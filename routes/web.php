<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController; 
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\PaymentController; 
use App\Http\Controllers\StatsController;

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


 
    Route::resource('books', BookController::class)->except(['index', 'show'])->middleware('role:gestionnaire');
    Route::get('/books/archived', [BookController::class, 'archived'])->name('books.archived')->middleware('auth');
    Route::delete('/books/{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete')->middleware('auth');
    Route::post('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore')->middleware('auth');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders')->middleware('auth');


    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update_status')->middleware('auth');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
    Route::get('/orders/{order}/edit', [OrderController::class, 'editCommande'])->name('orders.edit')->middleware('auth');
    Route::put('/orders/{order}', [OrderController::class, 'updateCommande'])->name('orders.update')->middleware('auth');
    Route::delete('/orders/{order}', [OrderController::class, 'destroyCommande'])->name('orders.destroy')->middleware('auth');
    

    Route::get('stats', [StatsController::class, 'index'])->name('stats.index');

  
});

require __DIR__.'/auth.php';
