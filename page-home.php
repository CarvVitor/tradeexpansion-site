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
  <?php wp_head(); ?>

  <style>
    :root {
      --primary: #102724;
      --secondary: #484942;
      --accent: #5D2713;
      --cream: #F1F1D9;
      --text: #E1E2DA;
      --gold: #D6A354;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Vollkorn', Georgia, serif;
      background: radial-gradient(circle at top, #1b332f 0%, #0c1514 45%, #050808 100%);
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
      background: linear-gradient(90deg, rgba(16, 39, 36, 0.92), rgba(72, 73, 66, 0.9));
      backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(241, 241, 217, 0.06);
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
      border-bottom-color: rgba(214, 163, 84, 0.18);
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
      background: rgba(5, 8, 8, 0.92);
      border-top: 1px solid rgba(241, 241, 217, 0.08);
      border-bottom: 1px solid rgba(241, 241, 217, 0.08);
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
      color: rgba(241, 241, 217, 0.78);
      white-space: nowrap;
    }

    .te-marquee-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(214, 163, 84, 0.85);
      box-shadow: 0 0 14px rgba(214, 163, 84, 0.35);
      flex: 0 0 auto;
    }

    @keyframes teMarquee {
      from { transform: translateX(0); }
      to { transform: translateX(-50%); }
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
        radial-gradient(circle at top left, rgba(214, 163, 84, 0.22), transparent 55%),
        linear-gradient(120deg, rgba(16, 39, 36, 0.88), rgba(5, 8, 8, 0.92));
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
      background: rgba(5, 8, 8, 0.88);
      border-top: 1px solid rgba(241, 241, 217, 0.06);
      border-bottom: 1px solid rgba(241, 241, 217, 0.06);
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
      border: 1px solid rgba(241, 241, 217, 0.14);
      box-shadow: 0 18px 48px rgba(0, 0, 0, 0.55);
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out, border-color 0.22s ease-out;
    }

    .material-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.75);
      border-color: rgba(214, 163, 84, 0.55);
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
      border: 1px solid rgba(214, 163, 84, 0.65);
      color: var(--cream) !important;
      background: radial-gradient(circle at top left, rgba(214, 163, 84, 0.28), transparent 55%);
      transition: background 0.25s ease-out, transform 0.25s ease-out, box-shadow 0.25s ease-out;
    }

    .te-nav-cta:hover {
      background: linear-gradient(135deg, #d6a354, #5d2713);
      box-shadow: 0 0 18px rgba(214, 163, 84, 0.45);
      transform: translateY(-1px);
    }

    main {
      margin-top: 76px; /* espaço para o header fixo */
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
        radial-gradient(circle at top left, rgba(214, 163, 84, 0.38), transparent 55%),
        linear-gradient(120deg, rgba(16, 39, 36, 0.94), rgba(16, 39, 36, 0.65), rgba(5, 8, 8, 0.95));
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
      font-size: clamp(2.9rem, 5vw, 4.6rem);
      line-height: 1.05;
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
      background: linear-gradient(135deg, #d6a354, #5d2713);
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
      border: 1px solid rgba(241, 241, 217, 0.4);
      color: rgba(241, 241, 217, 0.88);
      text-transform: uppercase;
      letter-spacing: 0.16em;
      font-size: 0.78rem;
      background: rgba(5, 8, 8, 0.6);
      backdrop-filter: blur(6px);
      transition: background 0.22s ease-out, border-color 0.22s ease-out;
    }

    .btn-secondary:hover {
      background: rgba(5, 8, 8, 0.9);
      border-color: var(--gold);
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
      background: radial-gradient(circle at top left, rgba(241, 241, 217, 0.08), rgba(16, 39, 36, 0.98));
      border: 1px solid rgba(241, 241, 217, 0.12);
      box-shadow: 0 22px 60px rgba(0, 0, 0, 0.6);
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
      background: radial-gradient(circle at top left, rgba(241, 241, 217, 0.12), rgba(16, 39, 36, 0.98));
      border: 1px solid rgba(241, 241, 217, 0.18);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6);
      color: rgba(241, 241, 217, 0.9);
      transition: transform 0.22s ease-out, box-shadow 0.22s ease-out, border-color 0.22s ease-out;
    }

    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 56px rgba(0, 0, 0, 0.8);
      border-color: rgba(214, 163, 84, 0.6);
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
      border: 1px solid rgba(241, 241, 217, 0.14);
      background: rgba(5, 8, 8, 0.9);
      font-size: 0.94rem;
      color: rgba(241, 241, 217, 0.84);
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
      background: radial-gradient(circle at top left, #5d2713, #102724);
      text-align: center;
      color: var(--cream);
    }

    .cta-final h2 {
      font-size: 2.3rem;
      font-weight: 300;
      margin-bottom: 1.4rem;
    }

    .cta-final p {
      font-size: 0.98rem;
      max-width: 36rem;
      margin: 0 auto 2.4rem;
      color: rgba(241, 241, 217, 0.9);
      line-height: 1.7;
    }

    .cta-final a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.9rem 2.6rem;
      border-radius: 999px;
      background: #f1f1d9;
      color: #102724;
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

    .fade-up.delay-1 { animation-delay: 0.18s; }
    .fade-up.delay-2 { animation-delay: 0.32s; }
    .fade-up.delay-3 { animation-delay: 0.48s; }

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
  <a class="te-logo" href="<?php echo esc_url( home_url('/') ); ?>" aria-label="Trade Expansion">
    <img class="te-logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.jpg' ); ?>" alt="Trade Expansion" />

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
      <path d="M26 22c0 3.3 2.7 6 6 6s6-2.7 6-6" fill="none" stroke="url(#teGold)" stroke-width="3" stroke-linecap="round" />

      <!-- Contêiner geométrico -->
      <rect x="14" y="30" width="36" height="24" rx="4" fill="none" stroke="url(#teGold)" stroke-width="3" />
      <path d="M22 30v24M30 30v24M38 30v24" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
      <path d="M14 38h36" stroke="url(#teGold)" stroke-width="2" opacity="0.65" />
    </svg>
  </a>

  <nav class="te-nav">
    <a href="<?php echo esc_url( home_url('/sobre-nos') ); ?>">Sobre</a>
    <a href="<?php echo esc_url( home_url('/rochas-ornamentais') ); ?>">Rochas</a>
    <a href="<?php echo esc_url( home_url('/inspecao') ); ?>">Inspeção</a>
    <a href="<?php echo esc_url( home_url('/catalogo') ); ?>">Catálogo</a>
    <a class="te-nav-cta" href="<?php echo esc_url( home_url('/contato') ); ?>">Contato</a>
  </nav>
</header>

<main>
  <!-- HERO COM VÍDEO -->
  <section class="hero">
    <video
      class="hero-video"
      autoplay
      muted
      loop
      playsinline
      preload="auto"
      poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-home-fallback.jpg' ); ?>"
    >
      <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/videos/hero-home.mp4' ); ?>" type="video/mp4" />
    </video>
    <div class="hero-overlay"></div>

    <div class="hero-grid">
      <div class="fade-up">
        <div class="hero-kicker">Grupo Trade Expansion</div>
        <h1 class="hero-title">Excelência em operações <span>internacionais</span>.</h1>
        <p class="hero-text">
          Atuamos na conexão entre produtores brasileiros e compradores internacionais, com foco em rochas ornamentais,
          commodities e inspeção técnica independente. Operação enxuta, olhar técnico e compromisso absoluto com a qualidade
          entregue.
        </p>

        <div class="hero-actions">
          <a class="btn-primary" href="<?php echo esc_url( home_url('/contato') ); ?>">Falar sobre um projeto</a>
          <a class="btn-secondary" href="<?php echo esc_url( home_url('/inspecao') ); ?>">Ver como funciona a inspeção</a>
        </div>

        <div class="hero-meta">Presença em campo no Brasil · Relacionamento direto com compradores externos</div>
      </div>

      <aside class="hero-side-card fade-up delay-2">
        <div class="hero-side-title">Operação em três pilares</div>
        <div class="hero-side-text">
          Exportação, inspeção e intermediação comercial atuam de forma integrada para reduzir riscos, alinhar expectativas
          entre as partes e construir relações de longo prazo.
        </div>
        <div class="hero-tags">
          <span class="hero-tag-pill">Rochas ornamentais</span>
          <span class="hero-tag-pill">Inspeção independente</span>
          <span class="hero-tag-pill">Commodities</span>
        </div>
      </aside>
    </div>
  </section>

  <!-- BARRA / MARQUEE (PALAVRAS-CHAVE) -->
  <section class="te-marquee" aria-label="Áreas de atuação">
    <div class="te-marquee-inner">
      <div class="te-marquee-track">
        <span class="te-marquee-item">Rochas ornamentais</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Inspeção independente</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Commodities</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Exportação</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Sourcing</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Relatórios fotográficos</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Qualidade &amp; conformidade</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Logística internacional</span><span class="te-marquee-dot" aria-hidden="true"></span>

        <span class="te-marquee-item">Rochas ornamentais</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Inspeção independente</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Commodities</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Exportação</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Sourcing</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Relatórios fotográficos</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Qualidade &amp; conformidade</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Logística internacional</span><span class="te-marquee-dot" aria-hidden="true"></span>
      </div>
    </div>
  </section>

  <!-- SOBRE / QUEM SOMOS -->
  <section class="te-section">
    <div class="te-section-header fade-up">
      <div class="te-kicker">Quem somos</div>
      <h2 class="te-title">Estrutura enxuta, visão estratégica e atuação em campo.</h2>
      <p class="te-subtitle">
        A Trade Expansion LTDA é uma empresa brasileira de comércio exterior que auxilia produtores e compradores a
        estruturarem operações internacionais com clareza, controle e segurança.
      </p>
    </div>

    <div class="about-grid fade-up delay-1">
      <div class="about-text">
        <p>
          Apoiamos parceiros na exportação de rochas ornamentais e na compra de commodities, sempre com foco na qualidade
          real do produto, na viabilidade logística e na proteção contratual das partes envolvidas.
        </p>
        <p>
          Cada operação é tratada de forma individual: avaliamos o contexto do cliente, entendemos o risco aceito,
          analisamos fornecedores e estruturamos o fluxo de comunicação para que ninguém seja surpreendido no meio do caminho.
        </p>

        <div class="about-highlight">
          <strong>Olhar técnico e responsabilidade.</strong>
          Nossos relatórios e inspeções não são peças de marketing: são documentos objetivos, criados para embasar decisões
          comerciais e construir confiança entre compradores e fornecedores.
        </div>
      </div>

      <div class="about-metrics">
        <div class="about-metric">
          <strong>Brasil &amp; exterior</strong>
          Atuação direta em operações que conectam produtores brasileiros a importadores em diferentes mercados.
        </div>
        <div class="about-metric">
          <strong>Inspeção em campo</strong>
          Presença física em pedreiras, pátios e armazéns para conferência de lotes, metragem e acabamento.
        </div>
        <div class="about-metric">
          <strong>Relatórios claros</strong>
          Documentos com fotos, métricas e observações técnicas pensados para quem decide negócio.
        </div>
        <div class="about-metric">
          <strong>Visão de longo prazo</strong>
          Foco na construção de relações contínuas, e não em uma única venda isolada.
        </div>
      </div>
    </div>
  </section>

  <!-- QUEBRA VISUAL (VÍDEO) -->
  <section class="te-break" aria-label="Atuação em campo">
    <video class="te-break-video" autoplay muted loop playsinline preload="metadata">
      <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/videos/hero-rochas.mp4' ); ?>" type="video/mp4" />
    </video>
    <div class="te-break-overlay" aria-hidden="true"></div>
    <div class="te-break-content fade-up">
      <div class="te-break-kicker">Do Brasil para o mundo</div>
      <h2 class="te-break-title">Você não compra foto bonita — você compra previsibilidade.</h2>
      <p class="te-break-sub">Por isso nosso trabalho é juntar ponta a ponta: material, padrão, metragem, acabamento, documentação e expectativas. O resto é barulho.</p>
    </div>
  </section>

  <!-- SERVIÇOS PRINCIPAIS -->
  <section class="services">
    <div class="te-section-header fade-up">
      <div class="te-kicker">Atuação</div>
      <h2 class="te-title">O que o Grupo Trade Expansion entrega na prática.</h2>
      <p class="te-subtitle">
        Nossas frentes de trabalho se complementam: inspeção técnica, exportação e intermediação comercial estruturam um
        fluxo único, com acompanhamento próximo do início ao fim da operação.
      </p>
    </div>

    <div class="services-grid">
      <article class="service-card fade-up">
        <div class="service-kicker">Inspeção técnica</div>
        <h3 class="service-title">Relatórios independentes em rochas e commodities.</h3>
        <p class="service-text">
          Conferimos lotes, metragem, acabamento e eventuais não conformidades, entregando relatórios com fotos, descrições
          técnicas e observações objetivas. Material pensado para importadores, traders e equipes internas de qualidade.
        </p>
        <a class="service-link" href="<?php echo esc_url( home_url('/inspecao') ); ?>">Ver detalhes da inspeção</a>
      </article>

      <article class="service-card fade-up delay-1">
        <div class="service-kicker">Exportação</div>
        <h3 class="service-title">Estruturação de operações com rochas ornamentais.</h3>
        <p class="service-text">
          Atuamos ao lado de produtores brasileiros na montagem de operações de exportação: seleção de materiais, definição
          de lotes, conferência de documentação e coordenação com agentes de carga e terminais.
        </p>
        <a class="service-link" href="<?php echo esc_url( home_url('/rochas-ornamentais') ); ?>">Conhecer atuação em rochas</a>
      </article>

      <article class="service-card fade-up delay-2">
        <div class="service-kicker">Intermediação</div>
        <h3 class="service-title">Conexão segura entre compradores e fornecedores.</h3>
        <p class="service-text">
          Fazemos a ponte entre importadores estrangeiros e fornecedores nacionais, alinhando expectativas comerciais,
          condições de pagamento, prazos e requisitos técnicos. Transparência total sobre riscos e limitações de cada operação.
        </p>
        <a class="service-link" href="<?php echo esc_url( home_url('/contato') ); ?>">Falar sobre uma demanda</a>
      </article>
    </div>
  </section>

  <!-- MATERIAIS EM DESTAQUE (FOTOS DINÂMICAS) -->
  <?php
    $te_featured = new WP_Query([
      'post_type'      => 'rocha',
      'posts_per_page' => 6,
      'no_found_rows'  => true,
      'meta_query'     => [
        [
          'key'     => '_rocha_destaque',
          'value'   => '1',
          'compare' => '='
        ]
      ],
      'meta_key'  => '_rocha_ordem',
      'orderby'   => [
        'meta_value_num' => 'ASC',
        'date'           => 'DESC'
      ]
    ]);
  ?>

  <section class="te-section materials" id="materiais">
    <div class="te-section-header fade-up">
      <div class="te-kicker">Rochas ornamentais</div>
      <h2 class="te-title">Alguns materiais que costumamos trabalhar.</h2>
      <p class="te-subtitle">Aqui é o “gostinho” visual: você cadastra o material uma vez (com foto) e ele reaparece no site. Sem retrabalho, sem duplicação.</p>
    </div>

    <div class="materials-grid">
      <?php if ($te_featured->have_posts()) : ?>
        <?php while ($te_featured->have_posts()) : $te_featured->the_post(); ?>
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
              <div class="material-meta"><?php echo $te_sku ? 'SKU ' . esc_html($te_sku) : 'Material em destaque'; ?></div>
              <a class="material-link" href="<?php echo esc_url( home_url('/rochas-ornamentais') ); ?>">Ver página de rochas →</a>
            </div>
          </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <div class="about-highlight" style="grid-column: 1 / -1;">
          <strong>Sem fotos ainda?</strong> Sem drama. Assim que você cadastrar materiais com imagem destacada e marcar “destaque”, eles aparecem automaticamente aqui.
        </div>
      <?php endif; ?>
    </div>

    <div class="materials-cta-row fade-up delay-1">
      <a class="btn-primary" href="<?php echo esc_url( home_url('/catalogo') ); ?>">Explorar catálogo</a>
      <a class="btn-secondary" href="<?php echo esc_url( home_url('/contato') ); ?>">Solicitar disponibilidade</a>
    </div>
  </section>

  <!-- COMO TRABALHAMOS -->
  <section class="te-section">
    <div class="te-section-header fade-up">
      <div class="te-kicker">Como trabalhamos</div>
      <h2 class="te-title">Processo claro, do primeiro contato ao pós-embarque.</h2>
      <p class="te-subtitle">
        Mais do que encontrar produto, nosso papel é organizar a operação, registrar o que foi entregue e dar segurança para que
        as partes sigam fazendo negócios.
      </p>
    </div>

    <div class="process-grid">
      <div class="process-step fade-up">
        <div class="process-step-number">Etapa 1</div>
        <div class="process-step-title">Entendimento da operação</div>
        <p>
          Mapeamos o cenário do cliente, o produto desejado, o mercado de destino e o nível de risco aceito. A partir daí,
          definimos o escopo: inspeção, intermediação, exportação ou combinação das três frentes.
        </p>
      </div>

      <div class="process-step fade-up delay-1">
        <div class="process-step-number">Etapa 2</div>
        <div class="process-step-title">Conexão, conferência e registro</div>
        <p>
          Conectamos com fornecedores adequados, conferimos lotes em campo quando necessário e produzimos relatórios técnicos
          que registram o que está sendo negociado, evitando ruídos futuros.
        </p>
      </div>

      <div class="process-step fade-up delay-2">
        <div class="process-step-number">Etapa 3</div>
        <div class="process-step-title">Acompanhamento e pós-venda</div>
        <p>
          Mantemos o cliente informado até a conclusão da operação e usamos o histórico construído em relatórios e negociações
          para estruturar o próximo passo com mais segurança.
        </p>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="cta-final">
    <h2>Pronto para discutir uma operação com o Grupo Trade Expansion?</h2>
    <p>
      Se você está avaliando uma compra no Brasil, estruturando exportação ou precisa de uma visão independente sobre lotes
      e cargas, podemos apoiar com olhar técnico e experiência prática.
    </p>
    <a href="<?php echo esc_url( home_url('/contato') ); ?>">Entrar em contato</a>
  </section>
</main>

</script>
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
  })();
</script>
<?php wp_footer(); ?>
</body>
</html>