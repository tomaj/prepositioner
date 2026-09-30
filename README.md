Prepositioner
=============

PHP Prepositioner for replacing prepositions with &amp;nbsp; after preposition

[![CI](https://github.com/tomaj/prepositioner/actions/workflows/ci.yml/badge.svg)](https://github.com/tomaj/prepositioner/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/tomaj/prepositioner/v/stable.svg)](https://packagist.org/packages/tomaj/prepositioner)
[![Total Downloads](https://poser.pugx.org/tomaj/prepositioner/downloads)](https://packagist.org/packages/tomaj/prepositioner)
[![PHP Version](https://img.shields.io/packagist/php-v/tomaj/prepositioner)](https://packagist.org/packages/tomaj/prepositioner)
[![License](https://poser.pugx.org/tomaj/prepositioner/license.svg)](https://packagist.org/packages/tomaj/prepositioner)

## Supported Languages

- **Slovak** (slovenčina)
- **Czech** (čeština)
- **Romanian** (română)
- **Empty** (no prepositions)

Installation
------------

Install package via composer:

``` bash
$ composer require tomaj/prepositioner
```

Usage
-----

Simple usage without *Factory* is very simple:

``` php
$prepositioner = new Tomaj\Prepositioner\Prepositioner(['one', 'two']);
$prepositioner->formatText($inputText);
```

This example replaces all occurrences of *'one'* or *'two'* strings in ```$inputText``` as *'one&amp;nbsp;'* and *'two&amp;nbsp;'*.

For using with *Factory* which contains language support try:

``` php
$prepositioner = Tomaj\Prepositioner\Factory::build('slovak');
$prepositioner->formatText($inputText);
```

Extending
---------

For new language support you need to implement new language class which implements *LanguageInterface* with prepositions. See *SlovakLanguage* for details.


Development
-----------

Run tests and code quality checks:

``` bash
composer test          # Run PHPUnit tests
composer cs            # Check coding standards (PSR-12)
composer cs-fix        # Fix coding standards automatically
composer phpstan       # Run static analysis
composer check         # Run all checks (cs, phpstan, test)
```


Upgrade
-------

**From version 3 to 4**

⚠️ **Breaking Changes:**
- **Minimum PHP version is now 8.2** (was 7.3)
- **Unicode behavior change**: All regex patterns now use `/u` modifier for proper UTF-8 support
  - Prepositions with diacritics and capital letters outside ASCII now work correctly (e.g., "Či", "În")
  - If you relied on ASCII-only behavior, this may change results
- **Exception handling**: `Prepositioner::formatText()` now throws `PrepositionerException` on regex errors
  - Previously it would silently return the original text
  - Wrap calls in try-catch if you need to handle errors
- **Factory validation**: `Factory::build()` now validates that language classes implement `LanguageInterface`
  - Custom language classes must properly implement the interface

**Other changes:**
- Updated to PHPUnit 10/11
- Coding standard updated to PSR-12
- Added PHPStan static analysis with strict rules
- Improved regex safety with proper `preg_quote()` usage
- Comprehensive test coverage (≥95%)

**From version 2 to 3**
- Minimum php version is **7.3** from now
- If you are using custom *Language* file from outside or from this repository (and don't use `Tomaj\Prepositioner\Factory`) you have to change namespace from `\Tomaj\Prepositioner\MyLanguage` to `\Tomaj\Prepositioner\Language\MyLanguage`
- *Note:* new version includes `declare(strict_types=1);` in all files


Contributing
------------

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

We appreciate:
- Bug reports and fixes
- New language support
- Documentation improvements
- Code quality enhancements


Security
--------

If you discover any security-related issues, please email tomasmajer@gmail.com instead of using the issue tracker. See [SECURITY.md](SECURITY.md) for more details.


License
-------

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.


Known Issues
------------

1. Each new language has to be in *Tomaj\Prepositioner\Language* namespace if you would like to use Factory
