<?php

namespace Tomaj\Prepositioner\Language;

class SlovakLanguage implements LanguageInterface
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

            /* 2 letter */
            'do',
            'od',
            'zo',
            'ku',
            'na',
            'po',
            'so',
            'za',
            'vo',
            'či',

            /* 3 letter */
            'cez',
            'pre',
            'nad',
            'pod',
            'pri',

            /* 4 letter */
            'spod',
            'pred',
            'skrz',
        ];
    }
}
