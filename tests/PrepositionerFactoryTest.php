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
        self::assertEquals(Prepositioner::class, $prepositioner::class);
    }

    public function testFactoryThrowExceptionOnUnknownLanguage(): void
    {
        self::expectException(LanguageNotExistsException::class);
        self::expectExceptionMessage(
            "Language class '\\Tomaj\\Prepositioner\\Language\\NonexistentLanguage' does not exist",
        );
        Factory::build('nonexistent');
    }

    public function testFactoryBuildsSlovakLanguage(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = 'a test';
        $result = $prepositioner->formatText($input);
        self::assertSame('a&nbsp;test', $result);
    }

    public function testFactoryBuildsCzechLanguage(): void
    {
        $prepositioner = Factory::build('czech');

        $input = 'a test';
        $result = $prepositioner->formatText($input);
        self::assertSame('a&nbsp;test', $result);
    }

    public function testFactoryBuildsRomanianLanguage(): void
    {
        $prepositioner = Factory::build('romanian');

        $input = 'cu test';
        $result = $prepositioner->formatText($input);
        self::assertSame('cu&nbsp;test', $result);
    }

    public function testFactoryWithCustomEscapeString(): void
    {
        $prepositioner = Factory::build('empty', '@@@@');
        self::assertSame('v @@@@a@@@@ dome', $prepositioner->formatText('v @@@@a@@@@ dome'));
    }

    public function testFactoryCaseInsensitive(): void
    {
        $prepositioner1 = Factory::build('Slovak');
        $prepositioner2 = Factory::build('SLOVAK');
        $prepositioner3 = Factory::build('slovak');

        self::assertSame('v&nbsp;dome', $prepositioner1->formatText('v dome'));
        self::assertSame('v&nbsp;dome', $prepositioner2->formatText('v dome'));
        self::assertSame('v&nbsp;dome', $prepositioner3->formatText('v dome'));
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
            self::expectExceptionMessage('must implement LanguageInterface');
            Factory::build('invalid');
        } finally {
            // Clean up
            if (file_exists($testFile)) {
                unlink($testFile);
            }
        }
    }
}
