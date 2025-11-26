<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class GoogleController extends Controller
{
    // Redirigir a Google para autenticación
    public function redirectToGoogle()
    {
        try{
            // return Socialite::driver('google')
            //     ->scopes(['profile', 'email'])
            //     ->redirect();
            return Socialite::driver('google')->redirect();
        }catch(Exception $e){
            return redirect()->route('login')
                ->with('error', 'Error al conectar con Google. Intenta de nuevo.');
        }
    }

    /**
     * Manejar callback de Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Obtener usuario de Google
            $googleUser = Socialite::driver('google')->user();

            // Validar que tenemos email
            if (!$googleUser->getEmail()) {
                return redirect()->route('login')
                    ->with('error', 'No pudimos obtener tu email de Google. Intenta de nuevo.');
            }

            // Buscar usuario existente
            $user = User::where('email', $googleUser->getEmail())->first();

            // Si no existe, crear nuevo usuario
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getEmail(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(32)), // Password aleatorio (no lo va a usar)
                    'role' => 'customer', // Nuevos usuarios vía Google son compradores
                    'is_verified' => true, // Google verifica el email
                    'email_verified_at' => now(),
                ]);
            }

            // Si el usuario es vendedor sin verificar, no dejar que inicie sesión por Google
            if ($user->role === 'vendor' && !$user->is_verified) {
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta de vendedor está pendiente de verificación. Contacta a soporte.');
            }

            // Iniciar sesión
            Auth::login($user, remember: true);

            // Redirigir según el rol
            if ($user->role === 'vendor') {
                return redirect()->route('vendor.dashboard')
                    ->with('success', '¡Bienvenido ' . $user->name . '!');
            } else {
                return redirect()->route('products.index')
                    ->with('success', '¡Bienvenido ' . $user->name . '!');
            }

        } catch (Exception $e) {
            // Log del error (opcional)
            // Log::error('Google OAuth Error: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Error al autenticar con Google: ' . $e->getMessage());
        }
    }
}
