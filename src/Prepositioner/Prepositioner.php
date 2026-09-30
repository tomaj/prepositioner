<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

class Prepositioner
{
    /** @var array<int, string> */
    private array $quotationMarkArray = ["\"", "'", "\u{201E}", "\u{201A}", "\u{201C}", "\u{2018}", "«", "‹"];

    /** @var array<int, string> */
    private array $prepositionsArray = [];

    private string $spaceCharacter = "&nbsp;";

    private string $escapeString;

    /**
     * @param array<int, string> $prepositionsArray
     */
    public function __construct(array $prepositionsArray, string $escapeString = '#####')
    {
        $this->prepositionsArray = $prepositionsArray;
        $this->escapeString = $escapeString;
    }

    public function formatText(string $text): string
    {
        if ($this->prepositionsArray === []) {
            return $text;
        }

        $prepositions = implode('|', $this->prepositionsArray);
        $quotationMarks = implode('|', $this->quotationMarkArray);

        $pattern = "#(\s|^|>|;|{$quotationMarks})({$prepositions})\s+(?=[^>]*(<|$))#i";
        $replacement = "$1$2{$this->spaceCharacter}";

        $result = preg_replace($pattern, $replacement, $text);
        if ($result === null) {
            return $text;
        }
        $text = $result;

        $result = preg_replace($pattern, $replacement, $text);
        if ($result === null) {
            return $text;
        }
        $text = $result;

        $escapePattern = "/{$this->escapeString}({$prepositions}){$this->escapeString}/i";
        $result = preg_replace($escapePattern, "$1", $text);
        if ($result === null) {
            return $text;
        }

        return $result;
    }
}
