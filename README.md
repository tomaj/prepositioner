Prepositioner
=============

PHP Prepositioner for replacing prepositions with &amp;nbsp; after preposition

[![Build Status](https://secure.travis-ci.org/tomaj/prepositioner.png)](http://travis-ci.org/tomaj/prepositioner)
[![Code Climate](https://codeclimate.com/github/tomaj/prepositioner/badges/gpa.svg)](https://codeclimate.com/github/tomaj/prepositioner)
[![Coverage Status](https://coveralls.io/repos/tomaj/prepositioner/badge.png?branch=master)](https://coveralls.io/r/tomaj/prepositioner?branch=master)

[![Latest Stable Version](https://poser.pugx.org/tomaj/prepositioner/v/stable.svg)](https://packagist.org/packages/tomaj/prepositioner)
[![Latest Unstable Version](https://poser.pugx.org/tomaj/prepositioner/v/unstable.svg)](https://packagist.org/packages/tomaj/prepositioner)
[![License](https://poser.pugx.org/tomaj/prepositioner/license.svg)](https://packagist.org/packages/tomaj/prepositioner)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/02301f01-c9e9-4a73-9fdb-40a9170c3042/big.png)](https://insight.sensiolabs.com/projects/02301f01-c9e9-4a73-9fdb-40a9170c3042)

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


Known issue
-----------

1. each new language has to be in *Tomaj\Prepositioner\Language* namespace if you would like to use Factory
