<?php

namespace Tomaj\Prepositioner;

class Prepositioner
{
    private $prepositionsArray = array();

    private $spaceCharacter = "&nbsp;";

    public function __construct($prepositionsArray)
    {
        $this->prepositionsArray = $prepositionsArray;
    }

    public function formatText($text)
    {
        if (empty($this->prepositionsArray)) {
            return $text;
        }

        $prepositions = implode('|', $this->prepositionsArray);

        $pattern = "#(\s|^)({$prepositions})\s+(?=[^>]*(<|$))#i";
        $replacement = "$1$2{$this->spaceCharacter}";

        $text = preg_replace($pattern, $replacement, $text);
        return $text;
    }
}
