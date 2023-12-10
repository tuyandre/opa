<?php

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
    return view('welcome');
});
//pricing page
Route::get('/pricing', [App\Http\Controllers\FrontRegistrationController::class, 'pricing'])->name('frontend.pricing');
//registration page
Route::get('/registration/{session_id}', [App\Http\Controllers\FrontRegistrationController::class, 'registration_training'])->name('frontend.registration.training');
//store registration form data
Route::post('/registration/store', [App\Http\Controllers\FrontRegistrationController::class, 'storeRegistration'])->name('frontend.registration.store');
//contact us routes
Route::post('/contact-us/store', [App\Http\Controllers\ContactUsController::class, 'saveContactUs'])->name('frontend.contact-us.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin group routes require authentication
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function () {
    Route::get('/contact_us', [App\Http\Controllers\ContactUsController::class, 'index'])->name('admin.contact.us');


    //training session routes
    Route::get('/training-session', [App\Http\Controllers\TrainingSessionController::class, 'index'])->name('admin.training.session');
    Route::post('/training-session/store', [App\Http\Controllers\TrainingSessionController::class, 'store'])->name('admin.training.session.store');



    //student routes
    Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('admin.student.index');


    //service routes
    Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('admin.service.index');
    Route::post('/services/store', [App\Http\Controllers\ServiceController::class, 'store'])->name('admin.service.store');
    Route::get('/service/delete/{id}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('admin.service.delete');
    Route::post('/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('admin.service.update');

   });
