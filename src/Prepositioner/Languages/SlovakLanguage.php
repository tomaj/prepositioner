<?php

namespace Tomaj\Prepositioner;

class SlovakLanguage implements LanguageInterface
{
    public function prepositions()
    {
        return array(
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
            'niže',
            'voči',
            'pred',
            'skrz',


            /* 5 letter */
            'podľa',
            'proti',
            'kvôli',
            'medzi',
            'popri',
            'okolo',
            'popod',

            /* 6 letter */
            'sponad',
            'naproti',

            /* more */
            'spomedzi',
            'prostred',
            'vrátane',
            'napriek',
        );
    }
}
