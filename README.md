# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Weasley provides generators and helpers for the [Slytherin](https://github.com/rougin/slytherin) framework.

## Install

Via Composer

``` bash
$ composer require rougin/weasley
```

## Features

### Generators

You can access the generators through `vendor/bin/weasley` in your terminal/command line.

* `make:controller` - Create a new HTTP controller class
* `make:integration` - Create a new [integration](https://github.com/rougin/slytherin/blob/master/src/Integration/IntegrationInterface.php) class
* `make:middleware` - Create a new [PSR-15](https://github.com/php-fig/fig-standards/blob/master/proposed/http-middleware/middleware-meta.md) middleware class
* `make:validator` - Create a new validator class

You can also include `--help` if you want to know the available options for each command.

### HTTP Controllers

* [`RestfulController`](src/Http/Controllers/RestfulController.php) - based on [PSR-7](http://www.php-fig.org/psr/psr-7), this controller provides class methods for creating RESTful APIs

### Integrations

* [`SessionIntegration`](src/Session/SessionIntegration.php) - an implementation of `SessionHandlerInterface`

#### Illuminate (Laravel's individual components)

* [`DatabaseIntegration`](src/Illuminate/DatabaseIntegration.php) - based on [illuminate/database](https://github.com/illuminate/database), also known as [Eloquent](https://laravel.com/docs/5.4/eloquent)
* [`PaginationIntegration`](src/Illuminate/PaginationIntegration.php) - based on [illuminate/pagination](https://github.com/illuminate/pagination)
* [`ViewIntegration`](src/Illuminate/ViewIntegration.php) - based on [illuminate/view](https://github.com/illuminate/view), also known as [Blade](https://laravel.com/docs/5.4/blade)

**NOTE**: The said integrations above needs to include their required packages first.

### HTTP Middlewares

All of the HTTP middlewares below are implemented in the `v0.4.1` of [PSR-15](https://github.com/http-interop/http-middleware/tree/0.4.1).

* [`CORS`](src/Middleware/Cors.php) - adds additional headers for [cross-origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
* [`EmptyStringToNull`](src/Middleware/EmptyStringToNull.php) - converts the empty strings from the incoming HTTP request values as `null`
* [`FormMethodSpoofing`](src/Middleware/FormMethodSpoofing.php) - changes the HTTP method of the request based on the `_method` input value from a `<form>` tag
* [`JSON`](src/Middleware/Json.php) - changes the `Content-Type` value of the response to `application/json`
* [`TrimString`](src/Middleware/TrimString.php) - trims the available strings from the incoming HTTP request

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors

[ico-version]: https://img.shields.io/packagist/v/rougin/weasley.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/weasley/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/weasley.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/weasley.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/weasley.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rougin/weasley
[link-travis]: https://travis-ci.org/rougin/weasley
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/weasley/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/weasley
[link-downloads]: https://packagist.org/packages/rougin/weasley
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors