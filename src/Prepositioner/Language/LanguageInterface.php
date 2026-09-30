<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

interface LanguageInterface
{
    /**
     * @return array<int, string>
     */
    public function prepositions(): array;
}
