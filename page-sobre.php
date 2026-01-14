<?php
/*
Template Name: Sobre Nós
*/
get_header();
?>

<!-- HERO – Sobre Nós -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
  <!-- Fundo (vídeo opcional). Se o arquivo não existir, o gradiente mantém o hero bonito. -->
  <div class="absolute inset-0 bg-gradient-to-b from-primary via-primary/80 to-black"></div>
  <video class="hero-video absolute inset-0 w-full h-full object-cover opacity-35" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
    <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/videos/about-hero.mp4' ); ?>" type="video/mp4" />
  </video>
  <div class="absolute inset-0 bg-primary/55"></div>

  <div class="relative z-10 text-center px-6 text-custom1 max-w-5xl">
    <p class="uppercase tracking-[0.22em] text-custom1/80 text-sm md:text-base mb-4">Inteligência • Intermediação • Inspeção Técnica</p>
    <h1 class="text-5xl md:text-6xl font-bold mb-5 tracking-wide uppercase">Sobre a Trade Expansion</h1>
    <p class="text-lg md:text-xl max-w-3xl mx-auto mb-10 text-custom1/90">
      Operações internacionais com rigor técnico, documentação impecável e transparência total — do fornecedor ao desembarque.
    </p>

    <div class="grid md:grid-cols-3 gap-4 md:gap-6 text-left">
      <div class="bg-black/25 border border-custom1/10 rounded-2xl p-5 backdrop-blur-sm">
        <p class="uppercase tracking-[0.18em] text-xs text-custom1/70 mb-2">Rigor Técnico</p>
        <p class="text-custom1/90 leading-relaxed">Inspeções com critérios objetivos de aceite, registro fotográfico e evidências por lote.</p>
      </div>
      <div class="bg-black/25 border border-custom1/10 rounded-2xl p-5 backdrop-blur-sm">
        <p class="uppercase tracking-[0.18em] text-xs text-custom1/70 mb-2">Transparência Total</p>
        <p class="text-custom1/90 leading-relaxed">Status claro, checkpoints e relatórios que reduzem ruído, disputa e retrabalho.</p>
      </div>
      <div class="bg-black/25 border border-custom1/10 rounded-2xl p-5 backdrop-blur-sm">
        <p class="uppercase tracking-[0.18em] text-xs text-custom1/70 mb-2">Segurança Operacional</p>
        <p class="text-custom1/90 leading-relaxed">Intermediação com gestão de risco: prazos, conformidade e previsibilidade na entrega.</p>
      </div>
    </div>
  </div>
</section>

<!-- MISSÃO • VISÃO • VALORES -->
<section class="bg-custom1 text-secondary py-20 px-6 md:px-20">
  <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-10 text-center">
    <div class="p-6">
      <h3 class="text-2xl font-semibold mb-4">Nossa Missão</h3>
      <p class="leading-relaxed text-secondary/90">
        Entregar operações internacionais com evidência, previsibilidade e rastreabilidade — conectando fornecedores e compradores com confiança técnica.
      </p>
    </div>
    <div class="p-6">
      <h3 class="text-2xl font-semibold mb-4">Nossa Visão</h3>
      <p class="leading-relaxed text-secondary/90">
        Ser a referência em operações de rochas ornamentais e commodities onde cada etapa é verificável: do embarque ao aceite final.
      </p>
    </div>
    <div class="p-6">
      <h3 class="text-2xl font-semibold mb-4">Nossos Valores</h3>
      <p class="leading-relaxed text-secondary/90">
        Disciplina técnica, transparência radical, documentação impecável e respeito ao que sustenta negócios duradouros: reputação e entrega.
      </p>
    </div>
  </div>
</section>

<!-- DIVISOR VISUAL (Prova) -->
<section class="bg-primary py-14">
  <div class="max-w-6xl mx-auto px-6 md:px-20">
    <div class="rounded-3xl overflow-hidden border border-custom1/10 bg-black/20">
      <div class="p-8 md:p-10">
        <p class="uppercase tracking-[0.22em] text-custom1/70 text-xs md:text-sm">O que muda quando há transparência</p>
        <h2 class="text-3xl md:text-4xl font-bold tracking-wide uppercase text-custom1 mt-3">Menos disputa. Mais previsibilidade.</h2>
        <p class="text-custom1/85 mt-4 max-w-3xl leading-relaxed">
          Em operações internacionais, o risco quase sempre nasce do “achismo”. A Trade Expansion opera com evidência: critérios, fotos, checkpoints e relatórios que deixam o processo claro para todas as partes.
        </p>
      </div>
      <div class="grid md:grid-cols-3 gap-px bg-custom1/10">
        <div class="bg-primary/70 p-6 md:p-8">
          <p class="uppercase tracking-[0.18em] text-custom1/70 text-xs mb-2">Checkpoint</p>
          <p class="text-custom1/90 leading-relaxed">Confirmações em etapas — sem “surpresa” no final.</p>
        </div>
        <div class="bg-primary/70 p-6 md:p-8">
          <p class="uppercase tracking-[0.18em] text-custom1/70 text-xs mb-2">Evidência</p>
          <p class="text-custom1/90 leading-relaxed">Relatórios objetivos e registro fotográfico por lote.</p>
        </div>
        <div class="bg-primary/70 p-6 md:p-8">
          <p class="uppercase tracking-[0.18em] text-custom1/70 text-xs mb-2">Rastreabilidade</p>
          <p class="text-custom1/90 leading-relaxed">Histórico claro para auditoria, qualidade e aceite.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HISTÓRIA -->
<section class="py-20 px-6 md:px-20">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-bold mb-8 uppercase tracking-wide text-primary text-center">Nossa História</h2>

    <div class="grid md:grid-cols-2 gap-10 items-start">
      <div>
        <p class="text-lg leading-relaxed mb-4">
          A Trade Expansion nasceu no Brasil, no coração de um setor onde reputação vale mais que slogan. Começamos com rochas ornamentais — e aprendemos cedo que o que sustenta uma operação não é só preço: é critério, controle e documentação.
        </p>
        <p class="text-lg leading-relaxed mb-4">
          Ao longo do tempo, evoluímos para um modelo que une inteligência comercial, intermediação e inspeção técnica — para reduzir risco e aumentar previsibilidade em operações internacionais.
        </p>
        <p class="text-lg leading-relaxed">
          Hoje, nossa assinatura é simples: cada etapa precisa ser verificável. Quando o processo é claro, o negócio flui.
        </p>
      </div>

      <div class="bg-custom1 rounded-3xl border border-primary/10 p-8">
        <h3 class="text-2xl font-semibold text-primary mb-5">Como trabalhamos</h3>
        <ol class="space-y-4 text-secondary/90">
          <li class="flex gap-4">
            <span class="mt-1 h-6 w-6 rounded-full bg-primary text-custom1 flex items-center justify-center text-xs font-bold">1</span>
            <div>
              <p class="font-semibold text-secondary">Alinhamento técnico</p>
              <p class="leading-relaxed">Especificação, tolerâncias, padrões de qualidade e critérios de aceite.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <span class="mt-1 h-6 w-6 rounded-full bg-primary text-custom1 flex items-center justify-center text-xs font-bold">2</span>
            <div>
              <p class="font-semibold text-secondary">Evidência em campo</p>
              <p class="leading-relaxed">Inspeção e registro fotográfico — sem “caixa preta”.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <span class="mt-1 h-6 w-6 rounded-full bg-primary text-custom1 flex items-center justify-center text-xs font-bold">3</span>
            <div>
              <p class="font-semibold text-secondary">Logística e checkpoints</p>
              <p class="leading-relaxed">Acompanhamento por etapas: fábrica → packing → embarque → desembarque.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <span class="mt-1 h-6 w-6 rounded-full bg-primary text-custom1 flex items-center justify-center text-xs font-bold">4</span>
            <div>
              <p class="font-semibold text-secondary">Relatório final</p>
              <p class="leading-relaxed">Consolidação técnica para reduzir disputa e aumentar confiança na recompra.</p>
            </div>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>