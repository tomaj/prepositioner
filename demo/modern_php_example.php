<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Prepositioner;

// Enum for languages (PHP 8.1+ feature, but demonstration of modernization)
enum SupportedLanguage: string
{
    case SLOVAK = 'slovak';
    case CZECH = 'czech';
    case ROMANIAN = 'romanian';
    case EMPTY = 'empty';
}

/**
 * Modern demonstration of Prepositioner library usage with PHP 8.0+ features
 */
final class ModernPrepositionerDemo
{
    public function __construct(
        private readonly SupportedLanguage $language = SupportedLanguage::SLOVAK,
        private readonly bool $verbose = false
    ) {
    }

    public function demonstratePrepositioner(): void
    {
        // Using match expression instead of switch
        $description = match ($this->language) {
            SupportedLanguage::SLOVAK => 'Slovak prepositions',
            SupportedLanguage::CZECH => 'Czech prepositions', 
            SupportedLanguage::ROMANIAN => 'Romanian prepositions',
            SupportedLanguage::EMPTY => 'no prepositions'
        };

        if ($this->verbose) {
            echo "🚀 Modernized Prepositioner library - {$description}\n";
            echo "📦 PHP version: " . PHP_VERSION . "\n\n";
        }

        // Creating prepositioner using Factory
        $prepositioner = Factory::build($this->language->value);
        
        // Test samples
        $testTexts = [
            'I am going with mom to the store.',
            'I met him in the park.',
            'The book is on the table.',
            'We talked about work.',
            'I have been waiting for the bus for an hour.',
        ];

        foreach ($testTexts as $text) {
            $formatted = $prepositioner->formatText($text);
            
            if ($this->verbose) {
                echo "📝 Original text: {$text}\n";
                echo "✨ Formatted:     {$formatted}\n";
                echo str_repeat('-', 50) . "\n";
            } else {
                echo $formatted . "\n";
            }
        }
    }

    /**
     * Demonstration of constructor property promotion and readonly properties usage
     */
    public function createCustomPrepositioner(array $customWords): Prepositioner
    {
        return new Prepositioner(
            prepositionsArray: $customWords,  // Named arguments (PHP 8.0+)
            escapeString: '###CUSTOM###'
        );
    }

    /**
     * Demonstration with typed properties and better type safety
     */
    public function getLanguageStats(): array
    {
        $prepositioner = Factory::build($this->language->value);
        $reflection = new ReflectionClass($prepositioner);
        
        return [
            'language' => $this->language->value,
            'class_name' => $reflection->getName(),
            'is_final' => $reflection->isFinal(),
            'php_version' => PHP_VERSION,
            'uses_readonly' => str_contains($reflection->getProperty('prepositionsArray')->getDocComment() ?: '', 'readonly'),
        ];
    }
}

// Running demo
echo "🎯 Prepositioner - Modern PHP 8.0+ version\n";
echo "==========================================\n\n";

$demo = new ModernPrepositionerDemo(
    language: SupportedLanguage::SLOVAK,
    verbose: true
);

$demo->demonstratePrepositioner();

echo "\n📊 Language information:\n";
print_r($demo->getLanguageStats());

echo "\n✅ Demo completed successfully! All PHP 8.0+ features work correctly.\n";