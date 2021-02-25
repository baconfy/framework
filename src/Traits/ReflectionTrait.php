<?php

namespace Baconfy\Traits;

use ReflectionClass;
use File;
use ReflectionException;
use Symfony\Component\Finder\SplFileInfo;

trait ReflectionTrait
{
    /**
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function getClass(): ReflectionClass
    {
        return new ReflectionClass($this);
    }

    /**
     * @param string $append
     * @return string
     * @throws ReflectionException
     */
    public function getClassDirectory(string $append = ''): string
    {
        $dirname = File::dirname($this->getClass()->getFileName());

        return $dirname . ($append ? DIRECTORY_SEPARATOR . $append : $append);
    }
}