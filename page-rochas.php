<?php
/**
 * Template Name: Rochas Ornamentais
 * Description: Página de catálogo de rochas ornamentais brasileiras
 */

get_header();

$hero_video = get_theme_file_uri('assets/videos/rochas-hero.mp4');
$hero_img   = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg'); // opcional
$whatsapp   = 'https://wa.me/5527999999999'; // troque aqui pelo número real
?>

<style>
/* =====================================================================
   Trade Expansion — Rochas Ornamentais
   P0: contraste + consistência + cara de SaaS premium
   ===================================================================== */
:root {
  --secondary: #102724;
  --cream: #F1F1D9;
  --text: #E1E2DA;
  --ink: #1D1F1E;
  --gold: #D6A354;

  /* Fallbacks (se o tema já define esses tokens, ótimo) */
  --primary: var(--primary, #102724);
  --accent: var(--accent, #D6A354);
}

.te-rochas {
  font-family: 'Vollkorn', Georgia, serif;
  overflow-x: hidden;
}

.te-rochas section {
  position: relative;
  width: 100%;
  clear: both;
}

/* Loader frosted (padrão premium) */
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

#te-loader .te-loader__inner { text-align: center; }

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

@keyframes teSpin { to { transform: rotate(360deg); } }

/* HERO */
.rochas-hero {
  position: relative;
  height: 100vh;
  min-height: 640px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: radial-gradient(1200px 600px at 50% 25%, rgba(214, 163, 84, 0.16), transparent 60%),
              linear-gradient(135deg, #102724 0%, #0b1b18 100%);
}

.rochas-hero__glow {
  position: absolute;
  inset: 0;
  background: radial-gradient(1000px 520px at 50% 15%, rgba(214,163,84,0.18), transparent 60%);
  pointer-events: none;
  z-index: 0;
}

.rochas-hero__video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translate(-50%, -50%) scale(1.12);
  object-fit: cover;
  opacity: 0.22;
  will-change: transform;
  z-index: 0;
}

.rochas-hero__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.12;
  z-index: 0;
}

.rochas-hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(16, 39, 36, 0.45) 0%, rgba(16, 39, 36, 0.92) 70%, rgba(16, 39, 36, 1) 100%);
  z-index: 0;
}

.rochas-hero-content {
  position: relative;
  z-index: 1;
  text-align: center;
  padding: 0 2rem;
  max-width: 1050px;
}

.rochas-badge {
  display: inline-flex;
  align-items: center;
  gap: .6rem;
  background: rgba(214, 163, 84, 0.14);
  border: 1px solid rgba(214, 163, 84, 0.35);
  color: var(--cream);
  padding: 0.75rem 1.25rem;
  border-radius: 999px;
  font-size: 0.82rem;
  letter-spacing: 0.18em;
  margin-bottom: 1.25rem;
  text-transform: uppercase;
  backdrop-filter: blur(6px);
}

.rochas-hero h1 {
  font-size: clamp(2.6rem, 6.5vw, 5rem);
  font-weight: 500;
  color: var(--cream);
  margin-bottom: 1rem;
  line-height: 1.08;
  letter-spacing: 0.03em;
  text-transform: uppercase;
}

.rochas-hero p {
  font-size: clamp(1.05rem, 2vw, 1.45rem);
  color: rgba(241, 241, 217, 0.88);
  margin: 0 auto 2.1rem;
  max-width: 820px;
  font-weight: 400;
  line-height: 1.65;
}

.rochas-hero__actions {
  display: flex;
  justify-content: center;
  gap: .8rem;
  flex-wrap: wrap;
}

.te-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .6rem;
  padding: 1rem 1.6rem;
  border-radius: 14px;
  font-weight: 800;
  text-decoration: none;
  transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  font-size: .92rem;
}

.te-btn--primary {
  background: var(--gold);
  color: var(--secondary);
  border: 1px solid rgba(214,163,84,0.55);
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}

.te-btn--primary:hover { transform: translateY(-2px); }

.te-btn--ghost {
  background: rgba(0,0,0,0.20);
  color: var(--cream);
  border: 1px solid rgba(241,241,217,0.22);
}

.te-btn--ghost:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.55);
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
  z-index: 1;
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

/* VANTAGENS */
.rochas-vantagem {
  background: linear-gradient(180deg, rgba(16, 39, 36, 1) 0%, rgba(11, 27, 24, 1) 100%);
  padding: 5.2rem 2rem;
}

.rochas-vantagem-grid {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.6rem;
  text-align: center;
}

.rochas-vantagem-card {
  padding: 2.2rem 1.9rem;
  background: rgba(241, 241, 217, 0.96);
  border: 1px solid rgba(214, 163, 84, 0.20);
  border-radius: 18px;
  box-shadow: 0 18px 60px rgba(0, 0, 0, 0.35);
}

.rochas-vantagem-icon {
  font-size: 2.7rem;
  margin-bottom: .8rem;
}

.rochas-vantagem-card h3 {
  font-size: 1.45rem;
  color: #1d1f1e;
  margin-bottom: .75rem;
  font-weight: 600;
  letter-spacing: .02em;
}

.rochas-vantagem-card p {
  font-size: 1rem;
  color: rgba(29, 31, 30, 0.78);
  line-height: 1.7;
}

/* CATÁLOGO */
.rochas-catalogo {
  background: radial-gradient(1200px 600px at 50% 0%, rgba(214, 163, 84, 0.12), transparent 60%),
              linear-gradient(180deg, rgba(16, 39, 36, 1) 0%, rgba(11, 27, 24, 1) 100%);
  padding: 5.2rem 2rem;
}

.rochas-catalogo-header {
  max-width: 1400px;
  margin: 0 auto 3rem;
  text-align: center;
}

.rochas-catalogo-header h2 {
  font-size: clamp(2rem, 4vw, 3.1rem);
  color: var(--cream);
  margin-bottom: 1rem;
  font-weight: 600;
  letter-spacing: .03em;
  text-transform: uppercase;
}

.rochas-catalogo-header p {
  color: rgba(241, 241, 217, 0.85);
  font-weight: 400;
  line-height: 1.65;
}

/* FILTROS */
.rochas-filtros {
  max-width: 1400px;
  margin: 0 auto 3rem;
  display: flex;
  flex-wrap: wrap;
  gap: .8rem;
  justify-content: center;
}

.rochas-filtro {
  padding: .85rem 1.4rem;
  border: 1px solid rgba(214, 163, 84, 0.22);
  background: rgba(241, 241, 217, 0.96);
  border-radius: 9999px;
  cursor: pointer;
  font-family: 'Vollkorn', serif;
  font-size: .95rem;
  transition: all 0.25s ease;
  color: rgba(16,39,36,0.92);
}

.rochas-filtro:hover,
.rochas-filtro.ativo {
  background: var(--gold);
  color: var(--secondary);
  border-color: rgba(214,163,84,0.85);
  transform: translateY(-1px);
}

/* GRID */
.rochas-grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.7rem;
}

.rocha-card {
  background: rgba(241, 241, 217, 0.98);
  border: 1px solid rgba(214, 163, 84, 0.18);
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
  transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
  cursor: pointer;
}

.rocha-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 70px rgba(0, 0, 0, 0.22);
}

.rocha-imagem {
  width: 100%;
  height: 250px;
  overflow: hidden;
  background: #f0f0f0;
  position: relative;
}

.rocha-imagem img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.rocha-card:hover .rocha-imagem img { transform: scale(1.08); }

.rocha-info { padding: 1.5rem; }

.rocha-tipo {
  font-size: 0.78rem;
  text-transform: uppercase;
  letter-spacing: 0.18em;
  color: rgba(16,39,36,0.85);
  margin-bottom: 0.55rem;
  font-weight: 800;
}

.rocha-nome {
  font-size: 1.32rem;
  color: #1d1f1e;
  margin-bottom: .75rem;
  font-weight: 700;
  letter-spacing: .02em;
}

.rocha-descricao {
  font-size: 0.98rem;
  color: rgba(29, 31, 30, 0.76);
  line-height: 1.55;
  margin-bottom: 1.2rem;
  min-height: 3em;
}

.rocha-cta {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  padding: .82rem 1.35rem;
  background: var(--secondary);
  color: var(--cream);
  text-decoration: none;
  border-radius: 9999px;
  font-size: 0.86rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  transition: all 0.25s ease;
  border: 1px solid rgba(16,39,36,0.2);
}

.rocha-cta:hover {
  background: var(--gold);
  color: var(--secondary);
  transform: translateX(3px);
}

/* SEÇÃO INSPEÇÃO */
.rochas-inspecao {
  background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%);
  padding: 5.2rem 2rem;
  color: var(--text);
}

.rochas-inspecao-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3.5rem;
  align-items: center;
}

.rochas-inspecao-imagem {
  width: 100%;
  height: 420px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(214,163,84,0.18);
}

.rochas-inspecao-imagem img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.rochas-inspecao-texto h2 {
  font-size: clamp(2rem, 4vw, 3.1rem);
  color: var(--cream);
  margin-bottom: 1.2rem;
  font-weight: 600;
  letter-spacing: .03em;
  text-transform: uppercase;
}

.rochas-inspecao-texto p {
  font-size: 1.1rem;
  line-height: 1.85;
  margin-bottom: 1.2rem;
  opacity: 0.92;
}

.rochas-inspecao-lista {
  list-style: none;
  margin: 1.8rem 0;
  padding: 0;
}

.rochas-inspecao-lista li {
  display: flex;
  gap: 1rem;
  margin-bottom: .9rem;
  font-size: 1rem;
}

.rochas-inspecao-lista span:first-child {
  color: rgba(214,163,84,0.92);
  font-weight: 900;
  flex-shrink: 0;
}

.rochas-inspecao-cta {
  display: inline-flex;
  align-items: center;
  gap: .55rem;
  padding: 1rem 1.7rem;
  background: var(--gold);
  color: var(--secondary);
  text-decoration: none;
  border-radius: 9999px;
  font-size: 0.92rem;
  letter-spacing: 0.10em;
  margin-top: 1.1rem;
  transition: all 0.25s ease;
  font-weight: 900;
  text-transform: uppercase;
}

.rochas-inspecao-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}

/* Responsivo */
@media (max-width: 968px) {
  .rochas-grid {
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.3rem;
  }

  .rochas-inspecao-content {
    grid-template-columns: 1fr;
    gap: 2.8rem;
  }

  .rochas-inspecao-imagem { height: 320px; }

  .rochas-filtros {
    justify-content: flex-start;
    overflow-x: auto;
    padding-bottom: 0.5rem;
  }
}

@media (max-width: 480px) {
  .rochas-hero h1 { font-size: 2.05rem; }
  .rochas-grid { grid-template-columns: 1fr; }
  .rochas-filtro { padding: 0.75rem 1.15rem; font-size: 0.85rem; }
}
</style>

<div class="te-rochas">

  <!-- Loader -->
  <div id="te-loader" aria-hidden="true">
    <div class="te-loader__inner">
      <div class="te-loader__spin"></div>
      <div class="te-loader__txt">Carregando catálogo…</div>
    </div>
  </div>

  <!-- HERO -->
  <section class="rochas-hero">
    <div class="rochas-hero__glow" aria-hidden="true"></div>

    <video class="rochas-hero__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
      <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4" />
    </video>

    <img class="rochas-hero__img" src="<?php echo esc_url($hero_img); ?>" alt="" aria-hidden="true" />

    <div class="rochas-hero__overlay" aria-hidden="true"></div>

    <div class="rochas-hero-content">
      <div class="rochas-badge">💎 <?php _e( 'Rochas Ornamentais Brasileiras', 'tradeexpansion' ); ?></div>
      <h1><?php _e( 'Catálogo premium. Aceite previsível.', 'tradeexpansion' ); ?></h1>
      <p><?php _e( 'Origem direta, inspeção técnica e evidência por lote — para reduzir disputa e aumentar segurança na operação.', 'tradeexpansion' ); ?></p>

      <div class="rochas-hero__actions">
        <a class="te-btn te-btn--primary" href="#catalogo"><?php _e( 'Explorar catálogo', 'tradeexpansion' ); ?></a>
        <a class="te-btn te-btn--ghost" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener"><?php _e( 'WhatsApp', 'tradeexpansion' ); ?></a>
      </div>
    </div>

    <div class="te-scroll" aria-hidden="true">
      <div class="te-scroll__bar"><div class="te-scroll__dot"></div></div>
      <span><?php _e('Desça', 'tradeexpansion'); ?></span>
    </div>
  </section>

  <!-- VANTAGENS -->
  <section class="rochas-vantagem">
    <div class="rochas-vantagem-grid">
      <div class="rochas-vantagem-card">
        <div class="rochas-vantagem-icon">🏔️</div>
        <h3><?php _e( 'Origem direta', 'tradeexpansion' ); ?></h3>
        <p><?php _e( 'Acesso a fornecedores e materiais com histórico de consistência e padrão.', 'tradeexpansion' ); ?></p>
      </div>
      <div class="rochas-vantagem-card">
        <div class="rochas-vantagem-icon">🔍</div>
        <h3><?php _e( 'Inspeção técnica', 'tradeexpansion' ); ?></h3>
        <p><?php _e( 'Checklist + registro fotográfico por lote, antes do embarque.', 'tradeexpansion' ); ?></p>
      </div>
      <div class="rochas-vantagem-card">
        <div class="rochas-vantagem-icon">🌍</div>
        <h3><?php _e( 'Logística e transparência', 'tradeexpansion' ); ?></h3>
        <p><?php _e( 'Operação rastreável — menos surpresa no destino e mais previsibilidade no aceite.', 'tradeexpansion' ); ?></p>
      </div>
    </div>
  </section>

  <!-- CATÁLOGO -->
  <section id="catalogo" class="rochas-catalogo">
    <div class="rochas-catalogo-header">
      <h2><?php _e( 'Explore nossa coleção', 'tradeexpansion' ); ?></h2>
      <p><?php _e( 'Materiais selecionados. Granitos, quartzitos e mármores — com transparência técnica na operação.', 'tradeexpansion' ); ?></p>
    </div>

    <!-- FILTROS -->
    <div class="rochas-filtros" role="tablist" aria-label="Filtros de rochas">
      <button class="rochas-filtro ativo" data-filter="*" role="tab" aria-selected="true"><?php _e( 'Todas', 'tradeexpansion' ); ?></button>
      <button class="rochas-filtro" data-filter="granito" role="tab" aria-selected="false"><?php _e( 'Granitos', 'tradeexpansion' ); ?></button>
      <button class="rochas-filtro" data-filter="quartzito" role="tab" aria-selected="false"><?php _e( 'Quartzitos', 'tradeexpansion' ); ?></button>
      <button class="rochas-filtro" data-filter="marmore" role="tab" aria-selected="false"><?php _e( 'Mármores', 'tradeexpansion' ); ?></button>
    </div>

    <!-- GRID DE ROCHAS -->
    <div class="rochas-grid" id="rochasGrid">
      <?php
      $args = array(
        'post_type'      => 'rocha',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_rocha_ordem',
        'order'          => 'ASC',
        'meta_query'     => array(
          array(
            'key'    => '_rocha_ordem',
            'value'  => 0,
            'compare' => '!=',
            'type'   => 'NUMERIC'
          )
        )
      );

      $rochas = new WP_Query( $args );

      if ( $rochas->have_posts() ) {
        while ( $rochas->have_posts() ) {
          $rochas->the_post();
          $tipo = get_the_terms( get_the_ID(), 'rocha_tipo' );
          $tipo_slug = $tipo ? strtolower( str_replace( ' ', '', $tipo[0]->name ) ) : '';
          ?>
          <div class="rocha-card" data-tipo="<?php echo esc_attr( $tipo_slug ); ?>">
            <div class="rocha-imagem">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
              <?php else : ?>
                <img src="https://via.placeholder.com/400x300?text=<?php echo urlencode( get_the_title() ); ?>" alt="<?php the_title_attribute(); ?>" />
              <?php endif; ?>
            </div>
            <div class="rocha-info">
              <?php if ( $tipo ) : ?>
                <div class="rocha-tipo"><?php echo esc_html( $tipo[0]->name ); ?></div>
              <?php endif; ?>
              <div class="rocha-nome"><?php the_title(); ?></div>
              <div class="rocha-descricao"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></div>
              <a href="<?php echo esc_url( home_url('/contato') ); ?>" class="rocha-cta"><?php _e( 'Solicitar cotação', 'tradeexpansion' ); ?> →</a>
            </div>
          </div>
          <?php
        }
        wp_reset_postdata();
      } else {
        echo '<p style="color: rgba(241,241,217,0.85); text-align:center;">' . __( 'Nenhuma rocha encontrada. Adicione rochas no painel administrativo.', 'tradeexpansion' ) . '</p>';
      }
      ?>
    </div>
  </section>

  <!-- SEÇÃO INSPEÇÃO -->
  <section class="rochas-inspecao">
    <div class="rochas-inspecao-content">
      <div class="rochas-inspecao-imagem">
        <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=1200&q=80&auto=format&fit=crop" alt="<?php _e( 'Inspeção de Rochas', 'tradeexpansion' ); ?>" />
      </div>
      <div class="rochas-inspecao-texto">
        <h2><?php _e( 'Inspeção antes do embarque', 'tradeexpansion' ); ?></h2>
        <p><?php _e( 'Inspeção técnica reduz disputa no destino e aumenta previsibilidade no aceite. Você aprova com base em critério e evidência.', 'tradeexpansion' ); ?></p>

        <ul class="rochas-inspecao-lista">
          <li><span>✓</span> <span><?php _e( 'Checklist por lote e acabamento', 'tradeexpansion' ); ?></span></li>
          <li><span>✓</span> <span><?php _e( 'Registro fotográfico completo', 'tradeexpansion' ); ?></span></li>
          <li><span>✓</span> <span><?php _e( 'Medições e conferência de padrão', 'tradeexpansion' ); ?></span></li>
          <li><span>✓</span> <span><?php _e( 'Relatório objetivo para decisão', 'tradeexpansion' ); ?></span></li>
        </ul>

        <a href="<?php echo esc_url( home_url( '/inspecao' ) ); ?>" class="rochas-inspecao-cta"><?php _e( 'Saiba mais sobre inspeção', 'tradeexpansion' ); ?> →</a>
      </div>
    </div>
  </section>

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
  }, 520);
});

// Parallax suave no hero
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset || document.documentElement.scrollTop || 0;
  const heroVideo = document.querySelector('.rochas-hero__video');
  if (!heroVideo) return;
  if (scrolled < window.innerHeight) {
    heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.18}px)) scale(1.12)`;
  }
});

// Filtros (funcionando)
document.addEventListener('DOMContentLoaded', function() {
  const btns = document.querySelectorAll('.rochas-filtro');
  const cards = document.querySelectorAll('.rocha-card');

  if (!btns.length || !cards.length) return;

  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => { b.classList.remove('ativo'); b.setAttribute('aria-selected','false'); });
      btn.classList.add('ativo');
      btn.setAttribute('aria-selected','true');

      const filter = btn.getAttribute('data-filter');

      cards.forEach(card => {
        const tipo = (card.getAttribute('data-tipo') || '').toLowerCase();
        if (filter === '*' || tipo === filter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
</script>

<?php get_footer(); ?>