<?php

namespace Aen233\IUSDK;

use Aen233\IUSDK\Http\Middleware\Access;
use Aen233\IUSDK\Http\Middleware\After;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class IUSDKServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/iu-sdk', 'iu-sdk'); // 视图目录指定
        //注册扩展包路由，使用php artisan route:list 命令可以查看是否生效
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->registerMiddle();

        $this->publishes([
            __DIR__ . '/../storage/doc' => base_path('storage/doc'),  // 发布doc demo 到 laravel的 storage 下
//            __DIR__ . '/../resources/views/iu-sdk' => base_path('resources/views/iu-sdk'),  // 发布视图目录到resources 下
//            __DIR__ . '/../config/error_code.php'      => config_path('error_code.php'), // 发布配置文件到 laravel 的config 下
        ]);
    }

    public function registerMiddle()
    {
        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(Access::class);
        $kernel->pushMiddleware(After::class);

        return $kernel;
    }

}
