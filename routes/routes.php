<?php
/**
 * Created by PhpStorm.
 * User: qian
 * Date: 2019/3/29
 * Time: 16:30
 */

use Aen233\IUSDK\Http\Handlers\DocHandler;
use Aen233\IUSDK\Http\Handlers\LogHandler;
use Illuminate\Support\Facades\Route;

Route::get('doc/{module?}/{name?}', ['uses' => DocHandler::class]);
Route::get('{modules}/doc/{name?}', ['uses' => DocHandler::class]);
Route::get('log/{module?}', ['uses' => LogHandler::class]);
Route::get('{modules}/log', ['uses' => LogHandler::class]);
