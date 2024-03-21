# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

Weasley is a PHP package that provides generators, helpers, and utilities when writing [Slytherin](/slytherin/)-based applications.

## Installation

Install `Weasley` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/weasley
```

## Features

### Generators

Access the generator commands through `vendor/bin/weasley` in the terminal/command line. To know the more the arguments and options, include the option `--help` to the chosen command.

| Command | Description |
| ------- | ----------- |
| make:check | Creates a new check (validation) class based on [Valitron](https://github.com/vlucas/valitron). |
| make:handler | Creates a new [Slytherin Middleware](https://github.com/rougin/slytherin/wiki/Middleware) class. |
| make:package | Creates a new [Slytherin Integration](https://github.com/rougin/slytherin/wiki/IntegrationInterface-Implementation) class. |
| make:route | Creates a new HTTP route class. |

### HTTP Routes

| Controller | Description |
| ---------- | ----------- |
| [HttpRoute](https://github.com/rougin/weasley/blob/master/src/Routes/HttpRoute.php) | A simple HTTP route class for RESTful APIs. |
| [JsonRoute](https://github.com/rougin/weasley/blob/master/src/Routes/JsonRoute.php) | Provides methods for RESTful APIs in [JSON](https://en.wikipedia.org/wiki/JSON) format. |

**NOTE**: In other PHP frameworks, this is also known as `Controllers`.

### Integrations

| Integration | Description |
| ----------- | ----------- |
| [SessionIntegration](https://github.com/rougin/weasley/blob/master/src/Session/SessionIntegration.php) | An implementation of [SessionHandlerInterface](https://secure.php.net/manual/en/class.sessionhandlerinterface.php). |

#### Illuminate (Laravel's individual components)

| Integration | Description |
| ----------- | ----------- |
| [DatabaseIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/DatabaseIntegration.php) | Based on [illuminate/database](https://github.com/illuminate/database) ([Eloquent](https://laravel.com/docs/5.4/eloquent)). |
| [PaginationIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/PaginationIntegration.php) | Based on [illuminate/pagination](https://github.com/illuminate/pagination). |
| [ViewIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/ViewIntegration.php) | Based on [illuminate/view](https://github.com/illuminate/view) ([Blade](https://laravel.com/docs/5.4/blade)). |

**NOTE**: The mentioned integrations above needs to include their required dependencies first.

### HTTP Middlewares

| Middleware | Description |
| ---------- | ----------- |
| [CrossOriginHeaders](https://github.com/rougin/weasley/blob/master/src/Middleware/CrossOriginHeaders.php) | Adds additional headers for [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing). |
| [EmptyStringToNull](https://github.com/rougin/weasley/blob/master/src/Middleware/EmptyStringToNull.php) | Converts the empty strings from request as `null`. |
| [SpoofFormMethod](https://github.com/rougin/weasley/blob/master/src/Middleware/SpoofFormMethod.php) | Replaces the HTTP verb  from `_method` value. |
| [JsonHeaders](https://github.com/rougin/weasley/blob/master/src/Middleware/Json.php) | Changes content response to `application/json`. |
| [TrimString](https://github.com/rougin/weasley/blob/master/src/Middleware/TrimString.php) | Trims the strings from an incoming request. |

**NOTE**: All of the HTTP middlewares above are implemented in the `v0.4.1` of [PSR-15](https://github.com/http-interop/http-middleware/tree/0.4.1).

### Validation

Weasley also provides a validation class on top of [Valitron](https://github.com/vlucas/valitron). Kindly create a class that extends to the `Check` class:

``` php
use Rougin\Weasley\Check;

class UserCheck extends Check
{
    protected $labels =
    [
        'name' => 'Name',
        'email' => 'Email',
        'age' => 'Age',
    ];

    protected $rules =
    [
        'name' => 'required',
        'setting' => 'required|email',
        'type' => 'required|numeric',
    ];
}
```

Once created, the data can be submitted to the said class for validation:

``` php
$check = new UserCheck;

$data = /* e.g., data from request */;

if ($check->valid($data))
{
  // $data passed from validation
}
else
{
  // Get the available errors ---
  $errors = $check->errors();
  // ----------------------------

  // Or get the first error only ---
  echo $check->firstError();
  // -------------------------------
}
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/weasley/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/weasley?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/weasley.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/weasley.svg?style=flat-square

[link-build]: https://github.com/rougin/weasley/actions
[link-changelog]: https://github.com/rougin/weasley/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/weasley/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/weasley
[link-downloads]: https://packagist.org/packages/rougin/weasley
[link-license]: https://github.com/rougin/weasley/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/weasley