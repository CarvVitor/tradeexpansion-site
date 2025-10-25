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