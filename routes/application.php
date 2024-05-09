<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'Auth',], function () {

    Route::post('login', [App\Http\Controllers\Application\Authcontroller::class,'login']);
    Route::post('register', [App\Http\Controllers\Application\Authcontroller::class,'register']);
    Route::post('logout', [App\Http\Controllers\Application\Authcontroller::class,'logout']);
    Route::post('delete', [App\Http\Controllers\Application\Authcontroller::class,'delete']);

              //////////////PassWord//////////
    Route::post('forgot-password', [App\Http\Controllers\Application\Authcontroller::class,'ForgotPassword']);
    Route::post('check-password', [App\Http\Controllers\Application\Authcontroller::class,'CodeCheck']);
    Route::post('reset', [App\Http\Controllers\Application\Authcontroller::class,'Reset']);

    Route::get('userinfo', [App\Http\Controllers\Application\Authcontroller::class,'userinfo']);

});

    Route::get('sections',[App\Http\Controllers\Application\MainController::class,'Sections']);
    Route::get('Activities',[App\Http\Controllers\Application\MainController::class,'Courses']);
    Route::get('profile',[App\Http\Controllers\Application\MainController::class,'Profile']);

    route::get('SectionBody/{name}',[App\Http\Controllers\Application\MainController::class,'SectionBody']);
    route::post('feedback',[App\Http\Controllers\Application\MainController::class,'feedback']);

    route::get('chooseCourse/{id}',[App\Http\Controllers\Application\MainController::class,'ChooseCourse']);

    // need
    route::post('need',[App\Http\Controllers\Application\NeedController::class,'store']);
    route::post('wanting',[App\Http\Controllers\Application\NeedController::class,'store_need']);
    route::get('index_need/{value}',[App\Http\Controllers\Application\NeedController::class,'index']);

    // select course to return all media have it
    route::get('select/{id}/{ids}',[App\Http\Controllers\Application\MainController::class,'selectCourse']);

    // for progress
    Route::post('/recordProgress',[App\Http\Controllers\Application\UserProgrssController::class,'recordProgress']);
    Route::get('/retrieveProgress',[App\Http\Controllers\Application\UserProgrssController::class,'retrieveProgress']);

    // for store result

    Route::post('/results', [App\Http\Controllers\Application\ResultController::class,'store']);









    Route::get('/test',function(){
        return "online";
    });

