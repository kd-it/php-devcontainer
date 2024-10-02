<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::match(['get', 'post'], 'item/{genre?}', [ItemController::class, 'index'])->name('item.index');
Route::get('item/show/{item}', [ItemController::class, 'show'])->name('item.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::put('cart/{cart}',[CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{cart}',[CartController::class, 'destroy'])->name('cart.destroy');

Route::get('order', [OrderController::class, 'index'])->name('order.index');

