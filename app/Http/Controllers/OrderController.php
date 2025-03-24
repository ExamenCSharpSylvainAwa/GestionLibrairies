<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:gestionnaire')->only(['index', 'update', 'destroy']);
    }

    public function index()
    {
        $orders = auth()->user()->isGestionnaire()
            ? Order::with('user', 'books')->get()
            : auth()->user()->orders()->with('books')->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Les gestionnaires ne peuvent pas passer de commandes.');
        }
        $validated = $request->validate([
            'books' => 'required|array',
            'books.*.id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        $totalAmount = 0;
        $booksData = [];

        foreach ($validated['books'] as $bookData) {
            $book = Book::findOrFail($bookData['id']);
            if ($book->stock < $bookData['quantity']) {
                return back()->withErrors(['stock' => "Stock insuffisant pour {$book->title}"]);
            }
            $totalAmount += $book->price * $bookData['quantity'];
            $booksData[$book->id] = [
                'quantity' => $bookData['quantity'],
                'price' => $book->price,
            ];
            $book->decrement('stock', $bookData['quantity']);
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
        ]);

        $order->books()->attach($booksData);

        // Notification au client
        auth()->user()->notify(new OrderConfirmed($order));

        // Notification au gestionnaire
        $gestionnaires = \App\Models\User::where('role', 'gestionnaire')->get();
        Notification::send($gestionnaires, new NewOrderNotification($order));

        return redirect()->route('orders.index')->with('success', 'Commande passée avec succès.');
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:En attente,En préparation,Expédiée,Payée',
        ]);

        $order->update($validated);

        if ($order->status === 'Expédiée') {
            $pdf = Pdf::loadView('orders.invoice', compact('order'));
            $pdfPath = storage_path("app/public/invoices/order-{$order->id}.pdf");
            $pdf->save($pdfPath);

            Mail::to($order->user->email)->send(new \App\Mail\InvoiceMail($order, $pdfPath));
        }

        return redirect()->route('orders.index')->with('success', 'Statut de la commande mis à jour.');
    }

    public function destroy(Order $order)
    {
        foreach ($order->books as $book) {
            $book->increment('stock', $book->pivot->quantity);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Commande annulée avec succès.');
    }
}
