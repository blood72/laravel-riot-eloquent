<?php

namespace Blood72\Riot;

use Illuminate\Support\ServiceProvider;

class RiotEloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateRiotTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__ . '/../migrations/create_riot_tables.php.stub'
                        => database_path('migrations/'.$timestamp.'_create_riot_tables.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__ . '/../config/riot-eloquent.php' => config_path('riot-eloquent.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/riot-eloquent.php', 'riot-eloquent');
    }
}
