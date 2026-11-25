# Podporované jazyky

Prepositioner má vstavanú podporu troch jazykov, každý s vlastným zoznamom predložiek a spojok.

::: info Prehľad jazykov
| Jazyk | Kód | Predložky | Použitie |
|-------|-----|-----------|----------|
| Slovenčina | `slovak` | 27 | slovenčina |
| Čeština | `czech` | 19 | čeština |
| Rumunčina | `romanian` | 16 | română |
| Prázdny | `empty` | 0 | Testy / bez úprav |
:::

## Slovenčina

Podporu slovenčiny zapnete takto:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
```

### Slovenské predložky

Slovenská implementácia obsahuje tieto predložky a spojky:

| Dĺžka | Predložky |
|-------|-----------|
| 1 písmeno | a, i, k, o, v, u, z, s |
| 2 písmená | do, od, zo, ku, na, po, so, za, vo, či |
| 3 písmená | cez, pre, nad, pod, pri |
| 4 písmená | spod, pred, skrz |

**Spolu: 27 predložiek**

### Príklad

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$text = "Išiel som v sobotu do obchodu s priateľom.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Išiel som v&nbsp;sobotu do&nbsp;obchodu s&nbsp;priateľom."
```

## Čeština

Podporu češtiny zapnete takto:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
```

### České predložky

Česká implementácia obsahuje tieto predložky a spojky:

| Dĺžka | Predložky |
|-------|-----------|
| 1 písmeno | a, i, k, o, v, u, z, s |
| 2 písmená | do, na, od, po, ze, ku |
| 3 a viac písmen | nad, pod, př, před, při |

**Spolu: 19 predložiek**

### Príklad

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
$text = "Byl jsem v Praze a v Brně před týdnem.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Byl jsem v&nbsp;Praze a&nbsp;v&nbsp;Brně před&nbsp;týdnem."
```

## Rumunčina

Podporu rumunčiny zapnete takto:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
```

### Rumunské predložky

Rumunská implementácia obsahuje tieto predložky:

| Dĺžka | Predložky |
|-------|-----------|
| 2 písmená | cu, de, în, la, pe |
| 3 písmená | cât, pro |
| 4 písmená | fără, până, prin, spre |
| 5 písmen | între, peste |
| 6 písmen | dintre, pentru |

**Spolu: 16 predložiek**

### Príklad

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('romanian');
$text = "Merg la București cu prietenii pentru vacanță.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Merg la&nbsp;București cu&nbsp;prietenii pentru&nbsp;vacanță."
```

## Prázdny jazyk

Špeciálny „prázdny“ jazyk použijete, keď potrebujete inštanciu Prepositionera bez akýchkoľvek predložiek:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$text = "Any text with any words.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Any text with any words." (no changes)
```

Hodí sa do testov alebo vtedy, keď potrebujete inštanciu Prepositionera, ale text sa nemá nijako upravovať.

## Rozpoznanie jazyka

::: warning Jazyk sa nerozpoznáva automaticky
Prepositioner jazyk vstupného textu **nerozpoznáva**. Jazyk musíte pri vytváraní inštancie zvoliť sami.
:::

Ak aplikácia spracúva viac jazykov, vytvorte pre každý samostatnú inštanciu:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioners = [
    'sk' => Factory::build('slovak'),
    'cs' => Factory::build('czech'),
    'ro' => Factory::build('romanian'),
];

// Use based on user's language preference
$userLang = 'sk';
$result = $prepositioners[$userLang]->formatText($text);
```

## Pridanie ďalšieho jazyka

Chcete pridať podporu ďalšieho jazyka? Podrobný postup nájdete v návode [Pridanie jazyka](/sk/guide/adding-language).
