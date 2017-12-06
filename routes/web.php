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
Route::get('staff/charts', 'UserController@charts');
Route::post('staff/login', 'UserController@loginCheck');
Route::get('staff/logout', 'UserController@logout');
Route::post('users/usernamecheck', 'UserController@userNameCheck');
Route::get('admin/reports', 'UserController@reportsView');
Route::get('admin/household', 'UserController@householdView');
Route::post('admin/household', 'UserController@householdView');
Route::get('downloadExcel', 'UserController@downloadExcel');

Route::post('ajax/householdVillage', 'UserController@householdVillage');

Route::post('household/create', 'UserController@createHousehold');
Route::get('household/list', 'UserController@getHousehold');

Route::get('patients/list', 'UserController@getPatientsView');
Route::get('analytics/{type}', 'UserController@analyticsView');
Route::post('ajax/analyticsVillage', 'UserController@analyticsVillage');

Route::group(['middleware' => 'customauth'], function () {
     
   
});

 

