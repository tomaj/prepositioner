<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\CzechLanguage;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;



#[CoversClass(CzechLanguage::class)]
class CzechLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();
        self::assertNotEmpty($result);
    }
}
