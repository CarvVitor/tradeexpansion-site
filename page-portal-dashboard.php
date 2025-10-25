<?php
/*
Template Name: Portal – Dashboard
Description: Página editável do Dashboard do Cliente (usa o portal existente).
*/

if ( ! defined('ABSPATH') ) exit;

// Se não estiver logado, manda pro login do portal
if ( ! is_user_logged_in() ) {
  wp_redirect( home_url('/area-do-cliente') );
  exit;
}

// Noindex (evita indexar área privada)
add_action('wp_head', function () {
  echo '<meta name="robots" content="noindex, nofollow">' . "\n";
});

// (Opcional) esconder admin bar para clientes
add_action('after_setup_theme', function () {
  $u = wp_get_current_user();
  if ( $u && in_array('cliente', (array) $u->roles, true) ) {
    show_admin_bar(false);
  }
});

// --- CONTEÚDO EDITÁVEL DA PÁGINA ---
// Você pode usar o editor do WP para um intro/aviso no topo do dashboard.
ob_start();
if ( have_posts() ) {
  while ( have_posts() ) { the_post(); }
  $intro = apply_filters('the_content', get_the_content(null, false, get_the_ID()));
} else {
  $intro = '';
}
$intro_html = trim($intro);

// Renderizamos o dashboard que já existe
// Dica: se quiser mostrar o $intro dentro do dashboard, podemos inserir no header-client.
$dashboard_view = get_template_directory() . '/client-portal/views/dashboard.php';

// Saída final
// Nota: não chamamos get_header()/get_footer() porque o dashboard já tem sua própria estrutura visual.
// Se quiser usar o cabeçalho/rodapé do tema principal, me avise que eu adapto.
if ( file_exists($dashboard_view) ) {
  // Exibe (opcional) intro acima do dashboard
  if ( $intro_html ) {
    echo '<section class="px-6 md:px-12 py-8 bg-primary/20 text-custom1"><div class="max-w-5xl mx-auto prose prose-invert">' . $intro_html . '</div></section>';
  }
  require $dashboard_view;
  exit;
}

// Fallback, caso o arquivo não exista (não deve ocorrer)
get_header();
echo '<main class="container mx-auto px-6 py-12"><h1>Dashboard</h1><p>Arquivo do portal não encontrado.</p></main>';
get_footer();