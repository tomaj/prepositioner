<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\RomanianLanguage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Language\RomanianLanguage
 */
class RomanianLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new RomanianLanguage();
        $result = $czechLanguage->prepositions();
        $this->assertNotEmpty($result);
    }
}
