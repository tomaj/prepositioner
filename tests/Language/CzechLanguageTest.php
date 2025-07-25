<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\CzechLanguage;

#[CoversClass(CzechLanguage::class)]
final class CzechLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();
        $this->assertNotEmpty($result);
    }
}
