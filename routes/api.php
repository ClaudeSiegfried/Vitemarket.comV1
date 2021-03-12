<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Create New User*/
Route::post('v1/NewUser','Admin\UserApiController@newUser');

/*Login*/
Route::post('v1/Login','Admin\UserApiController@RegisterUser');

Route::post('v1/LoginFirebase','Admin\UserApiController@RegisterFirebaseUser');

/*get all products*/
Route::get('v1/GetProductsCollection','GestionProduits\ProduitApiController@index');

Route::get('v2/GetProductsCollection','GestionProduits\ProduitApiController@indexV2');

/*get all categories*/
Route::get('v1/GetProductsCategories','GestionProduits\CategorieApiController@index');

/*get all payment Provider*/
Route::get('v1/GetPaymentProviders','Configurations\MmoneyApiController@index');

/*get a valid token*/
Route::get('v1/GetToken','Configurations\TokenController@index');

Route::post('v1/SaveFcmToken','Configurations\TokenController@fcm');

/*create and validate basket*/
Route::post('v1/NewBasket','GestionCommandes\panierApiController@store');

/*update and validate basket*/
Route::post('v1/UpdateBasket','GestionCommandes\panierApiController@update');

/*make an order*/
Route::post('v1/NewOrder','GestionCommandes\CommandeApiController@store');

Route::post('v1/GetUserHistory','GestionCommandes\CommandeApiController@show');

Route::post('v1/NewAddress','Localisations\LocalisationApiController@store');

Route::post('v1/UpdateAddress','Localisations\LocalisationApiController@update');

Route::post('v1/UserAddress','Localisations\LocalisationApiController@show');

Route::post('v1/DeleteAddress','Localisations\LocalisationApiController@destroy');

Route::get('v1/GetOtp','Configurations\OtpController@Send');

Route::post('v1/PaygateCallback','Paygate\PaygateController@get');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
