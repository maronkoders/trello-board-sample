<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


    Route::post("exportDB","CardController@exportDB");  
    Route::resource('/column', 'ColumnController');
    Route::resource('/card', 'CardController');
    Route::group(['middleware'=>'auth'], function(){
    
});



