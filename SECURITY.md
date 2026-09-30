# Security Policy

## Supported Versions

We actively support the following versions with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 4.x     | :white_check_mark: |
| 3.x     | :x:                |
| 2.x     | :x:                |
| 1.x     | :x:                |

## Reporting a Vulnerability

We take security seriously. If you discover a security vulnerability, please follow these steps:

### Do Not

- **Do not** open a public GitHub issue
- **Do not** disclose the vulnerability publicly until it has been addressed

### Do

1. **Email** the maintainer directly at: tomasmajer@gmail.com
2. Include:
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if any)

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity
  - Critical: Within 7 days
  - High: Within 30 days
  - Medium: Within 90 days
  - Low: Next minor release

### Disclosure Policy

Once a fix is available:

1. A new version will be released
2. Security advisory will be published on GitHub
3. Credit will be given to the reporter (unless anonymity is requested)

## Security Best Practices

When using this library:

- Keep your PHP version up to date
- Regularly update dependencies
- Use Composer's `audit` command to check for vulnerabilities
- Follow least privilege principle in your application
- Sanitize all user input before processing

## Known Limitations

This library processes text using regular expressions. While we strive to handle all edge cases safely:

- Complex HTML structures may not be fully supported
- Malformed input could produce unexpected results
- The library does not provide XSS protection (sanitize your output)

## Dependencies

This library has minimal dependencies. Monitor security advisories for:

- PHPUnit (dev dependency only)
- PHP_CodeSniffer (dev dependency only)
- PHPStan (dev dependency only)

## Questions?

For security-related questions that are not sensitive, you can open a discussion on GitHub.
