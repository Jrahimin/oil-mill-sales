<?php

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

Route::get('test',function (){
   dd(now()->format('Y-m-d'));
});

Route::middleware(['auth'])->group(function (){
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('users', 'UserController');

    Route::resource('item-categories','ItemCategoryController');

    Route::resource('stocks', 'StockController');

    Route::resource('items','ItemController');

    Route::resource('sales', 'SaleController');

    Route::resource('customers','CustomerController');

    Route::get('category/{categoryId}/items', 'SaleController@getItemsForCategory');
    Route::get('item/{itemId}/stocks', 'SaleController@getStocks');
    Route::get('stock/{stockId}/sale-price', 'SaleController@getSalePrice');

});

Auth::routes();
