# Verzie dokumentácie

Táto stránka vysvetľuje, ako funguje verzovanie dokumentácie a ako dokumentáciu archivovať pri vydaní novej hlavnej verzie.

## Ako to funguje

Dokumentácia je verzovaná, aby mohlo byť naraz dostupných viac hlavných verzií:

- **Aktuálna verzia** (`4.x`) – je vo vetve `master` a nasadzuje sa do koreňa: `https://tomaj.github.io/prepositioner/`
- **Archivované verzie** – sú vo vetvách `docs-archive/<major>.x` a nasadzujú sa do podadresárov: `https://tomaj.github.io/prepositioner/<major>.x/`

Slovenský preklad je súčasťou každej verzie a nasadzuje sa pod `/sk/` (napríklad `https://tomaj.github.io/prepositioner/sk/`).

::: tip Výber verzie
Medzi verziami sa prepína v rozbaľovacej ponuke verzií v navigačnej lište.
:::

## Štruktúra verzií

```
Repository branches:
├── master                    → Current docs (4.x)
└── docs-archive/3.x         → Archived docs for version 3.x
└── docs-archive/2.x         → Archived docs for version 2.x

Deployed documentation:
├── /prepositioner/          → Latest (4.x)
├── /prepositioner/3.x/      → Archived 3.x docs
└── /prepositioner/2.x/      → Archived 2.x docs
```

## Archivácia dokumentácie (pre správcov)

Pri vydaní novej hlavnej verzie (napríklad prechod zo 4.x na 5.0.0) archivujte starú dokumentáciu takto:

### Krok 1: Archívna vetva

Ešte pred vydaním novej hlavnej verzie vytvorte z `master` archívnu vetvu:

```bash
# Ensure you're on master with the latest 4.x docs
git checkout master
git pull origin master

# Create archive branch for 4.x
git checkout -b docs-archive/4.x
git push origin docs-archive/4.x
```

### Krok 2: Úprava master pre novú verziu

Prepnite sa späť na master a aktualizujte dokumentáciu pre novú hlavnú verziu:

```bash
git checkout master

# Update version in docs/.vitepress/config.mts
# Change: const currentVersion = '4.x'
# To:     const currentVersion = '5.x'

# Add archived version to versions array:
const versions = [
  { text: 'Latest (5.x)', link: '/' },
  { text: '4.x', link: 'https://tomaj.github.io/prepositioner/4.x/' }
]

# Commit the changes
git add docs/.vitepress/config.mts
git commit -m "docs: update to version 5.x"
git push origin master
```

Archivovanú verziu doplňte aj do poľa `versionsSk`, ktoré používa slovenská navigácia.

### Krok 3: Kontrola nasadenia

Po pushnutí workflow v GitHub Actions automaticky:

1. zostaví aktuálnu dokumentáciu (5.x) z `master` → nasadí ju do `/prepositioner/`,
2. zostaví archivovanú dokumentáciu (4.x) z `docs-archive/4.x` → nasadí ju do `/prepositioner/4.x/`,
3. spojí obe do jedného nasadenia.

Nasadenie skontrolujte na adresách:
- Najnovšia (5.x): https://tomaj.github.io/prepositioner/
- Archivovaná (4.x): https://tomaj.github.io/prepositioner/4.x/

::: warning Dôležité
Archívne vetvy nemažte. Workflow ich potrebuje na zostavenie všetkých verzií.
:::

## Ako funguje workflow

Workflow na nasadenie dokumentácie (`.github/workflows/docs.yml`) automaticky:

- sa spustí pri pushi do `master` alebo do ktorejkoľvek vetvy `docs-archive/*`,
- pri pull requeste overí, že každá anglická stránka má slovenský preklad (`docs/scripts/check-locales.py`), a dokumentáciu zostaví,
- zostaví aktuálnu verziu z `master` s `base: '/prepositioner/'`,
- nájde a zostaví všetky vetvy `docs-archive/<major>.x` s `base: '/prepositioner/<major>.x/'`,
- spojí všetky zostavenia do jedného artefaktu pre Pages,
- všetko nasadí na GitHub Pages.

::: tip Zatiaľ žiadne archívy?
Ak neexistuje žiadna vetva `docs-archive/*`, workflow funguje normálne a nasadí iba aktuálnu verziu.
:::

## Úpravy archivovanej dokumentácie

Chybu v dokumentácii archivovanej verzie opravíte takto:

```bash
# Checkout the archive branch
git checkout docs-archive/4.x

# Make your changes
# ... edit documentation files ...

# Commit and push
git add .
git commit -m "docs(4.x): fix typo in examples"
git push origin docs-archive/4.x
```

Workflow potom automaticky znova zostaví a nasadí všetky verzie.

## Konfigurácia verzií

Ponuka verzií sa nastavuje v `docs/.vitepress/config.mts`:

```typescript
// Version configuration
const currentVersion = '4.x'
const versions = [
  { text: `Latest (${currentVersion})`, link: '/' },
  // Add archived versions here:
  // { text: '3.x', link: 'https://tomaj.github.io/prepositioner/3.x/' }
]
```

## Odporúčania

::: tip Kedy archivovať
- Dokumentáciu archivujte pri vydaní **novej hlavnej verzie** (napríklad 4.0.0 → 5.0.0).
- Pri menších vydaniach a opravách (napríklad 4.1.0, 4.0.1) ju nearchivujte.
- Dostupné nechajte aspoň 2 – 3 hlavné verzie.
:::

::: warning Údržba
- Archivované verzie by sa mali meniť len výnimočne.
- Do archivovanej dokumentácie dávajte iba kritické opravy alebo zmeny súvisiace s bezpečnosťou.
- Väčšie vylepšenia dokumentácie robte v aktuálnej verzii.
:::

## Riešenie problémov

### Archívna vetva sa nezostavuje

Ak sa archivovaná verzia nezobrazuje:

1. skontrolujte, či názov vetvy zodpovedá vzoru `docs-archive/<major>.x`,
2. overte, či vetva obsahuje platný adresár `docs/`,
3. pozrite si v logoch GitHub Actions chyby zostavenia,
4. uistite sa, že v archívnej vetve existujú `docs/package.json` a `docs/package-lock.json`.

### Ponuka verzií sa nezobrazuje

Ak sa rozbaľovacia ponuka verzií nezobrazuje:

1. overte, či je v `docs/.vitepress/config.mts` vyplnené pole `versions`,
2. skontrolujte, či je správne nastavené `currentVersion`,
3. zostavte dokumentáciu lokálne: `npm run docs:build`.

### Odkazy medzi verziami

::: warning
Odkazy medzi rôznymi verziami dokumentácie vždy píšte ako absolútne URL, nie relatívne cesty, aby fungovali vo všetkých nasadených verziách.
:::
