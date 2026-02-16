<?php
if (!defined('ABSPATH')) {
  exit;
}

if (!defined('TE_CLIENT_PORTAL_LOGIN_SLUG')) {
  define('TE_CLIENT_PORTAL_LOGIN_SLUG', 'area-do-cliente');
}

if (!defined('TE_CLIENT_PORTAL_DASHBOARD_SLUG')) {
  define('TE_CLIENT_PORTAL_DASHBOARD_SLUG', 'dashboard');
}

if (!defined('TE_CLIENT_PORTAL_SESSION_KEY')) {
  define('TE_CLIENT_PORTAL_SESSION_KEY', 'te_client_session_nonce');
}

/**
 * Bootstraps the client portal features.
 */
add_action('init', 'te_client_portal_maybe_start_session', 1);
add_action('init', 'te_client_portal_register_routes');
add_filter('query_vars', 'te_client_portal_query_vars');
add_filter('template_include', 'te_client_portal_template_include');
add_action('after_switch_theme', 'te_client_portal_after_switch');
add_action('after_switch_theme', 'te_client_portal_register_role');

// Authentication handlers.
add_action('admin_post_nopriv_te_client_login', 'te_client_portal_handle_login');
add_action('admin_post_te_client_login', 'te_client_portal_handle_login');
add_action('admin_post_te_client_logout', 'te_client_portal_handle_logout');
add_action('admin_post_te_portal_submit_report', 'te_client_portal_handle_report_submission');
add_action('admin_post_te_client_proxy', 'te_client_portal_handle_proxy');
add_action('admin_post_nopriv_te_client_proxy', 'te_client_portal_handle_proxy'); // Optional: security check inside

/**
 * Ensures PHP session exists for portal nonce storage.
 */
function te_client_portal_maybe_start_session()
{
  if (php_sapi_name() === 'cli') {
    return;
  }

  if (!session_id()) {
    session_start();
  }
}

/**
 * Registers rewrite rules for /area-do-cliente and /dashboard.
 */
function te_client_portal_register_routes()
{
  add_rewrite_rule('^' . TE_CLIENT_PORTAL_LOGIN_SLUG . '/?$', 'index.php?te_client_portal=login', 'top');
  add_rewrite_rule('^' . TE_CLIENT_PORTAL_DASHBOARD_SLUG . '/?$', 'index.php?te_client_portal=dashboard', 'top');
  add_rewrite_tag('%te_client_portal%', '([^&]+)');
}

/**
 * Flush rewrite rules on theme activation.
 */
function te_client_portal_after_switch()
{
  te_client_portal_register_routes();
  flush_rewrite_rules();
}

/**
 * Adds the custom query var.
 */
function te_client_portal_query_vars($vars)
{
  $vars[] = 'te_client_portal';
  return $vars;
}

/**
 * Registers the "cliente" role if it does not exist.
 */
function te_client_portal_register_role()
{
  if (!get_role('cliente')) {
    add_role('cliente', __('Cliente', 'tradeexpansion'), ['read' => true]);
  }
}

/**
 * Template router.
 */
function te_client_portal_template_include($template)
{
  $portal_view = get_query_var('te_client_portal');

  if (!$portal_view) {
    return $template;
  }

  // Check if user has a specific view assigned
  if ($portal_view === 'dashboard' && is_user_logged_in()) {
    $user_id = get_current_user_id();
    $assigned_view = get_user_meta($user_id, 'te_portal_assigned_view', true);
    if ($assigned_view) {
      $specific_view_path = get_template_directory() . '/client-portal/views/' . $assigned_view . '.php';
      if (file_exists($specific_view_path)) {
        return $specific_view_path;
      }
    }
  }

  // For the dashboard route, use the page template wrapper (with get_header/get_footer/loader)
  // instead of loading views/dashboard.php directly without any layout.
  if ($portal_view === 'dashboard') {
    if (!is_user_logged_in()) {
      wp_redirect(home_url('/' . TE_CLIENT_PORTAL_LOGIN_SLUG . '/'));
      exit;
    }
    $page_template = get_template_directory() . '/page-portal-dashboard.php';
    if (file_exists($page_template)) {
      return $page_template;
    }
  }

  $view_path = get_template_directory() . '/client-portal/views/' . $portal_view . '.php';

  if (file_exists($view_path)) {
    return $view_path;
  }

  return $template;
}

/**
 * Gets a client-specific setting from user meta with an optional default.
 */
function te_client_portal_get_setting($user_id, $key, $default = '')
{
  $value = get_user_meta($user_id, 'te_portal_' . $key, true);
  return $value ? $value : $default;
}

/**
 * Checks if the logged user can see the dashboard.
 */
function te_client_portal_user_can_access()
{
  if (!is_user_logged_in()) {
    return false;
  }

  $user = wp_get_current_user();
  if (!te_client_portal_user_is_allowed($user)) {
    return false;
  }

  if (empty($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY])) {
    return false;
  }

  $nonce = sanitize_text_field(wp_unslash($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY]));
  return (bool) wp_verify_nonce($nonce, 'te_client_session_' . $user->ID);
}

/**
 * Handles the login submission.
 */
function te_client_portal_handle_login()
{
  if (!isset($_POST['te_client_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['te_client_nonce'])), 'te_client_login')) {
    te_client_portal_redirect_with_message('login', 'invalid_nonce');
  }

  $username = isset($_POST['username']) ? sanitize_text_field(wp_unslash($_POST['username'])) : '';
  $password = isset($_POST['password']) ? wp_unslash($_POST['password']) : '';
  $remember = !empty($_POST['remember']);

  $credentials = [
    'user_login' => $username,
    'user_password' => $password,
    'remember' => $remember,
  ];

  $user = wp_signon($credentials, false);

  if (is_wp_error($user)) {
    te_client_portal_redirect_with_message('login', 'invalid_credentials');
  }

  if (!te_client_portal_user_is_allowed($user)) {
    wp_logout();
    te_client_portal_redirect_with_message('login', 'unauthorized');
  }

  te_client_portal_set_session_nonce($user->ID);
  wp_safe_redirect(home_url('/' . TE_CLIENT_PORTAL_DASHBOARD_SLUG . '/'));
  exit;
}

/**
 * Handles logout requests.
 */
function te_client_portal_handle_logout()
{
  if (!isset($_POST['te_client_logout_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['te_client_logout_nonce'])), 'te_client_logout')) {
    te_client_portal_redirect_with_message('dashboard', 'invalid_nonce');
  }

  te_client_portal_clear_session();
  wp_logout();
  te_client_portal_redirect_with_message('login', 'logged_out');
}

/**
 * Determines whether a user belongs to the allowed roles.
 */
function te_client_portal_user_is_allowed($user)
{
  if (!$user || is_wp_error($user)) {
    return false;
  }

  $allowed_roles = ['cliente', 'administrator', 'editor'];
  return !empty(array_intersect($allowed_roles, (array) $user->roles));
}

/**
 * Stores the session nonce for the current user.
 */
function te_client_portal_set_session_nonce($user_id)
{
  if (!session_id()) {
    session_start();
  }

  $_SESSION[TE_CLIENT_PORTAL_SESSION_KEY] = wp_create_nonce('te_client_session_' . $user_id);
}

/**
 * Clears the stored session nonce.
 */
function te_client_portal_clear_session()
{
  if (isset($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY])) {
    unset($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY]);
  }
}

/**
 * Handles proxy requests to App Script.
 */
function te_client_portal_handle_proxy()
{
  if (!is_user_logged_in() && !current_user_can('manage_options')) {
    wp_send_json_error('Unauthorized', 401);
  }

  $user_id = get_current_user_id();
  $apps_script_url = te_client_portal_get_setting($user_id, 'apps_script_url');

  if (!$apps_script_url) {
    // If not set for user, check if we have a default or if it's coming from POST (for admin)
    $apps_script_url = isset($_POST['apps_script_url']) ? esc_url_raw($_POST['apps_script_url']) : '';
  }

  if (!$apps_script_url) {
    wp_send_json_error('No App Script URL configured', 400);
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $apps_script_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = $_POST;
    unset($post_data['action']); // Remove WP action
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
  }

  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  header('Content-Type: application/json');
  if ($http_code !== 200) {
    http_response_code($http_code);
  }
  echo $response;
  exit;
}

/**
 * Helper to redirect with system messages.
 */
function te_client_portal_redirect_with_message($view, $code)
{
  $slug = $view === 'dashboard' ? TE_CLIENT_PORTAL_DASHBOARD_SLUG : TE_CLIENT_PORTAL_LOGIN_SLUG;
  $url = add_query_arg('portal_status', $code, home_url('/' . $slug . '/'));
  wp_safe_redirect($url);
  exit;
}

/**
 * Handles the submission of new reports from the front-end form.
 */
function te_client_portal_handle_report_submission()
{
  if (!is_user_logged_in()) {
    te_client_portal_redirect_with_message('login', 'session_expired');
  }

  if (!isset($_POST['te_portal_report_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['te_portal_report_nonce'])), 'te_portal_report')) {
    te_client_portal_redirect_with_message('dashboard', 'invalid_nonce');
  }

  $current_user = wp_get_current_user();
  if (!$current_user || !te_client_portal_user_is_allowed($current_user)) {
    te_client_portal_redirect_with_message('dashboard', 'unauthorized');
  }

  $title = isset($_POST['report_title']) ? sanitize_text_field(wp_unslash($_POST['report_title'])) : '';
  $summary = isset($_POST['report_summary']) ? wp_kses_post(wp_unslash($_POST['report_summary'])) : '';
  $body = isset($_POST['report_content']) ? wp_kses_post(wp_unslash($_POST['report_content'])) : '';

  if ('' === $title || '' === trim(wp_strip_all_tags($body))) {
    te_client_portal_redirect_with_message('dashboard', 'report_missing_fields');
  }

  $status_slug = isset($_POST['report_status']) ? sanitize_text_field(wp_unslash($_POST['report_status'])) : 'pendente';
  $allowed_statuses = array_keys(te_client_portal_get_report_status_options());
  if (!in_array($status_slug, $allowed_statuses, true)) {
    $status_slug = 'pendente';
  }

  $report_date_input = isset($_POST['report_date']) ? sanitize_text_field(wp_unslash($_POST['report_date'])) : '';
  $report_date_label = te_client_portal_format_report_date_label($report_date_input);

  $client_id = $current_user->ID;
  if (current_user_can('edit_others_posts')) {
    $client_id = isset($_POST['report_client_id']) ? (int) $_POST['report_client_id'] : 0;
    if (!$client_id) {
      te_client_portal_redirect_with_message('dashboard', 'report_missing_client');
    }
    if (!te_client_portal_is_cliente_user($client_id)) {
      te_client_portal_redirect_with_message('dashboard', 'report_invalid_client');
    }
  }

  $pdf_url = '';
  if (!empty($_FILES['report_pdf_file']['name'])) {
    if (!current_user_can('upload_files')) {
      te_client_portal_redirect_with_message('dashboard', 'report_upload_error');
    }
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attachment_id = media_handle_upload('report_pdf_file', 0);
    if (is_wp_error($attachment_id)) {
      te_client_portal_redirect_with_message('dashboard', 'report_upload_error');
    }
    $pdf_url = wp_get_attachment_url($attachment_id);
  } elseif (!empty($_POST['report_pdf_url'])) {
    $pdf_url = esc_url_raw(wp_unslash($_POST['report_pdf_url']));
  }

  $client_name = te_client_portal_get_user_display_name($client_id);
  $status_label = te_client_portal_format_report_status($status_slug);
  $content = te_client_portal_build_report_content([
    'title' => $title,
    'summary' => $summary,
    'client_name' => $client_name,
    'status_label' => $status_label,
    'date_label' => $report_date_label,
    'body' => $body,
    'pdf_url' => $pdf_url,
  ]);

  $post_id = wp_insert_post([
    'post_type' => 'tec_relatorio',
    'post_status' => 'publish',
    'post_title' => $title,
    'post_content' => $content,
    'post_excerpt' => wp_strip_all_tags($summary),
    'post_author' => $current_user->ID,
  ], true);

  if (is_wp_error($post_id)) {
    te_client_portal_redirect_with_message('dashboard', 'report_save_error');
  }

  update_post_meta($post_id, 'tec_cliente_id', (int) $client_id);
  update_post_meta($post_id, 'tec_status', $status_slug);
  if ($pdf_url) {
    update_post_meta($post_id, 'tec_pdf_url', $pdf_url);
  }

  te_client_portal_redirect_with_message('dashboard', 'report_created');
}

function te_client_portal_is_cliente_user($user_id)
{
  $user = get_userdata($user_id);
  if (!$user) {
    return false;
  }
  return in_array('cliente', (array) $user->roles, true);
}

function te_client_portal_get_user_display_name($user_id)
{
  $user = get_userdata($user_id);
  if (!$user) {
    return '';
  }
  return $user->display_name ?: $user->user_login;
}

function te_client_portal_build_report_content($args)
{
  $defaults = [
    'title' => '',
    'summary' => '',
    'client_name' => '',
    'status_label' => '',
    'date_label' => '',
    'body' => '',
    'pdf_url' => '',
  ];
  $data = wp_parse_args($args, $defaults);

  $summary_html = $data['summary'] ? trim(wpautop($data['summary'])) : '<p>' . esc_html__('Resumo curto do relatório (2–3 linhas)...', 'tradeexpansion') . '</p>';
  $body_html = $data['body'] ? trim(wpautop($data['body'])) : '<p></p>';

  $cover_block = sprintf(
    '<!-- wp:cover {"dimRatio":40,"useFeaturedImage":true} -->
<div class="wp-block-cover is-light"><span aria-hidden="true" class="wp-block-cover__gradient-background has-background-dim"></span><div class="wp-block-cover__inner-container">
<!-- wp:heading {"level":1} -->
<h1>%s</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
%s
<!-- /wp:paragraph -->
</div></div>
<!-- /wp:cover -->',
    esc_html($data['title']),
    $summary_html
  );

  $spacer_24 = '<!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->';

  $group_block = sprintf(
    '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading {"level":3} -->
<h3>%s</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
  <li>%s</li>
  <li>%s</li>
  <li>%s</li>
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->',
    esc_html__('Dados principais', 'tradeexpansion'),
    sprintf(
      /* translators: %s: client name */
      esc_html__('Cliente: %s', 'tradeexpansion'),
      '<strong>' . esc_html($data['client_name']) . '</strong>'
    ),
    sprintf(
      /* translators: %s: report status */
      esc_html__('Status: %s', 'tradeexpansion'),
      '<strong>' . esc_html($data['status_label']) . '</strong>'
    ),
    sprintf(
      /* translators: %s: report date */
      esc_html__('Data: %s', 'tradeexpansion'),
      '<strong>' . esc_html($data['date_label']) . '</strong>'
    )
  );

  $spacer_12 = '<!-- wp:spacer {"height":"12px"} -->
<div style="height:12px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->';

  $content_block = sprintf(
    '<!-- wp:heading {"level":3} -->
<h3>%s</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
%s
<!-- /wp:paragraph -->',
    esc_html__('Conteúdo', 'tradeexpansion'),
    $body_html
  );

  $file_block = '';
  if (!empty($data['pdf_url'])) {
    $pdf_label = esc_html__('Arquivo PDF', 'tradeexpansion');
    $file_block = sprintf(
      '<!-- wp:file {"href":"%1$s"} -->
<div class="wp-block-file"><a href="%1$s">%2$s</a><a href="%1$s" class="wp-block-file__button" download>%3$s</a></div>
<!-- /wp:file -->',
      esc_url($data['pdf_url']),
      $pdf_label,
      esc_html__('Baixar', 'tradeexpansion')
    );
  }

  return implode(
    "\n\n",
    array_filter([
      $cover_block,
      $spacer_24,
      $group_block,
      $spacer_12,
      $content_block,
      $spacer_12,
      $file_block,
    ])
  );
}

function te_client_portal_format_report_date_label($raw_date)
{
  if (!$raw_date) {
    return date_i18n('d/m/Y');
  }

  $timestamp = strtotime($raw_date);
  if (!$timestamp) {
    return sanitize_text_field($raw_date);
  }

  return date_i18n('d/m/Y', $timestamp);
}

/**
 * Placeholder for future reports integration.
 */
function te_client_portal_fetch_reports($user_id)
{
  $reports = [];

  $query_args = [
    'post_type' => 'tec_relatorio',
    'post_status' => 'publish',
    'posts_per_page' => 20,
    'meta_query' => [
      [
        'key' => 'tec_cliente_id',
        'value' => (int) $user_id,
        'compare' => '=',
        'type' => 'NUMERIC',
      ],
    ],
    'orderby' => 'date',
    'order' => 'DESC',
    'no_found_rows' => true,
  ];

  $posts = get_posts($query_args);

  if ($posts) {
    foreach ($posts as $post) {
      $status_slug = get_post_meta($post->ID, 'tec_status', true) ?: 'pendente';
      $reports[] = [
        'post_id' => $post->ID,
        'title' => get_the_title($post),
        'date' => get_post_time('Y-m-d', false, $post, true),
        'status' => te_client_portal_format_report_status($status_slug),
        'status_slug' => $status_slug,
        'url' => get_post_meta($post->ID, 'tec_pdf_url', true) ?: get_permalink($post),
        'edit_link' => current_user_can('edit_post', $post->ID) ? get_edit_post_link($post->ID, '') : '',
        'excerpt' => has_excerpt($post) ? wp_strip_all_tags(get_the_excerpt($post), true) : '',
        'content' => $post->post_content,
        'note' => wp_strip_all_tags($post->post_content),
      ];
    }
  }

  if (empty($reports)) {
    $reports = [
      [
        'post_id' => 0,
        'title' => __('Relatório de Inspeção - Lote 23', 'tradeexpansion'),
        'date' => '2024-09-12',
        'status' => te_client_portal_format_report_status('aprovado'),
        'status_slug' => 'aprovado',
        'url' => '#',
        'edit_link' => '',
        'excerpt' => '',
        'content' => '',
        'note' => '',
      ],
      [
        'post_id' => 0,
        'title' => __('Auditoria de Qualidade - Agosto', 'tradeexpansion'),
        'date' => '2024-08-28',
        'status' => te_client_portal_format_report_status('pendente'),
        'status_slug' => 'pendente',
        'url' => '#',
        'edit_link' => '',
        'excerpt' => '',
        'content' => '',
        'note' => '',
      ],
      [
        'post_id' => 0,
        'title' => __('Checklist de Embarque - Container 08', 'tradeexpansion'),
        'date' => '2024-08-02',
        'status' => te_client_portal_format_report_status('reprovado'),
        'status_slug' => 'reprovado',
        'url' => '#',
        'edit_link' => '',
        'excerpt' => '',
        'content' => '',
        'note' => '',
      ],
    ];
  }

  return $reports;
}

/**
 * Placeholder for inspection gallery integration.
 */
function te_client_portal_fetch_inspections($user_id)
{
  $inspections = [];

  $query_args = [
    'post_type' => 'tec_inspecao',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => [
      [
        'key' => 'tec_cliente_id',
        'value' => (int) $user_id,
        'compare' => '=',
        'type' => 'NUMERIC',
      ],
    ],
    'orderby' => 'date',
    'order' => 'DESC',
    'no_found_rows' => true,
  ];

  $posts = get_posts($query_args);
  if ($posts) {
    foreach ($posts as $post) {
      $inspections[] = te_client_portal_prepare_inspection($post);
    }
  }

  if (empty($inspections)) {
    $base = get_template_directory_uri() . '/assets/images/inspections';
    $inspections[] = [
      'id' => 0,
      'title' => __('Inspeção demonstrativa', 'tradeexpansion'),
      'date' => current_time('Y-m-d'),
      'materials' => [
        [
          'name' => __('Granito Branco Ceará', 'tradeexpansion'),
          'term_id' => 0,
          'photos' => [
            [
              'attachment_id' => 0,
              'image' => $base . '/inspection-1.jpg',
              'note' => __('Acabamento polido e controle dimensional.', 'tradeexpansion'),
              'material' => __('Granito Branco Ceará', 'tradeexpansion'),
            ],
          ],
        ],
        [
          'name' => __('Quartzito Azul Bahia', 'tradeexpansion'),
          'term_id' => 0,
          'photos' => [
            [
              'attachment_id' => 0,
              'image' => $base . '/inspection-2.jpg',
              'note' => __('Verificação de fissuras e embalagem.', 'tradeexpansion'),
              'material' => __('Quartzito Azul Bahia', 'tradeexpansion'),
            ],
          ],
        ],
      ],
    ];
  }

  return $inspections;
}

function te_client_portal_prepare_inspection($post)
{
  $attachments = get_children([
    'post_parent' => $post->ID,
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'orderby' => 'menu_order ID',
    'order' => 'ASC',
  ]);

  $materials = [];

  if ($attachments) {
    foreach ($attachments as $attachment) {
      $material_info = te_client_portal_get_attachment_material($attachment->ID);
      $key = $material_info['name'] . '_' . $material_info['term_id'];
      if (!isset($materials[$key])) {
        $materials[$key] = [
          'name' => $material_info['name'],
          'term_id' => $material_info['term_id'],
          'photos' => [],
        ];
      }

      $materials[$key]['photos'][] = [
        'attachment_id' => $attachment->ID,
        'image' => wp_get_attachment_image_url($attachment->ID, 'large'),
        'note' => get_post_meta($attachment->ID, 'tec_obs', true),
        'material' => $material_info['name'],
      ];
    }
  }

  return [
    'id' => $post->ID,
    'title' => get_the_title($post),
    'date' => get_post_time('Y-m-d', false, $post, true),
    'materials' => array_values($materials),
  ];
}

function te_client_portal_get_attachment_material($attachment_id)
{
  $terms = wp_get_object_terms($attachment_id, 'tec_material', ['number' => 1]);
  if (!is_wp_error($terms) && !empty($terms)) {
    return [
      'term_id' => $terms[0]->term_id,
      'name' => $terms[0]->name,
    ];
  }

  return [
    'term_id' => 0,
    'name' => __('Sem material', 'tradeexpansion'),
  ];
}

/**
 * Placeholder for financial data integration.
 */
function te_client_portal_fetch_financial_data($user_id)
{
  $data = function_exists('tec_finance_get_remote') ? tec_finance_get_remote($user_id) : false;

  if ($data && isset($data['entries']) && is_array($data['entries'])) {
    // Normaliza status para manter consistência visual
    foreach ($data['entries'] as &$entry) {
      $entry['status'] = isset($entry['status']) ? ucfirst(strtolower($entry['status'])) : 'Pendente';
    }
    unset($entry);

    if (empty($data['summary']) && !empty($data['entries'])) {
      $pending = 0;
      $paid = 0;
      foreach ($data['entries'] as $entry) {
        $amount = isset($entry['amount']) ? (float) $entry['amount'] : 0;
        if (!empty($entry['status']) && strtolower($entry['status']) === 'pago') {
          $paid += $amount;
        } else {
          $pending += $amount;
        }
      }
      $data['summary'] = [
        'pending' => $pending,
        'paid' => $paid,
      ];
    }

    return $data;
  }

  return [
    'summary' => [
      'pending' => 42800.00,
      'paid' => 125600.00,
    ],
    'entries' => [
      [
        'description' => 'Pedido 2045 – Quartzito Patagonia',
        'amount' => 28600.00,
        'status' => 'Pendente',
        'due' => '2024-10-10',
      ],
      [
        'description' => 'Inspeção técnica – Mina Espírito Santo',
        'amount' => 3200.00,
        'status' => 'Pago',
        'due' => '2024-09-15',
      ],
      [
        'description' => 'Exportação – Container #TX-093',
        'amount' => 11000.00,
        'status' => 'Pago',
        'due' => '2024-08-22',
      ],
    ],
  ];
}

/**
 * Placeholder for future projects / orders module.
 */
function te_client_portal_fetch_projects_placeholder()
{
  return [
    'message' => __('Módulo de projetos/pedidos em desenvolvimento. Em breve será possível acompanhar etapas por material e cliente.', 'tradeexpansion'),
  ];
}

/**
 * Placeholder for chat integration.
 */
function te_client_portal_get_chat_placeholder()
{
  return [
    'message' => __('Chat com a Petra (API Gemini) em breve. Prepare-se para tirar dúvidas em tempo real dentro do portal.', 'tradeexpansion'),
  ];
}

/**
 * Placeholder for KPI widgets.
 */
function te_client_portal_get_kpis_placeholder()
{
  return [
    'message' => __('KPIs e gráficos com Chart.js em breve. O espaço já está reservado para métricas personalizadas.', 'tradeexpansion'),
  ];
}

/**
 * Helper to format report statuses.
 */
function te_client_portal_format_report_status($slug)
{
  $map = [
    'aprovado' => __('Aprovado', 'tradeexpansion'),
    'pendente' => __('Pendente', 'tradeexpansion'),
    'reprovado' => __('Reprovado', 'tradeexpansion'),
  ];

  $slug = strtolower((string) $slug);
  return $map[$slug] ?? ucfirst($slug);
}

function te_client_portal_get_report_status_options()
{
  return [
    'aprovado' => te_client_portal_format_report_status('aprovado'),
    'pendente' => te_client_portal_format_report_status('pendente'),
    'reprovado' => te_client_portal_format_report_status('reprovado'),
  ];
}

/**
 * Maps status codes to human-readable alerts.
 */
function te_client_portal_get_status_message($code)
{
  $messages = [
    'invalid_nonce' => [
      'type' => 'error',
      'text' => __('Não foi possível validar a sua solicitação. Tente novamente.', 'tradeexpansion'),
    ],
    'invalid_credentials' => [
      'type' => 'error',
      'text' => __('Usuário ou senha inválidos. Verifique os dados e tente novamente.', 'tradeexpansion'),
    ],
    'unauthorized' => [
      'type' => 'error',
      'text' => __('Seu usuário não possui acesso à Área do Cliente. Fale com nosso suporte.', 'tradeexpansion'),
    ],
    'session_expired' => [
      'type' => 'warning',
      'text' => __('Sua sessão expirou. Faça login novamente para continuar.', 'tradeexpansion'),
    ],
    'logged_out' => [
      'type' => 'success',
      'text' => __('Logout realizado com sucesso. Até breve!', 'tradeexpansion'),
    ],
    'report_created' => [
      'type' => 'success',
      'text' => __('Relatório enviado com sucesso! O conteúdo já está padronizado no editor.', 'tradeexpansion'),
    ],
    'report_missing_fields' => [
      'type' => 'error',
      'text' => __('Preencha título e conteúdo antes de enviar o relatório.', 'tradeexpansion'),
    ],
    'report_missing_client' => [
      'type' => 'error',
      'text' => __('Selecione o cliente que deve visualizar este relatório.', 'tradeexpansion'),
    ],
    'report_invalid_client' => [
      'type' => 'error',
      'text' => __('O cliente selecionado não é válido. Tente novamente.', 'tradeexpansion'),
    ],
    'report_upload_error' => [
      'type' => 'error',
      'text' => __('Não foi possível enviar o arquivo PDF. Verifique o formato e tente novamente.', 'tradeexpansion'),
    ],
    'report_save_error' => [
      'type' => 'error',
      'text' => __('Erro ao salvar o relatório. Atualize a página e tente outra vez.', 'tradeexpansion'),
    ],
  ];

  return $messages[$code] ?? null;
}
