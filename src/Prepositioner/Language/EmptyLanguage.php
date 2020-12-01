<?php
declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class EmptyLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [];
    }
}
