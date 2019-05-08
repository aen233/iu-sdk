<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Support\Str;
use Parsedown;

class DocHandler
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function __invoke($name = '')
    {
        $doc    = storage_path('doc/');
        $docUrl = 'doc/';

        if (empty($name) || $name == 'index') {
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

        return view('iu-sdk::doc')
            ->with('doc', $doc)
            ->with('docUrl', $docUrl)
            ->with('html', $html)
            ->with('config', $config);
    }
}
