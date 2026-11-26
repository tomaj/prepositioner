<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Prepositioner;

#[CoversClass(Prepositioner::class)]
class PrepositionerTest extends TestCase
{
    public function testBasicFormat(): void
    {
        $words = ['a', 'asdf', 'vd'];
        $prepositioner = new Prepositioner($words);
        $input = 'dsfoihdf s asd a sdfds asdf asd';
        self::assertSame('dsfoihdf s asd a&nbsp;sdfds asdf&nbsp;asd', $prepositioner->formatText($input));
    }

    public function testInWordReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'dsfdsfa dfsdg';
        self::assertSame('dsfdsfa dfsdg', $prepositioner->formatText($input));
    }

    public function testFirstWord(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'a asfs a asfd';
        self::assertSame('a&nbsp;asfs a&nbsp;asfd', $prepositioner->formatText($input));
    }

    public function testLastWord(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'asfd a';
        self::assertSame('asfd a', $prepositioner->formatText($input));
    }

    public function testSimplePreposition(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'a';
        self::assertSame('a', $prepositioner->formatText($input));
    }

    public function testUpperLowerCase(): void
    {
        $words = ['a', 'AsD', 'C', 'EE'];
        $prepositioner = new Prepositioner($words);
        $input = 'A acd asd fef c xxx Ee grgr';
        self::assertSame('A&nbsp;acd asd&nbsp;fef c&nbsp;xxx Ee&nbsp;grgr', $prepositioner->formatText($input));
    }

    public function testMultipleSpaces(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'asd a   asd';
        self::assertSame('asd a&nbsp;asd', $prepositioner->formatText($input));
    }

    public function testHtmlTextElementReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'asd a fs <a>sa a sd</a>';
        self::assertSame('asd a&nbsp;fs <a>sa a&nbsp;sd</a>', $prepositioner->formatText($input));
    }

    public function testHtmlContentDoesntReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'asd a fs <p a sad>sdasd</p>';
        self::assertSame('asd a&nbsp;fs <p a sad>sdasd</p>', $prepositioner->formatText($input));

        $input = 'asd a fs <p class="asd a c">sdasd</p>';
        self::assertSame('asd a&nbsp;fs <p class="asd a c">sdasd</p>', $prepositioner->formatText($input));
    }

    public function testSpecialCharacters(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a\t\tx a\nasdcdcd a<br/>asd";
        self::assertSame('asd a&nbsp;x a&nbsp;asdcdcd a<br/>asd', $prepositioner->formatText($input));

        $input = "asd\t\ta\tx \na asdcdcd a<br/>asd";
        self::assertSame("asd\t\ta&nbsp;x \na&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));
    }

    public function testFirstWordInTag(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = '<p>a bout</p>';
        self::assertSame('<p>a&nbsp;bout</p>', $prepositioner->formatText($input));
    }

    public function testDisablePrepositionsReplace(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words, '#####');
        $input = 'asd #####a##### asdsa b cc a asd s b';
        self::assertSame('asd a asdsa b&nbsp;cc a&nbsp;asd s b', $prepositioner->formatText($input));
    }

    public function testMorePreposition(): void
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = 'asd a c b asd b c';
        self::assertSame('asd a&nbsp;c&nbsp;b&nbsp;asd b&nbsp;c', $prepositioner->formatText($input));
    }

    public function testMultiplePreposition(): void
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = 'a b c a b b c';
        self::assertSame('a&nbsp;b&nbsp;c&nbsp;a&nbsp;b&nbsp;b&nbsp;c', $prepositioner->formatText($input));
    }

    public function testPrepositionAfterStraightQuotationMark(): void
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: "on to the hill, man"';
        self::assertSame('He said: "on&nbsp;to&nbsp;the&nbsp;hill, man"', $prepositioner->formatText($input));
    }

    public function testPrepositionAfterLeftDoubleQuotationMark(): void
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: “on to the hill, man”';
        self::assertSame('He said: “on&nbsp;to&nbsp;the&nbsp;hill, man”', $prepositioner->formatText($input));
    }

    public function testEmptyPrepositionsArray(): void
    {
        $prepositioner = new Prepositioner([]);
        $input = 'a test b string c text';
        self::assertSame($input, $prepositioner->formatText($input));
    }

    public function testEmptyString(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words);
        self::assertSame('', $prepositioner->formatText(''));
    }

    public function testPrepositionWithNewline(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "text\na word";
        self::assertSame("text\na&nbsp;word", $prepositioner->formatText($input));
    }

    public function testPrepositionAfterSemicolon(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'text;a word';
        self::assertSame('text;a&nbsp;word', $prepositioner->formatText($input));
    }

    public function testPrepositionWithVariousQuotationMarks(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);

        // Straight double quotes
        self::assertSame('"a&nbsp;test"', $prepositioner->formatText('"a test"'));
        // Straight single quotes
        self::assertSame("'a&nbsp;test'", $prepositioner->formatText("'a test'"));
        // German quotes (Anführungszeichen)
        self::assertSame("\u{201E}a&nbsp;test\u{201C}", $prepositioner->formatText("\u{201E}a test\u{201C}"));
        // Single low-9 quotation mark
        self::assertSame("\u{201A}a&nbsp;test\u{2019}", $prepositioner->formatText("\u{201A}a test\u{2019}"));
        // Left and right double quotation marks
        self::assertSame("\u{201C}a&nbsp;test\u{201D}", $prepositioner->formatText("\u{201C}a test\u{201D}"));
        // Left and right single quotation marks
        self::assertSame("\u{2018}a&nbsp;test\u{2019}", $prepositioner->formatText("\u{2018}a test\u{2019}"));
        // Guillemets
        self::assertSame('«a&nbsp;test»', $prepositioner->formatText('«a test»'));
        // Single guillemets
        self::assertSame('‹a&nbsp;test›', $prepositioner->formatText('‹a test›'));
    }

    public function testComplexHtmlStructure(): void
    {
        $words = ['a', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = '<div class="test a">a text <span>the word</span> a end</div>';
        $result = $prepositioner->formatText($input);
        $expected = '<div class="test a">a&nbsp;text <span>the&nbsp;word</span> '
            . 'a&nbsp;end</div>';
        self::assertSame($expected, $result);
    }

    public function testCustomEscapeString(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words, '%%%');
        $input = 'text %%%a%%% word b test';
        self::assertSame('text a word b&nbsp;test', $prepositioner->formatText($input));
    }

    public function testPrepositionAtStartOfString(): void
    {
        $words = ['the'];
        $prepositioner = new Prepositioner($words);
        self::assertSame('the&nbsp;quick', $prepositioner->formatText('the quick'));
    }

    public function testMultipleConsecutiveSpaces(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = 'test  a   word';
        self::assertSame('test  a&nbsp;word', $prepositioner->formatText($input));
    }

    public function testUnicodeCharacters(): void
    {
        $words = ['în', 'și'];
        $prepositioner = new Prepositioner($words);
        $input = 'text în România și test';
        self::assertSame('text în&nbsp;România și&nbsp;test', $prepositioner->formatText($input));
    }
}
