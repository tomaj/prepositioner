<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\SlovakLanguage;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;



#[CoversClass(SlovakLanguage::class)]
class SlovakLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new SlovakLanguage();
        $result = $czechLanguage->prepositions();
        self::assertNotEmpty($result);
    }
}
