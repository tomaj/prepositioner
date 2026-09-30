<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\LanguageNotExistsException;
use PHPUnit\Framework\TestCase;



/**
 * @covers \Tomaj\Prepositioner\LanguageNotExistsException
 */
class LanguageNotExistsExceptionTest extends TestCase
{
    public function testExceptionCanBeThrown(): void
    {
        $this->expectException(LanguageNotExistsException::class);
        throw new LanguageNotExistsException('Test exception');
    }

    public function testExceptionMessage(): void
    {
        $message = 'Language does not exist';

        try {
            throw new LanguageNotExistsException($message);
        } catch (LanguageNotExistsException $e) {
            $this->assertEquals($message, $e->getMessage());
        }
    }

    public function testExceptionIsException(): void
    {
        $exception = new LanguageNotExistsException('Test');
        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
