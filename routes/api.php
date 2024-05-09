<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller\Authentication;
use App\Http\Controllers\Authcontroller\AuthenticationAdmin;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'Auth_admin'
], function () {
    Route::post('register', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'register'])->name('register');
    Route::post('login', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'login'])->name('login');
    Route::post('logout', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'logout'])->middleware('auth:sanctum');
    Route::post('delete', [App\Http\Controllers\Authcontroller\AuthenticationAdmin::class, 'delete'])->middleware('auth:sanctum');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('profile', App\Http\Controllers\ProfileController::class);
    Route::post('update_photo_profile/{profile}', [App\Http\Controllers\ProfileController::class, 'update_photo_profile']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('section', App\Http\Controllers\SectionController::class);
    Route::post('update_photo_section/{section}', [App\Http\Controllers\SectionController::class, 'update_photo_section']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('activity', App\Http\Controllers\ActivityController::class);
    Route::get('get_activity/{id}', [App\Http\Controllers\ActivityController::class, 'get_activity']);
    Route::post('update_photo_activity/{activity}', [App\Http\Controllers\ActivityController::class, 'update_photo_activity']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('n_course', App\Http\Controllers\NCourseController::class);
    Route::get('get_n_course/{id}', [App\Http\Controllers\NCourseController::class, 'get_n_course']);
    // Route::Post('store_n_course/{value}', [App\Http\Controllers\NCourseController::class, 'store_n_course']);
    Route::post('update_photo_voice_n_Course/{n_course}', [App\Http\Controllers\NCourseController::class, 'update_photo_voice_n_Course']);
});
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('store', [App\Http\Controllers\Application\NeedController::class, 'store']);
    }
);

Route::get('feedbacks', [App\Http\Controllers\FeedBackController::class, 'getallFeedBacks'])
    // ->middleware('AdminLogin:sanctum');
;
