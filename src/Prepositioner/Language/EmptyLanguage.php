<?php

namespace Tomaj\Prepositioner\Language;

class EmptyLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [];
    }
}
