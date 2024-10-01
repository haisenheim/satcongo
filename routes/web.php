<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::namespace('App\Http\Controllers\Util')
    ->prefix('util')
    ->name('util.')
    ->group(function(){
        Route::get('ville/agences','SearchController@getAgencesByVilleId')->name('ville.agences');
       Route::get('agence/caisses','SearchController@getCaissesByAgenceId')->name('agence.caisses');
        #Route::get('departement/arrondissements','SearchController@getArrondissementsByDepartementId')->name('departement.arrondissements');
        
    });

Route::namespace('App\Http\Controllers\Admin')
    ->prefix('admin')
    ->middleware(['auth','admin'])
    ->name('admin.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::resource('users','UserController');
        Route::get('user/enable/{token}','UserController@enable')->name('user.enable');
        Route::get('user/disable/{token}','UserController@disable')->name('user.disable');
        Route::resource('caisses','CaisseController');
        Route::post('user/caisse','UserController@setCaisse')->name('user.caisse');
        Route::post('caisse/compte','CaisseController@addCompte')->name('caisse.compte');
        Route::get('caisse/enable/{token}','CaisseController@enable')->name('caisse.enable');
        Route::get('caisse/disable/{token}','CaisseController@disable')->name('caisse.disable');
        Route::resource('comptes','CompteController');
        Route::resource('agences','AgenceController');
        Route::get('agence/enable/{token}','AgenceController@enable')->name('agence.enable');
        Route::get('agence/disable/{token}','AgenceController@disable')->name('agence.disable');
        Route::resource('transactions','TransactionController');
        
    });

Route::namespace('App\Http\Controllers\Caissier')
    ->prefix('caissier')
    ->middleware(['auth','caissier'])
    ->name('caissier.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('caisse/comptes','DashboardController@getComptes')->name('caisse.comptes');
        Route::post('transactions','DashboardController@saveOperation')->name('operation.store');
    });

Route::namespace('App\Http\Controllers\Comptable')
    ->prefix('comptable')
    ->middleware(['auth','comptable'])
    ->name('comptable.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('bluk/validate/{caisse_id}/{start}/{end}','DashboardController@blukValidate')->name('bluk.validate');
        Route::get('bluk/export/{caisse_id}/{start}/{end}','DashboardController@blukExport')->name('bluk.export');
    });


Route::get('/home',[HomeController::class,'index'])->name('home')->middleware('auth');
Route::get('/profile',[HomeController::class,'profile'])->name('profile')->middleware('auth');
Route::post('/logout',[HomeController::class,'logout'])->name('logout')->middleware('auth');
