<?php

require dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/TestLanguage.php';

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\LanguageInterface;

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