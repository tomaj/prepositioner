# Príklady

Na tejto stránke sú praktické príklady rôznych spôsobov použitia knižnice Prepositioner.

::: tip Vyskúšajte si to
Všetky príklady používajú skutočné API a môžete ich priamo skopírovať do svojho projektu.
:::

## Základné príklady

### Spracovanie jednoduchého textu

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$text = "Išiel som do obchodu v meste.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Išiel som do&nbsp;obchodu v&nbsp;meste."
```

### Veľké a malé písmená

Knižnica správne spracuje predložky s veľkým aj malým začiatočným písmenom:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
$text = "V Praze a v Brně. A také v Ostravě.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "V&nbsp;Praze a&nbsp;v&nbsp;Brně. A&nbsp;také v&nbsp;Ostravě."
```

### Viac predložiek za sebou

Knižnica správne ošetrí aj niekoľko predložiek idúcich za sebou:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a', 'o']);
$text = "Text a o more text a o even more.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Text a&nbsp;o&nbsp;more text a&nbsp;o&nbsp;even more."
```

## HTML obsah

### Spracovanie HTML značiek

Prepositioner zachová štruktúru HTML a upraví iba textový obsah:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<p>Text v elemente.</p><div>Ďalší text v ďalšom elemente.</div>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<p>Text v&nbsp;elemente.</p><div>Ďalší text v&nbsp;ďalšom elemente.</div>"
```

### HTML atribúty zostanú nedotknuté

Predložky v HTML atribútoch sa nemenia:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<a href="/path/v/url">Link v texte</a>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<a href="/path/v/url">Link v&nbsp;texte</a>"
```

### Zložitejšie HTML s viacerými elementmi

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '
<article>
    <h1>Nadpis s predložkou v titulku</h1>
    <p>Prvý odstavec s textom. A ďalší text v ďalšej vete.</p>
    <p>Druhý odstavec s <strong>tučným textom v elemente</strong>.</p>
</article>
';
$result = $prepositioner->formatText($html);
```

## Pokročilé použitie

### Vlastný zoznam predložiek

Zoznam predložiek si môžete zadefinovať sami:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$customPrepositions = ['the', 'a', 'an', 'in', 'on'];
$prepositioner = new Prepositioner($customPrepositions);

$text = "The book is on a table in the room.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "The&nbsp;book is on&nbsp;a&nbsp;table in&nbsp;the&nbsp;room."
```

### Vlastný escapovací reťazec

Pre predložky, ktoré sa nemajú nahradiť, si môžete určiť vlastnú escapovaciu značku:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak', '***');
$text = "Slovo v texte ale nie ***v*** tomto prípade.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Slovo v&nbsp;texte ale nie v tomto prípade."
```

### Prázdny jazyk (bez predložiek)

Prázdny jazyk použijete, keď sa text má spracovať bez akýchkoľvek predložiek:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$text = "Any text with words.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Any text with words." (unchanged)
```

## Integrácia do frameworkov

### Nette / Latte

Zaregistrujte Prepositioner ako filter v Latte:

```php
<?php

$latte = new Latte\Engine();
$prepositioner = \Tomaj\Prepositioner\Factory::build('slovak');

$latte->addFilter('prepositions', fn($text) => $prepositioner->formatText($text));
```

V šablónach ho potom použijete takto:

```latte
<p>{$text|prepositions|noescape}</p>
```

### Twig

Zaregistrujte ho ako filter v Twigu:

```php
<?php

$twig = new \Twig\Environment($loader);
$prepositioner = \Tomaj\Prepositioner\Factory::build('czech');

$twig->addFilter(new \Twig\TwigFilter('prepositions', 
    fn($text) => $prepositioner->formatText($text),
    ['is_safe' => ['html']]
));
```

V šablónach ho potom použijete takto:

```twig
<p>{{ text|prepositions }}</p>
```

### Laravel

Zaregistrujte ho v service provideri:

```php
<?php

// app/Providers/AppServiceProvider.php
public function register()
{
    $this->app->singleton(\Tomaj\Prepositioner\Prepositioner::class, function () {
        return \Tomaj\Prepositioner\Factory::build(config('app.locale'));
    });
}
```

A potom ho získate cez dependency injection:

```php
<?php

class ArticleController extends Controller
{
    public function show(Article $article, \Tomaj\Prepositioner\Prepositioner $prepositioner)
    {
        $formatted = $prepositioner->formatText($article->content);
        return view('article.show', compact('formatted'));
    }
}
```

### Symfony

Zaregistrujte ho ako službu v `services.yaml`:

```yaml
services:
    Tomaj\Prepositioner\Prepositioner:
        factory: ['Tomaj\Prepositioner\Factory', 'build']
        arguments: ['%kernel.default_locale%']
```

A potom ho získate cez autowiring:

```php
<?php

class ArticleController extends AbstractController
{
    #[Route('/article/{id}')]
    public function show(Article $article, Prepositioner $prepositioner): Response
    {
        $formatted = $prepositioner->formatText($article->getContent());
        return $this->render('article/show.html.twig', [
            'content' => $formatted,
        ]);
    }
}
```

## Spracovanie chýb

::: warning Ošetrenie výnimiek
Od verzie 4.0 metóda `formatText()` pri chybe regulárneho výrazu vyhodí `PrepositionerException`. Pri spracovaní nedôveryhodného vstupu preto vždy použite try-catch.
:::

Chyby regulárnych výrazov ošetríte blokom try-catch:

```php
<?php

use Tomaj\Prepositioner\Factory;
use Tomaj\Prepositioner\PrepositionerException;

$prepositioner = Factory::build('slovak');

try {
    $result = $prepositioner->formatText($text);
} catch (PrepositionerException $e) {
    // Handle error - malformed UTF-8, regex limits exceeded, etc.
    error_log('Prepositioner error: ' . $e->getMessage());
    $result = $text; // Use original text as fallback
}
```

## Príklady z praxe

### Spracovanie článku na blogu

```php
<?php

use Tomaj\Prepositioner\Factory;

class BlogPost
{
    private Prepositioner $prepositioner;
    
    public function __construct()
    {
        $this->prepositioner = Factory::build('slovak');
    }
    
    public function getFormattedContent(string $rawContent): string
    {
        return $this->prepositioner->formatText($rawContent);
    }
}

$post = new BlogPost();
$content = '<h1>Článok o Slovensku</h1><p>Slovensko je krajina v strednej Európe.</p>';
echo $post->getFormattedContent($content);
// Output: "<h1>Článok o&nbsp;Slovensku</h1><p>Slovensko je krajina v&nbsp;strednej Európe.</p>"
```

### Spracovanie e-mailovej šablóny

```php
<?php

use Tomaj\Prepositioner\Factory;

class EmailFormatter
{
    public function formatEmailContent(string $locale, string $content): string
    {
        $prepositioner = Factory::build($locale);
        return $prepositioner->formatText($content);
    }
}

$formatter = new EmailFormatter();
$emailHtml = '<p>Dobrý deň, váš balík je v distribučnom centre.</p>';
$formatted = $formatter->formatEmailContent('slovak', $emailHtml);
// Output: "<p>Dobrý deň, váš balík je v&nbsp;distribučnom centre.</p>"
```

### Hromadné spracovanie

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
$articles = [
    'Článek o Praze',
    'Text s předložkami v textu',
    'Další článek na téma',
];

$formattedArticles = array_map(
    fn($article) => $prepositioner->formatText($article),
    $articles
);

print_r($formattedArticles);
// Output:
// [
//     "Článek o&nbsp;Praze",
//     "Text s&nbsp;předložkami v&nbsp;textu",
//     "Další článek na&nbsp;téma"
// ]
```
