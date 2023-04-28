<?php

// config for AchrafBardan/SimpleResources
return [
    'model_namespace' => 'App\\Models',
    'resource_namespace' => 'App\\Http\\Resources',

    /**
     * When this is set to false, you have to add the \AchrafBardan\SimpleResources\Contracts\HasResource interface to your models.
     * When set to true you can still optionally add the interface to your models, this interface will than be used instead of the guesser.
     */
    'guess_resource_name' => true,
];
