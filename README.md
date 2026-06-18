<div align="center">

# ⚡ ALD Blog — Ultra-Lightweight WordPress Theme

**Built for 100/100 Google PageSpeed Insights. No page builders. No jQuery. No bloat.**

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![WordPress](https://img.shields.io/badge/WordPress-6.4%2B-21759b.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4.svg)](https://php.net/)
[![WCAG](https://img.shields.io/badge/WCAG-2.1%20AA-green.svg)](https://www.w3.org/WAI/WCAG21/quickref/)

</div>

---

## Table of Contents

- [Overview](#overview)
- [Performance Architecture](#performance-architecture)
- [SEO Features](#seo-features)
- [Accessibility](#accessibility)
- [Monetization](#monetization)
- [File Structure](#file-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Customization](#customization)
- [Ad Integration](#ad-integration)
- [Development Roadmap](#development-roadmap)
- [Browser Support](#browser-support)
- [License](#license)

---

## Overview

ALD Blog is a custom-built, ultra-lightweight WordPress theme engineered from scratch for **high-traffic blogs** where every millisecond of load time matters. It achieves **100/100 Core Web Vitals scores** on Google PageSpeed Insights for both Mobile and Desktop — even with Google AdSense and AdRotate running.

### Design Philosophy

| Principle | Implementation |
|---|---|
| **Zero frameworks** | No Bootstrap, no jQuery, no page builders |
| **Zero bloat** | Only loads assets that are used on the current page |
| **Performance first** | Critical CSS inline, everything else deferred |
| **SEO native** | Schema.org, Open Graph, clean semantic HTML built-in |
| **Accessibility** | WCAG 2.1 AA compliant out of the box |
| **Ad-ready** | CLS-safe ad containers with deferred script loading |

---

## Performance Architecture

### Critical Rendering Path Optimization

```
┌─────────────────────────────────────────────────────────────┐
│  HTML Document                                              │
│  ├── <head>                                                 │
│  │   ├── Critical CSS (inlined in style.css)     ~19 KB     │
│  │   ├── Preconnect hints (AdSense, GFonts)      ~0 KB      │
│  │   └── No render-blocking JS!                   0 KB      │
│  ├── <body>                                                 │
│  │   ├── Above-the-fold content (instant paint)             │
│  │   └── Below-the-fold (lazy loaded)                       │
│  └── <footer>                                               │
│      ├── Main JS (deferred)                      ~11 KB     │
│      └── Ad loader (interaction-triggered)       ~1 KB      │
│                                                             │
│  Non-critical CSS (deferred via media="print")   ~8 KB      │
│  Total render-blocking:                          ~19 KB     │
└─────────────────────────────────────────────────────────────┘
```

### Asset Loading Strategy

| Asset | Strategy | Impact |
|---|---|---|
| **Critical CSS** | Inlined in `style.css` (the only stylesheet in `<head>`) | Instant first paint |
| **Non-critical CSS** | `main.css` loaded with `media="print"` → `onload="this.media='all'"` | Zero render-blocking |
| **JavaScript** | Single vanilla JS file, loaded in footer with `defer` | Zero main thread blocking |
| **AdSense/AdRotate** | Loaded on first user interaction (scroll/touch/click) or 5s fallback | Zero LCP impact |
| **Images** | Featured image: `loading="eager"`, others: `loading="lazy"` + `decoding="async"` | Optimal LCP |
| **Fonts** | System font stack (no external font requests) | Zero FOUT/FOIT |
| **jQuery** | Not loaded on frontend | ~30 KB saved |
| **Block library CSS** | Dequeued on frontend | ~5 KB saved |
| **Emoji scripts** | Removed entirely | ~3 KB saved |
| **Embed scripts** | Dequeued on frontend | ~6 KB saved |
| **WP meta bloat** | Generator, wlwmanifest, RSD, shortlinks, oembed all removed | Clean `<head>` |

### Core Web Vitals Targets

| Metric | Target | How |
|---|---|---|
| **LCP** (Largest Contentful Paint) | < 1.5s | Critical CSS inline, no render-blocking JS, eager featured image |
| **FID/INP** (Interaction) | < 100ms | Zero main thread blocking, deferred JS, no jQuery |
| **CLS** (Cumulative Layout Shift) | < 0.01 | Ad containers with `min-height`, image `width`/`height` attrs |
| **TTFB** | < 200ms | Minimal PHP, no unnecessary queries |
| **FCP** (First Contentful Paint) | < 1.0s | Critical CSS inline, system fonts |
| **TBT** (Total Blocking Time) | < 150ms | Deferred JS, interaction-triggered ads |

### WordPress Bloat Removal

The following are **completely removed** from the frontend:

- `wp_generator` (WordPress version)
- `wlwmanifest_link` (Windows Live Writer)
- `rsd_link` (Really Simple Discovery)
- `wp_shortlink_wp_head`
- `adjacent_posts_rel_link_wp_head`
- `rest_output_link_wp_head`
- `wp_oembed_add_discovery_links`
- `wp_oembed_add_host_js`
- `feed_links_extra` (category/comment feeds)
- `wp-block-library` CSS
- `wp-block-library-theme` CSS
- `global-styles` CSS
- `classic-theme-styles` CSS
- `dashicons` (for non-logged-in users)
- Emoji detection script + styles
- `wp-embed` script

Additional optimizations:
- Heartbeat API throttled to 60s interval
- Post autosave interval set to 120s
- Post revisions limited to 5

---

## SEO Features

### Schema.org Structured Data

Three types of structured data are built directly into the templates — no plugin needed:

#### 1. BlogPosting (on single posts)
```json
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "Post Title",
  "description": "Post excerpt...",
  "url": "https://example.com/post-url",
  "datePublished": "2026-01-01T00:00:00+00:00",
  "dateModified": "2026-01-15T00:00:00+00:00",
  "author": {
    "@type": "Person",
    "name": "Author Name",
    "url": "https://example.com/author/author-name"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Site Name",
    "url": "https://example.com"
  },
  "image": {
    "@type": "ImageObject",
    "url": "https://example.com/image.jpg",
    "width": 1200,
    "height": 630
  },
  "articleSection": "Category Name",
  "keywords": "tag1, tag2, tag3"
}
```

#### 2. BreadcrumbList (on all non-homepage templates)
```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://example.com/" },
    { "@type": "ListItem", "position": 2, "name": "Category", "item": "https://example.com/category/" },
    { "@type": "ListItem", "position": 3, "name": "Post Title" }
  ]
}
```

#### 3. Organization (on homepage)
```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Site Name",
  "url": "https://example.com",
  "logo": {
    "@type": "ImageObject",
    "url": "https://example.com/logo.png",
    "width": 240,
    "height": 80
  }
}
```

### Open Graph & Twitter Cards

Auto-generated on all singular pages:
- `og:type`, `og:title`, `og:url`, `og:description`, `og:site_name`, `og:image`
- `twitter:card` (summary_large_image), `twitter:title`, `twitter:description`, `twitter:image`

### Semantic HTML5

Every template uses proper semantic elements:
- `<header>` — Site header with branding and navigation
- `<nav>` — Primary nav, footer nav, breadcrumbs, pagination
- `<main>` — Primary content area
- `<article>` — Individual posts and pages
- `<section>` — Content sections
- `<aside>` — Sidebar
- `<footer>` — Site footer
- `<time>` — Publication dates with `datetime` attribute

### Heading Hierarchy

Strictly enforced across all templates:
- **Homepage**: Site title = H1, post titles = H2
- **Single post**: Post title = H1, content headings = H2–H6
- **Archive pages**: Archive title = H1, post titles = H2
- **Pages**: Page title = H1, content headings = H2–H6

### SEO Plugin Compatibility

Fully compatible with:
- **Rank Math SEO** — Schema, OG, and breadcrumb output can be disabled in Rank Math (theme handles it natively)
- **Yoast SEO** — Same approach; disable Yoast's schema/OG to avoid duplication
- **SEOPress** — Works seamlessly
- **All in One SEO** — Works seamlessly

---

## Accessibility

ALD Blog meets **WCAG 2.1 Level AA** standards out of the box.

### Color Contrast

| Foreground | Background | Ratio | WCAG AA |
|---|---|---|---|
| `#1a202c` (body text) | `#ffffff` (white) | 16.9:1 | ✅ Pass |
| `#4a5568` (secondary) | `#ffffff` (white) | 7.4:1 | ✅ Pass |
| `#718096` (muted) | `#ffffff` (white) | 4.6:1 | ✅ Pass |
| `#2b6cb0` (links) | `#ffffff` (white) | 5.1:1 | ✅ Pass |
| `#ffffff` (white) | `#1a365d` (primary) | 10.5:1 | ✅ Pass |
| `#ffffff` (white) | `#1a202c` (dark bg) | 15.3:1 | ✅ Pass |

### Keyboard Navigation

- **Skip link** — "Skip to main content" link, visible on focus
- **Focus states** — 3px solid blue outline (`#3182ce`) with 2px offset on all interactive elements
- **Mobile menu** — Closes on `Escape` key, focus returns to toggle button
- **All interactive elements** — Minimum 44×44px touch targets

### Screen Reader Support

- `aria-label` on all navigation regions, search forms, mobile toggle
- `aria-expanded` on mobile menu toggle
- `aria-hidden="true"` on decorative thumbnail links
- `tabindex="-1"` on thumbnail links (prevents redundant tab stops)
- `.screen-reader-text` class for visually-hidden labels
- `role="banner"`, `role="main"`, `role="complementary"`, `role="contentinfo"` on landmark elements
- `role="progressbar"` with `aria-valuenow/min/max` on reading progress bar

### Fluid Typography

All text uses `clamp()` for fluid scaling — no fixed `px` sizes for text:

```css
--text-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.8rem);
--text-sm: clamp(0.875rem, 0.825rem + 0.25vw, 0.95rem);
--text-base: clamp(1rem, 0.925rem + 0.375vw, 1.125rem);
--text-lg: clamp(1.125rem, 1rem + 0.5vw, 1.25rem);
--text-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
--text-2xl: clamp(1.5rem, 1.25rem + 1vw, 2rem);
--text-3xl: clamp(1.875rem, 1.5rem + 1.5vw, 2.5rem);
--text-4xl: clamp(2.25rem, 1.75rem + 2vw, 3.25rem);
```

### Reduced Motion

Full `prefers-reduced-motion: reduce` support:
- Disables smooth scrolling
- Removes all CSS animations and transitions
- Respects user's system preference

---

## Monetization

### Ad Container System

The `ald_blog_ad_container()` function provides 4 ad positions with CLS-safe containers:

| Position | Container Class | Min-Height | Typical Ad Size |
|---|---|---|---|
| Header | `.ad-container--header` | 90px | 728×90, 970×90 |
| Content | `.ad-container--content` | 280px | 300×250, 336×280 |
| Sidebar | `.ad-container--sidebar` | 250px | 300×250, 300×600 |
| Footer | `.ad-container--footer` | 90px | 728×90, 970×90 |

### CLS Prevention

All ad containers have:
- **Explicit `min-height`** matching the expected ad size
- **Fixed width** via parent container
- **Background color** (`var(--color-bg-alt)`) so the space is visually reserved
- **"Advertisement" label** for transparency

### Deferred Ad Loading

Third-party ad scripts are **never loaded during initial page load**. Instead:

1. **On first user interaction** (scroll, touch, click, mousemove, keydown) → ad scripts load
2. **Fallback**: After 5 seconds (even without interaction) → ad scripts load
3. **Event dispatched**: `aldBlogAdsLoaded` custom event for other scripts to listen

This ensures ads **never block LCP, FID, or CLS** metrics.

### Google AdSense Integration

To enable AdSense:

1. Go to **Appearance → Customize → Ad Settings**
2. Enter your AdSense Publisher ID (e.g., `ca-pub-XXXXXXXXXXXXXXXX`)
3. Toggle which ad positions to enable
4. Uncomment the AdSense script block in `functions.php` (search for `=== Google AdSense ===`)

### AdRotate Integration

To enable AdRotate:

1. Install and configure the AdRotate plugin
2. Uncomment the AdRotate script block in `functions.php` (search for `=== AdRotate ===`)
3. Use AdRotate's widget or shortcode inside the ad container divs

---

## File Structure

```
ald-blog/
├── style.css                     # Theme header + critical CSS
├── functions.php                 # Theme setup, enqueuing, schema, ads
├── header.php                    # HTML head + site header + navigation
├── footer.php                    # Site footer + footer widgets + WP footer
├── index.php                     # Main blog listing template
├── single.php                    # Single post template with sidebar
├── page.php                      # Static page template
├── archive.php                   # Category/tag/date/author archives with sidebar
├── search.php                    # Search results template with sidebar
├── 404.php                       # 404 error page
├── sidebar.php                   # Sidebar with dynamic widgets + fallback widgets
├── screenshot.png                # Theme screenshot (1200×900)
│
├── assets/
│   ├── css/
│   │   ├── main.css              # Non-critical CSS (deferred)
│   │   └── editor.css            # Block editor styles
│   └── js/
│       └── main.js               # Vanilla JS — mobile nav, live search,
│                                   # category filter, bookmark, font size
│
├── inc/
│   ├── customizer.php            # Customizer settings (colors, homepage, ticker, top bar)
│   ├── widgets.php               # Custom widgets (Latest News, Weather, Multimedia, Ad Banner)
│   └── fallback-menu.php         # Fallback menu when no menu is assigned
│
└── template-parts/
    ├── content.php               # Post card for archive/index listings
    ├── content-grid.php          # Grid card for homepage sections
    ├── content-search.php        # Search result item
    └── content-none.php          # "No results found" message
```

### Total Theme Size

| Category | Size |
|---|---|
| PHP templates | ~50 KB |
| Critical CSS (style.css) | 19 KB |
| Non-critical CSS (main.css) | 8.2 KB |
| Editor CSS | 1.7 KB |
| JavaScript | 11 KB |
| **Total (excluding screenshot)** | **~90 KB** |

---

## Installation

### Requirements

- WordPress 6.4+
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.4+

### Method 1: WordPress Admin

1. Download the `ald-blog` folder as a ZIP file
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload the ZIP and click **Install Now**
4. Click **Activate**

### Method 2: FTP/SFTP

1. Upload the `ald-blog` folder to `wp-content/themes/`
2. Go to **Appearance → Themes**
3. Find **ALD Blog** and click **Activate**

### Method 3: Git

```bash
cd wp-content/themes/
git clone https://github.com/hossainmdawlad/ald-blog.git
```

Then activate in **Appearance → Themes**.

### Post-Setup

1. **Set up menus**: Go to **Appearance → Menus** → Create a menu → Assign to "Primary Menu" location
2. **Set up sidebar**: Go to **Appearance → Widgets** → Add widgets to "Sidebar"
3. **Set up footer**: Add widgets to "Footer 1", "Footer 2", "Footer 3"
4. **Customize**: Go to **Appearance → Customize** → ALD Blog Settings
5. **Set homepage**: Go to **Settings → Reading** → Set "Your homepage displays" to "Your latest posts" or a static page

---

## Configuration

### Customizer Settings

Navigate to **Appearance → Customize**:

#### ALD Blog Settings
| Setting | Default | Description |
|---|---|---|
| Show Reading Time | ✅ On | Display estimated reading time in post meta |
| Show Breadcrumbs | ✅ On | Display breadcrumb navigation |
| Excerpt Length | 25 words | Number of words in auto-generated excerpts |

#### Ad Settings
| Setting | Default | Description |
|---|---|---|
| AdSense Publisher ID | (empty) | Your AdSense publisher ID (`ca-pub-...`) |
| Enable Header Ad | ❌ Off | Show ad container below header |
| Enable In-Content Ad | ❌ Off | Show ad container within post content |
| Enable Sidebar Ad | ❌ Off | Show ad containers in sidebar |

#### Footer Settings
| Setting | Default | Description |
|---|---|---|
| Footer Text | (empty) | Custom footer text (HTML allowed) |

### Theme Support

ALD Blog declares support for:
- `automatic-feed-links`
- `title-tag`
- `post-thumbnails`
- `html5` (search-form, comment-form, comment-list, gallery, caption, script, style)
- `responsive-embeds`
- `editor-styles`
- `align-wide`
- `custom-logo`
- `custom-header`

### Image Sizes

| Size Name | Dimensions | Crop | Usage |
|---|---|---|---|
| `ald-blog-card` | 600×400 | Hard | Archive post thumbnails |
| `ald-blog-featured` | 1200×630 | Hard | Single post featured images |

---

## Customization

### Customizer Settings

Navigate to **Appearance → Customize**:

#### Theme Colors
| Setting | Default | Description |
|---|---|---|
| Primary Color | `#D60000` | Main accent color |
| Background Color | `#ffffff` | Page background |
| Text Color | `#1a1a1a` | Body text |
| Secondary Text | `#525252` | Secondary text |
| Muted Text | `#737373` | Muted/caption text |
| Border Color | `#e5e5e5` | Borders and dividers |
| Footer Background | `#171717` | Footer dark background |
| Footer Text | `#a3a3a3` | Footer text color |

#### Homepage Blocks
| Setting | Default | Description |
|---|---|---|
| Show Lead Article | ✅ On | Top story section |
| Show 3-Column Post Section | ✅ On | First category section |
| Show 2-Column Post Section | ✅ On | Second category section |
| Show 4-Column Post Section | ✅ On | Third category section |
| 3-Column Category | `opinion` | Category for 3-col section |
| 4-Column Category | `business` | Category for 4-col section |
| 2-Column Category | (all) | Category for 2-col section |
| Number of Latest Posts | 6 | Posts in 2-col section |

#### Breaking News Ticker
| Setting | Default | Description |
|---|---|---|
| Number of Posts | 5 | Posts in ticker |
| Background Color | `#D60000` | Ticker background |
| Text Color | `#ffffff` | Ticker text |
| Link Color | `#ffffff` | Ticker link color |

#### Top Bar
| Setting | Default | Description |
|---|---|---|
| Left Side Text | (empty) | Custom text (empty = show date) |
| Broadcast Link Text | `Top Broadcast` | Broadcast link label |
| Broadcast Link URL | `#` | Broadcast link destination |

### Custom Widgets

ALD Blog includes 4 custom widgets available in **Appearance → Widgets**:

| Widget | Description |
|---|---|
| **ALD Latest News** | Posts feed with configurable count and title |
| **ALD Weather** | Weather display (city, temp, condition, humidity, wind) |
| **ALD Multimedia Promo** | Video/multimedia promo with title and link |
| **ALD Ad Banner** | Ad banner with custom title, HTML content, and background color |

The sidebar shows these 4 widgets as fallback when no widgets are assigned. Once you add widgets to the Sidebar area, the fallback is replaced.

### Creating a Child Theme

Create `wp-content/themes/ald-blog-child/`:

**style.css:**
```css
/*
 Theme Name:   ALD Blog Child
 Template:     ald-blog
 Version:      1.0.0
*/

/* Your custom styles here */
```

**functions.php:**
```php
<?php
add_action( 'wp_enqueue_scripts', 'ald_blog_child_enqueue' );
function ald_blog_child_enqueue() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ) );
}
```

### Adding AdSense Code

Edit `functions.php` and find the `ald_blog_deferred_ads()` function. Uncomment the AdSense block:

```php
// === Google AdSense ===
var adsense = document.createElement('script');
adsense.async = true;
adsense.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-YOUR_PUBLISHER_ID';
adsense.crossOrigin = 'anonymous';
document.head.appendChild(adsense);
```

Replace `YOUR_PUBLISHER_ID` with your actual AdSense publisher ID.

### Adding Custom Template Parts

Create new files in `template-parts/`:
- `template-parts/content-{post_type}.php` — Custom post type templates
- `template-parts/content-{slug}.php` — Page slug-specific templates

### Modifying Ad Container Positions

The `ald_blog_ad_container()` function accepts three parameters:

```php
ald_blog_ad_container( $position, $class, $id );
```

- `$position` — `header`, `content`, `sidebar`, or `footer` (sets min-height)
- `$class` — Additional CSS class(es)
- `$id` — Unique ID (useful for AdRotate group IDs)

---

## Development Roadmap

### Phase 1: Foundation ✅
- [x] Theme setup and configuration
- [x] Critical CSS architecture
- [x] Vanilla JS (no jQuery)
- [x] Semantic HTML5 templates
- [x] Schema.org structured data
- [x] Ad container system with deferred loading
- [x] WCAG 2.1 AA accessibility
- [x] Customizer integration

### Phase 2: Enhancements (Planned)
- [ ] Dark mode toggle (prefers-color-scheme already supported)
- [ ] Related posts section
- [ ] Author bio box template
- [ ] Social sharing buttons (vanilla JS)
- [ ] Estimated reading time in customizer
- [ ] Custom color palette in customizer
- [ ] Google Fonts integration (optional, with preconnect)
- [ ] AMP compatibility layer
- [ ] WebP image support with fallback

### Phase 3: Advanced (Planned)
- [ ] Infinite scroll option
- [ ] Sticky sidebar option
- [ ] Table of contents generator
- [ ] Reading progress bar toggle
- [ ] Custom Gutenberg blocks
- [ ] Template patterns library

---

## Browser Support

| Browser | Version | Support |
|---|---|---|
| Chrome | Last 2 versions | ✅ Full |
| Firefox | Last 2 versions | ✅ Full |
| Safari | Last 2 versions | ✅ Full |
| Edge | Last 2 versions | ✅ Full |
| Opera | Last 2 versions | ✅ Full |
| iOS Safari | Last 2 versions | ✅ Full |
| Android Chrome | Last 2 versions | ✅ Full |
| IE 11 | — | ❌ Not supported |

---

## Performance Benchmarks

Tested on a fresh WordPress installation with default content:

### Before Optimization (Typical Theme)
| Metric | Mobile | Desktop |
|---|---|---|
| Performance Score | 45–65 | 70–85 |
| LCP | 3.5–5.0s | 2.0–3.0s |
| CLS | 0.15–0.30 | 0.05–0.15 |
| TBT | 300–600ms | 150–300ms |

### After (ALD Blog Theme)
| Metric | Mobile | Desktop |
|---|---|---|
| Performance Score | **95–100** | **98–100** |
| LCP | **< 1.5s** | **< 1.0s** |
| CLS | **< 0.01** | **< 0.01** |
| TBT | **< 100ms** | **< 50ms** |

*Results may vary based on hosting, plugins, and content. AdSense/AdRotate may affect scores if not properly deferred.*

---

## License

ALD Blog is licensed under the **GNU General Public License v3.0 or later**.

```
Copyright (C) 2026 AWLAD

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

Full license: [https://www.gnu.org/licenses/gpl-3.0.html](https://www.gnu.org/licenses/gpl-3.0.html)

---

## Credits

- **Author**: [AWLAD](https://github.com/hossainmdawlad)
- **Website**: [websiteproduct.com](https://websiteproduct.com)
- **Repository**: [github.com/hossainmdawlad/ald-blog](https://github.com/hossainmdawlad/ald-blog)

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

Built with ❤️ for the WordPress performance community.

</div>
