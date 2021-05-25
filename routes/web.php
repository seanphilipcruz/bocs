<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::get('advertisers', ['as' => 'advertisers', 'uses' => 'AdvertiserController@index']);
    Route::get('advertisers/show', ['as' => 'advertisers.show', 'uses' => 'AdvertiserController@show']);
    Route::post('advertisers/store', ['as' => 'advertisers.store', 'uses' => 'AdvertiserController@store']);
    Route::put('advertisers/update/{id}', ['as' => 'advertisers.update', 'uses' => 'AdvertiserController@update']);
    Route::delete('advertisers/delete/{id}', ['as' => 'advertisers.delete', 'uses' => 'AdvertiserController@delete']);

    Route::get('agencies', ['as' => 'agencies', 'uses' => 'AgencyController@index']);
    Route::get('agencies/show', ['as' => 'agencies.show', 'uses' => 'AgencyController@show']);
    Route::post('agencies/store', ['as' => 'agencies.store', 'uses' => 'AgencyController@store']);
    Route::put('agencies/update/{id}', ['as' => 'agencies.update', 'uses' => 'AgencyController@update']);
    Route::delete('agencies/delete/{id}', ['as' => 'agencies.delete', 'uses' => 'AgencyController@delete']);

    Route::get('contracts', ['as' => 'contracts', 'uses' => 'ContractController@index']);
    Route::get('contracts/create', ['as' => 'contracts.create', 'uses' => 'ContractController@create']);
    Route::get('contracts/show', ['as' => 'contracts.show', 'uses' => 'ContractController@show']);
    Route::post('contracts/store', ['as' => 'contracts.store', 'uses' => 'ContractController@store']);
    Route::put('contracts/update/{id}', ['as' => 'contracts.update', 'uses' => 'ContractController@update']);
    Route::delete('contracts/delete/{id}', ['as' => 'contracts.delete', 'uses' => 'ContractController@delete']);
    Route::get('contracts/generate/{id}', ['as' => 'contracts.generate', 'uses' => 'ContractController@generatePDF']);
    Route::get('contracts/generate/text/{id}', ['as' => 'contracts.generate.text', 'uses' => 'ContractController@generateText']);

    Route::get('employees', ['as' => 'employees', 'uses' => 'EmployeeController@index']);
    Route::get('employees/show', ['as' => 'employees.show', 'uses' => 'EmployeeController@show']);
    Route::post('employees/store', ['as' => 'employees.store', 'uses' => 'EmployeeController@store']);
    Route::put('employees/update/{id}', ['as' => 'employees.update', 'uses' => 'EmployeeController@update']);
    Route::delete('employees/delete/{id}', ['as' => 'employees.delete', 'uses' => 'EmployeeController@delete']);
    Route::put('employees/change/{id}', ['as' => 'employee.change.password', 'uses' => 'EmployeeController@ChangePassword']);

    Route::get('jobs', ['as' => 'jobs', 'uses' => 'JobsController@index']);
    Route::get('jobs/show', ['as' => 'jobs.show', 'uses' => 'JobsController@show']);
    Route::post('jobs/store', ['as' => 'jobs.store', 'uses' => 'JobsController@store']);
    Route::put('jobs/update/{id}', ['as' => 'jobs.update', 'uses' => 'JobsController@update']);
    Route::delete('jobs/delete/{id}', ['as' => 'jobs.delete', 'uses' => 'JobsController@delete']);

    Route::get('sales', ['as' => 'sales', 'uses' => 'SalesController@index']);
    Route::get('sales/show', ['as' => 'sales.show', 'uses' => 'SalesController@show']);
    Route::get('sales/create', ['as' => 'sales.create', 'uses' => 'SalesController@create']);
    Route::post('sales/store', ['as' => 'sales.store', 'uses' => 'SalesController@store']);
    Route::put('sales/update/{id}', ['as' => 'sales.update', 'uses' => 'SalesController@update']);
    Route::delete('sales/delete/{id}', ['as' => 'sales.delete', 'uses' => 'SalesController@delete']);
    Route::get('sales/show/breakdowns', ['as' => 'sales.show.breakdowns', 'uses' => 'SalesController@breakdowns']);
    Route::get('sales/reports', ['as' => 'sales.reports', 'uses' => 'SalesController@report']);

    Route::get('logs', ['as' => 'logs', 'uses' => 'LogsController@index']);

    Route::get('archives', ['as' => 'archives', 'uses' => 'ArchiveController@index']);
    Route::get('archives/show/{id}', ['as' => 'archives.show', 'uses' => 'ArchiveController@show']);
});

// Compute contract total
Route::post('/find/total', ['as' => 'find.total', 'uses' => 'ContractController@findTotal']);
Route::post('/find/sales/total', ['as' => 'find.sales.total', 'uses' => 'ContractController@findSalesTotal']);

// Request an Account
Route::post('/request/account', ['as' => 'account.request', 'uses' => 'EmployeeController@request']);
