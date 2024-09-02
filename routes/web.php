<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', function(){
    return view('auth.login');
})->name('login');

Route::get('/register', function(){
    return view('auth.register');
})->name('register');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::resource('carts', CartController::class);
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    Route::group(['middleware' => 'isAdmin'], function(){
        Route::get('/invoice', [InvoiceController::class, 'displayAllInvoice'])->name('invoice.display');
        Route::resource('items', ItemController::class);
    });
});