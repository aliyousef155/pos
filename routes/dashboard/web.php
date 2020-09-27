<?php
use Illuminate\Support\Facades\Route;
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function (){
        //dashboard route
        route::get('admin','DashboardController@index')->name('admin');
        //users route
        route::resource('users','UsersController')->except('show');
        //categories route
        route::resource('categories','CategoryController')->except('show');
        //products route
        route::resource('products','ProductController')->except('show');
        //clients route
        route::resource('clients','ClientController')->except('show');
        route::resource('clients.orders','client\OrderController')->except('show');
        //order route
        route::resource('orders','OrderController')->except('edit');
        route::get('/orders/{order}/products','OrderController@products')->name('orders.products');
    });

});



