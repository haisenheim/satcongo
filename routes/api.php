<?php

use App\Http\Controllers\AuthController;
use App\Models\Absence;
use App\Models\Pointage;
use App\Models\User;
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
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

Route::get('/normal',function(){
    $absences = Absence::all();
    foreach($absences as $absence){
        $absence->matiere_id = $absence->pointage->matiere_id;
        $absence->save();
    }
    return "Ok";
    $pointages = Pointage::all();
    foreach($pointages as $pointage){
        $pointage->matiere_id = $pointage->emploi->matiere_id;
        //$pointage->mois_id = \Carbon\Carbon::parse($pointage->dt)->month;
        $pointage->save();
    }

});

Route::group([
    'namespace'=>'App\Http\Controllers\Api\Student',
    'prefix'=>'student'
],function(){
    Route::get('home','MainController@index');
    Route::get('fiche','MainController@getFiche');
    Route::post('fiche','MainController@saveFiche');
});

Route::group([
    'middleware'=>'auth:api',
    'namespace'=>'App\Http\Controllers\Api\Teacher',
    'prefix'=>'prof'
],function(){
    Route::get('dashboard','DashboardController@index');
    Route::resource('emplois','EmploiController');
    Route::post('emploi/pointage','EmploiController@setPointage');
    Route::get('honoraires','EmploiController@getHonoraires');
    Route::get('honoraires/{mois_id}','EmploiController@getHistorique');
    Route::resource('evaluations','EvaluationController');
    Route::get('examens','EvaluationController@getExams');
    Route::post('examen/notes','EvaluationController@storeNotes');
    Route::get('examen/{token}','EvaluationController@getExam');
    Route::post('examens','EvaluationController@storeExams');
    Route::get('notes','EvaluationController@getNotes');
});

Route::group([
    'middleware'=>'auth:api',
    'namespace'=>'App\Http\Controllers\Api\Admin'
],function(){
    Route::resource('matieres','MatiereController');
    Route::resource('filieres','FiliereController');
    Route::resource('criteres','CritereController');
    Route::resource('salles','SalleController');
    Route::resource('laboratoires','LaboratoireController');
    Route::resource('inscriptions','InscriptionController');
    Route::get('inscription/ecolages/{id}','InscriptionController@getEcolages');
    Route::resource('tuteurs','TuteurController');
    Route::resource('etudiants','EtudiantController');
    Route::resource('livres','LivreController');
    Route::resource('cours','CoursController');
    Route::resource('posts','PostController');
    Route::resource('enseignants','EnseignantController');
    Route::resource('paiements','PaiementController');
    Route::resource('tranches','TrancheController');
    Route::resource('emplois','EmploiController');
    Route::post('emploi/cours','EmploiController@getCours');
    Route::post('emploi/pointage','EmploiController@setPointage');
    Route::resource('annees','AnneeController');
    Route::resource('evaluations','EvaluationController');
    Route::get('examens','EvaluationController@getExams');
    Route::post('examen/notes','EvaluationController@storeNotes');
    Route::get('examen/{token}','EvaluationController@getExam');
    Route::post('examens','EvaluationController@storeExams');
    Route::get('notes','EvaluationController@getNotes');
    Route::resource('tarifs','TarifController');
    Route::resource('ecolages','EcolageController');
    Route::get('/reports/inscription/{id}','ReportController@getReportByInscriptionId');
    Route::get('/reports/enseignant/{id}','ReportController@getReportByEnseignantId');
    Route::get('/reports/month/{id}','ReportController@getReportByMonth');
    Route::get('/reports/create','ReportController@create');
    Route::get('/reports/init','ReportController@init');
});
