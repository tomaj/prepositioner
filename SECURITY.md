# Security Policy

## Supported Versions

Only the latest major version receives security updates.

| Version | Supported          |
| ------- | ------------------ |
| 4.x     | :white_check_mark: |
| 3.x     | :x:                |
| < 3.0   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability, please report it responsibly:

### Private Vulnerability Reporting (Recommended)

Use GitHub's [Private Vulnerability Reporting](https://docs.github.com/en/code-security/security-advisories/guidance-on-reporting-and-writing/privately-reporting-a-security-vulnerability) feature to submit your report directly and securely.

### Email

Alternatively, email security concerns to: **tomasmajer@gmail.com**

Please include:
- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Suggested fix (if any)

## Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Fix Timeline**: Depends on severity (critical issues prioritized)

## What to Expect

- We will acknowledge your report and work with you to understand the issue
- We will keep you informed of our progress
- Once fixed, we will publicly credit you (unless you prefer to remain anonymous)
- Security advisories will be published for confirmed vulnerabilities

## Scope

This library has **zero runtime dependencies** and minimal attack surface. Security concerns typically involve:
- Input validation and sanitization
- Regular expression denial of service (ReDoS)
- Unexpected behavior with malformed input

Thank you for helping keep this project secure!
