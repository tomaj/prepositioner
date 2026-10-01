import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "Prepositioner",
  description: "PHP library for replacing prepositions with non-breaking spaces in Slovak, Czech, and Romanian",
  base: '/prepositioner/',
  
  head: [
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/prepositioner/favicon.svg' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:title', content: 'Prepositioner - PHP Typography Library' }],
    ['meta', { property: 'og:description', content: 'PHP library for replacing prepositions with non-breaking spaces in Slovak, Czech, and Romanian' }],
    ['meta', { property: 'og:url', content: 'https://tomaj.github.io/prepositioner/' }],
    ['meta', { property: 'og:image', content: 'https://tomaj.github.io/prepositioner/logo.svg' }],
    ['meta', { name: 'twitter:card', content: 'summary' }],
    ['meta', { name: 'twitter:title', content: 'Prepositioner - PHP Typography Library' }],
    ['meta', { name: 'twitter:description', content: 'PHP library for replacing prepositions with non-breaking spaces in Slovak, Czech, and Romanian' }],
  ],

  lastUpdated: true,

  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    logo: '/logo.svg',
    
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/getting-started' },
      { text: 'API', link: '/api/reference' },
      { text: 'v4.0.0', link: 'https://github.com/tomaj/prepositioner/releases' }
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
          { text: 'Contributing Guide', link: '/contributing' }
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
      provider: 'local'
    },

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2014-2026 Tomas Majer'
    }
  }
})
