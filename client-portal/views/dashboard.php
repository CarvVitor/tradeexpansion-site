<?php
/**
 * Dashboard View - Orchestrator
 */
$current_user = wp_get_current_user();
$reports = te_client_portal_fetch_reports($current_user->ID);
$inspections = te_client_portal_fetch_inspections($current_user->ID);

// Idioma baseado no cliente
$is_spanish_client = false;
$client_name = $current_user->display_name;
if (stripos($client_name, 'Magma') !== false || stripos($client_name, 'Global Marmol') !== false) {
  $is_spanish_client = true;
}

$can_edit_reports = current_user_can('edit_posts');
$can_view_financial = function_exists('tec_portal_user_has_financial') ? tec_portal_user_has_financial(get_current_user_id()) : false;
// Forçar financial true se for admin para teste ou se o usuário tiver meta específica
if (current_user_can('manage_options'))
  $can_view_financial = true;

$can_manage_inspections = current_user_can('upload_files');
if ($can_manage_inspections) {
  wp_enqueue_media();
}

$portal_tabs = [
  'home' => $is_spanish_client ? 'Inicio' : 'Início',
  'reports' => $is_spanish_client ? 'Informes' : 'Relatórios',
  'inspections' => $is_spanish_client ? 'Inspecciones' : 'Inspeções',
  'orders' => $is_spanish_client ? 'Pedidos' : 'Pedidos',
];

if ($can_view_financial) {
  $portal_tabs['financial'] = $is_spanish_client ? 'Financiero' : 'Financeiro';
}

$active_tab = 'home';
$reports_rest_nonce = wp_create_nonce('wp_rest');
$reports_rest_url = esc_url(rest_url('te/v1/report/'));
$inspection_rest_nonce = wp_create_nonce('wp_rest');
$inspection_rest_url = esc_url(rest_url('te/v1/inspecao/'));

// Carrega materiais para inspeção
$material_terms = get_terms(['taxonomy' => 'tec_material', 'hide_empty' => false]);
$material_options = [];
if (!is_wp_error($material_terms)) {
  foreach ($material_terms as $term) {
    $material_options[] = ['id' => $term->term_id, 'name' => $term->name];
  }
}
?>

<style>
  :root {
    --primary-gold: #D6A354;
    --deep-green: #0B1D1B;
    --glass-bg: rgba(11, 29, 27, 0.6);
    --glass-border: rgba(255, 255, 255, 0.05);
    --text-bright: #F1F1D9;
    --sans-font: 'Inter', sans-serif;
  }

  .luxury-portal {
    background-color: var(--deep-green);
    min-height: 100vh;
    color: var(--text-bright);
    font-family: 'Vollkorn', serif;
  }

  h1,
  h2,
  h3,
  h4,
  .editorial-title {
    letter-spacing: 0.15em !important;
    text-transform: uppercase;
    font-weight: 700;
  }

  .label-secondary {
    font-family: var(--sans-font);
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    font-size: 10px;
    color: rgba(241, 241, 217, 0.3);
  }

  .luxury-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 4px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .luxury-card:hover {
    transform: translateY(-1px);
    border-color: rgba(214, 163, 84, 0.3);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(214, 163, 84, 0.15);
  }

  .portal-tab {
    padding: 12px 24px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    color: rgba(241, 241, 217, 0.2);
    border: none;
    background: transparent;
    transition: all 0.3s;
    border-bottom: 2px solid transparent;
  }

  .portal-tab-active {
    color: var(--primary-gold);
    border-bottom: 2px solid var(--primary-gold);
  }

  .btn-minimalist {
    background: transparent;
    border: 1px solid rgba(214, 163, 84, 0.3);
    color: var(--primary-gold);
    padding: 10px 24px;
    border-radius: 100px;
    font-family: var(--sans-font);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: all 0.4s;
    cursor: pointer;
  }

  .btn-minimalist:hover {
    background: var(--primary-gold);
    color: var(--deep-green);
  }

  .hidden {
    display: none;
  }
</style>

<main class="luxury-portal py-20">
  <div class="max-w-7xl mx-auto px-6 space-y-12">
    <!-- Header -->
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between border-b border-white/5 pb-10">
      <div>
        <span
          class="label-secondary mb-3 block"><?php echo $is_spanish_client ? 'Inteligencia B2B' : 'Inteligência B2B'; ?></span>
        <h1 class="text-6xl font-bold mb-2 tracking-tighter">
          <?php printf($is_spanish_client ? 'Hola, %s' : 'Olá, %s', esc_html($current_user->display_name)); ?>
        </h1>
        <p class="text-white/30 text-xl font-light italic">
          <?php echo $is_spanish_client ? 'Gestión técnica y operativa de su portafolio.' : 'Gestão técnica e operativa de seu portfólio.'; ?>
        </p>
      </div>

      <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="te_client_logout">
        <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
        <button type="submit" class="label-secondary hover:text-rose-400 transition-colors flex items-center gap-3">
          <span><?php echo $is_spanish_client ? 'Salir' : 'Sair'; ?></span>
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          </svg>
        </button>
      </form>
    </div>

    <!-- Navigation Tabs -->
    <div class="luxury-card p-4 mb-12">
      <div class="flex flex-wrap items-center gap-1 border-b border-white/5">
        <?php $is_first = true; ?>
        <?php foreach ($portal_tabs as $slug => $label): ?>
          <button class="portal-tab <?php echo $is_first ? 'portal-tab-active' : ''; ?>"
            data-tab-target="<?php echo esc_attr($slug); ?>">
            <?php echo esc_html($label); ?>
          </button>
          <?php $is_first = false; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Tab Contents -->
    <div id="portal-tab-contents">
      <?php
      $partials = [
        'home' => 'tab-home.php',
        'reports' => 'tab-reports.php',
        'inspections' => 'tab-inspections.php',
        'orders' => 'tab-orders.php',
        'financial' => 'tab-financial.php'
      ];

      foreach ($partials as $slug => $file) {
        $path = get_template_directory() . '/client-portal/partials/' . $file;
        if (file_exists($path)) {
          include $path;
        }
      }
      ?>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Tab Switching Logic
    const tabs = document.querySelectorAll('.portal-tab');
    const panels = document.querySelectorAll('[data-tab-panel]');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = tab.dataset.tabTarget;

        tabs.forEach(t => t.classList.remove('portal-tab-active'));
        tab.classList.add('portal-tab-active');

        panels.forEach(p => {
          if (p.dataset.tabPanel === target) {
            p.classList.remove('hidden');
          } else {
            p.classList.add('hidden');
          }
        });
      });
    });
  });
</script>