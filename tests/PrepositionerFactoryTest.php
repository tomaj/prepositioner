<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Language\EmptyLanguage;
use Tomaj\Prepositioner\LanguageNotExistsException;
use Tomaj\Prepositioner\Prepositioner;

// Test class that doesn't implement LanguageInterface
class InvalidLanguage
{
    public function someMethod(): string
    {
        return 'invalid';
    }
}

#[CoversClass(Factory::class)]
#[CoversClass(Prepositioner::class)]
#[CoversClass(EmptyLanguage::class)]
#[CoversClass(LanguageNotExistsException::class)]
#[CoversClass(\Tomaj\Prepositioner\Language\SlovakLanguage::class)]
#[CoversClass(\Tomaj\Prepositioner\Language\CzechLanguage::class)]
#[CoversClass(\Tomaj\Prepositioner\Language\RomanianLanguage::class)]
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

    public function testFactoryThrowExceptionWhenClassDoesNotImplementInterface(): void
    {
        // We need to test the case where class exists but doesn't implement LanguageInterface
        // Since our factory looks for classes in the Language namespace, we need to create
        // a test that simulates this scenario. We'll use reflection to test this edge case.
        
        $this->expectException(LanguageNotExistsException::class);
        $this->expectExceptionMessage("must implement LanguageInterface");
        
        // Create a temporary class file to test this scenario
        $tempClassName = 'Tomaj\\Prepositioner\\Language\\TestInvalidLanguage';
        
        // We need to use eval to create a class in the correct namespace for this test
        eval('
            namespace Tomaj\\Prepositioner\\Language;
            class TestInvalidLanguage {
                public function notTheRightMethod() {
                    return [];
                }
            }
        ');
        
        Factory::build('testInvalid');
    }
}
