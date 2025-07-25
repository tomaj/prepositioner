<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

interface LanguageInterface
{
    /**
     * Returns an array of prepositions for the language.
     *
     * @return array<string> Array of prepositions
     */
    public function prepositions(): array;
}
