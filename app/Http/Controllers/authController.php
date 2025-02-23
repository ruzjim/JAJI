<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function signin()
    {
        return view('signin');
    }

    public function registerr()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validar datos
        $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted',
        ], [], [
            'name' => 'nombre',
            'cedula' => 'cedula',
            'telefono' => 'telefono',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'terms' => 'términos y condiciones',
        ]);


        User::create([
            'name' => $request->name,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('signin')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ], [], [
            'email' => 'correo electrónico',
            'password' => 'contraseña',
        ]);

        // Intentar iniciar sesión con las credenciales proporcionadas
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Regenerar la sesión para evitar ataques de fijación de sesión
            $request->session()->regenerate();

            // Redirigir al usuario a la página de inicio o a donde se desee
            return redirect()->intended('index')->with('success', 'Inicio de sesión exitoso.');
        }

        // Si las credenciales son incorrectas
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al usuario al formulario de inicio de sesión
        return redirect()->route('signin')->with('success', 'Has cerrado sesión exitosamente.');
    }
}
