<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php
    // Detectar idioma via query string (?te_lang=en)
    // Detectar idioma pela URL ou query var
    $lang = 'pt';
    if (function_exists('get_query_var') && get_query_var('te_lang')) {
        $lang = get_query_var('te_lang');
    } elseif (!empty($_GET['te_lang']) && in_array($_GET['te_lang'], ['en', 'es', 'pt'])) {
        $lang = $_GET['te_lang'];
    } elseif (strpos($_SERVER['REQUEST_URI'], '/en') !== false) {
        $lang = 'en';
    } elseif (strpos($_SERVER['REQUEST_URI'], '/es') !== false) {
        $lang = 'es';
    }

    if (is_front_page() || is_home()) {
        if ($lang === 'en') echo 'Brazilian Natural Stone Export & Sourcing | Trade Expansion';
        elseif ($lang === 'es') echo 'Piedras Naturales para Exportación | Trade Expansion';
        else echo 'Rochas Naturais para Exportação | Trade Expansion';
    } else {
        wp_title('|', true, 'right');
        bloginfo('name');
    }
    ?>
  </title>
  
  <?php if (is_front_page() || is_home()): ?>
  <meta name="description" content="<?php 
    if ($lang === 'en') echo 'Trade Expansion is a boutique natural stone sourcing company in Brazil. We curate, inspect and export premium Brazilian quartzites — including Imperial Blue, available exclusively through us — to importers worldwide.';
    elseif ($lang === 'es') echo 'Catálogo de piedras naturales para exportación. Suministro internacional confiable de basalto, rocas ornamentales y silicatos.';
    else echo 'Catálogo de rochas naturais para exportação. Fornecimento de basalto, mármores e granitos com padrão internacional de qualidade.';
  ?>">
  <link rel="canonical" href="https://tradeexpansion.com.br<?php echo $lang === 'pt' ? '/' : '/' . $lang . '/'; ?>">
  <link rel="alternate" hreflang="en" href="https://tradeexpansion.com.br/en/" />
  <link rel="alternate" hreflang="pt-br" href="https://tradeexpansion.com.br/" />
  <link rel="alternate" hreflang="es" href="https://tradeexpansion.com.br/es/" />
  <link rel="alternate" hreflang="x-default" href="https://tradeexpansion.com.br/en/" />
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <!-- NAV -->
  <nav class="site-nav" id="site-nav" role="navigation" aria-label="Main navigation">
    <a href="<?php echo esc_url(home_url('/' . ($lang === 'pt' ? '' : $lang . '/'))); ?>" class="nav-logo" aria-label="Trade Expansion Home">
      <img class="nav-logo-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo.png'); ?>" alt="Trade Expansion">
      <!-- Ícone SVG (aparece no scroll quando a logo some) -->
      <svg class="nav-logo-icon" viewBox="0 0 64 64" role="img" aria-label="Trade Expansion">
        <defs>
          <linearGradient id="teGold" x1="0" x2="1" y1="0" y2="1">
            <stop offset="0" stop-color="#C9A961" />
            <stop offset="1" stop-color="#5D2713" />
          </linearGradient>
        </defs>
        <path d="M36 8c0 2.2-1.8 4-4 4s-4-1.8-4-4 1.8-4 4-4 4 1.8 4 4Z" fill="url(#teGold)" />
        <path d="M32 12v10" stroke="url(#teGold)" stroke-width="3" stroke-linecap="round" />
        <path d="M26 22c0 3.3 2.7 6 6 6s6-2.7 6-6" fill="none" stroke="url(#teGold)" stroke-width="3" stroke-linecap="round" />
        <rect x="14" y="30" width="36" height="24" rx="4" fill="none" stroke="url(#teGold)" stroke-width="3" />
        <path d="M22 30v24M30 30v24M38 30v24" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
        <path d="M14 38h36" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
      </svg>
      <span class="nav-logo-text">Trade Expansion</span>
    </a>

    <?php $lq = ($lang === 'pt') ? '' : '?te_lang=' . $lang; ?>
    <ul class="nav-links" role="list">
      <li><a href="<?php echo esc_url(home_url('/sobre-nos' . $lq)); ?>"><?php echo $lang === 'en' ? 'About' : ($lang === 'es' ? 'Sobre' : 'Sobre'); ?></a></li>

      <li><a href="<?php echo esc_url(home_url('/inspecao' . $lq)); ?>"><?php echo $lang === 'en' ? 'Inspection' : ($lang === 'es' ? 'Inspección' : 'Inspeção'); ?></a></li>
      <li><a href="<?php echo esc_url(home_url('/catalogo' . $lq)); ?>"><?php echo $lang === 'en' ? 'Catalog' : ($lang === 'es' ? 'Catálogo' : 'Catálogo'); ?></a></li>
      <li><a href="<?php echo esc_url(home_url('/contato' . $lq)); ?>"><?php echo $lang === 'en' ? 'Contact' : ($lang === 'es' ? 'Contacto' : 'Contato'); ?></a></li>
    </ul>

    <?php 
    if (is_front_page() || is_home()) {
        $url_pt = home_url('/');
        $url_en = home_url('/en/');
        $url_es = home_url('/es/');
    } else {
        $base_url = remove_query_arg('te_lang');
        $url_pt = $base_url;
        $url_en = add_query_arg('te_lang', 'en', $base_url);
        $url_es = add_query_arg('te_lang', 'es', $base_url);
    }
    ?>
    <nav class="lang-switcher" aria-label="Language selector">
      <a href="<?php echo esc_url($url_pt); ?>" class="lang-btn <?php echo $lang === 'pt' ? 'active' : ''; ?>" aria-label="Português"><span class="flag">🇧🇷</span><span class="lang-label">PT</span></a>
      <a href="<?php echo esc_url($url_en); ?>" class="lang-btn <?php echo $lang === 'en' ? 'active' : ''; ?>" aria-label="English"><span class="flag">🇺🇸</span><span class="lang-label">EN</span></a>
      <a href="<?php echo esc_url($url_es); ?>" class="lang-btn <?php echo $lang === 'es' ? 'active' : ''; ?>" aria-label="Español"><span class="flag">🇪🇸</span><span class="lang-label">ES</span></a>
    </nav>

    <a href="https://wa.me/5527992284517" target="_blank" rel="noopener" class="nav-cta" id="nav-whatsapp" aria-label="Contact via WhatsApp">
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
      </svg>
      <span class="btn-label"><?php echo $lang === 'en' ? 'Speak to an Expert' : ($lang === 'es' ? 'Hablar con un Experto' : 'Fale pelo WhatsApp'); ?></span>
    </a>

    <button class="nav-hamburger" id="nav-hamburger" aria-label="Open menu"
      onclick="document.querySelector('.nav-links').classList.toggle('open')">
      <span></span><span></span><span></span>
    </button>
  </nav>
