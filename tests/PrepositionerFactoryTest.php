<?php

require dirname(__FILE__). '/../vendor/autoload.php';

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\LanguageInterface;

class TestLanguage implements LanguageInterface
{
    public function prepositions()
    {
        return array('a', 'b');
    }
}

class PrepositionerFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreatePrepositioner()
    {
        $prepositioner = Factory::build('test');
        $this->assertEquals('Tomaj\Prepositioner\Prepositioner', get_class($prepositioner));
    }

    /**
     * @expectedException Tomaj\Prepositioner\LanguageNotExistsException
     */
    public function testFactoryThrowExceptionOnUnknownLanguage()
    {
        $prepositioner = Factory::build('asfsdgsdgdsgf');
    }
}