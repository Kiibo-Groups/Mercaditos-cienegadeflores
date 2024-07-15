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

Route::group(array('namespace' => 'App\Http\Controllers\Api'), function () {

    /**
     * Bienvenida y datos iniciales
     */
    Route::get('welcome','ApiController@welcome');
    Route::get('getDataInit','ApiController@getDataInit');
    Route::get('GetSurveysAssign/{id}','ApiController@GetSurveysAssign');
    
    /**
     * Datos iniciales para usuarios registrados
     */ 
    Route::get('homepage_init/{city}','ApiController@homepage_init');

    /**
     * Funciones de registro
     */
    Route::post('signup','ApiController@signup');
    Route::post('signupOP','ApiController@signupOP');
    Route::post('sendOTP','ApiController@sendOTP');
    Route::post('SignPhone','ApiController@SignPhone');

    /**
     * Funciones de inicio de sesion y validacion de usuario
     */
    Route::post('login','ApiController@login');
    Route::post('chkUser','ApiController@chkUser');
    Route::post('Newlogin','ApiController@Newlogin'); 
    Route::post('loginFb','ApiController@loginFb');
    Route::get('userinfo/{id}','ApiController@userinfo');
    Route::post('updateInfo/{id}','ApiController@updateInfo');
    Route::get('updateLocation/{lat}/{lng}/{user}','ApiController@updateLocation');

    /**
     * 
     * Funciones para obtener usuario en especifico y conexiones
     * 
     */
    Route::get('getUser/{user}','ApiController@getUser');
    Route::get('search/{query}','ApiController@search');
    Route::get('overview/{user}','ApiController@overview');
   
    /**
     * 
     * Funciones para el registro de informacion del mercado
     * 
     */
    Route::post('addMarket','ApiController@addMarket');
    Route::post('sendInfoMarket','ApiController@sendInfoMarket');
    Route::post('sendInfoMarketPending','ApiController@sendInfoMarketPending');
    Route::post('sendInfoOferentePending','ApiController@sendInfoOferentePending');
    
    /**
     * 
     * Funcion para registrar permisos de alcohol
     * 
     */
    Route::post('savePerms','ApiController@savePerms');

    /**
     * Valiamos un oferente por su ID codificado
     */
    Route::get('chkMarketId/{id}','ApiController@chkMarketId');
   
});
