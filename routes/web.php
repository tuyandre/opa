<?php
//namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
//services page
Route::get('/services', [App\Http\Controllers\FrontRegistrationController::class, 'frontServices'])->name('frontend.services');
Route::get('/contact_us', [App\Http\Controllers\FrontRegistrationController::class, 'frontContactUs'])->name('frontend.contact.us');
Route::get('/about_us', [App\Http\Controllers\FrontRegistrationController::class, 'frontAboutUs'])->name('frontend.about.us');
Route::get('/trending/read-more', [App\Http\Controllers\FrontRegistrationController::class, 'trendingDetail'])->name('frontend.trending.detail');

//registration page
Route::get('/registration/{session_id}', [App\Http\Controllers\FrontRegistrationController::class, 'registration_training'])->name('frontend.registration.training');
//store registration form data
Route::post('/registration/store', [App\Http\Controllers\FrontRegistrationController::class, 'storeRegistration'])->name('frontend.registration.store');
//contact us routes
Route::post('/contact-us/store', [App\Http\Controllers\ContactUsController::class, 'saveContactUs'])->name('frontend.contact-us.store');

//Auth::routes();
// Login Routes
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Password Reset Routes
Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset');

// Email Verification Routes
Route::get('/email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin group routes require authentication
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function () {
    Route::get('/contact_us', [App\Http\Controllers\ContactUsController::class, 'index'])->name('admin.contact.us');
    //delete contact us
    Route::get('/contact_us/delete/{id}', [App\Http\Controllers\ContactUsController::class, 'destroy'])->name('admin.contact.us.delete');


    //training session routes
    Route::get('/training-session', [App\Http\Controllers\TrainingSessionController::class, 'index'])->name('admin.training.session');
    Route::post('/training-session/store', [App\Http\Controllers\TrainingSessionController::class, 'store'])->name('admin.training.session.store');
    Route::get('/training-session/delete/{id}', [App\Http\Controllers\TrainingSessionController::class, 'destroy'])->name('admin.training.session.delete');
    Route::get('/training-session/change_status/{id}/{status}', [App\Http\Controllers\TrainingSessionController::class, 'updateStatus'])->name('admin.training.session.change_status');
    //get students by session id
    Route::get('/training-session/students/{id}', [App\Http\Controllers\TrainingSessionController::class, 'getStudentsBySessionId'])->name('admin.training.session.students');



    //student routes
    Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('admin.student.index');
    Route::get('/student/delete/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('admin.student.delete');
    Route::get('/student/change_payment_status/{id}', [App\Http\Controllers\StudentController::class, 'changePaymentStatus'])->name('admin.student.change_payment_status');
    Route::post('/student/reply', [App\Http\Controllers\StudentController::class, 'replyToStudent'])->name('admin.student.reply');


    //service routes
    Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('admin.service.index');
    Route::post('/services/store', [App\Http\Controllers\ServiceController::class, 'store'])->name('admin.service.store');
    Route::get('/service/delete/{id}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('admin.service.delete');
    Route::post('/service/update/{id}', [App\Http\Controllers\ServiceController::class, 'update'])->name('admin.service.update');

    //partner routes
    Route::get('/partners', [App\Http\Controllers\PartnerController::class, 'index'])->name('admin.partner.index');
    Route::post('/partners/store', [App\Http\Controllers\PartnerController::class, 'store'])->name('admin.partner.store');
    Route::get('/partner/delete/{id}', [App\Http\Controllers\PartnerController::class, 'destroy'])->name('admin.partner.delete');


    Route::get('/trending', [App\Http\Controllers\PartnerController::class, 'index'])->name('admin.trending.index');

   });
