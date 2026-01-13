<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>

  <!-- Fonte Vollkorn -->
  <link href="https://fonts.googleapis.com/css2?family=Vollkorn:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

  <!-- Tailwind CDN (Opcional, mantido para compatibilidade de classes legadas no header) -->
  <script src="https://cdn.tailwindcss.com"></script>
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

  <!-- LOADING SCREEN PREMIUN -->
  <div id="loading-screen">
    <div class="loading-content">
      <div class="loading-logo">TRADE EXPANSION</div>
      <div class="loading-bar-container">
        <div class="loading-bar"></div>
      </div>
      <div class="loading-text">Validando dados de inspeção...</div>
    </div>
  </div>

  <script>
    window.addEventListener('load', function () {
      var loadingScreen = document.getElementById('loading-screen');
      if (loadingScreen) {
        setTimeout(function () {
          loadingScreen.classList.add('hidden');
        }, 1500);
      }
    });
  </script>

  <!-- HEADER -->
  <header class="bg-secondary text-custom1 px-8 py-4 shadow-md relative flex justify-between items-center"
    style="background: var(--secondary); border-bottom: 1px solid rgba(255,255,255,0.05);">

    <!-- LOGO -->
    <div class="flex items-center space-x-3">
      <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2">
        <!-- Se não tiver logo.png, exibe texto -->
        <span class="text-xl font-bold uppercase tracking-wide"
          style="font-family: var(--font-serif); color: var(--cream);">Trade Expansion</span>
      </a>
    </div>

    <!-- BOTÃO MOBILE -->
    <button id="menu-toggle"
      class="md:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1 focus:outline-none border border-custom1 rounded">
      <span class="block w-6 h-0.5 bg-custom1"></span>
      <span class="block w-6 h-0.5 bg-custom1"></span>
      <span class="block w-6 h-0.5 bg-custom1"></span>
    </button>

    <!-- MENU -->
    <nav id="menu"
      class="hidden md:flex md:space-x-8 flex-col md:flex-row absolute md:static top-full left-0 w-full md:w-auto bg-secondary md:bg-transparent text-center md:text-left md:py-0 py-6 z-40">
      <a href="<?php echo home_url('/sobre'); ?>" class="block md:inline hover:text-accent transition duration-200"
        style="color: var(--text);">Sobre</a>
      <a href="<?php echo home_url('/rochas-ornamentais'); ?>"
        class="block md:inline hover:text-accent transition duration-200" style="color: var(--text);">Rochas</a>
      <a href="<?php echo home_url('/inspecao'); ?>" class="block md:inline hover:text-accent transition duration-200"
        style="color: var(--text);">Inspeção</a>
      <a href="<?php echo home_url('/contato'); ?>" class="block md:inline hover:text-accent transition duration-200"
        style="color: var(--text);">Contato</a>
    </nav>

    <!-- BANDEIRAS -->
    <div class="flex items-center space-x-4 relative z-30">
      <a href="/pt/" title="Português" class="hover:opacity-80 transition">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/br-flag.svg" alt="Português"
          class="w-6 h-6 rounded-full border border-custom1">
      </a>
      <a href="/en/" title="English" class="hover:opacity-80 transition">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/uk-flag.svg" alt="English"
          class="w-6 h-6 rounded-full border border-custom1">
      </a>
    </div>
  </header>

  <!-- SCRIPT DO MENU MOBILE -->
  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    menuToggle.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  </script>