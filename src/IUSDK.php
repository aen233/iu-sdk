<?php

namespace Aen233\IUSDK;

use Aen233\IUSDK\Http\Handlers\DocHandler;
use Aen233\IUSDK\Http\Handlers\LogHandler;
use Illuminate\Support\Facades\Route;

class IUSDK
{
    public static function routes()
    {
        Route::get('{modules}/doc/{name}', ['uses' => DocHandler::class]);
        Route::get('{modules}/log', ['uses' => LogHandler::class]);
    }
}
