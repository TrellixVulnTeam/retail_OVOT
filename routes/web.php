<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes...
Auth::routes(['verify' => true]);
// UI Store
Route::get('/', 'Ui\StoreController@index');
Route::get('/contacto', function () {return view('ui.tienda.contact');});
Route::get('/producto/{ProductosNombre}/{ProductosID}', 'Ui\StoreController@Producto');
/* Cart Routes */
Route::prefix('carrito')->group(function () {
  Route::get('/','Ui\CartController@index');
  Route::post('create','Ui\CartController@create');
  Route::get('read','Ui\CartController@read');
  Route::post('update','Ui\CartController@update');
  Route::post('delete','Ui\CartController@delete');
});
/* Auth views user */
Route::middleware(['auth','verified'])->group(function () {
  // checkout
  Route::prefix('checkout')->group(function () {
    Route::get('/','Ui\CheckoutController@index');
    Route::post('/store','Ui\CheckoutController@store');
  });
  // shipping
  Route::prefix('shipping')->group(function () {
    Route::get('/','Ui\ShippingController@shipping');
    Route::post('/shipping_action','Ui\ShippingController@shipping_action');
  });
  // Mis Pedidos
  Route::prefix('MisPedidos')->group(function () {
    Route::get('/','Ui\OrdersController@index');
    Route::get('/{NOrden}','Ui\OrdersController@detalles');
  });

});
// # Admin Views
Route::middleware(['auth','role.admin'])->group(function () {
  Route::get('/dashboard', 'HomeController@index')->name('home');
  //* Productos */
  Route::prefix('productos')->group(function () {
    Route::get('index', 'Admin\ProductController@index');
    Route::post('create','Admin\ProductController@create');
    Route::post('read','Admin\ProductController@read');
    Route::post('update','Admin\ProductController@update');
    // Imagenes de Productos
    Route::prefix('images')->group(function () {
      Route::post('read','Admin\ProductImagesController@read');
      Route::post('create','Admin\ProductImagesController@create');
      Route::post('delete','Admin\ProductImagesController@delete');
      Route::post('featured','Admin\ProductImagesController@featured');
    });
  });
});
