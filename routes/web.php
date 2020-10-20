<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'DashboardController');
Route::get('/addClient', 'DashboardController');
Route::get('/clients', 'DashboardController');
Route::get('/editClient', 'DashboardController');

//Endpoint


Route::get('/getClients', 'HomeController@getClients');
Route::get('/getActivites', 'HomeController@getActivites');
Route::post('/saveClient', 'HomeController@saveClient');
Route::post('/updateClient', 'HomeController@updateClient');
Route::post('/changeStatus', 'HomeController@changeStatus');
Route::post('/deleteClients', 'HomeController@deleteClients');
Route::post('/removeClient', 'HomeController@deleteClient');



Route::get('reset', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return '<h1>Have cleared the env</h1>';
});
