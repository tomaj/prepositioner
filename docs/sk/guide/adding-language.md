# Pridanie jazyka

Chcete pridať podporu nového jazyka? Tento návod vás prevedie celým postupom.

## Prehľad

Pridanie jazyka do Prepositionera má tri hlavné kroky:

1. Vytvoriť triedu jazyka, ktorá implementuje `LanguageInterface`
2. Napísať pre nový jazyk testy
3. Poslať pull request

## Krok 1: Trieda jazyka

V adresári `src/Prepositioner/Language/` vytvorte nový súbor s názvom podľa vzoru `{Language}Language.php`.

### Štruktúra

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class EnglishLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            // Add all prepositions for your language
            'a', 'an', 'the',
            'in', 'on', 'at', 'to', 'for',
            'of', 'from', 'with', 'by',
            // ... more prepositions
        ];
    }
}
```

### Zásady

**Čo zahrnúť:**
- jednopísmenové predložky (a spojky),
- viacpísmenové predložky,
- bežné predložkové spojenia, ak to v danom jazyku dáva zmysel.

**Čo nezahŕňať:**
- viacslabičné alebo veľmi dlhé predložky (pri zalamovaní riadkov problém robia len zriedka),
- predložky, ktoré bežne stoja na konci vety,
- slová, ktoré sú predložkami len niekedy.

**Tipy:**
- naštudujte si gramatické pravidlá jazyka,
- pozrite sa do typografických príručiek pre daný jazyk,
- inšpirujte sa existujúcimi implementáciami (slovenčina, čeština, rumunčina),
- vyskúšajte to na skutočných textoch v danom jazyku.

### Príklad: pridanie nemčiny

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class GermanLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return [
            // Two-way prepositions
            'an', 'auf', 'in', 'über', 'unter', 'vor', 'hinter', 'neben', 'zwischen',
            
            // Accusative prepositions
            'durch', 'für', 'gegen', 'ohne', 'um', 'bis', 'entlang',
            
            // Dative prepositions
            'aus', 'bei', 'mit', 'nach', 'seit', 'von', 'zu',
            
            // Genitive prepositions
            'wegen', 'während', 'trotz', 'statt',
        ];
    }
}
```

## Krok 2: Testy

V adresári `tests/Language/` vytvorte testovací súbor s názvom podľa vzoru `{Language}LanguageTest.php`.

### Základná štruktúra testu

Ak triedu odvodíte od `LanguageTestCase`, základné požiadavky sa overia automaticky:

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Tests\Language;

use PHPUnit\Framework\Attributes\CoversClass;
use Tomaj\Prepositioner\Language\EnglishLanguage;
use Tomaj\Prepositioner\Language\LanguageInterface;
use Tomaj\Prepositioner\Tests\LanguageTestCase;

#[CoversClass(EnglishLanguage::class)]
class EnglishLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): LanguageInterface
    {
        return new EnglishLanguage();
    }
}
```

Základná trieda `LanguageTestCase` automaticky overí, že:
- metóda vracia pole,
- pole obsahuje aspoň jednu predložku,
- všetky predložky sú neprázdne reťazce,
- žiadna predložka sa neopakuje,
- všetky predložky obsahujú iba povolené znaky.

### Ďalšie testy pre konkrétny jazyk

Pridajte testy, ktoré overia požiadavky špecifické pre daný jazyk:

```php
<?php

public function testContainsCommonPrepositions(): void
{
    $language = $this->createLanguage();
    $result = $language->prepositions();
    
    // Test that common prepositions are included
    self::assertContains('the', $result);
    self::assertContains('in', $result);
    self::assertContains('on', $result);
    self::assertContains('at', $result);
}

public function testPrepositionsAreLowercase(): void
{
    $language = $this->createLanguage();
    $result = $language->prepositions();
    
    foreach ($result as $preposition) {
        self::assertEquals(
            strtolower($preposition),
            $preposition,
            "Preposition '{$preposition}' should be lowercase"
        );
    }
}
```

### Integračný test

Napíšte test, ktorý overí, že jazyk funguje cez `Factory`:

```php
<?php

public function testFactoryIntegration(): void
{
    $prepositioner = \Tomaj\Prepositioner\Factory::build('english');
    
    $input = "The book is on a table in the room.";
    $result = $prepositioner->formatText($input);
    
    // Verify that prepositions are properly processed
    self::assertStringContainsString('&nbsp;', $result);
}
```

### Testy so skutočnými vetami

Pridajte testy so skutočnými vetami v danom jazyku:

```php
<?php

public function testRealSentence(): void
{
    $prepositioner = \Tomaj\Prepositioner\Factory::build('english');
    
    $input = "I went to the store in the morning.";
    $result = $prepositioner->formatText($input);
    
    // Verify specific prepositions are replaced
    self::assertStringContainsString('to&nbsp;the', $result);
    self::assertStringContainsString('in&nbsp;the', $result);
}
```

## Krok 3: Spustenie testov

Pred odoslaním sa uistite, že všetky testy prechádzajú:

```bash
# Run all tests
composer test

# Run only your language tests
vendor/bin/phpunit tests/Language/EnglishLanguageTest.php

# Run code style check
composer phpcs

# Run static analysis
composer phpstan

# Run all checks
composer check
```

## Krok 4: Aktualizácia dokumentácie

Doplňte nový jazyk do README.md a do dokumentácie:

1. Aktualizujte sekciu „Supported Languages“ v README.md
2. Pridajte príklad použitia
3. Vypíšte zahrnuté predložky

## Krok 5: Pull request

1. Forknite repozitár
2. Vytvorte novú vetvu: `git checkout -b add-language-english`
3. Commitnite zmeny: `git commit -m "Add English language support"`
4. Pushnite ich do svojho forku: `git push origin add-language-english`
5. Otvorte pull request na GitHube

### Čo uviesť v pull requeste

Pri otváraní PR uveďte:

- **názov jazyka** (po anglicky aj v pôvodnom jazyku),
- **počet predložiek**, ktoré ste zahrnuli,
- **zdroje** (gramatické príručky, typografické normy),
- **príklady z praxe**, ktoré ukazujú, že jazyk funguje správne,
- **prečo práve tento jazyk** (je po ňom dopyt? Spravujete projekty, ktoré ho používajú?).

## Alternatíva: žiadosť o podporu jazyka

Ak to nechcete implementovať sami, môžete [založiť issue so žiadosťou o podporu jazyka](https://github.com/tomaj/prepositioner/issues/new?template=language_support.md) a v ňom opísať:

- jazyk, ktorý by ste chceli mať podporovaný,
- prečo ho potrebujete,
- odkazy na gramatické pravidlá alebo typografické normy.

## Kontrolný zoznam pre nový jazyk

- [ ] Vytvorený `{Language}Language.php` v `src/Prepositioner/Language/`
- [ ] Implementuje `LanguageInterface`
- [ ] Používa `declare(strict_types=1);`
- [ ] Obsahuje riadny PHPDoc
- [ ] Má úplný zoznam predložiek
- [ ] Vytvorený `{Language}LanguageTest.php` v `tests/Language/`
- [ ] Je odvodený od `LanguageTestCase`
- [ ] Používa atribút `#[CoversClass(...)]`
- [ ] Obsahuje testy špecifické pre jazyk
- [ ] Testuje skutočné vety
- [ ] Všetky testy prechádzajú
- [ ] Kontrola štýlu kódu prechádza (`composer phpcs`)
- [ ] Statická analýza prechádza (`composer phpstan`)
- [ ] README.md je aktualizované
- [ ] Dokumentácia je aktualizovaná

## Otázky?

Ak máte otázky k pridaniu jazyka:

1. Pozrite sa na existujúce implementácie jazykov
2. Prečítajte si [návod, ako prispieť](/sk/contributing)
3. Otvorte diskusiu na GitHube
4. Opýtajte sa priamo v pull requeste

Radi vám s pridaním vášho jazyka pomôžeme!
