<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogHandler
{
    /**
     * @param Request $request
     * @param string  $module
     *
     * @return array|string
     */
    public function __invoke(Request $request)
    {
        $file = empty($request->get('file')) ? date('Y/m/d') . '.log' : $request->get('file');

        $file = storage_path('logs/' . $file);

        if (!file_exists($file)) {
            return '日志不存在';
        }

        $data = file_get_contents($file);

        return view('iu-sdk::log')
            ->with('file', $file)
            ->with('data', $data);
    }
}
