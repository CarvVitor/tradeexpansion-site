<?php
/**
 * Template Name: Inspeção Técnica
 * Description: Página institucional de Inspeção Técnica de Rochas Ornamentais
 */

get_header();

$hero_video = get_theme_file_uri('assets/videos/inspection-hero.mp4');
$hero_img   = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg'); // fallback
$whatsapp   = 'https://wa.me/5527999999999';
?>

<style>
:root {
  --secondary: #102724;
  --cream: #F1F1D9;
  --text: #E1E2DA;
  --ink: #1D1F1E;
  --gold: #D6A354;
}

.te-inspecao {
  font-family: 'Vollkorn', Georgia, serif;
  color: var(--ink);
  overflow-x: hidden;
}

.te-inspecao section {
  position: relative;
  clear: both;
  width: 100%;
}

/* HERO */
.te-hero {
  position: relative;
  height: 100vh;
  min-height: 640px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: var(--secondary);
}

.te-hero__glow {
  position: absolute;
  inset: 0;
  background: radial-gradient(1000px 520px at 50% 15%, rgba(214,163,84,0.18), transparent 60%);
  pointer-events: none;
}

.te-hero__video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translate(-50%, -50%) scale(1.1);
  object-fit: cover;
  opacity: 0.22;
  will-change: transform;
}

.te-hero__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.14;
}

.te-hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(16,39,36,0.35) 0%, rgba(16,39,36,0.78) 55%, rgba(16,39,36,1) 100%);
}

.te-hero__content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 0 1.5rem;
  max-width: 1100px;
  color: var(--cream);
}

.te-kicker {
  display: inline-flex;
  align-items: center;
  gap: .6rem;
  padding: .75rem 1.1rem;
  border-radius: 9999px;
  border: 1px solid rgba(214,163,84,0.35);
  background: rgba(0,0,0,0.18);
  backdrop-filter: blur(10px);
  text-transform: uppercase;
  letter-spacing: 0.22em;
  font-size: .78rem;
  color: rgba(241,241,217,0.92);
  margin-bottom: 1.25rem;
}

.te-kicker__dot {
  width: .5rem;
  height: .5rem;
  border-radius: 9999px;
  background: var(--gold);
}

.te-hero__title {
  font-size: clamp(2.8rem, 7vw, 4.8rem);
  font-weight: 600;
  letter-spacing: 0.03em;
  line-height: 1.05;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

.te-hero__subtitle {
  font-size: clamp(1.05rem, 2.2vw, 1.5rem);
  color: rgba(225,226,218,0.92);
  font-weight: 400;
  letter-spacing: 0.04em;
  margin: 0 auto 2.2rem;
  max-width: 760px;
  line-height: 1.6;
}

.te-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .6rem;
  padding: 1rem 1.6rem;
  border-radius: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
  letter-spacing: 0.04em;
}

.te-btn--primary {
  background: var(--gold);
  color: var(--secondary);
  border: 1px solid rgba(214,163,84,0.55);
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}

.te-btn--primary:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.85);
}

.te-btn--ghost {
  background: rgba(0,0,0,0.18);
  color: var(--cream);
  border: 1px solid rgba(241,241,217,0.2);
}

.te-btn--ghost:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.55);
}

.te-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: .8rem;
  justify-content: center;
}

.te-scroll {
  position: absolute;
  bottom: 1.4rem;
  left: 50%;
  transform: translateX(-50%);
  color: rgba(241,241,217,0.75);
  text-transform: uppercase;
  letter-spacing: 0.28em;
  font-size: .72rem;
  display: flex;
  align-items: center;
  gap: .6rem;
  z-index: 2;
}

.te-scroll__bar {
  width: 22px;
  height: 36px;
  border: 1px solid rgba(241,241,217,0.35);
  border-radius: 9999px;
  position: relative;
}

.te-scroll__dot {
  width: 6px;
  height: 6px;
  background: rgba(214,163,84,0.9);
  border-radius: 9999px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  top: 8px;
  animation: teScroll 1.2s ease-in-out infinite;
}

@keyframes teScroll {
  0%, 100% { transform: translateX(-50%) translateY(0); opacity: .9; }
  50% { transform: translateX(-50%) translateY(10px); opacity: .35; }
}

/* SEÇÕES */
.te-band--cream {
  background: linear-gradient(180deg, var(--cream) 0%, #E5E5D5 100%);
}

.te-band--green {
  background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%);
  color: var(--text);
}

.te-wrap {
  max-width: 1400px;
  margin: 0 auto;
  padding: 5.5rem 1.5rem;
}

.te-center {
  text-align: center;
}

.te-h2 {
  font-size: clamp(2.2rem, 4vw, 3.4rem);
  font-weight: 600;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  margin: .8rem 0 1.2rem;
}

.te-p {
  font-size: 1.08rem;
  line-height: 1.8;
  opacity: .9;
  max-width: 860px;
  margin: 0 auto;
}

.te-grid-3 {
  margin-top: 3.2rem;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.4rem;
}

.te-card {
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(241,241,217,0.12);
  border-radius: 16px;
  padding: 2.2rem 1.8rem;
  backdrop-filter: blur(10px);
  transition: transform .2s ease, border-color .2s ease;
}

.te-card:hover {
  transform: translateY(-6px);
  border-color: rgba(214,163,84,0.35);
}

.te-card h3 {
  margin: 0 0 .7rem;
  font-size: 1.25rem;
  letter-spacing: .03em;
  color: var(--cream);
}

.te-card p {
  margin: 0;
  opacity: .86;
  line-height: 1.75;
}

.te-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2.4rem;
  align-items: center;
  margin-top: 3rem;
}

.te-img {
  width: 100%;
  height: 560px;
  border-radius: 18px;
  overflow: hidden;
  border: 1px solid rgba(214,163,84,0.18);
  box-shadow: 0 22px 80px rgba(0,0,0,0.35);
}

.te-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.te-steps {
  margin-top: 3rem;
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 1rem;
}

.te-step {
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(241,241,217,0.12);
  border-radius: 16px;
  padding: 1.6rem 1.2rem;
  text-align: center;
}

.te-step__n {
  font-size: 2.4rem;
  font-weight: 700;
  color: rgba(214,163,84,0.75);
  margin-bottom: .2rem;
}

.te-step h4 {
  margin: .2rem 0 .5rem;
  color: var(--cream);
  font-size: 1.05rem;
}

.te-step p {
  margin: 0;
  opacity: .86;
  line-height: 1.65;
  font-size: .98rem;
}

/* FORM */
.te-form {
  max-width: 880px;
  margin: 0 auto;
  margin-top: 2.6rem;
  text-align: left;
  background: rgba(241,241,217,0.95);
  border-radius: 18px;
  padding: 2.2rem;
  border: 1px solid rgba(214,163,84,0.18);
  box-shadow: 0 22px 80px rgba(0,0,0,0.25);
  color: var(--secondary);
}

.te-form label {
  display: block;
  font-weight: 700;
  letter-spacing: .02em;
  margin: 0 0 .35rem;
}

.te-form input,
.te-form textarea {
  width: 100%;
  padding: 1rem 1rem;
  border-radius: 12px;
  border: 1px solid rgba(16,39,36,0.18);
  background: rgba(255,255,255,0.9);
  font-family: 'Vollkorn', Georgia, serif;
  font-size: 1rem;
  outline: none;
}

.te-form input:focus,
.te-form textarea:focus {
  border-color: rgba(214,163,84,0.5);
  box-shadow: 0 0 0 3px rgba(214,163,84,0.18);
}

.te-form__grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.te-form__row {
  margin-bottom: 1rem;
}

.te-form__actions {
  display: flex;
  flex-wrap: wrap;
  gap: .8rem;
  margin-top: .8rem;
}

/* LOADER (frosted) */
#te-loader {
  position: fixed;
  inset: 0;
  background: rgba(241,241,217,0.92);
  backdrop-filter: blur(8px);
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .8s ease, visibility .8s ease;
}

#te-loader .te-loader__inner {
  text-align: center;
}

#te-loader .te-loader__spin {
  width: 54px;
  height: 54px;
  border: 2px solid rgba(16,39,36,0.22);
  border-top-color: rgba(214,163,84,0.95);
  border-radius: 9999px;
  animation: teSpin 1s linear infinite;
  margin: 0 auto 1rem;
}

#te-loader .te-loader__txt {
  font-size: .85rem;
  letter-spacing: .3em;
  text-transform: uppercase;
  color: rgba(16,39,36,0.82);
}

@keyframes teSpin {
  to { transform: rotate(360deg); }
}

/* FLOATING CTA */
#te-floating {
  position: fixed;
  bottom: 1.6rem;
  right: 1.6rem;
  z-index: 9000;
  opacity: 0;
  transform: translateY(16px);
  transition: all .35s ease;
  pointer-events: none;
}

#te-floating a {
  pointer-events: auto;
  display: inline-flex;
  align-items: center;
  gap: .7rem;
  padding: .95rem 1.3rem;
  border-radius: 9999px;
  background: linear-gradient(135deg, rgba(214,163,84,0.98) 0%, rgba(214,163,84,0.78) 100%);
  color: var(--secondary);
  text-decoration: none;
  font-weight: 800;
  letter-spacing: .03em;
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}

#te-floating a:hover {
  transform: translateY(-2px);
}

@media (max-width: 1024px) {
  .te-grid-3 { grid-template-columns: 1fr; }
  .te-grid-2 { grid-template-columns: 1fr; }
  .te-img { height: 420px; }
  .te-steps { grid-template-columns: 1fr; }
  .te-form__grid { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
  #te-floating a span { display: none; }
}
</style>

<div class="te-inspecao">

  <!-- LOADER -->
  <div id="te-loader" aria-hidden="true">
    <div class="te-loader__inner">
      <div class="te-loader__spin"></div>
      <div class="te-loader__txt">Validando documentação…</div>
    </div>
  </div>

  <!-- HERO -->
  <section class="te-hero">
    <div class="te-hero__glow" aria-hidden="true"></div>

    <video class="te-hero__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
      <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4" />
    </video>

    <img class="te-hero__img" src="<?php echo esc_url($hero_img); ?>" alt="" aria-hidden="true" />

    <div class="te-hero__overlay" aria-hidden="true"></div>

    <div class="te-hero__content">
      <div class="te-kicker"><span class="te-kicker__dot"></span> Inspeção Técnica • Relatório Fotográfico • Checklist</div>
      <h1 class="te-hero__title">Inspeção Técnica de Rochas</h1>
      <p class="te-hero__subtitle">
        Seja seus olhos no Brasil: critérios objetivos de aceite, evidência por lote e transparência total antes do embarque.
      </p>
      <div class="te-hero__actions">
        <a class="te-btn te-btn--primary" href="#contato">Solicitar Inspeção</a>
        <a class="te-btn te-btn--ghost" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">Falar no WhatsApp</a>
      </div>
    </div>

    <div class="te-scroll" aria-hidden="true">
      <div class="te-scroll__bar"><div class="te-scroll__dot"></div></div>
      <span>Desça</span>
    </div>
  </section>

  <!-- NÚMEROS -->
  <section class="te-band--cream">
    <div class="te-wrap te-center">
      <p class="te-kicker" style="background: rgba(16,39,36,0.06); border-color: rgba(16,39,36,0.15); color: rgba(16,39,36,0.85);">
        <span class="te-kicker__dot"></span> Rigor técnico em escala
      </p>
      <h2 class="te-h2" style="color: var(--secondary);">Confiança se constrói com evidência</h2>
      <p class="te-p" style="color: rgba(16,39,36,0.85);">Relatórios claros, fotos por lote e inspeção alinhada ao que o seu cliente realmente aceita.</p>

      <div class="te-grid-3" style="margin-top:2.4rem;">
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);">Tempo</h3>
          <p>Relatório em 24–48h, com fotos e checklist.</p>
        </div>
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);">Critério</h3>
          <p>Aceite por tolerância: metragem, acabamento, padrão e lote.</p>
        </div>
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);">Transparência</h3>
          <p>Você decide com base em prova, não em promessa.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- O QUE É -->
  <section class="te-band--green">
    <div class="te-wrap">
      <div class="te-grid-2">
        <div>
          <p class="te-kicker"><span class="te-kicker__dot"></span> Seu padrão, nosso método</p>
          <h2 class="te-h2">Seu parceiro estratégico no Brasil</h2>
          <p class="te-p" style="margin:0; max-width: 760px;">
            A Trade Expansion atua com inspeção técnica, intermediação e inteligência de mercado para operações internacionais de rochas ornamentais.
            Nosso trabalho reduz disputa pós-embarque e aumenta previsibilidade no aceite.
          </p>
          <div class="te-hero__actions" style="justify-content:flex-start; margin-top: 1.6rem;">
            <a class="te-btn te-btn--ghost" href="#processo">Ver o processo</a>
          </div>
        </div>
        <div class="te-img">
          <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=1200&q=80&auto=format&fit=crop" alt="Inspeção técnica de rochas" />
        </div>
      </div>
    </div>
  </section>

  <!-- PROCESSO -->
  <section id="processo" class="te-band--green">
    <div class="te-wrap te-center" style="padding-top: 0;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> Metodologia</p>
      <h2 class="te-h2">Processo objetivo, sem achismo</h2>
      <p class="te-p">Do alinhamento de especificação ao relatório final: tudo rastreável.</p>

      <div class="te-steps">
        <div class="te-step">
          <div class="te-step__n">01</div>
          <h4>Brief técnico</h4>
          <p>Especificações, tolerâncias e padrão de aceite.</p>
        </div>
        <div class="te-step">
          <div class="te-step__n">02</div>
          <h4>Inspeção in loco</h4>
          <p>Pedreira, fábrica ou porto, conforme etapa.</p>
        </div>
        <div class="te-step">
          <div class="te-step__n">03</div>
          <h4>Checklist + fotos</h4>
          <p>Registro por lote, ângulos e detalhes críticos.</p>
        </div>
        <div class="te-step">
          <div class="te-step__n">04</div>
          <h4>Relatório</h4>
          <p>Conclusões e recomendações em 24–48h.</p>
        </div>
        <div class="te-step">
          <div class="te-step__n">05</div>
          <h4>Suporte</h4>
          <p>Apoio na decisão e follow-up com fornecedor.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- BENEFÍCIOS -->
  <section class="te-band--green">
    <div class="te-wrap te-center" style="padding-top: 0;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> Benefícios</p>
      <h2 class="te-h2">Por que a Trade Expansion</h2>
      <p class="te-p">O que você ganha quando troca “fé” por “prova”.</p>

      <div class="te-grid-3">
        <div class="te-card">
          <h3>Rigor técnico</h3>
          <p>Critérios claros, tolerâncias e padrão de aceite registrado.</p>
        </div>
        <div class="te-card">
          <h3>Transparência total</h3>
          <p>Evidência por lote: fotos, medições e checklist.</p>
        </div>
        <div class="te-card">
          <h3>Menos disputa</h3>
          <p>Redução de retrabalho, atraso e conflito pós-embarque.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTATO -->
  <section id="contato" class="te-band--cream">
    <div class="te-wrap te-center">
      <p class="te-kicker" style="background: rgba(16,39,36,0.06); border-color: rgba(16,39,36,0.15); color: rgba(16,39,36,0.85);">
        <span class="te-kicker__dot"></span> Vamos alinhar a inspeção
      </p>
      <h2 class="te-h2" style="color: var(--secondary);">Solicitar inspeção</h2>
      <p class="te-p" style="color: rgba(16,39,36,0.85);">Conte o material, quantidade e destino. A gente responde com próximos passos.</p>

      <form class="te-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="submit_inspection_request">
        <?php wp_nonce_field('inspection_request', 'inspection_nonce'); ?>

        <div class="te-form__grid">
          <div class="te-form__row">
            <label for="name">Nome completo *</label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="te-form__row">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required>
          </div>
        </div>

        <div class="te-form__grid">
          <div class="te-form__row">
            <label for="company">Empresa</label>
            <input type="text" id="company" name="company">
          </div>
          <div class="te-form__row">
            <label for="material">Material</label>
            <input type="text" id="material" name="material" placeholder="Ex.: Quartzito, granito, mármore">
          </div>
        </div>

        <div class="te-form__row">
          <label for="message">Detalhes do projeto *</label>
          <textarea id="message" name="message" required rows="6" placeholder="Quantidades, acabamentos, destino e qualquer exigência específica…"></textarea>
        </div>

        <div class="te-form__actions">
          <button type="submit" class="te-btn te-btn--primary">Enviar solicitação</button>
          <a class="te-btn te-btn--ghost" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">WhatsApp</a>
        </div>
      </form>
    </div>
  </section>

  <!-- FLOATING CTA -->
  <div id="te-floating">
    <a href="#contato" aria-label="Solicitar inspeção">
      <span>Solicitar inspeção</span>
      <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
  </div>

</div>

<script>
// Loader
window.addEventListener('load', function() {
  const loader = document.getElementById('te-loader');
  if (!loader) return;
  setTimeout(function() {
    loader.style.opacity = '0';
    loader.style.visibility = 'hidden';
    setTimeout(function(){ loader.remove(); }, 850);
  }, 650);
});

// Parallax suave no hero
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset || document.documentElement.scrollTop || 0;
  const heroVideo = document.querySelector('.te-hero__video');
  if (!heroVideo) return;
  if (scrolled < window.innerHeight) {
    heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.22}px)) scale(1.1)`;
  }
});

// Floating CTA
window.addEventListener('scroll', function() {
  const el = document.getElementById('te-floating');
  if (!el) return;
  if (window.scrollY > 900) {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0)';
    el.style.pointerEvents = 'auto';
  } else {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.pointerEvents = 'none';
  }
});

// Smooth scroll para âncoras internas
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    const target = href ? document.querySelector(href) : null;
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
</script>

<?php
get_footer();