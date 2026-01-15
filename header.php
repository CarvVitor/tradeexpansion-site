<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

  <!-- Título dinâmico -->
  <title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>

  <!-- Fonte Vollkorn -->
  <link href="https://fonts.googleapis.com/css2?family=Vollkorn:wght@400;600;700&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Configuração de cores e fonte -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#484942',
            secondary: '#102724',
            text: '#E1E2DA',
            accent: '#5D2713',
            custom1: '#F1F1D9'
          },
          fontFamily: {
            volk: ['Vollkorn', 'serif']
          }
        }
      }
    }
  </script>

  <?php wp_head(); ?>
</head>

<body <?php body_class("bg-primary text-text font-volk relative"); ?>>
 
<!-- HEADER -->
  <header id="teHeader" class="bg-secondary text-custom1 px-8 py-4 shadow-md relative flex justify-between items-center">

    <!-- LOGO -->
    <div class="flex items-center space-x-3">
      <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2" aria-label="Trade Expansion">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Trade Expansion" class="te-logo-img h-10 w-auto">

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

        <span class="te-logo-text text-xl font-bold uppercase tracking-wide">Trade Expansion</span>
      </a>
    </div>

    <!-- BOTÃO MOBILE -->
    <button id="menu-toggle" class="md:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1 focus:outline-none border border-custom1 rounded">
      <span class="block w-6 h-0.5 bg-custom1"></span>
      <span class="block w-6 h-0.5 bg-custom1"></span>
      <span class="block w-6 h-0.5 bg-custom1"></span>
    </button>

    <!-- MENU -->
    <nav id="menu" class="hidden md:flex md:space-x-8 flex-col md:flex-row absolute md:static top-full left-0 w-full md:w-auto bg-secondary md:bg-transparent text-center md:text-left md:py-0 py-6 z-40">
      <a href="<?php echo is_front_page() ? '#sobre' : esc_url( home_url('/#sobre') ); ?>" class="block md:inline hover:text-accent transition duration-200">Sobre</a>
      <a href="<?php echo is_front_page() ? '#servicos' : esc_url( home_url('/#servicos') ); ?>" class="block md:inline hover:text-accent transition duration-200">Serviços</a>
      <a href="<?php echo esc_url( home_url('/contato') ); ?>" class="block md:inline hover:text-accent transition duration-200">Contato</a>
    </nav>
      <!-- LOADING SCREEN -->
      <div id="loading-screen">
          <div class="loading-logo">TRADE</div>
      </div>

      <script>
      window.addEventListener('load', function() {
          var loadingScreen = document.getElementById('loading-screen');
          if (loadingScreen) {
              setTimeout(function() {
                  loadingScreen.classList.add('hidden');
              }, 800);
          }
      });
      </script>

    <!-- BANDEIRAS -->
    <div class="flex items-center space-x-4 relative z-30">
    <a href="/pt/" title="Português" class="hover:opacity-80 transition">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/br-flag.svg" alt="Português" class="w-6 h-6 rounded-full border border-custom1">
      </a>
      <a href="/en/" title="English" class="hover:opacity-80 transition">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/uk-flag.svg" alt="English" class="w-6 h-6 rounded-full border border-custom1">
      </a>
    </div>
  </header>

  <!-- SCRIPT DO MENU MOBILE -->
  <script>
    (function () {
      const menuToggle = document.getElementById('menu-toggle');
      const menu = document.getElementById('menu');
      if (!menuToggle || !menu) return;
      menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    })();
  </script>