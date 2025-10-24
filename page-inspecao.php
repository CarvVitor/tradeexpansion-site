<?php
/*
Template Name: Inspeção Técnica
*/
get_header();
?>

<!-- HERO | Inspeção -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
  <div class="absolute inset-0 bg-primary/70"></div>
  <div class="relative z-10 text-center px-6 text-custom1">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-wide uppercase">
      Inspeção de Rochas com Precisão Global
    </h1>
    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
      Relatórios técnicos especializados, auditoria in-loco e suporte completo para exportações internacionais.
    </p>
    <a href="#contato" class="bg-accent hover:bg-custom1 hover:text-accent text-custom1 font-semibold px-10 py-4 rounded-lg transition duration-300">
      Fale com especialista
    </a>
  </div>
</section>

<!-- PROCESSO DE INSPEÇÃO -->
<section id="processo" class="bg-custom1 text-secondary py-20 px-6 md:px-20">
  <div class="max-w-6xl mx-auto mb-12 text-center">
    <h2 class="text-4xl font-bold uppercase tracking-wide">Nosso Processo</h2>
    <p class="text-lg leading-relaxed text-secondary/80 mt-4">
      Cada etapa é conduzida com método, tecnologia e transparência para garantir qualidade e segurança.
    </p>
  </div>
  <div class="space-y-10">
    <div class="flex flex-col md:flex-row items-center gap-8">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inspecao-1.jpg" alt="Auditoria de campo" class="w-full md:w-1/2 rounded-lg shadow-lg">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-semibold mb-2">Auditoria de Campo</h3>
        <p class="leading-relaxed text-secondary/90">
          Nossa equipe visita a extração, documenta em vídeo e foto e prepara relatório preliminar.
        </p>
      </div>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-8">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inspecao-2.jpg" alt="Análise laboratorial" class="w-full md:w-1/2 rounded-lg shadow-lg">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-semibold mb-2">Análise Laboratorial</h3>
        <p class="leading-relaxed text-secondary/90">
          Inspeção técnica com equipamentos de ponta, medição de integridade e preparação para exportação.
        </p>
      </div>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-8">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inspecao-3.jpg" alt="Relatório de conformidade" class="w-full md:w-1/2 rounded-lg shadow-lg">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-semibold mb-2">Relatório de Conformidade</h3>
        <p class="leading-relaxed text-secondary/90">
          Entrega de relatório completo, acompanhamento de logística e suporte pós-venda para exportadores internacionais.
        </p>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>