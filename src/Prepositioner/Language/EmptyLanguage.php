<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

final class EmptyLanguage implements LanguageInterface
{
    /**
     * @return array<string>
     */
    public function prepositions(): array
    {
        return [];
    }
}
