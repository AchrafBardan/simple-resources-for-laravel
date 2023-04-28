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
}
