# Supported Languages

Prepositioner includes built-in support for three languages with their respective preposition rules.

::: info Language Overview
| Language | Code | Prepositions | Use Case |
|----------|------|--------------|----------|
| Slovak | `slovak` | 27 | slovenčina |
| Czech | `czech` | 19 | čeština |
| Romanian | `romanian` | 16 | română |
| Empty | `empty` | 0 | Testing/No processing |
:::

## Slovak (slovenčina)

To use Slovak language support:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
```

### Slovak Prepositions

The Slovak language implementation includes the following prepositions:

| Length | Prepositions |
|--------|-------------|
| 1-letter | a, i, k, o, v, u, z, s |
| 2-letter | do, od, zo, ku, na, po, so, za, vo, či |
| 3-letter | cez, pre, nad, pod, pri |
| 4-letter | spod, pred, skrz |

**Total: 27 prepositions**

### Example

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$text = "Išiel som v sobotu do obchodu s priateľom.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Išiel som v&nbsp;sobotu do&nbsp;obchodu s&nbsp;priateľom."
```

## Czech (čeština)

To use Czech language support:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
```

### Czech Prepositions

The Czech language implementation includes the following prepositions:

| Length | Prepositions |
|--------|-------------|
| 1-letter | a, i, k, o, v, u, z, s |
| 2-letter | do, na, od, po, ze, ku |
| 3+ letter | nad, pod, př, před, při |

**Total: 19 prepositions**

### Example

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
$text = "Byl jsem v Praze a v Brně před týdnem.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Byl jsem v&nbsp;Praze a&nbsp;v&nbsp;Brně před&nbsp;týdnem."
```

## Romanian (română)

To use Romanian language support:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
```

### Romanian Prepositions

The Romanian language implementation includes the following prepositions:

| Length | Prepositions |
|--------|-------------|
| 2-letter | cu, de, în, la, pe |
| 3-letter | cât, pro |
| 4-letter | fără, până, prin, spre |
| 5-letter | între, peste |
| 6-letter | dintre, pentru |

**Total: 16 prepositions**

### Example

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
$text = "Merg la București cu prietenii pentru vacanță.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Merg la&nbsp;București cu&nbsp;prietenii pentru&nbsp;vacanță."
```

## Empty Language

A special "empty" language is available when you need to instantiate a Prepositioner without any prepositions:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$text = "Any text with any words.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Any text with any words." (no changes)
```

This can be useful for testing or when you need a Prepositioner instance but don't want any text processing.

## Language Detection

::: warning No Automatic Detection
Prepositioner does **not** automatically detect the language of input text. You must explicitly choose which language to use when building the Prepositioner instance.
:::

For applications that need to process multiple languages, create separate instances:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioners = [
    'sk' => Factory::build('slovak'),
    'cs' => Factory::build('czech'),
    'ro' => Factory::build('romanian'),
];

// Use based on user's language preference
$userLang = 'sk';
$result = $prepositioners[$userLang]->formatText($text);
```

## Adding New Languages

Want to add support for another language? See the [Adding a Language](/guide/adding-language) guide for detailed instructions on how to contribute new language support.
