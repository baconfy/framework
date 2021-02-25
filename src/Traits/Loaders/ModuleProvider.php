<?php

namespace Baconfy\Traits\Loaders;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    use Autoload;

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \ReflectionException
     */
    public function boot()
    {
        $this->moduleLoaders();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->defaultLoaders();
    }
}
