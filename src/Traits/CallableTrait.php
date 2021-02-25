<?php

namespace Baconfy\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

trait CallableTrait
{
    /**
     * @var array
     */
    protected $beforeMethods = [];

    /**
     * @return mixed
     */
    public function call()
    {
        list($class, $arguments) = $this->parseArguments(func_get_args());

        $class = App::make($class);
        $this->callBeforeMethods($class);

        return $class->handle(...$arguments);
    }

    /**
     * @return mixed
     */
    public function callOrFail()
    {
        if (!$result = call_user_func_array([$this, 'call'], func_get_args())) {
            throw new InvalidCallException;
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function transactionalCall()
    {
        $arguments = func_get_args();

        return DB::transaction(function () use ($arguments) {
            return call_user_func_array([$this, 'call'], $arguments);
        });
    }

    /**
     * @param $class
     */
    private function callBeforeMethods($class)
    {
        foreach ($this->beforeMethods as $method => $arguments) {
            $class->{$method}(...$arguments);
        }

        $this->resetBeforeMethods();
    }

    /**
     * @param $method
     * @param $arguments
     * @return self
     */
    public function __call($method, $arguments)
    {
        $this->beforeMethods[$method] = $arguments;

        return $this;
    }

    /**
     * Reset before methods
     */
    private function resetBeforeMethods()
    {
        $this->beforeMethods = [];
    }

    /**
     * @param $arguments
     * @return array
     */
    private function parseArguments($arguments): array
    {
        $output = [$arguments[0]];
        unset($arguments[0]);

        $output[1] = $arguments;

        return $output;
    }
}