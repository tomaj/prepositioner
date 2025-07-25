<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

final class RomanianLanguage implements LanguageInterface
{
    private const TWO_LETTER = ['cu', 'de', 'în', 'la', 'pe'];
    private const THREE_LETTER = ['cât', 'pro'];
    private const FOUR_LETTER = ['fără', 'până', 'prin', 'spre'];
    private const FIVE_LETTER = ['între', 'peste'];
    private const SIX_LETTER = ['dintre', 'pentru'];

    /**
     * @return array<string>
     */
    public function prepositions(): array
    {
        return [
            ...self::TWO_LETTER,
            ...self::THREE_LETTER,
            ...self::FOUR_LETTER,
            ...self::FIVE_LETTER,
            ...self::SIX_LETTER,
        ];
    }
}
