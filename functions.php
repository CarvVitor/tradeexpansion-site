<?php
// Funções básicas do tema Trade Expansion
function tradeexpansion_setup() {
  // Suporte a título, logo, imagens destacadas
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');

  // Ativa suporte a tradução
  load_theme_textdomain('tradeexpansion', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'tradeexpansion_setup');

$portal_loader = get_template_directory() . '/client-portal/portal-loader.php';
if (file_exists($portal_loader)) {
  require_once $portal_loader;
}

/* ==== TRADEEXPANSION • CLIENT PORTAL – ROTAS, GUARDAS E TEMPLATE MAP ==== */

// 1) Query vars + rewrite tags + regras
add_action('init', function () {
    // Registra tags para as variáveis de rota
    add_rewrite_tag('%tec_portal%', '([^&]+)');
    add_rewrite_tag('%lang%', '([^&]+)');

    // Sem prefixo de idioma
    add_rewrite_rule('^area-do-cliente/?$', 'index.php?tec_portal=login', 'top');
    add_rewrite_rule('^dashboard/?$', 'index.php?tec_portal=dashboard', 'top');

    // Com prefixo de idioma (pt ou en)
    add_rewrite_rule('^(pt|en)/area-do-cliente/?$', 'index.php?tec_portal=login&lang=$matches[1]', 'top');
    add_rewrite_rule('^(pt|en)/dashboard/?$', 'index.php?tec_portal=dashboard&lang=$matches[1]', 'top');
});

// 2) Permite as query vars
add_filter('query_vars', function ($vars) {
    $vars[] = 'tec_portal';
    $vars[] = 'lang';
    return $vars;
});

// 3) Role "cliente" ao ativar o tema + flush de rewrites
add_action('after_switch_theme', function () {
    if (!get_role('cliente')) {
        add_role('cliente', 'Cliente', ['read' => true]);
    }
    flush_rewrite_rules();
});

// 4) Redireciona cliente que tentar acessar /wp-admin (exceto AJAX)
add_action('admin_init', function () {
    if (is_user_logged_in()) {
        $u = wp_get_current_user();
        if (in_array('cliente', (array) $u->roles, true) && !(defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(home_url('/dashboard'));
            exit;
        }
    }
});

// 5) Router: seleciona o template correto (prefere /client-portal/views)
add_filter('template_include', function ($template) {
    $portal = get_query_var('tec_portal');
    if (!$portal) return $template;

    $base  = get_template_directory() . '/client-portal';
    $views = $base . '/views';

    $resolve = function ($name) use ($base, $views) {
        $viewFile = $views . '/' . $name . '.php';
        $rootFile = $base  . '/' . $name . '.php';
        if (file_exists($viewFile)) return $viewFile;
        if (file_exists($rootFile)) return $rootFile;
        return false;
    };

    if ($portal === 'login') {
        $file = $resolve('login');
        return $file ? $file : $template;
    }

    if ($portal === 'dashboard') {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/area-do-cliente'));
            exit;
        }
        $file = $resolve('dashboard');
        return $file ? $file : $template;
    }

    return $template;
});

/* ==== /CLIENT PORTAL ==== */

/* ==== TRADEEXPANSION • CLIENT PORTAL – EDITÁVEL PELO ADMIN ==== */
/**
 * 1) Registra CPTs para: Relatórios, Inspeções e Financeiro (apenas no Admin, sem páginas públicas)
 * 2) Metaboxes para associar cada item a um usuário com role `cliente`
 * 3) Campos específicos por tipo (status, valor, vencimento, PDF etc.)
 */

add_action('init', function () {
  // Relatórios
  register_post_type('tec_relatorio', [
    'labels' => [
      'name' => 'Relatórios',
      'singular_name' => 'Relatório',
      'add_new_item' => 'Adicionar Relatório',
      'edit_item' => 'Editar Relatório',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-media-document',
    'supports' => ['title', 'editor', 'thumbnail'], // editor livre para notas
  ]);

  // Inspeções
  register_post_type('tec_inspecao', [
    'labels' => [
      'name' => 'Inspeções',
      'singular_name' => 'Inspeção',
      'add_new_item' => 'Adicionar Inspeção',
      'edit_item' => 'Editar Inspeção',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-search',
    'supports' => ['title', 'editor', 'thumbnail'], // use o conteúdo para observações; imagens anexas ao post
  ]);

  // Financeiro (lançamentos)
  register_post_type('tec_financeiro', [
    'labels' => [
      'name' => 'Financeiro',
      'singular_name' => 'Lançamento',
      'add_new_item' => 'Adicionar Lançamento',
      'edit_item' => 'Editar Lançamento',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-chart-pie',
    'supports' => ['title'], // campos virão via metaboxes
  ]);
});

/** Utils */
function tec_get_client_users() {
  return get_users(['role' => 'cliente', 'fields' => ['ID','display_name']]);
}
function tec_select_cliente_field($post, $selected_id) {
  $clientes = tec_get_client_users();
  echo '<label for="tec_cliente_id">Cliente: </label>';
  echo '<select id="tec_cliente_id" name="tec_cliente_id">';
  echo '<option value="">— selecione —</option>';
  foreach ($clientes as $u) {
    $sel = selected((int)$selected_id, (int)$u->ID, false);
    printf('<option value="%d" %s>%s</option>', (int)$u->ID, $sel, esc_html($u->display_name));
  }
  echo '</select>';
  wp_nonce_field('tec_save_meta','tec_meta_nonce');
}

/** Metaboxes */
add_action('add_meta_boxes', function () {
  // Relatório: cliente + status + PDF
  add_meta_box('tec_relatorio_meta', 'Dados do Relatório', function ($post) {
    $cliente_id = get_post_meta($post->ID, 'tec_cliente_id', true);
    $status     = get_post_meta($post->ID, 'tec_status', true); // aprovado|pendente|reprovado
    $pdf_url    = get_post_meta($post->ID, 'tec_pdf_url', true);

    tec_select_cliente_field($post, $cliente_id);

    echo '<p><label for="tec_status">Status: </label>';
    echo '<select id="tec_status" name="tec_status">';
    foreach (['aprovado'=>'Aprovado','pendente'=>'Pendente','reprovado'=>'Reprovado'] as $val=>$label) {
      $sel = selected($status, $val, false);
      echo "<option value='{$val}' {$sel}>{$label}</option>";
    }
    echo '</select></p>';

    echo '<p><label for="tec_pdf_url">URL do PDF: </label>';
    printf('<input type="url" id="tec_pdf_url" name="tec_pdf_url" value="%s" class="regular-text" placeholder="https://...pdf" />', esc_attr($pdf_url));
    echo '</p>';

    echo '<p><em>Dica:</em> use a Imagem Destacada para uma thumbnail do relatório e o Editor para notas/resumo.</p>';
  }, 'tec_relatorio', 'normal', 'default');

  // Inspeção: cliente (observações via editor; imagens anexadas ao post)
  add_meta_box('tec_inspecao_meta', 'Dados da Inspeção', function ($post) {
    $cliente_id = get_post_meta($post->ID, 'tec_cliente_id', true);
    tec_select_cliente_field($post, $cliente_id);
    echo '<p>Use o <strong>Editor</strong> para observações e anexe fotos a este post (serão exibidas no portal).</p>';
  }, 'tec_inspecao', 'normal', 'default');

  // Financeiro: cliente + valor + vencimento + status
  add_meta_box('tec_financeiro_meta', 'Dados Financeiros', function ($post) {
    $cliente_id = get_post_meta($post->ID, 'tec_cliente_id', true);
    $valor      = get_post_meta($post->ID, 'tec_valor', true);
    $venc       = get_post_meta($post->ID, 'tec_vencimento', true);
    $fstatus    = get_post_meta($post->ID, 'tec_fin_status', true); // pago|pendente

    tec_select_cliente_field($post, $cliente_id);

    echo '<p><label for="tec_valor">Valor (R$): </label>';
    printf('<input type="number" step="0.01" id="tec_valor" name="tec_valor" value="%s" />', esc_attr($valor));
    echo '</p>';

    echo '<p><label for="tec_vencimento">Vencimento: </label>';
    printf('<input type="date" id="tec_vencimento" name="tec_vencimento" value="%s" />', esc_attr($venc));
    echo '</p>';

    echo '<p><label for="tec_fin_status">Status: </label>';
    echo '<select id="tec_fin_status" name="tec_fin_status">';
    foreach (['pendente'=>'Pendente','pago'=>'Pago'] as $val=>$label) {
      $sel = selected($fstatus, $val, false);
      echo "<option value='{$val}' {$sel}>{$label}</option>";
    }
    echo '</select></p>';
  }, 'tec_financeiro', 'normal', 'default');
});

/** Save meta */
add_action('save_post', function ($post_id) {
  if (!isset($_POST['tec_meta_nonce']) || !wp_verify_nonce($_POST['tec_meta_nonce'],'tec_save_meta')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  $map = [
    'tec_relatorio' => ['tec_cliente_id','tec_status','tec_pdf_url'],
    'tec_inspecao'  => ['tec_cliente_id'],
    'tec_financeiro'=> ['tec_cliente_id','tec_valor','tec_vencimento','tec_fin_status'],
  ];
  $post_type = get_post_type($post_id);
  if (!isset($map[$post_type])) return;

  foreach ($map[$post_type] as $key) {
    if (isset($_POST[$key])) {
      $val = $_POST[$key];
      if ($key === 'tec_cliente_id') $val = (int)$val;
      update_post_meta($post_id, $key, sanitize_text_field($val));
    } else {
      delete_post_meta($post_id, $key);
    }
  }
});
/* ==== /CLIENT PORTAL – EDITÁVEL ==== */