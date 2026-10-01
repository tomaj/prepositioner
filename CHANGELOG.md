# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [4.0.0] - 2026-10-01

### Changed
- **BREAKING**: Minimum PHP version is now 8.2
- **BREAKING**: All regex patterns now use `/u` modifier for proper Unicode/UTF-8 support
- **BREAKING**: `Prepositioner::formatText()` now throws `PrepositionerException` on regex errors (previously returned original text silently)
- **BREAKING**: `Factory::build()` now validates that language classes implement `LanguageInterface` and throws exception with clearer message
- Updated coding standard from PSR-2 to PSR-12
- Modernized CI/CD pipeline with single unified workflow
- Updated all development dependencies to latest versions
- Switched from Travis CI to GitHub Actions
- Improved type hints in Prepositioner class (array and string types)

### Added
- LICENSE file (MIT, 2014-2026)
- CHANGELOG.md following Keep a Changelog format
- CONTRIBUTING.md with development guidelines
- SECURITY.md with security policy
- CODE_OF_CONDUCT.md (Contributor Covenant 2.1)
- Dependabot configuration for automated dependency updates
- GitHub issue templates (bug report, feature request, language support) with config linking to security policy
- GitHub pull request template
- .gitattributes for cleaner distribution archives
- Composer scripts for development workflow (test, cs, phpstan, infection, check, check-all)
- Composer archive configuration to exclude development files
- PHPStan static analysis with level max and strict rules
- Comprehensive CI workflow testing PHP 8.2, 8.3, 8.4, and 8.5
- Mutation testing with Infection (95% MSI threshold, 100% achieved)
- Separate CI job for mutation testing
- Automated security auditing with `composer audit`
- `PrepositionerException` class for proper error handling
- Unicode support: prepositions with diacritics and capital letters outside ASCII now work correctly (e.g., "Či", "În")
- Proper escaping: `preg_quote()` is now used for all prepositions and escape strings
- Comprehensive integration tests with real sentences in Slovak, Czech, and Romanian
- Exception handling tests for regex errors and invalid language classes
- Robustness tests: idempotence, text loss prevention, HTML preservation, long inputs, invalid UTF-8 handling
- Property-based tests with data providers for edge case coverage
- `LanguageTestCase` abstract base class for easier language addition with automatic contract verification
- Integration examples for Nette/Latte, Twig, Laravel, and Symfony in README
- Detailed language addition guide in CONTRIBUTING

### Fixed
- Updated phpunit.xml configuration for PHPUnit 11 compatibility
- Fixed typos in README (Installation, occurrences, outside, missing semicolon)
- Added missing badges to README (CI, Packagist, PHP version, license, downloads)
- Added upgrade guide from 3.x to 4.x in README
- Fixed PSR-12 compliance issues across codebase

## [3.0.0] - 2020-12-03

### Changed
- **BREAKING**: Minimum PHP version is now 7.2
- **BREAKING**: Changed namespace for language classes from `\Tomaj\Prepositioner\Languages\*` to `\Tomaj\Prepositioner\Language\*`
- Added `declare(strict_types=1);` to all PHP files
- Removed support for PHP < 7.2

### Added
- Added `EmptyLanguage` class for cases without prepositions
- Added language-specific test classes

## [2.2.0] - 2019-11-25

### Changed
- Respect opening quotation marks in text processing (#4)

## [2.1.0] - 2019-06-20

### Added
- Added Romanian language support (#3)

## [2.0.0] - 2018-08-08

### Changed
- **BREAKING**: Added Czech language support
- Added type hints to method signatures
- Major refactoring and code improvements

## [1.1.3] - 2014-07-25

### Changed
- Removed multiple-syllable prepositions to improve accuracy

## [1.1.2] - 2014-07-04

### Added
- Added Factory support for creating Prepositioner with custom escape string

## [1.1.1] - 2014-07-03

### Fixed
- Fixed bug with multiple consecutive prepositions in sequence

## [1.1.0] - 2014-07-03

### Added
- Added ability to escape prepositions that should not be replaced with `&nbsp;`
- Prepositions can be wrapped with escape markers to prevent replacement

## [1.0.0] - 2014-06-26

### Added
- Initial release
- Slovak language support
- Factory pattern for building prepositioners
- HTML content support
- Automatic replacement of spaces after single-letter prepositions with `&nbsp;`

[Unreleased]: https://github.com/tomaj/prepositioner/compare/4.0.0...HEAD
[4.0.0]: https://github.com/tomaj/prepositioner/compare/3.0.0...4.0.0
[3.0.0]: https://github.com/tomaj/prepositioner/compare/2.2.0...3.0.0
[2.2.0]: https://github.com/tomaj/prepositioner/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/tomaj/prepositioner/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/tomaj/prepositioner/compare/1.1.3...2.0.0
[1.1.3]: https://github.com/tomaj/prepositioner/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/tomaj/prepositioner/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/tomaj/prepositioner/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/tomaj/prepositioner/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/tomaj/prepositioner/releases/tag/1.0.0
