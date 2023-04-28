<?php

namespace AchrafBardan\SimpleResources;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SimpleResourcesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('simple-resources')
            ->hasConfigFile();
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        ResourceFactory::guessResourceNameUsing(function (string $modelName) {
            $guess = sprintf(
                '%s\\%sResource',
                config('simple-resources.resource_namespace'),
                str_replace(config('simple-resources.model_namespace').'\\', '', $modelName),
            );

            if (class_exists($guess)) {
                return $guess;
            }

            return ResourceFactory::$defaultResourceClass;
        });
    }
}
