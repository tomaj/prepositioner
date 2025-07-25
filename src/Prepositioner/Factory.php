<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

use Tomaj\Prepositioner\Language\LanguageInterface;

final class Factory
{
    public static function build(string $language, string $escapeString = '#####'): Prepositioner
    {
        $languageInstance = self::createLanguageInstance($language);
        return new Prepositioner($languageInstance->prepositions(), $escapeString);
    }

    private static function createLanguageInstance(string $language): LanguageInterface
    {
        $className = match (strtolower($language)) {
            'slovak' => '\Tomaj\Prepositioner\Language\SlovakLanguage',
            'czech' => '\Tomaj\Prepositioner\Language\CzechLanguage',
            'romanian' => '\Tomaj\Prepositioner\Language\RomanianLanguage',
            'empty' => '\Tomaj\Prepositioner\Language\EmptyLanguage',
            default => '\Tomaj\Prepositioner\Language\\' . ucfirst($language) . 'Language'
        };

        if (!class_exists($className)) {
            throw new LanguageNotExistsException("Language class '$className' doesn't exist");
        }

        $instance = new $className();

        if (!$instance instanceof LanguageInterface) {
            throw new LanguageNotExistsException("Language class '$className' must implement LanguageInterface");
        }

        return $instance;
    }
}
