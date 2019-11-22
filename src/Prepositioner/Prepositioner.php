<?php

namespace Tomaj\Prepositioner;

class Prepositioner
{
    private $quotationMarkArray = ["\"", "'", "„", "‚", "“", "‘", "«", "‹"];
    private $prepositionsArray = [];

    private $spaceCharacter = "&nbsp;";

    private $escapeString;

    public function __construct(array $prepositionsArray, string $escapeString = '#####')
    {
        $this->prepositionsArray = $prepositionsArray;
        $this->escapeString = $escapeString;
    }

    public function formatText(string $text)
    {
        if (empty($this->prepositionsArray)) {
            return $text;
        }

        $prepositions = implode('|', $this->prepositionsArray);
        $quotationMarks = implode('|', $this->quotationMarkArray);

        $pattern = "#(\s|^|>|;|{$quotationMarks})({$prepositions})\s+(?=[^>]*(<|$))#i";
        $replacement = "$1$2{$this->spaceCharacter}";

        $text = preg_replace($pattern, $replacement, $text);
        $text = preg_replace($pattern, $replacement, $text);

        $pattern = "/{$this->escapeString}({$prepositions}){$this->escapeString}/i";
        $text = preg_replace($pattern, "$1", $text);

        return $text;
    }
}
