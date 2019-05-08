<?php
/**
 * Created by PhpStorm.
 * User: qian
 * Date: 2019/3/29
 * Time: 16:30
 */

use Illuminate\Support\Facades\Route;
use Aen233\IUSDK\Http\Middleware\Indev;

Route::namespace('Aen233\IUSDK\Http\Handlers')->middleware(Indev::class)->group(function () {
    Route::get('doc/{name?}', ['uses' => DocHandler::class]);
    Route::get('log', ['uses' => LogHandler::class]);
    Route::get('info', ['uses' => InfoHandler::class]);
    Route::get('db', ['uses' => DBHandler::class]);
    Route::get('redis', ['uses' => RedisHandler::class]);
});
