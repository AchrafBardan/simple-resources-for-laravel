<?php

namespace AchrafBardan\SimpleResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ResourceFactory
{
    /**
     * The default resource class.
     *
     * @var string
     */
    public static $defaultResourceClass = JsonResource::class;

    /**
     * The resource name resolver.
     *
     * @var callable
     */
    protected static $resourceNameResolver;

    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  bool  $isPlural
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *         | \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *         | \Illuminate\Pagination\AbstractPaginator
     *
     * @throws \Exception
     */
    public function make($model, $isPlural = null, ...$args)
    {
        // Return the model directly if it is invalid.
        if (is_null($model) || $model instanceof MissingValue) {
            return $model;
        }

        // Check if the model is plural (a collection or paginated).
        $isPlural = $isPlural
            ?? ($model instanceof Collection || $model instanceof AbstractPaginator);

        $modelClass = $this->getModelClass($model, $isPlural);

        $resourceClass = $this->resolveResourceName($modelClass);

        // Based on the model's plurality, make the correct resource.
        if (! $isPlural) {
            $resource = new $resourceClass($model, ...$args);
        } else {
            $resource = $resourceClass::collection($model);
        }

        // If the model is paginated, we return `AbstractPaginator` instance
        // with the resource as its collection.
        if ($model instanceof AbstractPaginator) {
            return $model->setCollection($resource->collection);
        }

        return $resource;
    }

    /**
     * Get the class of the specified model.
     *
     * @param  mixed  $model
     * @param  bool  $isPlural
     * @return string
     */
    public function getModelClass($model, $isPlural = false)
    {
        if (is_null($model) || ! is_object($model)) {
            return ResourceModel::class;
        }

        if ($isPlural) {
            if (count($model) == 0) {
                return ResourceModel::class;
            } else {
                $model = Arr::first($model);
            }
        }

        return is_object($model)
            ? get_class($model)
            : ResourceModel::class;
    }

    /**
     * Get the resource class by model name.
     *
     * @return mixed
     */
    public static function resolveResourceName(string $modelName): string
    {
        if (config('simple-resources.guess_resource_name') && is_callable(static::$resourceNameResolver)) {
            $resolver = (static::$resourceNameResolver);
        }

        return $resolver($modelName);
    }

    /**
     * Set the function that resolves the resource name.
     *
     * @param  callable(class-string<\Illuminate\Database\Eloquent\Model>): class-string<\Illuminate\Database\Eloquent\Factories\Factory>  $resolver
     * @return void
     */
    public static function guessResourceNameUsing(callable $resolver)
    {
        static::$resourceNameResolver = $resolver;
    }
}
