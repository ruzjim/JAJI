<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaProducto;
use App\Models\Pago;
use App\Models\ProductoPunto;
use App\Models\PuntoUser;
use App\Models\User;
use App\Models\VentaPuntos;
use App\Models\Punto;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'productos' => 'required|array',
                'productos.*.id' => 'required|integer|exists:producto,Id_Producto',
                'productos.*.cantidad' => 'required|integer|min:1',
                'metodo_pago_id' => 'required|integer|in:1,2,3',
                'total' => 'required|numeric|min:0',
                'cedula' => 'nullable|string'
            ]);

            return DB::transaction(function () use ($request) {
                // Verificar stock antes de iniciar la transacción
                $productosSinStock = [];
                foreach ($request->productos as $item) {
                    $producto = Producto::findOrFail($item['id']);
                    if ($producto->Stock <= 0) {
                        $productosSinStock[] = $producto->Nombre_Producto;
                    } elseif ($producto->Stock < $item['cantidad']) {
                        throw new \Exception("Stock insuficiente para: {$producto->Nombre_Producto}");
                    }
                }

                if (!empty($productosSinStock)) {
                    throw new \Exception("Los siguientes productos están agotados: " . implode(', ', $productosSinStock));
                }

                // Resto del código de procesamiento de venta...
                $pago = Pago::findOrFail($request->metodo_pago_id);

                $venta = Venta::create([
                    'Monto_Total' => $request->total,
                    'Id_PagoFK' => $pago->Id_Pago,
                    'idusuario' => Auth::user()->id,
                ]);

                foreach ($request->productos as $item) {
                    $producto = Producto::lockForUpdate()->find($item['id']);

                    VentaProducto::create([
                        'Id_ProductoFK' => $producto->Id_Producto,
                        'Id_VentaFK' => $venta->Id_Venta,
                        'Cantidad' => $item['cantidad']
                    ]);

                    $producto->decrement('Stock', $item['cantidad']);
                }

                // Obtener productos únicos para puntos
                $productosUnicos = collect($request->productos)->unique('id')->pluck('id');

                // Obtener puntos de los productos únicos (activos en ProductoPunto y Punto)
                $puntosAsignar = [];
                foreach ($request->productos as $item) {
                    $productoId = $item['id'];
                    $cantidad = $item['cantidad'];

                    $productoPunto = ProductoPunto::with('punto')
                        ->where('Id_ProductoFK', $productoId)
                        ->where('Estado', 1)
                        ->first();

                    if ($productoPunto && $productoPunto->punto && $productoPunto->punto->Estado == 1) {
                        // Agregar un registro por cada unidad del producto
                        for ($i = 0; $i < $cantidad; $i++) {
                            $puntosAsignar[] = $productoPunto->punto;
                        }
                    }
                }

                // Buscar usuario con cédula sanitizada
                $user = null;
                if ($request->cedula) {
                    $cedula = preg_replace('/[^0-9]/', '', $request->cedula);
                    $user = User::where('cedula', $cedula)->first();
                }

                // Asignar puntos al usuario y vincular a la venta
                if ($user && !empty($puntosAsignar)) {
                    foreach ($puntosAsignar as $punto) {
                        // Crear entrada en puntos_users por cada punto

                        $fechaExpiracion = now()->endOfYear();

                        PuntoUser::create([
                            'Id_UsersFK' => $user->id,
                            'Id_PuntosFK' => $punto->Id_Puntos,
                            'created_at' => now(), // Fuerza la fecha actual
                            'updated_at' => now(),
                            'Fecha_De_Caducidad' => $fechaExpiracion->format('Y-m-d'), // Formato DATE de MySQL
                            'Estado' => 1
                        ]);

                        // Crear entrada en venta_puntos (sin firstOrCreate)
                        VentaPuntos::create([
                            'Id_PuntosFK' => $punto->Id_Puntos,
                            'Id_VentaFK' => $venta->Id_Venta,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    \Log::info("Puntos asignados: " . count($puntosAsignar));
                } else {
                    \Log::info("No se asignaron puntos. Usuario: " . ($user ? "Existe" : "No existe"));
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Venta completada con éxito'
                ]);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error en venta: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
    }








    public function cierrecaja()
    {
        $ventasSinCierre = DB::select('CALL ObtenerVentasSinCierre()');
        $metodosPagoSuma = [];

        foreach ($ventasSinCierre as $venta) {
            $metodoPago = $venta->Metodo_Pago;
            if (!isset($metodosPagoSuma[$metodoPago])) {
                $metodosPagoSuma[$metodoPago] = 0;
            }
            $metodosPagoSuma[$metodoPago] += $venta->Monto_Total;
        }
        return view('cierrecaja', compact('ventasSinCierre', 'metodosPagoSuma'));
    }

    public function CerrarCaja(Request $request)
    {
    
        $usuario = Auth::user()->id;
        $total = $request['total'];
        $diferencia = $request['diferencia'];
        $descripcion = $request['comentarios'] ?? null;
        $idVentas = $request['idVentas'];  

        // Llamar al procedimiento almacenado
        DB::statement('CALL InsertarCierreDeCaja(?, ?, ?, ?, ?)', [
            $usuario, 
            $total, 
            $diferencia, 
            $descripcion, 
            $idVentas
        ]);

        // Redirigir o devolver una respuesta
        return response()->json(['message' => 'Cierre de caja registrado y ventas actualizadas con éxito.']);
    
    }
}
