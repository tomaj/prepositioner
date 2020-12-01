<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class RomanianLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            /* 2 letter */
            'cu',
            'de',
            'în',
            'la',
            'pe',

            /* 3 letter */
            'cât',
            'pro',

            /* 4 letter */
            'fără',
            'până',
            'prin',
            'spre',

            /* 5 letter */
            'între',
            'peste',

            /* 6 letter */
            'dintre',
            'pentru',
        ];
    }
}
