<?php

use App\Http\Controllers\AuthController;
use App\Models\Absence;
use App\Models\Pointage;
use App\Models\User;
use App\Models\Tuteur;
use App\Services\OneSignalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('home',function(){
    $users = User::all();
    dd($users);
    return response()->json('ok oooooh');
});

Route::get('/tuteur/phone/{number}',function($number){

    $number = str_replace(' ','',$number);
    $tuteur = Tuteur::where('phone',$number)->first();
    if(!$tuteur){
        $tuteur = Tuteur::create([
            'phone'=>$number,
            'token'=>sha1(time())
        ]);
    }
    return response()->json($tuteur);
});

Route::post('/tuteur',function(){
    $phone = request()->phone;
    $phone = str_replace(' ','',$phone);
    $tuteur = Tuteur::where('phone',$phone)->first();
    $tuteur->first_name = request()->first_name;
    $tuteur->last_name = request()->last_name;
    $tuteur->email = request()->email;
    $tuteur->address = request()->address;
    $tuteur->save();
    return response()->json($tuteur);
});

Route::namespace('App\Http\Controllers\Api')
    ->middleware('api')
    ->group(function () {
        Route::post('link','SyncController@setLink');
        Route::post('notify','SyncController@notify');
        Route::post('notify/all','SyncController@notifyAll');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'tuteur',
    'namespace'=>'App\Http\Controllers\Api\Tuteur'
], function ($router) {
    Route::get('/home/{phone}','HomeController@index');
    Route::get('/eleve/{id}','HomeController@getEleveByLinkId');
    Route::post('/notify','HomeController@notify');
    Route::get('/segment','HomeController@createSegment');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'name'=>'api.'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('api.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('api.refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('api.me');
    Route::post('/ecoles/create',function()use($router){
        return response()->json('ok');
    })->middleware('auth:api')->name('me');
});

Route::get('/devices',function(){
   $data = OneSignal::getDevices();
   return response()->json($data);
});

Route::get('/onesignal',function(){
    $data['content'] = [
        'nom'=>'Essomba',
        'prenom'=>'Clement'
    ];
    $fields['include_external_user_ids'] = ['90239328327837'];
    $fields['channel_for_external_user_ids'] = "push";
    //$fields['isAndroid'] = true;
    $fields['data'] = $data;
    $message = 'Hello, Hello!';
    $response = OneSignalNotification::send($fields,$message);
    return response()->json($response);
});

Route::get('test',function(){
    $id = 4;

   $users = DB::table('inscriptions')
        ->join('etudiants','inscriptions.etudiant_id','=','etudiants.id')
        ->join('filieres','filieres.id','=','inscriptions.filiere_id')
        ->select('etudiants.first_name','etudiants.last_name','etudiants.matricule','inscriptions.niveau_id','filieres.code')
        ->get();

    return response()->json($users);

});






