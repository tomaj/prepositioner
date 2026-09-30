# Contributing to Prepositioner

Thank you for considering contributing to Prepositioner! This document provides guidelines and instructions for contributing.

## Code of Conduct

Be respectful and professional when interacting with the community.

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

To add support for a new language:

1. Create a new class in `src/Prepositioner/Language/` implementing `LanguageInterface`
2. Add all prepositions for that language in the `prepositions()` method
3. Create tests in `tests/Language/` covering the prepositions
4. Update the README with the new language

Example:

```php
<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class EnglishLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return ['a', 'an', 'the', 'in', 'on', 'at', /* ... */];
    }
}
```

### Pull Requests

1. Fork the repository and create your branch from `master`
2. Follow the coding standards (PSR-12)
3. Write or update tests as needed
4. Ensure all tests pass
5. Run static analysis and code style checks
6. Update documentation if needed
7. Write a clear commit message

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

```bash
composer cs
```

### Auto-fix Code Style

```bash
composer cs-fix
```

### Static Analysis

```bash
composer phpstan
```

### Run All Checks

```bash
composer check
```

## Coding Standards

- Follow PSR-12 coding standard
- Use strict types: `declare(strict_types=1);`
- Add type hints to all parameters and return types
- Write PHPDoc blocks for classes and methods
- Keep methods small and focused
- Write meaningful test names

## Testing

- Write tests for all new features
- Maintain or improve code coverage (target: ≥95%)
- Use meaningful test method names describing what is being tested
- Cover edge cases and error conditions
- Add `@covers` annotations to test classes

## Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests when applicable

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
