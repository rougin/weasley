# {{ application.name }}

{{ application.description }}

## Getting Started

``` bash
$ composer install
$ vendor/bin/phinx migrate && vendor/bin/phinx seed:run
$ php -S localhost:8000 -t public/
```

Then go to [http://localhost:8000](http://localhost:8000).

## Change Log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
