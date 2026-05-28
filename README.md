# Weasley

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

`Weasley` is a PHP package that provides generators, helpers, and utility classes for the [Slytherin](https://roug.in/slytherin/). Its goal is to improve the overall productivity when writing web applications based on `Slytherin` by reducing in writing code related to [CRUD operations](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete).

## Installation

Install `Weasley` through [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/weasley
```

## Basic usage

`Weasley` is built on a layered architecture where each domain delegates to a dedicated package:

| Package | Purpose |
|---------|---------|
| [Slytherin](https://github.com/rougin/slytherin) | Simple, extensible PHP micro-framework. |
| [Onion](https://github.com/rougin/onion) | HTTP middlewares for Slytherin. |
| [Valla](https://github.com/rougin/valla) | A simple validation package in PHP. |
| [Blueprint](https://github.com/rougin/blueprint) | A bootstrap for PHP console projects. |
| [Classidy](https://github.com/rougin/classidy) | Create PHP classes using PHP. |

## Code generators

`Weasley` provides commands that generate code for Slytherin components. These commands allow `Slytherin` to be a rapid prototyping tool when creating web-based applications.

Use the `weasley` command to access the list of its available commands:

``` bash
$ vendor/bin/weasley
```

### Available commands

| Command | Description |
|---------|-------------|
| `make:check` | Creates a new validation (`Check`) class |
| `make:handler` | Creates a new [HTTP Middleware](https://github.com/rougin/slytherin/wiki/Middleware) class |
| `make:package` | Creates a new [Slytherin Integration](https://github.com/rougin/slytherin/wiki/IntegrationInterface-Implementation) class |
| `make:route` | Creates a new [HTTP route](https://github.com/rougin/slytherin/wiki/Defining-HTTP-Routes) class |

Each command accepts the following options:

``` bash
$ vendor/bin/weasley make:check UserCheck --path src/Checks --namespace App\Checks --author "John Doe"
```

| Option | Default | Description |
|--------|---------|-------------|
| `--path` | `src/Checks` | Directory where the file will be created |
| `--namespace` | `App\Checks` | Namespace for the generated class |
| `--author` | _(empty)_ | Author name in the class docblock |

## HTTP routes

`Weasley` provides classes for creating HTTP routes in the [RESTful](https://en.wikipedia.org/wiki/REST) style. In other PHP frameworks, these are also known as _Controllers_.

### `HttpRoute`

A simple HTTP route class that provides a `json()` helper for returning JSON responses:

``` php
use Rougin\Weasley\Route;

class Welcome extends Route
{
    public function index()
    {
        $data = array('message' => 'Hello world!');

        return $this->json($data);
    }
}
```

The `Route` class is a root-namespace alias for `Rougin\Weasley\Routes\HttpRoute`. It accepts the PSR-07 request and response through its constructor:

``` php
/** @var \Psr\Http\Message\ServerRequestInterface */
$request = /** ... */;

/** @var \Psr\Http\Message\ResponseInterface */
$response = /** ... */;

$route = new Welcome($request, $response);

/** @var \Psr\Http\Message\ResponseInterface */
$result = $route->index();
```

### `JsonRoute`

Extends `HttpRoute` with built-in CRUD operations backed by an Eloquent model and a validator:

``` php
use Rougin\Weasley\Routes\JsonRoute;

class UsersRoute extends JsonRoute
{
    protected $model = 'Acme\Models\User';

    protected $mutator = 'Rougin\Weasley\Mutators\RestMutator';

    protected $validator = 'Acme\Checks\UserCheck';
}
```

Once defined, the following methods become available:

| Method | HTTP Equivalent | Description |
|--------|----------------|-------------|
| `index()` | `GET /users` | Returns all records (paginated when `illuminate/pagination` is installed) |
| `show($id)` | `GET /users/{id}` | Returns a single record |
| `store()` | `POST /users` | Creates a new record from the parsed request body |
| `update($id)` | `PUT /users/{id}` | Updates an existing record |
| `delete($id)` | `DELETE /users/{id}` | Deletes a record |

The `$model` must be an Eloquent model with `$fillable` defined. The `$validator` must be a `Check` subclass. Both are validated at construction time and will throw `UnexpectedValueException` if missing.

## HTTP handlers

`Weasley` provides HTTP middlewares (handlers) that process incoming requests and outgoing responses. Each handler implements `Rougin\Slytherin\Middleware\MiddlewareInterface`.

> [!NOTE]
> Starting v0.8, all handler classes are thin wrappers over [Onion](https://github.com/rougin/onion) (`rougin/onion`). Every feature described below originates from Onion's classes.

### `AllowCrossOrigin`

Adds [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) headers to every response:

``` php
use Rougin\Weasley\Handlers\AllowCrossOrigin;

// Default: allows all origins, allows GET/POST/PUT/DELETE/OPTIONS
$cors = new AllowCrossOrigin;

// Restrict to specific origins and methods via constructor
$cors = new AllowCrossOrigin(
    array('https://example.com', 'https://api.example.com'),
    array('GET', 'POST')
);

// Or configure fluently
$cors = (new AllowCrossOrigin)
    ->allowed(array('https://example.com'))
    ->methods(array('GET', 'POST', 'DELETE'));
```

> [!NOTE]
> If the incoming request method is `OPTIONS`, the handler returns an empty response immediately (preflight support).

### `EmptyStringToNull`

Converts empty, `"null"`, and `"undefined"` string values from query parameters and parsed body to actual `null`:

``` php
use Rougin\Weasley\Handlers\EmptyStringToNull;

$handler = new EmptyStringToNull;
// query params: ?age=&name=null&role=undefined
// becomes:      ['age' => null, 'name' => null, 'role' => null]
```

### `JsonContentType`

Sets the `Content-Type` header to `application/json` on every response that does not already have one:

``` php
use Rougin\Weasley\Handlers\JsonContentType;

$handler = new JsonContentType;
// Response header: Content-Type: application/json
```

### `MutateRequest`

An extensible base class for transforming request values. Extend it and override the `transform()` method:

``` php
use Rougin\Weasley\Handlers\MutateRequest;

class SanitizeHtml extends MutateRequest
{
    protected function transform($value)
    {
        return is_string($value) ? strip_tags($value) : $value;
    }
}
```

The `transform()` method is called recursively on every value in query parameters and the parsed body. Arrays are recursed into automatically.

### `SpoofHttpMethod`

Replaces the HTTP verb of the request with the value of a configurable key from the parsed body, enabling HTML forms to simulate `PATCH`, `PUT`, or `DELETE`:

``` php
use Rougin\Weasley\Handlers\SpoofHttpMethod;

// Default key is "_method"
$spoof = new SpoofHttpMethod;

// Use a custom key
$spoof = new SpoofHttpMethod('_action');
// or fluently: $spoof->key('_action');
```

When the request body contains `['_method' => 'PATCH']`, the request method becomes `PATCH`.

### `TrimStringValue`

Trims whitespace from all string values in query parameters and the parsed body:

``` php
use Rougin\Weasley\Handlers\TrimStringValue;

$handler = new TrimStringValue;
// query params: ?name=  Rougin
// becomes:      ['name' => 'Rougin']
```

## Validation

`Weasley` provides the `Check` class for validating data. It is built on [Valla](https://github.com/rougin/valla) (`rougin/valla`) and supports all rules from Valla's rule engine (e.g., `required`, `email`, and more):

``` php
$check = new UserCheck;

$data = /* e.g., from request */;

if ($check->valid($data))
{
    // Data passed validation
}
else
{
    // Get all errors: array<string, string[]>
    $errors = $check->errors();

    // Get the first error only
    echo $check->firstError(); // e.g., "Age is required"
}
```

Error messages are built from the label and the rule description. For example, a missing `email` field with the label `"Email"` produces `"Email is required"`.

### Method-based style (recommended)

The method-based style is recommended when rules depend on the submitted data (e.g., conditionally requiring a field):

``` php
use Rougin\Weasley\Check;

class UserCheck extends Check
{
    /**
     * @return array<string, string>
     */
    public function labels()
    {
        return array(
            'name' => 'Name',
            'email' => 'Email',
            'age' => 'Age',
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function rules(array $data)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric|min:18',
        );

        return $rules;
    }
}
```

### Property-based style (legacy)

This can also define rules and labels as protected properties for simple, static rule sets:

``` php
use Rougin\Weasley\Check;

class SimpleCheck extends Check
{
    protected $labels = array(
        'name' => 'Name',
        'email' => 'Email',
    );

    protected $rules = array(
        'name' => 'required',
        'email' => 'required|email',
    );
}
```

## Mutators

Mutators transform data into a specified output format (e.g., PSR-07 responses, API payloads). They implement `Rougin\Weasley\Contract\Mutator`.

### `JsonMutator`

Encodes data as JSON and returns a PSR-07 response:

``` php
use Rougin\Weasley\Mutators\JsonMutator;

$mutator = new JsonMutator($response);
$result = $mutator->mutate(array('status' => 'success'));
// Content-Type: application/json
// Body: {"status":"success"}
```

A second argument accepts [JSON encoding options](https://www.php.net/manual/en/json.constants.php):

``` php
$mutator = new JsonMutator($response, JSON_PRETTY_PRINT);
```

### `RestMutator`

Formats paginated results following [PayPal's API Style Guide](https://web.archive.org/web/20220114091735/https://github.com/paypal/api-standards/blob/master/api-style-guide.md):

``` php
use Rougin\Weasley\Mutators\RestMutator;

$mutator = new RestMutator;
$result = $mutator->mutate($paginator);

// $result becomes:
// [
//     'total_items' => 100,
//     'total_pages' => 10,
//     'items' => [...],
// ]
```

When the data is not a `LengthAwarePaginator`, the mutator wraps it as `['items' => $data]`.

## Third-party packages

`Weasley` provides `IntegrationInterface` implementations for wiring third-party packages into Slytherin's container.

### `Laravel\Eloquent`

Enables [Eloquent ORM](https://laravel.com/docs/eloquent) from [Laravel](https://laravel.com):

``` bash
$ composer require illuminate/database
```

``` php
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Packages\Laravel\Eloquent;

$config = new Configuration;
$config->set('database.default', 'sqlite');
$config->set('database.sqlite.driver', 'sqlite');
$config->set('database.sqlite.database', ':memory:');

$container = new Container;
(new Eloquent)->define($container, $config);

// Eloquent models are now available globally
$users = User::all();
```

### `Laravel\Blade`

Enables [Blade](https://laravel.com/docs/blade) templating:

``` bash
$ composer require illuminate/view
```

``` php
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Packages\Laravel\Blade;

$config = new Configuration;
$config->set('illuminate.view.templates', __DIR__ . '/templates');
$config->set('illuminate.view.compiled', __DIR__ . '/cache');

$container = new Container;
(new Blade)->define($container, $config);

// Resolve the renderer from the container
$renderer = $container->get('Rougin\Weasley\Renderers\BladeRenderer');
echo $renderer->render('welcome', array('name' => 'Rougin'));
```

### `Laravel\Paginate`

Adds pagination support to Eloquent models:

``` bash
$ composer require illuminate/pagination
```

``` php
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Packages\Laravel\Paginate;

// Assuming Eloquent is already booted (see above)
$container = new Container;
(new Paginate)->define($container, new Configuration);

// Eloquent models now have a paginate() method
$paginator = User::paginate(10); // 10 per page

echo $paginator->total();      // total records
echo $paginator->currentPage(); // current page number
```

### `Session`

Provides session management through `SessionHandlerInterface`:

``` php
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Packages\Session;

$config = new Configuration;
$config->set('session.cookies', array());
$config->set('session.expiration', 3600);
$config->set('session.path', __DIR__ . '/sessions');

$container = new Container;
(new Session)->define($container, $config);

// Resolve the session from the container ---
$class = 'Rougin\Weasley\Contract\Session';

$session = $container->get($class);
// ------------------------------------------

$session->set('user_id', 42);
echo $session->get('user_id'); // 42

$session->regenerate();      // rotate session ID
$session->delete('user_id'); // remove a key
```

## Contracts

`Weasley` defines interfaces for its extensible components:

### `Contract\Mutator`

``` php
namespace Rougin\Weasley\Contract;

interface Mutator
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function mutate($data);
}
```

Implement this interface to create custom mutators. `JsonMutator` and `RestMutator` are built-in implementations.

### `Contract\Session`

``` php
namespace Rougin\Weasley\Contract;

interface Session
{
    /**
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @param mixed  $value
     * @return self
     */
    public function set($key, $value);

    /**
     * @param string $key
     * @return boolean
     */
    public function delete($key);

    /**
     * @param boolean $delete
     * @return boolean
     */
    public function regenerate($delete = false);
}
```

## Utilities

### `Random`

Generates cryptographically secure random strings:

``` php
use Rougin\Weasley\Assorted\Random;

$token = Random::make(32); // e.g., "a7f3b9c2d1e8..."
```

## Changelog

Please see [CHANGELOG][link-changelog] for more recent changes.

## Upgrade Guide

As `Weasley` continues to evolve, there might be some breaking changes in its internal code during development. The said changes can be found in [UPGRADING][link-upgrading].

## Contributing

See [CONTRIBUTING][link-contributing] on how to contribute.

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/weasley/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/weasley?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/weasley.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/weasley.svg?style=flat-square

[link-build]: https://github.com/rougin/weasley/actions
[link-changelog]: https://github.com/rougin/weasley/blob/master/CHANGELOG.md
[link-contributing]: https://github.com/rougin/weasley/blob/master/CONTRIBUTING.md
[link-coverage]: https://app.codecov.io/gh/rougin/weasley
[link-downloads]: https://packagist.org/packages/rougin/weasley
[link-license]: https://github.com/rougin/weasley/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/weasley
[link-upgrading]: https://github.com/rougin/weasley/blob/master/UPGRADING.md
