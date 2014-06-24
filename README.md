Prepositioner
=============

PHP Prepositioner for replacing prepositions with &amp;nbsp; after preposition

Instalation
-----------

Install package via composer:

```
$ composer require tomaj/prepositioner
```

Usage
-----

Simple usage without *Factory* is very simple:

```
$prepositioner = new Tomaj\Prepositioner\Prepositioner(array('one', 'two'));
$prepositioner->formatText($inputText);
```

This example replace all occurences of *'one'* or *'two'* strings in ```$inputText``` as *'one&amp;nbsp;'* and *'two&amp;nbsp;'*.

For using with *Factory* which contains language support try:

```
$prepositioner = Tomaj\Prepositioner\Factory::build('slovak')
$prepositioner->formatText($inputText);
```

Extending
---------

For new language support you need to implement new language class which implements *LanguageInterface* with prepositions. See *SlovakLanguage* for details.


Known issue
-----------

1. each new language has to be in *Tomaj\Prepositioner* namespace
