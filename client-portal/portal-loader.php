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

/**
 * Ensures PHP session exists for portal nonce storage.
 */
function te_client_portal_maybe_start_session() {
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
function te_client_portal_register_routes() {
  add_rewrite_rule('^' . TE_CLIENT_PORTAL_LOGIN_SLUG . '/?$', 'index.php?te_client_portal=login', 'top');
  add_rewrite_rule('^' . TE_CLIENT_PORTAL_DASHBOARD_SLUG . '/?$', 'index.php?te_client_portal=dashboard', 'top');
  add_rewrite_tag('%te_client_portal%', '([^&]+)');
}

/**
 * Flush rewrite rules on theme activation.
 */
function te_client_portal_after_switch() {
  te_client_portal_register_routes();
  flush_rewrite_rules();
}

/**
 * Adds the custom query var.
 */
function te_client_portal_query_vars($vars) {
  $vars[] = 'te_client_portal';
  return $vars;
}

/**
 * Registers the "cliente" role if it does not exist.
 */
function te_client_portal_register_role() {
  if (!get_role('cliente')) {
    add_role('cliente', __('Cliente', 'tradeexpansion'), ['read' => true]);
  }
}

/**
 * Template router.
 */
function te_client_portal_template_include($template) {
  $portal_view = get_query_var('te_client_portal');

  if (!$portal_view) {
    return $template;
  }

  $view_path = get_template_directory() . '/client-portal/views/' . $portal_view . '.php';

  if ($portal_view === 'dashboard' && !te_client_portal_user_can_access()) {
    te_client_portal_redirect_with_message('login', 'session_expired');
  }

  if (file_exists($view_path)) {
    return $view_path;
  }

  return $template;
}

/**
 * Checks if the logged user can see the dashboard.
 */
function te_client_portal_user_can_access() {
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
function te_client_portal_handle_login() {
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
function te_client_portal_handle_logout() {
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
function te_client_portal_user_is_allowed($user) {
  if (!$user || is_wp_error($user)) {
    return false;
  }

  $allowed_roles = ['cliente', 'administrator', 'editor'];
  return !empty(array_intersect($allowed_roles, (array) $user->roles));
}

/**
 * Stores the session nonce for the current user.
 */
function te_client_portal_set_session_nonce($user_id) {
  if (!session_id()) {
    session_start();
  }

  $_SESSION[TE_CLIENT_PORTAL_SESSION_KEY] = wp_create_nonce('te_client_session_' . $user_id);
}

/**
 * Clears the stored session nonce.
 */
function te_client_portal_clear_session() {
  if (isset($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY])) {
    unset($_SESSION[TE_CLIENT_PORTAL_SESSION_KEY]);
  }
}

/**
 * Helper to redirect with system messages.
 */
function te_client_portal_redirect_with_message($view, $code) {
  $slug = $view === 'dashboard' ? TE_CLIENT_PORTAL_DASHBOARD_SLUG : TE_CLIENT_PORTAL_LOGIN_SLUG;
  $url = add_query_arg('portal_status', $code, home_url('/' . $slug . '/'));
  wp_safe_redirect($url);
  exit;
}

/**
 * Placeholder for future reports integration.
 */
function te_client_portal_fetch_reports($user_id) {
  return [
    [
      'title' => 'Relatório de Inspeção - Lote 23',
      'date' => '2024-09-12',
      'status' => 'Aprovado',
      'url' => '#',
    ],
    [
      'title' => 'Auditoria de Qualidade - Agosto',
      'date' => '2024-08-28',
      'status' => 'Pendente',
      'url' => '#',
    ],
    [
      'title' => 'Checklist de Embarque - Container 08',
      'date' => '2024-08-02',
      'status' => 'Reprovado',
      'url' => '#',
    ],
  ];
}

/**
 * Placeholder for inspection gallery integration.
 */
function te_client_portal_fetch_inspections($user_id) {
  $base = get_template_directory_uri() . '/assets/images/inspections';
  return [
    [
      'image' => $base . '/inspection-1.jpg',
      'note' => 'Quartzito Azul Bahia – acabamento polido.'
    ],
    [
      'image' => $base . '/inspection-2.jpg',
      'note' => 'Granito Branco Ceará – verificação dimensional.'
    ],
    [
      'image' => $base . '/inspection-3.jpg',
      'note' => 'Controle de fissuras antes do embarque.'
    ],
    [
      'image' => $base . '/inspection-4.jpg',
      'note' => 'Teste de absorção de água – lote experimental.'
    ],
  ];
}

/**
 * Placeholder for financial data integration.
 */
function te_client_portal_fetch_financial_data($user_id) {
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
function te_client_portal_fetch_projects_placeholder() {
  return [
    'message' => __('Módulo de projetos/pedidos em desenvolvimento. Em breve será possível acompanhar etapas por material e cliente.', 'tradeexpansion'),
  ];
}

/**
 * Placeholder for chat integration.
 */
function te_client_portal_get_chat_placeholder() {
  return [
    'message' => __('Chat com a Petra (API Gemini) em breve. Prepare-se para tirar dúvidas em tempo real dentro do portal.', 'tradeexpansion'),
  ];
}

/**
 * Placeholder for KPI widgets.
 */
function te_client_portal_get_kpis_placeholder() {
  return [
    'message' => __('KPIs e gráficos com Chart.js em breve. O espaço já está reservado para métricas personalizadas.', 'tradeexpansion'),
  ];
}

/**
 * Maps status codes to human-readable alerts.
 */
function te_client_portal_get_status_message($code) {
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
  ];

  return $messages[$code] ?? null;
}
