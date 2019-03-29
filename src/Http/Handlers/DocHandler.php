<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Support\Str;
use Parsedown;

class DocHandler
{
    public function __invoke($module, $name)
    {
        // 仅开发环境可以访问
        if (!app()->environment('local', 'dev')) {
            return ['blank'];
        }

        $doc = base_path('modules/' . Str::title($module) . '/Doc/');

        $config = file_get_contents($doc . 'config.json');
        $config = json_decode($config, true);

        if ($name === 'index') {
            $docPath = $doc . 'readme.md';
        } else {
            $name    = urldecode($name);
            $name    = str_replace('-', '/', $name);
            $docPath = $doc . $name;
        }

        $parseDown = new Parsedown();
        $html      = $parseDown->text(file_get_contents($docPath));

        return view('iu-sdk.doc')
            ->with('doc', $doc)
            ->with('module', $module)
            ->with('html', $html)
            ->with('config', $config);
    }
}
