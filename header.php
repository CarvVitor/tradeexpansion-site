<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">

  <!-- Título dinâmico -->
  <title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>

  <!-- Fonte Vollkorn -->
  <link href="https://fonts.googleapis.com/css2?family=Vollkorn:wght@400;600;700&display=swap" rel="stylesheet">

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
  <header class="bg-secondary text-custom1 px-8 py-4 shadow-md relative flex justify-between items-center">

    <!-- LOGO -->
    <div class="flex items-center space-x-3">
      <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Trade Expansion" class="h-10 w-auto">
        <span class="text-xl font-bold uppercase tracking-wide">Trade Expansion</span>
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
      <a href="#sobre" class="block md:inline hover:text-accent transition duration-200">Sobre</a>
      <a href="#servicos" class="block md:inline hover:text-accent transition duration-200">Serviços</a>
      <a href="#contato" class="block md:inline hover:text-accent transition duration-200">Contato</a>
      <a class="z-20">
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
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    menuToggle.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  </script>