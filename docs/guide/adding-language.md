# Adding a Language

Want to add support for a new language? This guide will walk you through the process.

## Overview

Adding a new language to Prepositioner involves three main steps:

1. Create a language class that implements `LanguageInterface`
2. Create tests for the new language
3. Submit a pull request

## Step 1: Create the Language Class

Create a new file in `src/Prepositioner/Language/` with the name pattern `{Language}Language.php`.

### Structure

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class EnglishLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            // Add all prepositions for your language
            'a', 'an', 'the',
            'in', 'on', 'at', 'to', 'for',
            'of', 'from', 'with', 'by',
            // ... more prepositions
        ];
    }
}
```

### Guidelines

**What to include:**
- Single-letter prepositions
- Multi-letter prepositions
- Common prepositional phrases if appropriate for the language

**What NOT to include:**
- Multi-syllable or very long prepositions (they rarely cause line-break issues)
- Prepositions that are commonly used at the end of sentences
- Words that are only sometimes used as prepositions

**Tips:**
- Research the language's grammar rules
- Check typography guides for that language
- Look at existing implementations (Slovak, Czech, Romanian) for inspiration
- Test with real text samples from the language

### Example: Adding German

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class GermanLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            // Two-way prepositions
            'an', 'auf', 'in', 'über', 'unter', 'vor', 'hinter', 'neben', 'zwischen',
            
            // Accusative prepositions
            'durch', 'für', 'gegen', 'ohne', 'um', 'bis', 'entlang',
            
            // Dative prepositions
            'aus', 'bei', 'mit', 'nach', 'seit', 'von', 'zu',
            
            // Genitive prepositions
            'wegen', 'während', 'trotz', 'statt',
        ];
    }
}
```

## Step 2: Create Tests

Create a test file in `tests/Language/` with the name pattern `{Language}LanguageTest.php`.

### Basic Test Structure

Extend `LanguageTestCase` to get automatic contract verification:

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use Tomaj\Prepositioner\Language\EnglishLanguage;
use Tomaj\Prepositioner\Language\LanguageInterface;
use Tomaj\Prepositioner\Tests\LanguageTestCase;

#[CoversClass(EnglishLanguage::class)]
class EnglishLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): LanguageInterface
    {
        return new EnglishLanguage();
    }
}
```

The `LanguageTestCase` base class automatically verifies:
- Returns an array
- Contains at least one preposition
- All prepositions are non-empty strings
- No duplicate prepositions
- All prepositions contain only valid characters

### Additional Language-Specific Tests

Add tests that verify language-specific requirements:

```php
<?php

public function testContainsCommonPrepositions(): void
{
    $language = $this->createLanguage();
    $result = $language->prepositions();
    
    // Test that common prepositions are included
    self::assertContains('the', $result);
    self::assertContains('in', $result);
    self::assertContains('on', $result);
    self::assertContains('at', $result);
}

public function testPrepositionsAreLowercase(): void
{
    $language = $this->createLanguage();
    $result = $language->prepositions();
    
    foreach ($result as $preposition) {
        self::assertEquals(
            strtolower($preposition),
            $preposition,
            "Preposition '{$preposition}' should be lowercase"
        );
    }
}
```

### Integration Test

Create a test that verifies the language works with the Factory:

```php
<?php

public function testFactoryIntegration(): void
{
    $prepositioner = \Tomaj\Prepositioner\Factory::build('english');
    
    $input = "The book is on a table in the room.";
    $result = $prepositioner->formatText($input);
    
    // Verify that prepositions are properly processed
    self::assertStringContainsString('&nbsp;', $result);
}
```

### Test with Real Sentences

Add tests with actual sentences in the language:

```php
<?php

public function testRealSentence(): void
{
    $prepositioner = \Tomaj\Prepositioner\Factory::build('english');
    
    $input = "I went to the store in the morning.";
    $result = $prepositioner->formatText($input);
    
    // Verify specific prepositions are replaced
    self::assertStringContainsString('to&nbsp;the', $result);
    self::assertStringContainsString('in&nbsp;the', $result);
}
```

## Step 3: Run Tests

Before submitting, ensure all tests pass:

```bash
# Run all tests
composer test

# Run only your language tests
vendor/bin/phpunit tests/Language/EnglishLanguageTest.php

# Run code style check
composer cs

# Run static analysis
composer phpstan

# Run all checks
composer check
```

## Step 4: Update Documentation

Add the new language to the README.md and documentation:

1. Update the "Supported Languages" section in README.md
2. Add a usage example
3. List the prepositions included

## Step 5: Submit a Pull Request

1. Fork the repository
2. Create a new branch: `git checkout -b add-language-english`
3. Commit your changes: `git commit -m "Add English language support"`
4. Push to your fork: `git push origin add-language-english`
5. Open a pull request on GitHub

### Pull Request Template

When opening the PR, include:

- **Language name** (in English and native name)
- **Number of prepositions** included
- **Source references** (grammar guides, typography standards)
- **Real-world examples** demonstrating the language works correctly
- **Why this language** (is there demand for it? Do you maintain projects using it?)

## Alternative: Language Support Request

If you don't want to implement it yourself, you can [create a language support request issue](https://github.com/tomaj/prepositioner/issues/new?template=language_support.md) describing:

- The language you'd like to see supported
- Why you need it
- Any references to grammar rules or typography standards

## Language Implementation Checklist

- [ ] Created `{Language}Language.php` in `src/Prepositioner/Language/`
- [ ] Implements `LanguageInterface`
- [ ] Uses `declare(strict_types=1);`
- [ ] Includes proper PHPDoc
- [ ] Has comprehensive list of prepositions
- [ ] Created `{Language}LanguageTest.php` in `tests/Language/`
- [ ] Extends `LanguageTestCase`
- [ ] Uses `#[CoversClass(...)]` attribute
- [ ] Includes language-specific tests
- [ ] Tests real sentences
- [ ] All tests pass
- [ ] Code style passes (`composer cs`)
- [ ] Static analysis passes (`composer phpstan`)
- [ ] Updated README.md
- [ ] Updated documentation

## Questions?

If you have questions about adding a language:

1. Check existing language implementations for examples
2. Review the [Contributing Guide](/contributing)
3. Open a discussion on GitHub
4. Ask in your pull request

We're happy to help you add support for your language!
