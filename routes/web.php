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
   dd(public_path('fonts/kalpurush.ttf'));
});

Route::middleware(['auth'])->group(function (){
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('users', 'UserController');

    Route::resource('item-categories','ItemCategoryController');

    Route::resource('stocks', 'StockController');

    Route::resource('items','ItemController');
    Route::get('items/category/{categoryId}','ItemController@getItemsForCategory');

    Route::resource('sales', 'SaleController');
    Route::get('sale-quantity', 'SaleController@getSaleQuantity')->name('sale_quantity');

    Route::resource('customers', 'CustomerController');

    Route::resource('vehicle','VehicleController');

    Route::get('category/{categoryId}/items', 'SaleController@getItemsForCategory');
    Route::get('item/{itemId}/stocks', 'SaleController@getStocks');
    Route::get('stock/{stockId}/sale-price', 'SaleController@getSalePrice');

    Route::resource('routes', 'RouteController');

    Route::resource('item-units', 'ItemUnitController');

    Route::get('memo', 'ReportController@generateMemo')->name('memo');

    Route::get('report/route', 'ReportController@routeWiseReport')->name('route_report');
    Route::get('memo/route', 'ReportController@generateRouteWiseReport')->name('route_memo');
});

Auth::routes();
