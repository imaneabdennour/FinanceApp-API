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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List everything :    (http://127.0.0.1:8000/api/clients)
Route::get("clients", "ClientController@index");
Route::get("factures", "FactureController@index");
Route::get("gerants", "GerantController@index");
Route::get("navires", "NavireController@index");

//List a single client :
Route::get("client/{nom_entreprise}", "ClientController@show");
Route::get("facture/{num_commande}", "FactureController@show");
Route::get("gerant/{id}", "GerantController@show");
Route::get("navire/{nom_navire}", "NavireController@show");

//Create new client :
Route::post('client', "ClientController@store");
Route::post('facture', "FactureController@store");
Route::post('gerant', "GerantController@store");
Route::post('navire', "NavireController@store");

//Update client :
Route::put('client', "ClientController@store");
Route::put('facture', "FactureController@store");
Route::put('gerant', "GerantController@store");
Route::put('navire', "NavireController@store");

//Delete client :
Route::delete('client/{nom_entreprise}', "ClientController@destroy");
Route::delete('facture/{num_commande}', "FactureController@destroy");
//Route::delete('navire/{nom_navire}', "NavireController@destroy");
Route::delete('gerant/{id}', "GerantController@destroy");



