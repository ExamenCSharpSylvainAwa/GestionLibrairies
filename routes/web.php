<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController; 
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\PaymentController; 
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les livres
    Route::resource('books', BookController::class)->except(['index', 'show'])->middleware('role:gestionnaire');
    Route::get('/books/archived', [BookController::class, 'archived'])->name('books.archived');
    Route::delete('/books/{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete');
    Route::post('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show')->where('book', '[0-9]+');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Routes pour les commandes
    // Routes statiques d'abord
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('role:gestionnaire'); // Ajout du middleware
    Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update_status')->where('order', '[0-9]+');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->where('order', '[0-9]+');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store')->where('order', '[0-9]+');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay')->middleware('role:gestionnaire')->where('order', '[0-9]+');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice')->where('order', '[0-9]+');
    Route::get('orders/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('orders.download_invoice');

    // Routes personnalisées pour l'édition et la suppression
    Route::get('/orders/{order}/edit', [OrderController::class, 'editCommande'])->name('orders.edit')->where('order', '[0-9]+');
    Route::put('/orders/{order}', [OrderController::class, 'updateCommande'])->name('orders.update')->where('order', '[0-9]+');
    Route::delete('/orders/{order}', [OrderController::class, 'destroyCommande'])->name('orders.destroy')->where('order', '[0-9]+');

    // Route dynamique pour afficher une commande (doit être après les routes statiques)
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->where('order', '[0-9]+');

    // Routes pour les paiements et statistiques
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index')->middleware('role:gestionnaire');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index')->middleware('role:gestionnaire');
    Route::get('/statistics', [App\Http\Controllers\OrderController::class, 'statistics'])->name('statistics.index')->middleware('role:gestionnaire');


    // routes/web.php
    Route::post('/webhook', [WebhookController::class, 'handle']);
});

require __DIR__.'/auth.php';
