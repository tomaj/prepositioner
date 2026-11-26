# Contributing to Prepositioner

Thank you for considering contributing to Prepositioner! This document provides guidelines and instructions for contributing.

## Code of Conduct

This project adheres to the [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to tomasmajer@gmail.com.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When creating a bug report, include:

- A clear and descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- Your environment (PHP version, OS, etc.)
- Code samples if applicable

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, include:

- A clear and descriptive title
- Detailed description of the proposed feature
- Examples of how it would be used
- Why this enhancement would be useful

### Adding New Language Support

We welcome contributions of new language support! To add a new language:

1. **Create the language class** in `src/Prepositioner/Language/` implementing `LanguageInterface`:

```php
<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class EnglishLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            'a', 'an', 'the',
            'in', 'on', 'at', 'to', 'for',
            'of', 'from', 'with', 'by',
            // Add all prepositions for your language
        ];
    }
}
```

2. **Create tests** in `tests/Language/` by extending `LanguageTestCase`:

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
    
    // Add language-specific tests if needed
    public function testContainsCommonPrepositions(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();
        
        self::assertContains('the', $result);
        self::assertContains('in', $result);
        self::assertContains('on', $result);
    }
}
```

The `LanguageTestCase` base class automatically verifies that your language:
- Returns an array
- Contains at least one preposition (or empty for EmptyLanguage)
- All prepositions are non-empty strings
- All prepositions are unique (no duplicates)
- Prepositions contain only valid characters (letters, spaces, hyphens, apostrophes)

3. **Update the README** with the new language in the usage section

4. **Open a pull request** or [create a language support request issue](https://github.com/tomaj/prepositioner/issues/new?template=language_support.md)

### Pull Requests

1. Fork the repository and create your branch from `master`
2. Follow the coding standards (PER coding style, `composer phpcs`)
3. Write or update tests as needed
4. Ensure all tests pass
5. Run static analysis and code style checks
6. Update documentation if needed
7. Write a clear commit message

## Documentation

Documentation lives in the `docs/` directory and is built with VitePress. See the [online documentation](https://tomaj.github.io/prepositioner/) for the latest version.

### Building Documentation Locally

```bash
cd docs
npm install
npm run docs:dev    # Start development server
npm run docs:build  # Build for production
```

### Documentation Versioning

For maintainers: When releasing a new major version, the documentation should be archived. See the [Versioning Docs](https://tomaj.github.io/prepositioner/guide/versioning.html) guide for detailed instructions on how to create archived documentation versions.

## Development Workflow

### Setup

```bash
composer install
```

### Running Tests

```bash
composer test
```

### Code Style Check

Code style is checked with [PHP-CS-Fixer](https://cs.symfony.com/) (PER-CS + PHP 8.4 migration rules, `.php-cs-fixer.dist.php`):

```bash
composer phpcs
```

### Auto-fix Code Style

```bash
composer cs-fix
```

### Static Analysis

PHPStan at level max with bleeding edge, strict, deprecation and PHPUnit rules, over `src` and `tests`, without a baseline file:

```bash
composer phpstan
```

### Rector

`rector.php` applies the PHP 8.4 set plus the dead code, code quality and type declaration sets. The dry run must report no changes:

```bash
composer rector       # dry run
composer rector-fix   # apply the changes
```

### Coverage

```bash
composer coverage     # Clover in build/logs, HTML in build/coverage (needs Xdebug)
```

### Mutation Testing

Mutation testing helps ensure test quality by modifying the code and checking if tests catch the changes:

```bash
composer infection
```

This runs [Infection](https://infection.github.io/) mutation testing framework. The project maintains:
- Minimum MSI (Mutation Score Indicator): 95%
- Minimum Covered Code MSI: 95%

Equivalent mutants (quotation mark escaping, error message formatting) are explicitly ignored in configuration.

### Run All Checks

```bash
composer check        # code style, PHPStan, Rector, tests
composer infection    # mutation testing, run separately
```

## Coding Standards

- Follow the PER coding style (checked by PHP-CS-Fixer)
- Use strict types: `declare(strict_types=1);`
- Add type hints to all parameters and return types
- Write PHPDoc blocks for classes and methods
- Keep methods small and focused
- Write meaningful test names

## Testing

- Write tests for all new features
- Maintain or improve code coverage (target: ≥90%)
- Use meaningful test method names describing what is being tested
- Cover edge cases and error conditions
- Use `#[CoversClass(...)]` attributes on test classes
- Write tests that would fail if the implementation is incorrect (verified via mutation testing)

## Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests when applicable

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
