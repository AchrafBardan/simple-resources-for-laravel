<?php

namespace AchrafBardan\SimpleResources\Contracts;

interface HasResource
{
    /**
     * Get the resource class name for the model.
     */
    public function getResource(): string;
}
