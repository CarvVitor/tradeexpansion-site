<?php
/*
Template Name: Sobre Nós
*/
get_header();
?>

<style>
  /* Estilos Exclusivos Sobre Nós */
  .about-hero {
    height: 80vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 0 10%;
  }

  .about-bg-video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translate(-50%, -50%);
    z-index: -1;
    filter: brightness(0.4) saturate(0);
  }

  .timeline-section {
    padding: 100px 0;
    position: relative;
    background: #080808;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: rgba(255, 255, 255, 0.1);
    /* Lines */
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin: 60px 0;
  }

  .stat-box {
    background: #0a1f1c;
    /* match body bg */
    padding: 40px 20px;
    text-align: center;
  }

  .paperless-highlight {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 60px;
    max-width: 1200px;
    margin: 100px auto;
    padding: 0 20px;
  }

  @media (max-width: 900px) {
    .stats-grid {
      grid-template-columns: 1fr 1fr;
    }

    .paperless-highlight {
      grid-template-columns: 1fr;
    }
  }
</style>

<main>

  <!-- HERO NARRATIVO -->
  <section class="about-hero">
    <video class="about-bg-video" autoplay muted loop playsinline>
      <!-- Fallback to image if video not present, handled by CSS mostly but good to preserve structure -->
      <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero-home.mp4" type="video/mp4">
    </video>

    <div class="fade-up" style="max-width: 800px; padding-left: 20px; border-left: 4px solid var(--gold);">
      <h1 style="font-size: clamp(3rem, 6vw, 5rem); line-height: 1.1; margin-bottom: 30px;">
        Comprometidos com a precisão, <br>
        <span style="color: var(--gold);">movidos pela confiança.</span>
      </h1>
      <p style="font-size: 1.2rem; color: rgba(255,255,255,0.8); max-width: 600px;">
        Não somos apenas intermediários. Somos o seu braço técnico e estratégico no Brasil, garantindo que a distância
        física não signifique perda de controle.
      </p>
    </div>
  </section>

  <!-- DNA "PAPERLESS" & TECH -->
  <section class="paperless-highlight">
    <div class="fade-up">
      <h2 style="font-size: 2.5rem; margin-bottom: 20px;">A Evolução Paperless</h2>
      <p style="font-size: 1.1rem; margin-bottom: 20px; color: #ccc;">
        O comércio exterior tradicional é afogado em papel, e-mails perdidos e informações desencontradas. Nós nascemos
        para mudar isso.
      </p>
      <p style="font-size: 1.1rem; color: #ccc;">
        Na Trade Expansion, sua operação é digital de ponta a ponta. Do momento da inspeção na pedreira até a emissão do
        BL, tudo flui através de nosso ecossistema conectado. Menos burocracia, mais velocidade e rastreabilidade total.
      </p>
    </div>
    <div class="glass-panel fade-up delay-200"
      style="height: 400px; border-radius: 12px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
      <!-- Abstract Representation of Data Flow -->
      <div
        style="position: absolute; inset: 0; background: linear-gradient(45deg, transparent 40%, rgba(201, 169, 97, 0.1) 100%);">
      </div>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" alt="Icon"
        style="width: 80px; opacity: 0.8; filter: drop-shadow(0 0 20px var(--gold));">
      <div
        style="position: absolute; bottom: 30px; left: 30px; font-family: monospace; color: var(--gold); font-size: 0.8rem;">
        > SYSTEM_STATUS: ONLINE<br>
        > INSPECTION_NODE: ACTIVE<br>
        > PAPER_USAGE: 0%
      </div>
    </div>
  </section>

  <!-- STATS GRID -->
  <section class="fade-up" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="stats-grid">
      <div class="stat-box">
        <div class="text-gradient" style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">15+</div>
        <span style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; color: #888;">Anos de
          Expertise</span>
      </div>
      <div class="stat-box">
        <div class="text-gradient" style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">40k</div>
        <span style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; color: #888;">m²
          Inspecionados/Mês</span>
      </div>
      <div class="stat-box">
        <div class="text-gradient" style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">100%</div>
        <span style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; color: #888;">Digital
          Compliance</span>
      </div>
      <div class="stat-box">
        <div class="text-gradient" style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">0</div>
        <span style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; color: #888;">Incerteza</span>
      </div>
    </div>
  </section>

  <!-- CTA FOOTER -->
  <section
    style="text-align: center; padding: 100px 20px; background: radial-gradient(circle at center, #1a3a35 0%, #0a1f1c 70%);">
    <h2 style="font-size: 2rem; margin-bottom: 30px;">Faça parte da nova era do comércio exterior.</h2>
    <a href="<?php echo home_url('/contato'); ?>" class="btn-primary">Fale com a Diretoria</a>
  </section>

</main>

<?php get_footer(); ?>