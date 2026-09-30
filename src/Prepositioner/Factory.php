<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

class Factory
{
    public static function build(string $language, string $escapeString = '#####'): Prepositioner
    {
        $className = '\Tomaj\Prepositioner\Language\\' . ucfirst($language) . 'Language';
        if (!class_exists($className)) {
            throw new LanguageNotExistsException("Language class '$className' does not exist");
        }

        /** @var Language\LanguageInterface $languageInstance */
        $languageInstance = new $className();

        return new Prepositioner($languageInstance->prepositions(), $escapeString);
    }
}
