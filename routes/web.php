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

Route::get('/', 'HomeController@index')->name('home');

Route::resource('users', 'UserController')->middleware('auth');

Route::get('item-categories','ItemCategoryController@index')->name('itemCategory.index')->middleware('auth') ;
Route::post('store-item-categories','ItemCategoryController@store')->name('itemCategory.store')->middleware('auth') ;
Route::post('update-item-category/{id}','ItemCategoryController@update')->name('itemCategory.update')->middleware('auth') ;
Route::post('delete-item-category/{id}','ItemCategoryController@destroy')->name('itemCategory.destroy')->middleware('auth') ;


Auth::routes();
