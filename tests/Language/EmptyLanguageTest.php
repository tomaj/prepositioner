<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\EmptyLanguage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Language\EmptyLanguage
 */
class EmptyLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new EmptyLanguage();
        $result = $czechLanguage->prepositions();
        $this->assertEmpty($result);
    }
}
