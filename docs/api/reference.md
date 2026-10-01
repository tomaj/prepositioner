# API Reference

Complete reference for all public classes and methods in the Prepositioner library.

::: info Namespace
All classes are under the `Tomaj\Prepositioner` namespace.
:::

## Prepositioner Class

The main class for text processing.

### Constructor

```php
public function __construct(array $prepositionsArray, string $escapeString = '#####')
```

Creates a new Prepositioner instance.

**Parameters:**
- `$prepositionsArray` (array<int, string>) - Array of prepositions to replace
- `$escapeString` (string, optional) - String used to escape prepositions that should not be replaced. Default: `'#####'`

**Example:**

```php
<?php

$prepositioner = new Prepositioner(['a', 'v', 'o']);
$prepositioner = new Prepositioner(['a', 'v', 'o'], '***'); // Custom escape string
```

### formatText()

```php
public function formatText(string $text): string
```

Processes the input text and replaces spaces after prepositions with non-breaking spaces.

**Parameters:**
- `$text` (string) - The text to process

**Returns:**
- (string) - The processed text with non-breaking spaces

**Throws:**
- `PrepositionerException` - If regex processing fails (malformed UTF-8, pattern limits exceeded, etc.)

::: warning Breaking Change in v4.0
Since version 4.0, this method throws `PrepositionerException` on errors. Previously it returned the original text silently.
:::

**Example:**

```php
<?php

$prepositioner = new Prepositioner(['a', 'v']);
$result = $prepositioner->formatText('Text a more text v even more.');
// Returns: "Text a&nbsp;more text v&nbsp;even more."
```

**Error Handling:**

```php
<?php

use Tomaj\Prepositioner\PrepositionerException;

try {
    $result = $prepositioner->formatText($text);
} catch (PrepositionerException $e) {
    // Handle error
    error_log($e->getMessage());
}
```

## Factory Class

Factory for creating Prepositioner instances with built-in language support.

### build()

```php
public static function build(string $language, string $escapeString = '#####'): Prepositioner
```

Creates a Prepositioner instance for the specified language.

**Parameters:**
- `$language` (string) - Language identifier: `'slovak'`, `'czech'`, `'romanian'`, or `'empty'`
- `$escapeString` (string, optional) - String used to escape prepositions. Default: `'#####'`

**Returns:**
- (Prepositioner) - A configured Prepositioner instance

**Throws:**
- `LanguageNotExistsException` - If the language class doesn't exist or doesn't implement `LanguageInterface`

**Example:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$prepositioner = Factory::build('czech', '***'); // With custom escape string
```

**Error Handling:**

```php
<?php

use Tomaj\Prepositioner\LanguageNotExistsException;

try {
    $prepositioner = Factory::build('unknown');
} catch (LanguageNotExistsException $e) {
    // Language not found
    echo "Error: " . $e->getMessage();
}
```

## Language Interface

Interface that all language classes must implement.

### LanguageInterface

```php
interface LanguageInterface
{
    /**
     * @return array<int, string>
     */
    public function prepositions(): array;
}
```

**Methods:**
- `prepositions()` - Returns an array of prepositions for the language

**Example Implementation:**

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class SlovakLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return ['a', 'i', 'k', 'o', 'v', 'u', 'z', 's', /* ... */];
    }
}
```

## Built-in Language Classes

### SlovakLanguage

```php
class SlovakLanguage implements LanguageInterface
```

Slovak language implementation with 27 prepositions.

**Usage:**

```php
<?php

use Tomaj\Prepositioner\Language\SlovakLanguage;
use Tomaj\Prepositioner\Prepositioner;

$language = new SlovakLanguage();
$prepositioner = new Prepositioner($language->prepositions());

// Or use Factory:
$prepositioner = Factory::build('slovak');
```

**Prepositions:**
- 1-letter: a, i, k, o, v, u, z, s
- 2-letter: do, od, zo, ku, na, po, so, za, vo, či
- 3-letter: cez, pre, nad, pod, pri
- 4-letter: spod, pred, skrz

### CzechLanguage

```php
class CzechLanguage implements LanguageInterface
```

Czech language implementation with 19 prepositions.

**Usage:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
```

**Prepositions:**
- 1-letter: a, i, k, o, v, u, z, s
- 2-letter: do, na, od, po, ze, ku
- 3+-letter: nad, pod, př, před, při

### RomanianLanguage

```php
class RomanianLanguage implements LanguageInterface
```

Romanian language implementation with 16 prepositions.

**Usage:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
```

**Prepositions:**
- 2-letter: cu, de, în, la, pe
- 3-letter: cât, pro
- 4-letter: fără, până, prin, spre
- 5-letter: între, peste
- 6-letter: dintre, pentru

### EmptyLanguage

```php
class EmptyLanguage implements LanguageInterface
```

A language implementation with no prepositions. Useful for testing or when you need a Prepositioner instance that doesn't modify text.

**Usage:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$result = $prepositioner->formatText('Any text'); // Returns unchanged
```

## Exception Classes

### PrepositionerException

```php
class PrepositionerException extends \Exception
```

Thrown when regex processing fails in the `formatText()` method.

**Common causes:**
- Malformed UTF-8 in input text
- Pattern backtrack limit exceeded
- Pattern recursion limit exceeded
- PCRE JIT stack limit exceeded

**Example:**

```php
<?php

use Tomaj\Prepositioner\PrepositionerException;

try {
    $result = $prepositioner->formatText($text);
} catch (PrepositionerException $e) {
    // Error message includes specific PCRE error details
    error_log('Regex error: ' . $e->getMessage());
}
```

### LanguageNotExistsException

```php
class LanguageNotExistsException extends \Exception
```

Thrown by `Factory::build()` when:
- The language class doesn't exist
- The class doesn't implement `LanguageInterface`

**Example:**

```php
<?php

use Tomaj\Prepositioner\LanguageNotExistsException;

try {
    $prepositioner = Factory::build('nonexistent');
} catch (LanguageNotExistsException $e) {
    echo "Language not found: " . $e->getMessage();
}
```

## Type Definitions

### Preposition Array

```php
array<int, string>
```

An indexed array of preposition strings. Used in:
- `Prepositioner::__construct()`
- `LanguageInterface::prepositions()`

**Example:**

```php
['a', 'v', 'o', 'z', 's']
```

## Constants

The library does not define any public constants. The default escape string `'#####'` can be overridden in the constructor.

## Static Methods

### Factory::build()

The only public static method in the library. See [Factory Class](#factory-class) above.

## Namespace Structure

```
Tomaj\Prepositioner\
├── Prepositioner                    (main class)
├── Factory                          (factory class)
├── PrepositionerException           (exception)
├── LanguageNotExistsException       (exception)
└── Language\
    ├── LanguageInterface            (interface)
    ├── SlovakLanguage               (implementation)
    ├── CzechLanguage                (implementation)
    ├── RomanianLanguage             (implementation)
    └── EmptyLanguage                (implementation)
```

## PHP Version Compatibility

- **PHP 8.2+** required (as of version 4.0.0)
- Uses strict types: `declare(strict_types=1);`
- All methods have proper type hints

## Best Practices

::: tip Creating Instances
**Recommended:** Use Factory for built-in languages

```php
$prepositioner = Factory::build('slovak');
```

**Advanced:** Direct instantiation for custom prepositions

```php
$prepositioner = new Prepositioner(['custom', 'prepositions']);
```
:::

### Error Handling

::: warning Always Use Try-Catch
Always wrap `formatText()` in try-catch when processing user input:

```php
try {
    $result = $prepositioner->formatText($userInput);
} catch (PrepositionerException $e) {
    $result = $userInput; // Fallback to original
}
```
:::

### Reusing Instances

Create one instance and reuse it for multiple texts:

```php
$prepositioner = Factory::build('slovak');

foreach ($articles as $article) {
    $article->content = $prepositioner->formatText($article->content);
}
```

### Thread Safety

::: tip Stateless After Construction
Prepositioner instances are stateless after construction and safe to use across multiple threads or processes.
:::
