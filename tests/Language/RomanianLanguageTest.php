<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\RomanianLanguage;

#[CoversClass(RomanianLanguage::class)]
class RomanianLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $romanianLanguage = new RomanianLanguage();
        $result = $romanianLanguage->prepositions();
        self::assertNotEmpty($result);
    }

    public function testContainsCommonPrepositions(): void
    {
        $romanianLanguage = new RomanianLanguage();
        $result = $romanianLanguage->prepositions();

        self::assertContains('cu', $result);
        self::assertContains('de', $result);
        self::assertContains('în', $result);
        self::assertContains('la', $result);
        self::assertContains('pe', $result);
    }

    public function testContainsLongerPrepositions(): void
    {
        $romanianLanguage = new RomanianLanguage();
        $result = $romanianLanguage->prepositions();

        self::assertContains('între', $result);
        self::assertContains('pentru', $result);
        self::assertContains('peste', $result);
    }

    public function testReturnsArray(): void
    {
        $romanianLanguage = new RomanianLanguage();
        $result = $romanianLanguage->prepositions();
        self::assertIsArray($result);
    }
}
