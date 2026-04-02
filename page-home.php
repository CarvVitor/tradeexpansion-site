<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 * Description: Página principal da Trade Expansion — institucional, com vídeo de fundo e layout "luxury".
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Vollkorn:wght@400;500;600&display=swap" rel="stylesheet">
  <?php wp_head(); ?>

  <style>
    :root {
      --primary: #1A1A1A;
      --secondary: #2D2D2D;
      --accent: #B8956A;
      --cream: #F5F3EF;
      --text: #E8E6E1;
      --gold: #B8956A;
      --charcoal: #0F0F0F;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Vollkorn', Georgia, serif;
      background: var(--charcoal);
      color: var(--text);
      overflow-x: hidden;
    }

    a {
      text-decoration: none;
    }

    /* HEADER FIXO */
    header.te-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      padding: 1.25rem 4vw;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(15, 15, 15, 0.92);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(184, 149, 106, 0.08);
    }

    .te-logo {
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 1rem;
      letter-spacing: 0.35em;
      text-transform: uppercase;
      color: var(--cream);
      font-weight: 500;
    }

    .te-logo-img {
      height: 34px;
      width: auto;
      display: block;
      filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.45));
    }

    .te-logo-text {
      display: none;
    }

    /* Logo: full (top) -> ícone (scroll) */
    .te-logo-icon {
      display: none;
      height: 34px;
      width: 34px;
      filter: drop-shadow(0 10px 18px rgba(0, 0, 0, 0.45));
    }

    header.te-header.is-scrolled {
      padding: 0.85rem 4vw;
      border-bottom-color: rgba(184, 149, 106, 0.18);
    }

    header.te-header.is-scrolled .te-logo-img {
      opacity: 0;
      width: 0;
      height: 0;
      margin: 0;
      overflow: hidden;
    }

    header.te-header.is-scrolled .te-logo-icon {
      display: block;
    }

    /* BARRA / MARQUEE ENTRE SEÇÕES */
    .te-marquee {
      background: rgba(15, 15, 15, 0.95);
      border-top: 1px solid rgba(184, 149, 106, 0.08);
      border-bottom: 1px solid rgba(184, 149, 106, 0.08);
      overflow: hidden;
    }

    .te-marquee-inner {
      max-width: 1240px;
      margin: 0 auto;
      padding: 0 6vw;
    }

    .te-marquee-track {
      display: flex;
      align-items: center;
      gap: 2.2rem;
      width: max-content;
      padding: 1.05rem 0;
      animation: teMarquee 26s linear infinite;
      will-change: transform;
    }

    .te-marquee-item {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.24em;
      color: rgba(245, 243, 239, 0.6);
      white-space: nowrap;
    }

    .te-marquee-dot {
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: rgba(184, 149, 106, 0.7);
      box-shadow: 0 0 10px rgba(184, 149, 106, 0.25);
      flex: 0 0 auto;
    }

    @keyframes teMarquee {
      from {
        transform: translateX(0);
      }

      to {
        transform: translateX(-50%);
      }
    }

    /* QUEBRA VISUAL COM VÍDEO */
    .te-break {
      position: relative;
      min-height: 360px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-top: 1px solid rgba(241, 241, 217, 0.06);
      border-bottom: 1px solid rgba(241, 241, 217, 0.06);
    }

    .te-break-video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: saturate(1.08) contrast(1.05) brightness(0.7);
      transform: scale(1.02);
    }

    .te-break-overlay {
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at top left, rgba(184, 149, 106, 0.12), transparent 55%),
        linear-gradient(120deg, rgba(15, 15, 15, 0.92), rgba(15, 15, 15, 0.95));
    }

    .te-break-content {
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 3.2rem 6vw;
      max-width: 980px;
      color: var(--cream);
    }

    .te-break-kicker {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.26em;
      color: rgba(241, 241, 217, 0.78);
      margin-bottom: 1rem;
    }

    .te-break-title {
      font-size: clamp(1.9rem, 3.4vw, 2.6rem);
      font-weight: 300;
      line-height: 1.15;
      margin: 0 0 1.2rem;
    }

    .te-break-sub {
      font-size: 1rem;
      line-height: 1.75;
      color: rgba(241, 241, 217, 0.9);
      margin: 0 auto;
      max-width: 42rem;
    }

    /* GRID DE MATERIAIS (FOTOS DINÂMICAS) */
    .materials {
      background: rgba(15, 15, 15, 0.95);
      border-top: 1px solid rgba(184, 149, 106, 0.06);
      border-bottom: 1px solid rgba(184, 149, 106, 0.06);
    }

    .materials-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 1.6rem;
      margin-top: 2.6rem;
    }

    .material-card {
      position: relative;
      border-radius: 18px;
      overflow: hidden;
      min-height: 280px;
      background-size: cover;
      background-position: center;
      border: 1px solid rgba(184, 149, 106, 0.12);
      box-shadow: 0 18px 48px rgba(0, 0, 0, 0.55);
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out, border-color 0.22s ease-out;
    }

    .material-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.75);
      border-color: rgba(184, 149, 106, 0.45);
    }

    .material-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(5, 8, 8, 0.08) 0%, rgba(5, 8, 8, 0.82) 70%, rgba(5, 8, 8, 0.96) 100%);
    }

    .material-content {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      padding: 1.35rem 1.35rem 1.5rem;
    }

    .material-title {
      margin: 0 0 0.45rem;
      font-size: 1.1rem;
      font-weight: 400;
      color: var(--cream);
    }

    .material-meta {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(241, 241, 217, 0.78);
    }

    .material-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 0.95rem;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(214, 163, 84, 0.92);
    }

    .materials-cta-row {
      display: flex;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 2.4rem;
    }

    .te-nav {
      display: flex;
      align-items: center;
      gap: 1.75rem;
      font-size: 0.85rem;
      letter-spacing: 0.16em;
      text-transform: uppercase;
    }

    .te-nav a {
      color: rgba(241, 241, 217, 0.85);
      position: relative;
      padding-bottom: 0.15rem;
    }

    .te-nav a::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0;
      height: 1px;
      background: var(--gold);
      transition: width 0.25s ease-out;
    }

    .te-nav a:hover::after {
      width: 100%;
    }

    .te-nav-cta {
      padding: 0.55rem 1.4rem;
      border-radius: 999px;
      border: 1px solid rgba(184, 149, 106, 0.5);
      color: var(--cream) !important;
      background: radial-gradient(circle at top left, rgba(184, 149, 106, 0.18), transparent 55%);
      transition: background 0.25s ease-out, transform 0.25s ease-out, box-shadow 0.25s ease-out;
    }

    .te-nav-cta:hover {
      background: linear-gradient(135deg, var(--accent), #8B6E4E);
      box-shadow: 0 0 18px rgba(184, 149, 106, 0.35);
      transform: translateY(-1px);
    }

    main {
      margin-top: 76px;
      /* espaço para o header fixo */
    }

    /* HERO COM VÍDEO */
    .hero {
      position: relative;
      min-height: calc(100vh - 76px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 5rem 6vw 6rem;
      overflow: hidden;
    }

    .hero-video {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: saturate(1.1) contrast(1.05) brightness(0.85);
      transform: scale(1.03);
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at top left, rgba(184, 149, 106, 0.15), transparent 55%),
        linear-gradient(120deg, rgba(15, 15, 15, 0.95), rgba(26, 26, 26, 0.85), rgba(15, 15, 15, 0.97));
      mix-blend-mode: multiply;
    }

    .hero-grid {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
      gap: 3rem;
      align-items: center;
      max-width: 1280px;
      width: 100%;
      color: var(--cream);
    }

    .hero-kicker {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.28em;
      color: rgba(241, 241, 217, 0.75);
      margin-bottom: 1.5rem;
    }

    .hero-title {
      font-family: 'Cormorant Garamond', Georgia, serif;
      font-size: clamp(2.4rem, 4.5vw, 3.8rem);
      line-height: 1.1;
      font-weight: 300;
      margin-bottom: 1.8rem;
    }

    .hero-title span {
      color: var(--gold);
    }

    .hero-text {
      font-size: 1.05rem;
      max-width: 36rem;
      color: rgba(241, 241, 217, 0.9);
      line-height: 1.7;
      margin-bottom: 2.4rem;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: center;
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.85rem 2.4rem;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--accent), #8B6E4E);
      color: var(--cream);
      text-transform: uppercase;
      letter-spacing: 0.18em;
      font-size: 0.8rem;
      border: none;
      box-shadow: 0 14px 40px rgba(0, 0, 0, 0.55);
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 18px 46px rgba(0, 0, 0, 0.7);
    }

    .btn-secondary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.8rem 1.9rem;
      border-radius: 999px;
      border: 1px solid rgba(241, 241, 217, 0.2);
      color: rgba(241, 241, 217, 0.9);
      text-transform: uppercase;
      letter-spacing: 0.16em;
      font-size: 0.78rem;
      background: transparent;
      transition: background 0.22s ease-out, border-color 0.22s ease-out;
    }

    .btn-secondary:hover {
      background: rgba(214, 163, 84, 0.1);
      border-color: rgba(214, 163, 84, 0.4);
    }

    .hero-meta {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.2em;
      color: rgba(241, 241, 217, 0.7);
      margin-top: 2.1rem;
    }

    .hero-side-card {
      padding: 2.2rem 2.4rem;
      border-radius: 18px;
      background: rgba(26, 26, 26, 0.85);
      border: 1px solid rgba(184, 149, 106, 0.12);
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(12px);
    }

    .hero-side-title {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.26em;
      color: rgba(241, 241, 217, 0.75);
      margin-bottom: 1.3rem;
    }

    .hero-side-text {
      font-size: 0.95rem;
      line-height: 1.7;
      color: rgba(241, 241, 217, 0.9);
      margin-bottom: 1.5rem;
    }

    .hero-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 0.55rem;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(241, 241, 217, 0.75);
    }

    .hero-tag-pill {
      padding: 0.45rem 0.9rem;
      border-radius: 999px;
      border: 1px solid rgba(241, 241, 217, 0.22);
      background: rgba(5, 8, 8, 0.7);
    }

    /* SEÇÕES BASE */
    section {
      position: relative;
    }

    .te-section {
      max-width: 1240px;
      margin: 0 auto;
      padding: 5.5rem 6vw;
    }

    .te-section-header {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      margin-bottom: 3rem;
    }

    .te-kicker {
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.24em;
      color: rgba(241, 241, 217, 0.7);
    }

    .te-title {
      font-family: 'Cormorant Garamond', Georgia, serif;
      font-size: 2.1rem;
      font-weight: 300;
      color: var(--cream);
    }

    .te-subtitle {
      font-size: 0.98rem;
      max-width: 32rem;
      color: rgba(241, 241, 217, 0.78);
      line-height: 1.7;
    }

    /* SOBRE / QUEM SOMOS */
    .about-grid {
      display: grid;
      grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
      gap: 3.2rem;
      align-items: flex-start;
    }

    .about-text {
      font-size: 0.98rem;
      line-height: 1.85;
      color: rgba(241, 241, 217, 0.88);
    }

    .about-highlight {
      margin-top: 1.8rem;
      padding: 1.6rem 1.8rem;
      border-radius: 16px;
      border: 1px solid rgba(241, 241, 217, 0.14);
      background: radial-gradient(circle at top left, rgba(241, 241, 217, 0.08), rgba(16, 39, 36, 0.96));
      font-size: 0.92rem;
    }

    .about-metrics {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1.4rem;
      font-size: 0.86rem;
      color: rgba(241, 241, 217, 0.8);
    }

    .about-metric strong {
      display: block;
      font-size: 1.3rem;
      color: var(--gold);
      margin-bottom: 0.2rem;
      font-weight: 400;
    }

    /* SERVIÇOS */
    .services {
      padding: 5.5rem 6vw 4.5rem;
      max-width: 1240px;
      margin: 0 auto;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 2.4rem;
    }

    .service-card {
      padding: 2.4rem 2.2rem;
      border-radius: 18px;
      background: rgba(26, 26, 26, 0.85);
      border: 1px solid rgba(184, 149, 106, 0.12);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6);
      color: rgba(245, 243, 239, 0.9);
      backdrop-filter: blur(8px);
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out, border-color 0.22s ease-out;
    }

    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 56px rgba(0, 0, 0, 0.8);
      border-color: rgba(184, 149, 106, 0.45);
    }

    .service-kicker {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.22em;
      color: rgba(241, 241, 217, 0.7);
      margin-bottom: 0.9rem;
    }

    .service-title {
      font-size: 1.2rem;
      margin-bottom: 0.9rem;
      color: var(--cream);
    }

    .service-text {
      font-size: 0.94rem;
      line-height: 1.8;
      margin-bottom: 1.4rem;
    }

    .service-link {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(214, 163, 84, 0.9);
    }

    /* PROCESSO */
    .process-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 2rem;
      margin-top: 1.5rem;
    }

    .process-step {
      padding: 1.8rem 1.8rem 1.9rem;
      border-radius: 16px;
      border: 1px solid rgba(184, 149, 106, 0.1);
      background: rgba(26, 26, 26, 0.7);
      font-size: 0.94rem;
      color: rgba(245, 243, 239, 0.84);
    }

    .process-step-number {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.24em;
      color: rgba(214, 163, 84, 0.9);
      margin-bottom: 0.7rem;
    }

    .process-step-title {
      font-size: 1.05rem;
      margin-bottom: 0.6rem;
      color: var(--cream);
    }

    /* CTA FINAL */
    .cta-final {
      padding: 5rem 6vw 5.5rem;
      background: linear-gradient(135deg, rgba(184, 149, 106, 0.15), rgba(15, 15, 15, 0.98));
      text-align: center;
      color: var(--cream);
      border-top: 1px solid rgba(184, 149, 106, 0.1);
    }

    .cta-final h2 {
      font-family: 'Cormorant Garamond', Georgia, serif;
      font-size: 2.3rem;
      font-weight: 300;
      margin-bottom: 1.4rem;
    }

    .cta-final p {
      font-size: 0.98rem;
      max-width: 36rem;
      margin: 0 auto 2.4rem;
      color: rgba(245, 243, 239, 0.85);
      line-height: 1.7;
    }

    .cta-final a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.9rem 2.6rem;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--accent), #8B6E4E);
      color: var(--cream);
      text-transform: uppercase;
      letter-spacing: 0.18em;
      font-size: 0.8rem;
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out;
      box-shadow: 0 14px 32px rgba(0, 0, 0, 0.55);
    }

    .cta-final a:hover {
      transform: translateY(-2px);
      box-shadow: 0 18px 48px rgba(0, 0, 0, 0.75);
    }

    /* ANIMAÇÕES SIMPLES */
    .fade-up {
      opacity: 0;
      transform: translateY(24px);
      animation: fadeUp 0.9s ease-out forwards;
    }

    .fade-up.delay-1 {
      animation-delay: 0.18s;
    }

    .fade-up.delay-2 {
      animation-delay: 0.32s;
    }

    .fade-up.delay-3 {
      animation-delay: 0.48s;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 960px) {
      header.te-header {
        padding-inline: 1.5rem;
      }

      .te-nav {
        display: none;
      }

      .te-logo-img {
        height: 30px;
      }

      .te-break {
        min-height: 280px;
      }

      .materials-grid {
        grid-template-columns: minmax(0, 1fr);
      }

      main {
        margin-top: 64px;
      }

      .hero {
        padding: 4.5rem 1.6rem 4.8rem;
      }

      .hero-grid {
        grid-template-columns: minmax(0, 1fr);
      }

      .hero-side-card {
        margin-top: 1.2rem;
      }

      .about-grid,
      .services-grid,
      .process-grid {
        grid-template-columns: minmax(0, 1fr);
      }

      .te-section {
        padding-inline: 1.6rem;
      }
    }
  </style>
</head>

<body <?php body_class(); ?>>

  <header class="te-header" id="teHeader">
    <a class="te-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Trade Expansion">
      <img class="te-logo-img" src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>"
        alt="Trade Expansion" />

      <!-- Ícone (aparece no scroll) -->
      <svg class="te-logo-icon" viewBox="0 0 64 64" role="img" aria-label="Trade Expansion">
        <defs>
          <linearGradient id="teGold" x1="0" x2="1" y1="0" y2="1">
            <stop offset="0" stop-color="#D6A354" />
            <stop offset="1" stop-color="#5D2713" />
          </linearGradient>
        </defs>
        <!-- Gancho minimalista -->
        <path d="M36 8c0 2.2-1.8 4-4 4s-4-1.8-4-4 1.8-4 4-4 4 1.8 4 4Z" fill="url(#teGold)" />
        <path d="M32 12v10" stroke="url(#teGold)" stroke-width="3" stroke-linecap="round" />
        <path d="M26 22c0 3.3 2.7 6 6 6s6-2.7 6-6" fill="none" stroke="url(#teGold)" stroke-width="3"
          stroke-linecap="round" />

        <!-- Contêiner geométrico -->
        <rect x="14" y="30" width="36" height="24" rx="4" fill="none" stroke="url(#teGold)" stroke-width="3" />
        <path d="M22 30v24M30 30v24M38 30v24" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
        <path d="M14 38h36" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
      </svg>
    </a>

    <nav class="te-nav">
      <a href="<?php echo esc_url(home_url('/sobre-nos')); ?>">Sobre</a>
      <a href="<?php echo esc_url(home_url('/rochas-ornamentais')); ?>">Rochas</a>
      <a href="<?php echo esc_url(home_url('/inspecao')); ?>">Inspeção</a>
      <a href="<?php echo esc_url(home_url('/catalogo')); ?>">Catálogo</a>
      <a class="te-nav-cta" href="<?php echo esc_url(home_url('/contato')); ?>">Contato</a>
    </nav>
  </header>

  <main>
    <!-- HERO COM VÍDEO -->
    <section class="hero">
      <video class="hero-video" autoplay muted loop playsinline preload="auto"
        poster="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-home-fallback.jpg'); ?>">
        <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-home.mp4'); ?>"
          type="video/mp4" />
      </video>
      <div class="hero-overlay"></div>

      <div class="hero-grid">
        <div class="fade-up">
          <div class="hero-kicker">Boutique de Inteligência em Comércio Exterior</div>
          <h1 class="hero-title">Onde a Precisão encontra a <span>Exclusividade</span> na Exportação de Rochas.</h1>
          <p class="hero-text">
            Curadoria técnica e inteligência operacional para compradores que não aceitam margem
            para erro. Do campo à entrega final, garantimos a integridade do seu investimento.
          </p>

          <div class="hero-actions">
            <a class="btn-primary" href="<?php echo esc_url(home_url('/contato')); ?>">Solicitar Curadoria Técnica</a>
            <a class="btn-secondary" href="<?php echo esc_url(home_url('/inspecao')); ?>">Consultar Especialista</a>
          </div>

          <div class="hero-meta">Operações para importadores na Europa, Ásia e América do Norte · Inspeções em ES, MG e BA</div>
        </div>

        <aside class="hero-side-card fade-up delay-2">
          <div class="hero-side-title">Atendimento Boutique e Dedicado</div>
          <div class="hero-side-text">
            Cada operação recebe atenção exclusiva. Nosso modelo boutique garante que seu projeto
            tenha um especialista dedicado do início ao embarque — sem filas, sem surpresas.
          </div>
          <div class="hero-tags">
            <span class="hero-tag-pill">Curadoria de Rochas</span>
            <span class="hero-tag-pill">Inspeção Técnica</span>
            <span class="hero-tag-pill">Blindagem Operacional</span>
          </div>
        </aside>
      </div>
    </section>

    <!-- BARRA / MARQUEE (PALAVRAS-CHAVE) -->
    <section class="te-marquee" aria-label="Áreas de atuação">
      <div class="te-marquee-inner">
        <div class="te-marquee-track">
          <span class="te-marquee-item">Rochas ornamentais</span><span class="te-marquee-dot" aria-hidden="true"></span>
          <span class="te-marquee-item">Inspeção independente</span><span class="te-marquee-dot"
            aria-hidden="true"></span>
          <span class="te-marquee-item">Commodities</span><span class="te-marquee-dot" aria-hidden="true"></span>
          <span class="te-marquee-item">Exportação</span><span class="te-marquee-dot" aria-hidden="true"></span>
          <span class="te-marquee-item">Sourcing</span><span class="te-marquee-dot" aria-hidden="true"></span>
          <span class="te-marquee-item">Relatórios fotográficos</span><span class="te-marquee-dot"
            aria-hidden="true"></span>
          <span class="te-marquee-item">Qualidade &amp; conformidade</span><span class="te-marquee-dot"
            aria-hidden="true"></span>
          <span class="te-marquee-item">Logística internacional</span><span class="te-marquee-dot"
            aria-hidden="true"></span>
        </div>
      </div>
    </section>

    <div style="background: rgba(26, 26, 26, 0.6); text-align: center; padding: 1.5rem 0; border-bottom: 1px solid rgba(184, 149, 106, 0.08);">
      <p style="font-size: 0.82rem; letter-spacing: 0.12em; color: rgba(184, 149, 106, 0.7); margin: 0; text-transform: uppercase;">
        Operações realizadas para importadores na Europa, Ásia e América do Norte · Inspeções técnicas em ES, MG e BA
      </p>
    </div>

    <!-- SOBRE / QUEM SOMOS -->
    <section class="te-section">
      <div class="te-section-header fade-up">
        <div class="te-kicker">Quem somos</div>
        <h2 class="te-title">A Inteligência por trás das Maiores Operações.</h2>
        <p class="te-subtitle">
          Na Trade Expansion, não apenas facilitamos negócios; nós os blindamos. Nossa estrutura
          boutique permite um olhar microscópico sobre cada detalhe da rocha e da logística.
        </p>
      </div>

      <div class="about-grid fade-up delay-1">
        <div class="about-text">
          <p>
            Operamos como uma extensão dedicada do seu time de compras. Cada lote é analisado com rigor técnico,
            cada documento é revisado com precisão jurídica, e cada embarque é acompanhado com a vigílância
            que seu investimento exige.
          </p>

          <div class="about-highlight">
            <strong>Inteligência aplicada ao campo.</strong>
            Nossos laudos e inspeções são instrumentos de decisão — não peças de marketing. Cada relatório
            é construído para blindar operações e proteger ambas as partes.
          </div>
        </div>

        <div class="about-metrics">
          <div class="about-metric">
            <strong>Curadoria Técnica</strong>
            Seleção criteriosa de materiais com análise visual, dimensional e de acabamento.
          </div>
          <div class="about-metric">
            <strong>Inspeção em Campo</strong>
            Presença física em pedreiras, pátios e armazéns com documentação fotográfica detalhada.
          </div>
          <div class="about-metric">
            <strong>Laudos Técnicos</strong>
            Documentos com métricas objetivas, construídos para quem toma decisões de alto valor.
          </div>
          <div class="about-metric">
            <strong>Visão Estratégica</strong>
            Foco na construção de operações sustentáveis e relacionamentos de longo prazo.
          </div>
        </div>
      </div>
    </section>

    <!-- QUEBRA VISUAL (VÍDEO) -->
    <section class="te-break" aria-label="Atuação em campo">
      <video class="te-break-video" autoplay muted loop playsinline preload="metadata">
        <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-rochas.mp4'); ?>"
          type="video/mp4" />
      </video>
      <div class="te-break-overlay" aria-hidden="true"></div>
      <div class="te-break-content fade-up">
        <div class="te-break-kicker">Do Brasil para o mundo</div>
        <h2 class="te-break-title">Você não compra foto bonita — você compra previsibilidade.</h2>
        <p class="te-break-sub">Por isso nosso trabalho é juntar ponta a ponta: material, padrão, metragem, acabamento,
          documentação e expectativas. O resto é barulho.</p>
      </div>
    </section>

    <!-- THE INTELLIGENCE LAB -->
    <section class="te-section" style="border-top: 1px solid rgba(184, 149, 106, 0.08);">
      <div class="te-section-header fade-up">
        <div class="te-kicker">The Intelligence Lab</div>
        <h2 class="te-title">Onde cada lote é dissecado antes da decisão.</h2>
        <p class="te-subtitle">
          Nosso rigor técnico não é um discurso — é um protocolo. Cada material passa por análise visual,
          dimensional e de acabamento antes de qualquer recomendação.
        </p>
      </div>

      <div class="services-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
        <article class="service-card fade-up" style="text-align: center; padding: 2.8rem 2rem;">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none" style="margin: 0 auto 1.2rem;">
            <circle cx="20" cy="20" r="14" stroke="var(--accent)" stroke-width="2" fill="none"/>
            <line x1="30" y1="30" x2="42" y2="42" stroke="var(--accent)" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="20" cy="20" r="6" stroke="var(--accent)" stroke-width="1.5" fill="none" opacity="0.5"/>
          </svg>
          <h3 class="service-title">Análise de Lote</h3>
          <p class="service-text">Conferência visual, dimensional e de acabamento com registro fotográfico de cada peça avaliada.</p>
        </article>

        <article class="service-card fade-up delay-1" style="text-align: center; padding: 2.8rem 2rem;">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none" style="margin: 0 auto 1.2rem;">
            <rect x="6" y="4" width="36" height="40" rx="3" stroke="var(--accent)" stroke-width="2" fill="none"/>
            <line x1="14" y1="14" x2="34" y2="14" stroke="var(--accent)" stroke-width="1.5" opacity="0.6"/>
            <line x1="14" y1="20" x2="30" y2="20" stroke="var(--accent)" stroke-width="1.5" opacity="0.6"/>
            <line x1="14" y1="26" x2="34" y2="26" stroke="var(--accent)" stroke-width="1.5" opacity="0.6"/>
            <line x1="14" y1="32" x2="26" y2="32" stroke="var(--accent)" stroke-width="1.5" opacity="0.6"/>
          </svg>
          <h3 class="service-title">Laudo Técnico</h3>
          <p class="service-text">Relatório fotográfico com métricas objetivas, construído para embasar decisões de alto valor.</p>
        </article>

        <article class="service-card fade-up delay-2" style="text-align: center; padding: 2.8rem 2rem;">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none" style="margin: 0 auto 1.2rem;">
            <path d="M24 4L24 12" stroke="var(--accent)" stroke-width="2" stroke-linecap="round"/>
            <path d="M24 36L24 44" stroke="var(--accent)" stroke-width="2" stroke-linecap="round"/>
            <path d="M4 24L12 24" stroke="var(--accent)" stroke-width="2" stroke-linecap="round"/>
            <path d="M36 24L44 24" stroke="var(--accent)" stroke-width="2" stroke-linecap="round"/>
            <circle cx="24" cy="24" r="10" stroke="var(--accent)" stroke-width="2" fill="none"/>
            <circle cx="24" cy="24" r="4" fill="var(--accent)" opacity="0.3"/>
          </svg>
          <h3 class="service-title">Blindagem Operacional</h3>
          <p class="service-text">Documentação que protege comprador e vendedor em cada etapa da operação comercial.</p>
        </article>
      </div>

      <div style="text-align: center; margin-top: 2.4rem;" class="fade-up delay-1">
        <button id="te-lab-btn" class="btn-secondary" style="cursor: pointer; font-family: inherit;">
          Ver Exemplo de Laudo →
        </button>
      </div>
    </section>

    <!-- MODAL DO LAUDO -->
    <div id="te-lab-modal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.9); backdrop-filter:blur(10px); align-items:center; justify-content:center;">
      <div style="max-width: 900px; width: 95%; height: 85vh; position: relative; background: var(--secondary); border: 1px solid rgba(184, 149, 106, 0.2); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 1rem 1.5rem; background: rgba(26, 26, 26, 0.9); border-bottom: 1px solid rgba(184, 149, 106, 0.1); display: flex; justify-content: space-between; align-items: center;">
          <span style="font-family: 'Cormorant Garamond', serif; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; font-size: 0.9rem;">Technical Inspection Report · Taj Mahal</span>
          <div style="display: flex; gap: 1rem; align-items: center;">
            <a href="<?php echo esc_url(get_template_directory_uri() . '/assets/Laudo_Taj-Mahal_EN_2026-04-02.pdf'); ?>" download class="btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.75rem; border-color: rgba(184, 149, 106, 0.3);">Download PDF</a>
            <button id="te-lab-close" style="background:none; border:none; color:var(--cream); font-size:1.5rem; cursor:pointer; line-height: 1;">✕</button>
          </div>
        </div>
        <iframe id="te-lab-iframe" src="" style="width:100%; flex: 1; border:none;" title="Technical Report Viewer"></iframe>
        <div style="text-align:center; padding: 0.8rem; font-size:0.75rem; color:rgba(184,149,106,0.5); text-transform:uppercase; letter-spacing:0.1em; background: rgba(26,26,26,0.5);">Documento de uso analítico · Trade Expansion Technical Division</div>
      </div>
    </div>

    <!-- SERVIÇOS PRINCIPAIS -->
    <section class="services">
      <div class="te-section-header fade-up">
        <div class="te-kicker">Atuação</div>
        <h2 class="te-title">Três pilares que blindam sua operação.</h2>
        <p class="te-subtitle">
          Inspeção técnica, exportação e intermediação comercial operam de forma integrada para
          eliminar riscos antes que eles existam.
        </p>
      </div>

      <div class="services-grid" style="grid-template-columns: 1.5fr 1fr; gap: 2rem;">
        <article class="service-card fade-up" style="border-color: rgba(184, 149, 106, 0.25); padding: 2.8rem;">
          <svg width="40" height="40" viewBox="0 0 40 40" fill="none" style="margin-bottom: 1.2rem;">
            <circle cx="20" cy="20" r="18" stroke="var(--accent)" stroke-width="1.5" fill="none"/>
            <path d="M12 20L18 26L28 14" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <div class="service-kicker">Diferencial Central</div>
          <h3 class="service-title">Inspeção Técnica Independente</h3>
          <p class="service-text">
            Laudos com registro fotográfico, análise dimensional e de acabamento. Cada relatório é
            um instrumento de decisão construído para proteger seu investimento.
          </p>
          <a class="service-link" href="<?php echo esc_url(home_url('/inspecao')); ?>">Conhecer protocolo de inspeção</a>
        </article>

        <div style="display: flex; flex-direction: column; gap: 2rem;">
          <article class="service-card fade-up delay-1">
            <div class="service-kicker">Exportação</div>
            <h3 class="service-title">Operações estruturadas com rochas ornamentais.</h3>
            <p class="service-text">
              Seleção de materiais, curadoria de lotes e coordenação logística do início ao embarque.
            </p>
            <a class="service-link" href="<?php echo esc_url(home_url('/rochas-ornamentais')); ?>">Explorar curadoria</a>
          </article>

          <article class="service-card fade-up delay-2">
            <div class="service-kicker">Intermediação</div>
            <h3 class="service-title">Conexão blindada entre compradores e fornecedores.</h3>
            <p class="service-text">
              Alinhamento técnico e comercial com transparência total sobre riscos e limitações.
            </p>
            <a class="service-link" href="<?php echo esc_url(home_url('/contato')); ?>">Consultar especialista</a>
          </article>
        </div>
      </div>
    </section>

    <!-- MATERIAIS EM DESTAQUE (FOTOS DINÂMICAS) -->
    <?php
    $te_featured = new WP_Query([
      'post_type' => 'rocha',
      'posts_per_page' => 6,
      'no_found_rows' => true,
      'meta_query' => [
        [
          'key' => '_rocha_destaque',
          'value' => '1',
          'compare' => '='
        ]
      ],
      'meta_key' => '_rocha_ordem',
      'orderby' => [
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
      ]
    ]);
    ?>

    <section class="te-section materials" id="materiais">
      <div class="te-section-header fade-up">
        <div class="te-kicker">Rochas ornamentais</div>
        <h2 class="te-title">Alguns materiais que costumamos trabalhar.</h2>
      </div>

      <div class="materials-grid">
        <?php if ($te_featured->have_posts()): ?>
          <?php while ($te_featured->have_posts()):
            $te_featured->the_post(); ?>
            <?php
            $te_img = get_the_post_thumbnail_url(get_the_ID(), 'large');
            if (!$te_img) {
              $te_img = get_template_directory_uri() . '/assets/images/hero-rochas-fallback.jpg';
            }
            $te_sku = get_post_meta(get_the_ID(), '_rocha_sku', true);
            ?>
            <article class="material-card fade-up" style="background-image: url('<?php echo esc_url($te_img); ?>');">
              <div class="material-overlay" aria-hidden="true"></div>
              <div class="material-content">
                <h3 class="material-title"><?php the_title(); ?></h3>
                <div class="material-meta"><?php echo $te_sku ? 'SKU ' . esc_html($te_sku) : 'Material em destaque'; ?>
                </div>
                <a class="material-link" href="<?php echo esc_url(home_url('/rochas-ornamentais')); ?>">Ver página de
                  rochas →</a>
              </div>
            </article>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else: ?>
          <div class="about-highlight" style="grid-column: 1 / -1; display: none;">
            <!-- Placeholder section oculta via CSS. Para exibir os materiais, insira posts de rochas destacadas no WP -->
          </div>
        <?php endif; ?>
      </div>

      <div class="materials-cta-row fade-up delay-1">
        <a class="btn-primary" href="<?php echo esc_url(home_url('/catalogo')); ?>">Explorar catálogo</a>
        <a class="btn-secondary" href="<?php echo esc_url(home_url('/contato')); ?>">Solicitar disponibilidade</a>
      </div>
    </section>

    <!-- COMO TRABALHAMOS -->
    <section class="te-section">
      <div class="te-section-header fade-up">
        <div class="te-kicker">Como trabalhamos</div>
        <h2 class="te-title">Processo claro, do primeiro contato ao pós-embarque.</h2>
        <p class="te-subtitle">
          Mais do que encontrar produto, nosso papel é organizar a operação, registrar o que foi entregue e dar
          segurança para que
          as partes sigam fazendo negócios.
        </p>
      </div>

      <div class="process-grid">
        <div class="process-step fade-up">
          <div class="process-step-number">Etapa 1</div>
          <div class="process-step-title">Entendimento da operação</div>
          <p>
            Mapeamos o cenário do cliente, o produto desejado e o nível de risco aceito para definir o escopo ideal e seguro da exportação.
          </p>
        </div>

        <div class="process-step fade-up delay-1">
          <div class="process-step-number">Etapa 2</div>
          <div class="process-step-title">Conexão, conferência e registro</div>
          <p>
            Conectamos os parceiros certos, auditamos lotes em campo e produzimos laudos técnicos objetivos e detalhados.
          </p>
        </div>

        <div class="process-step fade-up delay-2">
          <div class="process-step-number">Etapa 3</div>
          <div class="process-step-title">Acompanhamento e pós-venda</div>
          <p>
            Garantimos comunicação transparente até o fim da entrega e usamos o histórico para otimizar negócios futuros.
          </p>
        </div>
      </div>
    </section>

    <!-- CTA FINAL -->
    <section class="cta-final">
      <h2>Seu próximo embarque merece inteligência de ponta.</h2>
      <p>
        Deixe que nossa curadoria técnica elimine os riscos antes que eles existam.
      </p>
      <a href="<?php echo esc_url(home_url('/contato')); ?>">Solicitar Curadoria Técnica</a>
    </section>
  </main>

  <script>
    (function () {
      const header = document.getElementById('teHeader');
      if (!header) return;

      // Header: logo completa -> ícone
      const toggleHeader = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
      };

      // Parallax sutil (só desktop / sem reduzir acessibilidade)
      const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const isCoarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
      const heroVideo = document.querySelector('.hero-video');
      const breakVideo = document.querySelector('.te-break-video');

      let ticking = false;
      const onScroll = () => {
        toggleHeader();
        if (prefersReduced || isCoarse) return;
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(() => {
          const y = window.scrollY || 0;
          const p1 = Math.min(28, y * 0.08);
          const p2 = Math.min(20, y * 0.05);
          if (heroVideo) heroVideo.style.transform = `translate3d(0, ${p1}px, 0) scale(1.03)`;
          if (breakVideo) breakVideo.style.transform = `translate3d(0, ${p2}px, 0) scale(1.02)`;
          ticking = false;
        });
      };

      toggleHeader();
      window.addEventListener('scroll', onScroll, { passive: true });

      // Modal do Intelligence Lab
      const labBtn = document.getElementById('te-lab-btn');
      const labModal = document.getElementById('te-lab-modal');
      const labClose = document.getElementById('te-lab-close');
      const labIframe = document.getElementById('te-lab-iframe');
      const pdfUrl = "<?php echo esc_url(get_template_directory_uri() . '/assets/Laudo_Taj-Mahal_EN_2026-04-02.pdf'); ?>";

      if (labBtn && labModal) {
        labBtn.addEventListener('click', () => { 
          labModal.style.display = 'flex'; 
          if (labIframe && !labIframe.src) {
            labIframe.src = pdfUrl + "#toolbar=0&navpanes=0";
          }
        });
        labClose.addEventListener('click', () => { labModal.style.display = 'none'; });
        labModal.addEventListener('click', (e) => { if (e.target === labModal) labModal.style.display = 'none'; });
      }

      // Fade-up observer
      const faders = document.querySelectorAll('.fade-up');
      if (faders.length && 'IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
          entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); } });
        }, { threshold: 0.15 });
        faders.forEach(f => io.observe(f));
      }
    })();
  </script>
  <?php wp_footer(); ?>
</body>

</html>