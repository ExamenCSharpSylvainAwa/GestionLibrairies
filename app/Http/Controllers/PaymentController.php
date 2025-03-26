<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Mail\OrderPaid;
use App\Models\Order;
use App\Models\Payment; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Accès non autorisé.');
        }

        $payments = Payment::with('order')->get();
        return view('payments.index', compact('payments'));
    }
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

    public function pay(Request $request, Order $order)
{
    if (!Auth::user()->isGestionnaire()) {
        return redirect()->route('orders.index')->with('error', 'Accès non autorisé.');
    }

    if ($order->payment) {
        return redirect()->route('orders.index')->with('error', 'Cette commande a déjà été payée.');
    }

    if ($order->status !== OrderStatus::SHIPPED) {
        return redirect()->route('orders.index')->with('error', 'Une commande ne peut être payée que si elle est "Expédiée".');
    }

    $request->validate([
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
    ]);

    try {
        $paymentDate = Carbon::parse($request->payment_date);
        $order->payment()->create([
            'amount' => $request->amount,
            'payment_date' => $paymentDate,
            'payment_method' => 'cash',
        ]);
    } catch (\Exception $e) {
        return redirect()->route('orders.index')->with('error', 'Échec de la création du paiement : ' . $e->getMessage());
    }

    $order->update(['status' => OrderStatus::PAID->value]);

    try {
        Mail::to($order->user->email)->send(new OrderPaid($order));
    } catch (\Exception $e) {
        return redirect()->route('orders.index')->with('warning', 'Paiement enregistré avec succès, mais échec de l\'envoi de l\'email : ' . $e->getMessage());
    }

    return redirect()->route('orders.index')->with('success', 'Paiement enregistré avec succès.');
}
}
