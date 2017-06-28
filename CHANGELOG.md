# Changelog

All notable changes to `Weasley` will be documented in this file.

## [0.3.0](https://github.com/rougin/weasley/compare/v0.2.1...v0.3.0) - Unreleased

### Added
- `Http\Middleware\FormMethodSpoofing`

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