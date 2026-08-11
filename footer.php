<?php
// Garantir a detecção do idioma para o footer
global $lang;
if (empty($lang)) {
    if (function_exists('get_query_var') && get_query_var('te_lang')) {
        $lang = get_query_var('te_lang');
    } elseif (!empty($_GET['te_lang']) && in_array($_GET['te_lang'], ['en', 'es', 'pt'])) {
        $lang = $_GET['te_lang'];
    } elseif (strpos($_SERVER['REQUEST_URI'], '/en') !== false) {
        $lang = 'en';
    } elseif (strpos($_SERVER['REQUEST_URI'], '/es') !== false) {
        $lang = 'es';
    } else {
        $lang = 'pt';
    }
}

$tf = [
  'f_eyebrow' => ['pt' => 'Fonte Direta', 'en' => 'Direct Source', 'es' => 'Fuente Directa'],
  'f_title' => [
    'pt' => 'Solicite a Seleção Atual<br>de Rochas Ornamentais',
    'en' => 'Request the Current Selection<br>of Natural Stones',
    'es' => 'Solicite la Selección Actual<br>de Rocas Ornamentales'
  ],
  'f_sub' => [
    'pt' => 'Entre em contato para receber fotos de chapas, disponibilidade, informações sobre amostras e condições de exportação para a coleção completa.',
    'en' => 'Contact us to receive slab photos, availability, information about samples, and export conditions for the complete collection.',
    'es' => 'Contáctenos para recibir fotos de chapas, disponibilidad, información sobre muestras y condiciones de exportación para la colección completa.'
  ],
  'f_btn' => ['pt' => 'Solicitar Informações via WhatsApp', 'en' => 'Request Information via WhatsApp', 'es' => 'Solicitar Información vía WhatsApp'],
  'f_copy' => [
    'pt' => 'Trade Expansion — Brazilian Natural Stone Export & Sourcing',
    'en' => 'Trade Expansion — Brazilian Natural Stone Export & Sourcing',
    'es' => 'Trade Expansion — Brazilian Natural Stone Export & Sourcing'
  ],
  'f_links' => [
    'pt' => '<a href="/sobre-nos" style="color:inherit;text-decoration:none;">Sobre</a> &middot; <a href="/inspecao" style="color:inherit;text-decoration:none;">Inspeção</a> &middot; <a href="/contato" style="color:inherit;text-decoration:none;">Contato</a>',
    'en' => '<a href="/sobre-nos?te_lang=en" style="color:inherit;text-decoration:none;">About</a> &middot; <a href="/inspecao?te_lang=en" style="color:inherit;text-decoration:none;">Inspection</a> &middot; <a href="/contato?te_lang=en" style="color:inherit;text-decoration:none;">Contact</a>',
    'es' => '<a href="/sobre-nos?te_lang=es" style="color:inherit;text-decoration:none;">Sobre</a> &middot; <a href="/inspecao?te_lang=es" style="color:inherit;text-decoration:none;">Inspección</a> &middot; <a href="/contato?te_lang=es" style="color:inherit;text-decoration:none;">Contacto</a>'
  ],
  'f_tagline' => [
    'pt' => 'Operações para importadores na Europa, Ásia e América do Norte · Inspeções no ES, MG e BA',
    'en' => 'Operations for importers in Europe, Asia and North America · Inspections in Espírito Santo, Minas Gerais and Bahia',
    'es' => 'Operaciones para importadores en Europa, Asia y Norteamérica · Inspecciones en ES, MG y BA'
  ]
];

if (!function_exists('te_tf')) {
    function te_tf($key) {
        global $tf, $lang;
        return isset($tf[$key][$lang]) ? $tf[$key][$lang] : $tf[$key]['pt'];
    }
}
?>
  <!-- FOOTER / CONTACT -->
  <footer class="footer" id="contact" role="contentinfo">
    <p class="eyebrow"><?php echo te_tf('f_eyebrow'); ?></p>
    <h2 class="footer-title"><?php echo te_tf('f_title'); ?></h2>
    <p class="footer-sub"><?php echo te_tf('f_sub'); ?></p>
    <div class="footer-contacts">
      <a href="https://wa.me/5527992284517" target="_blank" rel="noopener" class="btn-whatsapp" id="footer-whatsapp">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
        </svg>
        <span><?php echo te_tf('f_btn'); ?></span>
      </a>
      <div style="display: flex; gap: 16px; margin-top: 12px; flex-wrap: wrap;">
          <a href="mailto:vitor@tradeexpansion.com.br" class="footer-email">vitor@tradeexpansion.com.br</a>
          <a href="mailto:valeria@tradeexpansion.com.br" class="footer-email">valeria@tradeexpansion.com.br</a>
      </div>
    </div>
    
    <div style="margin-top: 40px; text-align: center; font-size: 0.9rem; opacity: 0.8;">
        <p class="footer-copy" style="margin-bottom: 8px;">&copy; <?php echo date('Y'); ?> <?php echo te_tf('f_copy'); ?></p>
        <p style="margin-bottom: 8px;"><?php echo te_tf('f_links'); ?></p>
        <p class="footer-tagline" style="font-size: 0.8rem; opacity: 0.7; margin-bottom: 0;"><?php echo te_tf('f_tagline'); ?></p>
    </div>
  </footer>

  <!-- FLOATING CTA -->
  <a href="https://wa.me/5527992284517" target="_blank" rel="noopener" class="floating-cta" title="WhatsApp">
    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
  </a>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    /* Header scroll effect */
    const nav = document.getElementById('site-nav');
    if (nav) {
      const toggleNav = () => {
        nav.style.background = window.scrollY > 60 ? 'rgba(11,28,26,.97)' : 'rgba(11,28,26,.88)';
      };
      toggleNav();
      window.addEventListener('scroll', toggleNav, { passive: true });
    }

    /* Fade-in observer robusto */
    const faders = document.querySelectorAll('.fade-in-up');
    if (faders.length > 0) {
      if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
              obs.unobserve(entry.target);
            }
          });
        }, { rootMargin: '0px 0px -20px 0px', threshold: 0.05 });
        faders.forEach(el => obs.observe(el));
      } else {
        // Fallback para navegadores antigos
        faders.forEach(el => el.classList.add('visible'));
      }
    }

    /* Parallax sutil */
    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isCoarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
    if (!prefersReduced && !isCoarse) {
      const heroVideo = document.querySelector('.hero-video');
      const breakVideo = document.querySelector('.te-break-video');
      let ticking = false;
      window.addEventListener('scroll', () => {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(() => {
          const y = window.scrollY || 0;
          if (heroVideo) heroVideo.style.transform = `translate3d(0, ${Math.min(28, y * 0.08)}px, 0) scale(1.03)`;
          if (breakVideo) breakVideo.style.transform = `translate3d(0, ${Math.min(20, y * 0.05)}px, 0) scale(1.02)`;
          ticking = false;
        });
      }, { passive: true });
    }
  });
  </script>

  <?php wp_footer(); ?>
  <!-- Assistente IA Petra -->
  <script src="<?php echo get_template_directory_uri(); ?>/ai-assistente/chat-widget.js"></script>
</body>
</html>