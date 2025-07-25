<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Language\CzechLanguage;
use Tomaj\Prepositioner\Language\EmptyLanguage;
use Tomaj\Prepositioner\Language\LanguageInterface;
use Tomaj\Prepositioner\Language\RomanianLanguage;
use Tomaj\Prepositioner\Language\SlovakLanguage;

#[CoversClass(SlovakLanguage::class)]
#[CoversClass(CzechLanguage::class)]
#[CoversClass(RomanianLanguage::class)]
#[CoversClass(EmptyLanguage::class)]
final class LanguageTest extends TestCase
{
    #[DataProvider('languageProvider')]
    public function testLanguageImplementsInterface(LanguageInterface $language): void
    {
        $this->assertInstanceOf(LanguageInterface::class, $language);
    }

    #[DataProvider('languageProvider')]
    public function testLanguageReturnsArray(LanguageInterface $language): void
    {
        $prepositions = $language->prepositions();
        $this->assertIsArray($prepositions);
        
        foreach ($prepositions as $preposition) {
            $this->assertIsString($preposition);
            $this->assertNotEmpty($preposition);
        }
    }

    public static function languageProvider(): array
    {
        return [
            'Slovak language' => [new SlovakLanguage()],
            'Czech language' => [new CzechLanguage()],
            'Romanian language' => [new RomanianLanguage()],
            'Empty language' => [new EmptyLanguage()],
        ];
    }

    public function testSlovakLanguageHasExpectedPrepositions(): void
    {
        $slovak = new SlovakLanguage();
        $prepositions = $slovak->prepositions();
        
        $this->assertContains('a', $prepositions);
        $this->assertContains('na', $prepositions);
        $this->assertContains('pre', $prepositions);
        $this->assertContains('pred', $prepositions);
        
        // Test specific Slovak prepositions
        $this->assertContains('či', $prepositions);
        $this->assertContains('skrz', $prepositions);
    }

    public function testCzechLanguageHasExpectedPrepositions(): void
    {
        $czech = new CzechLanguage();
        $prepositions = $czech->prepositions();
        
        $this->assertContains('a', $prepositions);
        $this->assertContains('k', $prepositions);
        $this->assertContains('o', $prepositions);
        $this->assertContains('v', $prepositions);
    }

    public function testRomanianLanguageHasExpectedPrepositions(): void
    {
        $romanian = new RomanianLanguage();
        $prepositions = $romanian->prepositions();
        
        $this->assertContains('cu', $prepositions);
        $this->assertContains('de', $prepositions);
        $this->assertContains('în', $prepositions);
        $this->assertContains('pentru', $prepositions);
    }

    public function testEmptyLanguageReturnsEmptyArray(): void
    {
        $empty = new EmptyLanguage();
        $this->assertEmpty($empty->prepositions());
    }
}