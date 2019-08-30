# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Weasley is a PHP package that provides generators, helpers, and utilities for rapid prototyping of [Slytherin](/slytherin/)-based applications. Might be useful for developing Slytherin-based applications with a time constraint.

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
| make:controller | Creates a new HTTP controller class |
| make:integration | Creates a new [Slytherin Integration](https://github.com/rougin/slytherin/blob/master/src/Integration/IntegrationInterface.php) class |
| make:middleware | Creates a new `v0.4.1` of [PSR-15](https://github.com/http-interop/http-middleware/tree/0.4.1) middleware class |
| make:validator | Creates a new validator class based on [Valitron](https://github.com/vlucas/valitron) |

### HTTP Controllers

| Controller | Description |
| ---------- | ----------- |
| [JsonController](https://github.com/rougin/weasley/blob/master/src/Controllers/JsonController.php) | Provides methods for RESTful APIs in [JSON](https://en.wikipedia.org/wiki/JSON) format |

### Integrations

| Integration | Description |
| ----------- | ----------- |
| [SessionIntegration](https://github.com/rougin/weasley/blob/master/src/Session/SessionIntegration.php) | An implementation of [SessionHandlerInterface](https://secure.php.net/manual/en/class.sessionhandlerinterface.php) |

#### Illuminate (Laravel's individual components)

| Integration | Description |
| ----------- | ----------- |
| [DatabaseIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/DatabaseIntegration.php) | Based on [illuminate/database](https://github.com/illuminate/database) ([Eloquent](https://laravel.com/docs/5.4/eloquent)) |
| [PaginationIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/PaginationIntegration.php) | Based on [illuminate/pagination](https://github.com/illuminate/pagination) |
| [ViewIntegration](https://github.com/rougin/weasley/blob/master/src/Illuminate/ViewIntegration.php) | Based on [illuminate/view](https://github.com/illuminate/view) ([Blade](https://laravel.com/docs/5.4/blade)) |

**NOTE**: The mentioned integrations above needs to include their required dependencies first.

### HTTP Middlewares

| Middleware | Description |
| ---------- | ----------- |
| [CrossOriginHeaders](https://github.com/rougin/weasley/blob/master/src/Middleware/CrossOriginHeaders.php) | Adds additional headers for [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) |
| [EmptyStringToNull](https://github.com/rougin/weasley/blob/master/src/Middleware/EmptyStringToNull.php) | Converts the empty strings from request as `null` |
| [SpoofFormMethod](https://github.com/rougin/weasley/blob/master/src/Middleware/SpoofFormMethod.php) | Replaces the HTTP verb  from `_method` value |
| [JsonHeaders](https://github.com/rougin/weasley/blob/master/src/Middleware/Json.php) | Changes content response to `application/json` |
| [TrimString](https://github.com/rougin/weasley/blob/master/src/Middleware/TrimString.php) | Trims the strings from an incoming request |

**NOTE**: All of the HTTP middlewares above are implemented in the `v0.4.1` of [PSR-15](https://github.com/http-interop/http-middleware/tree/0.4.1).

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

[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/weasley.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/weasley.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/weasley.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/weasley/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/weasley.svg?style=flat-square

[link-changelog]: https://github.com/rougin/weasley/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/weasley
[link-contributors]: https://github.com/rougin/weasley/contributors
[link-downloads]: https://packagist.org/packages/rougin/weasley
[link-license]: https://github.com/rougin/weasley/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/weasley
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/weasley/code-structure
[link-travis]: https://travis-ci.org/rougin/weasley