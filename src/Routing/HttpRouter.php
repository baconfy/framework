<?php

namespace Baconfy\Routing;

use Illuminate\Contracts\Routing\Registrar as Router;

abstract class HttpRouter
{
    /**
     * Router middlewares
     *
     * @var array
     */
    protected $middlewares = [];

    /**
     * @param Router $router
     * @return mixed
     */
    abstract public function map(Router $router);

    /**
     * @param array $middlewares
     * @return array
     */
    public function getMiddlewares($middlewares = []): array
    {
        $middlewares = !is_array($middlewares) ? [$middlewares] : $middlewares;

        return array_merge($middlewares, $this->middlewares);
    }
}
