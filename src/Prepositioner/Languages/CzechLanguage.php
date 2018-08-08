<?php

namespace Tomaj\Prepositioner;

class CzechLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            /* 1 letter */
            'a',
            'i',
            'k',
            'o',
            'v',
            'u',
            'z',
            's',
        ];
    }
}
