<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PuntoUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PuntosUsersController extends Controller
{
    public function puntosUsersList()
{
    $this->actualizarEstadosPuntos();

    $usuarios = User::select('users.id', 'users.name', 'users.cedula', 'users.email', 'users.telefono')
        ->selectRaw('(SELECT SUM(p.Puntos_Obtenidos) 
                      FROM puntos_users pu 
                      JOIN puntos p ON pu.Id_PuntosFK = p.Id_Puntos 
                      WHERE pu.Id_UsersFK = users.id 
                      AND pu.Estado = 1
                      AND YEAR(pu.Fecha_De_Caducidad) >= YEAR(CURDATE())) AS total_puntos')
        ->get();

    return view('puntos_users', compact('usuarios'));
}

private function actualizarEstadosPuntos()
{
    $hoy = Carbon::now(config('app.timezone')); // Asegurar zona horaria
    
    // Ejecutar si es 1 de Enero o durante pruebas
    if (($hoy->month === 1 && $hoy->day === 1) || app()->environment('local')) {
        $anioExpiracion = $hoy->year - 1;
        
        DB::statement("
            UPDATE puntos_users 
            SET Estado = 0, updated_at = NOW() 
            WHERE Estado = 1 
            AND YEAR(Fecha_De_Caducidad) = ?
        ", [$anioExpiracion]);
    }
}

public function buscarPorCedula(Request $request)
{
    $cedula = $request->input('cedula');

    $usuario = User::where('cedula', $cedula)
        ->select('users.id', 'users.name', 'users.cedula', 'users.email', 'users.telefono')
        ->selectRaw('(SELECT SUM(p.Puntos_Obtenidos) 
                      FROM puntos_users pu 
                      JOIN puntos p ON pu.Id_PuntosFK = p.Id_Puntos 
                      WHERE pu.Id_UsersFK = users.id AND pu.Estado = 1) AS total_puntos')
        ->first();

    return view('puntos_totales_users', compact('usuario'));
}

public function listarUsuariosConPuntos(Request $request)
    {
        // Opciones de filtrado
        $filtro = $request->input('filtro', 'todos'); // 'todos', 'activos', 'expirados'
        $busqueda = $request->input('busqueda', '');

        $query = User::with(['puntos' => function($query) {
            $query->select('puntos.*', 'puntos_users.Estado', 'puntos_users.Fecha_De_Caducidad');
        }])
        ->whereHas('puntos') // Solo usuarios que tienen puntos
        ->select('users.*')
        ->selectRaw('(SELECT SUM(puntos.Puntos_Obtenidos) 
                    FROM puntos_users 
                    JOIN puntos ON puntos_users.Id_PuntosFK = puntos.Id_Puntos 
                    WHERE puntos_users.Id_UsersFK = users.id AND puntos_users.Estado = 1) AS puntos_activos')
        ->selectRaw('(SELECT SUM(puntos.Puntos_Obtenidos) 
                    FROM puntos_users 
                    JOIN puntos ON puntos_users.Id_PuntosFK = puntos.Id_Puntos 
                    WHERE puntos_users.Id_UsersFK = users.id AND puntos_users.Estado = 0) AS puntos_expirados')
        ->selectRaw('(SELECT SUM(puntos.Puntos_Obtenidos) 
                    FROM puntos_users 
                    JOIN puntos ON puntos_users.Id_PuntosFK = puntos.Id_Puntos 
                    WHERE puntos_users.Id_UsersFK = users.id) AS puntos_totales');

        // Aplicar filtros
        if ($busqueda) {
            $query->where(function($q) use ($busqueda) {
                $q->where('name', 'like', "%$busqueda%")
                  ->orWhere('cedula', 'like', "%$busqueda%")
                  ->orWhere('email', 'like', "%$busqueda%");
            });
        }

        if ($filtro === 'activos') {
            $query->whereHas('puntos', function($q) {
                $q->where('puntos_users.Estado', 1);
            });
        } elseif ($filtro === 'expirados') {
            $query->whereHas('puntos', function($q) {
                $q->where('puntos_users.Estado', 0);
            });
        }

        $usuarios = $query->orderBy('puntos_totales', 'desc')
                         ->paginate(15);

        return view('lista_puntos_users', compact('usuarios', 'filtro', 'busqueda'));
    }

}
