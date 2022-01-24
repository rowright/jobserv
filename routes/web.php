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


Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');
Route::post('/login', 'App\Http\Controllers\LoginController@authenticate');
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/workorders');
    });
    Route::get('/simple/quickadd', 'App\Http\Controllers\SimpleController@quickAdd');
    Route::post('/simple/quickadd', 'App\Http\Controllers\SimpleController@quickAddStore');

    Route::get('/integrations', 'App\Http\Controllers\IntegrationController@index');
    Route::get('/workorders', 'App\Http\Controllers\WorkOrderController@index');
    Route::get('/workorders/all', 'App\Http\Controllers\WorkOrderController@all');
    Route::get('/workorders/new/{id}', 'App\Http\Controllers\WorkOrderController@create');
    Route::post('/workorders/new/{id}', 'App\Http\Controllers\WorkOrderController@store');
    Route::get('/workorders/{id}', 'App\Http\Controllers\WorkOrderController@show');
    Route::get('/workorders/{id}/print', 'App\Http\Controllers\WorkOrderController@print');
    Route::get('/workorders/{id}/archive', 'App\Http\Controllers\WorkOrderController@archive');
    Route::get('/workorders/{id}/unarchive', 'App\Http\Controllers\WorkOrderController@unarchive');
    Route::get('/workorders/{id}/removeworker/{worker_id}', 'App\Http\Controllers\WorkOrderController@removeworker');
    Route::post('/workorders/{id}/addworker', 'App\Http\Controllers\WorkOrderController@addworker');
    Route::get('/workorders/{id}/edit', 'App\Http\Controllers\WorkOrderController@edit');
    Route::post('/workorders/{id}/edit', 'App\Http\Controllers\WorkOrderController@save');
    Route::get('/workorders/{id}/unlink', 'App\Http\Controllers\WorkOrderController@unlink');
    Route::post('/workorders/{id}/link', 'App\Http\Controllers\WorkOrderController@link');
    Route::post('/workorders/{id}/addcomment', 'App\Http\Controllers\WorkOrderController@comment');
    Route::get('/ical', 'App\Http\Controllers\iCalController@index');

    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/users/new', 'App\Http\Controllers\UserController@create');
    Route::post('/users/new', 'App\Http\Controllers\UserController@save');
    Route::get('/users/{id}', 'App\Http\Controllers\UserController@edit');
    Route::post('/users/{id}', 'App\Http\Controllers\UserController@update');
    Route::get('/users/{id}/delete', 'App\Http\Controllers\UserController@delete');

    Route::get('/workers', 'App\Http\Controllers\WorkerController@index');
    Route::get('/workers/new', 'App\Http\Controllers\WorkerController@create');
    Route::post('/workers/new', 'App\Http\Controllers\WorkerController@save');
    Route::get('/workers/{id}', 'App\Http\Controllers\WorkerController@edit');
    Route::post('/workers/{id}', 'App\Http\Controllers\WorkerController@update');

    Route::get('/jobtypes', 'App\Http\Controllers\JobTypeController@index');
    Route::get('/jobtypes/new', 'App\Http\Controllers\JobTypeController@new');
    Route::post('/jobtypes/new', 'App\Http\Controllers\JobTypeController@store');
    Route::get('/jobtypes/{id}', 'App\Http\Controllers\JobTypeController@edit');
    Route::post('/jobtypes/{id}', 'App\Http\Controllers\JobTypeController@update');

    Route::get('/customers', 'App\Http\Controllers\CustomerController@index');
    Route::get('/customers/new', 'App\Http\Controllers\CustomerController@create');
    Route::post('/customers/new', 'App\Http\Controllers\CustomerController@save');
    Route::get('/customers/{id}', 'App\Http\Controllers\CustomerController@show');
    Route::get('/customers/{id}/edit', 'App\Http\Controllers\CustomerController@edit');
    Route::post('/customers/{id}/edit', 'App\Http\Controllers\CustomerController@update');

    Route::get('/admin/tenant', 'App\Http\Controllers\AdminController@index');
    Route::get('/admin/purge', 'App\Http\Controllers\AdminController@purgeTenant');
    Route::post('/admin/tenant', 'App\Http\Controllers\AdminController@createTenant');

});
Route::get('/ical/all/{uuid}.ics', 'App\Http\Controllers\iCalController@all');
Route::get('/ical/{id}/{uuid}.ics', 'App\Http\Controllers\iCalController@worker');
Route::get('/register', 'App\Http\Controllers\AdminController@registerTenant');
Route::post('/register', 'App\Http\Controllers\AdminController@createTenant');
