Prepositioner
=============

PHP Prepositioner for replacing prepositions with `&nbsp;` after preposition

[![Code Climate](https://codeclimate.com/github/tomaj/prepositioner/badges/gpa.svg)](https://codeclimate.com/github/tomaj/prepositioner)
[![Test Coverage](https://api.codeclimate.com/v1/badges/d82eb747d9ac33571be3/test_coverage)](https://codeclimate.com/github/tomaj/prepositioner/test_coverage)
[![Latest Stable Version](https://poser.pugx.org/tomaj/prepositioner/v/stable.svg)](https://packagist.org/packages/tomaj/prepositioner)
[![License](https://poser.pugx.org/tomaj/prepositioner/license.svg)](https://packagist.org/packages/tomaj/prepositioner)

## Requirements

- **PHP 8.0** or higher
- Uses modern PHP 8.0+ features including:
  - Constructor property promotion
  - Readonly properties
  - Match expressions
  - Attributes instead of docblock annotations
  - Union types
  - Spread operator in arrays

## Installation

Install package via composer:

```bash
composer require tomaj/prepositioner
```

## Usage

### Simple usage without Factory

```php
use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['one', 'two']);
$result = $prepositioner->formatText($inputText);
```

This example replaces all occurrences of *'one'* or *'two'* strings in `$inputText` as *'one&nbsp;'* and *'two&nbsp;'*.

### Using Factory with language support

```php
use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$result = $prepositioner->formatText($inputText);
```

### Supported Languages

- **Slovak** - `Factory::build('slovak')`
- **Czech** - `Factory::build('czech')`  
- **Romanian** - `Factory::build('romanian')`
- **Empty** - `Factory::build('empty')` - for testing or custom usage

### Custom escape string

```php
use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak', '###CUSTOM###');
$result = $prepositioner->formatText($inputText);
```

## Extending

To add support for a new language, implement the `LanguageInterface`:

```php
<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

final class MyLanguage implements LanguageInterface
{
    private const PREPOSITIONS = ['my', 'custom', 'prepositions'];

    /**
     * @return array<string>
     */
    public function prepositions(): array
    {
        return self::PREPOSITIONS;
    }
}
```

Then use it directly:

```php
use Tomaj\Prepositioner\Prepositioner;
use Tomaj\Prepositioner\Language\MyLanguage;

$language = new MyLanguage();
$prepositioner = new Prepositioner($language->prepositions());
```

Or register it for use with the Factory by placing it in the `Tomaj\Prepositioner\Language` namespace.

## What's New in v4.0

- **PHP 8.0+ required** - modernized codebase with latest PHP features
- **Constructor property promotion** - cleaner, more concise code
- **Readonly properties** - improved immutability and type safety
- **Match expressions** - better performance and readability in Factory
- **PHPUnit 10** - latest testing framework with attributes
- **PSR-4 autoloading** - improved autoloader efficiency
- **Final classes** - better encapsulation and performance
- **Typed arrays** - better documentation and IDE support

## Migration from v3.x

- Minimum PHP version is now **8.0**
- All functionality remains the same - no breaking changes to public API
- If extending classes, note that most classes are now `final`
- Tests now use PHPUnit 10 with attributes instead of docblock annotations

## Development

Run tests:
```bash
composer test
```

Code style:
```bash
composer cs
```
