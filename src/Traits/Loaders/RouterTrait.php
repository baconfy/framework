<?php

namespace Baconfy\Traits\Loaders;

use Baconfy\Exception\RouterMapException;
use File;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

trait RouterTrait
{
    /**
     * Map routes for api and web
     */
    public function map()
    {
        try {
            $this->loadModuleRoutes('Ui/Api/Routes', 'api');
            $this->loadModuleRoutes('Ui/Web/Routes', 'web');
        } catch (\ReflectionException $e) {
            throw new RouterMapException;
        }
    }

    /**
     * @param string $directory
     * @param string $type
     * @return void
     */
    private function loadModuleRoutes(string $directory, string $type)
    {
        // Get module directory
        $directory = $this->getClassDirectory($directory);

        // Namespace definition
        $controllers = sprintf('%s\\Ui\\%s\\%s', $this->namespace, ucfirst($type), 'Controllers');
        $routes = sprintf('%s\\Ui\\%s\\%s', $this->namespace, ucfirst($type), 'Routes');

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                $class = $this->app->make("{$routes}\\{$file->getBasename('.php')}");
                $middlewares = $class->getMiddlewares($type);

                Route::group(['namespace' => $controllers, 'middleware' => $middlewares], function (Registrar $router) use ($file, $class) {
                    $class->map($router);
                });
            }
        }
    }
}