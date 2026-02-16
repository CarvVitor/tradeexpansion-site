<?php
// Funções básicas do tema Trade Expansion
function tradeexpansion_setup()
{
  // Suporte a título, logo, imagens destacadas
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  // Registra a localização do menu principal (usado no header)
  register_nav_menus([
    'primary' => __('Menu Principal', 'tradeexpansion'),
  ]);

  // Ativa suporte a tradução
  load_theme_textdomain('tradeexpansion', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'tradeexpansion_setup');

// Esconde admin bar no front-end para clientes
add_filter('show_admin_bar', function ($show) {
  if (is_admin())
    return $show;
  if (!is_user_logged_in())
    return $show;
  $u = wp_get_current_user();
  if ($u && in_array('cliente', (array) $u->roles, true)) {
    return false;
  }
  return $show;
});

add_action('wp_head', function () {
  if (!is_user_logged_in() || is_admin())
    return;
  $u = wp_get_current_user();
  if ($u && in_array('cliente', (array) $u->roles, true)) {
    echo '<style>#wpadminbar{display:none!important}</style>';
  }
}, 99);

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
  $vars[] = 'tec_export';
  $vars[] = 'tec_export_post';
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
  if (!$portal)
    return $template;

  $base = get_template_directory() . '/client-portal';
  $views = $base . '/views';

  $resolve = function ($name) use ($base, $views) {
    $viewFile = $views . '/' . $name . '.php';
    $rootFile = $base . '/' . $name . '.php';
    if (file_exists($viewFile))
      return $viewFile;
    if (file_exists($rootFile))
      return $rootFile;
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
    // Use the page template wrapper (with get_header/get_footer/loader)
    // instead of loading views/dashboard.php directly without any layout.
    $page_template = get_template_directory() . '/page-portal-dashboard.php';
    if (file_exists($page_template)) {
      return $page_template;
    }
    $file = $resolve('dashboard');
    return $file ? $file : $template;
  }

  return $template;
});

/* ==== /CLIENT PORTAL ==== */

// Enfileira o CSS específico do portal/client-report
add_action('wp_enqueue_scripts', function () {
  if (get_query_var('tec_portal') || is_page_template('page-portal-dashboard.php')) {
    $css = get_template_directory() . '/client-portal/css/client-dashboard.css';
    $ver = file_exists($css) ? filemtime($css) : wp_get_theme()->get('Version');
    wp_enqueue_style(
      'tradeexpansion-client-dashboard',
      get_template_directory_uri() . '/client-portal/css/client-dashboard.css',
      [],
      $ver
    );
  }
});

/* ==== CLIENT PORTAL • SETTINGS PAGE ==== */
add_action('admin_init', 'tec_portal_register_settings');
function tec_portal_register_settings()
{
  register_setting('tece_portal', 'tece_fin_url', [
    'type' => 'string',
    'sanitize_callback' => 'tec_portal_sanitize_fin_url',
    'default' => '',
  ]);

  register_setting('tece_portal', 'tece_fin_cache_minutes', [
    'type' => 'integer',
    'sanitize_callback' => 'tec_portal_sanitize_cache_minutes',
    'default' => 5,
  ]);

  register_setting('tece_portal', 'tece_primary_color', [
    'type' => 'string',
    'sanitize_callback' => 'tec_portal_sanitize_primary_color',
    'default' => '#102724',
  ]);

  add_settings_section(
    'tece_portal_finance',
    __('Integrações e Aparência', 'tradeexpansion'),
    function () {
      echo '<p>Configure o endpoint financeiro, o cache e a cor principal utilizada no client portal.</p>';
    },
    'tece_portal'
  );

  add_settings_field(
    'tece_fin_url',
    __('Endpoint Financeiro (Google Sheets / API)', 'tradeexpansion'),
    'tec_portal_field_fin_url',
    'tece_portal',
    'tece_portal_finance'
  );

  add_settings_field(
    'tece_fin_cache_minutes',
    __('Cache (minutos)', 'tradeexpansion'),
    'tec_portal_field_fin_cache',
    'tece_portal',
    'tece_portal_finance'
  );

  add_settings_field(
    'tece_primary_color',
    __('Cor Primária do Portal', 'tradeexpansion'),
    'tec_portal_field_primary_color',
    'tece_portal',
    'tece_portal_finance'
  );
}

add_action('admin_menu', function () {
  add_options_page(
    __('Portal do Cliente', 'tradeexpansion'),
    __('Portal do Cliente', 'tradeexpansion'),
    'manage_options',
    'tece-portal',
    'tec_portal_settings_page'
  );
});

function tec_portal_settings_page()
{
  if (!current_user_can('manage_options')) {
    return;
  }
  ?>
  <div class="wrap">
    <h1><?php esc_html_e('Portal do Cliente', 'tradeexpansion'); ?></h1>
    <p><?php esc_html_e('Ajuste integrações e branding do Client Portal.', 'tradeexpansion'); ?></p>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
      <?php
      settings_fields('tece_portal');
      do_settings_sections('tece_portal');
      submit_button();
      ?>
    </form>
  </div>
  <?php
}

function tec_portal_field_fin_url()
{
  $value = esc_url(get_option('tece_fin_url', ''));
  echo '<input type="url" class="regular-text" name="tece_fin_url" id="tece_fin_url" value="' . $value . '" placeholder="https://script.google.com/...">';
  echo '<p class="description">' . esc_html__('URL do Apps Script/endpoint que retorna os dados financeiros em JSON.', 'tradeexpansion') . '</p>';
}

function tec_portal_field_fin_cache()
{
  $value = (int) get_option('tece_fin_cache_minutes', 5);
  echo '<input type="number" min="1" step="1" name="tece_fin_cache_minutes" id="tece_fin_cache_minutes" value="' . esc_attr($value) . '">';
  echo '<p class="description">' . esc_html__('Tempo em minutos que os dados da API permanecem em cache.', 'tradeexpansion') . '</p>';
}

function tec_portal_field_primary_color()
{
  $value = esc_attr(get_option('tece_primary_color', '#102724'));
  echo '<input type="text" class="regular-text" name="tece_primary_color" id="tece_primary_color" value="' . $value . '" placeholder="#102724">';
  echo '<p class="description">' . esc_html__('Hexadecimal da cor principal do dashboard (ex: #102724).', 'tradeexpansion') . '</p>';
}

function tec_portal_sanitize_fin_url($value)
{
  $value = trim((string) $value);
  if ($value === '') {
    return '';
  }

  if (!filter_var($value, FILTER_VALIDATE_URL)) {
    add_settings_error('tece_fin_url', 'tece_fin_url_invalid', __('Informe uma URL válida para o endpoint financeiro.', 'tradeexpansion'));
    return get_option('tece_fin_url', '');
  }

  return esc_url_raw($value);
}

function tec_portal_sanitize_cache_minutes($value)
{
  $value = absint($value);
  if ($value < 1) {
    add_settings_error('tece_fin_cache_minutes', 'tece_fin_cache_minutes_invalid', __('Defina pelo menos 1 minuto de cache.', 'tradeexpansion'));
    $value = 1;
  }
  return $value;
}

function tec_portal_sanitize_primary_color($value)
{
  $value = trim((string) $value);
  if ($value === '') {
    return '#102724';
  }

  if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $value)) {
    add_settings_error('tece_primary_color', 'tece_primary_color_invalid', __('Informe uma cor hexadecimal válida (ex: #102724).', 'tradeexpansion'));
    return get_option('tece_primary_color', '#102724');
  }

  return strtoupper($value);
}

/* ==== CLIENT PORTAL • REST ENDPOINTS ==== */
add_action('rest_api_init', function () {
  register_rest_route('te/v1', '/report/(?P<id>\d+)', [
    'methods' => WP_REST_Server::EDITABLE,
    'callback' => 'tec_portal_rest_update_report',
    'permission_callback' => function ($request) {
      $post_id = (int) $request['id'];
      return current_user_can('edit_post', $post_id);
    },
    'args' => [
      'title' => [
        'type' => 'string',
        'required' => false,
      ],
      'content' => [
        'type' => 'string',
        'required' => false,
      ],
    ],
  ]);

  register_rest_route('te/v1', '/inspecao/(?P<id>\d+)', [
    'methods' => WP_REST_Server::CREATABLE,
    'callback' => 'tec_portal_rest_attach_inspection_media',
    'permission_callback' => function ($request) {
      $post_id = (int) $request['id'];
      return current_user_can('edit_post', $post_id) && current_user_can('upload_files');
    },
    'args' => [
      'attachments' => [
        'type' => 'array',
        'required' => true,
      ],
    ],
  ]);
});

function tec_portal_rest_update_report(WP_REST_Request $request)
{
  $post_id = (int) $request['id'];
  $post = get_post($post_id);

  if (!$post || $post->post_type !== 'tec_relatorio') {
    return new WP_Error('te_report_not_found', __('Relatório não encontrado.', 'tradeexpansion'), ['status' => 404]);
  }

  $data = ['ID' => $post_id];
  $has_changes = false;

  if ($request->offsetExists('title')) {
    $data['post_title'] = sanitize_text_field($request['title']);
    $has_changes = true;
  }

  if ($request->offsetExists('content')) {
    $data['post_content'] = wp_kses_post($request['content']);
    $has_changes = true;
  }

  if ($has_changes) {
    $result = wp_update_post($data, true);
    if (is_wp_error($result)) {
      return $result;
    }

    $post = get_post($post_id);
  }

  return new WP_REST_Response([
    'id' => $post_id,
    'title' => $post->post_title,
    'content' => $post->post_content,
    'note' => wp_strip_all_tags($post->post_content),
  ]);
}

function tec_portal_rest_attach_inspection_media(WP_REST_Request $request)
{
  $post_id = (int) $request['id'];
  $post = get_post($post_id);

  if (!$post || $post->post_type !== 'tec_inspecao') {
    return new WP_Error('te_inspection_not_found', __('Inspeção não encontrada.', 'tradeexpansion'), ['status' => 404]);
  }

  $items = $request->get_param('attachments');
  if (!is_array($items) || empty($items)) {
    return new WP_Error('te_no_attachments', __('Selecione ao menos uma imagem para enviar.', 'tradeexpansion'), ['status' => 400]);
  }

  foreach ($items as $item) {
    $attachment_id = 0;
    $material_value = isset($item['tec_material']) ? $item['tec_material'] : '';
    $note_value = isset($item['tec_obs']) ? $item['tec_obs'] : '';

    if (!empty($item['id'])) {
      $attachment_id = (int) $item['id'];
      $attachment = get_post($attachment_id);
      if (!$attachment || $attachment->post_type !== 'attachment') {
        continue;
      }
    } elseif (!empty($item['url'])) {
      $attachment_id = tec_portal_sideload_attachment($item['url'], $post_id);
    }

    if (!$attachment_id) {
      continue;
    }

    wp_update_post([
      'ID' => $attachment_id,
      'post_parent' => $post_id,
    ]);

    if ($note_value !== '') {
      update_post_meta($attachment_id, 'tec_obs', sanitize_text_field($note_value));
    }

    if ($material_value !== '') {
      tec_portal_assign_material_term($attachment_id, $material_value);
    }
  }

  $data = te_client_portal_prepare_inspection($post);
  return rest_ensure_response($data);
}

function tec_portal_assign_material_term($attachment_id, $value)
{
  if (is_numeric($value)) {
    $term_id = (int) $value;
    if ($term_id > 0) {
      wp_set_object_terms($attachment_id, $term_id, 'tec_material', false);
    }
    return;
  }

  $value = sanitize_text_field($value);
  if ($value === '') {
    return;
  }

  $term = term_exists($value, 'tec_material');
  if (!$term) {
    $term = wp_insert_term($value, 'tec_material');
  }

  if (!is_wp_error($term)) {
    wp_set_object_terms($attachment_id, (int) $term['term_id'], 'tec_material', false);
  }
}

function tec_portal_sideload_attachment($url, $post_id)
{
  if (!$url) {
    return 0;
  }

  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $attachment_id = media_sideload_image(esc_url_raw($url), $post_id, null, 'id');
  if (is_wp_error($attachment_id)) {
    return 0;
  }

  return $attachment_id;
}

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
    'show_in_rest' => true,
    'template_lock' => 'insert',
    'template' => [
      [
        'core/cover',
        ['dimRatio' => 40, 'useFeaturedImage' => true],
        [
          ['core/heading', ['level' => 1, 'placeholder' => 'Título do relatório']],
          ['core/paragraph', ['placeholder' => 'Resumo curto do relatório (2–3 linhas)...']],
        ]
      ],
      ['core/spacer', ['height' => '24px']],
      [
        'core/group',
        ['layout' => ['type' => 'constrained']],
        [
          ['core/heading', ['level' => 3, 'content' => 'Dados principais']],
          [
            'core/list',
            [],
            [
              ['core/list-item', ['content' => 'Cliente: <strong>preencha aqui</strong>']],
              ['core/list-item', ['content' => 'Status: <strong>aprovado/pendente/reprovado</strong>']],
              ['core/list-item', ['content' => 'Data: <strong>dd/mm/aaaa</strong>']],
            ]
          ],
        ]
      ],
      ['core/spacer', ['height' => '12px']],
      ['core/heading', ['level' => 3, 'content' => 'Conteúdo']],
      ['core/paragraph', ['placeholder' => 'Descreva resultados, observações, itens inspecionados...']],
      ['core/spacer', ['height' => '12px']],
      ['core/file', []],
    ],
  ]);

  // Inspeções
  register_post_type('tec_inspecao', [
    'labels' => [
      'name' => 'Inspeções (internas)',
      'singular_name' => 'Inspeção (interna)',
      'add_new_item' => 'Adicionar Inspeção',
      'edit_item' => 'Editar Inspeção',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => 'edit.php?post_type=tec_relatorio',
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

/* ==== ADMIN LIST COLUMNS FOR CPTs ==== */

function tec_portal_get_client_name($user_id)
{
  $user = $user_id ? get_user_by('id', (int) $user_id) : null;
  return $user ? ($user->display_name ?: $user->user_login) : __('Sem cliente', 'tradeexpansion');
}

// Relatórios
add_filter('manage_tec_relatorio_posts_columns', function ($columns) {
  $new = [
    'cb' => $columns['cb'],
    'title' => __('Relatório', 'tradeexpansion'),
    'cliente' => __('Cliente', 'tradeexpansion'),
    'status' => __('Status', 'tradeexpansion'),
    'date' => $columns['date'] ?? __('Data', 'tradeexpansion'),
  ];
  return $new;
});

add_action('manage_tec_relatorio_posts_custom_column', function ($column, $post_id) {
  switch ($column) {
    case 'cliente':
      $client_id = (int) get_post_meta($post_id, 'tec_cliente_id', true);
      echo esc_html(tec_portal_get_client_name($client_id));
      break;
    case 'status':
      $status = get_post_meta($post_id, 'tec_status', true) ?: 'pendente';
      echo esc_html(te_client_portal_format_report_status($status));
      break;
  }
}, 10, 2);

add_filter('manage_edit-tec_relatorio_sortable_columns', function ($columns) {
  $columns['cliente'] = 'cliente';
  $columns['status'] = 'status';
  return $columns;
});

// Inspeções
add_filter('manage_tec_inspecao_posts_columns', function ($columns) {
  $new = [
    'cb' => $columns['cb'],
    'title' => __('Inspeção', 'tradeexpansion'),
    'cliente' => __('Cliente', 'tradeexpansion'),
    'total_m2' => __('Total m²', 'tradeexpansion'),
    'date' => $columns['date'] ?? __('Data', 'tradeexpansion'),
  ];
  return $new;
});

if (!function_exists('tec_portal_calculate_total_m2')) {
  function tec_portal_calculate_total_m2($post_id)
  {
    $raw = get_post_meta($post_id, 'tec_slabs_json', true);
    if (!$raw) {
      return 0;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
      return 0;
    }

    $total = 0;
    foreach ($decoded as $slab) {
      $c = isset($slab['C']) ? $slab['C'] : (isset($slab['c']) ? $slab['c'] : (isset($slab['comprimento']) ? $slab['comprimento'] : 0));
      $h = isset($slab['H']) ? $slab['H'] : (isset($slab['h']) ? $slab['h'] : (isset($slab['altura']) ? $slab['altura'] : 0));
      $q = isset($slab['Qtd']) ? $slab['Qtd'] : (isset($slab['qtd']) ? $slab['qtd'] : (isset($slab['quantidade']) ? $slab['quantidade'] : 1));

      $c = (float) $c;
      $h = (float) $h;
      $q = (float) $q;
      if ($c > 0 && $h > 0 && $q > 0) {
        $total += ($c * $h * $q);
      }
    }

    return $total;
  }
}

add_filter('manage_edit-tec_inspecao_sortable_columns', function ($columns) {
  $columns['cliente'] = 'cliente';
  return $columns;
});

// Financeiro
add_filter('manage_tec_financeiro_posts_columns', function ($columns) {
  $new = [
    'cb' => $columns['cb'],
    'title' => __('Lançamento', 'tradeexpansion'),
    'cliente' => __('Cliente', 'tradeexpansion'),
    'valor' => __('Valor (R$)', 'tradeexpansion'),
    'status' => __('Status', 'tradeexpansion'),
    'vencimento' => __('Vencimento', 'tradeexpansion'),
    'date' => $columns['date'] ?? __('Data', 'tradeexpansion'),
  ];
  return $new;
});

add_action('manage_tec_financeiro_posts_custom_column', function ($column, $post_id) {
  switch ($column) {
    case 'cliente':
      $client_id = (int) get_post_meta($post_id, 'tec_cliente_id', true);
      echo esc_html(tec_portal_get_client_name($client_id));
      break;
    case 'valor':
      $valor = (float) get_post_meta($post_id, 'tec_valor', true);
      echo $valor ? 'R$ ' . esc_html(number_format_i18n($valor, 2)) : '&mdash;';
      break;
    case 'status':
      $status = get_post_meta($post_id, 'tec_fin_status', true);
      echo $status ? esc_html(ucfirst($status)) : '&mdash;';
      break;
    case 'vencimento':
      $date = get_post_meta($post_id, 'tec_vencimento', true);
      echo $date ? esc_html(date_i18n('d/m/Y', strtotime($date))) : '&mdash;';
      break;
  }
}, 10, 2);

add_filter('manage_edit-tec_financeiro_sortable_columns', function ($columns) {
  $columns['cliente'] = 'cliente';
  $columns['valor'] = 'valor';
  $columns['status'] = 'status';
  $columns['vencimento'] = 'vencimento';
  return $columns;
});

add_action('pre_get_posts', function ($query) {
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  $orderby = $query->get('orderby');
  $post_type = $query->get('post_type');

  if (!$orderby || !$post_type) {
    return;
  }

  if (in_array($post_type, ['tec_relatorio', 'tec_inspecao', 'tec_financeiro'], true)) {
    if ($orderby === 'cliente') {
      $query->set('meta_key', 'tec_cliente_id');
      $query->set('orderby', 'meta_value_num');
    } elseif ($post_type === 'tec_relatorio' && $orderby === 'status') {
      $query->set('meta_key', 'tec_status');
      $query->set('orderby', 'meta_value');
    } elseif ($post_type === 'tec_financeiro') {
      if ($orderby === 'valor') {
        $query->set('meta_key', 'tec_valor');
        $query->set('orderby', 'meta_value_num');
      } elseif ($orderby === 'status') {
        $query->set('meta_key', 'tec_fin_status');
        $query->set('orderby', 'meta_value');
      } elseif ($orderby === 'vencimento') {
        $query->set('meta_key', 'tec_vencimento');
        $query->set('orderby', 'meta_value');
      }
    }
  }
});

add_action('transition_post_status', function ($new_status, $old_status, $post) {
  if ($post->post_type !== 'tec_relatorio') {
    return;
  }

  if ('publish' !== $new_status || 'publish' === $old_status) {
    return;
  }

  if (wp_is_post_revision($post->ID)) {
    return;
  }

  $client_id = (int) get_post_meta($post->ID, 'tec_cliente_id', true);
  if (!$client_id) {
    return;
  }

  $user = get_user_by('id', $client_id);
  if (!$user || !is_email($user->user_email)) {
    return;
  }

  $portal_url = home_url('/dashboard/');
  $subject = __('Novo relatório disponível', 'tradeexpansion');
  $message = sprintf(
    __("Olá %s,\n\nUm novo relatório foi publicado no portal da Trade Expansion.\nAcesse: %s\n\nObrigado!", 'tradeexpansion'),
    $user->display_name ?: $user->user_login,
    $portal_url
  );

  wp_mail($user->user_email, $subject, $message);
}, 10, 3);

/* ==== FINANCE DATA SYNC (CRON) ==== */
add_filter('cron_schedules', function ($schedules) {
  $schedules['tece_fin_10min'] = [
    'interval' => 10 * MINUTE_IN_SECONDS,
    'display' => __('A cada 10 minutos (Financeiro Portal)', 'tradeexpansion'),
  ];
  return $schedules;
});

add_action('init', function () {
  if (!wp_next_scheduled('tece_fin_sync')) {
    wp_schedule_event(time(), 'tece_fin_10min', 'tece_fin_sync');
  }
});

add_action('switch_theme', function () {
  $timestamp = wp_next_scheduled('tece_fin_sync');
  if ($timestamp) {
    wp_unschedule_event($timestamp, 'tece_fin_sync');
  }
});

add_action('tece_fin_sync', 'tec_portal_run_fin_sync');
function tec_portal_run_fin_sync()
{
  $users = get_users([
    'role' => 'cliente',
    'meta_key' => 'tec_show_financial',
    'meta_value' => 'yes',
    'fields' => ['ID'],
  ]);

  if (empty($users)) {
    return;
  }

  foreach ($users as $user) {
    $data = tec_portal_fetch_financial_remote((int) $user->ID);
    if ($data) {
      set_transient('tec_fin_json_' . (int) $user->ID, $data, 12 * MINUTE_IN_SECONDS);
    }
  }
}

function tec_portal_fetch_financial_remote($uid)
{
  $uid = (int) $uid;
  if ($uid <= 0) {
    return false;
  }

  $url = defined('TECE_FIN_URL') && TECE_FIN_URL ? TECE_FIN_URL : get_option('tece_fin_url');
  if (empty($url)) {
    return false;
  }

  $request_url = add_query_arg(['uid' => $uid], $url);
  $response = wp_remote_get($request_url, ['timeout' => 12]);

  if (is_wp_error($response)) {
    return false;
  }

  if (wp_remote_retrieve_response_code($response) !== 200) {
    return false;
  }

  $data = json_decode(wp_remote_retrieve_body($response), true);
  return is_array($data) ? $data : false;
}

/* ==== NAV MENU CONDITIONAL ITEMS ==== */
add_filter('wp_nav_menu_items', function ($items, $args) {
  if (empty($args->theme_location) || $args->theme_location !== 'primary') {
    return $items;
  }

  if (is_admin()) {
    return $items;
  }

  $portal_login = home_url('/' . (defined('TE_CLIENT_PORTAL_LOGIN_SLUG') ? TE_CLIENT_PORTAL_LOGIN_SLUG : 'area-do-cliente') . '/');
  $portal_dashboard = home_url('/' . (defined('TE_CLIENT_PORTAL_DASHBOARD_SLUG') ? TE_CLIENT_PORTAL_DASHBOARD_SLUG : 'dashboard') . '/');

  if (is_user_logged_in() && te_client_portal_user_is_allowed(wp_get_current_user())) {
    $items .= '<li class="menu-item menu-item-portal"><a href="' . esc_url($portal_dashboard) . '" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/40 text-sm text-white hover:bg-white/10 transition">' . esc_html__('Dashboard', 'tradeexpansion') . '</a></li>';
  } else {
    $items .= '<li class="menu-item menu-item-portal-login"><a href="' . esc_url($portal_login) . '" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/40 text-sm text-white hover:bg-white/10 transition">' . esc_html__('Área do Cliente', 'tradeexpansion') . '</a></li>';
  }

  if (current_user_can('manage_options')) {
    $items .= '<li class="menu-item menu-item-admin"><a href="' . esc_url(admin_url()) . '" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-accent text-sm text-accent hover:bg-accent hover:text-white transition">' . esc_html__('Admin', 'tradeexpansion') . '</a></li>';
  }

  return $items;
}, 10, 2);

/** Utils */
function tec_get_client_users()
{
  return get_users(['role' => 'cliente', 'fields' => ['ID', 'display_name']]);
}
function tec_select_cliente_field($post, $selected_id)
{
  $clientes = tec_get_client_users();
  echo '<label for="tec_cliente_id">Cliente: </label>';
  echo '<select id="tec_cliente_id" name="tec_cliente_id">';
  echo '<option value="">— selecione —</option>';
  foreach ($clientes as $u) {
    $sel = selected((int) $selected_id, (int) $u->ID, false);
    printf('<option value="%d" %s>%s</option>', (int) $u->ID, $sel, esc_html($u->display_name));
  }
  echo '</select>';
  wp_nonce_field('tec_save_meta', 'tec_meta_nonce');
}

/** Metaboxes */
add_action('add_meta_boxes', function () {
  // Relatório: cliente + status
  add_meta_box('tec_relatorio_meta', 'Dados do Relatório', function ($post) {
    $cliente_id = get_post_meta($post->ID, 'tec_cliente_id', true);
    $status = get_post_meta($post->ID, 'tec_status', true); // aprovado|pendente|reprovado

    tec_select_cliente_field($post, $cliente_id);

    echo '<p><label for="tec_status">Status: </label>';
    echo '<select id="tec_status" name="tec_status">';
    foreach (['aprovado' => 'Aprovado', 'pendente' => 'Pendente', 'reprovado' => 'Reprovado'] as $val => $label) {
      $sel = selected($status, $val, false);
      echo "<option value='{$val}' {$sel}>{$label}</option>";
    }
    echo '</select></p>';

    echo '<p><em>Dica:</em> use o <strong>Editor</strong> para notas/resumo. As fotos e dados de bundles são enviados pelo formulário do front (layout padronizado por item), então não é necessário informar URL de PDF.</p>';
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
    $valor = get_post_meta($post->ID, 'tec_valor', true);
    $venc = get_post_meta($post->ID, 'tec_vencimento', true);
    $fstatus = get_post_meta($post->ID, 'tec_fin_status', true); // pago|pendente

    tec_select_cliente_field($post, $cliente_id);

    echo '<p><label for="tec_valor">Valor (R$): </label>';
    printf('<input type="number" step="0.01" id="tec_valor" name="tec_valor" value="%s" />', esc_attr($valor));
    echo '</p>';

    echo '<p><label for="tec_vencimento">Vencimento: </label>';
    printf('<input type="date" id="tec_vencimento" name="tec_vencimento" value="%s" />', esc_attr($venc));
    echo '</p>';

    echo '<p><label for="tec_fin_status">Status: </label>';
    echo '<select id="tec_fin_status" name="tec_fin_status">';
    foreach (['pendente' => 'Pendente', 'pago' => 'Pago'] as $val => $label) {
      $sel = selected($fstatus, $val, false);
      echo "<option value='{$val}' {$sel}>{$label}</option>";
    }
    echo '</select></p>';
  }, 'tec_financeiro', 'normal', 'default');
});

/** Save meta */
add_action('save_post', function ($post_id) {
  if (!isset($_POST['tec_meta_nonce']) || !wp_verify_nonce($_POST['tec_meta_nonce'], 'tec_save_meta'))
    return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  $map = [
    'tec_relatorio' => ['tec_cliente_id', 'tec_status'],
    'tec_inspecao' => ['tec_cliente_id'],
    'tec_financeiro' => ['tec_cliente_id', 'tec_valor', 'tec_vencimento', 'tec_fin_status'],
  ];
  $post_type = get_post_type($post_id);
  if (!isset($map[$post_type]))
    return;

  foreach ($map[$post_type] as $key) {
    if (isset($_POST[$key])) {
      $val = $_POST[$key];
      if ($key === 'tec_cliente_id')
        $val = (int) $val;
      update_post_meta($post_id, $key, sanitize_text_field($val));
    } else {
      delete_post_meta($post_id, $key);
    }
  }
});
/* ==== /CLIENT PORTAL – EDITÁVEL ==== */

/* ==== TRADEEXPANSION • MATERIAIS E FOTOS DE INSPEÇÃO ==== */
// Taxonomia para classificar fotos e inspeções por material
add_action('init', function () {
  register_taxonomy('tec_material', ['attachment', 'tec_inspecao'], [
    'labels' => [
      'name' => 'Materiais',
      'singular_name' => 'Material',
    ],
    'public' => false,
    'show_ui' => true,
    'hierarchical' => false,
    'show_admin_column' => false,
  ]);

  // Garante termos básicos
  foreach (['Mármore', 'Granito', 'Quartzito', 'Quartzo', 'Outro'] as $t) {
    if (!term_exists($t, 'tec_material')) {
      wp_insert_term($t, 'tec_material');
    }
  }
});

// Campos extras no anexo (foto): Material + Observação
add_filter('attachment_fields_to_edit', function ($form_fields, $post) {
  if (strpos((string) $post->post_mime_type, 'image') === false)
    return $form_fields;

  // Dropdown de Materiais (taxonomia)
  $terms = get_terms(['taxonomy' => 'tec_material', 'hide_empty' => false]);
  $cur = wp_get_object_terms($post->ID, 'tec_material', ['fields' => 'ids']);
  $curId = $cur ? (int) $cur[0] : 0;

  $html = '<select name="attachments[' . $post->ID . '][tec_material]" id="attachments-' . $post->ID . '-tec_material">';
  $html .= '<option value="">— Material —</option>';
  foreach ($terms as $term) {
    $sel = selected($curId, (int) $term->term_id, false);
    $html .= '<option value="' . (int) $term->term_id . '" ' . $sel . '>' . esc_html($term->name) . '</option>';
  }
  $html .= '</select>';

  $form_fields['tec_material'] = [
    'label' => 'Material',
    'input' => 'html',
    'html' => $html,
  ];

  // Observação por foto
  $obs = get_post_meta($post->ID, 'tec_obs', true);
  $form_fields['tec_obs'] = [
    'label' => 'Observação',
    'input' => 'text',
    'value' => $obs ?: '',
    'helps' => 'Comentário específico deste bundle/foto.',
  ];

  return $form_fields;
}, 10, 2);

add_filter('attachment_fields_to_save', function ($post, $attachment) {
  // Observação
  if (isset($attachment['tec_obs'])) {
    update_post_meta($post['ID'], 'tec_obs', sanitize_text_field($attachment['tec_obs']));
  }
  // Material (taxonomia)
  if (isset($attachment['tec_material']) && $attachment['tec_material']) {
    wp_set_object_terms($post['ID'], (int) $attachment['tec_material'], 'tec_material', false);
  } else {
    wp_set_object_terms($post['ID'], [], 'tec_material', false);
  }
  return $post;
}, 10, 2);

/* ==== CLIENT PORTAL • PROFILE FINANCIAL TOGGLE ==== */
if (!function_exists('tec_portal_financial_field')) {
  function tec_portal_financial_field($user)
  {
    if (!current_user_can('manage_options'))
      return;
    $enabled = get_user_meta($user->ID, 'tec_show_financial', true);
    ?>
    <h2>Portal do Cliente</h2>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row"><label for="tec_show_financial">Módulo Financeiro</label></th>
        <td>
          <label>
            <input type="checkbox" name="tec_show_financial" id="tec_show_financial" value="yes" <?php checked($enabled, 'yes'); ?>>
            Exibir a aba Financeiro no dashboard deste cliente
          </label>
          <p class="description">Marque para este usuário ver a aba Financeiro no portal.</p>
        </td>
      </tr>
    </table>
    <?php
  }
}
add_action('show_user_profile', 'tec_portal_financial_field');
add_action('edit_user_profile', 'tec_portal_financial_field');

/* Campo também no formulário de "Adicionar novo usuário" (user-new.php) */
if (!function_exists('tec_portal_financial_field_new_user')) {
  function tec_portal_financial_field_new_user($operation)
  {
    if (!current_user_can('manage_options'))
      return;
    ?>
    <h2>Portal do Cliente</h2>
    <table class="form-table" role="presentation">
      <tr>
        <th scope="row"><label for="tec_show_financial">Módulo Financeiro</label></th>
        <td>
          <label>
            <input type="checkbox" name="tec_show_financial" id="tec_show_financial" value="yes">
            Exibir a aba Financeiro no dashboard deste cliente
          </label>
        </td>
      </tr>
    </table>
    <?php
  }
}
add_action('user_new_form', 'tec_portal_financial_field_new_user');

/* Salva a flag ao criar/atualizar usuário */
if (!function_exists('tec_portal_save_financial_field')) {
  function tec_portal_save_financial_field($user_id)
  {
    if (!current_user_can('manage_options'))
      return;
    $value = isset($_POST['tec_show_financial']) ? 'yes' : 'no';
    update_user_meta($user_id, 'tec_show_financial', $value);
  }
}
add_action('personal_options_update', 'tec_portal_save_financial_field');
add_action('edit_user_profile_update', 'tec_portal_save_financial_field');
add_action('user_register', 'tec_portal_save_financial_field');

/* Helper: checa se o usuário tem acesso ao módulo financeiro */
if (!function_exists('tec_portal_user_has_financial')) {
  function tec_portal_user_has_financial($user_id)
  {
    $u = get_user_by('id', (int) $user_id);
    if (!$u)
      return false;

    // Admin sempre pode ver
    if (in_array('administrator', (array) $u->roles, true))
      return true;

    // Whitelist opcional por login (ex.: Israel)
    $whitelist = ['israel', 'israelteste', 'israel.magma'];
    if (in_array($u->user_login, $whitelist, true))
      return true;

    // Padrão: respeita o checkbox
    return get_user_meta($u->ID, 'tec_show_financial', true) === 'yes';
  }
}

/* ==== TRADEEXPANSION • FINANCEIRO REMOTO (STUB) ==== */
// Define TECE_FIN_URL em wp-config.php ou use a opção 'tece_fin_url'
if (!defined('TECE_FIN_URL')) {
  // define('TECE_FIN_URL', 'https://script.google.com/macros/s/SEU-APPS-SCRIPT/exec'); // exemplo
}

function tec_finance_get_remote($uid)
{
  $cache_key = 'tec_fin_json_' . (int) $uid;
  $cached = get_transient($cache_key);
  if ($cached !== false) {
    return $cached;
  }
  return false;
}

// Redireciona a rota /dashboard do portal para a página editável (ajuste o slug conforme precisar)
add_action('template_redirect', function () {
  $portal = get_query_var('tec_portal');
  if ($portal === 'dashboard') {
    $p = get_page_by_path('dashboard-portal'); // slug da página (ajuste se usar outro)
    if ($p) {
      wp_redirect(get_permalink($p->ID));
      exit;
    }
  }
});
// Export routes (HTML-to-PDF friendly previews)
add_filter('template_include', function ($template) {
  $export = get_query_var('tec_export');
  if (!$export)
    return $template;

  // /?tec_export=relatorio&tec_export_post=ID[&download=1]
  if ($export === 'relatorio') {
    $post_id = (int) get_query_var('tec_export_post');
    if ($post_id > 0) {
      tec_export_render_relatorio_pdf($post_id);
      exit;
    }
  }

  // Mantém a rota de inspeção (se você já usa)
  if ($export === 'inspecao') {
    $export_template = get_template_directory() . '/client-portal/export/relatorio-inspecao-pdf.php';
    if (file_exists($export_template))
      return $export_template;
  }

  return $template;
}, 20);

if (!function_exists('tec_export_render_relatorio_pdf')) {
  function tec_export_render_relatorio_pdf($post_id)
  {
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'tec_relatorio') {
      status_header(404);
      echo 'Relatório não encontrado.';
      return;
    }
    nocache_headers();

    $title = get_the_title($post);
    $content = apply_filters('the_content', $post->post_content);

    $cliente_id = (int) get_post_meta($post_id, 'tec_cliente_id', true);
    $cliente_name = $cliente_id ? tec_portal_get_client_name($cliente_id) : '—';
    $status = get_post_meta($post_id, 'tec_status', true) ?: 'pendente';
    $status_label = function_exists('te_client_portal_format_report_status') ? te_client_portal_format_report_status($status) : ucfirst($status);
    ?>
    <!doctype html>
    <html <?php language_attributes(); ?>>

    <head>
      <meta charset="<?php bloginfo('charset'); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="robots" content="noindex, nofollow">
      <title><?php echo esc_html($title); ?> — PDF</title>
      <style>
        @page {
          size: A4;
          margin: 16mm 14mm 18mm 14mm;
        }

        body {
          font: 12pt/1.45 Georgia, "Times New Roman", serif;
          color: #102724;
        }

        h1 {
          font-size: 22pt;
          margin: 0 0 8px
        }

        .meta {
          display: flex;
          gap: 12px;
          justify-content: space-between;
          padding: 10px 12px;
          background: #f7f8f7;
          border: 1px solid #e0e4e2;
          border-radius: 6px;
          margin: 10px 0 18px
        }

        .wp-block-table table {
          width: 100%;
          border-collapse: collapse
        }

        .wp-block-table th,
        .wp-block-table td {
          border: 1px solid #e0e4e2;
          padding: 6px 8px
        }

        .wp-block-columns {
          display: flex;
          gap: 14px;
          margin: 10px 0 16px
        }

        .wp-block-column {
          flex: 1
        }

        figure.wp-block-image {
          margin: 0
        }

        figure.wp-block-image img {
          max-width: 100%;
          height: auto;
          display: block
        }

        .no-print {
          margin-bottom: 8px;
          text-align: right
        }

        .btn {
          display: inline-block;
          padding: 8px 12px;
          border: 1px solid #102724;
          border-radius: 6px;
          text-decoration: none;
          color: #102724
        }

        @media print {
          .no-print {
            display: none
          }

          a[href]:after {
            content: ""
          }
        }
      </style>
    </head>

    <body>
      <div class="no-print"><a class="btn" href="#" onclick="window.print();return false;">Imprimir / Salvar PDF</a></div>
      <h1><?php echo esc_html($title); ?></h1>
      <div class="meta">
        <div><strong>Cliente:</strong> <?php echo esc_html($cliente_name); ?></div>
        <div><strong>Status:</strong> <?php echo esc_html($status_label); ?></div>
        <div><strong>Data:</strong> <?php echo esc_html(date_i18n('d/m/Y')); ?></div>
      </div>
      <div><?php echo $content; ?></div>
      <?php if (!empty($_GET['download'])): ?>
        <script>window.print()</script><?php endif; ?>
    </body>

    </html>
    <?php
  }
}

// Robots noindex para o Dashboard (template, slug ou rota do portal)
add_action('wp_head', function () {
  static $te_noindex_done = false;
  if ($te_noindex_done)
    return;

  $is_portal_template = is_page_template('page-portal-dashboard.php');
  $is_portal_slug = is_page('dashboard-portal'); // ajuste se o slug for outro
  $is_portal_route = (get_query_var('tec_portal') === 'dashboard');

  if ($is_portal_template || $is_portal_slug || $is_portal_route) {
    echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
    $te_noindex_done = true;
  }
}, 1);

/* ==== /CLIENT PORTAL EXPORT ==== */

/* ==== FRONT-END FORM • RELATÓRIO (SHORTCODE) ==== */

/** Upload front-end e retorno do ID do anexo. */
function te_handle_front_upload($file, $post_id)
{
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $overrides = ['test_form' => false];
  $uploaded = wp_handle_upload($file, $overrides);

  if (isset($uploaded['error']))
    return 0;

  $filetype = wp_check_filetype($uploaded['file'], null);
  $attachment = [
    'post_mime_type' => $filetype['type'],
    'post_title' => sanitize_file_name(basename($uploaded['file'])),
    'post_content' => '',
    'post_status' => 'inherit'
  ];

  $attach_id = wp_insert_attachment($attachment, $uploaded['file'], $post_id);
  if (!is_wp_error($attach_id)) {
    $attach_data = wp_generate_attachment_metadata($attach_id, $uploaded['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
  }
  return 0;
}

/** Monta o conteúdo em blocos (Gutenberg) a partir dos campos do formulário. */
function te_build_relatorio_blocks($title, $resumo, $data = [], $bundles = [])
{
  $title = esc_html($title);
  $resumo = esc_html($resumo);

  $cliente_id = !empty($data['tec_cliente_id']) ? (int) $data['tec_cliente_id'] : 0;
  $cliente_name = $cliente_id ? tec_portal_get_client_name($cliente_id) : '—';

  $status_val = !empty($data['tec_status']) ? sanitize_text_field($data['tec_status']) : 'pendente';
  $status_map = ['aprovado' => 'Aprovado', 'pendente' => 'Pendente', 'reprovado' => 'Reprovado'];
  $status = isset($status_map[$status_val]) ? $status_map[$status_val] : ucfirst($status_val);

  $date = date_i18n('d/m/Y');

  // Cabeçalho simples (sem cover)
  $content = <<<HTML
  <!-- wp:group {"layout":{"type":"constrained"}} -->
  <div class="wp-block-group"><div class="wp-block-group__inner-container">
  <!-- wp:heading {"level":1} --><h1>{$title}</h1><!-- /wp:heading -->
  <!-- wp:paragraph --><p>{$resumo}</p><!-- /wp:paragraph -->
  <!-- wp:list --><ul>
    <li>Cliente: <strong>{$cliente_name}</strong></li>
    <li>Status: <strong>{$status}</strong></li>
    <li>Data: <strong>{$date}</strong></li>
  </ul><!-- /wp:list -->
  </div></div>
  <!-- /wp:group -->
  HTML;

  foreach ($bundles as $b) {
    $ident = esc_html($b['ident'] ?? '');
    $desc = esc_html($b['descricao'] ?? '');
    $acab = esc_html($b['acabamento'] ?? '');
    $qtd = isset($b['quant']) ? (int) $b['quant'] : 0;
    $c = isset($b['comp']) ? (float) $b['comp'] : 0;
    $h = isset($b['altura']) ? (float) $b['altura'] : 0;
    $esp = isset($b['esp']) ? (float) $b['esp'] : 0;
    $m2 = isset($b['m2']) ? (float) $b['m2'] : round($c * $h * max($qtd, 1), 2);

    $img = '';
    if (!empty($b['attachment_id'])) {
      $url = wp_get_attachment_image_url((int) $b['attachment_id'], 'large');
      if ($url) {
        $alt = get_post_meta((int) $b['attachment_id'], '_wp_attachment_image_alt', true);
        $img = '<figure class="wp-block-image size-large"><img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/></figure>';
      }
    }

    $table = '
    <!-- wp:table -->
    <figure class="wp-block-table"><table><thead><tr>
      <th>IDENT.</th><th>QUANT.</th><th>DESCRIPTION</th><th>FINISH</th><th>DIMENSIONS (m)</th><th>TOTAL (m²)</th>
    </tr></thead><tbody><tr>
      <td>' . $ident . '</td>
      <td>' . $qtd . '</td>
      <td>' . $desc . '</td>
      <td>' . $acab . '</td>
      <td>comp ' . $c . ' × alt ' . $h . ' × esp ' . $esp . 'cm</td>
      <td>' . number_format($m2, 2, ',', '.') . '</td>
    </tr></tbody></table></figure>
    <!-- /wp:table -->';

    $content .= '
    <!-- wp:columns -->
    <div class="wp-block-columns">
      <!-- wp:column {"width":"65%"} -->
      <div class="wp-block-column" style="flex-basis:65%">' . $table . '</div>
      <!-- /wp:column -->
      <!-- wp:column {"width":"35%"} -->
      <div class="wp-block-column" style="flex-basis:35%">' . $img . '</div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->';
  }

  return $content;
}

if (!function_exists('te_relatorio_parse_float')) {
  function te_relatorio_parse_float($value)
  {
    $value = str_replace(',', '.', (string) $value);
    return is_numeric($value) ? (float) $value : 0.0;
  }
}

if (!function_exists('te_relatorio_parse_int')) {
  function te_relatorio_parse_int($value)
  {
    return (int) round(te_relatorio_parse_float($value));
  }
}

if (!function_exists('te_relatorio_extract_items_from_request')) {
  function te_relatorio_extract_items_from_request()
  {
    $raw_items = [];
    if (!empty($_POST['cavaletes']) && is_array($_POST['cavaletes'])) {
      $raw_items = array_values($_POST['cavaletes']);
    } elseif (!empty($_POST['bundles']) && is_array($_POST['bundles'])) {
      $raw_items = array_values($_POST['bundles']);
    }

    $items = [];
    foreach ($raw_items as $row) {
      if (!is_array($row)) {
        continue;
      }

      $items[] = [
        'ident' => sanitize_text_field($row['ident'] ?? $row['identificacao'] ?? ''),
        'descricao' => sanitize_text_field($row['descricao'] ?? ($row['material'] ?? '')),
        'acabamento' => sanitize_text_field($row['acabamento'] ?? ''),
        'quant' => te_relatorio_parse_int($row['quantidade'] ?? ($row['quant'] ?? 0)),
        'comp' => te_relatorio_parse_float($row['comp_m'] ?? ($row['comp'] ?? 0)),
        'altura' => te_relatorio_parse_float($row['altura_m'] ?? ($row['altura'] ?? 0)),
        'esp' => te_relatorio_parse_float($row['espess_cm'] ?? ($row['esp'] ?? 0)),
        'obs' => sanitize_text_field($row['obs'] ?? ''),
      ];
    }

    return $items;
  }
}

if (!function_exists('te_relatorio_attach_photos_to_items')) {
  function te_relatorio_attach_photos_to_items(array &$items, $post_id)
  {
    $attachments_map = [];

    if (!empty($_FILES['bundle_photo']['name']) && is_array($_FILES['bundle_photo']['name'])) {
      $bundle_files = $_FILES['bundle_photo'];
      $count = count($bundle_files['name']);
      for ($i = 0; $i < $count; $i++) {
        if (empty($bundle_files['name'][$i]) || $bundle_files['error'][$i] !== UPLOAD_ERR_OK) {
          continue;
        }
        $file = [
          'name' => $bundle_files['name'][$i],
          'type' => $bundle_files['type'][$i],
          'tmp_name' => $bundle_files['tmp_name'][$i],
          'error' => $bundle_files['error'][$i],
          'size' => $bundle_files['size'][$i],
        ];
        $attach_id = te_handle_front_upload($file, $post_id);
        if (!$attach_id) {
          continue;
        }
        $attachments_map[$i][] = $attach_id;
      }
    }

    foreach ($_FILES as $field => $group) {
      if (!preg_match('/^cavalete_photo_(\\d+)$/', $field, $matches)) {
        continue;
      }
      $index = (int) $matches[1];
      if (empty($group['name']) || !is_array($group['name'])) {
        continue;
      }
      $count = count($group['name']);
      for ($i = 0; $i < $count; $i++) {
        if (empty($group['name'][$i]) || $group['error'][$i] !== UPLOAD_ERR_OK) {
          continue;
        }
        $file = [
          'name' => $group['name'][$i],
          'type' => $group['type'][$i],
          'tmp_name' => $group['tmp_name'][$i],
          'error' => $group['error'][$i],
          'size' => $group['size'][$i],
        ];
        $attach_id = te_handle_front_upload($file, $post_id);
        if (!$attach_id) {
          continue;
        }
        $attachments_map[$index][] = $attach_id;
      }
    }

    if (empty($attachments_map)) {
      return;
    }

    foreach ($attachments_map as $index => $attachments) {
      if (!isset($items[$index])) {
        continue;
      }
      $items[$index]['attachments'] = $attachments;
      $items[$index]['attachment_id'] = (int) ($attachments[0] ?? 0);
      $material = $items[$index]['descricao'];
      $obs = $items[$index]['obs'];
      foreach ($attachments as $att_id) {
        if ($material) {
          tec_portal_assign_material_term($att_id, $material);
        }
        if ($obs) {
          update_post_meta($att_id, 'tec_obs', $obs);
        }
      }
    }
  }
}
/** Shortcode [te_relatorio_form] – cria Relatório pelo front-end (Admin/Editor). */
add_shortcode('te_relatorio_form', function ($atts) {
  if (!is_user_logged_in() || !current_user_can('edit_posts')) {
    return '<p>Acesso restrito.</p>';
  }

  $notice = '';
  if (isset($_POST['te_relatorio_nonce']) && wp_verify_nonce($_POST['te_relatorio_nonce'], 'te_relatorio_form')) {
    $title = sanitize_text_field($_POST['te_title'] ?? '');
    $resumo = sanitize_textarea_field($_POST['te_resumo'] ?? '');
    $cliente_id = isset($_POST['tec_cliente_id']) ? (int) $_POST['tec_cliente_id'] : 0;
    $status_meta = sanitize_text_field($_POST['tec_status'] ?? 'pendente');

    $action = sanitize_text_field($_POST['action'] ?? '');
    $post_status = $action === 'save_draft' ? 'draft' : 'publish';

    $items = te_relatorio_extract_items_from_request();
    if (empty($items)) {
      $items[] = [
        'ident' => '',
        'descricao' => '',
        'acabamento' => '',
        'quant' => 0,
        'comp' => 0,
        'altura' => 0,
        'esp' => 0,
        'obs' => '',
      ];
    }

    // Cria o post
    $post_id = wp_insert_post([
      'post_type' => 'tec_relatorio',
      'post_status' => $post_status,
      'post_title' => $title ? $title : 'Relatório',
      'post_content' => '',
    ], true);

    if (!is_wp_error($post_id)) {
      if ($cliente_id)
        update_post_meta($post_id, 'tec_cliente_id', $cliente_id);
      update_post_meta($post_id, 'tec_status', $status_meta);

      te_relatorio_attach_photos_to_items($items, $post_id);

      $json_rows = [];
      foreach ($items as $row) {
        $m2 = ($row['comp'] > 0 && $row['altura'] > 0 && $row['quant'] > 0)
          ? round($row['comp'] * $row['altura'] * max(1, (int) $row['quant']), 2)
          : 0;
        $json_rows[] = [
          'ident' => $row['ident'] ?? '',
          'descricao' => $row['descricao'] ?? '',
          'acabamento' => $row['acabamento'] ?? '',
          'Qtd' => isset($row['quant']) ? (int) $row['quant'] : 0,
          'C' => isset($row['comp']) ? (float) $row['comp'] : 0,
          'H' => isset($row['altura']) ? (float) $row['altura'] : 0,
          'esp' => isset($row['esp']) ? (float) $row['esp'] : 0,
          'm2' => $m2,
          'attachment' => (int) ($row['attachment_id'] ?? 0),
          'obs' => $row['obs'] ?? '',
        ];
      }
      update_post_meta($post_id, 'tec_slabs_json', wp_json_encode($json_rows));

      // Monta o conteúdo com tabela + foto por bundle
      $content = te_build_relatorio_blocks($title, $resumo, $_POST, $items);
      wp_update_post([
        'ID' => $post_id,
        'post_content' => $content,
      ]);

      $notice = '<div class="notice-success">Relatório criado! '
        . '<a href="' . esc_url(get_edit_post_link($post_id)) . '" target="_blank" rel="noopener">Editar no Admin</a>'
        . '</div>';

      $_POST = []; // evita reenvio
    } else {
      $notice = '<div class="notice-error">' . esc_html($post_id->get_error_message()) . '</div>';
    }
  }

  ob_start();
  echo $notice;
  include get_template_directory() . '/client-portal/partials/form-relatorio.php';
  return ob_get_clean();
});

// Alta legibilidade no formulário de Relatório (sempre que a página tiver o shortcode ou for /novo-relatorio/)
add_action('wp_head', function () {
  if (!is_singular())
    return;
  global $post;
  $has_short = ($post && has_shortcode($post->post_content ?? '', 'te_relatorio_form'));
  $is_novo_relatorio = function_exists('get_queried_object') && is_page() && (get_post_field('post_name', get_queried_object_id()) === 'novo-relatorio');
  if (!$has_short && !$is_novo_relatorio)
    return;
  ?>
  <style>
    /* Força texto VERDE nos campos (e impede o tema de cinzar) */
    body .te-relatorio-form input[type="text"],
    body .te-relatorio-form input[type="email"],
    body .te-relatorio-form input[type="number"],
    body .te-relatorio-form input[type="date"],
    body .te-relatorio-form input[type="file"],
    body .te-relatorio-form select,
    body .te-relatorio-form textarea,
    body.page-novo-relatorio form input[type="text"],
    body.page-novo-relatorio form input[type="email"],
    body.page-novo-relatorio form input[type="number"],
    body.page-novo-relatorio form input[type="date"],
    body.page-novo-relatorio form input[type="file"],
    body.page-novo-relatorio form select,
    body.page-novo-relatorio form textarea {
      color: #102724 !important;
      /* verde escuro */
      -webkit-text-fill-color: #9AA3A1 !important;
      /* Safari/autofill */
      background-color: rgb(255, 255, 255) !important;
      /* fundo branco */
      caret-color: #102724 !important;
    }

    /* Placeholder com contraste melhor */
    body .te-relatorio-form input::placeholder,
    body .te-relatorio-form textarea::placeholder,
    body.page-novo-relatorio form input::placeholder,
    body.page-novo-relatorio form textarea::placeholder {
      color: #9AA3A1 !important;
      opacity: 2 !important;
      /* Safari */
    }

    body .te-relatorio-form input::-webkit-input-placeholder,
    body .te-relatorio-form textarea::-webkit-input-placeholder,
    body.page-novo-relatorio form input::-webkit-input-placeholder,
    body.page-novo-relatorio form textarea::-webkit-input-placeholder {
      color: #9AA3A1 !important;
    }

    body .te-relatorio-form input::-moz-placeholder,
    body .te-relatorio-form textarea::-moz-placeholder,
    body.page-novo-relatorio form input::-moz-placeholder,
    body.page-novo-relatorio form textarea::-moz-placeholder {
      color: #9AA3A1 !important;
    }

    body .te-relatorio-form input:-ms-input-placeholder,
    body .te-relatorio-form textarea:-ms-input-placeholder,
    body.page-novo-relatorio form input:-ms-input-placeholder,
    body.page-novo-relatorio form textarea:-ms-input-placeholder {
      color: #9AA3A1 !important;
    }

    body .te-relatorio-form input::-ms-input-placeholder,
    body .te-relatorio-form textarea::-ms-input-placeholder,
    body.page-novo-relatorio form input::-ms-input-placeholder,
    body.page-novo-relatorio form textarea::-ms-input-placeholder {
      color: #9AA3A1 !important;
    }

    /* Autofill (Chrome/Safari) mantendo texto verde e “apagando” o amarelado */

    body .te-relatorio-form input:-webkit-autofill,
    body .te-relatorio-form input:-webkit-autofill:hover,
    body .te-relatorio-form input:-webkit-autofill:focus,
    body .te-relatorio-form textarea:-webkit-autofill,
    body .te-relatorio-form select:-webkit-autofill,
    body.page-novo-relatorio form input:-webkit-autofill,
    body.page-novo-relatorio form input:-webkit-autofill:hover,
    body.page-novo-relatorio form input:-webkit-autofill:focus,
    body.page-novo-relatorio form textarea:-webkit-autofill,
    body.page-novo-relatorio form select:-webkit-autofill {
      -webkit-text-fill-color: #102724 !important;
      transition: background-color 9999s ease-in-out 0s !important;
    }

    /* Foco com borda/halo no tom da marca */
    body .te-relatorio-form input:focus,
    body .te-relatorio-form select:focus,
    body .te-relatorio-form textarea:focus,
    body.page-novo-relatorio form input:focus,
    body.page-novo-relatorio form select:focus,
    body.page-novo-relatorio form textarea:focus {
      outline: none;
      border-color: #102724 !important;
      box-shadow: 0 0 0 3px rgba(16, 39, 36, 0.20);
    }
  </style>
  <?php
});

// Monta a URL do PDF do relatório
function tec_relatorio_pdf_url($post_id, $auto_print = false)
{
  $args = ['tec_export' => 'relatorio', 'tec_export_post' => (int) $post_id];
  if ($auto_print)
    $args['download'] = 1;
  return add_query_arg($args, home_url('/'));
}

// Shortcode rápido: [te_relatorio_pdf id="123" text="Baixar PDF" auto="yes|no"]
add_shortcode('te_relatorio_pdf', function ($atts) {
  $a = shortcode_atts(['id' => 0, 'text' => 'Baixar PDF', 'auto' => 'no'], $atts);
  $id = (int) $a['id'];
  if ($id <= 0)
    return '';
  $url = esc_url(tec_relatorio_pdf_url($id, $a['auto'] === 'yes'));
  return '<a class="btn" href="' . $url . '" target="_blank" rel="noopener">' . esc_html($a['text']) . '</a>';
});

// === FINANCEIRO (Google Sheets via Apps Script) =============================

// 2.1) Informe a URL do Apps Script (a que termina com /exec)
if (!defined('TECE_FIN_URL')) {
  define('TECE_FIN_URL', 'https://script.google.com/macros/s/COLE_AQUI_SUA_URL/exec');
}

// 2.2) Quem pode ver a aba "Financeiro" no portal?

// 2.3) Buscar dados no Apps Script e normalizar para o dashboard
if (!function_exists('te_client_portal_fetch_financial_data')) {
  function te_client_portal_fetch_financial_data($user_id)
  {
    $user_id = (int) $user_id;
    if ($user_id <= 0) {
      return null;
    }

    if (!defined('TECE_FIN_URL') || !TECE_FIN_URL) {
      return null;
    }

    // (Opcional) Só retorna se o usuário tiver permissão para ver o financeiro
    if (function_exists('tec_portal_user_has_financial') && !tec_portal_user_has_financial($user_id)) {
      return null;
    }

    // Se quiser filtrar por cliente no Apps Script, você pode mandar um ?client=login
    $user = get_userdata($user_id);
    $url = TECE_FIN_URL . '?client=' . rawurlencode($user ? $user->user_login : 'anon');

    $res = wp_remote_get($url, [
      'timeout' => 15,
      'headers' => [
        'Accept' => 'application/json'
      ],
    ]);

    if (is_wp_error($res)) {
      return null;
    }

    $code = (int) wp_remote_retrieve_response_code($res);
    if ($code < 200 || $code >= 300) {
      return null;
    }

    $body = wp_remote_retrieve_body($res);
    $json = json_decode($body, true);
    if (!is_array($json)) {
      return null;
    }

    // Garante chaves esperadas pelo dashboard.php
    $summary = [
      'pending' => (float) ($json['summary']['pending'] ?? 0),
      'paid' => (float) ($json['summary']['paid'] ?? 0),
    ];

    $entries = [];
    if (!empty($json['entries']) && is_array($json['entries'])) {
      foreach ($json['entries'] as $row) {
        $entries[] = [
          'description' => (string) ($row['description'] ?? ''),
          'amount' => (float) ($row['amount'] ?? 0),
          'status' => (string) ($row['status'] ?? 'Pendente'),
          'due' => (string) ($row['due'] ?? ''),
          'open' => (float) ($row['open_balance'] ?? 0),
          'credit' => (float) ($row['credit_balance'] ?? 0),
          'documents' => (string) ($row['documents'] ?? ''),
        ];
      }
    }

    return [
      'summary' => $summary,
      'entries' => $entries,
    ];
  }
}


// === CPT Lead (para salvar contatos do formulário) ===
add_action('init', function () {
  if (post_type_exists('te_lead')) {
    return;
  }
  register_post_type('te_lead', [
    'labels' => [
      'name' => 'Leads',
      'singular_name' => 'Lead',
      'add_new_item' => 'Adicionar Lead',
      'edit_item' => 'Editar Lead',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-id',
    'supports' => ['title', 'editor'],
  ]);
});

/* ==== /CLIENT PORTAL • SETTINGS PAGE ==== */
/**
 * CUSTOM POST TYPE: PRODUTOS DE CATÁLOGO
 * Adicione este código ao final do functions.php
 * ORDEM CORRETA: Primeiro registra o CPT, depois as funções helper
 */

// Registra o Custom Post Type
add_action('init', 'te_register_catalog_products_cpt');
function te_register_catalog_products_cpt()
{
  $labels = [
    'name' => __('Produtos do Catálogo', 'tradeexpansion'),
    'singular_name' => __('Produto', 'tradeexpansion'),
    'add_new' => __('Adicionar Novo', 'tradeexpansion'),
    'add_new_item' => __('Adicionar Novo Produto', 'tradeexpansion'),
    'edit_item' => __('Editar Produto', 'tradeexpansion'),
    'new_item' => __('Novo Produto', 'tradeexpansion'),
    'view_item' => __('Ver Produto', 'tradeexpansion'),
    'search_items' => __('Buscar Produtos', 'tradeexpansion'),
    'not_found' => __('Nenhum produto encontrado', 'tradeexpansion'),
    'not_found_in_trash' => __('Nenhum produto na lixeira', 'tradeexpansion'),
    'menu_name' => __('Catálogo de Rochas', 'tradeexpansion'),
  ];

  $args = [
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-clipboard',
    'menu_position' => 5,
    'supports' => ['title', 'editor', 'thumbnail'],
    'has_archive' => false,
    'rewrite' => false,
  ];

  register_post_type('te_catalog_product', $args);
}

// Registra as Taxonomias (Tipo de Rocha e Cor)
add_action('init', 'te_register_catalog_taxonomies');
function te_register_catalog_taxonomies()
{
  // Tipo de Rocha
  register_taxonomy('tipo_rocha', 'te_catalog_product', [
    'labels' => [
      'name' => __('Tipos de Rocha', 'tradeexpansion'),
      'singular_name' => __('Tipo', 'tradeexpansion'),
      'add_new_item' => __('Adicionar Novo Tipo', 'tradeexpansion'),
    ],
    'hierarchical' => true,
    'show_admin_column' => true,
    'rewrite' => false,
  ]);

  // Cor
  register_taxonomy('cor_rocha', 'te_catalog_product', [
    'labels' => [
      'name' => __('Cores', 'tradeexpansion'),
      'singular_name' => __('Cor', 'tradeexpansion'),
      'add_new_item' => __('Adicionar Nova Cor', 'tradeexpansion'),
    ],
    'hierarchical' => true,
    'show_admin_column' => true,
    'rewrite' => false,
  ]);
}

// Adiciona termos padrão automaticamente
add_action('init', 'te_add_default_catalog_terms', 20);
function te_add_default_catalog_terms()
{
  // Tipos de rocha
  $tipos = ['Granito', 'Mármore', 'Quartzito', 'Quartzo'];
  foreach ($tipos as $tipo) {
    if (!term_exists($tipo, 'tipo_rocha')) {
      wp_insert_term($tipo, 'tipo_rocha');
    }
  }

  // Cores
  $cores = ['Claro', 'Escuro', 'Colorido'];
  foreach ($cores as $cor) {
    if (!term_exists($cor, 'cor_rocha')) {
      wp_insert_term($cor, 'cor_rocha');
    }
  }
}

// Adiciona Metaboxes para dados técnicos
add_action('add_meta_boxes', 'te_add_catalog_product_metaboxes');
function te_add_catalog_product_metaboxes()
{
  add_meta_box(
    'te_product_details',
    __('Detalhes do Produto', 'tradeexpansion'),
    'te_product_details_callback',
    'te_catalog_product',
    'normal',
    'high'
  );

  add_meta_box(
    'te_product_images',
    __('Galeria de Imagens', 'tradeexpansion'),
    'te_product_images_callback',
    'te_catalog_product',
    'side',
    'default'
  );
}

// Callback do Metabox - Detalhes do Produto
function te_product_details_callback($post)
{
  wp_nonce_field('te_save_product_meta', 'te_product_meta_nonce');

  $nome_geologico = get_post_meta($post->ID, '_te_nome_geologico', true);
  $origem = get_post_meta($post->ID, '_te_origem', true);
  $absorcao = get_post_meta($post->ID, '_te_absorcao', true);
  $densidade = get_post_meta($post->ID, '_te_densidade', true);
  $resistencia = get_post_meta($post->ID, '_te_resistencia', true);
  $acabamentos = get_post_meta($post->ID, '_te_acabamentos', true);
  $aplicacoes = get_post_meta($post->ID, '_te_aplicacoes', true);
  ?>
  <style>
    .te-field-group {
      margin-bottom: 20px;
    }

    .te-field-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .te-field-group input[type="text"],
    .te-field-group textarea,
    .te-field-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .te-field-row {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 15px;
    }
  </style>

  <div class="te-field-group">
    <label for="te_nome_geologico"><?php _e('Nome Geológico', 'tradeexpansion'); ?></label>
    <input type="text" id="te_nome_geologico" name="te_nome_geologico" value="<?php echo esc_attr($nome_geologico); ?>"
      placeholder="Ex: Granito, Mármore...">
  </div>

  <div class="te-field-group">
    <label for="te_origem"><?php _e('Origem (Cidade, Estado)', 'tradeexpansion'); ?></label>
    <input type="text" id="te_origem" name="te_origem" value="<?php echo esc_attr($origem); ?>"
      placeholder="Ex: Espírito Santo, Brasil">
  </div>

  <h3><?php _e('Características Técnicas', 'tradeexpansion'); ?></h3>
  <div class="te-field-row">
    <div class="te-field-group">
      <label for="te_absorcao"><?php _e('Absorção de Água', 'tradeexpansion'); ?></label>
      <input type="text" id="te_absorcao" name="te_absorcao" value="<?php echo esc_attr($absorcao); ?>"
        placeholder="Ex: 0.4%">
    </div>

    <div class="te-field-group">
      <label for="te_densidade"><?php _e('Densidade', 'tradeexpansion'); ?></label>
      <input type="text" id="te_densidade" name="te_densidade" value="<?php echo esc_attr($densidade); ?>"
        placeholder="Ex: 2.630 kg/m³">
    </div>

    <div class="te-field-group">
      <label for="te_resistencia"><?php _e('Resistência', 'tradeexpansion'); ?></label>
      <select id="te_resistencia" name="te_resistencia">
        <option value=""><?php _e('Selecione...', 'tradeexpansion'); ?></option>
        <option value="Baixa" <?php selected($resistencia, 'Baixa'); ?>><?php _e('Baixa', 'tradeexpansion'); ?></option>
        <option value="Média" <?php selected($resistencia, 'Média'); ?>><?php _e('Média', 'tradeexpansion'); ?></option>
        <option value="Alta" <?php selected($resistencia, 'Alta'); ?>><?php _e('Alta', 'tradeexpansion'); ?></option>
        <option value="Muito Alta" <?php selected($resistencia, 'Muito Alta'); ?>>
          <?php _e('Muito Alta', 'tradeexpansion'); ?>
        </option>
      </select>
    </div>
  </div>

  <div class="te-field-group">
    <label for="te_acabamentos"><?php _e('Acabamentos Disponíveis', 'tradeexpansion'); ?></label>
    <input type="text" id="te_acabamentos" name="te_acabamentos" value="<?php echo esc_attr($acabamentos); ?>"
      placeholder="Ex: Polido, Flameado, Levigado">
    <small><?php _e('Separe por vírgulas', 'tradeexpansion'); ?></small>
  </div>

  <div class="te-field-group">
    <label for="te_aplicacoes"><?php _e('Aplicações Recomendadas', 'tradeexpansion'); ?></label>
    <input type="text" id="te_aplicacoes" name="te_aplicacoes" value="<?php echo esc_attr($aplicacoes); ?>"
      placeholder="Ex: Pisos, Revestimentos, Bancadas">
    <small><?php _e('Separe por vírgulas', 'tradeexpansion'); ?></small>
  </div>

  <div class="te-field-group">
    <label><?php _e('Descrição do Produto', 'tradeexpansion'); ?></label>
    <small><?php _e('Use o editor principal acima para adicionar a descrição detalhada do produto.', 'tradeexpansion'); ?></small>
  </div>
  <?php
}

// Callback do Metabox - Galeria de Imagens
function te_product_images_callback($post)
{
  $gallery_ids = get_post_meta($post->ID, '_te_gallery_ids', true);
  $gallery_ids = $gallery_ids ? explode(',', $gallery_ids) : [];
  ?>
  <style>
    #te-gallery-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 15px;
    }

    .te-gallery-item {
      position: relative;
    }

    .te-gallery-item img {
      width: 100%;
      height: 100px;
      object-fit: cover;
      border-radius: 4px;
    }

    .te-gallery-remove {
      position: absolute;
      top: 5px;
      right: 5px;
      background: red;
      color: white;
      border: none;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      cursor: pointer;
      font-size: 14px;
      line-height: 1;
    }
  </style>

  <p><strong><?php _e('Imagem Destacada:', 'tradeexpansion'); ?></strong>
    <?php _e('Use a caixa "Imagem Destacada" ao lado para a imagem principal.', 'tradeexpansion'); ?></p>

  <p><strong><?php _e('Galeria Adicional:', 'tradeexpansion'); ?></strong></p>
  <div id="te-gallery-container">
    <?php foreach ($gallery_ids as $img_id): ?>
      <?php if ($img_id): ?>
        <div class="te-gallery-item" data-id="<?php echo esc_attr($img_id); ?>">
          <img src="<?php echo wp_get_attachment_image_url($img_id, 'thumbnail'); ?>">
          <button type="button" class="te-gallery-remove">×</button>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <input type="hidden" id="te_gallery_ids" name="te_gallery_ids"
    value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>">
  <button type="button" class="button"
    id="te-add-gallery-image"><?php _e('Adicionar Imagens à Galeria', 'tradeexpansion'); ?></button>

  <script>
    jQuery(document).ready(function ($) {
      let frame;

      $('#te-add-gallery-image').on('click', function (e) {
        e.preventDefault();

        if (frame) {
          frame.open();
          return;
        }

        frame = wp.media({
          title: '<?php _e('Selecione as Imagens', 'tradeexpansion'); ?>',
          button: { text: '<?php _e('Adicionar à Galeria', 'tradeexpansion'); ?>' },
          multiple: true
        });

        frame.on('select', function () {
          const selection = frame.state().get('selection');
          const ids = $('#te_gallery_ids').val().split(',').filter(id => id);

          selection.forEach(function (attachment) {
            attachment = attachment.toJSON();
            if (!ids.includes(attachment.id.toString())) {
              ids.push(attachment.id);
              $('#te-gallery-container').append(`
              <div class="te-gallery-item" data-id="${attachment.id}">
                <img src="${attachment.sizes.thumbnail.url}">
                <button type="button" class="te-gallery-remove">×</button>
              </div>
            `);
            }
          });

          $('#te_gallery_ids').val(ids.join(','));
        });

        frame.open();
      });

      $(document).on('click', '.te-gallery-remove', function () {
        const item = $(this).closest('.te-gallery-item');
        const id = item.data('id');
        const ids = $('#te_gallery_ids').val().split(',').filter(i => i != id);
        $('#te_gallery_ids').val(ids.join(','));
        item.remove();
      });
    });
  </script>
  <?php
}

// Salva os metadados do produto
add_action('save_post_te_catalog_product', 'te_save_catalog_product_meta');
function te_save_catalog_product_meta($post_id)
{
  // Verificações de segurança
  if (!isset($_POST['te_product_meta_nonce']))
    return;
  if (!wp_verify_nonce($_POST['te_product_meta_nonce'], 'te_save_product_meta'))
    return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;
  if (!current_user_can('edit_post', $post_id))
    return;

  // Campos simples
  $fields = [
    'te_nome_geologico',
    'te_origem',
    'te_absorcao',
    'te_densidade',
    'te_resistencia',
    'te_acabamentos',
    'te_aplicacoes',
    'te_gallery_ids',
  ];

  foreach ($fields as $field) {
    if (isset($_POST[$field])) {
      update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
    }
  }
}

// Adiciona coluna de imagem na listagem do admin
add_filter('manage_te_catalog_product_posts_columns', 'te_catalog_admin_columns');
function te_catalog_admin_columns($columns)
{
  $new_columns = [];
  $new_columns['cb'] = $columns['cb'];
  $new_columns['image'] = __('Imagem', 'tradeexpansion');
  $new_columns['title'] = $columns['title'];
  $new_columns['taxonomy-tipo_rocha'] = __('Tipo', 'tradeexpansion');
  $new_columns['taxonomy-cor_rocha'] = __('Cor', 'tradeexpansion');
  $new_columns['date'] = $columns['date'];
  return $new_columns;
}

add_action('manage_te_catalog_product_posts_custom_column', 'te_catalog_admin_column_content', 10, 2);
function te_catalog_admin_column_content($column, $post_id)
{
  if ($column === 'image') {
    $thumbnail = get_the_post_thumbnail($post_id, [50, 50]);
    echo $thumbnail ? $thumbnail : '—';
  }
}

/**
 * FUNÇÃO HELPER: Busca produtos para uso nos templates
 * Esta função DEVE estar DEPOIS de todas as definições acima
 */
if (!function_exists('te_get_catalog_products')) {
  function te_get_catalog_products($args = [])
  {
    $defaults = [
      'post_type' => 'te_catalog_product',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ];

    $args = wp_parse_args($args, $defaults);
    $query = new WP_Query($args);

    $products = [];

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        // Busca os termos (tipo e cor)
        $tipos = wp_get_post_terms($post_id, 'tipo_rocha', ['fields' => 'slugs']);
        $cores = wp_get_post_terms($post_id, 'cor_rocha', ['fields' => 'slugs']);

        // Busca a galeria
        $gallery_ids = get_post_meta($post_id, '_te_gallery_ids', true);
        $gallery_ids = $gallery_ids ? explode(',', $gallery_ids) : [];
        $imagens_adicionais = [];
        foreach ($gallery_ids as $img_id) {
          if ($img_id) {
            $imagens_adicionais[] = wp_get_attachment_image_url($img_id, 'large');
          }
        }

        $products[] = [
          'id' => $post_id,
          'nome' => get_the_title(),
          'nome_geologico' => get_post_meta($post_id, '_te_nome_geologico', true),
          'tipo' => !empty($tipos) ? $tipos[0] : '',
          'cor' => !empty($cores) ? $cores[0] : '',
          'origem' => get_post_meta($post_id, '_te_origem', true),
          'imagem_principal' => get_the_post_thumbnail_url($post_id, 'large') ?: '',
          'imagens_adicionais' => $imagens_adicionais,
          'caracteristicas' => [
            'absorcao' => get_post_meta($post_id, '_te_absorcao', true),
            'densidade' => get_post_meta($post_id, '_te_densidade', true),
            'resistencia' => get_post_meta($post_id, '_te_resistencia', true),
          ],
          'acabamentos' => get_post_meta($post_id, '_te_acabamentos', true),
          'aplicacoes' => get_post_meta($post_id, '_te_aplicacoes', true),
          'descricao' => get_the_content(),
        ];
      }
      wp_reset_postdata();
    }

    return $products;
  }
}

// Handler AJAX para criar relatório no frontend
add_action('wp_ajax_create_report_frontend', 'te_create_report_frontend');
function te_create_report_frontend()
{
  // Verifica permissões
  if (!current_user_can('edit_posts')) {
    wp_send_json_error('Sem permissão');
    return;
  }

  // Cria o post
  $report_id = wp_insert_post([
    'post_type' => 'tec_relatorio',
    'post_title' => sanitize_text_field($_POST['title']),
    'post_content' => wp_kses_post($_POST['content']),
    'post_status' => 'publish',
    'post_author' => get_current_user_id()
  ]);

  if (is_wp_error($report_id)) {
    wp_send_json_error('Erro ao criar relatório');
    return;
  }

  // Salva metadados
  update_post_meta($report_id, 'tec_cliente_id', intval($_POST['client_id']));
  update_post_meta($report_id, 'tec_status', sanitize_text_field($_POST['status']));

  // Upload do PDF se houver
  if (!empty($_FILES['pdf'])) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $attachment_id = media_handle_upload('pdf', $report_id);

    if (!is_wp_error($attachment_id)) {
      update_post_meta($report_id, 'tec_pdf_id', $attachment_id);
    }
  }

  wp_send_json_success(['report_id' => $report_id]);
}

// Handler do formulário de inspeção
add_action('admin_post_nopriv_submit_inspection_request', 'handle_inspection_request');
add_action('admin_post_submit_inspection_request', 'handle_inspection_request');

function handle_inspection_request()
{
  if (!isset($_POST['inspection_nonce']) || !wp_verify_nonce($_POST['inspection_nonce'], 'inspection_request')) {
    wp_die('Erro de segurança');
  }

  $name = sanitize_text_field($_POST['name']);
  $email = sanitize_email($_POST['email']);
  $company = sanitize_text_field($_POST['company']);
  $material = sanitize_text_field($_POST['material']);
  $message = sanitize_textarea_field($_POST['message']);

  // Envia email
  $to = get_option('admin_email');
  $subject = 'Nova Solicitação de Inspeção - ' . $name;
  $body = "Nome: $name\nEmail: $email\nEmpresa: $company\nMaterial: $material\n\nMensagem:\n$message";

  wp_mail($to, $subject, $body);

  wp_redirect(add_query_arg('inspection', 'success', wp_get_referer()));
  exit;
}
?>

<?php
// ==================== CUSTOM POST TYPE: ROCHAS ORNAMENTAIS ====================

function registrar_cpt_rochas()
{
  $labels = array(
    'name' => __('Rochas Ornamentais', 'tradeexpansion'),
    'singular_name' => __('Rocha Ornamental', 'tradeexpansion'),
    'menu_name' => __('Rochas Ornamentais', 'tradeexpansion'),
    'add_new' => __('Adicionar Nova', 'tradeexpansion'),
    'add_new_item' => __('Adicionar Nova Rocha', 'tradeexpansion'),
    'edit_item' => __('Editar Rocha', 'tradeexpansion'),
    'view_item' => __('Ver Rocha', 'tradeexpansion'),
  );

  $args = array(
    'label' => __('Rochas Ornamentais', 'tradeexpansion'),
    'labels' => $labels,
    'description' => __('Catálogo de rochas ornamentais brasileiras', 'tradeexpansion'),
    'public' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-images-alt2',
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'has_archive' => true,
    'rewrite' => array('slug' => 'rochas'),
    'taxonomies' => array('rocha_tipo', 'rocha_cor'),
  );

  register_post_type('rocha', $args);

  // Taxonomia: Tipo de Rocha
  register_taxonomy('rocha_tipo', 'rocha', array(
    'label' => __('Tipo de Rocha', 'tradeexpansion'),
    'rewrite' => array('slug' => 'tipo'),
    'hierarchical' => false,
    'show_ui' => true,
    'public' => true,
  ));

  // Taxonomia: Cor
  register_taxonomy('rocha_cor', 'rocha', array(
    'label' => __('Cor', 'tradeexpansion'),
    'rewrite' => array('slug' => 'cor'),
    'hierarchical' => false,
    'show_ui' => true,
    'public' => true,
  ));
}

add_action('init', 'registrar_cpt_rochas');

// Meta Box para ordem de exibição
function adicionar_metabox_rocha()
{
  add_meta_box(
    'rocha_metabox',
    __('Configurações da Rocha', 'tradeexpansion'),
    'render_metabox_rocha',
    'rocha',
    'normal',
    'high'
  );
}

add_action('add_meta_boxes', 'adicionar_metabox_rocha');

function render_metabox_rocha($post)
{
  $ordem = get_post_meta($post->ID, '_rocha_ordem', true);
  $destaque = get_post_meta($post->ID, '_rocha_destaque', true);

  ?>
  <div style="margin: 10px 0;">
    <label for="rocha_ordem"><?php _e('Ordem de Exibição:', 'tradeexpansion'); ?></label>
    <input type="number" id="rocha_ordem" name="rocha_ordem" value="<?php echo esc_attr($ordem); ?>"
      style="width: 60px;" />
    <small><?php _e('Deixe 0 para desabilitar', 'tradeexpansion'); ?></small>
  </div>

  <div style="margin: 10px 0;">
    <label for="rocha_destaque">
      <input type="checkbox" id="rocha_destaque" name="rocha_destaque" value="1" <?php checked($destaque, 1); ?> />
      <?php _e('Exibir nas 10 Principais?', 'tradeexpansion'); ?>
    </label>
  </div>
  <?php
}

function salvar_metabox_rocha($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  if (isset($_POST['rocha_ordem'])) {
    update_post_meta($post_id, '_rocha_ordem', sanitize_text_field($_POST['rocha_ordem']));
  }

  if (isset($_POST['rocha_destaque'])) {
    update_post_meta($post_id, '_rocha_destaque', 1);
  } else {
    delete_post_meta($post_id, '_rocha_destaque');
  }
}

add_action('save_post', 'salvar_metabox_rocha');
?>

<?php
// ==================== PARTE 1: CRIAR ROCHA ====================

// Essa função cria um novo tipo chamado "rocha" no WordPress
function criar_tipo_rocha()
{

  // Aqui a gente dá nomes em português
  $nomes = array(
    'name' => __('Rochas Ornamentais', 'tradeexpansion'),
    'singular_name' => __('Rocha Ornamental', 'tradeexpansion'),
    'menu_name' => __('Rochas Ornamentais', 'tradeexpansion'),
    'add_new' => __('Adicionar Nova', 'tradeexpansion'),
    'add_new_item' => __('Adicionar Nova Rocha', 'tradeexpansion'),
    'edit_item' => __('Editar Rocha', 'tradeexpansion'),
    'view_item' => __('Ver Rocha', 'tradeexpansion'),
  );

  // Aqui a gente configura como o WordPress vai tratar as rochas
  $config = array(
    'label' => __('Rochas Ornamentais', 'tradeexpansion'),
    'labels' => $nomes,  // Usa os nomes que definimos acima
    'description' => __('Catálogo de rochas ornamentais brasileiras', 'tradeexpansion'),
    'public' => true,    // Mostra no site
    'show_in_menu' => true,    // Aparece no menu do admin
    'menu_icon' => 'dashicons-images-alt2',  // Ícone no menu (imagem)
    'supports' => array('title', 'editor', 'thumbnail'), // Título, conteúdo e foto
    'has_archive' => true,    // Permite listar todas as rochas
    'rewrite' => array('slug' => 'rochas'), // URL fica /rochas/nome-da-rocha
  );

  // Registra (cadastra) o novo tipo no WordPress
  register_post_type('rocha', $config);
}

// Diz ao WordPress: "Quando você iniciar, execute a função criar_tipo_rocha()"
add_action('init', 'criar_tipo_rocha');

// ==================== PARTE 2: META BOX DO SKU ====================

// Essa função cria a caixa do SKU que aparece ao editar uma rocha
function criar_metabox_sku()
{
  add_meta_box(
    'rocha_sku_box',                                    // ID único dessa caixa
    __('Código do Produto (SKU)', 'tradeexpansion'),  // Título da caixa
    'renderizar_metabox_sku',                           // Função que desenha a caixa
    'rocha',                                            // Tipo: só aparece em "Rochas"
    'normal',                                           // Posição: normal (nem topo, nem lado)
    'high'                                              // Prioridade: alta (aparece primeiro)
  );
}

// Essa função desenha o que aparece DENTRO da caixa
function renderizar_metabox_sku($post)
{
  // Pega o SKU salvo (se existir)
  $sku_salvo = get_post_meta($post->ID, '_rocha_sku', true);

  // Pega os 3 primeiros caracteres do prefixo (ex: TUL de TUL-056)
  $prefixo = substr($sku_salvo, 0, 3);

  // Desenha o HTML (a caixa que você vai ver)
  ?>
  <div style="margin: 15px 0;">
    <label for="rocha_sku" style="display: block; margin-bottom: 8px; font-weight: bold;">
      <?php _e('SKU (Código Único):', 'tradeexpansion'); ?>
    </label>

    <!-- Campo de entrada -->
    <input type="text" id="rocha_sku" name="rocha_sku" value="<?php echo esc_attr($sku_salvo); ?>"
      placeholder="Ex: TUL-056" maxlength="7" pattern="[A-Z]{3}-[0-9]{3}"
      style="width: 200px; padding: 10px; border: 2px solid #ccc; border-radius: 4px; font-family: monospace; font-size: 16px;" />

    <!-- Ajuda embaixo -->
    <p style="margin-top: 10px; color: #666; font-size: 13px;">
      <?php _e('📌 Formato: 3 LETRAS - 3 NÚMEROS (ex: TUL-056)', 'tradeexpansion'); ?><br>
      <?php _e('⚠️ Cada PREFIXO só pode aparecer UMA VEZ. Ex: TUL-056 já existe? Não pode usar TUL-999', 'tradeexpansion'); ?>
    </p>

    <!-- Aviso de duplicata (se existir) -->
    <?php
    // Se o prefixo foi usado antes COM UM NÚMERO DIFERENTE
    if ($prefixo && strlen($prefixo) === 3) {
      $outro_com_mesmo_prefixo = get_posts(array(
        'post_type' => 'rocha',
        'posts_per_page' => 1,
        'meta_query' => array(
          array(
            'key' => '_rocha_sku',
            'value' => $prefixo . '-%',
            'compare' => 'LIKE'
          )
        ),
        'exclude' => array($post->ID) // Não contar a própria rocha
      ));

      if ($outro_com_mesmo_prefixo) {
        $outro_sku = get_post_meta($outro_com_mesmo_prefixo[0]->ID, '_rocha_sku', true);
        ?>
        <p style="margin-top: 10px; padding: 10px; background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;">
          ⚠️ <strong><?php _e('Atenção:', 'tradeexpansion'); ?></strong>
          <?php printf(
            __('O prefixo "%s" já está em uso: %s', 'tradeexpansion'),
            esc_html($prefixo),
            esc_html($outro_sku)
          ); ?>
        </p>
        <?php
      }
    }
    ?>
  </div>
  <?php
}

// Diz ao WordPress: execute criar_metabox_sku() quando o admin carregar
add_action('add_meta_boxes', 'criar_metabox_sku');

// ==================== PARTE 3: SALVAR O SKU ====================

// Essa função salva o SKU quando você clica em "Atualizar"

function salvar_sku_rocha($post_id)
{
  // NÃO FAZE NADA AQUI - validação é no frontend form
  return;

  /* CÓDIGO ANTIGO COMENTADO PARA REFERÊNCIA
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
  }

  if ( isset( $_POST['rocha_sku'] ) ) {
      $sku = sanitize_text_field( $_POST['rocha_sku'] );

      if ( preg_match( '/^[A-Z]{3}-[0-9]{3}$/', $sku ) ) {
          $outro_com_mesmo_sku = get_posts( array(
              'post_type'      => 'rocha',
              'posts_per_page' => 1,
              'meta_query'     => array(
                  array(
                      'key'     => '_rocha_sku',
                      'value'   => $sku,
                      'compare' => '='
                  )
              ),
              'exclude'        => array( $post_id )
          ));

          if ( ! $outro_com_mesmo_sku ) {
              update_post_meta( $post_id, '_rocha_sku', $sku );
          } else {
              wp_die( __( 'Erro: Este SKU já existe! Use outro número.', 'tradeexpansion' ) );
          }
      } else {
          wp_die( __( 'Erro: SKU deve ter o formato XXX-000', 'tradeexpansion' ) );
      }
  }
  */
}

// ==================== AJAX: Verificar SKU ====================

function verificar_sku_rocha_ajax()
{
  if (!isset($_POST['sku'])) {
    wp_send_json_error('SKU não fornecido');
  }

  $sku = sanitize_text_field($_POST['sku']);

  $sku_existe = get_posts(array(
    'post_type' => 'rocha',
    'posts_per_page' => 1,
    'meta_query' => array(
      array(
        'key' => '_rocha_sku',
        'value' => $sku,
      )
    ),
    'fields' => 'ids'
  ));

  wp_send_json(array(
    'existe' => !empty($sku_existe)
  ));
}

add_action('wp_ajax_verificar_sku_rocha', 'verificar_sku_rocha_ajax');
add_action('wp_ajax_nopriv_verificar_sku_rocha', 'verificar_sku_rocha_ajax');

/**
 * ATIVAÇÃO DE PERMISSÕES - PORTAL GLOBAL MARMOL
 * 
 * Instruções:
 * 1. Troque o '0' pelo ID do usuário que você deseja dar acesso.
 * 2. Salve este arquivo e abra qualquer página do seu site.
 * 3. Após abrir a página, apague este bloco de código.
 */
function te_ativar_permissoes_global_marmol()
{
  $user_id = 0; // <--- COLOQUE O ID DO USUÁRIO AQUI (Ex: 12)

  if ($user_id > 0) {
    update_user_meta($user_id, 'gm_can_view_favorita', true);
    update_user_meta($user_id, 'gm_can_view_policast', true);
    update_user_meta($user_id, 'gm_can_view_management', true);
  }
}
add_action('init', 'te_ativar_permissoes_global_marmol');

?>
<?php
// ============================================
// SISTEMA DE ROLES E PERMISSÕES
// ============================================

// Incluir arquivo de permissões
require_once get_template_directory() . '/client-portal/includes/permissions.php';

// Registrar roles customizados na ativação do tema
add_action('after_switch_theme', 'te_register_custom_roles');

// Adicionar meta boxes para configurações de usuário
add_action('show_user_profile', 'te_add_user_permission_fields');
add_action('edit_user_profile', 'te_add_user_permission_fields');

function te_add_user_permission_fields($user) {
  $user_roles = $user->roles;
  
  // Meta box para Clientes
  if (in_array('te_cliente', $user_roles)) {
    $company_id = get_user_meta($user->ID, 'te_client_company_id', true);
    ?>
    <h3>Configurações do Cliente</h3>
    <table class="form-table">
      <tr>
        <th><label for="te_client_company_id">ID da Empresa</label></th>
        <td>
          <select name="te_client_company_id" id="te_client_company_id" class="regular-text">
            <option value="">Selecione...</option>
            <?php foreach (te_get_available_clients() as $id => $name): ?>
              <option value="<?php echo esc_attr($id); ?>" <?php selected($company_id, $id); ?>>
                <?php echo esc_html($name); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="description">Empresa à qual este cliente pertence</p>
        </td>
      </tr>
    </table>
    <?php
  }
  
  // Meta box para Vendedores
  if (in_array('te_vendedor', $user_roles)) {
    $supplier_id = get_user_meta($user->ID, 'te_vendor_supplier_id', true);
    $vendor_clients = get_user_meta($user->ID, 'te_vendor_clients', true);
    if (!is_array($vendor_clients)) {
      $vendor_clients = [];
    }
    ?>
    <h3>Configurações do Vendedor</h3>
    <table class="form-table">
      <tr>
        <th><label for="te_vendor_supplier_id">Fornecedor</label></th>
        <td>
          <select name="te_vendor_supplier_id" id="te_vendor_supplier_id" class="regular-text">
            <option value="">Selecione...</option>
            <?php foreach (te_get_available_suppliers() as $id => $name): ?>
              <option value="<?php echo esc_attr($id); ?>" <?php selected($supplier_id, $id); ?>>
                <?php echo esc_html($name); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="description">Fornecedor que este vendedor representa</p>
        </td>
      </tr>
      <tr>
        <th><label>Clientes Vinculados</label></th>
        <td>
          <?php foreach (te_get_available_clients() as $id => $name): ?>
            <label style="display: block; margin-bottom: 8px;">
              <input type="checkbox" 
                     name="te_vendor_clients[]" 
                     value="<?php echo esc_attr($id); ?>"
                     <?php checked(in_array($id, $vendor_clients)); ?>>
              <?php echo esc_html($name); ?>
            </label>
          <?php endforeach; ?>
          <p class="description">Clientes que este vendedor pode acessar</p>
        </td>
      </tr>
    </table>
    <?php
  }
}

// Salvar meta fields de permissões
add_action('personal_options_update', 'te_save_user_permission_fields');
add_action('edit_user_profile_update', 'te_save_user_permission_fields');

function te_save_user_permission_fields($user_id) {
  if (!current_user_can('edit_user', $user_id)) {
    return false;
  }
  
  $user = get_userdata($user_id);
  $user_roles = $user->roles;
  
  // Salvar dados de Cliente
  if (in_array('te_cliente', $user_roles)) {
    if (isset($_POST['te_client_company_id'])) {
      update_user_meta($user_id, 'te_client_company_id', sanitize_text_field($_POST['te_client_company_id']));
      
      // Atualizar nome da empresa automaticamente
      $clients = te_get_available_clients();
      $company_id = sanitize_text_field($_POST['te_client_company_id']);
      if (isset($clients[$company_id])) {
        update_user_meta($user_id, 'te_client_company_name', $clients[$company_id]);
      }
    }
  }
  
  // Salvar dados de Vendedor
  if (in_array('te_vendedor', $user_roles)) {
    if (isset($_POST['te_vendor_supplier_id'])) {
      update_user_meta($user_id, 'te_vendor_supplier_id', sanitize_text_field($_POST['te_vendor_supplier_id']));
      
      // Atualizar nome do fornecedor automaticamente
      $suppliers = te_get_available_suppliers();
      $supplier_id = sanitize_text_field($_POST['te_vendor_supplier_id']);
      if (isset($suppliers[$supplier_id])) {
        update_user_meta($user_id, 'te_vendor_supplier_name', $suppliers[$supplier_id]);
      }
    }
    
    if (isset($_POST['te_vendor_clients'])) {
      $vendor_clients = array_map('sanitize_text_field', $_POST['te_vendor_clients']);
      update_user_meta($user_id, 'te_vendor_clients', $vendor_clients);
    } else {
      update_user_meta($user_id, 'te_vendor_clients', []);
    }
  }
}
