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
        $input = "dsfoihdf s asd a sdfds asdf asd";
        self::assertEquals("dsfoihdf s asd a&nbsp;sdfds asdf&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testInWordReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "dsfdsfa dfsdg";
        self::assertEquals("dsfdsfa dfsdg", $prepositioner->formatText($input));
    }

    public function testFirstWord(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "a asfs a asfd";
        self::assertEquals("a&nbsp;asfs a&nbsp;asfd", $prepositioner->formatText($input));
    }

    public function testLastWord(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asfd a";
        self::assertEquals("asfd a", $prepositioner->formatText($input));
    }

    public function testSimplePreposition(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "a";
        self::assertEquals("a", $prepositioner->formatText($input));
    }

    public function testUpperLowerCase(): void
    {
        $words = ['a', 'AsD', 'C', 'EE'];
        $prepositioner = new Prepositioner($words);
        $input = "A acd asd fef c xxx Ee grgr";
        self::assertEquals("A&nbsp;acd asd&nbsp;fef c&nbsp;xxx Ee&nbsp;grgr", $prepositioner->formatText($input));
    }

    public function testMultipleSpaces(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a   asd";
        self::assertEquals("asd a&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testHtmlTextElementReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <a>sa a sd</a>";
        self::assertEquals("asd a&nbsp;fs <a>sa a&nbsp;sd</a>", $prepositioner->formatText($input));
    }

    public function testHtmlContentDoesntReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <p a sad>sdasd</p>";
        self::assertEquals("asd a&nbsp;fs <p a sad>sdasd</p>", $prepositioner->formatText($input));

        $input = "asd a fs <p class=\"asd a c\">sdasd</p>";
        self::assertEquals("asd a&nbsp;fs <p class=\"asd a c\">sdasd</p>", $prepositioner->formatText($input));
    }

    public function testSpecialCharacters(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a\t\tx a\nasdcdcd a<br/>asd";
        self::assertEquals("asd a&nbsp;x a&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));

        $input = "asd\t\ta\tx \na asdcdcd a<br/>asd";
        self::assertEquals("asd\t\ta&nbsp;x \na&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));
    }

    public function testFirstWordInTag(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "<p>a bout</p>";
        self::assertEquals("<p>a&nbsp;bout</p>", $prepositioner->formatText($input));
    }

    public function testDisablePrepositionsReplace(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words, '#####');
        $input = "asd #####a##### asdsa b cc a asd s b";
        self::assertEquals("asd a asdsa b&nbsp;cc a&nbsp;asd s b", $prepositioner->formatText($input));
    }

    public function testMorePreposition(): void
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a c b asd b c";
        self::assertEquals("asd a&nbsp;c&nbsp;b&nbsp;asd b&nbsp;c", $prepositioner->formatText($input));
    }

    public function testMultiplePreposition(): void
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = "a b c a b b c";
        self::assertEquals("a&nbsp;b&nbsp;c&nbsp;a&nbsp;b&nbsp;b&nbsp;c", $prepositioner->formatText($input));
    }

    public function testPrepositionAfterStraightQuotationMark(): void
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: "on to the hill, man"';
        self::assertEquals('He said: "on&nbsp;to&nbsp;the&nbsp;hill, man"', $prepositioner->formatText($input));
    }

    public function testPrepositionAfterLeftDoubleQuotationMark(): void
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: “on to the hill, man”';
        self::assertEquals('He said: “on&nbsp;to&nbsp;the&nbsp;hill, man”', $prepositioner->formatText($input));
    }

    public function testEmptyPrepositionsArray(): void
    {
        $prepositioner = new Prepositioner([]);
        $input = "a test b string c text";
        self::assertEquals($input, $prepositioner->formatText($input));
    }

    public function testEmptyString(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words);
        self::assertEquals('', $prepositioner->formatText(''));
    }

    public function testPrepositionWithNewline(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "text\na word";
        self::assertEquals("text\na&nbsp;word", $prepositioner->formatText($input));
    }

    public function testPrepositionAfterSemicolon(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "text;a word";
        self::assertEquals("text;a&nbsp;word", $prepositioner->formatText($input));
    }

    public function testPrepositionWithVariousQuotationMarks(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);

        // Straight double quotes
        self::assertEquals('"a&nbsp;test"', $prepositioner->formatText('"a test"'));
        // Straight single quotes
        self::assertEquals("'a&nbsp;test'", $prepositioner->formatText("'a test'"));
        // German quotes (Anführungszeichen)
        self::assertEquals("\u{201E}a&nbsp;test\u{201C}", $prepositioner->formatText("\u{201E}a test\u{201C}"));
        // Single low-9 quotation mark
        self::assertEquals("\u{201A}a&nbsp;test\u{2019}", $prepositioner->formatText("\u{201A}a test\u{2019}"));
        // Left and right double quotation marks
        self::assertEquals("\u{201C}a&nbsp;test\u{201D}", $prepositioner->formatText("\u{201C}a test\u{201D}"));
        // Left and right single quotation marks
        self::assertEquals("\u{2018}a&nbsp;test\u{2019}", $prepositioner->formatText("\u{2018}a test\u{2019}"));
        // Guillemets
        self::assertEquals("«a&nbsp;test»", $prepositioner->formatText("«a test»"));
        // Single guillemets
        self::assertEquals("‹a&nbsp;test›", $prepositioner->formatText("‹a test›"));
    }

    public function testComplexHtmlStructure(): void
    {
        $words = ['a', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = '<div class="test a">a text <span>the word</span> a end</div>';
        $result = $prepositioner->formatText($input);
        $expected = '<div class="test a">a&nbsp;text <span>the&nbsp;word</span> ' .
            'a&nbsp;end</div>';
        self::assertEquals($expected, $result);
    }

    public function testCustomEscapeString(): void
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words, '%%%');
        $input = "text %%%a%%% word b test";
        self::assertEquals("text a word b&nbsp;test", $prepositioner->formatText($input));
    }

    public function testPrepositionAtStartOfString(): void
    {
        $words = ['the'];
        $prepositioner = new Prepositioner($words);
        self::assertEquals("the&nbsp;quick", $prepositioner->formatText("the quick"));
    }

    public function testMultipleConsecutiveSpaces(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "test  a   word";
        self::assertEquals("test  a&nbsp;word", $prepositioner->formatText($input));
    }

    public function testUnicodeCharacters(): void
    {
        $words = ['în', 'și'];
        $prepositioner = new Prepositioner($words);
        $input = "text în România și test";
        self::assertEquals("text în&nbsp;România și&nbsp;test", $prepositioner->formatText($input));
    }
}
