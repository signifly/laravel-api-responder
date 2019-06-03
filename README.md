# API Responses for your Laravel API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/signifly/laravel-api-responder.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-api-responder)
[![Build Status](https://img.shields.io/travis/signifly/laravel-api-responder/master.svg?style=flat-square)](https://travis-ci.org/signifly/laravel-api-responder)
[![StyleCI](https://styleci.io/repos/188211079/shield?branch=master)](https://styleci.io/repos/188211079)
[![Quality Score](https://img.shields.io/scrutinizer/g/signifly/laravel-api-responder.svg?style=flat-square)](https://scrutinizer-ci.com/g/signifly/laravel-api-responder)
[![Total Downloads](https://img.shields.io/packagist/dt/signifly/laravel-api-responder.svg?style=flat-square)](https://packagist.org/packages/signifly/laravel-api-responder)

The `signifly/laravel-api-responder` package allows you to easily return API responses in your Laravel app.

Below is a small example of how to use it:

```php
use Signifly\Responder\Concerns\Respondable;

class ProductController extends Controller
{
    use Respondable;

    public function index()
    {
        $paginator = Product::paginate();

        return $this->respond($paginator);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return $this->respond($product->fresh())
            ->setStatusCode(201); // responds with a 201 status code
    }

    public function show(Product $product)
    {
        return $this->respond($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->respond($product); // return an empty 204 json response
    }
}
```

It will automatically resolve resources for the provided data if they exist.


## Documentation

To get started follow the installation instructions below.

## Installation

You can install the package via composer:

```bash
composer require signifly/laravel-api-responder
```

The package will automatically register itself.

You can optionally publish the config file with:
```bash
php artisan vendor:publish --tag="responder-config"
```

This is the contents of the published config file:

```php
return [

    /*
     * The namespace to use when resolving resources.
     */
    'namespace' => 'App\\Http\\Resources',

    /*
     * Force the usage of resources.
     * 
     * It will throw a ResourceNotFoundException 
     * if it does not resolve a resource.
     */
    'force_resources' => false,

    /*
     * Indicates if the resources uses a naming convention with a type suffix.
     * 
     * If it is set to true it will try to resolve `UserResource`.
     */
    'use_type_suffix' => false,
    
];
```

## Usage

The responder can be used in several ways.

### Using the Facade

```php
use Signifly\Responder\Facades\Responder;

class ProductController
{
    public function show(Product $product)
    {
        return Responder::respond($product);
    }
}
```

### Using the Trait

```php
use Signifly\Responder\Concerns\Respondable;

class ProductController
{
    use Respondable;

    public function show(Product $product)
    {
        return $this->respond($product);
    }
}
```

### Using the Service Container

```php
use Signifly\Responder\Contracts\Responder;

class ProductController
{
    public function show(Product $product, Responder $responder)
    {
        return $responder->respond($product);
    }
}
```

### Custom response codes

You can set the status code of the response by using the `setStatusCode` method on the response from the responder.

```php
return Responder::respond($data)
    ->setStatusCode(201);
```

### Forcing the usage of API resources

If you want to force the usage of API resources, you have to set the `responder.force_resources` option to `true` in the config file.

When set to true it will throw a `ResourceNotFoundException` if a resource for the associated model could not be found.

## Testing
```bash
composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
