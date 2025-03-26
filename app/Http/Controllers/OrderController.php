<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use App\Mail\OrderShipped;
use App\Enums\OrderStatus;
use Carbon\Carbon;
use App\Models\Payment;
use App\Mail\OrderPaid;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function downloadInvoice(Order $order)
    {
        // Charger les données nécessaires pour la facture
        $order->load('books', 'user');
    
        // Générer le PDF
        $pdf = Pdf::loadView('invoices.order', compact('order'));
    
        // Télécharger le PDF
        return $pdf->download('facture-commande-' . $order->id . '.pdf');
    }
    public function store(Request $request)
    {
        // Vérifier si la requête vient de books/show.blade.php (book_id et quantity)
        if ($request->has('book_id') && $request->has('quantity')) {
            // Convertir book_id et quantity en un tableau books compatible
            $request->merge([
                'books' => [
                    [
                        'id' => $request->input('book_id'),
                        'quantity' => $request->input('quantity'),
                    ],
                ],
            ]);
        }
    
        // Valider les données de la requête
        $validated = $request->validate([
            'books' => 'required|array|min:1', // Le tableau books doit contenir au moins 1 élément
            'books.*.id' => 'required|exists:books,id', // Chaque livre doit exister dans la table books
            'books.*.quantity' => 'required|integer|min:1', // La quantité doit être un entier >= 1
        ]);
    
        // Créer une nouvelle commande
        $order = new Order();
        $order->user_id = auth()->id();
        $order->status = \App\Enums\OrderStatus::PENDING;
        $order->total_amount = 0; // Sera calculé après
        $order->save();
    
        // Ajouter les livres à la commande
        $totalAmount = 0;
        foreach ($validated['books'] as $bookData) {
            $book = Book::findOrFail($bookData['id']);
            
            // Vérifier le stock
            if ($book->stock < $bookData['quantity']) {
                return redirect()->back()->with('error', "Stock insuffisant pour le livre : {$book->title}");
            }
    
            // Calculer le prix total pour ce livre
            $price = $book->price * $bookData['quantity'];
            $totalAmount += $price;
    
            // Associer le livre à la commande
            $order->books()->attach($book->id, [
                'quantity' => $bookData['quantity'],
                'price' => $book->price,
            ]);
    
            // Mettre à jour le stock
            $book->decrement('stock', $bookData['quantity']);
        }
    
        // Mettre à jour le montant total de la commande
        $order->update(['total_amount' => $totalAmount]);
    
        return redirect()->route('orders.my_orders')->with('success', 'Commande passée avec succès.');
    }
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_map(function ($case) {
                return \App\Enums\OrderStatus::from($case->value)->label();
            }, \App\Enums\OrderStatus::cases())),
        ]);
    
        $order->status = \App\Enums\OrderStatus::from(array_search($validated['status'], array_map(function ($case) {
            return \App\Enums\OrderStatus::from($case->value)->label();
        }, \App\Enums\OrderStatus::cases())));
    
        $order->save();
    
        if ($order->status === \App\Enums\OrderStatus::SHIPPED) {
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
        try {
            // Récupérer l'ID de l'utilisateur connecté
            $userId = auth()->id();
    
            // Vérifier que l'ID est numérique (par sécurité)
            if (!is_numeric($userId)) {
                \Log::error('auth()->id() a retourné une valeur non numérique : ' . $userId);
                return redirect()->route('books.index')->with('error', 'Erreur lors de la récupération de vos commandes.');
            }
    
            // Récupérer les commandes de l'utilisateur avec la relation 'books'
            $orders = Order::where('user_id', $userId)
                ->with('books')
                ->get();
    
            // Rendre la vue correcte : orders.my_orders
            return view('orders.my_orders', compact('orders'));
        } catch (\Exception $e) {
            // En cas d'erreur (par exemple, problème de base de données)
            \Log::error('Erreur lors de la récupération des commandes : ' . $e->getMessage());
            return redirect()->route('books.index')->with('error', 'Une erreur est survenue lors de la récupération de vos commandes.');
        }
    }

    public function show(Order $order)
{
    // Charger les relations nécessaires
    $order->load('books', 'user');

    return view('orders.show', compact('order'));
}

    public function cancel(Order $order)
    {
        // Vérifier que l'utilisateur est le propriétaire de la commande
        if (auth()->id() !== $order->user_id) {
            return redirect()->route('orders.my_orders')->with('error', 'Vous n\'avez pas le droit d\'annuler cette commande.');
        }
    
        // Vérifier que le statut de la commande est 'pending'
        if ($order->status !== \App\Enums\OrderStatus::PENDING) {
            return redirect()->route('orders.my_orders')->with('error', 'Seules les commandes en attente peuvent être annulées.');
        }
    
        // Restaurer le stock des livres
        foreach ($order->books as $book) {
            $book->increment('stock', $book->pivot->quantity);
        }
    
        // Supprimer la commande
        $order->delete();
    
        return redirect()->route('orders.my_orders')->with('success', 'Commande annulée avec succès.');
    }
    public function updateStatus(Request $request, Order $order)
    {
        if (!auth()->user()->isGestionnaire()) {
            return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
    
        $request->validate([
            'status' => 'required|in:' . implode(',', array_column(\App\Enums\OrderStatus::cases(), 'value')),
        ]);
    
        $order->status = \App\Enums\OrderStatus::from($request->status);
    
        if ($order->status === \App\Enums\OrderStatus::PAID) {
            $order->payment_date = now();
            $order->payment_amount = $order->total_amount;
        }
    
        if ($order->status === \App\Enums\OrderStatus::SHIPPED) {
            Mail::to($order->user->email)->send(new \App\Mail\OrderShipped($order));
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
        if (!Auth::user()->isGestionnaire()) {
            return redirect()->route('orders.index')->with('error', 'Accès non autorisé.');
        }
    
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(OrderStatus::cases(), 'value'))],
            'books' => 'nullable|array',
            'books.*.id' => 'exists:books,id',
            'books.*.quantity' => 'integer|min:1',
        ]);
    
        $newStatus = OrderStatus::from($request->status);
        $currentStatus = $order->status; // Maintenant une instance de OrderStatus grâce au cast
    
        // Vérifications des transitions de statut
        if ($newStatus->value === OrderStatus::CANCELLED->value) {
            // Une commande peut être annulée à tout moment
        } elseif ($newStatus->value === OrderStatus::VALIDATED->value && $currentStatus->value !== OrderStatus::PENDING->value) {
            return redirect()->back()->with('error', 'Une commande ne peut passer à "Validée" que si elle est "En attente". [Statut actuel : ' . $currentStatus->label() . ']');
        } elseif ($newStatus->value === OrderStatus::PROCESSING->value && !in_array($currentStatus->value, [OrderStatus::PENDING->value, OrderStatus::VALIDATED->value])) {
            return redirect()->back()->with('error', 'Une commande ne peut passer à "En préparation" que si elle est "En attente" ou "Validée". [Statut actuel : ' . $currentStatus->label() . ']');
        } elseif ($newStatus->value === OrderStatus::SHIPPED->value && $currentStatus->value !== OrderStatus::PROCESSING->value) {
            return redirect()->back()->with('error', 'Une commande ne peut passer à "Expédiée" que si elle est "En préparation". [Statut actuel : ' . $currentStatus->label() . ']');
        }
    
        // Si books est fourni, mettre à jour les livres et quantités
        if ($request->filled('books')) {
            // Vérifier que chaque livre a un ID et une quantité
            foreach ($request->books as $bookData) {
                if (!isset($bookData['id']) || !isset($bookData['quantity'])) {
                    return redirect()->back()->with('error', 'Les données des livres sont incomplètes.');
                }
            }
    
            // Calculer le montant total et valider le stock
            $totalAmount = 0;
            $books = Book::findMany(array_column($request->books, 'id'));
    
            foreach ($books as $index => $book) {
                $quantity = $request->books[$index]['quantity'];
                $price = $book->price;
    
                if ($price <= 0) {
                    return redirect()->back()->with('error', "Le prix du livre {$book->title} doit être supérieur à 0.");
                }
    
                if ($book->stock < $quantity) {
                    return redirect()->back()->with('error', "Stock insuffisant pour le livre : {$book->title}");
                }
    
                $totalAmount += $price * $quantity;
            }
    
            // Restaurer le stock des livres précédemment associés
            foreach ($order->books as $book) {
                $book->increment('stock', $book->pivot->quantity);
            }
    
            // Synchroniser les livres et quantités
            $syncData = [];
            foreach ($request->books as $bookData) {
                $book = Book::find($bookData['id']);
                $syncData[$book->id] = [
                    'quantity' => $bookData['quantity'],
                    'price' => $book->price,
                ];
            }
            $order->books()->sync($syncData);
    
            // Décrémenter le stock des livres après la mise à jour
            foreach ($order->books as $book) {
                $book->decrement('stock', $book->pivot->quantity);
            }
        } else {
            // Si books n'est pas fourni, conserver le montant total existant
            $totalAmount = $order->total_amount;
        }
    
        // Vérifier si la commande passe au statut "Expédiée"
        $wasShipped = $newStatus->value === OrderStatus::SHIPPED->value && $currentStatus->value !== OrderStatus::SHIPPED->value;
    
        // Mettre à jour la commande
        $order->update([
            'status' => $newStatus->value,
            'total_amount' => $totalAmount,
        ]);
    
        // Envoyer un email si la commande passe au statut "Expédiée"
        if ($wasShipped) {
            try {
                Mail::to($order->user->email)->send(new OrderShipped($order));
            } catch (\Exception $e) {
                return redirect()->route('orders.index')->with('warning', 'Commande mise à jour avec succès, mais échec de l\'envoi de l\'email : ' . $e->getMessage());
            }
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

    public function create(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour passer une commande.');
        }

        $bookId = $request->query('book_id');
        $book = $bookId ? Book::findOrFail($bookId) : null;

        $books = Book::where('stock', '>', 0)->get();
        return view('orders.create', compact('books', 'book'));
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
        // Débogage : Vérifier l'ID de la commande
        if (!$order->id) {
            throw new \Exception('L\'ID de la commande est vide.');
        }

        $paymentDate = Carbon::parse($request->payment_date);

        // Débogage : Afficher les valeurs avant la création
        \Log::info('Création du paiement pour la commande ' . $order->id, [
            'amount' => $request->amount,
            'payment_date' => $paymentDate,
            'payment_method' => 'cash',
        ]);

        // Créer une instance explicite de Payment
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->amount = $request->amount;
        $payment->payment_date = $paymentDate;
        $payment->payment_method = 'cash';
        $payment->save();
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

public function statistics()
{
    \Log::info('Méthode statistics appelée');

    if (!auth()->user()->isGestionnaire()) {
        \Log::info('Utilisateur non autorisé, redirection vers books.index');
        return redirect()->route('books.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
    }

    // Date du jour
    $today = \Carbon\Carbon::today();

    // 1. Commandes en cours de la journée (PENDING, VALIDATED, PROCESSING)
    $ongoingOrders = Order::whereIn('status', [
        \App\Enums\OrderStatus::PENDING,
        \App\Enums\OrderStatus::VALIDATED,
        \App\Enums\OrderStatus::PROCESSING,
    ])
        ->whereDate('created_at', $today)
        ->with('user', 'books')
        ->count();
    \Log::info('ongoingOrders: ' . $ongoingOrders);

    // 2. Commandes validées de la journée
    $validatedOrders = Order::where('status', \App\Enums\OrderStatus::VALIDATED)
        ->whereDate('created_at', $today)
        ->with('user', 'books')
        ->count();
    \Log::info('validatedOrders: ' . $validatedOrders);

    // 3. Recettes journalières (total des paiements reçus)
    $dailyRevenue = Payment::whereDate('payment_date', $today)
        ->sum('amount');
    \Log::info('dailyRevenue: ' . $dailyRevenue);

    // 4. Nombre de commandes par mois (pour Chart.js)
    $ordersPerMonth = [];
    for ($month = 1; $month <= 12; $month++) {
        $ordersPerMonth[$month] = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', $month)
            ->count();
    }
    \Log::info('ordersPerMonth: ' . json_encode($ordersPerMonth));

    // 5. Nombre de livres vendus par catégorie par mois (pour Chart.js)
    try {
        $booksSoldByCategoryPerMonth = \App\Models\Book::selectRaw('categories.name as category, MONTH(orders.created_at) as month, YEAR(orders.created_at) as year, SUM(order_book.quantity) as total_sold')
            ->join('order_book', 'books.id', '=', 'order_book.book_id')
            ->join('orders', 'order_book.order_id', '=', 'orders.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->whereYear('orders.created_at', now()->year)
            ->groupBy('categories.name', 'year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->groupBy('category')
            ->map(function ($categoryGroup, $categoryName) {
                $data = [];
                for ($month = 1; $month <= 12; $month++) {
                    $monthData = $categoryGroup->firstWhere('month', $month);
                    $data[$month] = $monthData ? $monthData->total_sold : 0;
                }
                return [
                    'category' => $categoryName,
                    'data' => $data,
                ];
            });
        \Log::info('booksSoldByCategoryPerMonth: ' . json_encode($booksSoldByCategoryPerMonth));
    } catch (\Exception $e) {
        \Log::error('Erreur lors du calcul de booksSoldByCategoryPerMonth: ' . $e->getMessage());
        $booksSoldByCategoryPerMonth = collect();
    }

    // 6. Nombre total de livres vendus par catégorie (pour le graphique en camembert)
    try {
        $booksSoldByCategory = \App\Models\Book::selectRaw('categories.name as category, SUM(order_book.quantity) as total_sold')
            ->join('order_book', 'books.id', '=', 'order_book.book_id')
            ->join('orders', 'order_book.order_id', '=', 'orders.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->whereYear('orders.created_at', now()->year)
            ->groupBy('categories.name')
            ->pluck('total_sold', 'category')
            ->toArray();
        \Log::info('booksSoldByCategory: ' . json_encode($booksSoldByCategory));
    } catch (\Exception $e) {
        \Log::error('Erreur lors du calcul de booksSoldByCategory: ' . $e->getMessage());
        $booksSoldByCategory = [];
    }

    return view('statistics.index', compact(
        'ongoingOrders',
        'validatedOrders',
        'dailyRevenue',
        'ordersPerMonth',
        'booksSoldByCategory',
        'booksSoldByCategoryPerMonth'
    ));
}


}