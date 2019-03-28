<?php

namespace Aen233\IUSDK\Http\Middleware;

use Closure;

class Access
{
    /**
     * 记录访问日志
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        if ($params['password'] ?? '') {
            $params['password'] = '********';
        }
        iuLog('debug', 'Request Url: ' . $request->url());
        iuLog('debug', 'Request Method: ' . $request->method());
        iuLog('debug', 'Request Params: ', $params);
        iuLog(PHP_EOL);

        return $next($request);
    }
}
