<?php

namespace Aen233\IUSDK\Http\Handlers;

class InfoHandler
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function __invoke()
    {
        echo phpinfo();
    }
}
