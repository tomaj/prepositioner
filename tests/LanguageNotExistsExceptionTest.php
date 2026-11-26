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
            self::assertSame($message, $e->getMessage());
        }
    }

    public function testExceptionIsException(): void
    {
        self::assertTrue(new \ReflectionClass(LanguageNotExistsException::class)->isSubclassOf(\Exception::class));
    }
}
