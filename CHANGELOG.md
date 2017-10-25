# Changelog

All notable changes to `Weasley` will be documented in this file.

## [0.6.0](https://github.com/rougin/weasley/compare/v0.5.0...v0.6.0) - Unreleased

### Added
- `Session` library

### Changed
- `Generator` directory to `Console` directory

## [0.5.0](https://github.com/rougin/weasley/compare/v0.4.4...v0.5.0) - 2017-10-06

### Changed
- Renamed `Skeleton` to `App` in the default namespace of the command generators
- Renamed `Template` directory to `Renderers`
- Moved `Commands` and `Templates` directory to `Generator` directory

### Removed
- `rougin/loream-authsum` package
- `DatabaseIntegration::prepare` method

## [0.4.4](https://github.com/rougin/weasley/compare/v0.4.3...v0.4.4) - 2017-09-19

### Fixed
- Version of `http-interop/http-middleware` to `v0.4.1` due to BC break on `v0.5.0`

## [0.4.3](https://github.com/rougin/weasley/compare/v0.4.2...v0.4.3) - 2017-07-24

### Removed
- Typehinting of model in `RestfulController::save`

## [0.4.2](https://github.com/rougin/weasley/compare/v0.4.1...v0.4.2) - 2017-07-14

### Fixed
- Returning Eloquent model in `RestfulController::save`

## [0.4.1](https://github.com/rougin/weasley/compare/v0.4.0...v0.4.1) - 2017-07-13

### Fixed
- Not rounded `total_pages` in `ApiTransformer::paginator`

## [0.4.0](https://github.com/rougin/weasley/compare/v0.3.1...v0.4.0) - 2017-07-13

### Added
- `TransformerInterface` for handling classes that transforms results
- `JsonTransformer` for transforming the results in JSON format
- `ApiTransformer` for transforming the results based on [Paypal's API Style Guide](https://github.com/paypal/api-standards/blob/master/api-style-guide.md)
- `RestfulController::transformer` for defining the transformer to be used in `RestfulController::index`
- Exception when the specified item does not exists in `RestfulController::show`

### Changed
- Moved `BaseController::save` and `BaseController::check` in `RestfulController`

### Fixed
- HTTP Code `201` for creating a new item in `RestfulController::store` 

## [0.3.1](https://github.com/rougin/weasley/compare/v0.3.0...v0.3.1) - 2017-07-10

### Fixed
- Checking of `illuminate/pagination` package in `RestfulController::index`

## [0.3.0](https://github.com/rougin/weasley/compare/v0.2.1...v0.3.0) - 2017-07-10

### Added
- `Http\Middleware\FormMethodSpoofing`
- `Integrations\Illuminate\PaginationIntegration`
- `Integrations\Illuminate\ViewIntegration`

### Changed
- Version of `rougin/slytherin` to `v0.9.0`

## [0.2.1](https://github.com/rougin/weasley/compare/v0.2.0...v0.2.1) - 2017-06-07

### Fixed
- Overriding `Content-Type` even if it exists in `Http\Middleware\Json`

## [0.2.0](https://github.com/rougin/weasley/compare/v0.1.2...v0.2.0) - 2017-05-25

### Added
- `$options` parameter in `BaseController::json`

### Changed
- `BaseController::toJson` to `BaseController::json`
- DocBlocks documentation on `RestfulController`

### Fixed
- Issue if the HTTP method is `OPTIONS` in `Http\Middleware\Cors`

## [0.1.2](https://github.com/rougin/weasley/compare/v0.1.1...v0.1.2) - 2017-05-09

### Added
- Set `Illuminate\Database\Capsule\Manager` to container in [`DatabaseIntegration`](https://github.com/rougin/weasley/blob/master/src/Integrations/Illuminate/DatabaseIntegration.php)

### Changed
- Allow to access multiple database connections in [`DatabaseIntegration`](https://github.com/rougin/weasley/blob/master/src/Integrations/Illuminate/DatabaseIntegration.php)

## [0.1.1](https://github.com/rougin/weasley/compare/v0.1.0...v0.1.1) - 2017-05-03

### Fixed
- Missing `src` in default path for the generators

### Changed
- Update command descriptions

## 0.1.0 - 2017-05-02

### Added
- `Weasley` library