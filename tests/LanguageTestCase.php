<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\LanguageInterface;

/**
 * Abstract base class for language tests
 *
 * Extend this class to automatically verify LanguageInterface contract for your language.
 * Example:
 *
 * ```php
 * #[CoversClass(MyLanguage::class)]
 * class MyLanguageTest extends LanguageTestCase
 * {
 *     protected function createLanguage(): LanguageInterface
 *     {
 *         return new MyLanguage();
 *     }
 * }
 * ```
 */
abstract class LanguageTestCase extends TestCase
{
    /**
     * Create an instance of the language to test
     */
    abstract protected function createLanguage(): LanguageInterface;

    /**
     * Test that prepositions() returns an array
     */
    public function testReturnsArray(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        self::assertIsArray($result);
    }

    /**
     * Test that prepositions() returns non-empty array (unless it's EmptyLanguage)
     */
    public function testReturnsNonEmptyArray(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        // Skip this test for EmptyLanguage
        if (get_class($language) === 'Tomaj\Prepositioner\Language\EmptyLanguage') {
            self::assertEmpty($result);
            return;
        }

        self::assertNotEmpty(
            $result,
            'Language prepositions() should return at least one preposition'
        );
    }

    /**
     * Test that all prepositions are strings
     */
    public function testAllPrepositionsAreStrings(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        foreach ($result as $preposition) {
            self::assertIsString(
                $preposition,
                'All prepositions must be strings'
            );
        }
    }

    /**
     * Test that all prepositions are non-empty strings
     */
    public function testAllPrepositionsAreNonEmpty(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        foreach ($result as $preposition) {
            self::assertNotEmpty(
                $preposition,
                'Prepositions must not be empty strings'
            );
        }
    }

    /**
     * Test that prepositions are unique
     */
    public function testPrepositionsAreUnique(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        $unique = array_unique($result);

        self::assertCount(
            count($result),
            $unique,
            'All prepositions must be unique (no duplicates)'
        );
    }

    /**
     * Test that prepositions contain only valid characters
     * (letters, spaces, hyphens, and apostrophes for multi-word prepositions)
     */
    public function testPrepositionsContainValidCharacters(): void
    {
        $language = $this->createLanguage();
        $result = $language->prepositions();

        foreach ($result as $preposition) {
            self::assertMatchesRegularExpression(
                '/^[\p{L}\s\-\']+$/u',
                $preposition,
                "Preposition '{$preposition}' contains invalid characters. " .
                "Only letters, spaces, hyphens, and apostrophes are allowed."
            );
        }
    }
}
