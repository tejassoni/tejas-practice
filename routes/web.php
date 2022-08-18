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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/profile-view', [App\Http\Controllers\UserController::class, 'profile_view']);
Route::post('/profile-update-submit', [App\Http\Controllers\UserController::class, 'profile_update']);

// Single File Handling
Route::get('/file-upload', [App\Http\Controllers\FileHandlingController::class, 'loadSingleFileView']);
Route::post('/file-upload-submit', [App\Http\Controllers\FileHandlingController::class, 'submitSingleFileUpload']);

// Multiple File Handling
Route::get('/multi-file-upload', [App\Http\Controllers\FileHandlingController::class, 'loadMultipleFileView']);
Route::post('/multifile-upload-submit', [App\Http\Controllers\FileHandlingController::class, 'submitMultipleFileUpload']);

// Email Send Example
Route::get('/send-email', [App\Http\Controllers\EmailController::class, 'sendEmail']);

// Email Send With Attachment Example
Route::get('/send-email-attachment', [App\Http\Controllers\EmailController::class, 'sendEmailWithAttachment']);


// Update Password Example
Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'viewChangePassword']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
