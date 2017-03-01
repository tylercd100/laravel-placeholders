# Find and Replace placeholder strings in Laravel 5
[![Latest Version](https://img.shields.io/github/release/tylercd100/laravel-placeholders.svg?style=flat-square)](https://github.com/tylercd100/laravel-placeholders/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/tylercd100/laravel-placeholders.svg?branch=master)](https://travis-ci.org/tylercd100/laravel-placeholders)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tylercd100/laravel-placeholders/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/laravel-placeholders/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tylercd100/laravel-placeholders/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/laravel-placeholders/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187)
[![Total Downloads](https://img.shields.io/packagist/dt/tylercd100/laravel-placeholders.svg?style=flat-square)](https://packagist.org/packages/tylercd100/laravel-placeholders)

## Installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require tylercd100/laravel-placeholders
```

Now add the following to the `providers` array in your `config/app.php`
```php
Tylercd100\Placeholders\ServiceProvider::class
```

and this to the `aliases` array in `config/app.php`
```php
"Placeholders" => Tylercd100\Placeholders\Facades\Placeholders::class,
```
Then you will need to run these commands in the terminal in order to copy the config file
```bash
php artisan vendor:publish --provider="Tylercd100\Placeholders\ServiceProvider"
```

## Usage
```php
use Placeholders;

// Basic
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
	'veg' => 'cucumber'
]); //I like oranges and cucumbers

// Globally
Placeholders::set("fruit", "apple");
Placeholders::set("veg", "carrot");
Placeholders::parse("I like [fruit]s and [veg]s"); // I like apples and carrots
```

### Style
```php
// Change the style
Placeholders::setStyle("{{", "}}");
Placeholders::parse("I like {{fruit}}s and {{veg}}s", [
	'fruit' => 'lemon',
	'veg' => 'string bean'
]); //I like lemons and string beans
```

### Errors
```php
// Throw an error if one is missed
Placeholders::setThorough(true) // This is the default
Placeholders::parse("I like [fruit]s and [veg]s", [
	'fruit' => 'orange',
]); //Throws an Exception: Could not find a replacement for [veg]
```
