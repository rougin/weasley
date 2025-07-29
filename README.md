# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

`Weasley` is a PHP package that provides generators, helpers, and utility classes for the [Slytherin](https://roug.in/slytherin/). Its goal is to improve the overall productivity when writing web applications based on `Slytherin` by reducing in writing code related to [CRUD operations](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete).

## Installation

Install the `Weasley` package via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/weasley
```

> [!NOTE]
> When using the `weasley` command, the [Symfony Console](https://symfony.com/doc/current/components/console.html) must be installed first.

Once installed, kindly see the following features below provided by `Weasley`:

## Code generators

`Weasley` provides commands that generates code based on the specified type (e.g., `Check`, `Route`, etc.). These commands allow `Slytherin` to be a rapid prototyping tool in creating web-based applications.

To access the list of available commands, kindly run its namesake command from the terminal:

``` bash
$ vendor/bin/weasley
```

### `make:check`

Creates a new check (validation) class based on [Valitron](https://github.com/vlucas/valitron).

### `make:handler`

Creates a new [HTTP Middleware](https://github.com/rougin/slytherin/wiki/Middleware) class.

### `make:package`

Creates a new [Slytherin Integration](https://github.com/rougin/slytherin/wiki/IntegrationInterface-Implementation) class.

### `make:route`

Creates a new [HTTP route](https://github.com/rougin/slytherin/wiki/Defining-HTTP-Routes) class.

## HTTP routes

In creating web applications, `Weasley` also provides PHP classes to create HTTP routes based on the [RESTful](https://en.wikipedia.org/wiki/REST) style.

> [!NOTE]
> In other PHP frameworks, this is also known as `Controllers`.

### `HttpRoute`

A simple HTTP route class for RESTful APIs.

### `JsonRoute`

Similar with `HttpRoute` but the response will be returned in [JSON](https://en.wikipedia.org/wiki/JSON) format.

## Third-party packages

To conform with the usage of [`IntegrationInterface`](https://github.com/rougin/slytherin/wiki/IntegrationInterface-Implementation) from `Slytherin`, `Weasley` also provides the following third-party integrations with other PHP packages:

### `Laravel\Eloquent`

This package enables the usage of [Eloquent](https://laravel.com/docs/eloquent) to `Slytherin` which is an [Object-relational mapper (ORM)](https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping) from [Laravel](https://laravel.com). To use this package, kindly install its required package first in `Composer`:

``` bash
$ composer require illuminate/database
```

### `Laravel\Blade`

`Laravel\Blade` allows `Slytherin` to use [Blade](https://laravel.com/docs/blade) from `Laravel` for creating PHP templates using the `Blade` templating engine. Use the command below to install the specified package from `Composer`:

``` bash
$ composer require illuminate/view
```

### `Laravel\Paginate`

This is a simple third-party package that allows `Eloquent` to generate pagination links based on its models. Kindly use the command below to install this third-party package:

``` bash
$ composer require illuminate/paginate
```

### `Session`

`Weasley` also provides a simple implementation of the [SessionHandlerInterface](https://secure.php.net/manual/en/class.sessionhandlerinterface.php).

## HTTP handlers

`Weasley` has the following HTTP middlewares (HTTP handlers in this case) to improve the handling of HTTP requests and its respective responses:

### `AllowCrossOrigin`

Adds additional headers for [Cross-origin resource sharing](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) (CORS).

### `EmptyStringToNull`

Converts the empty strings from request as `null`.

### `JsonContentType`

Changes content response to `application/json`.

### `MutateRequest`

A middleware that can be extended to mutate/transform values from the request.

### `SpoofHttpMethod`

Replaces the HTTP verb  from `_method` value.

### `TrimStringValue`

Trims the strings from an incoming request.

## Mutators

Provided by `Weasley`, mutators are classes that mutates (transforms) to a specified result (e.g., [PSR-07](https://www.php-fig.org/psr/psr-7/) responses, API data, etc.):

### `JsonMutator`

Mutates a `PSR-07` response in JSON format.

### `RestMutator`

Mutates a response created from the `Laravel/Paginate` package based on [Paypal's API Style Guide](https://web.archive.org/web/20220114091735/https://github.com/paypal/api-standards/blob/master/api-style-guide.md).

## Validation

`Weasley` also provides a simple validation class on top of [Valitron](https://github.com/vlucas/valitron) using the `Check` class:

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

## Testing

If there is a need to check the source code of `Weasley` for development purposes (e.g., creating fixes, new features, etc.), kindly clone this repository first to a local machine:

``` bash
$ git clone https://github.com/rougin/weasley.git "Sample"
```

After cloning, use `Composer` to install its required packages:

``` bash
$ cd Sample
$ composer update
```

> [!NOTE]
> Please see also the [build.yml](https://github.com/rougin/weasley/blob/master/.github/workflows/build.yml) of `Weasley` to check any packages that needs to be installed based on the PHP version.

Once the required packages were installed, kindly check the following below on how to maintain the code quality and styling guide when interacting the source code of `Weasley`:

### Unit tests

`Weasley` also contains unit tests that were written in [PHPUnit](https://phpunit.de/index.html):

``` bash
$ composer test
```

When creating fixes or implementing new features, it is recommended to run the above command to always check if the updated code introduces errors during development.

### Code quality

To retain the code quality of `Weasley`, a static code analysis code tool named [PHPStan](https://phpstan.org/) is being used during development. To start, kindly install the specified package in the global environment of `Composer`:

``` bash
$ composer global require phpstan/phpstan --dev
```

Once installed, `PHPStan` can now be run using its namesake command:

``` bash
$ cd Sample
$ phpstan
```

> [!NOTE]
> When running `phpstan`, it will use the `phpstan.neon` file which is already provided by `Weasley`.

### Coding style

Aside from code quality, `Weasley` also uses a tool named [PHP Coding Standards Fixer](https://cs.symfony.com/) for maintaining an opinionated style guide. To use this tooling, it needs also to be installed in the `Composer`'s global environment first:

``` bash
$ composer global require friendsofphp/php-cs-fixer --dev
```

After its installation, kindly use the `php-cs-fixer` command in the same `Weasley` directory:

``` bash
$ cd Sample
$ php-cs-fixer fix --config=phpstyle.php
```

The `phpstyle.php` file provided by `Weasley` currently follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) standard as its baseline for the coding style and uses [Allman](https://en.wikipedia.org/wiki/Indentation_style#Allman_style) as its indentation style.

> [!NOTE]
> Installing both `PHPStan` and `PHP Coding Standards Fixer` requires a minimum version of PHP at least `7.4`.

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

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
