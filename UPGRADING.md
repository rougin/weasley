# Upgrade Guide

Below are the significant changes when upgrading from specified versions due to backward compatibility breaks:

## From `v0.7.0` to `v0.8.0`

### Handlers migrated to `Onion`

The following HTTP handlers have been migrated to [Onion](https://github.com/rougin/onion) (`rougin/onion`). The handler classes remain as thin proxies for backward compatibility:

| Old (Handlers) | New (Onion) |
|----------------|-------------|
| `Handlers\AllowCrossOrigin` | `Rougin\Onion\CorsHeader` |
| `Handlers\EmptyStringToNull` | `Rougin\Onion\NullString` |
| `Handlers\JsonContentType` | `Rougin\Onion\JsonHeader` |
| `Handlers\MutateRequest` | `Rougin\Onion\Transform` |
| `Handlers\SpoofHttpMethod` | `Rougin\Onion\SpoofMethod` |
| `Handlers\TrimStringValue` | `Rougin\Onion\TrimString` |

### Validation migrated to `Valla`

The `Check` class has been migrated to [Valla](https://github.com/rougin/valla) (`rougin/valla`). The `Check` class remains as a thin proxy for backward compatibility:

``` php
// Both continue to work, the latter is the ultimate source

class UserCheck extends \Rougin\Weasley\Check
{
}

class UserCheck extends \Rougin\Valla\Check
{
}
```

The `AbstractValidator` class now uses Valla's `Valid` engine internally instead of Valitron:

``` php
// Old (Valitron, imperative)
$this->validator->rule('required', 'name');

// New (Valla, declaration-first)
$this->valid->addRule('name', 'required');
```

### `rules()` signature now requires `array` type hint

Since `Check` now extends `Rougin\Valla\Check`, overriding the `rules()` method requires the `array` type hint on its parameter to be compatible with PHP 7.0+:

``` php
// Before (PHP 5.3 compatible, breaks PHP 7.0+)
public function rules($data)

// After (compatible with all PHP versions)
public function rules(array $data)
```

### Validators deprecated

The `AbstractValidator` class is now deprecated. Use `Check` instead:

| Old | New |
|-----|-----|
| `Validators\AbstractValidator` | `Validate\Check` (or `Rougin\Weasley\Check`) |

### Removed `$data` fallback in `Check`

The `$data` property and the automatic fallback in `valid()` have been removed. Data must now be passed explicitly:

``` php
// Old - `$data` property used as fallback when calling valid() without arguments
$check->valid();

// New - pass data explicitly
$data = array('name' => 'Rougin', 'password' => '1234');
$check->valid($data);
```

## From `v0.6.0` to `v0.7.0`

### Controllers directory renamed to Routes

| Old | New |
|-----|-----|
| `Controllers\BaseController` | `Routes\HttpRoute` |
| `Controllers\JsonController` | `Routes\JsonRoute` |

### Middleware directory renamed to Handlers

| Old | New |
|-----|-----|
| `Middleware\CrossOriginHeaders` | `Handlers\AllowCrossOrigin` |
| `Middleware\EmptyStringToNull` | `Handlers\EmptyStringToNull` |
| `Middleware\JsonHeaders` | `Handlers\JsonContentType` |
| `Middleware\SpoofFormMethod` | `Handlers\SpoofHttpMethod` |
| `Middleware\TransformRequest` | `Handlers\MutateRequest` |
| `Middleware\TrimString` | `Handlers\TrimStringValue` |

### Illuminate directory renamed to Packages

| Old | New |
|-----|-----|
| `Illuminate\DatabaseIntegration` | `Packages\Laravel\Eloquent` |
| `Illuminate\PaginationIntegration` | `Packages\Laravel\Paginate` |
| `Illuminate\ViewIntegration` | `Packages\Laravel\Blade` |

### Validators directory renamed to Validate

| Old | New |
|-----|-----|
| `Validators\AbstractValidator` | `Validate\Check` |

### Commands directory renamed to Scripts

| Old | New |
|-----|-----|
| `Commands\MakeControllerCommand` | `Scripts\CreateRoute` |
| `Commands\MakeIntegrationCommand` | `Scripts\CreatePackage` |
| `Commands\MakeMiddlewareCommand` | `Scripts\CreateHandler` |
| `Commands\MakeValidatorCommand` | `Scripts\CreateCheck` |

### Transformer renamed to Mutators / Contract

| Old | New |
|-----|-----|
| `Transformer\ApiTransformer` | `Mutators\RestMutator` |
| `Transformer\JsonTransformer` | `Mutators\JsonMutator` |
| `Transformer\TransformerInterface` | `Contract\Mutator` |

The `transform()` method has also been renamed to `mutate()`:

```
- Rougin\Weasley\Transformer\TransformerInterface::transform($data)
+ Rougin\Weasley\Contract\Mutator::mutate($data)
```

### Session renames

| Old | New |
|-----|-----|
| `Session\SessionIntegration` | `Packages\Session` |
| `Session\SessionInterface` | `Contract\Session` |

### Removal of http-interop/http-middleware

The `http-interop/http-middleware` package has been removed as a dependency. HTTP middlewares now conform to `Rougin\Slytherin\Middleware\MiddlewareInterface` from Slytherin.

## From `v0.5.0` to `v0.6.0`

### Http\Controllers directory deprecated

| Old | New |
|-----|-----|
| `Http\Controllers\BaseController` | `Controllers\BaseController` |
| `Http\Controllers\JsonController` | `Controllers\JsonController` |
| `Http\Controllers\RestfulController` | `Controllers\JsonController` |

### Http\Middleware directory deprecated

| Old | New |
|-----|-----|
| `Http\Middleware\Cors` | `Middleware\CrossOriginHeaders` |
| `Http\Middleware\FormMethodSpoofing` | `Middleware\SpoofFormMethod` |
| `Http\Middleware\Json` | `Middleware\JsonHeaders` |

### Middleware class renames

| Old | New |
|-----|-----|
| `Http\Middleware\Cors` | `Middleware\CrossOriginHeaders` |
| `Http\Middleware\FormMethodSpoofing` | `Middleware\SpoofFormMethod` |
| `Http\Middleware\Json` | `Middleware\JsonHeaders` |

### Integrations\Illuminate moved to Illuminate

| Old | New |
|-----|-----|
| `Integrations\Illuminate\DatabaseIntegration` | `Illuminate\DatabaseIntegration` |
| `Integrations\Illuminate\PaginationIntegration` | `Illuminate\PaginationIntegration` |
| `Integrations\Illuminate\ViewIntegration` | `Illuminate\ViewIntegration` |

## From `v0.1.0` to `v0.2.0`

### `toJson()` renamed to `json()`

``` diff
- $this->toJson($data);
+ $this->json($data);
```
