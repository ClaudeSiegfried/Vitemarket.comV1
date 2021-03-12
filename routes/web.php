<?php

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

/*Route::get('/', function () {
    return view('auth.login');
});*/

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@auth');

Route::get('/', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {

    Route::resource('users', 'UserController')->except('show', 'create', 'store');

});

Route::get('images/{filename}', 'GestionPhotos\PhotoController@display')->name('photo.display');

Route::resource('client', 'Utilisateurs\ClientController')->except('show');

Route::resource('fournisseur', 'Utilisateurs\FournisseurController');

Route::resource('livreur', 'Utilisateurs\LivreurController')->except('destroy');

Route::resource('marque', 'GestionProduits\MarqueController')->except('show');

Route::resource('categorie', 'GestionProduits\CategorieController');

Route::resource('produit', 'GestionProduits\ProduitController');

Route::resource('etiquette', 'GestionProduits\EtiquetteController');

Route::resource('stock', 'GestionProduits\StockController');

Route::resource('commande', 'GestionCommandes\CommandeController');

Route::resource('livraison', 'GestionLivraisons\LivraisonController');

Route::resource('paiement', 'GestionCommandes\PaiementController');

Route::resource('mmoney', 'Configurations\MmoneyController');

Route::resource('percentage', 'Configurations\MoneyProviderPercentageController');

Route::resource('deliveryFees', 'Configurations\TarifLivraisonController');

Route::resource('discounts', 'Discounts\DiscountsController');

Route::namespace('Discounts')->prefix('applyDiscount')->name('applyDiscount.')->middleware('can:manage-users')->group(function () {

    Route::post('savediscountsuser', 'DiscountsController@savediscountsuser')->name('savediscountsuser');

    Route::delete('/deletediscountsuser/{id}', 'DiscountsController@deletediscountsuser')->name('deletediscountsuser');

    Route::get('/editdiscountsuser/{id}', 'DiscountsController@editdiscountsuser')->name('editdiscountsuser');

    Route::post('savediscountsproduct', 'DiscountsController@savediscountsproduct')->name('savediscountsproduct');

    Route::delete('/deletediscountsproduct/{id}', 'DiscountsController@deletediscountsproduct')->name('deletediscountsproduct');

    Route::get('/editdiscountsproduct/{id}', 'DiscountsController@editdiscountsproduct')->name('editdiscountsproduct');

});

Route::namespace('Discounts')->prefix('applyDiscount')->name('applyDiscount.')->middleware('can:manage-users')->group(function () {

    Route::get('/applydiscountsuser', 'DiscountsController@applydiscountsuser')->name('applydiscountsuser');

    Route::get('/applydiscountsproduct', 'DiscountsController@applydiscountsproduct')->name('applydiscountsproduct');
});


