<?php

namespace Aen233\IUSDK;

use Illuminate\Support\ServiceProvider;

class IUSDKServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/iu-sdk', 'iu-sdk'); // 视图目录指定
        //注册扩展包路由，使用php artisan route:list 命令可以查看是否生效
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        $this->publishes([
            __DIR__ . '/../resources/views/iu-sdk' => base_path('resources/views/iu-sdk'),  // 发布视图目录到resources 下
//            __DIR__ . '/../config/routes.php'      => config_path('routes.php'), // 发布配置文件到 laravel 的config 下
        ]);
    }
}
