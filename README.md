![Soyhuce](https://soyhuce.fr/wp-content/uploads/2020/06/logo-soyhuce-dark-1.png "Soyhuce")

# Empty Laravel collections correctly understood by PHPStan

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soyhuce/empty-collection.svg?style=flat-square)](https://packagist.org/packages/soyhuce/empty-collection)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/soyhuce/empty-collection/tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/soyhuce/empty-collection.svg?style=flat-square)](https://packagist.org/packages/soyhuce/empty-collection)


## Installation

You can install the package via composer:

```bash
composer require soyhuce/empty-collection
```

Add the provided PHPStan extension in your PHPStan configuration:
```yaml
includes:
  - ./vendor/soyhuce/empty-collection/extension.neon
```

This package does not require `phpstan/phpstan` to be installed in order to keep it in your dev dependencies.
Be sure to use version `1.4.6` or higher.

## Usage

Have you ever had some issue with incorrectly typed empty collections in Laravel ?
Have you ever seen these PHPStan errors ?
```txt
Property App\Service\MyService::$items (Illuminate\Support\Collection<int, App\Service\Item>) does not accept Illuminate\Support\Collection<*NEVER*, *NEVER*>.
Unable to resolve the template type TKey in call to function collect
Unable to resolve the template type TValue in call to function collect
```

We get you covered !

This package provides an easy way to initialise empty collections, correctly typed for PHPStan.

Let's take an example:
```diff
class MyService {

    /**
     * @var \Illuminate\Support\Collection<int, App\Service\Item>
     */
    private Collection $items;

    public function __construct()
    {
-        $this->items = collect();
+        $this->items = empty_collection('int', Item::class);
    }
}
```
This way, PHPStan won't complain about the type of the collection.

### Available functions

#### `empty_collection(string $keyType, string $valueType) : \Illuminate\Support\Collection`

`$keyType` must be `'int'` or `'string'`.
`$valueType` must be some type PHPStan will understand.

Exemples: 
```php
empty_collection('int', 'int'); // Illuminate\Support\Collection<int, int>
empty_collection('int', 'string'); // Illuminate\Support\Collection<int, string>
empty_collection('string', 'array<string, bool>'); // Illuminate\Support\Collection<string, array<string, bool>>
empty_collection('string', Item::class); // Illuminate\Support\Collection<string, App\Service\Item>
```

#### `empty_eloquent_collection(string $keyType, string $valueType) : \Illuminate\Database\Eloquent\Collection`

`$keyType` must be `'int'` or `'string'`.
`$valueType` must be a class name.

Exemples:
```php
empty_eloquent_collection('int', User::class); // Illuminate\Database\Eloquent\Collection<int, App\Models\User>
empty_eloquent_collection('string', User::class); // Illuminate\Database\Eloquent\Collection<string, App\Models\User>
```

## Testing

Testing is done via PHPStan and can be run with

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
