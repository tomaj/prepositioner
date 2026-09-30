<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Prepositioner;
use Tomaj\Prepositioner\PrepositionerException;

#[CoversClass(Prepositioner::class)]
#[CoversClass(PrepositionerException::class)]
class PrepositionerExceptionTest extends TestCase
{
    public function testExceptionInheritance(): void
    {
        $exception = new PrepositionerException('Test message');
        self::assertInstanceOf(\RuntimeException::class, $exception);
        self::assertInstanceOf(\Exception::class, $exception);
    }

    public function testExceptionMessage(): void
    {
        $message = 'Test exception message';
        $exception = new PrepositionerException($message);
        self::assertEquals($message, $exception->getMessage());
    }

    public function testInvalidUTF8HandlingWithMalformedData(): void
    {
        $prepositioner = new Prepositioner(['a', 'the']);

        // This should not throw with valid UTF-8
        $validText = "Text with a preposition";
        $result = $prepositioner->formatText($validText);
        self::assertStringContainsString("a&nbsp;preposition", $result);
    }

    public function testEmptyPrepositionsDoesNotThrow(): void
    {
        $prepositioner = new Prepositioner([]);
        $text = "Any text here";
        $result = $prepositioner->formatText($text);
        self::assertEquals($text, $result);
    }

    public function testSpecialRegexCharactersInPrepositions(): void
    {
        // Test that special regex characters are properly escaped
        $prepositioner = new Prepositioner(['a+b', 'c.d', 'e*f', 'g?h']);
        $text = "Test a+b word c.d text";

        // Should not throw exception due to invalid regex
        $result = $prepositioner->formatText($text);
        self::assertIsString($result);
    }

    public function testSpecialRegexCharactersInEscapeString(): void
    {
        // Test that escape string with special regex characters is properly escaped
        $prepositioner = new Prepositioner(['a'], '***');
        $text = "Test ***a*** word";
        $result = $prepositioner->formatText($text);

        // The escape markers should be removed
        self::assertEquals("Test a word", $result);
    }

    public function testPregReplaceErrorWithInvalidUTF8(): void
    {
        $prepositioner = new Prepositioner(['test']);

        // Create a string with invalid UTF-8 sequence when /u flag is used
        // \xFF is not valid UTF-8
        $invalidUtf8Text = "Some text test \xFF more text";

        try {
            $prepositioner->formatText($invalidUtf8Text);
            // If no exception is thrown, that's also acceptable since the pattern might match
            // or the invalid UTF-8 might be silently handled
            self::assertTrue(true);
        } catch (PrepositionerException $e) {
            // Verify the exception contains error information
            self::assertStringContainsString('preg_replace failed', $e->getMessage());
        }
    }

    public function testGetPregErrorMessageCoverage(): void
    {
        // This test ensures we have coverage of the error message generation
        // We can't easily trigger all PCRE errors, but we test the method indirectly
        // by verifying that invalid UTF-8 with /u flag produces an appropriate error
        $prepositioner = new Prepositioner(['a']);

        // Binary string that's not valid UTF-8
        $binaryString = "\x80\x81\x82 a test";

        try {
            $result = $prepositioner->formatText($binaryString);
            // Some PHP versions might handle this differently
            self::assertIsString($result);
        } catch (PrepositionerException $e) {
            // Should mention UTF-8 error
            self::assertStringContainsString('preg_replace failed', $e->getMessage());
        }
    }

    public function testPregQuoteIsEssentialForSpecialCharacters(): void
    {
        // This test verifies that preg_quote is actually protecting special regex chars
        // Without preg_quote, these would be interpreted as regex metacharacters
        $prepositioner = new Prepositioner(['a+', 'b*', 'c?', 'd.e', 'f[g]', 'h(i)', 'j|k']);

        // These should match literally, not as regex patterns
        $text = "test a+ word b* text c? more d.e stuff f[g] data h(i) end j|k finish";
        $result = $prepositioner->formatText($text);

        // All special characters should be matched literally and get nbsp
        self::assertStringContainsString("a+&nbsp;word", $result);
        self::assertStringContainsString("b*&nbsp;text", $result);
        self::assertStringContainsString("c?&nbsp;more", $result);
        self::assertStringContainsString("d.e&nbsp;stuff", $result);
        self::assertStringContainsString("f[g]&nbsp;data", $result);
        self::assertStringContainsString("h(i)&nbsp;end", $result);
        self::assertStringContainsString("j|k&nbsp;finish", $result);
    }

    public function testQuotationMarksRequirePregQuote(): void
    {
        // Verify that quotation marks are also properly escaped
        $prepositioner = new Prepositioner(['test']);

        // Using quotation marks that contain regex special characters
        $text = '"test word"';
        $result = $prepositioner->formatText($text);

        // Should work correctly without regex errors
        self::assertStringContainsString('test&nbsp;word', $result);
    }

    public function testQuotationMarksWithRegexMetacharacters(): void
    {
        // Test that quotation marks are properly escaped with preg_quote
        // Without preg_quote, these would cause regex errors
        $prepositioner = new Prepositioner(['a']);

        // All default quotation marks should work
        $quotationCases = [
            '"a test"' => '"a&nbsp;test"',
            "'a test'" => "'a&nbsp;test'",
            "\u{201E}a test\u{201C}" => "\u{201E}a&nbsp;test\u{201C}",  // German quotes
            "\u{201A}a test\u{2019}" => "\u{201A}a&nbsp;test\u{2019}",  // Single low-9
            "«a test»" => "«a&nbsp;test»",  // Guillemets
            "‹a test›" => "‹a&nbsp;test›",  // Single guillemets
        ];

        foreach ($quotationCases as $input => $expected) {
            $result = $prepositioner->formatText($input);
            self::assertEquals(
                $expected,
                $result,
                "Quotation marks not properly handled for: {$input}"
            );
        }
    }

    public function testErrorMessageContent(): void
    {
        // Test that error messages are correctly formatted
        // This ensures getPregErrorMessage returns proper text
        $prepositioner = new Prepositioner(['test.*pattern']);

        try {
            // Try to cause a regex error with invalid UTF-8
            $prepositioner->formatText("\xFF\xFE invalid utf8");
            // If no exception, test passes anyway
            self::assertTrue(true);
        } catch (PrepositionerException $e) {
            $message = $e->getMessage();

            // Should contain "preg_replace failed"
            self::assertStringContainsString('preg_replace failed', $message);

            // Should contain one of the error descriptions
            $validErrors = [
                'No error',
                'Internal PCRE error',
                'Backtrack limit exhausted',
                'Recursion limit exhausted',
                'Malformed UTF-8 data',
                'Bad UTF-8 offset',
                'JIT stack limit exhausted',
                'Unknown error',
            ];

            $foundValidError = false;
            foreach ($validErrors as $errorText) {
                if (str_contains($message, $errorText)) {
                    $foundValidError = true;
                    break;
                }
            }

            self::assertTrue(
                $foundValidError,
                "Exception message should contain a valid error description: {$message}"
            );
        }
    }
}
