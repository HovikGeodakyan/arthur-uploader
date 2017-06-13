<?php namespace Arthur\Uploader;

use Arthur\Uploader\Console\MakeUploaderCommand;
use Illuminate\Support\ServiceProvider;

class UploaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => app()->basePath() . '/config/uploader.php',
        ]);

        // Register migrations
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        // Register commands
        $this->commands('command.make.uploader');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('uploader', function ($app) {
            return new Uploader();
        });

        $this->app->alias('uploader', 'Arthur\Uploader\Uploader');

        $this->app->singleton('command.make.uploader', function ($app) {
            return new MakeUploaderCommand();
        });
    }
}
