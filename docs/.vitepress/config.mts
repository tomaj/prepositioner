import { defineConfig, type HeadConfig } from 'vitepress'

// Version configuration
const currentVersion = '4.x'
const versions = [
  { text: `Latest (${currentVersion})`, link: '/' }
  // Archived versions will be added here when available
  // { text: '3.x', link: 'https://tomaj.github.io/prepositioner/3.x/' }
]
const versionsSk = [
  { text: `Najnovšia (${currentVersion})`, link: '/sk/' }
]

const siteUrl = 'https://tomaj.github.io/prepositioner/'

const seo = {
  en: {
    title: 'Prepositioner - PHP Typography Library',
    description: 'PHP library for replacing prepositions with non-breaking spaces in Slovak, Czech, and Romanian',
    ogLocale: 'en_US',
  },
  sk: {
    title: 'Prepositioner - PHP knižnica pre typografiu',
    description: 'PHP knižnica, ktorá za predložky a spojky v slovenčine, češtine a rumunčine vkladá nezalomiteľné medzery',
    ogLocale: 'sk_SK',
  },
}

// English pages live at the site root, Slovak pages mirror them under sk/ with the same paths.
function pageUrl(relativePath: string): string {
  const path = relativePath.replace(/(^|\/)index\.md$/, '$1').replace(/\.md$/, '.html')
  return siteUrl + path
}

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "Prepositioner",
  description: seo.en.description,
  base: '/prepositioner/',

  head: [
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/prepositioner/favicon.svg' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:image', content: 'https://tomaj.github.io/prepositioner/logo.svg' }],
    ['meta', { name: 'twitter:card', content: 'summary' }],
  ],

  // Per-locale Open Graph / Twitter tags and hreflang links between the English and Slovak twin of each page.
  transformHead({ pageData }) {
    const relativePath = pageData.relativePath
    const isSk = relativePath.startsWith('sk/')
    const meta = isSk ? seo.sk : seo.en
    const enPath = isSk ? relativePath.slice(3) : relativePath
    const head: HeadConfig[] = [
      ['meta', { property: 'og:title', content: meta.title }],
      ['meta', { property: 'og:description', content: meta.description }],
      ['meta', { property: 'og:url', content: pageUrl(relativePath) }],
      ['meta', { property: 'og:locale', content: meta.ogLocale }],
      ['meta', { property: 'og:locale:alternate', content: isSk ? seo.en.ogLocale : seo.sk.ogLocale }],
      ['meta', { name: 'twitter:title', content: meta.title }],
      ['meta', { name: 'twitter:description', content: meta.description }],
      ['link', { rel: 'alternate', hreflang: 'en', href: pageUrl(enPath) }],
      ['link', { rel: 'alternate', hreflang: 'sk', href: pageUrl(`sk/${enPath}`) }],
      ['link', { rel: 'alternate', hreflang: 'x-default', href: pageUrl(enPath) }],
    ]
    return head
  },

  lastUpdated: true,

  // English is the default locale at the site root; Slovak mirrors it under /sk/ (scripts/check-locales.py keeps them in sync).
  locales: {
    root: {
      label: 'English',
      lang: 'en-US',
      description: seo.en.description,
    },
    sk: {
      label: 'Slovenčina',
      lang: 'sk-SK',
      link: '/sk/',
      title: 'Prepositioner',
      description: seo.sk.description,
      themeConfig: {
        nav: [
          { text: 'Úvod', link: '/sk/' },
          { text: 'Príručka', link: '/sk/guide/getting-started' },
          { text: 'API', link: '/sk/api/reference' },
          {
            text: currentVersion,
            items: versionsSk
          },
          { text: 'Vydania', link: 'https://github.com/tomaj/prepositioner/releases' }
        ],

        sidebar: [
          {
            text: 'Úvod',
            items: [
              { text: 'Začíname', link: '/sk/guide/getting-started' },
              { text: 'Príklady', link: '/sk/guide/examples' }
            ]
          },
          {
            text: 'Príručka',
            items: [
              { text: 'Podporované jazyky', link: '/sk/guide/languages' },
              { text: 'Ako to funguje', link: '/sk/guide/how-it-works' },
              { text: 'Pridanie jazyka', link: '/sk/guide/adding-language' }
            ]
          },
          {
            text: 'Referencia',
            items: [
              { text: 'Referencia API', link: '/sk/api/reference' },
              { text: 'Zoznam zmien', link: '/sk/changelog' }
            ]
          },
          {
            text: 'Prispievanie',
            items: [
              { text: 'Ako prispieť', link: '/sk/contributing' },
              { text: 'Verzie dokumentácie', link: '/sk/guide/versioning' }
            ]
          }
        ],

        outline: {
          label: 'Na tejto stránke',
        },
        docFooter: {
          prev: 'Predchádzajúca stránka',
          next: 'Nasledujúca stránka',
        },
        editLink: {
          pattern: 'https://github.com/tomaj/prepositioner/edit/master/docs/:path',
          text: 'Upraviť túto stránku na GitHube',
        },
        lastUpdated: {
          text: 'Naposledy upravené',
        },
        darkModeSwitchLabel: 'Vzhľad',
        lightModeSwitchTitle: 'Prepnúť na svetlý režim',
        darkModeSwitchTitle: 'Prepnúť na tmavý režim',
        sidebarMenuLabel: 'Ponuka',
        returnToTopLabel: 'Návrat na začiatok',
        langMenuLabel: 'Zmeniť jazyk',
        skipToContentLabel: 'Preskočiť na obsah',
        footer: {
          message: 'Vydané pod licenciou MIT.',
          copyright: 'Copyright © 2014-2026 Tomas Majer',
        },
        notFound: {
          code: '404',
          title: 'STRÁNKA SA NENAŠLA',
          quote: 'Ak nezmeníte smer a budete hľadať ďalej, môžete doraziť práve tam, kam mierite.',
          linkLabel: 'prejsť na úvod',
          linkText: 'Späť na úvod',
        },
      },
    },
  },

  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    logo: '/logo.svg',

    nav: [
      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/getting-started' },
      { text: 'API', link: '/api/reference' },
      {
        text: currentVersion,
        items: versions
      },
      { text: 'Releases', link: 'https://github.com/tomaj/prepositioner/releases' }
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'Getting Started', link: '/guide/getting-started' },
          { text: 'Examples', link: '/guide/examples' }
        ]
      },
      {
        text: 'Guide',
        items: [
          { text: 'Supported Languages', link: '/guide/languages' },
          { text: 'How It Works', link: '/guide/how-it-works' },
          { text: 'Adding a Language', link: '/guide/adding-language' }
        ]
      },
      {
        text: 'Reference',
        items: [
          { text: 'API Reference', link: '/api/reference' },
          { text: 'Changelog', link: '/changelog' }
        ]
      },
      {
        text: 'Contributing',
        items: [
          { text: 'Contributing Guide', link: '/contributing' },
          { text: 'Versioning Docs', link: '/guide/versioning' }
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/tomaj/prepositioner' }
    ],

    editLink: {
      pattern: 'https://github.com/tomaj/prepositioner/edit/master/docs/:path',
      text: 'Edit this page on GitHub'
    },

    search: {
      provider: 'local',
      options: {
        locales: {
          sk: {
            translations: {
              button: {
                buttonText: 'Hľadať',
                buttonAriaLabel: 'Hľadať',
              },
              modal: {
                displayDetails: 'Zobraziť podrobný zoznam',
                resetButtonTitle: 'Vymazať hľadanie',
                backButtonTitle: 'Zavrieť hľadanie',
                noResultsText: 'Žiadne výsledky pre',
                footer: {
                  selectText: 'vybrať',
                  selectKeyAriaLabel: 'enter',
                  navigateText: 'prejsť',
                  navigateUpKeyAriaLabel: 'šípka hore',
                  navigateDownKeyAriaLabel: 'šípka dole',
                  closeText: 'zavrieť',
                  closeKeyAriaLabel: 'escape',
                },
              },
            },
          },
        },
      },
    },

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2014-2026 Tomas Majer'
    }
  }
})
