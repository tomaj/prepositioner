<?php

require dirname(__FILE__). '/../vendor/autoload.php';

use Tomaj\Prepositioner\Prepositioner;

class PrepositionerTest extends PHPUnit_Framework_TestCase
{
    public function testBasicFormat()
    {
        $words = array('a', 'asdf', 'vd');
        $prepositioner = new Prepositioner($words);
        $input = "dsfoihdf s asd a sdfds asdf asd";
        $this->assertEquals("dsfoihdf s asd a&nbsp;sdfds asdf&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testInWordReplace()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "dsfdsfa dfsdg";
        $this->assertEquals("dsfdsfa dfsdg", $prepositioner->formatText($input));
    }

    public function testFirstWord()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "a asfs a asfd";
        $this->assertEquals("a&nbsp;asfs a&nbsp;asfd", $prepositioner->formatText($input));
    }

    public function testLastWord()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "asfd a";
        $this->assertEquals("asfd a", $prepositioner->formatText($input));    
    }

    public function testSimplePreposition()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "a";
        $this->assertEquals("a", $prepositioner->formatText($input));        
    }

    public function testUpperLowerCase()
    {
        $words = array('a', 'AsD', 'C', 'EE');
        $prepositioner = new Prepositioner($words);
        $input = "A acd asd fef c xxx Ee grgr";
        $this->assertEquals("A&nbsp;acd asd&nbsp;fef c&nbsp;xxx Ee&nbsp;grgr", $prepositioner->formatText($input));
    }

    public function testMultipleSpaces()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "asd a   asd";
        $this->assertEquals("asd a&nbsp;asd", $prepositioner->formatText($input));
    }

    public function testHtmlTextElementReplace()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <a>sa a sd</a>";
        $this->assertEquals("asd a&nbsp;fs <a>sa a&nbsp;sd</a>", $prepositioner->formatText($input));
    }
    
    public function testHtmlContentDoesntReplace()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "asd a fs <p a sad>sdasd</p>";
        $this->assertEquals("asd a&nbsp;fs <p a sad>sdasd</p>", $prepositioner->formatText($input));

        $input = "asd a fs <p class=\"asd a c\">sdasd</p>";
        $this->assertEquals("asd a&nbsp;fs <p class=\"asd a c\">sdasd</p>", $prepositioner->formatText($input));
    }

    public function testSpecialCharacters()
    {
        $words = array('a');
        $prepositioner = new Prepositioner($words);
        $input = "asd a\t\tx a\nasdcdcd a<br/>asd";
        $this->assertEquals("asd a&nbsp;x a&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));

        $input = "asd\t\ta\tx \na asdcdcd a<br/>asd";
        $this->assertEquals("asd\t\ta&nbsp;x \na&nbsp;asdcdcd a<br/>asd", $prepositioner->formatText($input));
    }
}