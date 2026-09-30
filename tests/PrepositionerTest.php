<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Prepositioner;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;



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
}
