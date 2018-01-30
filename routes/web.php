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


//Auth::routes();

Route::get('/', function () {
    return redirect('/staff/login');
});

Route::get('staff/login', 'UserController@show');
Route::post('staff/login', 'UserController@loginCheck');
Route::get('staff/logout', 'UserController@logout');

Route::get('downloadExcel', 'UserController@downloadExcel');

Route::post('ajax/householdVillage', 'UserController@householdVillage');
//api's
Route::group(['middleware' => 'apiauth'], function () {
    Route::post('household/create', 'UserController@createHousehold');
    Route::get('household/list', 'UserController@getHousehold');
    Route::get('household/count', 'UserController@getHouseholdCount');
});


Route::post('ajax/analyticsVillage', 'UserController@analyticsVillage');
Route::post('ajax/patientPHC', 'UserController@patientPHC');

Route::group(['middleware' => 'customauth'], function () {
    Route::get('dashboard', 'UserController@dashboard');
    Route::get('admin/reports', 'UserController@reportsView');
    Route::post('admin/reports', 'UserController@reportsView');
    Route::get('admin/household', 'UserController@householdView');
    Route::post('admin/household', 'UserController@householdView');


    Route::get('patients/list', 'UserController@getPatientsView');
    Route::post('patients/list', 'UserController@getPatientsView');
    Route::get('analytics/{type}', 'UserController@analyticsView');
    Route::post('analytics/{type}', 'UserController@analyticsView');
    Route::get('disease', 'UserController@diseaseView');
    Route::post('disease', 'UserController@diseaseView');
});



