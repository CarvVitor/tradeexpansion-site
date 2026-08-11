<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 * Description: Página principal da Trade Expansion — institucional, com vídeo de fundo e layout luxury.
 */

// Detectar idioma pela URL ou query var para slugs SEO-friendly
$lang = 'pt';
if (function_exists('get_query_var') && get_query_var('te_lang')) {
    $lang = get_query_var('te_lang');
} elseif (!empty($_GET['te_lang']) && in_array($_GET['te_lang'], ['en', 'es', 'pt'])) {
    $lang = $_GET['te_lang'];
} elseif (strpos($_SERVER['REQUEST_URI'], '/en') !== false) {
    $lang = 'en';
} elseif (strpos($_SERVER['REQUEST_URI'], '/es') !== false) {
    $lang = 'es';
}


// Dicionário de Traduções da Home
$t = [
  'hero_kicker' => [
    'pt' => 'Boutique de Inteligência em Comércio Exterior',
    'en' => 'Brazilian Natural Stone Export — Boutique Sourcing & Inspection',
    'es' => 'Boutique de Inteligencia en Comercio Exterior'
  ],
  'hero_title' => [
    'pt' => 'Onde a Precisão encontra a <span>Exclusividade</span> na Exportação de Rochas.',
    'en' => 'Where Precision meets <span>Exclusivity</span> in Natural Stone Export.',
    'es' => 'Donde la Precisión encuentra la <span>Exclusividad</span> en Exportación de Rocas.'
  ],
  'hero_text' => [
    'pt' => 'Curadoria técnica e inteligência operacional para compradores que não aceitam margem para erro. Do campo à entrega final, garantimos a integridade do seu investimento.',
    'en' => 'Technical curation and operational intelligence for buyers who accept no margin for error. From the quarry to final delivery, we guarantee the integrity of your investment.',
    'es' => 'Curaduría técnica e inteligencia operativa para compradores que no aceptan margen de error. Desde la cantera hasta la entrega final, garantizamos la integridad de su inversión.'
  ],
  'hero_btn1' => [
    'pt' => 'Solicitar Curadoria Técnica', 'en' => 'Request Technical Curation', 'es' => 'Solicitar Curaduría Técnica'
  ],
  'hero_btn2' => [
    'pt' => 'Consultar Especialista', 'en' => 'Consult an Expert', 'es' => 'Consultar a un Experto'
  ],
  'hero_meta' => [
    'pt' => 'Operações para importadores na Europa, Ásia e América do Norte · Inspeções em ES, MG e BA',
    'en' => 'Operations for importers in Europe, Asia, and North America · Inspections in ES, MG, and BA',
    'es' => 'Operaciones para importadores en Europa, Asia y Norteamérica · Inspecciones en ES, MG y BA'
  ],
  'hero_side_title' => [
    'pt' => 'Atendimento Boutique e Dedicado', 'en' => 'Dedicated Boutique Service', 'es' => 'Servicio Boutique y Dedicado'
  ],
  'hero_side_text' => [
    'pt' => 'Cada operação recebe atenção exclusiva. Nosso modelo boutique garante que seu projeto tenha um especialista dedicado do início ao embarque — sem filas, sem surpresas.',
    'en' => 'Every operation receives exclusive attention. Our boutique model ensures your project has a dedicated expert from start to shipping — no queues, no surprises.',
    'es' => 'Cada operación recibe atención exclusiva. Nuestro modelo boutique garantiza un experto dedicado desde el inicio hasta el embarque: sin filas, sin sorpresas.'
  ],
  'tag1' => ['pt' => 'Curadoria de Rochas', 'en' => 'Stone Curation', 'es' => 'Curaduría de Rocas'],
  'tag2' => ['pt' => 'Inspeção Técnica', 'en' => 'Technical Inspection', 'es' => 'Inspección Técnica'],
  'tag3' => ['pt' => 'Blindagem Operacional', 'en' => 'Operational Shielding', 'es' => 'Blindaje Operativo'],
  'crown_label' => [
    'pt' => 'Reserva Privada · Exclusividade Trade Expansion',
    'en' => 'Private Reserve · Trade Expansion Exclusive',
    'es' => 'Reserva Privada · Exclusividad Trade Expansion'
  ],
  'crown_title' => [
    'pt' => 'A Coleção de<br><em>Quartzitos Exclusivos</em>',
    'en' => 'The Collection of<br><em>Exclusive Quartzites</em>',
    'es' => 'La Colección de<br><em>Cuarcitas Exclusivas</em>'
  ],
  'crown_geo' => [
    'pt' => 'Acesso direto a pedreiras originais e estoques raros. Como proprietários da pedreira do Imperial Blue, oferecemos materiais que não estão disponíveis em nenhum outro lugar do mundo.',
    'en' => 'Imperial Blue quartzite is available through a single source worldwide. As the exclusive commercial partner for this material, we are the only way to guarantee its origin, authenticity, and supply continuity.',
    'es' => 'Acceso directo a canteras originales y stocks raros. Como propietarios de la cantera de Imperial Blue, ofrecemos materiales no disponibles en ningún otro lugar.'
  ],
  'crown_b1' => [
    'pt' => 'Uma seleção meticulosa de quartzitos brasileiros — do Imperial Blue ao Bonsai Crystal — reservada exclusivamente para projetos onde a pedra atua como o ponto focal da arquitetura e do luxo.',
    'en' => 'A meticulous selection of Brazilian quartzites — from Imperial Blue to Bonsai Crystal — reserved exclusively for projects where stone serves as the focal point of architecture and luxury.',
    'es' => 'Una selección meticulosa de cuarcitas brasileñas — desde Imperial Blue hasta Bonsai Crystal — reservada exclusivamente para proyectos donde la piedra es el foco de la arquitectura y el lujo.'
  ],
  'crown_b2' => [
    'pt' => 'Seis materiais. Seis expressões distintas de movimento, profundidade e elegância natural. Cada chapa carrega uma identidade geológica única.',
    'en' => 'Each slab carries a unique geological identity. Each material, a single point of access.',
    'es' => 'Seis materiales. Seis expresiones distintas de movimiento, profundidad y elegancia natural. Cada chapa lleva una identidad geológica única.'
  ],
  'crown_f1' => [
    'pt' => 'Imperial Blue — A raridade original, extração própria',
    'en' => 'Imperial Blue — Worldwide exclusive. One source.',
    'es' => 'Imperial Blue — La rareza original, extracción propia'
  ],
  'crown_cta' => [
    'pt' => 'Explorar a Coleção Original →', 'en' => 'Explore the Exclusive Collection →', 'es' => 'Explorar la Colección Original →'
  ],
  'alt_crown' => [
    'pt' => 'Quartzito Imperial Blue — Extração Própria', 'en' => 'Imperial Blue Quartzite — Trade Expansion Exclusive', 'es' => 'Cuarcita Imperial Blue — Extracción Propia'
  ]
];

if (!function_exists('te_t')) {
    function te_t($key) {
        global $t, $lang;
        return isset($t[$key][$lang]) ? $t[$key][$lang] : (isset($t[$key]['pt']) ? $t[$key]['pt'] : '');
    }
}

get_header();
?>

<main>
  <!-- HERO COM VÍDEO -->
  <header class="hero" style="position: relative;">
    <video class="hero-video te-hero__video" autoplay muted loop playsinline preload="auto">
      <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-home.mp4'); ?>" type="video/mp4" />
    </video>
    <img class="te-hero__img" data-src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-home-fallback.jpg'); ?>" alt="" aria-hidden="true" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.15; display:none;" />
    <div class="hero-overlay"></div>
    <div class="hero-grid" style="padding:5rem 6vw 6rem; margin:0 auto;">
      <div class="fade-in-up">
        <div class="hero-kicker"><?php echo te_t('hero_kicker'); ?></div>
        <h1 class="hero-title"><?php echo te_t('hero_title'); ?></h1>
        <p class="hero-text" style="margin-top:32px;">
          <?php echo te_t('hero_text'); ?>
        </p>
        <div class="hero-actions">
          <a class="btn-primary" href="<?php echo esc_url(home_url('/contato')); ?>"><?php echo te_t('hero_btn1'); ?></a>
          <a class="btn-secondary" href="<?php echo esc_url(home_url('/inspecao')); ?>"><?php echo te_t('hero_btn2'); ?></a>
        </div>
        <div class="hero-meta"><?php echo te_t('hero_meta'); ?></div>
      </div>
      <aside class="hero-side-card fade-in-up">
        <h2 class="hero-side-title"><?php echo te_t('hero_side_title'); ?></h2>
        <div class="hero-side-text">
          <?php echo te_t('hero_side_text'); ?>
        </div>
        <div class="hero-tags">
          <span class="hero-tag-pill"><?php echo te_t('tag1'); ?></span>
          <span class="hero-tag-pill"><?php echo te_t('tag2'); ?></span>
          <span class="hero-tag-pill"><?php echo te_t('tag3'); ?></span>
        </div>
      </aside>
    </div>
  </header>

  <!-- SEÇÃO EXCLUSIVA — COLEÇÃO DE QUARTZITOS -->
  <section class="crown-section" id="colecao-exclusiva" aria-labelledby="crown-heading">
    <div class="crown-text fade-in-up">
      <p class="section-label"><?php echo te_t('crown_label'); ?></p>
      <h2 id="crown-heading" class="crown-title"><?php echo te_t('crown_title'); ?></h2>
      <blockquote class="crown-geo"><?php echo te_t('crown_geo'); ?></blockquote>
      <p class="crown-body"><?php echo te_t('crown_b1'); ?></p>
      <p class="crown-body"><?php echo te_t('crown_b2'); ?></p>
      <ul class="crown-features" aria-label="Destaques da coleção">
        <li><?php echo te_t('crown_f1'); ?></li>
        <li>Seven Blue, Bali Brown, Bali Crystal, Bonsai Crystal, Valenza River</li>
      </ul>
      <a href="https://tradeexpansion.com.br/exclusive/" class="crown-link" id="crown-cta"><?php echo te_t('crown_cta'); ?></a>
    </div>
    <div class="crown-image-wrap fade-in-up">
      <div class="crown-frame">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/imperial-blue.jpg'); ?>" alt="<?php echo te_t('alt_crown'); ?>">
      </div>
    </div>
  </section>
<?php
// Extensão do Dicionário para Parte 2 e 3
$t2 = [
  'mq1' => ['pt' => 'Rochas ornamentais', 'en' => 'Ornamental Rocks', 'es' => 'Rocas Ornamentales'],
  'mq2' => ['pt' => 'Inspeção independente', 'en' => 'Independent Inspection', 'es' => 'Inspección Independiente'],
  'mq3' => ['pt' => 'Exportação', 'en' => 'Export', 'es' => 'Exportación'],
  'mq4' => ['pt' => 'Logística internacional', 'en' => 'International Logistics', 'es' => 'Logística Internacional'],
  
  'about_kicker' => ['pt' => 'Quem somos', 'en' => 'Who We Are', 'es' => 'Quiénes Somos'],
  'about_title' => [
    'pt' => 'A Inteligência por trás das Maiores Operações.',
    'en' => 'The Intelligence Behind Major Operations.',
    'es' => 'La Inteligencia detrás de las Mayores Operaciones.'
  ],
  'about_sub' => [
    'pt' => 'Na Trade Expansion, não apenas facilitamos negócios; nós os blindamos. Nossa estrutura boutique permite um olhar microscópico sobre cada detalhe da rocha e da logística.',
    'en' => 'At Trade Expansion, we don’t just facilitate deals; we shield them. Our boutique structure allows a microscopic look at every detail of the stone and logistics.',
    'es' => 'En Trade Expansion, no solo facilitamos negocios; los blindamos. Nuestra estructura boutique permite una mirada microscópica a cada detalle de la roca y la logística.'
  ],
  'about_text' => [
    'pt' => 'Operamos como uma extensão dedicada do seu time de compras. Cada lote é analisado com rigor técnico, cada documento é revisado com precisão jurídica, e cada embarque é acompanhado com a vigilância que seu investimento exige.',
    'en' => 'We operate as a dedicated extension of your procurement team. Each batch is analyzed with technical rigor, each document is reviewed with legal precision, and each shipment is monitored with the vigilance your investment demands.',
    'es' => 'Operamos como una extensión dedicada de su equipo de compras. Cada lote es analizado con rigor técnico, cada documento es revisado con precisión legal, y cada envío es monitoreado con la vigilancia que su inversión exige.'
  ],
  'break_kicker' => ['pt' => 'Do Brasil para o mundo', 'en' => 'From Brazil to the World', 'es' => 'De Brasil para el mundo'],
  'break_title' => [
    'pt' => 'Você não compra foto bonita — você compra previsibilidade.',
    'en' => 'You don’t buy a pretty picture — you buy predictability.',
    'es' => 'No compras una foto bonita, compras previsibilidad.'
  ]
];
$t = array_merge($t, $t2);
?>

  <!-- MARQUEE -->
  <section class="te-marquee" aria-label="Áreas de atuação">
    <div class="te-marquee-inner">
      <div class="te-marquee-track">
        <span class="te-marquee-item"><?php echo te_t('mq1'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq2'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Commodities</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq3'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Sourcing</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Quality Control</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq4'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <!-- Loop Duplicado -->
        <span class="te-marquee-item"><?php echo te_t('mq1'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq2'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Commodities</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq3'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Sourcing</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item">Quality Control</span><span class="te-marquee-dot" aria-hidden="true"></span>
        <span class="te-marquee-item"><?php echo te_t('mq4'); ?></span><span class="te-marquee-dot" aria-hidden="true"></span>
      </div>
    </div>
  </section>

  <!-- SOBRE / QUEM SOMOS -->
  <section class="te-section" aria-labelledby="about-heading">
    <header class="te-section-header fade-in-up">
      <div class="te-kicker"><?php echo te_t('about_kicker'); ?></div>
      <h2 id="about-heading" class="te-title"><?php echo te_t('about_title'); ?></h2>
      <p class="te-subtitle"><?php echo te_t('about_sub'); ?></p>
    </header>
    <div class="about-grid fade-in-up">
      <div class="about-text">
        <p><?php echo te_t('about_text'); ?></p>
      </div>
    </div>
  </section>

  <!-- BREAK VISUAL -->
  <section class="te-break" aria-labelledby="break-heading">
    <video class="te-break-video" autoplay muted loop playsinline preload="metadata">
      <source src="<?php echo esc_url(get_template_directory_uri() . '/assets/videos/hero-rochas.mp4'); ?>" type="video/mp4" />
    </video>
    <div class="te-break-overlay" aria-hidden="true"></div>
    <div class="te-break-content fade-in-up">
      <div class="te-break-kicker"><?php echo te_t('break_kicker'); ?></div>
      <h2 id="break-heading" class="te-break-title"><?php echo te_t('break_title'); ?></h2>
    </div>
  </section>
<?php
$t3 = [
  'lab_kicker' => ['pt' => 'The Intelligence Lab', 'en' => 'The Intelligence Lab', 'es' => 'The Intelligence Lab'],
  'lab_title' => ['pt' => 'Onde cada lote é dissecado antes da decisão.', 'en' => 'Where every batch is dissected before the decision.', 'es' => 'Donde cada lote es diseccionado antes de la decisión.'],
  'lab_text' => [
    'pt' => 'Cada rocha que nós selecionamos passa por uma avaliação técnica rigorosa antes de qualquer compromisso. Analisamos consistência de cor, integridade estrutural, qualidade de acabamento e conformidade dimensional — porque nossos clientes compram do outro lado do mundo e não podem se dar ao luxo de surpresas.',
    'en' => 'Every stone we source goes through a rigorous technical evaluation before any commitment is made. We analyze color consistency, structural integrity, finish quality, and dimensional compliance — because our clients buy from the other side of the world and cannot afford surprises.',
    'es' => 'Cada piedra que seleccionamos pasa por una evaluación técnica rigurosa antes de cualquier compromiso. Analizamos consistencia de color, integridad estructural, calidad de acabado y conformidad dimensional — porque nuestros clientes compran desde el otro lado del mundo y no pueden permitirse sorpresas.'
  ],
  'contact_kicker' => ['pt' => 'Fale conosco', 'en' => 'Contact Us', 'es' => 'Contáctenos'],
  'contact_title' => ['pt' => 'Pronto para blindar sua próxima operação?', 'en' => 'Ready to shield your next operation?', 'es' => '¿Listo para blindar su próxima operación?'],
  'contact_btn_wp' => ['pt' => 'Falar com Especialista no WhatsApp', 'en' => 'Speak to an Expert on WhatsApp', 'es' => 'Hablar con un Experto por WhatsApp'],
  'contact_btn_em' => ['pt' => 'Enviar E-mail', 'en' => 'Send E-mail', 'es' => 'Enviar Correo'],
  'feat_title' => ['pt' => 'Alguns materiais que costumamos trabalhar.', 'en' => 'Some materials we usually work with.', 'es' => 'Algunos materiales que solemos trabajar.'],
  'feat_btn1' => ['pt' => 'Explorar catálogo', 'en' => 'Explore catalog', 'es' => 'Explorar catálogo'],
  'feat_btn2' => ['pt' => 'Solicitar disponibilidade', 'en' => 'Request availability', 'es' => 'Solicitar disponibilidad']
];
$t = array_merge($t, $t3);
?>

  <!-- THE INTELLIGENCE LAB -->
  <section class="te-section" aria-labelledby="lab-heading" style="border-top:1px solid var(--te-line);">
    <header class="te-section-header fade-in-up">
      <div class="te-kicker"><?php echo te_t('lab_kicker'); ?></div>
      <h2 id="lab-heading" class="te-title"><?php echo te_t('lab_title'); ?></h2>
      <p class="te-subtitle"><?php echo te_t('lab_text'); ?></p>
    </header>
  </section>

  <!-- MATERIAIS EM DESTAQUE -->
  <?php
  $te_featured = new WP_Query([
    'post_type' => 'rocha',
    'posts_per_page' => 6,
    'no_found_rows' => true,
    'meta_query' => [['key' => '_rocha_destaque', 'value' => '1', 'compare' => '=']],
    'meta_key' => '_rocha_ordem',
    'orderby' => ['meta_value_num' => 'ASC', 'date' => 'DESC']
  ]);
  ?>
  <section class="te-section materials" id="materiais" aria-labelledby="materials-heading">
    <header class="te-section-header fade-in-up">
      <div class="te-kicker">Portfolio</div>
      <h2 id="materials-heading" class="te-title"><?php echo te_t('feat_title'); ?></h2>
    </header>
    <div class="materials-grid">
      <?php if ($te_featured->have_posts()): ?>
        <?php while ($te_featured->have_posts()): $te_featured->the_post(); ?>
          <?php
          $te_img = get_the_post_thumbnail_url(get_the_ID(), 'large');
          if (!$te_img) $te_img = get_template_directory_uri() . '/assets/images/hero-rochas-fallback.jpg';
          ?>
          <article class="material-card fade-in-up" style="background-image:url('<?php echo esc_url($te_img); ?>');">
            <div class="material-overlay" aria-hidden="true"></div>
            <div class="material-content">
              <h3 class="material-title"><?php the_title(); ?></h3>
              <a class="material-link" href="<?php echo esc_url(home_url('/rochas-ornamentais')); ?>">→</a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
    <div class="materials-cta-row fade-in-up">
      <a class="btn-primary" href="<?php echo esc_url(home_url('/catalogo')); ?>"><?php echo te_t('feat_btn1'); ?></a>
      <a class="btn-secondary" href="<?php echo esc_url(home_url('/contato')); ?>"><?php echo te_t('feat_btn2'); ?></a>
    </div>
  </section>

  <!-- NOVA SEÇÃO: CONTATO -->
  <section class="te-section" aria-labelledby="contact-heading" style="text-align:center; padding: 8rem 6vw;">
    <div class="te-section-header fade-in-up" style="align-items:center;">
      <div class="te-kicker"><?php echo te_t('contact_kicker'); ?></div>
      <h2 id="contact-heading" class="te-title" style="font-size: 2.8rem; margin-bottom: 2rem;"><?php echo te_t('contact_title'); ?></h2>
    </div>
    <div class="fade-in-up" style="display:flex; gap:1.5rem; justify-content:center; flex-wrap:wrap;">
      <a href="https://wa.me/5527992284517" target="_blank" rel="noopener" class="btn-primary" style="padding: 1.2rem 2.5rem; font-size: 0.9rem;">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="margin-right:8px;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        <?php echo te_t('contact_btn_wp'); ?>
      </a>
      <a href="mailto:vitor@tradeexpansion.com.br" class="btn-secondary" style="padding: 1.2rem 2.5rem; font-size: 0.9rem; border-color: rgba(201,153,97,.4);">
        <?php echo te_t('contact_btn_em'); ?>
      </a>
    </div>
  </section>
</main>

<script>
  // Fallback inteligente para vídeo do hero na Home
  document.addEventListener('DOMContentLoaded', function() {
    const heroVideoEl = document.querySelector('.te-hero__video');
    const heroImgEl = document.querySelector('.te-hero__img');
    if (heroVideoEl && heroImgEl) {
      heroVideoEl.addEventListener('error', function() {
        heroImgEl.src = heroImgEl.dataset.src;
        heroImgEl.style.display = 'block';
      });
      setTimeout(function() {
        if (heroVideoEl.readyState === 0) {
          heroImgEl.src = heroImgEl.dataset.src;
          heroImgEl.style.display = 'block';
        }
      }, 4000);
    }
  });
</script>

<?php get_footer(); ?>
