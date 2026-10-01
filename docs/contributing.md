# Contributing

Thank you for considering contributing to Prepositioner!

## Quick Links

- [Code of Conduct](https://github.com/tomaj/prepositioner/blob/master/CODE_OF_CONDUCT.md)
- [Contribution Guidelines](https://github.com/tomaj/prepositioner/blob/master/CONTRIBUTING.md)
- [Security Policy](https://github.com/tomaj/prepositioner/blob/master/SECURITY.md)

## How to Contribute

### Reporting Bugs

Found a bug? Please check [existing issues](https://github.com/tomaj/prepositioner/issues) first to avoid duplicates.

When reporting a bug, include:
- A clear and descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- Your environment (PHP version, OS, etc.)
- Code samples if applicable

[Report a bug →](https://github.com/tomaj/prepositioner/issues/new?template=bug_report.md)

### Suggesting Features

Have an idea for a new feature? We'd love to hear it!

When suggesting a feature, include:
- A clear and descriptive title
- Detailed description of the proposed feature
- Examples of how it would be used
- Why this enhancement would be useful

[Request a feature →](https://github.com/tomaj/prepositioner/issues/new?template=feature_request.md)

### Adding Language Support

Want to add support for a new language? Check out our [Adding a Language Guide](/guide/adding-language).

[Request language support →](https://github.com/tomaj/prepositioner/issues/new?template=language_support.md)

### Contributing Code

1. **Fork the repository** and create your branch from `master`
2. **Make your changes** following the coding standards
3. **Write or update tests** as needed
4. **Ensure all tests pass**
5. **Run code quality checks**
6. **Update documentation** if needed
7. **Submit a pull request**

## Development Setup

### Prerequisites

- PHP 8.2 or higher
- Composer

### Installation

```bash
git clone https://github.com/tomaj/prepositioner.git
cd prepositioner
composer install
```

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
vendor/bin/phpunit --coverage-html build/coverage
```

### Code Style

```bash
# Check code style
composer cs

# Fix code style automatically
composer cs-fix
```

### Static Analysis

```bash
composer phpstan
```

### Mutation Testing

```bash
composer infection
```

### All Checks

```bash
# Run all checks (code style, static analysis, tests)
composer check

# Run all checks including mutation testing
composer check-all
```

## Coding Standards

- Follow **PSR-12** coding standard
- Use strict types: `declare(strict_types=1);`
- Add type hints to all parameters and return types
- Write PHPDoc blocks for classes and methods
- Keep methods small and focused
- Write meaningful test names

## Testing Guidelines

- Write tests for all new features
- Maintain or improve code coverage (target: ≥90%)
- Use meaningful test method names
- Cover edge cases and error conditions
- Use `#[CoversClass(...)]` attributes on test classes

## Pull Request Guidelines

- **One feature per PR** - Keep PRs focused
- **Write clear commit messages** - Use present tense and imperative mood
- **Reference issues** - Link to related issues in your PR description
- **Update tests and docs** - Keep everything in sync
- **Be responsive** - Address review feedback promptly

## Code of Conduct

This project adheres to the [Contributor Covenant Code of Conduct](https://github.com/tomaj/prepositioner/blob/master/CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## Security Issues

If you discover a security vulnerability, please email tomasmajer@gmail.com instead of using the issue tracker. See [SECURITY.md](https://github.com/tomaj/prepositioner/blob/master/SECURITY.md) for details.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

## Questions?

- Open a [discussion](https://github.com/tomaj/prepositioner/discussions)
- Ask in your pull request
- Check existing issues and PRs

## Documentation Versioning

For maintainers: See [Versioning Docs](/guide/versioning) for instructions on archiving documentation when releasing new major versions.

Thank you for contributing! 🎉
