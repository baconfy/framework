<?php

namespace Baconfy\Traits\Loaders;

use Baconfy\Traits\ReflectionTrait;

trait Autoload
{
    use ReflectionTrait, AliasesTrait, ConfigurationTrait, ConsoleTrait,
        FactoriesTrait, LanguagesTrait, MigrationsTrait,
        ProvidersTrait, RouterTrait, ViewsTrait;

    /**
     * @return void
     */
    private function defaultLoaders()
    {
        if (isset($this->aliases) && is_array($this->aliases)) {
            $this->loadAliases($this->aliases);
        }

        if (isset($this->providers) && is_array($this->providers)) {
            $this->loadProviders($this->providers);
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function moduleLoaders()
    {
        // Load configurations
        $this->loadModuleConfiguration('Configs');

        // Load database
        $this->loadModuleFactories('Data/Factories');
        $this->loadModuleMigrations('Data/Migrations');

        // Load languages
        $this->loadModuleLanguages('Resources/Languages');

        // Load routes
        $this->loadModuleRoutes('Ui/Api/Routes', 'api');
        $this->loadModuleRoutes('Ui/Web/Routes', 'web');

        // Load commands
        $this->loadModuleCommands('Ui/Console/Routes');

        // Load views
        $this->loadModuleViews('Ui/Web/Views');
    }
}
