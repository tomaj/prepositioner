# Getting Started

## What is Prepositioner?

Prepositioner is a PHP library that automatically replaces spaces after prepositions with non-breaking spaces (`&nbsp;`). This improves typography by preventing single-letter prepositions from appearing at the end of a line, which is considered poor typographic practice in Slovak, Czech, and Romanian languages.

::: tip Why Non-Breaking Spaces?
In Slovak, Czech, and Romanian typography, single-letter prepositions should never appear at the end of a line. Non-breaking spaces ensure the preposition stays with the following word.
:::

## Installation

Install the library via Composer:

```bash
composer require tomaj/prepositioner
```

::: info Requirements
PHP 8.2 or higher
:::

## Quick Start

### Basic Usage

The simplest way to use Prepositioner is by creating an instance with a list of prepositions:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a', 'o', 'v', 'z']);
$text = "V Bratislave a v Prahe.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "V&nbsp;Bratislave a&nbsp;v&nbsp;Prahe."
```

### Using the Factory with Built-in Languages

The recommended approach is to use the Factory class with built-in language support:

```php
<?php

use Tomaj\Prepositioner\Factory;

// For Slovak
$prepositioner = Factory::build('slovak');
$result = $prepositioner->formatText('Išiel som do obchodu v meste.');
// Output: "Išiel som do&nbsp;obchodu v&nbsp;meste."

// For Czech
$prepositioner = Factory::build('czech');
$result = $prepositioner->formatText('Byl jsem v Praze a v Brně.');
// Output: "Byl jsem v&nbsp;Praze a&nbsp;v&nbsp;Brně."

// For Romanian
$prepositioner = Factory::build('romanian');
$result = $prepositioner->formatText('Merg la București și la Cluj.');
// Output: "Merg la&nbsp;București și la&nbsp;Cluj."
```

### HTML Content Support

Prepositioner safely handles HTML content:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<p>V Bratislave a v Prahe.</p>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<p>V&nbsp;Bratislave a&nbsp;v&nbsp;Prahe.</p>"
```

::: warning Important
HTML attributes and tags are preserved and not modified. Only text content is processed.
:::

### Escaping Prepositions

If you need to prevent certain prepositions from being replaced, wrap them with escape markers:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a'], '#####');
$text = "Word a text but not #####a##### this one.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Word a&nbsp;text but not a this one."
```

## What's Next?

- [View more examples](/guide/examples) to see Prepositioner in action
- [Learn about supported languages](/guide/languages) and their preposition rules
- [Understand how it works](/guide/how-it-works) under the hood
- [Integrate with your framework](/guide/examples#framework-integration)
