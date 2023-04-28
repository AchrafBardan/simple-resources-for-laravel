<?php

namespace AchrafBardan\SimpleResources;

if (! function_exists(__NAMESPACE__.'/resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  bool  $isPlural
     * @return mixed
     */
    function resource($model, $isPlural = null, ...$args)
    {
        return (new ResourceFactory)->make($model, $isPlural, ...$args);
    }
}
