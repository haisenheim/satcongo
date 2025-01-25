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
        Route::resource('departements','DepartementController');
        Route::get('departement/enable/{token}','DepartementController@enable')->name('departement.enable');
        Route::get('departement/disable/{token}','DepartementController@disable')->name('departement.disable');
        Route::post('user/caisse','UserController@setCaisse')->name('user.caisse');
        Route::post('user/departement','UserController@setDepartement')->name('user.departement');
        Route::post('caisse/compte','CaisseController@addCompte')->name('caisse.compte');
        Route::post('caisse/set/compte','CaisseController@setCompte')->name('caisse.set.compte');
        Route::post('caisse/add/compte','CaisseController@addCompte')->name('caisse.add.compte');
        Route::post('caisse/set/user','CaisseController@setUser')->name('caisse.set.user');
        Route::get('caisse/enable/{token}','CaisseController@enable')->name('caisse.enable');


        Route::resource('dossiers','DossierController');
        Route::resource('clients','ClientController');
        Route::get('dossier/close/{token}','DossierController@close')->name('dossier.close');


        Route::get('caisse/disable/{token}','CaisseController@disable')->name('caisse.disable');
        Route::resource('libelles','LibelleController');
        Route::resource('comptes','CompteController');
        Route::resource('agences','AgenceController');
        Route::post('agence/set/libelle','AgenceController@setLibelle')->name('agence.set.libelle');
        Route::get('agence/enable/{token}','AgenceController@enable')->name('agence.enable');
        Route::get('agence/disable/{token}','AgenceController@disable')->name('agence.disable');
        Route::resource('tiers','TierController');
        Route::get('tier/enable/{token}','TierController@enable')->name('tier.enable');
        Route::get('tier/disable/{token}','TierController@disable')->name('tier.disable');
        Route::resource('transactions','TransactionController');

    });

Route::namespace('App\Http\Controllers\Caissier')
    ->prefix('caissier')
    ->middleware(['auth','caissier'])
    ->name('caissier.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('operation/create','DashboardController@createOperation')->name('operation.create');
        Route::get('caisse/comptes','DashboardController@getComptes')->name('caisse.comptes');
        Route::get('operation/{token}','DashboardController@getOperation')->name('operation.show');
        Route::get('print/operation/{token}','DashboardController@printOperation')->name('operation.print');
       # Route::post('transactions','DashboardController@saveOperation')->name('operation.store');
        Route::post('operations','DashboardController@saveOperation')->name('operation.save');
        Route::post('operation/update','DashboardController@updateOperation')->name('operation.update');
        Route::get('caisse/libelles','DashboardController@getLibelles')->name('agence.libelles');
        Route::get('create','DashboardController@create')->name('create');
        Route::post('store1','DashboardController@store')->name('store');
        Route::post('store2','DashboardController@store2')->name('store2');
        Route::post('store3','DashboardController@store3')->name('store3');

        Route::get('data/operations','DashboardController@getOperations')->name('operations.all');
    });

Route::namespace('App\Http\Controllers\Comptable')
    ->prefix('comptable')
    ->middleware(['auth','comptable'])
    ->name('comptable.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('bluk/validate/{caisse_id}/{start}/{end}','DashboardController@blukValidate')->name('bluk.validate');
        Route::get('bluk/export/{caisse_id}/{start}/{end}','DashboardController@blukExport')->name('bluk.export');
        Route::get('data/operations','DashboardController@getOperations')->name('operations.all');
        Route::post('store','DashboardController@store')->name('store');
    });

Route::namespace('App\Http\Controllers\Operateur')
    ->prefix('operateur')
    ->middleware(['auth','operateur'])
    ->name('operateur.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::resource('dossiers','DossierController');
        Route::resource('clients','ClientController');
    });

Route::namespace('App\Http\Controllers\Dcomptable')
    ->prefix('dcomptable')
    ->middleware(['auth','dcomptable'])
    ->name('dcomptable.')
    ->group(function(){
        Route::get('dashboard','DashboardController@index')->name('dashboard');
        Route::get('bluk/validate/{caisse_id}/{start}/{end}','DashboardController@blukValidate')->name('bluk.validate');
        Route::get('single/validate/{token}','DashboardController@singleValidate')->name('single.validate');
        Route::get('bluk/export/{caisse_id}/{start}/{end}','DashboardController@blukExport')->name('bluk.export');
    });



Route::get('/home',[HomeController::class,'index'])->name('home')->middleware('auth');
Route::get('/profile',[HomeController::class,'profile'])->name('profile')->middleware('auth');
Route::post('/logout',[HomeController::class,'logout'])->name('logout')->middleware('auth');
