<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:gestionnaire')->only(['index', 'update', 'destroy']);
    }

    public function index()
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
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
        $order->status = 'En attente';

        // Notification au client
        auth()->user()->notify(new \App\Notifications\OrderConfirmed($order));

        // Notification au gestionnaire
        $gestionnaires = \App\Models\User::where('role', 'gestionnaire')->get();
        \Illuminate\Support\Facades\Notification::send($gestionnaires, new \App\Notifications\NewOrderNotification($order));

        return redirect()->route('orders.my_orders')->with('success', 'Commande passée avec succès.');
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:En attente,En préparation,Expédiée,Payée',
        ]);

        $order->update($validated);

        if ($order->status === 'Expédiée') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.invoice', compact('order'));
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

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())->with('books')->get();
        return view('orders.my_orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $book = $order->book;
        $book->stock += $order->quantity;
        $book->save();

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Commande annulée avec succès.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
    
        $request->validate([
            'status' => 'required|in:En attente,En préparation,Expédiée,Payée',
        ]);
    
        $order->status = $request->status;
    
        if ($request->status === 'Payée') {
            $order->payment_date = now();
            $order->payment_amount = $order->total_price;
        }
    
        if ($request->status === 'Expédiée') {
            // Envoyer un e-mail avec la facture PDF
            Mail::to($order->user->email)->send(new OrderShipped($order));
        }
    
        $order->save();
    
        return redirect()->route('orders.show', $order)->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function editCommande(Order $order)
    {
        // Vérifie si l'utilisateur est autorisé à modifier la commande
        if (Auth::user()->isGestionnaire() || Auth::user()->id === $order->user_id) {
            $books = Book::all();
            return view('orders.edit', compact('order', 'books'));
        }

        // Si l'utilisateur n'est pas autorisé, rediriger avec un message d'erreur
        return redirect()->route('orders.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cette commande.');
    }
    public function updateCommande(Request $request, Order $order)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (!Auth::user()->isGestionnaire()) {
            return redirect()->route('orders.index')->with('error', 'Accès non autorisé.');
        }
    
        // Validation des données
        $request->validate([
            'status' => 'required|in:En attente,En préparation,Expédiée,Livrée,Annulée',
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);
    
        // Mapper les statuts en français vers les statuts en anglais (pour la base de données)
        $statusMap = [
            'En attente' => 'pending',
            'En préparation' => 'processing',
            'Expédiée' => 'shipped',
            'Livrée' => 'delivered',
            'Annulée' => 'cancelled',
        ];
    
        // Vérifier que le statut est valide après mappage
        $mappedStatus = $statusMap[$request->status] ?? null;
        if (!$mappedStatus) {
            return redirect()->back()->with('error', 'Statut invalide.');
        }
    
        // Calculer le nouveau montant total
        $totalAmount = 0;
        $books = Book::findMany($request->book_ids);
        foreach ($books as $index => $book) {
            $quantity = $request->quantities[$index];
            $price = $book->price;
    
            // Vérifier que le prix est valide
            if ($price <= 0) {
                return redirect()->back()->with('error', "Le prix du livre {$book->title} doit être supérieur à 0.");
            }
    
            // Vérifier le stock
            if ($book->stock < $quantity) {
                return redirect()->back()->with('error', "Stock insuffisant pour le livre : {$book->title}");
            }
    
            $totalAmount += $price * $quantity;
        }
    
        // Mettre à jour la commande
        $order->update([
            'status' => $mappedStatus,
            'total_amount' => $totalAmount,
        ]);
    
        // Mettre à jour les livres associés (pivot table)
        $syncData = [];
        foreach ($request->book_ids as $index => $bookId) {
            $syncData[$bookId] = [
                'quantity' => $request->quantities[$index],
                'price' => $books[$index]->price,
            ];
        }
        $order->books()->sync($syncData);
    
        // Ajuster le stock des livres
        foreach ($order->books as $book) {
            $book->decrement('stock', $book->pivot->quantity);
        }
    
        return redirect()->route('orders.index')->with('success', 'Commande mise à jour avec succès.');
    }
    public function destroyCommande(Order $order)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (!Auth::user()->isGestionnaire()) {
            return redirect()->route('orders.index')->with('error', 'Accès non autorisé.');
        }

        // Restaurer le stock des livres associés
        foreach ($order->books as $book) {
            $book->increment('stock', $book->pivot->quantity);
        }

        // Supprimer la commande
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Commande supprimée avec succès.');
    }
}