<?php

namespace Aen233\IUSDK\Http\Handlers;

class DBHandler
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function __invoke()
    {
        return \App\Models\User::first();
    }
}
