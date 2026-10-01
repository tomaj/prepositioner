<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\LanguageNotExistsException;

#[CoversClass(LanguageNotExistsException::class)]
class LanguageNotExistsExceptionTest extends TestCase
{
    public function testExceptionCanBeThrown(): void
    {
        self::expectException(LanguageNotExistsException::class);
        throw new LanguageNotExistsException('Test exception');
    }

    public function testExceptionMessage(): void
    {
        $message = 'Language does not exist';

        try {
            throw new LanguageNotExistsException($message);
        } catch (LanguageNotExistsException $e) {
            self::assertEquals($message, $e->getMessage());
        }
    }

    public function testExceptionIsException(): void
    {
        $exception = new LanguageNotExistsException('Test');
        self::assertInstanceOf(\Exception::class, $exception);
    }
}
