<?php

use Illuminate\Support\Facades\Route;

/**
 * Created by PhpStorm.
 * User: julien
 * Date: 25/10/18
 * Time: 14:17
 */

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/widget/ssmotion/infos/{id}', [\Tchoblond59\SSMotionSensor\Controllers\SSMotionSensorController::class, 'infos']);
});