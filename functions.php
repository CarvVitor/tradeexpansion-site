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