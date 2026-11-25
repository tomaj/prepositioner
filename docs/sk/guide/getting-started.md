# Začíname

## Čo je Prepositioner?

Prepositioner je PHP knižnica, ktorá automaticky nahrádza medzeru za predložkou nezalomiteľnou medzerou (`&nbsp;`). Zlepšuje tým typografiu: jednopísmenové predložky a spojky sa neocitnú na konci riadku, čo sa v slovenskej, českej aj rumunskej sadzbe považuje za chybu.

::: tip Prečo nezalomiteľné medzery?
Podľa slovenských, českých a rumunských typografických pravidiel by jednopísmenové predložky a spojky (v, k, s, z, o, u, a, i) nemali zostať na konci riadku. Nezalomiteľná medzera ich udrží na rovnakom riadku ako nasledujúce slovo.
:::

V tejto dokumentácii slovom „predložky“ označujeme celý zoznam slov, za ktoré knižnica vkladá nezalomiteľnú medzeru. Okrem predložiek doň patria aj krátke spojky ako *a*, *i* či *či*.

## Inštalácia

Knižnicu nainštalujete cez Composer:

```bash
composer require tomaj/prepositioner
```

::: info Požiadavky
PHP 8.2 alebo novšie
:::

## Rýchly štart

### Základné použitie

Najjednoduchšie je vytvoriť inštanciu so zoznamom predložiek:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a', 'o', 'v', 'z']);
$text = "V Bratislave a v Prahe.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "V&nbsp;Bratislave a&nbsp;v&nbsp;Prahe."
```

### Továreň so vstavanými jazykmi

Odporúčaný spôsob je použiť triedu `Factory` so vstavanou podporou jazykov:

```php
<?php

use Tomaj\Prepositioner\Factory;

// For Slovak
$prepositioner = Factory::build('slovak');
$result = $prepositioner->formatText('Išiel som do obchodu v meste.');
// Output: "Išiel som do&nbsp;obchodu v&nbsp;meste."

// For Czech
$prepositioner = Factory::build('czech');
$result = $prepositioner->formatText('Byl jsem v Praze a v Brně.');
// Output: "Byl jsem v&nbsp;Praze a&nbsp;v&nbsp;Brně."

// For Romanian
$prepositioner = Factory::build('romanian');
$result = $prepositioner->formatText('Merg la București și la Cluj.');
// Output: "Merg la&nbsp;București și la&nbsp;Cluj."
```

### Podpora HTML

Prepositioner si bezpečne poradí aj s HTML:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<p>V Bratislave a v Prahe.</p>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<p>V&nbsp;Bratislave a&nbsp;v&nbsp;Prahe.</p>"
```

::: warning Dôležité
HTML značky a atribúty zostanú zachované a nezmenené. Spracúva sa iba textový obsah.
:::

### Vynechanie predložiek

Ak niektorú predložku nechcete nahradiť, obaľte ju escapovacími značkami:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a'], '#####');
$text = "Word a text but not #####a##### this one.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Word a&nbsp;text but not a this one."
```

## Kam ďalej?

- [Ďalšie príklady](/sk/guide/examples) ukazujú Prepositioner v praxi
- [Podporované jazyky](/sk/guide/languages) a ich zoznamy predložiek
- [Ako to funguje](/sk/guide/how-it-works) pod kapotou
- [Integrácia do frameworku](/sk/guide/examples#integracia-do-frameworkov)
