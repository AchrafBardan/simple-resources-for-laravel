# Simple resources for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/AchrafBardan/simple-resources.svg?style=flat-square)](https://packagist.org/packages/achrafbardan/simple-resources)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/AchrafBardan/simple-resources-for-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/AchrafBardan/simple-resources-for-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/AchrafBardan/simple-resources.svg?style=flat-square)](https://packagist.org/packages/achrafbardan/simple-resources)

This is a small package that simplifies resource usage. It is used to auto guess and link resources to models. Paginated collections are also auto wrappable in the resource.

## Installation

You can install the package via composer:

```bash
composer require AchrafBardan/simple-resources-for-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="simple-resources-for-laravel-config"
```

This is the contents of the published config file:

```php
return [
    "model_namespace" => "App\\Models",
    "resource_namespace" => "App\\Http\\Resources",

    /**
     * When this is set to false, you have to add the \AchrafBardan\SimpleResources\Contracts\HasResource interface to your models.
     * When set to true you can still optionally add the interface to your models, this interface will than be used instead of the guesser.
     */
    "guess_resource" => true
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="simple-resources-for-laravel-views"
```

## Usage

Before returning a model or collection you pass it trough the ResourceFactory. The resource factory finds the resource for your model, collection or even a paginated collection.

```php
use AchrafBardan\SimpleResources\ResourceFactory;
...
$resource = ResourceFactory::make($model);
return response()->json($resource);
```
You can also use the helper function `resource` which is the same as `ResourceFactory::make`
```php
use function AchrafBardan\SimpleResources\resource;
...
$resource = resource($model);
return response()->json($resource);
```
It also intended to be used inside a resource for child models and collections, see the following example.
```php
// App/Http/Resources/TestResource.php
...
class TestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'child' => resource($this->whenLoaded('child'))
        ];
    }
}
```
## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Achraf Bardan](https://github.com/AchrafBardan)
- [OWOW Agency](https://github.com/owowagency)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
