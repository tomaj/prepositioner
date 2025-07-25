<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

final class SlovakLanguage implements LanguageInterface
{
    private const ONE_LETTER = ['a', 'i', 'k', 'o', 'v', 'u', 'z', 's'];
    private const TWO_LETTER = ['do', 'od', 'zo', 'ku', 'na', 'po', 'so', 'za', 'vo', 'či'];
    private const THREE_LETTER = ['cez', 'pre', 'nad', 'pod', 'pri'];
    private const FOUR_LETTER = ['spod', 'pred', 'skrz'];

    /**
     * @return array<string>
     */
    public function prepositions(): array
    {
        return [
            ...self::ONE_LETTER,
            ...self::TWO_LETTER,
            ...self::THREE_LETTER,
            ...self::FOUR_LETTER,
        ];
    }
}
