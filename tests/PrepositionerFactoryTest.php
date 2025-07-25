<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Language\EmptyLanguage;
use Tomaj\Prepositioner\LanguageNotExistsException;
use Tomaj\Prepositioner\Prepositioner;

#[CoversClass(Factory::class)]
#[CoversClass(Prepositioner::class)]
#[CoversClass(EmptyLanguage::class)]
final class PrepositionerFactoryTest extends TestCase
{
    public function testCreatePrepositioner(): void
    {
        $prepositioner = Factory::build('empty');
        $this->assertInstanceOf(Prepositioner::class, $prepositioner);
    }

    public function testFactoryThrowExceptionOnUnknownLanguage(): void
    {
        $this->expectException(LanguageNotExistsException::class);
        $this->expectExceptionMessage("Language class '\\Tomaj\\Prepositioner\\Language\\NonexistentLanguage' doesn't exist");
        
        Factory::build('nonexistent');
    }

    public function testFactorySupportsKnownLanguages(): void
    {
        $languages = ['slovak', 'czech', 'romanian', 'empty'];
        
        foreach ($languages as $language) {
            $prepositioner = Factory::build($language);
            $this->assertInstanceOf(Prepositioner::class, $prepositioner);
        }
    }

    public function testFactoryWithCustomEscapeString(): void
    {
        $customEscape = '###ESCAPE###';
        $prepositioner = Factory::build('empty', $customEscape);
        
        $this->assertInstanceOf(Prepositioner::class, $prepositioner);
    }
}
