# Ako prispieť

Ďakujeme, že zvažujete príspevok do Prepositionera!

## Rýchle odkazy

- [Kódex správania](https://github.com/tomaj/prepositioner/blob/master/CODE_OF_CONDUCT.md)
- [Pravidlá pre príspevky](https://github.com/tomaj/prepositioner/blob/master/CONTRIBUTING.md)
- [Bezpečnostná politika](https://github.com/tomaj/prepositioner/blob/master/SECURITY.md)

## Ako môžete prispieť

### Hlásenie chýb

Našli ste chybu? Najprv si prosím pozrite [existujúce issues](https://github.com/tomaj/prepositioner/issues), aby ste nezakladali duplicitné.

V hlásení chyby uveďte:
- jasný a výstižný názov,
- kroky, ktorými chybu vyvoláte,
- očakávané správanie,
- skutočné správanie,
- vaše prostredie (verzia PHP, operačný systém a pod.),
- ukážky kódu, ak sú relevantné.

[Nahlásiť chybu →](https://github.com/tomaj/prepositioner/issues/new?template=bug_report.md)

### Návrhy nových funkcií

Máte nápad na novú funkciu? Radi si ho vypočujeme!

V návrhu uveďte:
- jasný a výstižný názov,
- podrobný opis navrhovanej funkcie,
- príklady, ako by sa používala,
- prečo by bola užitočná.

[Navrhnúť funkciu →](https://github.com/tomaj/prepositioner/issues/new?template=feature_request.md)

### Podpora ďalšieho jazyka

Chcete pridať podporu nového jazyka? Pozrite si návod [Pridanie jazyka](/sk/guide/adding-language).

[Požiadať o podporu jazyka →](https://github.com/tomaj/prepositioner/issues/new?template=language_support.md)

### Príspevky do kódu

1. **Forknite repozitár** a vytvorte si vetvu z `master`
2. **Urobte zmeny** podľa pravidiel písania kódu
3. **Napíšte alebo upravte testy**
4. **Overte, že všetky testy prechádzajú**
5. **Spustite kontroly kvality kódu**
6. **Aktualizujte dokumentáciu**, ak treba (anglickú aj slovenskú pod `docs/sk/`)
7. **Pošlite pull request**

## Vývojové prostredie

### Predpoklady

- PHP 8.4 alebo novšie
- Composer

### Inštalácia

```bash
git clone https://github.com/tomaj/prepositioner.git
cd prepositioner
composer install
```

### Spustenie testov

```bash
# Run all tests
composer test

# Run tests with coverage (needs Xdebug)
composer coverage
```

### Štýl kódu

```bash
# Check code style (PHP-CS-Fixer, dry run)
composer phpcs

# Fix code style automatically
composer cs-fix
```

### Statická analýza

```bash
composer phpstan
```

### Rector

```bash
# Show the changes Rector would make (must be none)
composer rector

# Apply them
composer rector-fix
```

### Mutačné testovanie

```bash
composer infection
```

### Všetky kontroly

```bash
# Run all checks (code style, static analysis, Rector, tests)
composer check

# Mutation testing runs separately
composer infection
```

## Pravidlá písania kódu

- dodržiavajte štýl kódu **PER** (kontroluje ho PHP-CS-Fixer),
- používajte striktné typy: `declare(strict_types=1);`,
- uvádzajte typy všetkých parametrov a návratových hodnôt,
- triedy a metódy dokumentujte blokmi PHPDoc,
- metódy nech sú malé a robia jednu vec,
- testy pomenúvajte zrozumiteľne.

## Pravidlá testovania

- každú novú funkciu pokryte testami,
- pokrytie kódu udržte alebo zlepšite (cieľ: ≥ 90 %),
- testovacie metódy pomenúvajte zrozumiteľne,
- pokryte hraničné prípady a chybové stavy,
- na testovacích triedach používajte atribúty `#[CoversClass(...)]`.

## Pravidlá pre pull requesty

- **Jedna funkcia na jeden PR** – PR nech sú zamerané na jednu vec
- **Jasné commit správy** – píšte v prítomnom čase a rozkazovacom spôsobe (po anglicky)
- **Odkazy na issues** – v opise PR uveďte súvisiace issues
- **Testy a dokumentácia** – udržujte ich v súlade s kódom
- **Reagujte** – pripomienky z review riešte priebežne

## Kódex správania

Projekt sa riadi [kódexom správania Contributor Covenant](https://github.com/tomaj/prepositioner/blob/master/CODE_OF_CONDUCT.md). Účasťou na projekte sa zaväzujete ho dodržiavať.

## Bezpečnostné problémy

Ak objavíte bezpečnostnú zraniteľnosť, napíšte prosím na tomasmajer@gmail.com a nezakladajte verejné issue. Podrobnosti nájdete v [SECURITY.md](https://github.com/tomaj/prepositioner/blob/master/SECURITY.md).

## Licencia

Príspevkom súhlasíte s tým, že bude licencovaný pod licenciou MIT.

## Otázky?

- Otvorte [diskusiu](https://github.com/tomaj/prepositioner/discussions)
- Opýtajte sa priamo v pull requeste
- Pozrite si existujúce issues a PR

## Verzie dokumentácie

Pre správcov: postup archivácie dokumentácie pri vydaní novej hlavnej verzie nájdete na stránke [Verzie dokumentácie](/sk/guide/versioning).

Ďakujeme za váš príspevok! 🎉
