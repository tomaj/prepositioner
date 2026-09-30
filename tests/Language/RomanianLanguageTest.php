<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\RomanianLanguage;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;



#[CoversClass(RomanianLanguage::class)]
class RomanianLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new RomanianLanguage();
        $result = $czechLanguage->prepositions();
        self::assertNotEmpty($result);
    }
}
