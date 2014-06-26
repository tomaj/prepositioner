<?php

namespace Tomaj\Prepositioner;

// This need to be removed but i need to change factory behaviour
class TestLanguage implements LanguageInterface
{
    public function prepositions()
    {
        return array('a', 'b');
    }
}
