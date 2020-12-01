<?php

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\LanguageNotExistsException;
use PHPUnit\Framework\TestCase;

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
