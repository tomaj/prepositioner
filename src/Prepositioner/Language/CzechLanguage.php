<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

final class CzechLanguage implements LanguageInterface
{
    private const PREPOSITIONS = ['a', 'i', 'k', 'o', 'v', 'u', 'z', 's'];

    /**
     * @return array<string>
     */
    public function prepositions(): array
    {
        return self::PREPOSITIONS;
    }
}
