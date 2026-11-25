# Ako to funguje

Táto stránka vysvetľuje, ako Prepositioner vnútorne funguje a ako spracúva text.

::: info Technický prehľad
Prepositioner pomocou regulárnych výrazov s podporou Unicode (modifikátor `/u`) nájde medzery za predložkami a nahradí ich nezalomiteľnými medzerami (`&nbsp;`).
:::

## Prehľad

Prepositioner hľadá predložky v texte regulárnymi výrazmi s podporou Unicode a medzeru za nimi nahradí nezalomiteľnou medzerou (`&nbsp;`). Knižnica zvláda:

- **Čistý text** – jednoduché spracovanie textu
- **HTML** – zachová štruktúru HTML aj atribúty
- **UTF-8/Unicode** – plná podpora znakov s diakritikou
- **Veľké a malé písmená** – predložky nájde bez ohľadu na veľkosť písmen
- **Hraničné prípady** – viac predložiek za sebou, úvodzovky a podobne

## Algoritmus

### Krok 1: Zostavenie vzoru

Pri vytvorení inštancie Prepositioner zostaví z predložiek regulárny výraz:

```php
<?php

$prepositioner = new Prepositioner(['a', 'v', 'o']);
```

Každá predložka sa najprv escapuje funkciou `preg_quote()`, aby sa špeciálne znaky brali doslovne:

```php
$quotedPrepositions = array_map(fn($p) => preg_quote($p, '/'), $prepositionsArray);
$prepositions = implode('|', $quotedPrepositions); // "a|v|o"
```

### Krok 2: Regulárny výraz

Hlavný vzor, ktorý hľadá predložky:

```regex
/(\s|^|>|;|quotationMarks)(prepositions)\s+(?=[^>]*(<|$))/iu
```

Po častiach:

- `(\s|^|>|;|quotationMarks)` – zodpovedá jednému z:
  - `\s` – biely znak
  - `^` – začiatok reťazca
  - `>` – koniec HTML značky
  - `;` – bodkočiarka (koniec HTML entity)
  - rôzne úvodzovky (`"`, `'`, `„`, `‚`, `"`, `'`, `«`, `‹`)

- `(prepositions)` – ktorákoľvek z predložiek

- `\s+` – jedna alebo viac medzier za predložkou

- `(?=[^>]*(<|$))` – výhľadová podmienka (lookahead), ktorá zaručí, že nie sme vnútri HTML značky

- príznaky `/iu`:
  - `i` – nezáleží na veľkosti písmen
  - `u` – podpora Unicode/UTF-8

### Krok 3: Nahradenie

Nájdený text sa nahradí reťazcom:

```php
"$1$2&nbsp;"
```

Kde:
- `$1` – znak pred predložkou
- `$2` – samotná predložka
- `&nbsp;` – nezalomiteľná medzera

### Krok 4: Dvojité použitie

Vzor sa použije **dvakrát**, aby sa ošetrili predložky idúce za sebou:

```php
$text = $this->safePregReplace($pattern, $replacement, $text);
$text = $this->safePregReplace($pattern, $replacement, $text); // Applied again
```

Vďaka tomu sa napríklad „a o text“ správne zmení na „a&nbsp;o&nbsp;text“.

### Krok 5: Escapovacie značky

Nakoniec sa odstránia escapovacie značky:

```php
$escapePattern = "/{$quotedEscapeString}({$prepositions}){$quotedEscapeString}/iu";
$text = $this->safePregReplace($escapePattern, "$1", $text);
```

## Spracovanie HTML

### Prečo je HTML špeciálne

Pri spracovaní HTML treba zaručiť, že:

1. predložky vnútri HTML značiek sa **nenahrádzajú**,
2. predložky v HTML atribútoch sa **nenahrádzajú**,
3. nahrádzajú sa iba predložky v samotnom texte.

### Riešenie výhľadovou podmienkou

Výhľadová podmienka `(?=[^>]*(<|$))` zaručí, že vzor zachytí iba predložky:
- za ktorými nasledujú znaky iné ako `>` (nie sme vnútri značky),
- až po `<` (začiatok ďalšej značky) alebo koniec reťazca.

Príklad:

```html
<a href="/path/v/url">Text v článku</a>
```

- Za `v` v `/path/v/url` nasleduje `/url">`, kde je `>`, takže sa nenahradí.
- Za `v` v „Text v článku“ nasleduje „ článku“, kde až po zatváraciu značku nie je `>`, takže sa nahradí.

## Podpora Unicode

### Modifikátor `/u`

Všetky regulárne výrazy používajú modifikátor `/u`, ktorý zapína podporu Unicode. Knižnica tak správne spracuje:

- **predložky s diakritikou**: `č`, `ř`, `ž`, `ă`, `ț` a ďalšie,
- **veľké písmená mimo ASCII**: `Č`, `Ř`, `În` a ďalšie,
- **porovnávanie bez ohľadu na veľkosť písmen**: funguje správne aj pre znaky Unicode.

Príklad:

```php
$prepositioner = Factory::build('slovak');
$text = "Či ide v Bratislave?";
// "či" with diacritic is correctly matched as a preposition
// Output: "Či&nbsp;ide v&nbsp;Bratislave?"
```

### Pred verziou 4.0

::: warning Staršie správanie
Verzie pred 4.0 modifikátor `/u` nepoužívali. Preto:
- predložky s diakritikou mimo ASCII nefungovali správne,
- porovnávanie bez ohľadu na veľkosť písmen fungovalo iba pre ASCII.

Verzia 4.0 tieto problémy odstránila plnou podporou Unicode.
:::

## Spracovanie chýb

### Bezpečné volanie regulárnych výrazov

Metóda `safePregReplace()` obaľuje každé volanie `preg_replace()` a kontroluje chyby:

```php
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
```

Možné chyby:
- `PREG_BACKTRACK_LIMIT_ERROR` – vzor je príliš zložitý
- `PREG_RECURSION_LIMIT_ERROR` – prekročený limit rekurzie
- `PREG_BAD_UTF8_ERROR` – neplatné UTF-8 na vstupe
- `PREG_JIT_STACKLIMIT_ERROR` – vyčerpaný zásobník JIT

Vo verzii 3.x a starších sa chyby potichu ignorovali a vrátil sa pôvodný text. Verzia 4.0 namiesto toho vyhadzuje výnimky, takže chyby môžete riadne ošetriť.

::: tip Odporúčanie
Volania `formatText()` pri spracovaní vstupu od používateľov alebo iného nedôveryhodného obsahu vždy obaľte blokom try-catch.
:::

## Escapovanie

### Ako escapovanie funguje

Konkrétnu predložku môžete z nahrádzania vynechať tak, že ju obalíte escapovacími značkami:

```php
$prepositioner = new Prepositioner(['a'], '#####');
$text = "Replace a here but not #####a##### here.";
$result = $prepositioner->formatText($text);
// Output: "Replace a&nbsp;here but not a here."
```

Postup:

1. **Počas nahrádzania**: escapované predložky chránia ich značky, takže ich hlavný vzor nezachytí.
2. **Po nahradení**: escapovacie značky sa odstránia a za predložkou zostane obyčajná medzera.

Hodí sa to pri skratkách a ďalších prípadoch, keď slovo vyzerá ako predložka, ale ako predložka sa správať nemá.

## Úvodzovky

Knižnica počíta s úvodzovkami a správne spracuje predložku na začiatku citovaného textu:

```php
$prepositioner = Factory::build('slovak');
$text = 'Povedal: "V meste je pekne."';
// Output: 'Povedal: "V&nbsp;meste je pekne."'
```

Podporované úvodzovky:
- `"` – rovné dvojité úvodzovky
- `'` – rovný apostrof
- `„` – nemecké/české/slovenské otváracie úvodzovky (U+201E)
- `‚` – jednoduché dolné úvodzovky (U+201A)
- `"` – ľavé dvojité úvodzovky (U+201C)
- `'` – ľavé jednoduché úvodzovky (U+2018)
- `«` – ľavé dvojité lomené úvodzovky
- `‹` – ľavé jednoduché lomené úvodzovky

## Výkon

### Zostavenie regulárneho výrazu

Vzor sa zostaví raz pri vytvorení inštancie Prepositionera, nie pri každom volaní `formatText()`.

### Viac prechodov

Vzor sa na text použije dvakrát, aby sa ošetrili predložky idúce za sebou. Pre väčšinu textov je to dostatočne rýchle. Pri veľmi veľkých textoch (100 000 a viac znakov) zvážte:
- spracovanie po častiach,
- ukladanie výsledkov do cache,
- escapovacie značky na preskočenie častí, ktoré spracovať netreba.

### Zložitosť HTML

Výhľadová podmienka pri spracovaní HTML niečo stojí. Ak potrebujete maximálny výkon a spracúvate iba čistý text, zvážte prepositioner s jednoduchšími vzormi.
