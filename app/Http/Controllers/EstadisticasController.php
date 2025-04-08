<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class EstadisticasController extends Controller
{

    public function __construct()
    {
        $this->actualizarProductosExpirados(); 
    }

    public function topUsuarios()
    {
        $topUsuarios = User::select('users.name')
            ->selectRaw('SUM(p.Puntos_Obtenidos) as total_puntos')
            ->join('puntos_users as pu', 'pu.Id_UsersFK', '=', 'users.id')
            ->join('puntos as p', 'pu.Id_PuntosFK', '=', 'p.Id_Puntos')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_puntos')
            ->limit(5)
            ->get();

        return response()->json($topUsuarios);
    }

    public function totalUsuarios()
    {
        $totalUsuarios = User::count();
        return response()->json(['total_usuarios' => $totalUsuarios]);
    }

    public function totalProductosExpirados()
{
    $totalExpirados = Producto::where('Expirado', 1)->count();
    return response()->json(['total_productos_expirados' => $totalExpirados]);
}


    public function totalProductosStockBajo()
    {
        $totalProductosStockBajo = DB::table('producto')
            ->where('Estado', 1)
            ->where('Stock', '<', 10)   
            ->whereNotNull('Stock')     
            ->count(); 

        return response()->json(['total_productos_stock_bajo' => $totalProductosStockBajo]);
    }

    public function ProductosStockBajo()
    {
        $productos = DB::table('producto')
            ->where('Estado', 1)
            ->where('Stock', '>', 0)
            ->where('Stock', '<', 10)
            ->whereNotNull('Stock')
            ->select('Id_Producto', 'Nombre_Producto', 'Marca', 'Stock')
            ->orderBy('Stock', 'asc')
            ->limit(8)
            ->get();

        return response()->json($productos);
    }

    public function productosStockBajo2()
    {
        $productos = DB::table('producto')
            ->where('Estado', 1)
            ->where('Stock', '<', 10)
            ->whereNotNull('Stock')
            ->select('Id_Producto', 'Nombre_Producto', 'Marca', 'Stock')
            ->get();

        return view('stockbajo', compact('productos'));
    }

    public function productosPorVencer()
    {
        // dd('productosPorVencer');
        try {
            $hoy = now()->format('Y-m-d');
            $semanaDespues = now()->addWeek()->format('Y-m-d');
    
            $productos = Producto::where('Estado', 1)
                ->whereBetween('Fecha_De_Caducidad', [$hoy, $semanaDespues])
                ->orderBy('Fecha_De_Caducidad')
                ->limit(5)
                ->get(['Nombre_Producto', 'Marca', 'Fecha_De_Caducidad']);
                
                dd($productos);
                return view('index')->with('productos', $productos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener productos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function totalProductosPorVencer()
    {
        $hoy = now()->format('Y-m-d');
        $semanaDespues = now()->addWeek()->format('Y-m-d');

        $totalProductosPorVencer = Producto::where('Estado', 1)
            ->whereBetween('Fecha_De_Caducidad', [$hoy, $semanaDespues])
            ->count();

        return response()->json(['total_productos_por_vencer' => $totalProductosPorVencer]);
    }

    public function productosPorVencer2()
    {
        try {
            $hoy = now()->format('Y-m-d');
            $semanaDespues = now()->addWeek()->format('Y-m-d');

            $productos = Producto::where('Estado', 1)
                ->whereBetween('Fecha_De_Caducidad', [$hoy, $semanaDespues])
                ->orderBy('Fecha_De_Caducidad')
                ->get(['Nombre_Producto', 'Marca', 'Fecha_De_Caducidad']);

            return view('productos_a_vencer', compact('productos'));
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener productos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizarProductosExpirados()
    {
        try {
            $hoy = now()->format('Y-m-d');

            Producto::where('Estado', 1) 
                ->where('Fecha_De_Caducidad', '<', $hoy)
                ->where('Expirado', 0)
                ->update(['Expirado' => 1]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar productos expirados',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
