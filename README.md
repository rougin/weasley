# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Weasley provides generators and helpers that will speed up your [Slytherin](https://github.com/rougin/slytherin) workflow.

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

Include `--help` if you want to know the options for each command.

### HTTP Controllers

* [`AuthenticationController`](https://github.com/rougin/weasley/blob/master/src/Http/Controllers/AuthenticationController.php) - based on [Loream Authsum](https://github.com/rougin/loream-authsum), this controller provides methods for authenticating credentials
* [`RestfulController`](https://github.com/rougin/weasley/blob/master/src/Http/Controllers/RestfulController.php) - based on [PSR-7](http://www.php-fig.org/psr/psr-7), this controller provides methods for creating RESTful APIs

### Integrations

#### Illuminate (Laravel's individual components)

* [`DatabaseIntegration`](https://github.com/rougin/weasley/blob/master/src/Integrations/Illuminate/DatabaseIntegration.php) - based on [illuminate/database](https://github.com/illuminate/database), also known as [Eloquent](https://laravel.com/docs/5.4/eloquent)
* [`PaginationIntegration`](https://github.com/rougin/weasley/blob/master/src/Integrations/Illuminate/PaginationIntegration.php) - based on [illuminate/pagination](https://github.com/illuminate/pagination)
* [`ViewIntegration`](https://github.com/rougin/weasley/blob/master/src/Integrations/Illuminate/ViewIntegration.php) - based on [illuminate/view](https://github.com/illuminate/view), also known as [Blade](https://laravel.com/docs/5.4/blade)

### Middlewares

* [`CORS`](https://github.com/rougin/weasley/blob/master/src/Http/Middleware/Cors.php) - adds additional headers for [cross-origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
* [`JSON`](https://github.com/rougin/weasley/blob/master/src/Http/Middleware/Json.php) - changes `Content-Type` of response to `application/json`
* [`FormMethodSpoofing`](https://github.com/rougin/weasley/blob/master/src/Http/Middleware/FormMethodSpoofing.php) - changes the HTTP method of the request if it founds a `_method` attribute from a `<form>` tag

### Validators

* [`AuthenticationValidator`](https://github.com/rougin/weasley/blob/master/src/Validators/AuthenticationValidator.php) - a simple validator (username and password) for [Loream Authsum](https://github.com/rougin/loream-authsum)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

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