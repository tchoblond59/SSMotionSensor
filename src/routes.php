<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 25/10/18
 * Time: 14:17
 */

Route::group(['middleware' => ['web']], function () {
    Route::get('/widget/ssmotion/infos/{id}', 'Tchoblond59\SSMotionSensor\Controllers\SSMotionSensorController@infos');
});