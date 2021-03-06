<?php

namespace Palmbuy\Log\Provider;

use Illuminate\Support\ServiceProvider;

class RequestLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // if (!config('requestLog.enabled')) {
        //     return;
        // }
        //publish
        $this->publishes([
            __DIR__ . '/config/autoload/requestLog.php' => config_path('requestLog.php'),
        ]);
        // 加载数据迁移文件
        $this->loadMigrationsFrom(__DIR__ . '/Storage/migrations');
    }
}
