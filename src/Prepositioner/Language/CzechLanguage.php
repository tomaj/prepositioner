<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class CzechLanguage implements LanguageInterface
{
    /**
     * @return array<int, string>
     */
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
