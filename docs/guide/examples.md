# Examples

This page contains practical examples demonstrating various use cases of the Prepositioner library.

::: tip Try it yourself
All examples on this page use the actual API and can be copied directly into your project.
:::

## Basic Examples

### Simple Text Processing

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$text = "Išiel som do obchodu v meste.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Išiel som do&nbsp;obchodu v&nbsp;meste."
```

### Case Insensitivity

The library handles uppercase and lowercase prepositions correctly:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('czech');
$text = "V Praze a v Brně. A také v Ostravě.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "V&nbsp;Praze a&nbsp;v&nbsp;Brně. A&nbsp;také v&nbsp;Ostravě."
```

### Multiple Consecutive Prepositions

The library properly handles multiple prepositions in a row:

```php
<?php

use Tomaj\Prepositioner\Prepositioner;

$prepositioner = new Prepositioner(['a', 'o']);
$text = "Text a o more text a o even more.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Text a&nbsp;o&nbsp;more text a&nbsp;o&nbsp;even more."
```

## HTML Content

### Processing HTML Tags

Prepositioner preserves HTML structure while processing text content:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<p>Text v elemente.</p><div>Ďalší text v ďalšom elemente.</div>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<p>Text v&nbsp;elemente.</p><div>Ďalší text v&nbsp;ďalšom elemente.</div>"
```

### HTML Attributes Are Preserved

Prepositions inside HTML attributes are not modified:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak');
$html = '<a href="/path/v/url">Link v texte</a>';
$result = $prepositioner->formatText($html);

echo $result;
// Output: "<a href="/path/v/url">Link v&nbsp;texte</a>"
```

### Complex HTML with Multiple Elements

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

## Advanced Usage

### Custom Prepositions List

You can define your own list of prepositions:

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

### Custom Escape String

Define a custom escape marker for prepositions that should not be replaced:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('slovak', '***');
$text = "Slovo v texte ale nie ***v*** tomto prípade.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Slovo v&nbsp;texte ale nie v tomto prípade."
```

### Empty Language (No Prepositions)

Use the empty language when you need to process text without any prepositions:

```php
<?php

use Tomaj\Prepositioner\Factory;

$prepositioner = Factory::build('empty');
$text = "Any text with words.";
$result = $prepositioner->formatText($text);

echo $result;
// Output: "Any text with words." (unchanged)
```

## Framework Integration

### Nette / Latte

Register Prepositioner as a Latte filter:

```php
<?php

$latte = new Latte\Engine();
$prepositioner = \Tomaj\Prepositioner\Factory::build('slovak');

$latte->addFilter('prepositions', fn($text) => $prepositioner->formatText($text));
```

Then use in templates:

```latte
<p>{$text|prepositions|noescape}</p>
```

### Twig

Register as a Twig filter:

```php
<?php

$twig = new \Twig\Environment($loader);
$prepositioner = \Tomaj\Prepositioner\Factory::build('czech');

$twig->addFilter(new \Twig\TwigFilter('prepositions', 
    fn($text) => $prepositioner->formatText($text),
    ['is_safe' => ['html']]
));
```

Then use in templates:

```twig
<p>{{ text|prepositions }}</p>
```

### Laravel

Register in a service provider:

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

Then use via dependency injection:

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

Register as a service in `services.yaml`:

```yaml
services:
    Tomaj\Prepositioner\Prepositioner:
        factory: ['Tomaj\Prepositioner\Factory', 'build']
        arguments: ['%kernel.default_locale%']
```

Then use via autowiring:

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

## Error Handling

::: warning Exception Handling
Since version 4.0, `formatText()` throws `PrepositionerException` on regex errors. Always use try-catch when processing untrusted input.
:::

Handle regex errors with try-catch:

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

## Real-World Examples

### Blog Post Processing

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

### Email Template Processing

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

### Batch Processing

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
