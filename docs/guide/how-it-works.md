# How It Works

This page explains the internal mechanics of Prepositioner and how it processes text.

::: info Technical Overview
Prepositioner uses regular expressions with Unicode support (`/u` modifier) to identify and replace spaces after prepositions with non-breaking spaces (`&nbsp;`).
:::

## Overview

Prepositioner uses regular expressions with Unicode support to identify prepositions in text and replace the space after them with a non-breaking space (`&nbsp;`). The library is designed to handle:

- **Plain text** - Simple text processing
- **HTML content** - Preserves HTML structure and attributes
- **UTF-8/Unicode** - Full support for characters with diacritics
- **Case insensitivity** - Matches prepositions regardless of case
- **Edge cases** - Multiple consecutive prepositions, quotation marks, etc.

## The Algorithm

### Step 1: Pattern Construction

When you create a Prepositioner instance, it builds a regex pattern from the provided prepositions:

```php
<?php

$prepositioner = new Prepositioner(['a', 'v', 'o']);
```

Internally, each preposition is properly escaped using `preg_quote()` to ensure special characters are treated literally:

```php
$quotedPrepositions = array_map(fn($p) => preg_quote($p, '/'), $prepositionsArray);
$prepositions = implode('|', $quotedPrepositions); // "a|v|o"
```

### Step 2: Regex Pattern

The main pattern that matches prepositions:

```regex
/(\s|^|>|;|quotationMarks)(prepositions)\s+(?=[^>]*(<|$))/iu
```

Let's break it down:

- `(\s|^|>|;|quotationMarks)` - Matches one of:
  - `\s` - whitespace
  - `^` - start of string
  - `>` - closing HTML tag
  - `;` - semicolon (for HTML entities)
  - Various quotation marks (`"`, `'`, `„`, `‚`, `"`, `'`, `«`, `‹`)

- `(prepositions)` - Matches any of the prepositions

- `\s+` - Matches one or more spaces after the preposition

- `(?=[^>]*(<|$))` - Lookahead assertion ensuring we're not inside an HTML tag

- `/iu` flags:
  - `i` - Case-insensitive matching
  - `u` - Unicode/UTF-8 support

### Step 3: Replacement

The matched text is replaced with:

```php
"$1$2&nbsp;"
```

Where:
- `$1` - The character before the preposition
- `$2` - The preposition itself
- `&nbsp;` - The non-breaking space

### Step 4: Double Application

The pattern is applied **twice** to handle consecutive prepositions:

```php
$text = $this->safePregReplace($pattern, $replacement, $text);
$text = $this->safePregReplace($pattern, $replacement, $text); // Applied again
```

This ensures that patterns like "a o text" correctly become "a&nbsp;o&nbsp;text".

### Step 5: Escape Markers

Finally, escape markers are removed:

```php
$escapePattern = "/{$quotedEscapeString}({$prepositions}){$quotedEscapeString}/iu";
$text = $this->safePregReplace($escapePattern, "$1", $text);
```

## HTML Processing

### Why HTML is Special

When processing HTML content, we must ensure that:

1. Prepositions inside HTML tags are **not** replaced
2. Prepositions in HTML attributes are **not** replaced
3. Only prepositions in actual text content are replaced

### The Lookahead Solution

The lookahead assertion `(?=[^>]*(<|$))` ensures we only match prepositions that are:
- Followed by characters that are NOT `>` (not inside a tag)
- Until we reach either `<` (start of next tag) or end of string

Example:

```html
<a href="/path/v/url">Text v článku</a>
```

- The `v` in `/path/v/url` is followed by `/url">`, which contains `>`, so it's not matched
- The `v` in "Text v článku" is followed by " článku", which doesn't contain `>` until the closing tag, so it's matched

## Unicode Support

### The `/u` Modifier

All regex patterns use the `/u` modifier, which enables Unicode support. This allows the library to correctly handle:

- **Prepositions with diacritics**: `č`, `ř`, `ž`, `ă`, `ț`, etc.
- **Capital letters outside ASCII**: `Č`, `Ř`, `În`, etc.
- **Proper case-insensitive matching**: Works correctly with Unicode characters

Example:

```php
$prepositioner = Factory::build('slovak');
$text = "Či ide v Bratislave?";
// "či" with diacritic is correctly matched as a preposition
// Output: "Či&nbsp;ide v&nbsp;Bratislave?"
```

### Before Version 4.0

::: warning Legacy Behavior
In versions before 4.0, the library did not use the `/u` modifier. This meant:
- Prepositions with diacritics outside ASCII didn't work correctly
- Case-insensitive matching was ASCII-only

Version 4.0 added proper Unicode support to fix these issues.
:::

## Error Handling

### Safe Regex Execution

The `safePregReplace()` method wraps all `preg_replace()` calls and checks for errors:

```php
private function safePregReplace(string $pattern, string $replacement, string $subject): string
{
    $result = preg_replace($pattern, $replacement, $subject);

    if ($result === null) {
        $error = preg_last_error();
        $errorMessage = $this->getPregErrorMessage($error);
        throw new PrepositionerException("preg_replace failed: {$errorMessage}");
    }

    return $result;
}
```

Possible errors include:
- `PREG_BACKTRACK_LIMIT_ERROR` - Pattern too complex
- `PREG_RECURSION_LIMIT_ERROR` - Pattern recursion limit reached
- `PREG_BAD_UTF8_ERROR` - Invalid UTF-8 in input
- `PREG_JIT_STACKLIMIT_ERROR` - JIT stack exhausted

In version 3.x and earlier, errors were silently ignored and the original text was returned. Version 4.0 throws explicit exceptions for better error handling.

::: tip Best Practice
Always wrap `formatText()` calls in try-catch blocks when processing user input or untrusted content.
:::

## Escaping Mechanism

### How Escaping Works

You can prevent specific prepositions from being replaced by wrapping them with escape markers:

```php
$prepositioner = new Prepositioner(['a'], '#####');
$text = "Replace a here but not #####a##### here.";
$result = $prepositioner->formatText($text);
// Output: "Replace a&nbsp;here but not a here."
```

The process:

1. **During replacement**: Escaped prepositions are protected by their markers and not matched by the main pattern
2. **After replacement**: The escape markers are removed, leaving the preposition with a normal space

This is useful when you have abbreviations or other cases where a preposition-like word should not be treated as a preposition.

## Quotation Marks

The library respects quotation marks and correctly handles prepositions at the start of quoted text:

```php
$prepositioner = Factory::build('slovak');
$text = 'Povedal: "V meste je pekne."';
// Output: 'Povedal: "V&nbsp;meste je pekne."'
```

Supported quotation marks:
- `"` - Straight double quote
- `'` - Straight single quote
- `„` - German/Czech opening quote (U+201E)
- `‚` - Single low quote (U+201A)
- `"` - Left double quote (U+201C)
- `'` - Left single quote (U+2018)
- `«` - Left double angle quote
- `‹` - Left single angle quote

## Performance Considerations

### Regex Compilation

The regex pattern is constructed once when the Prepositioner instance is created, not on every `formatText()` call.

### Multiple Passes

The pattern is applied twice to handle consecutive prepositions. For most texts, this is fast enough. For very large texts (100k+ characters), consider:
- Processing in chunks
- Caching results
- Using escape markers to skip sections that don't need processing

### HTML Complexity

The lookahead assertion adds some overhead when processing HTML. For plain text, consider using a prepositioner with simpler patterns if you need maximum performance.
