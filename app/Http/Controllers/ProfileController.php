<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil del usuario
     */
    public function show()
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();

        return view('profile.show', compact('user', 'orders'));
    }

    /**
     * Actualizar información personal del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validar datos
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20'
            ]
        ]);

        try {
            // Actualizar usuario
            $user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? $user->phone
            ]);

            return redirect()->route('profile.show')
                ->with('success', '✓ Tu información ha sido actualizada exitosamente');


        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al actualizar información: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Actualizar dirección de envío del usuario
     */
    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        // Validar datos de dirección
        $validated = $request->validate([
            'address' => [
                'required',
                'string',
                'max:255',
                'min:5'
            ],
            'city' => [
                'required',
                'string',
                'max:100',
                'min:2'
            ],
            'state' => [
                'required',
                'string',
                'max:100',
                'min:2'
            ],
            'country' => [
                'required',
                'string',
                'max:100',
                'min:2'
            ],
            'postal_code' => [
                'required',
                'string',
                'max:20',
                'min:4'
            ]
        ]);

        try {
            // Actualizar dirección
            $user->update([
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code']
            ]);

            return redirect()->route('profile.show')
                ->with('success', '✓ Tu dirección de envío ha sido guardada');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al guardar dirección: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Ver detalles de una orden específica
     */
    public function viewOrder($orderId)
    {
        $user = Auth::user();
        $order = $user->orders()->findOrFail($orderId);

        return view('profile.partials.order-detail', compact('order'));
    }
}
