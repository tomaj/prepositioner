# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed
- **BREAKING**: Minimum PHP version is now 8.2
- **BREAKING**: Updated PHPUnit to ^10.0|^11.0
- Updated coding standard from PSR-2 to PSR-12
- Modernized CI/CD pipeline with single workflow
- Added PHPStan static analysis with strict rules
- Updated all development dependencies

### Added
- LICENSE file (MIT)
- CHANGELOG.md (Keep a Changelog format)
- CONTRIBUTING.md guidelines
- SECURITY.md policy
- Dependabot configuration
- GitHub issue and pull request templates
- .gitattributes for cleaner distribution archives
- Composer scripts for development workflow
- Comprehensive CI workflow testing PHP 8.2–8.5
- Automated security auditing

### Fixed
- Fixed phpunit.xml configuration for PHPUnit 11
- Fixed README typos
- Updated README with badges and contributing guidelines

## [3.0.0] - 2020-12-03

### Changed
- **BREAKING**: Minimum PHP version is now 7.3
- Added `declare(strict_types=1);` to all files
- **BREAKING**: Changed namespace for language files from `\Tomaj\Prepositioner\MyLanguage` to `\Tomaj\Prepositioner\Language\MyLanguage`

## [2.2.0] - 2019-11-25

### Added
- Added Romanian language support

## [2.1.0] - 2019-06-20

### Added
- Added EmptyLanguage for cases without prepositions

## [2.0.0] - 2018-08-08

### Changed
- **BREAKING**: Major refactoring and namespace reorganization

## [1.1.3] - 2014-07-25

### Fixed
- Bug fixes and improvements

## [1.1.2] - 2014-07-04

### Fixed
- Bug fixes and improvements

## [1.1.1] - 2014-07-03

### Fixed
- Bug fixes and improvements

## [1.1.0] - 2014-07-03

### Added
- New features and improvements

## [1.0.0] - 2014-06-26

### Added
- Initial release
- Slovak and Czech language support
- Factory for building prepositioners
- HTML support

[Unreleased]: https://github.com/tomaj/prepositioner/compare/3.0.0...HEAD
[3.0.0]: https://github.com/tomaj/prepositioner/compare/2.2.0...3.0.0
[2.2.0]: https://github.com/tomaj/prepositioner/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/tomaj/prepositioner/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/tomaj/prepositioner/compare/1.1.3...2.0.0
[1.1.3]: https://github.com/tomaj/prepositioner/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/tomaj/prepositioner/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/tomaj/prepositioner/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/tomaj/prepositioner/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/tomaj/prepositioner/releases/tag/1.0.0
