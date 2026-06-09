<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Get all active payment methods (API endpoint)
     */
    public function getActive()
    {
        $methods = PaymentMethod::where('is_active', true)->get();
        return response()->json($methods);
    }

    /**
     * Get payment methods by type
     */
    public function getByType($type)
    {
        $methods = PaymentMethod::where('type', $type)
                                ->where('is_active', true)
                                ->get();
        return response()->json($methods);
    }

    /**
     * Store new payment method
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:bank,ewallet',
            'name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
        ]);

        $method = PaymentMethod::create([
            ...$validated,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Payment method berhasil ditambahkan!',
            'data' => $method
        ], 201);
    }

    /**
     * Update payment method
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'type' => 'required|in:bank,ewallet',
            'name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        $paymentMethod->update($validated);

        return response()->json([
            'message' => 'Payment method berhasil diupdate!',
            'data' => $paymentMethod
        ]);
    }

    /**
     * Delete payment method
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return response()->json([
            'message' => 'Payment method berhasil dihapus!'
        ]);
    }
}
