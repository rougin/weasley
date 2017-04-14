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

* `make:controller` - Creates a new HTTP controller
* `make:integration` - Creates an empty Slytherin Integration template
* `make:validator` - Creates an empty validator based on [Valitron](https://github.com/vlucas/valitron)

### HTTP Controllers

* [`AuthenticationController`](https://github.com/rougin/weasley/blob/master/src/Http/Controllers/AuthenticationController.php) - based on [Loream Authsum](https://github.com/rougin/loream-authsum), this controller provides methods for authenticating credentials
* [`RestfulController`](https://github.com/rougin/weasley/blob/master/src/Http/Controllers/RestfulController.php) - based on [PSR-7](http://www.php-fig.org/psr/psr-7), this controller provides methods for creating RESTful APIs

### Integrations

Coming soon

### Middlewares

* [`CORS`](https://github.com/rougin/weasley/blob/master/src/Http/Middleware/Cors.php) - add additional headers for [cross-origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
* [`JSON`](https://github.com/rougin/weasley/blob/master/src/Http/Middleware/Json.php) - changes `Content-Type` of response to `application/json`

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