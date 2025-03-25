<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionnaireController extends Controller
{
    /**
     * Crée une nouvelle instance du contrôleur.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Nécessite une connexion
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isGestionnaire()) {
                return redirect()->route('orders.index')->with('error', 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    /**
     * Affiche le tableau de bord des gestionnaires.
     */
    public function dashboard()
    {
        $orders = Order::with('books', 'user')->get(); // Récupère toutes les commandes
        $books = Book::all(); // Récupère tous les livres
        return view('gestionnaire.dashboard', compact('orders', 'books'));
    }
}