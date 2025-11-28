<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;

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
                echo "aqui llega";
                return redirect()->route('login')
                    ->with('error', 'No pudimos obtener tu email de Google. Intenta de nuevo.');
            }

            // Buscar usuario existente por email
            $user = User::where('email', $googleUser->getEmail())->first();

            // Para debug, guardar info del usuario en el log
            Log::info('Google OAuth user:', [
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            // Si no existe, crear nuevo usuario
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(32)),
                    'role' => 'customer',
                    'is_verified' => true,
                    'email_verified_at' => now(),
                ]);
            }

            // Si el usuario es vendedor sin verificar, bloquear acceso
            if ($user->role === 'vendor' && !$user->is_verified) {
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta de vendedor está pendiente de verificación. Contacta a soporte.');
            }

            // Iniciar sesión
            Auth::login($user, true);

            // Redirigir según el rol
            if ($user->role === 'vendor') {
                return redirect()->route('vendor.dashboard')
                    ->with('success', '¡Bienvenido ' . $user->name . '!');
            }

            return redirect()->route('products.index')
                ->with('success', '¡Bienvenido ' . $user->name . '!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::error('Google OAuth InvalidStateException: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Error de sesión con Google. Intenta de nuevo.');

        } catch (Exception $e) {
            // Guardar el error completo en el log
            Log::error('Google OAuth Error: ' . $e->getMessage());
            echo $e->getMessage();
            return redirect()->route('login')
                ->with('error', 'Error al autenticar con Google. Intenta de nuevo.');
        }
    }

}
