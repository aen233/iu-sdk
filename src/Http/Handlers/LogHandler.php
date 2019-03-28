<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogHandler
{
    public function __invoke(Request $request, $module)
    {
        // 如果是开发环境才输出日志
        if (app()->environment('local', 'dev')) {
            $module = Str::title($module);
            $file = empty($request->get('file')) ? date('Y/m/d') . '.log' : $request->get('file');
            $file = base_path('modules/' . $module . '/Logs/'. $file);

            if (!file_exists($file)) {
                return '日志不存在';
            }

            $data = file_get_contents($file);

            return view('log')
                ->with('modules', $module)
                ->with('file', $file)
                ->with('data', $data);
        }
    }
}
