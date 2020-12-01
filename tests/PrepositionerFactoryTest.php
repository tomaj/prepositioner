<?php
declare(strict_types=1);

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
    public function testCreatePrepositioner(): void
    {
        $prepositioner = Factory::build('empty');
        $this->assertEquals('Tomaj\Prepositioner\Prepositioner', get_class($prepositioner));
    }

    public function testFactoryThrowExceptionOnUnknownLanguage(): void
    {
        $this->expectException(LanguageNotExistsException::class);
        $prepositioner = Factory::build('asfsdgsdgdsgf');
    }
}
