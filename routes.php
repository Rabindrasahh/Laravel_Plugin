<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web'], 'namespace' => '\Acelle\Plugin\AddNewLeadToCrm\Controllers'], function () {
    Route::match(['get'], 'plugins/add-lead-to-crm', 'MainController@index');
    Route::match(['post'], 'plugins/add-lead-to-crm/save', 'MainController@saveList');
});
