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
    public function __invoke(Request $request, $module = '')
    {
        // 仅开发环境可以访问
        if (!app()->environment('local', 'dev')) {
            return ['version' => '0.0.1'];
        }

        $file = empty($request->get('file')) ? date('Y/m/d') . '.log' : $request->get('file');

        if (!in_array(Str::title($module), getModules())) {
            $file = storage_path('logs/' . $file);
        } else {
            $file = base_path('modules/' . Str::title($module) . '/Logs/' . $file);
        }

        if (!file_exists($file)) {
            return '日志不存在';
        }

        $data = file_get_contents($file);

        return view('iu-sdk::log')
            ->with('file', $file)
            ->with('data', $data);
    }
}
