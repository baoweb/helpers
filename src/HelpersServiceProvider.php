<?php

namespace Baoweb\Helpers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'baoweb');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'baoweb');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }


        Builder::macro('search', function ($fields, $string) {

            if(is_array($fields) && $string) {
                $this->where(function($query) use ($fields, $string) {
                    $firstIteration = true;

                    foreach($fields as $field) {
                        if($firstIteration) {
                            $query->where($field, 'like', '%'.$string.'%');
                        } else {
                            $query->orWhere($field, 'like', '%'.$string.'%');
                        }

                        $firstIteration = false;
                    }
                });

                return $this;
            }

            if($string) {
                return $this->where($fields, 'like', '%'.$string.'%');
            }

            return $this;
        });

        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/helpers.php', 'helpers');

        // Register the service the package provides.
        $this->app->singleton('helpers', function ($app) {
            return new Helpers;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['helpers'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/helpers.php' => config_path('helpers.php'),
        ], 'helpers.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/baoweb'),
        ], 'helpers.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/baoweb'),
        ], 'helpers.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/baoweb'),
        ], 'helpers.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
