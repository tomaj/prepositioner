<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\CzechLanguage;

#[CoversClass(CzechLanguage::class)]
class CzechLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();
        self::assertNotEmpty($result);
    }

    public function testContainsCommonPrepositions(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();

        self::assertContains('a', $result);
        self::assertContains('i', $result);
        self::assertContains('k', $result);
        self::assertContains('o', $result);
        self::assertContains('v', $result);
        self::assertContains('u', $result);
        self::assertContains('z', $result);
        self::assertContains('s', $result);
    }

    public function testReturnsArray(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();
        self::assertIsArray($result);
    }
}
