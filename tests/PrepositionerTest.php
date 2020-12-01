<?php

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Prepositioner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Tomaj\Prepositioner\Prepositioner
 */
class PrepositionerTest extends TestCase
{
    public function testBasicFormat()
    {
        $words = ['a', 'asdf', 'vd'];
        $prepositioner = new Prepositioner($words);
        $input = "dsfoihdf s asd a sdfds asdf asd";
        $this->assertEquals("dsfoihdf s asd a&nbsp;sdfds asdf&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testInWordReplace()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "dsfdsfa dfsdg";
        $this->assertEquals("dsfdsfa dfsdg", $prepositioner->formatText($input));
    }

    public function testFirstWord()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "a asfs a asfd";
        $this->assertEquals("a&nbsp;asfs a&nbsp;asfd", $prepositioner->formatText($input));
    }

    public function testLastWord()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asfd a";
        $this->assertEquals("asfd a", $prepositioner->formatText($input));
    }

    public function testSimplePreposition()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "a";
        $this->assertEquals("a", $prepositioner->formatText($input));
    }

    public function testUpperLowerCase()
    {
        $words = ['a', 'AsD', 'C', 'EE'];
        $prepositioner = new Prepositioner($words);
        $input = "A acd asd fef c xxx Ee grgr";
        $this->assertEquals("A&nbsp;acd asd&nbsp;fef c&nbsp;xxx Ee&nbsp;grgr", $prepositioner->formatText($input));
    }

    public function testMultipleSpaces()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a   asd";
        $this->assertEquals("asd a&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testHtmlTextElementReplace()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <a>sa a sd</a>";
        $this->assertEquals("asd a&nbsp;fs <a>sa a&nbsp;sd</a>", $prepositioner->formatText($input));
    }
    
    public function testHtmlContentDoesntReplace()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <p a sad>sdasd</p>";
        $this->assertEquals("asd a&nbsp;fs <p a sad>sdasd</p>", $prepositioner->formatText($input));

        $input = "asd a fs <p class=\"asd a c\">sdasd</p>";
        $this->assertEquals("asd a&nbsp;fs <p class=\"asd a c\">sdasd</p>", $prepositioner->formatText($input));
    }

    public function testSpecialCharacters()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a\t\tx a\nasdcdcd a<br/>asd";
        $this->assertEquals("asd a&nbsp;x a&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));

        $input = "asd\t\ta\tx \na asdcdcd a<br/>asd";
        $this->assertEquals("asd\t\ta&nbsp;x \na&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));
    }

    public function testFirstWordInTag()
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "<p>a bout</p>";
        $this->assertEquals("<p>a&nbsp;bout</p>", $prepositioner->formatText($input));
    }

    public function testDisablePrepositionsReplace()
    {
        $words = ['a', 'b'];
        $prepositioner = new Prepositioner($words, '#####');
        $input = "asd #####a##### asdsa b cc a asd s b";
        $this->assertEquals("asd a asdsa b&nbsp;cc a&nbsp;asd s b", $prepositioner->formatText($input));
    }

    public function testMorePreposition()
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = "asd a c b asd b c";
        $this->assertEquals("asd a&nbsp;c&nbsp;b&nbsp;asd b&nbsp;c", $prepositioner->formatText($input));
    }

    public function testMultiplePreposition()
    {
        $words = ['a', 'b', 'c'];
        $prepositioner = new Prepositioner($words);
        $input = "a b c a b b c";
        $this->assertEquals("a&nbsp;b&nbsp;c&nbsp;a&nbsp;b&nbsp;b&nbsp;c", $prepositioner->formatText($input));
    }

    public function testPrepositionAfterStraightQuotationMark()
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: "on to the hill, man"';
        $this->assertEquals('He said: "on&nbsp;to&nbsp;the&nbsp;hill, man"', $prepositioner->formatText($input));
    }

    public function testPrepositionAfterLeftDoubleQuotationMark()
    {
        $words = ['on', 'to', 'the'];
        $prepositioner = new Prepositioner($words);
        $input = 'He said: “on to the hill, man”';
        $this->assertEquals('He said: “on&nbsp;to&nbsp;the&nbsp;hill, man”', $prepositioner->formatText($input));
    }
}
