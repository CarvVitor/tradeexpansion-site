<?php
/**
 * Template Name: Rochas Ornamentais
 * Description: Catálogo Premium de Rochas
 */

get_header();
?>

<style>
  /* Estilos Específicos da Página (usando vars globais e novos utils) */

  /* Grid Premium */
  .catalogo-section {
    padding: 80px 0;
    background: var(--secondary);
  }

  .rochas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    padding: 40px 20px;
    max-width: 1400px;
    margin: 0 auto;
  }

  .rocha-card {
    background: #fff;
    border-radius: 8px;
    /* Standard radius */
    overflow: hidden;
    position: relative;
    transition: var(--transition);
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.05);
  }

  .rocha-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
  }

  .rocha-img-wrapper {
    height: 300px;
    /* Taller images */
    overflow: hidden;
    position: relative;
  }

  .rocha-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
  }

  .rocha-card:hover .rocha-img-wrapper img {
    transform: scale(1.1);
  }

  .rocha-info {
    padding: 25px;
    background: #151515;
    /* Dark card content */
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  .rocha-type {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--gold);
    margin-bottom: 8px;
    display: block;
  }

  .rocha-title {
    font-size: 1.4rem;
    color: var(--text);
    margin: 0 0 10px;
  }

  /* Filtros Estilizados */
  .filtros-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 40px;
  }

  .filtro-btn {
    padding: 10px 24px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    color: rgba(255, 255, 255, 0.7);
    background: transparent;
    cursor: pointer;
    font-size: 0.9rem;
    font-family: var(--font-sans);
    transition: var(--transition);
  }

  .filtro-btn:hover,
  .filtro-btn.active {
    border-color: var(--gold);
    color: var(--gold);
    background: rgba(201, 169, 97, 0.1);
  }
</style>

<main>
  <!-- HERO - PARALLAX ROCHAS -->
  <section class="parallax-hero" id="rochas-hero" style="height: 70vh; min-height: 500px;">

    <!-- Layer 0: Background Fixo -->
    <div class="parallax-layer layer-0" style="background: var(--secondary);">
      <div
        style="position: absolute; inset: 0; opacity: 0.4; background: url('<?php echo get_template_directory_uri(); ?>/assets/images/rochas_bg_pattern.png');">
      </div>
      <!-- Organic Overlay at bottom -->
      <div
        style="position: absolute; bottom: 0; left: 0; width: 100%; height: 150px; background: linear-gradient(to top, var(--secondary), transparent);">
      </div>
    </div>

    <!-- Layer 1: Parallax Image (Grande Chapa Flutuante) -->
    <div class="parallax-layer layer-1" style="display: flex; align-items: center; justify-content: center;">
      <div class="organic-stone"
        style="width: 100%; height: 120%; top: -10%; left: 0; background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero_rochas.jpg'); opacity: 0.3; filter: blur(2px);">
      </div>
    </div>

    <!-- Layer 2: Conteúdo -->
    <div class="parallax-layer layer-2" style="display: flex; align-items: center; justify-content: center;">
      <div class="rochas-header-content fade-up glass-panel-overlap">
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 20px;">
          A excelência da geodiversidade brasileira, <br>
          <span class="text-gradient">selecionada por especialistas.</span>
        </h1>
        <p style="font-size: 1.1rem; color: rgba(255,255,255,0.85); max-width: 700px; margin: 0 auto 30px;">
          A Trade Expansion não apenas vende, mas valida cada bloco e chapa através de inspeção rigorosa. Curadoria
          exclusiva de Mármores, Granitos e Quartzitos.
        </p>
        <a href="#" class="btn-secondary" style="border-color: var(--cream); color: var(--cream);">
          <span style="margin-right: 8px;">↓</span> Baixar Catálogo Técnico PDF
        </a>
      </div>
    </div>
  </section>

  <!-- Script Parallax Específico Rochas -->
  <script>
    document.addEventListener('scroll', function () {
      if (window.innerWidth <= 768) return;

      const rochasHero = document.getElementById('rochas-hero');
      if (rochasHero) {
        const scrolled = window.scrollY;
        if (scrolled < rochasHero.offsetHeight) {
          // Background move mais lento para dar profundidade
          const layer1 = rochasHero.querySelector('.layer-1');
          if (layer1) layer1.style.transform = `translateY(${scrolled * 0.2}px)`;
        }
      }
    });
  </script>

  <!-- CATALOGO -->
  <section class="catalogo-section">

    <!-- Filtros -->
    <div class="filtros-container fade-up delay-100">
      <button class="filtro-btn active">Todos</button>
      <button class="filtro-btn">Quartzitos</button>
      <button class="filtro-btn">Mármores</button>
      <button class="filtro-btn">Granitos</button>
      <button class="filtro-btn">Exóticos</button>
    </div>

    <div class="rochas-grid">
      <?php
      // Query simples simulada
      $args = array(
        'post_type' => 'rocha',
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num',
        'meta_key' => '_rocha_ordem',
        'order' => 'ASC'
      );
      $rochas = new WP_Query($args);

      if ($rochas->have_posts()):
        while ($rochas->have_posts()):
          $rochas->the_post();
          $tipo = get_the_terms(get_the_ID(), 'rocha_tipo');
          $tipo_name = $tipo ? $tipo[0]->name : 'Natural Stone';
          $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: 'https://via.placeholder.com/600x800?text=Stone';
          ?>

          <article class="rocha-card fade-up">
            <div class="rocha-img-wrapper">
              <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title(); ?>">
            </div>
            <div class="rocha-info">
              <span class="rocha-type"><?php echo esc_html($tipo_name); ?></span>
              <h3 class="rocha-title"><?php the_title(); ?></h3>
              <div style="font-size: 0.9rem; color: #888; margin-top: 10px;">
                Ver detalhes técnicos &rarr;
              </div>
            </div>
          </article>

        <?php
        endwhile;
        wp_reset_postdata();
      else:
        ?>
        <!-- Fallback Mock Cards se não tiver posts -->
        <article class="rocha-card fade-up">
          <div class="rocha-img-wrapper">
            <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=800" alt="White Marble">
          </div>
          <div class="rocha-info">
            <span class="rocha-type">Mármore</span>
            <h3 class="rocha-title">Bianco Paraná</h3>
            <div style="font-size: 0.9rem; color: #888; margin-top: 10px;">Ver detalhes técnicos &rarr;</div>
          </div>
        </article>

        <article class="rocha-card fade-up delay-100">
          <div class="rocha-img-wrapper">
            <img src="https://images.unsplash.com/photo-1596496336495-a2291583ffcd?w=800" alt="Granite">
          </div>
          <div class="rocha-info">
            <span class="rocha-type">Granito</span>
            <h3 class="rocha-title">Black Cosmic</h3>
            <div style="font-size: 0.9rem; color: #888; margin-top: 10px;">Ver detalhes técnicos &rarr;</div>
          </div>
        </article>
      <?php endif; ?>
    </div>

  </section>

</main>

<script>
  // Atribui funcionalidade básica de filtro (mock)
  const btns = document.querySelectorAll('.filtro-btn');
  btns.forEach(btn => {
    btn.addEventListener('click', function () {
      btns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      // Logica de filtro real seria implementada aqui
    });
  });
</script>

<?php get_footer(); ?>