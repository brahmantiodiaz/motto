<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\BoardAssignmentController;
use App\Http\Controllers\ModalStoryController;
use App\Http\Controllers\ProjectBoardController;
use App\Http\Controllers\SowController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\TrainerController;
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


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::resource('projectboard', ProjectBoardController::class, ['except' => [
        'create', 'update'
    ]]);
    Route::resource('boardassignment', BoardAssignmentController::class, ['except' => [
        'create', 'update'
    ]]);
    Route::get('/boardassignmentcopy/{id}', [BoardAssignmentController::class, 'copy']);
    Route::post('/boardassignmentcopy', [BoardAssignmentController::class, 'savecopy']);
    Route::get('/boardassignmentdrop/{id}', [BoardAssignmentController::class, 'drop']);
    
    Route::get('/modalstory/{id}', [ModalStoryController::class, 'index']);
    Route::get('/download/{file}', [ModalStoryController::class, 'download']);
    Route::resource('story', StoryController::class);
    Route::resource('sow', SowController::class);
    Route::resource('technology', TechnologyController::class);
    Route::resource('trainer', TrainerController::class);
    Route::resource('batch', BatchController::class);
    Route::resource('attachment', AttachmentController::class);

});
