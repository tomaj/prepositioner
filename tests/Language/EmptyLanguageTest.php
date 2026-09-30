<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Language\EmptyLanguage;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;



#[CoversClass(EmptyLanguage::class)]
class EmptyLanguageTest extends TestCase
{
    public function testLanguage(): void
    {
        $czechLanguage = new EmptyLanguage();
        $result = $czechLanguage->prepositions();
        self::assertEmpty($result);
    }
}
