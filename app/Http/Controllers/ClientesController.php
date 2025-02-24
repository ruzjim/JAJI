<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\New_;

class ClientesController extends Controller
{
    public function index()
    {
        $customers = User::select('name', 'cedula', 'telefono', 'email', 'profile_photo_path')
            ->where('role_id', 2)
            ->orderBy('name', 'asc')
            ->get();
        return view('customers', compact('customers'));
    }

    public function agregarCliente(request $request)
    {
        $request->validate([
            'name' => 'required',
            'cedula' => 'required',
            'telefono' => 'required',
            'email' => 'required',
        ]);

        $customer = new User();
        $customer->name = $request->name;
        $customer->cedula = $request->cedula;
        $customer->telefono = $request->telefono;
        $customer->email = $request->email;
        $customer->password = Hash::make(123456);
        $customer->role_id = 2;
        $customer->save();

        return redirect()->back()->with('message', 'Cliente agregado correctamente');
    }
 
}
