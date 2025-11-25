<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VendorMiddleware

{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // // Verificar si el usuario está autenticado
        // if (!auth()->check()) {
        //     return redirect()->route('login')
        //         ->with('error', 'Debes iniciar sesión primero');
        // }

        // // Verificar si es vendedor y está verificado
        // if (auth()->user()->role !== 'vendor' || !auth()->user()->is_verified) {
        //     return redirect()->route('products.index')
        //         ->with('error', 'No tienes acceso al panel de vendedor');
        // }

        // return $next($request);

        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión primero');
        }

        // Verificar si es vendedor y está verificado
        $user = Auth::user();

        if ($user->role !== 'vendor' || !$user->is_verified) {
            return redirect()->route('products.index')
                ->with('error', 'No tienes acceso al panel de vendedor');
        }

        return $next($request);
    }
}
