<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

use Tomaj\Prepositioner\Language\LanguageInterface;

class Factory
{
    public static function build(string $language, string $escapeString = '#####'): Prepositioner
    {
        $className = '\Tomaj\Prepositioner\Language\\' . ucfirst($language) . 'Language';

        if (!class_exists($className)) {
            throw new LanguageNotExistsException("Language class '$className' does not exist");
        }

        $languageInstance = new $className();

        if (!$languageInstance instanceof LanguageInterface) {
            throw new LanguageNotExistsException("Language class '$className' must implement LanguageInterface");
        }

        return new Prepositioner($languageInstance->prepositions(), $escapeString);
    }
}
