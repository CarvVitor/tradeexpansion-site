<?php get_header(); ?>

<main class="relative h-[90vh] flex flex-col items-center justify-center overflow-hidden">

  <!-- VÍDEO DE FUNDO -->
  <video class="absolute inset-0 w-full h-full object-cover"
         autoplay muted loop playsinline
         poster="<?php echo get_template_directory_uri(); ?>/assets/images/hero-home-fallback.jpg">
    <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero-home.mp4" type="video/mp4">
    Seu navegador não suporta vídeo em background.
  </video>

  <!-- OVERLAY PARA CONTRASTE -->
  <div class="absolute inset-0 bg-primary/60"></div>

  <!-- CONTEÚDO -->
  <div class="relative z-10 text-center px-6 text-custom1">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-wide uppercase">
      Expanda suas fronteiras com a Trade Expansion
    </h1>
    <p class="text-lg md:text-xl max-w-2xl mx-auto mb-8">
      Comércio internacional, exportação de rochas ornamentais e soluções sob medida para o seu crescimento global.
    </p>
    <a href="#contato" class="bg-accent hover:bg-custom1 hover:text-accent text-custom1 font-semibold px-10 py-4 rounded-lg transition duration-300">
      Fale com a gente
    </a>
  </div>
</main>

<!-- SOBRE -->
<section id="sobre" class="bg-custom1 text-secondary py-20 px-6 md:px-20 text-center md:text-left">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-bold mb-6 uppercase tracking-wide">Sobre a Trade Expansion</h2>
    <p class="text-lg leading-relaxed mb-4">
      A <strong>Trade Expansion LTDA</strong> é uma empresa brasileira de comércio exterior especializada na exportação de <strong>rochas ornamentais</strong> e commodities. Atuamos conectando produtores nacionais a compradores internacionais, garantindo qualidade, transparência e eficiência em todas as etapas do processo.
    </p>
    <p class="text-lg leading-relaxed mb-4">
      Nosso diferencial está na experiência operacional e na visão estratégica voltada ao crescimento sustentável dos nossos parceiros, ampliando oportunidades comerciais com solidez e confiança.
    </p>
    <p class="text-lg leading-relaxed">
      Com presença global e atuação direta no Brasil e no exterior, oferecemos soluções personalizadas para cada cliente, de inspeção de produtos à negociação internacional completa.
    </p>
  </div>
</section>

<!-- SERVIÇOS -->
<section id="servicos" class="bg-primary text-custom1 py-20 px-6 md:px-20 text-center">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-4xl font-bold mb-12 uppercase tracking-wide">Nossas Soluções</h2>
    
    <div class="grid md:grid-cols-3 gap-10">
      
      <!-- Card 1 -->
      <div class="bg-secondary rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300">
        <h3 class="text-2xl font-semibold mb-4 text-custom1">Exportação de Rochas Ornamentais</h3>
        <p class="text-custom1/90 leading-relaxed">
          Atuação direta com produtores brasileiros de granito, quartzito e mármore, oferecendo chapas e blocos para importadores em todo o mundo, com controle de qualidade e logística eficiente.
        </p>
      </div>

      <!-- Card 2 -->
      <div class="bg-secondary rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300">
        <h3 class="text-2xl font-semibold mb-4 text-custom1">Intermediação Comercial</h3>
        <p class="text-custom1/90 leading-relaxed">
          Conectamos compradores internacionais e fornecedores nacionais, garantindo negociações seguras, transparentes e sustentáveis para todas as partes envolvidas.
        </p>
      </div>

      <!-- Card 3 -->
      <div class="bg-secondary rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300">
        <h3 class="text-2xl font-semibold mb-4 text-custom1">Serviços de Inspeção</h3>
        <p class="text-custom1/90 leading-relaxed">
          Realizamos inspeções técnicas em rochas ornamentais e commodities, representando empresas estrangeiras com relatórios detalhados e imparciais sobre qualidade e conformidade.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- CONTATO -->
<section id="contato" class="bg-custom1 text-secondary py-20 px-6 md:px-20">
  <div class="max-w-4xl mx-auto text-center">
    <h2 class="text-4xl font-bold mb-8 uppercase tracking-wide">Fale com a gente</h2>
    <p class="text-lg mb-10">
      Envie sua mensagem e entraremos em contato o mais breve possível. 
      Nossa equipe está pronta para atender sua demanda com agilidade e confiança.
    </p>

    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
      
      <div>
        <label for="name" class="block text-sm font-semibold mb-2">Nome</label>
        <input type="text" id="name" name="name" required class="w-full p-3 rounded-lg border border-secondary/20 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
      </div>

      <div>
        <label for="email" class="block text-sm font-semibold mb-2">E-mail</label>
        <input type="email" id="email" name="email" required class="w-full p-3 rounded-lg border border-secondary/20 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent">
      </div>

      <div class="md:col-span-2">
        <label for="message" class="block text-sm font-semibold mb-2">Mensagem</label>
        <textarea id="message" name="message" rows="5" required class="w-full p-3 rounded-lg border border-secondary/20 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent"></textarea>
      </div>

      <div class="md:col-span-2 text-center">
        <button type="submit" class="bg-accent hover:bg-secondary text-custom1 font-semibold px-10 py-4 rounded-lg transition duration-300">
          Enviar mensagem
        </button>
      </div>

    </form>
  </div>
</section>

<!-- FAQ -->
<section id="faq" class="bg-primary text-custom1 py-20 px-6 md:px-20">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold mb-10 uppercase tracking-wide text-center">Perguntas Frequentes</h2>

    <div class="space-y-6">

      <!-- Item 1 -->
      <div class="border-b border-custom1/30 pb-4">
        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none">
          <span class="text-lg font-semibold">O que é acesso a mercados internacionais?</span>
          <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-content hidden mt-3 text-custom1/90 leading-relaxed">
          Refere-se à capacidade de uma empresa vender produtos ou serviços em outro país, de acordo com regras comerciais, tarifas e exigências de conformidade.
        </div>
      </div>

      <!-- Item 2 -->
      <div class="border-b border-custom1/30 pb-4">
        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none">
          <span class="text-lg font-semibold">Como a Trade Expansion auxilia na conformidade comercial?</span>
          <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-content hidden mt-3 text-custom1/90 leading-relaxed">
          Oferecemos orientação sobre certificações, documentação, normas de importação/exportação e requisitos legais, garantindo que sua empresa opere com segurança em novos mercados.
        </div>
      </div>

      <!-- Item 3 -->
      <div class="border-b border-custom1/30 pb-4">
        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none">
          <span class="text-lg font-semibold">A Trade Expansion trabalha apenas com grandes empresas?</span>
          <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-content hidden mt-3 text-custom1/90 leading-relaxed">
          Não. Atuamos também com pequenas e médias empresas B2B que desejam expandir internacionalmente com soluções estratégicas e acessíveis.
        </div>
      </div>

      <!-- Item 4 -->
      <div class="border-b border-custom1/30 pb-4">
        <button class="faq-toggle w-full text-left flex justify-between items-center focus:outline-none">
          <span class="text-lg font-semibold">A Trade Expansion oferece suporte durante todo o processo de exportação?</span>
          <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-content hidden mt-3 text-custom1/90 leading-relaxed">
          Sim. Acompanhamos desde a análise de mercado e estratégia inicial até a documentação, negociações com parceiros e monitoramento de compliance a longo prazo.
        </div>
      </div>

    </div>
  </div>
</section>

<!-- SCRIPT FAQ -->
<script>
  const toggles = document.querySelectorAll('.faq-toggle');
  toggles.forEach(btn => {
    btn.addEventListener('click', () => {
      const content = btn.nextElementSibling;
      const icon = btn.querySelector('svg');
      content.classList.toggle('hidden');
      icon.classList.toggle('rotate-180');
    });
  });
</script>

<?php get_footer(); ?>