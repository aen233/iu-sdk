<?php

namespace Aen233\IUSDK;

use Aen233\IUSDK\Http\Middleware\Access;
use Aen233\IUSDK\Http\Middleware\After;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class IUSDKServiceProvider extends ServiceProvider
{
    const IUSDK_MIDDLEWARE_GROUPS = [
        Access::class,
        After::class
    ];

    const IUSDK_ROUTE_MIDDLEWARE = [
        'access' => Access::class,
        'after'  => After::class
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/iu-sdk', 'iu-sdk'); // 视图目录指定
        //注册扩展包路由，使用php artisan route:list 命令可以查看是否生效
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->registerMiddle();

        $this->publishes([
            __DIR__ . '/../resources/views/iu-sdk' => base_path('resources/views/iu-sdk'),  // 发布视图目录到resources 下
            // __DIR__ . '/../config/routes.php'      => config_path('routes.php'), // 发布配置文件到 laravel 的config 下
        ]);
    }

    public function registerMiddle()
    {
        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);

        $kernel->routeMiddleware = array_merge($kernel->routeMiddleware, self::IUSDK_ROUTE_MIDDLEWARE);
        $kernel->middlewareGroups['web'] = array_merge($kernel->middlewareGroups['web'], self::IUSDK_MIDDLEWARE_GROUPS);
        $kernel->middlewareGroups['api'] = array_merge($kernel->middlewareGroups['api'], self::IUSDK_MIDDLEWARE_GROUPS);

        return $kernel;
    }

}
