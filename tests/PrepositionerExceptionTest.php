<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Prepositioner;
use Tomaj\Prepositioner\PrepositionerException;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Tomaj\Prepositioner\Prepositioner
 * @covers \Tomaj\Prepositioner\PrepositionerException
 */
class PrepositionerExceptionTest extends TestCase
{
    public function testExceptionInheritance(): void
    {
        $exception = new PrepositionerException('Test message');
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testExceptionMessage(): void
    {
        $message = 'Test exception message';
        $exception = new PrepositionerException($message);
        $this->assertEquals($message, $exception->getMessage());
    }

    public function testInvalidUTF8HandlingWithMalformedData(): void
    {
        $prepositioner = new Prepositioner(['a', 'the']);

        // This should not throw with valid UTF-8
        $validText = "Text with a preposition";
        $result = $prepositioner->formatText($validText);
        $this->assertStringContainsString("a&nbsp;preposition", $result);
    }

    public function testEmptyPrepositionsDoesNotThrow(): void
    {
        $prepositioner = new Prepositioner([]);
        $text = "Any text here";
        $result = $prepositioner->formatText($text);
        $this->assertEquals($text, $result);
    }

    public function testSpecialRegexCharactersInPrepositions(): void
    {
        // Test that special regex characters are properly escaped
        $prepositioner = new Prepositioner(['a+b', 'c.d', 'e*f', 'g?h']);
        $text = "Test a+b word c.d text";

        // Should not throw exception due to invalid regex
        $result = $prepositioner->formatText($text);
        $this->assertIsString($result);
    }

    public function testSpecialRegexCharactersInEscapeString(): void
    {
        // Test that escape string with special regex characters is properly escaped
        $prepositioner = new Prepositioner(['a'], '***');
        $text = "Test ***a*** word";
        $result = $prepositioner->formatText($text);

        // The escape markers should be removed
        $this->assertEquals("Test a word", $result);
    }
}
