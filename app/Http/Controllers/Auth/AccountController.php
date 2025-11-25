<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //Mostrar Login
    public function login(){
        return view('auth.login');
    }

    // Autenticar inicio de sesión
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Validación
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Intentar login
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();

            // ⭐ Si es vendedor y está verificado → panel vendor
            if ($user->role === 'vendor' && $user->is_verified) {
                return redirect()->route('vendor.dashboard');
            }

            // ⭐ Si NO es vendedor → catálogo
            return redirect()->route('products.index');
        }

        // Credenciales incorrectas
        return redirect()->route('login')
            ->with('error', 'El Correo o Contraseña es incorrecta')
            ->withInput();
    }

    // Cerrar sesión
    public function logout(){
        Auth::logout();
        return redirect()->route('products.index');
    }

}
