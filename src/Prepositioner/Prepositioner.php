<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner;

final class Prepositioner
{
    private const QUOTATION_MARKS = ["\"", "'", "„", "‚", "“", "‘", "«", "‹"];
    private const SPACE_CHARACTER = "&nbsp;";

    /**
     * @param array<string> $prepositionsArray
     */
    public function __construct(
        private readonly array $prepositionsArray,
        private readonly string $escapeString = '#####'
    ) {
    }

    public function formatText(string $text): string
    {
        if (empty($this->prepositionsArray)) {
            return $text;
        }

        $prepositions = implode('|', $this->prepositionsArray);
        $quotationMarks = implode('|', self::QUOTATION_MARKS);

        $pattern = "#(\s|^|>|;|{$quotationMarks})({$prepositions})\s+(?=[^>]*(<|$))#i";
        $replacement = "$1$2" . self::SPACE_CHARACTER;

        // Apply the pattern twice for edge cases
        $text = preg_replace($pattern, $replacement, $text);
        $text = preg_replace($pattern, $replacement, $text);

        // Restore escaped prepositions
        $escapePattern = "/{$this->escapeString}({$prepositions}){$this->escapeString}/i";
        $text = preg_replace($escapePattern, "$1", $text);

        return $text ?? '';
    }
}
