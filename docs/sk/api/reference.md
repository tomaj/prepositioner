# Referencia API

Úplný prehľad všetkých verejných tried a metód knižnice Prepositioner.

::: info Menný priestor
Všetky triedy sú v mennom priestore `Tomaj\Prepositioner`.
:::

## Trieda Prepositioner

Hlavná trieda na spracovanie textu.

### Konštruktor

```php
public function __construct(array $prepositionsArray, string $escapeString = '#####')
```

Vytvorí novú inštanciu Prepositionera.

**Parametre:**
- `$prepositionsArray` (array<int, string>) – pole predložiek, za ktoré sa má vložiť nezalomiteľná medzera
- `$escapeString` (string, nepovinný) – reťazec, ktorým sa označia predložky, ktoré sa nahradiť nemajú. Predvolená hodnota: `'#####'`

**Príklad:**

```php
<?php

$prepositioner = new Prepositioner(['a', 'v', 'o']);
$prepositioner = new Prepositioner(['a', 'v', 'o'], '***'); // Custom escape string
```

### formatText()

```php
public function formatText(string $text): string
```

Spracuje vstupný text a medzery za predložkami nahradí nezalomiteľnými medzerami.

**Parametre:**
- `$text` (string) – text na spracovanie

**Vracia:**
- (string) – spracovaný text s nezalomiteľnými medzerami

**Vyhadzuje:**
- `PrepositionerException` – ak spracovanie regulárnym výrazom zlyhá (neplatné UTF-8, prekročené limity vzoru a podobne)

::: warning Nekompatibilná zmena vo verzii 4.0
Od verzie 4.0 táto metóda pri chybe vyhodí `PrepositionerException`. Predtým potichu vrátila pôvodný text.
:::

**Príklad:**

```php
<?php

$prepositioner = new Prepositioner(['a', 'v']);
$result = $prepositioner->formatText('Text a more text v even more.');
// Returns: "Text a&nbsp;more text v&nbsp;even more."
```

**Spracovanie chýb:**

```php
<?php

use Tomaj\Prepositioner\PrepositionerException;

try {
    $result = $prepositioner->formatText($text);
} catch (PrepositionerException $e) {
    // Handle error
    error_log($e->getMessage());
}
```

## Trieda Factory

Továreň na vytváranie inštancií Prepositionera so vstavanou podporou jazykov.

### build()

```php
public static function build(string $language, string $escapeString = '#####'): Prepositioner
```

Vytvorí inštanciu Prepositionera pre zadaný jazyk.

**Parametre:**
- `$language` (string) – identifikátor jazyka: `'slovak'`, `'czech'`, `'romanian'` alebo `'empty'`
- `$escapeString` (string, nepovinný) – reťazec na označenie predložiek, ktoré sa nahradiť nemajú. Predvolená hodnota: `'#####'`

**Vracia:**
- (Prepositioner) – nakonfigurovanú inštanciu Prepositionera

**Vyhadzuje:**
- `LanguageNotExistsException` – ak trieda jazyka neexistuje alebo neimplementuje `LanguageInterface`

**Príklad:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$prepositioner = Factory::build('czech', '***'); // With custom escape string
```

**Spracovanie chýb:**

```php
<?php

use Tomaj\Prepositioner\LanguageNotExistsException;

try {
    $prepositioner = Factory::build('unknown');
} catch (LanguageNotExistsException $e) {
    // Language not found
    echo "Error: " . $e->getMessage();
}
```

## Rozhranie jazyka

Rozhranie, ktoré musia implementovať všetky triedy jazykov.

### LanguageInterface

```php
interface LanguageInterface
{
    /**
     * @return array<int, string>
     */
    public function prepositions(): array;
}
```

**Metódy:**
- `prepositions()` – vráti pole predložiek daného jazyka

**Príklad implementácie:**

```php
<?php

declare(strict_types=1);

namespace Tomaj\Prepositioner\Language;

class SlovakLanguage implements LanguageInterface
{
    public function prepositions(): array
    {
        return ['a', 'i', 'k', 'o', 'v', 'u', 'z', 's', /* ... */];
    }
}
```

## Vstavané triedy jazykov

### SlovakLanguage

```php
class SlovakLanguage implements LanguageInterface
```

Implementácia slovenčiny s 27 predložkami a spojkami.

**Použitie:**

```php
<?php

use Tomaj\Prepositioner\Language\SlovakLanguage;
use Tomaj\Prepositioner\Prepositioner;

$language = new SlovakLanguage();
$prepositioner = new Prepositioner($language->prepositions());

// Or use Factory:
$prepositioner = Factory::build('slovak');
```

**Predložky:**
- 1 písmeno: a, i, k, o, v, u, z, s
- 2 písmená: do, od, zo, ku, na, po, so, za, vo, či
- 3 písmená: cez, pre, nad, pod, pri
- 4 písmená: spod, pred, skrz

### CzechLanguage

```php
class CzechLanguage implements LanguageInterface
```

Implementácia češtiny s 19 predložkami a spojkami.

**Použitie:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
```

**Predložky:**
- 1 písmeno: a, i, k, o, v, u, z, s
- 2 písmená: do, na, od, po, ze, ku
- 3 a viac písmen: nad, pod, př, před, při

### RomanianLanguage

```php
class RomanianLanguage implements LanguageInterface
```

Implementácia rumunčiny so 16 predložkami.

**Použitie:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
```

**Predložky:**
- 2 písmená: cu, de, în, la, pe
- 3 písmená: cât, pro
- 4 písmená: fără, până, prin, spre
- 5 písmen: între, peste
- 6 písmen: dintre, pentru

### EmptyLanguage

```php
class EmptyLanguage implements LanguageInterface
```

Implementácia jazyka bez predložiek. Hodí sa do testov alebo vtedy, keď potrebujete inštanciu Prepositionera, ktorá text nemení.

**Použitie:**

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$result = $prepositioner->formatText('Any text'); // Returns unchanged
```

## Výnimky

### PrepositionerException

```php
class PrepositionerException extends \Exception
```

Vyhodí ju metóda `formatText()`, keď zlyhá spracovanie regulárnym výrazom.

**Časté príčiny:**
- neplatné UTF-8 vo vstupnom texte,
- prekročený limit backtrackingu,
- prekročený limit rekurzie,
- prekročený limit zásobníka PCRE JIT.

**Príklad:**

```php
<?php

use Tomaj\Prepositioner\PrepositionerException;

try {
    $result = $prepositioner->formatText($text);
} catch (PrepositionerException $e) {
    // Error message includes specific PCRE error details
    error_log('Regex error: ' . $e->getMessage());
}
```

### LanguageNotExistsException

```php
class LanguageNotExistsException extends \Exception
```

Vyhodí ju `Factory::build()`, keď:
- trieda jazyka neexistuje,
- trieda neimplementuje `LanguageInterface`.

**Príklad:**

```php
<?php

use Tomaj\Prepositioner\LanguageNotExistsException;

try {
    $prepositioner = Factory::build('nonexistent');
} catch (LanguageNotExistsException $e) {
    echo "Language not found: " . $e->getMessage();
}
```

## Definície typov

### Pole predložiek

```php
array<int, string>
```

Indexované pole reťazcov s predložkami. Používa sa v:
- `Prepositioner::__construct()`
- `LanguageInterface::prepositions()`

**Príklad:**

```php
['a', 'v', 'o', 'z', 's']
```

## Konštanty

Knižnica nedefinuje žiadne verejné konštanty. Predvolený escapovací reťazec `'#####'` môžete zmeniť v konštruktore.

## Statické metódy

### Factory::build()

Jediná verejná statická metóda v knižnici. Pozrite si [triedu Factory](#trieda-factory) vyššie.

## Štruktúra menných priestorov

```
Tomaj\Prepositioner\
├── Prepositioner                    (main class)
├── Factory                          (factory class)
├── PrepositionerException           (exception)
├── LanguageNotExistsException       (exception)
└── Language\
    ├── LanguageInterface            (interface)
    ├── SlovakLanguage               (implementation)
    ├── CzechLanguage                (implementation)
    ├── RomanianLanguage             (implementation)
    └── EmptyLanguage                (implementation)
```

## Kompatibilita s verziami PHP

- vyžaduje **PHP 8.4+** (od verzie 5.0.0),
- používa striktné typy: `declare(strict_types=1);`,
- všetky metódy majú typové deklarácie.

## Odporúčania

::: tip Vytváranie inštancií
**Odporúčané:** pre vstavané jazyky použite `Factory`

```php
$prepositioner = Factory::build('slovak');
```

**Pokročilé:** priame vytvorenie inštancie s vlastnými predložkami

```php
$prepositioner = new Prepositioner(['custom', 'prepositions']);
```
:::

### Spracovanie chýb

::: warning Vždy použite try-catch
Pri spracovaní vstupu od používateľov vždy obaľte `formatText()` blokom try-catch:

```php
try {
    $result = $prepositioner->formatText($userInput);
} catch (PrepositionerException $e) {
    $result = $userInput; // Fallback to original
}
```
:::

### Opakované použitie inštancií

Vytvorte jednu inštanciu a použite ju pre viac textov:

```php
$prepositioner = Factory::build('slovak');

foreach ($articles as $article) {
    $article->content = $prepositioner->formatText($article->content);
}
```

### Bezpečnosť pri súbežnom behu

::: tip Bez stavu po vytvorení
Inštancie Prepositionera po vytvorení nemajú žiadny meniaci sa stav, takže ich môžete bezpečne používať vo viacerých vláknach či procesoch.
:::
