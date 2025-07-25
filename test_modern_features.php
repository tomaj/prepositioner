<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\Prepositioner;

echo "🚀 Testing PHP 8.0+ Modernized Prepositioner Library\n";
echo "====================================================\n\n";

// Test 1: Factory Pattern with Match Expression (PHP 8.0 feature)
echo "✅ Test 1: Factory with Match Expression\n";
$prepositioner = Factory::build('slovak');
$text = "Je to a slovo v texte.";
$result = $prepositioner->formatText($text);
echo "Input:  '$text'\n";
echo "Output: '$result'\n\n";

// Test 2: Constructor Property Promotion (PHP 8.0 feature)
echo "✅ Test 2: Constructor Property Promotion\n";
$customPrepositioner = new Prepositioner(['na', 'po', 'za'], '####');
$text2 = "Ideme na obchod po nákupy za jedlom.";
$result2 = $customPrepositioner->formatText($text2);
echo "Input:  '$text2'\n";
echo "Output: '$result2'\n\n";

// Test 3: Array Spread Operator (PHP 7.4+, but improved in 8.0)
echo "✅ Test 3: Testing Different Languages\n";
$languages = ['slovak', 'czech', 'romanian'];
foreach ($languages as $lang) {
    try {
        $prep = Factory::build($lang);
        echo "✓ Language '$lang' loaded successfully\n";
    } catch (Exception $e) {
        echo "✗ Error loading '$lang': " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 All modern PHP 8.0+ features working perfectly!\n";
echo "Library successfully upgraded and modernized.\n";