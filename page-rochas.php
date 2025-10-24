<?php
/*
Template Name: Rochas Ornamentais
*/
get_header();
?>

<!-- HERO VIDEO com fallback imagem -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
  <video class="absolute top-0 left-0 w-full h-full object-cover" autoplay muted loop playsinline poster="<?php echo get_template_directory_uri(); ?>/assets/images/hero-rochas-fallback.jpg">
    <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero-rochas.mp4" type="video/mp4">
    <!-- se quiser incluir webm -->
    <!-- <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero-rochas.webm" type="video/webm"> -->
    Seu navegador não suporta vídeo de fundo.
  </video>
  <div class="absolute inset-0 bg-primary/70"></div>
  <div class="relative z-10 text-center px-6 text-custom1">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-wide uppercase">
      Rochas Ornamentais de Excelência
    </h1>
    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
      Conectando materiais brasileiros premium a projetos globais com logística e qualidade técnica.
    </p>
    <a href="#catalogo" class="bg-accent hover:bg-custom1 hover:text-accent text-custom1 font-semibold px-10 py-4 rounded-lg transition duration-300">
      Veja nosso catálogo
    </a>
  </div>
</section>

<!-- CATEGORIAS DE MATERIAIS -->
<section id="categorias" class="bg-custom1 text-secondary py-20 px-6 md:px-20">
  <div class="max-w-6xl mx-auto text-center mb-12">
    <h2 class="text-4xl font-bold uppercase tracking-wide">Nossas Categorias</h2>
    <p class="text-lg leading-relaxed text-secondary/80 mt-4">
      Explorar nossos materiais principais com qualidade, procedência e entrega global.
    </p>
  </div>
  <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
    <div class="group">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/marmores.jpg" alt="Mármores" class="w-full h-auto rounded-lg shadow-lg group-hover:scale-105 transition duration-300">
      <h3 class="mt-4 text-2xl font-semibold">Mármores</h3>
    </div>
    <div class="group">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/granitos.jpg" alt="Granitos" class="w-full h-auto rounded-lg shadow-lg group-hover:scale-105 transition duration-300">
      <h3 class="mt-4 text-2xl font-semibold">Granitos</h3>
    </div>
    <div class="group">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/quartzitos.jpg" alt="Quartzitos" class="w-full h-auto rounded-lg shadow-lg group-hover:scale-105 transition duration-300">
      <h3 class="mt-4 text-2xl font-semibold">Quartzitos</h3>
    </div>
    <div class="group">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/quartzos.jpg" alt="Quartzos" class="w-full h-auto rounded-lg shadow-lg group-hover:scale-105 transition duration-300">
      <h3 class="mt-4 text-2xl font-semibold">Quartzos</h3>
    </div>
  </div>
</section>

<!-- CATÁLOGO / DOWNLOAD -->
<section id="catalogo" class="bg-secondary text-custom1 py-20 px-6 md:px-20 text-center">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold mb-6 uppercase tracking-wide">Catálogo Premium</h2>
    <p class="text-lg leading-relaxed mb-8">
      Faça download de nossos materiais e amostras em alta resolução e explore nossa linha completa de rochas ornamentais.
    </p>
    <a href="<?php echo get_template_directory_uri(); ?>/assets/docs/catalogo-rochas.pdf" download class="bg-accent hover:bg-custom1 hover:text-accent text-custom1 font-semibold px-10 py-4 rounded-lg transition duration-300">
      Baixar catálogo
    </a>
  </div>
</section>

<?php get_footer(); ?>