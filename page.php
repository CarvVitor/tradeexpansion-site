<?php get_header(); ?>

<main class="min-h-[60vh] py-16">
  <div class="max-w-5xl mx-auto px-6">
    <?php
    if (have_posts()):
      while (have_posts()): the_post();
        // Título padrão da página (opcional)
        echo '<h1 class="text-4xl font-bold mb-6">' . esc_html(get_the_title()) . '</h1>';

        // CONTEÚDO DA PÁGINA -> aqui o WP processa shortcodes
        the_content();

      endwhile;
    endif;
    ?>
  </div>
</main>

<?php get_footer(); ?>