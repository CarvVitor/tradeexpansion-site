<?php
/**
 * Template Name: Inspeção Técnica
 * Description: Página de Processo de Inspeção v2.0
 */

get_header();
?>

<style>
  /* Processo em Steps Verticais com linha conectora (Desktop) */
  .process-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    position: relative;
    padding: 60px 20px;
  }

  .process-line {
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(-50%);
  }

  .step-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 100px;
    position: relative;
  }

  .step-row:last-child {
    margin-bottom: 0;
  }

  .step-content {
    width: 45%;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 8px;
    position: relative;
  }

  .step-content h3 {
    color: var(--gold);
    font-size: 1.5rem;
    margin-bottom: 15px;
  }

  .step-marker {
    width: 50px;
    height: 50px;
    background: var(--secondary);
    border: 2px solid var(--gold);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: var(--gold);
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 0 20px rgba(201, 169, 97, 0.2);
    z-index: 2;
  }

  .step-image {
    width: 45%;
    height: 250px;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
  }

  .step-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: grayscale(100%);
    transition: filter 0.5s ease;
  }

  .step-row:hover .step-image img {
    filter: grayscale(0%);
  }

  /* Alternar lados */
  .step-row:nth-child(even) {
    flex-direction: row-reverse;
  }

  /* Responsivo */
  @media (max-width: 768px) {
    .process-line {
      left: 20px;
    }

    .step-marker {
      left: 20px;
      width: 40px;
      height: 40px;
      font-size: 0.9rem;
    }

    .step-row {
      flex-direction: column;
      align-items: flex-start;
      margin-left: 50px;
      margin-bottom: 60px;
    }

    .step-row:nth-child(even) {
      flex-direction: column;
    }

    .step-content,
    .step-image {
      width: 100%;
    }

    .step-image {
      height: 200px;
      margin-bottom: 20px;
      order: -1;
    }
  }
</style>

<main>

  <!-- HEADER SIMPLES (Tipografia Forte) -->
  <section
    style="padding: 120px 20px 80px; text-align: center; background: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg-texture-dark.png');">
    <div class="fade-up" style="max-width: 800px; margin: 0 auto;">
      <h1 style="font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 20px;">
        Relatórios detalhados.<br>
        <span style="color: var(--gold);">Incerteza zero.</span>
      </h1>
      <p style="font-size: 1.15rem; color: rgba(255,255,255,0.8); line-height: 1.8;">
        Nosso processo de inspeção segue padrões globais rigorosos. Fornecemos fotos em alta resolução, análises
        laboratoriais e medições precisas, tudo acessível via portal exclusivo.
      </p>
    </div>
  </section>

  <!-- PROCESSO V2 -->
  <section style="background: linear-gradient(180deg, #0a1f1c 0%, var(--secondary) 100%); padding-bottom: 100px;">
    <div class="process-wrapper">
      <div class="process-line"></div>

      <!-- Passo 1 -->
      <div class="step-row fade-up">
        <div class="step-content">
          <h3>01. Auditoria no Local</h3>
          <p>Nossos inspetores vão até a "boca da mina" ou ao pátio da fábrica. Verificamos as condições de
            armazenamento, estrutura da empresa e conformidade dos equipamentos de beneficiamento.</p>
        </div>
        <div class="step-marker">01</div>
        <div class="step-image">
          <!-- Placeholder premium -->
          <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800" alt="Auditoria">
        </div>
      </div>

      <!-- Passo 2 -->
      <div class="step-row fade-up delay-100">
        <div class="step-content">
          <h3>02. Coleta de Dados e Fotos</h3>
          <p>Via aplicativo proprietário, registramos cada chapa com fotos de alta resolução, medimos espessura real e
            marcamos imperfeições visíveis e invisíveis (via testes de absorção).</p>
        </div>
        <div class="step-marker">02</div>
        <div class="step-image">
          <img src="https://images.unsplash.com/photo-1581093588401-fbb0777e132c?w=800" alt="Coleta Digital">
        </div>
      </div>

      <!-- Passo 3 -->
      <div class="step-row fade-up delay-200">
        <div class="step-content">
          <h3>03. Geração de Relatório Digital</h3>
          <p>Os dados são compilados instantaneamente em nosso dashboard. Você recebe um link seguro para visualizar o
            "Raio-X" do lote, aprovando ou reprovando itens individualmente.</p>
        </div>
        <div class="step-marker">03</div>
        <div class="step-image">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800" alt="Dashboard Report">
        </div>
      </div>

      <!-- Passo 4 -->
      <div class="step-row fade-up delay-300">
        <div class="step-content">
          <h3>04. Liberação Logística Segura</h3>
          <p>Apenas após sua aprovação digital o lote é liberado para estufagem. Acompanhamos o carregamento para
            garantir que o material aprovado seja o material embarcado.</p>
        </div>
        <div class="step-marker">04</div>
        <div class="step-image">
          <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800" alt="Logistica">
        </div>
      </div>

    </div>
  </section>

  <!-- FINAL CTA -->
  <section class="glass-panel-dark"
    style="margin: 0 auto; max-width: 1200px; padding: 60px; text-align: center; border-radius: 12px; margin-bottom: 80px;">
    <h2 style="font-size: 2rem;">Não deixe sua operação no escuro.</h2>
    <p style="max-width: 600px; margin: 0 auto 30px;">Solicite um modelo de relatório e veja o nível de detalhe que
      entregamos.</p>
    <a href="<?php echo home_url('/contato'); ?>" class="btn-primary">Ver Modelo de Relatório</a>
  </section>

</main>

<?php get_footer(); ?>