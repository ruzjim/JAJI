<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Models\VentaProducto;
use Carbon\Carbon;

class ReportesController extends Controller
{
    public function productosMasVendidos()
{
    $productos = Producto::select([
            'producto.Id_Producto',
            'producto.Nombre_Producto',
            'producto.Marca',
            'producto.Stock',
            \DB::raw('COALESCE(SUM(venta_productos.Cantidad), 0) as total_vendido')
        ])
        ->leftJoin('venta_productos', 'producto.Id_Producto', '=', 'venta_productos.Id_ProductoFK')
        ->groupBy([
            'producto.Id_Producto',
            'producto.Nombre_Producto',
            'producto.Marca',
            'producto.Stock'
        ])
        ->having('total_vendido', '>', 0)
        ->orderByDesc('total_vendido')
        ->get();

    return view('productos_mas_vendidos', compact('productos'));
}

public function puntosUsersList()
{
    $usuarios = User::select('users.id', 'users.name', 'users.cedula', 'users.email', 'users.telefono')
        ->selectRaw('(SELECT COALESCE(SUM(p.Puntos_Obtenidos), 0) 
                      FROM puntos_users pu 
                      JOIN puntos p ON pu.Id_PuntosFK = p.Id_Puntos 
                      WHERE pu.Id_UsersFK = users.id) AS total_puntos')
        ->having('total_puntos', '>', 0)
        ->orderBy('total_puntos', 'desc')
        ->get();

    return view('producto_users_mas_puntos', compact('usuarios'));
}

public function reporteDiarioVentas()
{
    // Obtener fecha actual en formato Costa Rica
    $hoy = now()->startOfDay();
    $manana = now()->addDay()->startOfDay();

    // Calcular total de ventas del día
    $totalVentas = Venta::whereBetween('Created_At', [$hoy, $manana])
                        ->sum('Monto_Total');

    // Obtener productos vendidos hoy con cantidades
    $productosVendidos = VentaProducto::with(['producto' => function($query) {
                            $query->select('Id_Producto', 'barcode', 'Nombre_Producto', 'Marca', 'Precio_Venta');
                        }])
                        ->whereHas('venta', function($query) use ($hoy, $manana) {
                            $query->whereBetween('Created_At', [$hoy, $manana]);
                        })
                        ->selectRaw('Id_ProductoFK, 
                                   SUM(Cantidad) as cantidad_vendida, 
                                   SUM(Cantidad * producto.Precio_Venta) as total_producto')
                        ->join('producto', 'venta_productos.Id_ProductoFK', '=', 'producto.Id_Producto')
                        ->groupBy('Id_ProductoFK')
                        ->get()
                        ->map(function($item) {
                            return (object)[
                                'barcode' => $item->producto->barcode ?? null,
                                'Nombre_Producto' => $item->producto->Nombre_Producto ?? null,
                                'Marca' => $item->producto->Marca ?? null,
                                'cantidad_vendida' => $item->cantidad_vendida ?? 0,
                                'total_producto' => $item->total_producto ?? 0
                            ];
                        });

    $productosVendidos = $productosVendidos->isEmpty() ? collect() : $productosVendidos;

    return view('reporte_diario_ventas', compact('totalVentas', 'productosVendidos'));
}

public function reportePorFechas(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio'
    ]);

    $fechaInicio = $request->filled('fecha_inicio') 
        ? Carbon::parse($request->fecha_inicio)->startOfDay()
        : now()->subDays(7)->startOfDay();

    $fechaFin = $request->filled('fecha_fin')
        ? Carbon::parse($request->fecha_fin)->endOfDay()
        : now()->endOfDay();

    $ventas = Venta::with([
            'usuario:id,name',
            'pago:Id_Pago,metodo_pago',
            'productos.producto:Id_Producto,Nombre_Producto'
        ])
        ->whereBetween('Created_At', [$fechaInicio, $fechaFin])
        ->orderBy('Created_At', 'desc')
        ->get();

    $totalVentas = $ventas->sum('Monto_Total');

    return view('reporte_venta_fechas', compact(
        'totalVentas',
        'ventas',
        'fechaInicio',
        'fechaFin'
    ));
}

}