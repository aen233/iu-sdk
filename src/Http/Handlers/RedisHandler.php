<?php

namespace Aen233\IUSDK\Http\Handlers;

use Illuminate\Support\Facades\Redis;

class RedisHandler
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function __invoke()
    {
        Redis::set('name', 'aen233');
        $values = Redis::get('name');
        dd($values);
    }
}
