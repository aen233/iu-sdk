<?php

namespace Aen233\IUSDK\Http\Middleware;

use Closure;

class Indev
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return array|mixed
     */
    public function handle($request, Closure $next)
    {
        // 仅开发环境可以访问
        if (!app()->environment('local', 'dev')) {
            return ['version' => '0.0.1'];
        }

        return $next($request);
    }
}
