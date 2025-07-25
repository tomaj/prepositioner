<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tomaj\Prepositioner\Prepositioner;

#[CoversClass(Prepositioner::class)]
final class PrepositionerTest extends TestCase
{
    #[DataProvider('basicFormatProvider')]
    public function testBasicFormat(array $words, string $input, string $expected): void
    {
        $prepositioner = new Prepositioner($words);
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public static function basicFormatProvider(): array
    {
        return [
            'basic preposition replacement' => [
                ['a', 'asdf', 'vd'],
                "dsfoihdf s asd a sdfds asdf asd",
                "dsfoihdf s asd a&nbsp;sdfds asdf&nbsp;asd"
            ],
            'no replacement in middle of words' => [
                ['a'],
                "dsfdsfa dfsdg",
                "dsfdsfa dfsdg"
            ],
            'first word replacement' => [
                ['prvé'],
                "prvé slovo",
                "prvé&nbsp;slovo"
            ],
            'multiple same prepositions' => [
                ['a'],
                "a slovo a ešte",
                "a&nbsp;slovo a&nbsp;ešte"
            ],
            'case insensitive' => [
                ['a'],
                "A slovo",
                "A&nbsp;slovo"
            ],
        ];
    }

    public function testInWordReplace(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "dsfdsfa dfsdg";
        $this->assertEquals("dsfdsfa dfsdg", $prepositioner->formatText($input));
    }

    public function testFirstWord(): void
    {
        $words = ['prvé'];
        $prepositioner = new Prepositioner($words);
        $input = "prvé slovo";
        $this->assertEquals("prvé&nbsp;slovo", $prepositioner->formatText($input));
    }

    public function testMultipleSamePrepositions(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "a slovo a ešte";
        $this->assertEquals("a&nbsp;slovo a&nbsp;ešte", $prepositioner->formatText($input));
    }

    public function testCaseInsensitive(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "A slovo";
        $this->assertEquals("A&nbsp;slovo", $prepositioner->formatText($input));
    }

    public function testAnotherCaseInsensitive(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "slovo A slovo";
        $this->assertEquals("slovo A&nbsp;slovo", $prepositioner->formatText($input));
    }

    public function testEmpty(): void
    {
        $words = [];
        $prepositioner = new Prepositioner($words);
        $input = "a slovo a ešte";
        $this->assertEquals("a slovo a ešte", $prepositioner->formatText($input));
    }

    public function testAfterComma(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = ", a slovo";
        $this->assertEquals(", a&nbsp;slovo", $prepositioner->formatText($input));
    }

    public function testAfterOpeningQuote(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = '„a slovo"';
        $this->assertEquals('„a&nbsp;slovo"', $prepositioner->formatText($input));
    }

    public function testInHtml(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "<div>a slovo</div>";
        $this->assertEquals("<div>a&nbsp;slovo</div>", $prepositioner->formatText($input));
    }

    public function testInHtmlAttribute(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = '<div title="a slovo">some content</div>';
        $this->assertEquals('<div title="a slovo">some content</div>', $prepositioner->formatText($input));
    }

    public function testEscaping(): void
    {
        $words = ['a'];
        $prepositioner = new Prepositioner($words);
        $input = "test #####a##### escaped";
        $this->assertEquals("test a escaped", $prepositioner->formatText($input));
    }

    public function testCustomEscapeString(): void
    {
        $words = ['a'];
        $customEscape = '%%%';
        $prepositioner = new Prepositioner($words, $customEscape);
        $input = "test %%%a%%% escaped";
        $this->assertEquals("test a escaped", $prepositioner->formatText($input));
    }

    public function testComplexText(): void
    {
        $words = ['a', 'o', 'v', 'na'];
        $prepositioner = new Prepositioner($words);
        $input = "Toto je text a tu máme predložky o ktorých sa bavíme. Sú v texte na rôznych miestach.";
        $expected = "Toto je text a&nbsp;tu máme predložky o&nbsp;ktorých sa bavíme. Sú v&nbsp;texte na&nbsp;rôznych miestach.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    #[DataProvider('htmlTestProvider')]
    public function testHtmlContexts(string $input, string $expected): void
    {
        $words = ['a', 'v'];
        $prepositioner = new Prepositioner($words);
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public static function htmlTestProvider(): array
    {
        return [
            'simple html tag' => [
                '<p>a slovo v texte</p>',
                '<p>a&nbsp;slovo v&nbsp;texte</p>'
            ],
            'html with attributes' => [
                '<div class="test">a slovo</div>',
                '<div class="test">a&nbsp;slovo</div>'
            ],
            'nested html' => [
                '<div><span>a slovo</span> v texte</div>',
                '<div><span>a&nbsp;slovo</span> v&nbsp;texte</div>'
            ],
            'html attribute should not be changed' => [
                '<img alt="a slovo" src="test.jpg">',
                '<img alt="a slovo" src="test.jpg">'
            ],
        ];
    }
}
