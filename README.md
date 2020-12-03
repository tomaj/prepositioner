Prepositioner
=============

PHP Prepositioner for replacing prepositions with &amp;nbsp; after preposition

[![Code Climate](https://codeclimate.com/github/tomaj/prepositioner/badges/gpa.svg)](https://codeclimate.com/github/tomaj/prepositioner)
[![Test Coverage](https://api.codeclimate.com/v1/badges/d82eb747d9ac33571be3/test_coverage)](https://codeclimate.com/github/tomaj/prepositioner/test_coverage)
[![Latest Stable Version](https://poser.pugx.org/tomaj/prepositioner/v/stable.svg)](https://packagist.org/packages/tomaj/prepositioner)
[![License](https://poser.pugx.org/tomaj/prepositioner/license.svg)](https://packagist.org/packages/tomaj/prepositioner)


Instalation
-----------

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

This example replaces all occurences of *'one'* or *'two'* strings in ```$inputText``` as *'one&amp;nbsp;'* and *'two&amp;nbsp;'*.

For using with *Factory* which contains language support try:

``` php
$prepositioner = Tomaj\Prepositioner\Factory::build('slovak')
$prepositioner->formatText($inputText);
```

Extending
---------

For new language support you need to implement new language class which implements *LanguageInterface* with prepositions. See *SlovakLanguage* for details.


Upgrade
-------

**From version 2 to 3**
- Minimum php version is **7.3** from now
- If you are using custom *Language* file from otside or from this repository (and don't use `Tomaj\Prepositioner\Factory`) you have to change namespace from `\Tomaj\Prepositioner\MyLanguage` to `\Tomaj\Prepositioner\Language\MyLanguage`
- *Note:* new version includes `declare(strict_types=1);` in all files


Known issue
-----------

1. each new language has to be in *Tomaj\Prepositioner\Language* namespace if you would like to use Factory
