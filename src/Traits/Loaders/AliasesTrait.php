<?php

namespace Baconfy\Traits\Loaders;

use Illuminate\Foundation\AliasLoader;

trait AliasesTrait
{
    /**
     * @void
     * @param array $aliases
     */
    protected function loadAliases(array $aliases)
    {
        foreach ($aliases as $alias => $class) {
            AliasLoader::getInstance()->alias($alias, $class);
        }
    }
}