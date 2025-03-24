<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:gestionnaire');
    }

    public function store(Request $request, Order $order)
    {
        if ($order->payment) {
            return back()->withErrors(['payment' => 'Cette commande a déjà été payée.']);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
        ]);

        $order->update(['status' => 'Payée']);

        return redirect()->route('orders.index')->with('success', 'Paiement enregistré avec succès.');
    }
}
