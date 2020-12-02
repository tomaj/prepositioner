<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\CzechLanguage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Language\CzechLanguage
 */
class CzechLanaguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new CzechLanguage();
        $result = $czechLanguage->prepositions();
        $this->assertNotEmpty($result);
    }
}
