<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\SlovakLanguage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Language\SlovakLanguage
 */
class SlovakLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new SlovakLanguage();
        $result = $czechLanguage->prepositions();
        $this->assertNotEmpty($result);
    }
}
