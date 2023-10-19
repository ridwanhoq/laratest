<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'ajax'], function () {
    Route::get('get-product-info-by-id/{productId}', function ($productId) {
        $product = Product::select(['id', 'unit_price'])->find($productId);

        return response()->json(
            $product
        );
    });
});


Route::get('/orders/create', function () {
    $products = Product::orderByDesc('id')->get(['id', 'name']);

    return view(
        'orders.create',
        compact(
            'products'
        )
    );
});
