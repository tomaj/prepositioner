<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Prepositioner;

#[CoversClass(Prepositioner::class)]
#[CoversClass(Factory::class)]
class RobustnessTest extends TestCase
{
    /**
     * Test idempotence: formatText(formatText(x)) === formatText(x)
     * Applying the formatter twice should produce the same result as applying it once
     */
    #[DataProvider('languageProvider')]
    public function testIdempotence(string $language): void
    {
        $prepositioner = Factory::build($language);

        $inputs = [
            "This is a test with prepositions",
            "Multiple a b c prepositions in a row",
            "<p>HTML a content with tags</p>",
            "Quotes \"a test\" and more",
            "",
            "Single",
        ];

        foreach ($inputs as $input) {
            $once = $prepositioner->formatText($input);
            $twice = $prepositioner->formatText($once);

            self::assertEquals(
                $once,
                $twice,
                "Idempotence failed for input: {$input}"
            );
        }
    }

    /**
     * Test that no text is lost during formatting
     * After removing &nbsp;, output should equal input
     */
    #[DataProvider('languageProvider')]
    public function testNoTextLoss(string $language): void
    {
        $prepositioner = Factory::build($language);

        $inputs = [
            "Simple text with words",
            "Multiple    spaces   between words",
            "<p>HTML content</p>",
            "Text with\nnewlines\nand\ttabs",
            "Special chars: @#$%^&*()",
        ];

        foreach ($inputs as $input) {
            $output = $prepositioner->formatText($input);
            $normalized = str_replace('&nbsp;', ' ', $output);

            self::assertEquals(
                $input,
                $normalized,
                "Text loss detected for input: {$input}"
            );
        }
    }

    /**
     * Test behavior with very long inputs
     */
    #[DataProvider('languageProvider')]
    public function testVeryLongInputs(string $language): void
    {
        $prepositioner = Factory::build($language);

        // Generate a long text (1000 words - reduced to avoid memory issues in CI)
        $longText = implode(' ', array_fill(0, 1000, 'word test content'));

        $result = $prepositioner->formatText($longText);

        // Should not throw exception
        self::assertIsString($result);

        // Result should be at least as long as input (may have &nbsp; additions)
        self::assertGreaterThanOrEqual(strlen($longText), strlen($result));
    }

    /**
     * Test that HTML tags and attributes are preserved exactly
     */
    #[DataProvider('languageProvider')]
    public function testHtmlPreservation(string $language): void
    {
        $prepositioner = Factory::build($language);

        $htmlCases = [
            '<p>text</p>' => 'Basic tag',
            '<div class="test">content</div>' => 'Tag with class',
            '<a href="https://example.com">link</a>' => 'Link with href',
            '<img src="image.jpg" alt="description">' => 'Self-closing tag',
            '<span data-value="a test">text</span>' => 'Data attribute with preposition',
            '<div id="main" class="container primary">content</div>' => 'Multiple attributes',
        ];

        foreach ($htmlCases as $input => $description) {
            $output = $prepositioner->formatText($input);

            // Extract tags from input and output
            preg_match_all('/<[^>]+>/', $input, $inputTags);
            preg_match_all('/<[^>]+>/', $output, $outputTags);

            self::assertEquals(
                $inputTags[0],
                $outputTags[0],
                "HTML tags/attributes were modified for: {$description}"
            );
        }
    }

    /**
     * Test behavior with invalid UTF-8 sequences
     * Documented behavior: Invalid UTF-8 may throw PrepositionerException or be handled gracefully
     */
    public function testInvalidUtf8Behavior(): void
    {
        $prepositioner = new Prepositioner(['test', 'a']);

        $invalidUtf8Cases = [
            "\xFF test word",           // Invalid start byte
            "test \x80\x81 word",      // Invalid continuation
            "word \xC0 test",           // Overlong encoding
        ];

        foreach ($invalidUtf8Cases as $input) {
            try {
                $result = $prepositioner->formatText($input);
                // If no exception, verify result is a string
                self::assertIsString($result);
            } catch (\Tomaj\Prepositioner\PrepositionerException $e) {
                // Exception is acceptable for invalid UTF-8
                self::assertStringContainsString('preg_replace failed', $e->getMessage());
            }
        }
    }

    /**
     * Test with random-like inputs to catch edge cases
     */
    #[DataProvider('randomInputProvider')]
    public function testRandomInputs(string $input): void
    {
        $prepositioner = Factory::build('slovak');

        try {
            $result = $prepositioner->formatText($input);

            // Should always return a string
            self::assertIsString($result);

            // Idempotence should hold
            $again = $prepositioner->formatText($result);
            self::assertEquals($result, $again);

            // No text loss (after removing &nbsp;)
            $normalized = str_replace('&nbsp;', ' ', $result);
            self::assertEquals($input, $normalized);
        } catch (\Tomaj\Prepositioner\PrepositionerException $e) {
            // Only acceptable if input contained invalid UTF-8
            self::assertStringContainsString('preg_replace failed', $e->getMessage());
        }
    }

    /**
     * Test empty string handling
     */
    #[DataProvider('languageProvider')]
    public function testEmptyString(string $language): void
    {
        $prepositioner = Factory::build($language);

        self::assertEquals('', $prepositioner->formatText(''));
    }

    public static function languageProvider(): array
    {
        return [
            'slovak' => ['slovak'],
            'czech' => ['czech'],
            'romanian' => ['romanian'],
            'empty' => ['empty'],
        ];
    }

    public static function randomInputProvider(): array
    {
        return [
            ['a b c d e f g h i j k'],
            ['test   multiple      spaces'],
            ['<p><span><div>nested</div></span></p>'],
            ['Mixed <b>HTML</b> and plain text'],
            ['123 456 789 numbers only'],
            ['Special!@#$%^&*()chars'],
            ['Newline\nTab\tCarriage\rReturn'],
            ['Unicode characters: ščťžýáíé'],
            ['Very    long       text    with    many    spaces'],
            ['Single'],
            [' Leading and trailing spaces '],
            ['<div class="a b c">content</div>'],
        ];
    }
}
