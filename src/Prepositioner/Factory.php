<?php

namespace Tomaj\Prepositioner;

class Factory
{
	public static function build($language)
	{
		$className = ucfirst($language) . 'Language';
		if (class_exists($className)) {
			$language = new $className;
			return new Prepositioner($language->prepositions());
		}

		throw new LanguageNotExistsException("Language class '$className' doesn't exists");
	}
}