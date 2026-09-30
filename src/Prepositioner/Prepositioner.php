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

        // Quote prepositions for safe regex usage
        $quotedPrepositions = array_map(
            /** @param string $p */
            fn($p): string => preg_quote($p, '/'),
            $this->prepositionsArray
        );
        $prepositions = implode('|', $quotedPrepositions);

        // Quote quotation marks for safe regex usage
        $quotedQuotationMarks = array_map(
            /** @param string $q */
            fn($q): string => preg_quote($q, '/'),
            $this->quotationMarkArray
        );
        $quotationMarks = implode('|', $quotedQuotationMarks);

        // Quote escape string for safe regex usage
        $quotedEscapeString = preg_quote($this->escapeString, '/');

        // Main pattern with Unicode support (/u modifier)
        $pattern = "/(\s|^|>|;|{$quotationMarks})({$prepositions})\s+(?=[^>]*(<|$))/iu";
        $replacement = "$1$2{$this->spaceCharacter}";

        // Apply replacement twice to handle consecutive prepositions
        $text = $this->safePregReplace($pattern, $replacement, $text);
        $text = $this->safePregReplace($pattern, $replacement, $text);

        // Remove escape markers
        $escapePattern = "/{$quotedEscapeString}({$prepositions}){$quotedEscapeString}/iu";
        $text = $this->safePregReplace($escapePattern, "$1", $text);

        return $text;
    }

    private function safePregReplace(string $pattern, string $replacement, string $subject): string
    {
        $result = preg_replace($pattern, $replacement, $subject);

        if ($result === null) {
            $error = preg_last_error();
            $errorMessage = $this->getPregErrorMessage($error);
            throw new PrepositionerException("preg_replace failed: {$errorMessage}");
        }

        return $result;
    }

    private function getPregErrorMessage(int $error): string
    {
        return match ($error) {
            PREG_NO_ERROR => 'No error',
            PREG_INTERNAL_ERROR => 'Internal PCRE error',
            PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit exhausted',
            PREG_RECURSION_LIMIT_ERROR => 'Recursion limit exhausted',
            PREG_BAD_UTF8_ERROR => 'Malformed UTF-8 data',
            PREG_BAD_UTF8_OFFSET_ERROR => 'Bad UTF-8 offset',
            PREG_JIT_STACKLIMIT_ERROR => 'JIT stack limit exhausted',
            default => "Unknown error (code: {$error})",
        };
    }
}
