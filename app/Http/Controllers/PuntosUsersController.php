<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PuntosUser;
use Illuminate\Support\Facades\DB;

class PuntosUsersController extends Controller
{
    public function puntosUsersList()
{
    $usuarios = User::select('users.id', 'users.name', 'users.cedula', 'users.email', 'users.telefono')
        ->selectRaw('(SELECT SUM(p.Puntos_Obtenidos) 
                      FROM puntos_users pu 
                      JOIN puntos p ON pu.Id_PuntosFK = p.Id_Puntos 
                      WHERE pu.Id_UsersFK = users.id) AS total_puntos')
        ->get();

    return view('puntos_users', compact('usuarios'));
}

public function buscarPorCedula(Request $request)
{
    $cedula = $request->input('cedula');

    $usuario = User::where('cedula', $cedula)
        ->select('users.id', 'users.name', 'users.cedula', 'users.email', 'users.telefono')
        ->selectRaw('(SELECT SUM(p.Puntos_Obtenidos) 
                      FROM puntos_users pu 
                      JOIN puntos p ON pu.Id_PuntosFK = p.Id_Puntos 
                      WHERE pu.Id_UsersFK = users.id) AS total_puntos')
        ->first();

    return view('puntos_totales_users', compact('usuario'));
}

}
