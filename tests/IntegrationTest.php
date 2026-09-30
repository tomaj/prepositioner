<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests;

use Tomaj\Prepositioner\Factory;
use PHPUnit\Framework\TestCase;



/**
 * @covers \Tomaj\Prepositioner\Factory
 * @covers \Tomaj\Prepositioner\Prepositioner
 * @covers \Tomaj\Prepositioner\Language\SlovakLanguage
 * @covers \Tomaj\Prepositioner\Language\CzechLanguage
 * @covers \Tomaj\Prepositioner\Language\RomanianLanguage
 */
class IntegrationTest extends TestCase
{
    public function testSlovakRealSentence(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "Išiel som do obchodu a kúpil som si knihu o prírode.";
        $expected = "Išiel som do&nbsp;obchodu a&nbsp;kúpil som si knihu o&nbsp;prírode.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testSlovakWithDiacritics(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "Chodím s kamarátmi na futbal či volejbal.";
        $expected = "Chodím s&nbsp;kamarátmi na&nbsp;futbal či&nbsp;volejbal.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testSlovakCapitalPrepositions(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "V lete cestujem po Slovensku. K morю idem cez Rakúsko.";
        $expected = "V&nbsp;lete cestujem po&nbsp;Slovensku. K&nbsp;morю idem cez&nbsp;Rakúsko.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testSlovakMultiplePrepositions(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "Išiel som z domu do mesta s bratom a s kamarátom.";
        $expected = "Išiel som z&nbsp;domu do&nbsp;mesta s&nbsp;bratom a&nbsp;s&nbsp;kamarátom.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testSlovakInHTML(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "<p>Text s predložkami v HTML.</p><div>Ďalší text k dispozícii.</div>";
        $expected = "<p>Text s&nbsp;predložkami v&nbsp;HTML.</p><div>Ďalší text k&nbsp;dispozícii.</div>";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testCzechRealSentence(): void
    {
        $prepositioner = Factory::build('czech');

        $input = "Šel jsem do obchodu a koupil jsem si knihu o přírodě.";
        $expected = "Šel jsem do&nbsp;obchodu a&nbsp;koupil jsem si knihu o&nbsp;přírodě.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testCzechWithDiacritics(): void
    {
        $prepositioner = Factory::build('czech');

        $input = "Chodím s přáteli na fotbal i volejbal.";
        $expected = "Chodím s&nbsp;přáteli na&nbsp;fotbal i&nbsp;volejbal.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testCzechCapitalPrepositions(): void
    {
        $prepositioner = Factory::build('czech');

        $input = "V létě cestuji po Čechách. K moři jedu z Prahy.";
        $expected = "V&nbsp;létě cestuji po&nbsp;Čechách. K&nbsp;moři jedu z&nbsp;Prahy.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testRomanianRealSentence(): void
    {
        $prepositioner = Factory::build('romanian');

        $input = "Am mers la magazin cu prietenii pentru cumpărături.";
        $expected = "Am mers la&nbsp;magazin cu&nbsp;prietenii pentru&nbsp;cumpărături.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testRomanianWithDiacritics(): void
    {
        $prepositioner = Factory::build('romanian');

        $input = "Merg în România cu mașina prin munți și peste câmpii.";
        $expected = "Merg în&nbsp;România cu&nbsp;mașina prin&nbsp;munți și peste&nbsp;câmpii.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testRomanianCapitalPrepositions(): void
    {
        $prepositioner = Factory::build('romanian');

        $input = "În vara mergem la mare. Cu trenul este mai rapid.";
        $expected = "În&nbsp;vara mergem la&nbsp;mare. Cu&nbsp;trenul este mai rapid.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testRomanianSpecialCharacters(): void
    {
        $prepositioner = Factory::build('romanian');

        $input = "Text în română cu ă, â, î, ș, ț.";
        $expected = "Text în&nbsp;română cu&nbsp;ă, â, î, ș, ț.";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }

    public function testLongTextPerformance(): void
    {
        $prepositioner = Factory::build('slovak');

        $text = str_repeat("Text s predložkami v slovenčine. ", 100);
        $result = $prepositioner->formatText($text);

        $this->assertStringContainsString("s&nbsp;predložkami", $result);
        $this->assertStringContainsString("v&nbsp;slovenčine", $result);
    }

    public function testMixedLanguageContent(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "Email: user@domain.com a website: https://example.com s parametrom.";
        $result = $prepositioner->formatText($input);

        $this->assertStringContainsString("a&nbsp;website", $result);
        $this->assertStringContainsString("s&nbsp;parametrom", $result);
        $this->assertStringContainsString("user@domain.com", $result);
    }

    public function testHTMLAttributes(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = '<div class="text a paragraph" data-value="s value">Text s predložkami.</div>';
        $result = $prepositioner->formatText($input);

        $this->assertStringContainsString('class="text a paragraph"', $result);
        $this->assertStringContainsString('data-value="s value"', $result);
        $this->assertStringContainsString("s&nbsp;predložkami", $result);
    }

    public function testNestedHTML(): void
    {
        $prepositioner = Factory::build('slovak');

        $input = "<div>Vonkajší text s predložkou.<span>Vnorený text a ďalší.</span>Text k záveru.</div>";
        $expected = "<div>Vonkajší text s&nbsp;predložkou.<span>Vnorený text a&nbsp;ďalší.</span>Text k&nbsp;záveru.</div>";
        $this->assertEquals($expected, $prepositioner->formatText($input));
    }
}
