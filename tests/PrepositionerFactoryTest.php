<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Language\CzechLanguage;
use Tomaj\Prepositioner\Language\EmptyLanguage;
use Tomaj\Prepositioner\Language\RomanianLanguage;
use Tomaj\Prepositioner\Language\SlovakLanguage;
use Tomaj\Prepositioner\LanguageNotExistsException;
use Tomaj\Prepositioner\Prepositioner;

#[CoversClass(Factory::class)]
#[CoversClass(Prepositioner::class)]
#[CoversClass(EmptyLanguage::class)]
#[CoversClass(SlovakLanguage::class)]
#[CoversClass(CzechLanguage::class)]
#[CoversClass(RomanianLanguage::class)]
#[CoversClass(LanguageNotExistsException::class)]
class PrepositionerFactoryTest extends TestCase
{
    public function testCreatePrepositioner(): void
    {
        $prepositioner = Factory::build('empty');
        self::assertEquals('Tomaj\Prepositioner\Prepositioner', get_class($prepositioner));
    }

    public function testFactoryThrowExceptionOnUnknownLanguage(): void
    {
        self::expectException(LanguageNotExistsException::class);
        self::expectExceptionMessage(
            "Language class '\\Tomaj\\Prepositioner\\Language\\NonexistentLanguage' does not exist"
        );
        Factory::build('nonexistent');
    }

    public function testFactoryBuildsSlovakLanguage(): void
    {
        $prepositioner = Factory::build('slovak');
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner);

        $input = "a test";
        $result = $prepositioner->formatText($input);
        self::assertEquals("a&nbsp;test", $result);
    }

    public function testFactoryBuildsCzechLanguage(): void
    {
        $prepositioner = Factory::build('czech');
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner);

        $input = "a test";
        $result = $prepositioner->formatText($input);
        self::assertEquals("a&nbsp;test", $result);
    }

    public function testFactoryBuildsRomanianLanguage(): void
    {
        $prepositioner = Factory::build('romanian');
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner);

        $input = "cu test";
        $result = $prepositioner->formatText($input);
        self::assertEquals("cu&nbsp;test", $result);
    }

    public function testFactoryWithCustomEscapeString(): void
    {
        $prepositioner = Factory::build('empty', '@@@@');
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner);
    }

    public function testFactoryCaseInsensitive(): void
    {
        $prepositioner1 = Factory::build('Slovak');
        $prepositioner2 = Factory::build('SLOVAK');
        $prepositioner3 = Factory::build('slovak');

        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner1);
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner2);
        self::assertInstanceOf('Tomaj\Prepositioner\Prepositioner', $prepositioner3);
    }

    public function testFactoryThrowsExceptionForClassNotImplementingInterface(): void
    {
        // Create a temporary class file that doesn't implement LanguageInterface
        $testFile = __DIR__ . '/../src/Prepositioner/Language/InvalidLanguage.php';
        $content = '<?php
namespace Tomaj\Prepositioner\Language;
class InvalidLanguage {
    public function prepositions(): array { return []; }
}';
        file_put_contents($testFile, $content);

        try {
            self::expectException(LanguageNotExistsException::class);
            self::expectExceptionMessage("must implement LanguageInterface");
            Factory::build('invalid');
        } finally {
            // Clean up
            if (file_exists($testFile)) {
                unlink($testFile);
            }
        }
    }
}
