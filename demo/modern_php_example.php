<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Prepositioner;

// Enum pre jazyky (PHP 8.1+ feature, ale ukážka modernizácie)
enum SupportedLanguage: string
{
    case SLOVAK = 'slovak';
    case CZECH = 'czech';
    case ROMANIAN = 'romanian';
    case EMPTY = 'empty';
}

/**
 * Moderná ukážka použitia Prepositioner knižnice s PHP 8.0+ funkciami
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
        // Použitie match expression namiesto switch
        $description = match ($this->language) {
            SupportedLanguage::SLOVAK => 'slovenské predložky',
            SupportedLanguage::CZECH => 'české predložky', 
            SupportedLanguage::ROMANIAN => 'rumunské predložky',
            SupportedLanguage::EMPTY => 'žiadne predložky'
        };

        if ($this->verbose) {
            echo "🚀 Modernizovaná Prepositioner knižnica - {$description}\n";
            echo "📦 PHP verzia: " . PHP_VERSION . "\n\n";
        }

        // Vytvorenie prepositioner pomocou Factory
        $prepositioner = Factory::build($this->language->value);
        
        // Test vzorky
        $testTexts = [
            'Idem s mamou do obchodu.',
            'Stretol som ho v parku.',
            'Kniha je na stole.',
            'Rozprávali sme sa o práci.',
            'Čakám na autobus už hodinu.',
        ];

        foreach ($testTexts as $text) {
            $formatted = $prepositioner->formatText($text);
            
            if ($this->verbose) {
                echo "📝 Pôvodný text: {$text}\n";
                echo "✨ Formatovaný:   {$formatted}\n";
                echo str_repeat('-', 50) . "\n";
            } else {
                echo $formatted . "\n";
            }
        }
    }

    /**
     * Ukážka použitia constructor property promotion a readonly properties
     */
    public function createCustomPrepositioner(array $customWords): Prepositioner
    {
        return new Prepositioner(
            prepositionsArray: $customWords,  // Named arguments (PHP 8.0+)
            escapeString: '###CUSTOM###'
        );
    }

    /**
     * Ukážka s typed properties a lepšou type safety
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

// Spustenie demo
echo "🎯 Prepositioner - Moderná PHP 8.0+ verzia\n";
echo "==========================================\n\n";

$demo = new ModernPrepositionerDemo(
    language: SupportedLanguage::SLOVAK,
    verbose: true
);

$demo->demonstratePrepositioner();

echo "\n📊 Informácie o jazyku:\n";
print_r($demo->getLanguageStats());

echo "\n✅ Demo úspešne dokončené! Všetky PHP 8.0+ funkcie fungujú správne.\n";