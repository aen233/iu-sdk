<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Support\Str;
use Parsedown;

class DocHandler
{
    /**
     * @param string $module
     * @param string $name
     *
     * @return array
     */
    public function __invoke($module = 'module', $name = 'index')
    {
        // 仅开发环境可以访问
        if (!app()->environment('local', 'dev')) {
            return ['version' => '0.0.1'];
        }

        if (in_array($module, ['module', 'index'])) {
            unset($module);
            $doc    = storage_path('doc/');
            $docUrl = 'doc/';
        } else {
            $doc    = base_path('modules/' . Str::title($module) . '/Doc/');
            $docUrl = $module . '/doc/';
        }

        if ($name === 'index') {
            $docPath = $doc . 'readme.md';
        } else {
            $name    = urldecode($name);
            $name    = str_replace('-', '/', $name);
            $docPath = $doc . $name;
        }

        $config = file_get_contents($doc . 'config.json');
        $config = json_decode($config, true);

        $parseDown = new Parsedown();
        $html      = $parseDown->text(file_get_contents($docPath));

        return view('iu-sdk.doc')
            ->with('doc', $doc)
            ->with('docUrl', $docUrl)
            ->with('html', $html)
            ->with('config', $config);
    }
}
