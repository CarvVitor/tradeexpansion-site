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

// Esconde admin bar no front-end para clientes
add_filter('show_admin_bar', function ($show) {
  if (is_admin()) return $show;
  if (!is_user_logged_in()) return $show;
  $u = wp_get_current_user();
  if ($u && in_array('cliente', (array) $u->roles, true)) {
    return false;
  }
  return $show;
});

add_action('wp_head', function () {
  if (!is_user_logged_in() || is_admin()) return;
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
function tec_portal_register_settings() {
    register_setting('tece_portal', 'tece_fin_url', [
        'type'              => 'string',
        'sanitize_callback' => 'tec_portal_sanitize_fin_url',
        'default'           => '',
    ]);

    register_setting('tece_portal', 'tece_fin_cache_minutes', [
        'type'              => 'integer',
        'sanitize_callback' => 'tec_portal_sanitize_cache_minutes',
        'default'           => 5,
    ]);

    register_setting('tece_portal', 'tece_primary_color', [
        'type'              => 'string',
        'sanitize_callback' => 'tec_portal_sanitize_primary_color',
        'default'           => '#102724',
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

function tec_portal_settings_page() {
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

function tec_portal_field_fin_url() {
    $value = esc_url(get_option('tece_fin_url', ''));
    echo '<input type="url" class="regular-text" name="tece_fin_url" id="tece_fin_url" value="' . $value . '" placeholder="https://script.google.com/...">';
    echo '<p class="description">' . esc_html__('URL do Apps Script/endpoint que retorna os dados financeiros em JSON.', 'tradeexpansion') . '</p>';
}

function tec_portal_field_fin_cache() {
    $value = (int) get_option('tece_fin_cache_minutes', 5);
    echo '<input type="number" min="1" step="1" name="tece_fin_cache_minutes" id="tece_fin_cache_minutes" value="' . esc_attr($value) . '">';
    echo '<p class="description">' . esc_html__('Tempo em minutos que os dados da API permanecem em cache.', 'tradeexpansion') . '</p>';
}

function tec_portal_field_primary_color() {
    $value = esc_attr(get_option('tece_primary_color', '#102724'));
    echo '<input type="text" class="regular-text" name="tece_primary_color" id="tece_primary_color" value="' . $value . '" placeholder="#102724">';
    echo '<p class="description">' . esc_html__('Hexadecimal da cor principal do dashboard (ex: #102724).', 'tradeexpansion') . '</p>';
}

function tec_portal_sanitize_fin_url($value) {
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

function tec_portal_sanitize_cache_minutes($value) {
    $value = absint($value);
    if ($value < 1) {
        add_settings_error('tece_fin_cache_minutes', 'tece_fin_cache_minutes_invalid', __('Defina pelo menos 1 minuto de cache.', 'tradeexpansion'));
        $value = 1;
    }
    return $value;
}

function tec_portal_sanitize_primary_color($value) {
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
        'methods'             => WP_REST_Server::EDITABLE,
        'callback'            => 'tec_portal_rest_update_report',
        'permission_callback' => function ($request) {
            $post_id = (int) $request['id'];
            return current_user_can('edit_post', $post_id);
        },
        'args' => [
            'title' => [
                'type'     => 'string',
                'required' => false,
            ],
            'content' => [
                'type'     => 'string',
                'required' => false,
            ],
        ],
    ]);

    register_rest_route('te/v1', '/inspecao/(?P<id>\d+)', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'tec_portal_rest_attach_inspection_media',
        'permission_callback' => function ($request) {
            $post_id = (int) $request['id'];
            return current_user_can('edit_post', $post_id) && current_user_can('upload_files');
        },
        'args' => [
            'attachments' => [
                'type'     => 'array',
                'required' => true,
            ],
        ],
    ]);
});

function tec_portal_rest_update_report(WP_REST_Request $request) {
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
        'id'      => $post_id,
        'title'   => $post->post_title,
        'content' => $post->post_content,
        'note'    => wp_strip_all_tags($post->post_content),
    ]);
}

function tec_portal_rest_attach_inspection_media(WP_REST_Request $request) {
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

function tec_portal_assign_material_term($attachment_id, $value) {
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

function tec_portal_sideload_attachment($url, $post_id) {
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
      [ 'core/cover', [ 'dimRatio' => 40, 'useFeaturedImage' => true ], [
        [ 'core/heading',  [ 'level' => 1, 'placeholder' => 'Título do relatório' ] ],
        [ 'core/paragraph',[ 'placeholder' => 'Resumo curto do relatório (2–3 linhas)...' ] ],
      ]],
      [ 'core/spacer', [ 'height' => '24px' ] ],
      [ 'core/group', [ 'layout' => [ 'type' => 'constrained' ] ], [
        [ 'core/heading', [ 'level' => 3, 'content' => 'Dados principais' ] ],
        [ 'core/list', [], [
          [ 'core/list-item', [ 'content' => 'Cliente: <strong>preencha aqui</strong>' ] ],
          [ 'core/list-item', [ 'content' => 'Status: <strong>aprovado/pendente/reprovado</strong>' ] ],
          [ 'core/list-item', [ 'content' => 'Data: <strong>dd/mm/aaaa</strong>' ] ],
        ]],
      ]],
      [ 'core/spacer', [ 'height' => '12px' ] ],
      [ 'core/heading', [ 'level' => 3, 'content' => 'Conteúdo' ] ],
      [ 'core/paragraph', [ 'placeholder' => 'Descreva resultados, observações, itens inspecionados...' ] ],
      [ 'core/spacer', [ 'height' => '12px' ] ],
      [ 'core/file', [] ],
    ],
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

/* ==== ADMIN LIST COLUMNS FOR CPTs ==== */

function tec_portal_get_client_name($user_id) {
  $user = $user_id ? get_user_by('id', (int) $user_id) : null;
  return $user ? ($user->display_name ?: $user->user_login) : __('Sem cliente', 'tradeexpansion');
}

// Relatórios
add_filter('manage_tec_relatorio_posts_columns', function ($columns) {
  $new = [
    'cb'       => $columns['cb'],
    'title'    => __('Relatório', 'tradeexpansion'),
    'cliente'  => __('Cliente', 'tradeexpansion'),
    'status'   => __('Status', 'tradeexpansion'),
    'date'     => $columns['date'] ?? __('Data', 'tradeexpansion'),
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
  $columns['status']  = 'status';
  return $columns;
});

// Inspeções
add_filter('manage_tec_inspecao_posts_columns', function ($columns) {
  $new = [
    'cb'       => $columns['cb'],
    'title'    => __('Inspeção', 'tradeexpansion'),
    'cliente'  => __('Cliente', 'tradeexpansion'),
    'total_m2' => __('Total m²', 'tradeexpansion'),
    'date'     => $columns['date'] ?? __('Data', 'tradeexpansion'),
  ];
  return $new;
});

if (!function_exists('tec_portal_calculate_total_m2')) {
  function tec_portal_calculate_total_m2($post_id) {
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
    'cb'        => $columns['cb'],
    'title'     => __('Lançamento', 'tradeexpansion'),
    'cliente'   => __('Cliente', 'tradeexpansion'),
    'valor'     => __('Valor (R$)', 'tradeexpansion'),
    'status'    => __('Status', 'tradeexpansion'),
    'vencimento'=> __('Vencimento', 'tradeexpansion'),
    'date'      => $columns['date'] ?? __('Data', 'tradeexpansion'),
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
  $columns['cliente']   = 'cliente';
  $columns['valor']     = 'valor';
  $columns['status']    = 'status';
  $columns['vencimento']= 'vencimento';
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
        'display'  => __('A cada 10 minutos (Financeiro Portal)', 'tradeexpansion'),
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
function tec_portal_run_fin_sync() {
    $users = get_users([
        'role'       => 'cliente',
        'meta_key'   => 'tec_show_financial',
        'meta_value' => 'yes',
        'fields'     => ['ID'],
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

function tec_portal_fetch_financial_remote($uid) {
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
  // Relatório: cliente + status
  add_meta_box('tec_relatorio_meta', 'Dados do Relatório', function ($post) {
    $cliente_id = get_post_meta($post->ID, 'tec_cliente_id', true);
    $status     = get_post_meta($post->ID, 'tec_status', true); // aprovado|pendente|reprovado

    tec_select_cliente_field($post, $cliente_id);

    echo '<p><label for="tec_status">Status: </label>';
    echo '<select id="tec_status" name="tec_status">';
    foreach (['aprovado'=>'Aprovado','pendente'=>'Pendente','reprovado'=>'Reprovado'] as $val=>$label) {
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
    'tec_relatorio' => ['tec_cliente_id','tec_status'],
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

/* ==== TRADEEXPANSION • MATERIAIS E FOTOS DE INSPEÇÃO ==== */
// Taxonomia para classificar fotos e inspeções por material
add_action('init', function () {
  register_taxonomy('tec_material', ['attachment','tec_inspecao'], [
    'labels' => [
      'name'          => 'Materiais',
      'singular_name' => 'Material',
    ],
    'public'            => false,
    'show_ui'           => true,
    'hierarchical'      => false,
    'show_admin_column' => false,
  ]);

  // Garante termos básicos
  foreach (['Mármore','Granito','Quartzito','Quartzo','Outro'] as $t) {
    if (!term_exists($t, 'tec_material')) {
      wp_insert_term($t, 'tec_material');
    }
  }
});

// Campos extras no anexo (foto): Material + Observação
add_filter('attachment_fields_to_edit', function ($form_fields, $post) {
  if (strpos((string)$post->post_mime_type, 'image') === false) return $form_fields;

  // Dropdown de Materiais (taxonomia)
  $terms = get_terms(['taxonomy' => 'tec_material', 'hide_empty' => false]);
  $cur   = wp_get_object_terms($post->ID, 'tec_material', ['fields' => 'ids']);
  $curId = $cur ? (int)$cur[0] : 0;

  $html = '<select name="attachments['.$post->ID.'][tec_material]" id="attachments-'.$post->ID.'-tec_material">';
  $html .= '<option value="">— Material —</option>';
  foreach ($terms as $term) {
    $sel = selected($curId, (int)$term->term_id, false);
    $html .= '<option value="'.(int)$term->term_id.'" '.$sel.'>'.esc_html($term->name).'</option>';
  }
  $html .= '</select>';

  $form_fields['tec_material'] = [
    'label' => 'Material',
    'input' => 'html',
    'html'  => $html,
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
    wp_set_object_terms($post['ID'], (int)$attachment['tec_material'], 'tec_material', false);
  } else {
    wp_set_object_terms($post['ID'], [], 'tec_material', false);
  }
  return $post;
}, 10, 2);

/* ==== CLIENT PORTAL • PROFILE FINANCIAL TOGGLE ==== */
if (!function_exists('tec_portal_financial_field')) {
  function tec_portal_financial_field($user) {
    if (!current_user_can('manage_options')) return;
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
  function tec_portal_financial_field_new_user($operation) {
    if (!current_user_can('manage_options')) return;
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
  function tec_portal_save_financial_field($user_id) {
    if (!current_user_can('manage_options')) return;
    $value = isset($_POST['tec_show_financial']) ? 'yes' : 'no';
    update_user_meta($user_id, 'tec_show_financial', $value);
  }
}
add_action('personal_options_update', 'tec_portal_save_financial_field');
add_action('edit_user_profile_update', 'tec_portal_save_financial_field');
add_action('user_register', 'tec_portal_save_financial_field');

/* Helper: checa se o usuário tem acesso ao módulo financeiro */
if (!function_exists('tec_portal_user_has_financial')) {
  function tec_portal_user_has_financial($user_id) {
    $u = get_user_by('id', (int)$user_id);
    if (!$u) return false;

    // Admin sempre pode ver
    if (in_array('administrator', (array)$u->roles, true)) return true;

    // Whitelist opcional por login (ex.: Israel)
    $whitelist = ['israel', 'israelteste', 'israel.magma'];
    if (in_array($u->user_login, $whitelist, true)) return true;

    // Padrão: respeita o checkbox
    return get_user_meta($u->ID, 'tec_show_financial', true) === 'yes';
  }
}

/* ==== TRADEEXPANSION • FINANCEIRO REMOTO (STUB) ==== */
// Define TECE_FIN_URL em wp-config.php ou use a opção 'tece_fin_url'
if (!defined('TECE_FIN_URL')) {
  // define('TECE_FIN_URL', 'https://script.google.com/macros/s/SEU-APPS-SCRIPT/exec'); // exemplo
}

function tec_finance_get_remote($uid) {
  $cache_key = 'tec_fin_json_' . (int)$uid;
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
      wp_redirect( get_permalink($p->ID) );
      exit;
    }
  }
});
// Export routes (HTML-to-PDF friendly previews)
add_filter('template_include', function ($template) {
    $export = get_query_var('tec_export');
    if (!$export) return $template;

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
        $export_template = get_template_directory().'/client-portal/export/relatorio-inspecao-pdf.php';
        if (file_exists($export_template)) return $export_template;
    }

    return $template;
}, 20);

if (!function_exists('tec_export_render_relatorio_pdf')) {
    function tec_export_render_relatorio_pdf($post_id) {
        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'tec_relatorio') {
            status_header(404);
            echo 'Relatório não encontrado.'; return;
        }
        nocache_headers();

        $title   = get_the_title($post);
        $content = apply_filters('the_content', $post->post_content);

        $cliente_id   = (int) get_post_meta($post_id, 'tec_cliente_id', true);
        $cliente_name = $cliente_id ? tec_portal_get_client_name($cliente_id) : '—';
        $status       = get_post_meta($post_id, 'tec_status', true) ?: 'pendente';
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
                @page { size: A4; margin: 16mm 14mm 18mm 14mm; }
                body { font:12pt/1.45 Georgia,"Times New Roman",serif; color:#102724; }
                h1{font-size:22pt;margin:0 0 8px}
                .meta{display:flex;gap:12px;justify-content:space-between;padding:10px 12px;background:#f7f8f7;border:1px solid #e0e4e2;border-radius:6px;margin:10px 0 18px}
                .wp-block-table table{width:100%;border-collapse:collapse}
                .wp-block-table th,.wp-block-table td{border:1px solid #e0e4e2;padding:6px 8px}
                .wp-block-columns{display:flex;gap:14px;margin:10px 0 16px}
                .wp-block-column{flex:1}
                figure.wp-block-image{margin:0}
                figure.wp-block-image img{max-width:100%;height:auto;display:block}
                .no-print{margin-bottom:8px;text-align:right}
                .btn{display:inline-block;padding:8px 12px;border:1px solid #102724;border-radius:6px;text-decoration:none;color:#102724}
                @media print{.no-print{display:none} a[href]:after{content:""}}
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
            <?php if (!empty($_GET['download'])): ?><script>window.print()</script><?php endif; ?>
        </body>
        </html>
        <?php
    }
}

// Robots noindex para o Dashboard (template, slug ou rota do portal)
add_action('wp_head', function () {
  static $te_noindex_done = false;
  if ($te_noindex_done) return;

  $is_portal_template = is_page_template('page-portal-dashboard.php');
  $is_portal_slug     = is_page('dashboard-portal'); // ajuste se o slug for outro
  $is_portal_route    = (get_query_var('tec_portal') === 'dashboard');

  if ($is_portal_template || $is_portal_slug || $is_portal_route) {
    echo "<meta name=\"robots\" content=\"noindex, nofollow\">\n";
    $te_noindex_done = true;
  }
}, 1);

/* ==== /CLIENT PORTAL EXPORT ==== */

/* ==== FRONT-END FORM • RELATÓRIO (SHORTCODE) ==== */

/** Upload front-end e retorno do ID do anexo. */
function te_handle_front_upload($file, $post_id) {
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';

  $overrides = ['test_form' => false];
  $uploaded  = wp_handle_upload($file, $overrides);

  if (isset($uploaded['error'])) return 0;

  $filetype   = wp_check_filetype($uploaded['file'], null);
  $attachment = [
    'post_mime_type' => $filetype['type'],
    'post_title'     => sanitize_file_name(basename($uploaded['file'])),
    'post_content'   => '',
    'post_status'    => 'inherit'
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
function te_build_relatorio_blocks($title, $resumo, $data = [], $bundles = []) {
  $title  = esc_html($title);
  $resumo = esc_html($resumo);

  $cliente_id   = !empty($data['tec_cliente_id']) ? (int)$data['tec_cliente_id'] : 0;
  $cliente_name = $cliente_id ? tec_portal_get_client_name($cliente_id) : '—';

  $status_val = !empty($data['tec_status']) ? sanitize_text_field($data['tec_status']) : 'pendente';
  $status_map = ['aprovado' => 'Aprovado', 'pendente' => 'Pendente', 'reprovado' => 'Reprovado'];
  $status     = isset($status_map[$status_val]) ? $status_map[$status_val] : ucfirst($status_val);

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
    $desc  = esc_html($b['descricao'] ?? '');
    $acab  = esc_html($b['acabamento'] ?? '');
    $qtd   = isset($b['quant']) ? (int)$b['quant'] : 0;
    $c     = isset($b['comp']) ? (float)$b['comp'] : 0;
    $h     = isset($b['altura']) ? (float)$b['altura'] : 0;
    $esp   = isset($b['esp']) ? (float)$b['esp'] : 0;
    $m2    = isset($b['m2']) ? (float)$b['m2'] : round($c * $h * max($qtd,1), 2);

    $img = '';
    if (!empty($b['attachment_id'])) {
      $url = wp_get_attachment_image_url((int)$b['attachment_id'], 'large');
      if ($url) {
        $alt = get_post_meta((int)$b['attachment_id'], '_wp_attachment_image_alt', true);
        $img = '<figure class="wp-block-image size-large"><img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/></figure>';
      }
    }

    $table = '
    <!-- wp:table -->
    <figure class="wp-block-table"><table><thead><tr>
      <th>IDENT.</th><th>QUANT.</th><th>DESCRIPTION</th><th>FINISH</th><th>DIMENSIONS (m)</th><th>TOTAL (m²)</th>
    </tr></thead><tbody><tr>
      <td>'.$ident.'</td>
      <td>'.$qtd.'</td>
      <td>'.$desc.'</td>
      <td>'.$acab.'</td>
      <td>comp '.$c.' × alt '.$h.' × esp '.$esp.'cm</td>
      <td>'.number_format($m2,2,',','.').'</td>
    </tr></tbody></table></figure>
    <!-- /wp:table -->';

    $content .= '
    <!-- wp:columns -->
    <div class="wp-block-columns">
      <!-- wp:column {"width":"65%"} -->
      <div class="wp-block-column" style="flex-basis:65%">'.$table.'</div>
      <!-- /wp:column -->
      <!-- wp:column {"width":"35%"} -->
      <div class="wp-block-column" style="flex-basis:35%">'.$img.'</div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->';
  }

  return $content;
}
/** Shortcode [te_relatorio_form] – cria Relatório pelo front-end (Admin/Editor). */
add_shortcode('te_relatorio_form', function($atts){
  if (!is_user_logged_in() || !current_user_can('edit_posts')) {
    return '<p>Acesso restrito.</p>';
  }

  $notice = '';
  if (isset($_POST['te_relatorio_nonce']) && wp_verify_nonce($_POST['te_relatorio_nonce'], 'te_relatorio_form')) {
    $title       = sanitize_text_field($_POST['te_title'] ?? '');
    $resumo      = sanitize_textarea_field($_POST['te_resumo'] ?? '');
    $cliente_id  = isset($_POST['tec_cliente_id']) ? (int) $_POST['tec_cliente_id'] : 0;
    $status_meta = sanitize_text_field($_POST['tec_status'] ?? 'pendente');

    // Normaliza bundles (dados)
    $bundles = [];
    if (!empty($_POST['bundles']) && is_array($_POST['bundles'])) {
      $rows = array_values($_POST['bundles']);
      foreach ($rows as $i => $row) {
        $bundles[$i] = [
          'ident'      => sanitize_text_field($row['ident'] ?? ''),
          'descricao'  => sanitize_text_field($row['descricao'] ?? ''),
          'acabamento' => sanitize_text_field($row['acabamento'] ?? ''),
          'quant'      => isset($row['quant']) ? (int)$row['quant'] : 0,
          'comp'       => isset($row['comp']) ? (float) str_replace(',', '.', $row['comp']) : 0,
          'altura'     => isset($row['altura']) ? (float) str_replace(',', '.', $row['altura']) : 0,
          'esp'        => isset($row['esp']) ? (float) str_replace(',', '.', $row['esp']) : 0,
          'obs'        => sanitize_text_field($row['obs'] ?? ''),
        ];
      }
    }


    // Cria o post
    $post_id = wp_insert_post([
      'post_type'   => 'tec_relatorio',
      'post_status' => 'publish',
      'post_title'  => $title ? $title : 'Relatório',
      'post_content'=> '',
    ], true);

    if (!is_wp_error($post_id)) {
      if ($cliente_id) update_post_meta($post_id, 'tec_cliente_id', $cliente_id);
      update_post_meta($post_id, 'tec_status', $status_meta);

      // Fotos de cada bundle (bundle_photo[])
      if (!empty($_FILES['bundle_photo']['name']) && is_array($_FILES['bundle_photo']['name'])) {
        $names = $_FILES['bundle_photo']['name'];
        for ($i=0; $i<count($names); $i++) {
          if (!empty($names[$i])) {
            $file = [
              'name'     => $_FILES['bundle_photo']['name'][$i],
              'type'     => $_FILES['bundle_photo']['type'][$i],
              'tmp_name' => $_FILES['bundle_photo']['tmp_name'][$i],
              'error'    => $_FILES['bundle_photo']['error'][$i],
              'size'     => $_FILES['bundle_photo']['size'][$i],
            ];
            $att_id = te_handle_front_upload($file, $post_id);
            if ($att_id) {
              $bundles[$i]['attachment_id'] = $att_id;
              if (!empty($bundles[$i]['descricao'])) {
                tec_portal_assign_material_term($att_id, $bundles[$i]['descricao']);
              }
              if (!empty($bundles[$i]['obs'])) {
                update_post_meta($att_id, 'tec_obs', $bundles[$i]['obs']);
              }
            }
          }
        }
      }

      // Salva JSON compatível com o cálculo de m² (colunas C,H,Qtd)
      $json_rows = [];
      foreach ($bundles as $b) {
        $json_rows[] = [
          'ident'      => $b['ident'] ?? '',
          'descricao'  => $b['descricao'] ?? '',
          'acabamento' => $b['acabamento'] ?? '',
          'Qtd'        => isset($b['quant']) ? (int)$b['quant'] : 0,
          'C'          => isset($b['comp']) ? (float)$b['comp'] : 0,
          'H'          => isset($b['altura']) ? (float)$b['altura'] : 0,
          'esp'        => isset($b['esp']) ? (float)$b['esp'] : 0,
          'm2'         => isset($b['comp'], $b['altura'], $b['quant']) ? round($b['comp']*$b['altura']*max(1,(int)$b['quant']), 2) : 0,
          'attachment' => isset($b['attachment_id']) ? (int)$b['attachment_id'] : 0,
          'obs'        => $b['obs'] ?? '',
        ];
      }
      update_post_meta($post_id, 'tec_slabs_json', wp_json_encode($json_rows));

      // Monta o conteúdo com tabela + foto por bundle
      $content = te_build_relatorio_blocks($title, $resumo, $_POST, $bundles);
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
  if (!is_singular()) return;
  global $post;
  $has_short = ($post && has_shortcode($post->post_content ?? '', 'te_relatorio_form'));
  $is_novo_relatorio = function_exists('get_queried_object') && is_page() && (get_post_field('post_name', get_queried_object_id()) === 'novo-relatorio');
  if (!$has_short && !$is_novo_relatorio) return;
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
      color: #102724 !important;                   /* verde escuro */
      -webkit-text-fill-color:  #9AA3A1 !important; /* Safari/autofill */
      background-color:rgb(255, 255, 255) !important;        /* fundo branco */
      caret-color: #102724 !important;
    }

    /* Placeholder com contraste melhor */
    body .te-relatorio-form input::placeholder,
    body .te-relatorio-form textarea::placeholder,
    body.page-novo-relatorio form input::placeholder,
    body.page-novo-relatorio form textarea::placeholder {
      color:  #9AA3A1 !important;
      opacity: 2 !important; /* Safari */
    }
    
    body .te-relatorio-form input::-webkit-input-placeholder,
    body .te-relatorio-form textarea::-webkit-input-placeholder,
    body.page-novo-relatorio form input::-webkit-input-placeholder,
    body.page-novo-relatorio form textarea::-webkit-input-placeholder { color: #9AA3A1 !important; }
    body .te-relatorio-form input::-moz-placeholder,
    body .te-relatorio-form textarea::-moz-placeholder,
    body.page-novo-relatorio form input::-moz-placeholder,
    body.page-novo-relatorio form textarea::-moz-placeholder { color:  #9AA3A1 !important; }
    body .te-relatorio-form input:-ms-input-placeholder,
    body .te-relatorio-form textarea:-ms-input-placeholder,
    body.page-novo-relatorio form input:-ms-input-placeholder,
    body.page-novo-relatorio form textarea:-ms-input-placeholder { color: #9AA3A1 !important; }    
    body .te-relatorio-form input::-ms-input-placeholder,
    body .te-relatorio-form textarea::-ms-input-placeholder,
    body.page-novo-relatorio form input::-ms-input-placeholder,
    body.page-novo-relatorio form textarea::-ms-input-placeholder { color: #9AA3A1 !important; }
    
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
      box-shadow: 0 0 0 3px rgba(16,39,36,0.20);
    }
  </style>
  <?php
});

// Monta a URL do PDF do relatório
function tec_relatorio_pdf_url($post_id, $auto_print = false) {
    $args = ['tec_export'=>'relatorio','tec_export_post'=>(int)$post_id];
    if ($auto_print) $args['download']=1;
    return add_query_arg($args, home_url('/'));
}

// Shortcode rápido: [te_relatorio_pdf id="123" text="Baixar PDF" auto="yes|no"]
add_shortcode('te_relatorio_pdf', function($atts){
    $a = shortcode_atts(['id'=>0,'text'=>'Baixar PDF','auto'=>'no'],$atts);
    $id = (int)$a['id']; if ($id<=0) return '';
    $url = esc_url(tec_relatorio_pdf_url($id, $a['auto']==='yes'));
    return '<a class="btn" href="'.$url.'" target="_blank" rel="noopener">'.esc_html($a['text']).'</a>';
});

// === FINANCEIRO (Google Sheets via Apps Script) =============================

// 2.1) Informe a URL do Apps Script (a que termina com /exec)
if (!defined('TECE_FIN_URL')) {
  define('TECE_FIN_URL', 'https://script.google.com/macros/s/COLE_AQUI_SUA_URL/exec');
}

// 2.2) Quem pode ver a aba "Financeiro" no portal?

// 2.3) Buscar dados no Apps Script e normalizar para o dashboard
if (!function_exists('te_client_portal_fetch_financial_data')) {
  function te_client_portal_fetch_financial_data($user_id) {
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
    $url  = TECE_FIN_URL . '?client=' . rawurlencode($user ? $user->user_login : 'anon');

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
      'pending' => (float)($json['summary']['pending'] ?? 0),
      'paid'    => (float)($json['summary']['paid'] ?? 0),
    ];

    $entries = [];
    if (!empty($json['entries']) && is_array($json['entries'])) {
      foreach ($json['entries'] as $row) {
        $entries[] = [
          'description' => (string)($row['description'] ?? ''),
          'amount'      => (float)($row['amount'] ?? 0),
          'status'      => (string)($row['status'] ?? 'Pendente'),
          'due'         => (string)($row['due'] ?? ''),
          'open'        => (float)($row['open_balance'] ?? 0),
          'credit'      => (float)($row['credit_balance'] ?? 0),
          'documents'   => (string)($row['documents'] ?? ''),
        ];
      }
    }

    return [
      'summary' => $summary,
      'entries' => $entries,
    ];
  }
}

/* ==== CLIENT PORTAL • SETTINGS PAGE ==== */
     