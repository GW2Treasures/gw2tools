# gw2treasures/gw2tools

<!-- badges -->
[![version][packagist-badge]][packagist]
[![license][license-badge]][packagist]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]

[packagist-badge]: https://img.shields.io/packagist/v/gw2treasures/gw2tools.svg?style=flat-square
[license-badge]: https://img.shields.io/packagist/l/gw2treasures/gw2tools.svg?style=flat-square
[travis-badge]: https://img.shields.io/travis/GW2Treasures/gw2tools.svg?style=flat-square
[coverage-badge]: https://img.shields.io/codecov/c/github/GW2Treasures/gw2tools.svg?style=flat-square
[packagist]: https://packagist.org/packages/gw2treasures/gw2tools
[travis]: https://travis-ci.org/GW2Treasures/gw2tools
[coverage]: https://codecov.io/github/GW2Treasures/gw2tools

**Collection of useful helpers to work with data for Guild Wars 2 in PHP**.

## Features
 - ...

## Requirements
 - PHP >= 5.5

## Setup

### Using [composer](https://getcomposer.org) (recommended)

```sh
composer require gw2treasures/gw2tools
```

If you haven't included composers autoloader yet,
you will have to add this before being able to use the GW2Tools.

```php
include 'vendor/autoload.php';
```

### Using the gw2api.phar archive

You need to download the [latest gw2tools.phar](https://github.com/GW2Treasures/gw2tools/releases/latest) 
and place it in your project directory.
Now you can include it to start using the GW2Tools.

```php
include __DIR__ . '/gw2tools.phar';
```

## License

[MIT](LICENSE) © 2015 gw2treasures.com
