<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\SlovakLanguage;

#[CoversClass(SlovakLanguage::class)]
class SlovakLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $slovakLanguage = new SlovakLanguage();
        $result = $slovakLanguage->prepositions();
        self::assertNotEmpty($result);
    }

    public function testContainsOneLetterPrepositions(): void
    {
        $slovakLanguage = new SlovakLanguage();
        $result = $slovakLanguage->prepositions();

        self::assertContains('a', $result);
        self::assertContains('i', $result);
        self::assertContains('k', $result);
        self::assertContains('o', $result);
        self::assertContains('v', $result);
        self::assertContains('u', $result);
        self::assertContains('z', $result);
        self::assertContains('s', $result);
    }

    public function testContainsTwoLetterPrepositions(): void
    {
        $slovakLanguage = new SlovakLanguage();
        $result = $slovakLanguage->prepositions();

        self::assertContains('do', $result);
        self::assertContains('od', $result);
        self::assertContains('zo', $result);
        self::assertContains('ku', $result);
        self::assertContains('na', $result);
        self::assertContains('po', $result);
        self::assertContains('so', $result);
        self::assertContains('za', $result);
        self::assertContains('vo', $result);
        self::assertContains('či', $result);
    }

    public function testContainsLongerPrepositions(): void
    {
        $slovakLanguage = new SlovakLanguage();
        $result = $slovakLanguage->prepositions();

        self::assertContains('cez', $result);
        self::assertContains('pre', $result);
        self::assertContains('nad', $result);
        self::assertContains('pod', $result);
        self::assertContains('pri', $result);
        self::assertContains('spod', $result);
        self::assertContains('pred', $result);
        self::assertContains('skrz', $result);
    }

    public function testReturnsArray(): void
    {
        $slovakLanguage = new SlovakLanguage();
        $result = $slovakLanguage->prepositions();
        self::assertIsArray($result);
    }
}
