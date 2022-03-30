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

Route::get('locale/{locale}',[App\Http\Controllers\HomeController::class, 'changeLocale'])->name('locale');

Route::middleware(['set_locale'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/questionary/{id}', [App\Http\Controllers\QuestionaryController::class, 'showQuestionary'])->name('showQuestionary');
    Route::get('/questionary-update/{hash}', [App\Http\Controllers\QuestionaryController::class, 'showUpdateQuestionary'])->name('showUpdateQuestionary');
});
Route::post('/questionary/check',[App\Http\Controllers\QuestionaryController::class, 'checkData']);
Route::post('/questionary/create', [App\Http\Controllers\QuestionaryController::class, 'addQuestionary'])->name('addQuestionary');
Route::get('/questionary/university/{id}', [App\Http\Controllers\QuestionaryController::class, 'getDataUniversity']);
Route::get('/questionary/college/{id}', [App\Http\Controllers\QuestionaryController::class, 'getDataCollege']);
Route::post('/questionary/update/{id}', [App\Http\Controllers\QuestionaryController::class, 'updateQuestionary'])->name('updateQuestionary');

Route::group(['prefix'=>'admin', 'middleware'=>'auth:admin'], function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class,'index']);
    Route::get('/university', [App\Http\Controllers\Admin\DashboardController::class,'showDashboard'])->name('admin.university');
    Route::get('/university/{id}', [App\Http\Controllers\Admin\QuestionaryController::class,'showQuestionaryParticipant'])->name('admin.university.participant');
    Route::get('/college', [App\Http\Controllers\Admin\DashboardController::class,'showDashboard'])->name('admin.college');
    Route::get('/college/{id}', [App\Http\Controllers\Admin\QuestionaryController::class,'showQuestionaryParticipant'])->name('admin.college.participant');
    Route::post('/change-data', [App\Http\Controllers\Admin\QuestionaryController::class,'changeStatusOrUpdateData'])->name('admin.change-data');
    Route::get('/file-export/{id}', [\App\Http\Controllers\DataExportController::class, 'export'])->name('file.export');
    Route::post('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
});
Route::get('admin/login', [App\Http\Controllers\Admin\LoginController::class,'showLogin'])->name('admin.login');
Route::post('admin/auth', [App\Http\Controllers\Admin\LoginController::class,'login'])->name('admin.auth');
