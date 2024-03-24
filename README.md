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

### Packages

The following classes below are using the [`IntegrationInterface`](https://github.com/rougin/slytherin/wiki/IntegrationInterface-Implementation) from Slytherin:

| Package | Description |
| ----------- | ----------- |
| [Laravel/Eloquent](https://github.com/rougin/weasley/blob/master/src/Packages/Laravel/Eloquent.php) | Based on the [illuminate/database](https://github.com/illuminate/database) ([Eloquent](https://laravel.com/docs/11.x/eloquent)). |
| [Laravel/Blade](https://github.com/rougin/weasley/blob/master/src/Packages/Laravel/Blade.php) | Based on the [illuminate/view](https://github.com/illuminate/view) ([Blade](https://laravel.com/docs/11.x/blade)). |
| [Laravel/Paginate](https://github.com/rougin/weasley/blob/master/src/Packages/Laravel/Paginate.php) | Based on the [illuminate/pagination](https://github.com/illuminate/pagination). |
| [Session](https://github.com/rougin/weasley/blob/master/src/Packages/Session.php) | A simple implementation of the [SessionHandlerInterface](https://secure.php.net/manual/en/class.sessionhandlerinterface.php). |

**NOTE**: The mentioned integrations above needs to include their required dependencies first.

### HTTP Handlers

The following classes below uses the [Middleware](https://github.com/rougin/slytherin/wiki/Middleware) component of Slytherin:

| Handler | Description |
| ---------- | ----------- |
| [AllowCrossOrigin](https://github.com/rougin/weasley/blob/master/src/Handlers/AllowCrossOrigin.php) | Adds additional headers for [Cross-origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) (CORS). |
| [EmptyStringToNull](https://github.com/rougin/weasley/blob/master/src/Handlers/EmptyStringToNull.php) | Converts the empty strings from request as `null`. |
| [JsonContentType](https://github.com/rougin/weasley/blob/master/src/Handlers/JsonContentType.php) | Changes content response to `application/json`. |
| [MutateRequest](https://github.com/rougin/weasley/blob/master/src/Handlers/MutateRequest.php) | A middleware that can be extended to mutate/transform values from the request. |
| [SpoofHttpMethod](https://github.com/rougin/weasley/blob/master/src/Handlers/SpoofHttpMethod.php) | Replaces the HTTP verb  from `_method` value. |
| [TrimStringValue](https://github.com/rougin/weasley/blob/master/src/Handlers/TrimStringValue.php) | Trims the strings from an incoming request. |

**NOTE**: In other PHP frameworks, this is also known as `Middlewares`.

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