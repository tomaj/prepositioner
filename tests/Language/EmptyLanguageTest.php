<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\EmptyLanguage;

#[CoversClass(EmptyLanguage::class)]
class EmptyLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $emptyLanguage = new EmptyLanguage();
        $result = $emptyLanguage->prepositions();
        self::assertEmpty($result);
    }

    public function testReturnsArray(): void
    {
        $emptyLanguage = new EmptyLanguage();
        $result = $emptyLanguage->prepositions();
        self::assertIsArray($result);
    }

    public function testReturnsEmptyArray(): void
    {
        $emptyLanguage = new EmptyLanguage();
        $result = $emptyLanguage->prepositions();
        self::assertCount(0, $result);
    }
}
