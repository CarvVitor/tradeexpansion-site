<?php
/*
Template Name: Portal – Dashboard
Description: Página do Dashboard do Cliente (consistente com o tema principal).
*/

if (!defined('ABSPATH'))
  exit;

// Se não estiver logado, manda pro login do portal
if (!is_user_logged_in()) {
  wp_redirect(home_url('/area-do-cliente'));
  exit;
}

// Noindex (evita indexar área privada)
add_action('wp_head', function () {
  echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

// Admin preview mode: permite admin visualizar como cliente
// Use: /portal-dashboard/?preview=cliente
$te_preview_role = '';
if (current_user_can('manage_options') && isset($_GET['preview'])) {
  $te_preview_role = sanitize_text_field(wp_unslash($_GET['preview']));
}

// (Opcional) esconder admin bar para clientes (ou quando admin estiver simulando cliente)
add_action('after_setup_theme', function () use ($te_preview_role) {
  $u = wp_get_current_user();
  $is_cliente = ($u && in_array('cliente', (array) $u->roles, true));

  if ($is_cliente || $te_preview_role === 'cliente') {
    show_admin_bar(false);
  }
});

// --- CONTEÚDO EDITÁVEL DA PÁGINA ---
// Você pode usar o editor do WP para um intro/aviso no topo do dashboard.
ob_start();
if (have_posts()) {
  while (have_posts()) {
    the_post();
  }
  $intro = apply_filters('the_content', get_the_content(null, false, get_the_ID()));
} else {
  $intro = '';
}
$intro_html = trim($intro);

// Renderizamos o dashboard existente
$dashboard_view = get_template_directory() . '/client-portal/views/dashboard.php';

get_header();
?>

<style>
  /* =====================================================================
     Trade Expansion — Portal / Dashboard (P0)
     Contraste + consistência + premium feel
     ===================================================================== */
  :root {
    --te-forest: #102724;
    --te-cream: #F1F1D9;
    --te-gold: #D6A354;
    --te-ink: #1D1F1E;
  }

  /* Garante fundo e legibilidade mesmo que o portal tenha CSS próprio */
  body {
    background: var(--te-forest);
    color: rgba(241, 241, 217, 0.92);
  }

  .te-portal-wrap {
    background: radial-gradient(1200px 600px at 50% 0%, rgba(214, 163, 84, 0.12), transparent 60%),
      linear-gradient(180deg, rgba(16, 39, 36, 1) 0%, rgba(11, 27, 24, 1) 100%);
    min-height: 100vh;
  }

  /* Intro do WP (quando usado) */
  .te-portal-intro {
    padding: 2.4rem 1.5rem;
    border-bottom: 1px solid rgba(241, 241, 217, 0.10);
    background: rgba(0, 0, 0, 0.18);
    backdrop-filter: blur(8px);
  }

  .te-portal-intro .prose,
  .te-portal-intro .prose * {
    color: rgba(241, 241, 217, 0.92) !important;
  }

  /* Loader frosted (padrão premium do site) */
  #te-loader {
    position: fixed;
    inset: 0;
    background: rgba(241, 241, 217, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity .85s ease, visibility .85s ease;
  }

  #te-loader .te-loader__inner {
    text-align: center;
  }

  #te-loader .te-loader__spin {
    width: 54px;
    height: 54px;
    border: 2px solid rgba(16, 39, 36, 0.22);
    border-top-color: rgba(214, 163, 84, 0.95);
    border-radius: 9999px;
    animation: teSpin 1s linear infinite;
    margin: 0 auto 1rem;
  }

  #te-loader .te-loader__txt {
    font-family: 'Vollkorn', Georgia, serif;
    font-size: .85rem;
    letter-spacing: .32em;
    text-transform: uppercase;
    color: rgba(16, 39, 36, 0.82);
  }

  @keyframes teSpin {
    to {
      transform: rotate(360deg);
    }
  }

  /* Pequeno badge de preview para admin */
  .te-preview-badge {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: .55rem .95rem;
    border-radius: 9999px;
    border: 1px solid rgba(214, 163, 84, 0.25);
    background: rgba(214, 163, 84, 0.12);
    color: rgba(241, 241, 217, 0.92);
    font-family: 'Vollkorn', Georgia, serif;
    font-size: .78rem;
    letter-spacing: .18em;
    text-transform: uppercase;
  }

  .te-preview-badge a {
    color: rgba(241, 241, 217, 0.92);
    text-decoration: underline;
    text-underline-offset: 3px;
  }
</style>

<!-- Loader (Premium Frosted) -->
<div id="te-loader" aria-hidden="true">
  <div class="te-loader__inner">
    <div class="te-loader__spin"></div>
    <div class="te-loader__txt">Carregando seu painel…</div>
  </div>
</div>

<main class="te-portal-wrap" id="primary">

  <?php if (current_user_can('manage_options')): ?>
    <section class="px-6 md:px-12 pt-6">
      <div class="max-w-6xl mx-auto flex items-center justify-between flex-wrap gap-3">
        <?php if ($te_preview_role === 'cliente'): ?>
          <span class="te-preview-badge">👁️ Preview: Cliente <a
              href="<?php echo esc_url(remove_query_arg('preview')); ?>">sair</a></span>
        <?php else: ?>
          <span class="te-preview-badge">⚙️ Admin <a href="<?php echo esc_url(add_query_arg('preview', 'cliente')); ?>">ver
              como cliente</a></span>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>

  <?php if ($intro_html): ?>
    <section class="te-portal-intro">
      <div class="max-w-6xl mx-auto prose prose-invert">
        <?php echo $intro_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>
    </section>
  <?php endif; ?>

  <?php
  if (file_exists($dashboard_view)) {
    // Expõe uma flag para o view saber que está embutido no tema principal (se você quiser usar depois)
    $TE_DASHBOARD_EMBEDDED = true;

    require $dashboard_view;
  } else {
    echo '<section class="px-6 md:px-12 py-16"><div class="max-w-6xl mx-auto">'
      . '<h1 style="color: var(--te-cream); font-family: Vollkorn, serif; font-size: 2rem; text-transform: uppercase; letter-spacing: .06em;">Dashboard</h1>'
      . '<p style="color: rgba(241,241,217,0.82); margin-top: .75rem;">Arquivo do portal não encontrado.</p>'
      . '</div></section>';
  }
  ?>

</main>

<script>
  // Loader
  window.addEventListener('load', function () {
    const loader = document.getElementById('te-loader');
    if (!loader) return;

    setTimeout(function () {
      loader.style.opacity = '0';
      loader.style.visibility = 'hidden';

      setTimeout(function () {
        loader.remove();
      }, 900);
    }, 520);
  });
</script>

<?php
get_footer();