<?php

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\LanguageNotExistsException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Factory
 * @covers \Tomaj\Prepositioner\Prepositioner
 * @covers \Tomaj\Prepositioner\Language\EmptyLanguage
 */
class PrepositionerFactoryTest extends TestCase
{
    public function testCreatePrepositioner()
    {
        $prepositioner = Factory::build('empty');
        $this->assertEquals('Tomaj\Prepositioner\Prepositioner', get_class($prepositioner));
    }

    public function testFactoryThrowExceptionOnUnknownLanguage()
    {
        $this->expectException(LanguageNotExistsException::class);
        $prepositioner = Factory::build('asfsdgsdgdsgf');
    }
}
