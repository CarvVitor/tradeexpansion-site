<?php get_header(); ?>

<?php
$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
$current_user = is_user_logged_in() ? wp_get_current_user() : null;
$already_logged = $current_user && te_client_portal_user_is_allowed($current_user);
?>

<main class="min-h-[80vh] flex items-center justify-center py-16 px-6 bg-gradient-to-br from-secondary to-primary">
  <div class="w-full max-w-4xl bg-custom1 text-secondary rounded-3xl shadow-2xl grid md:grid-cols-2 overflow-hidden">
    <div class="p-10 space-y-6">
      <div class="space-y-2">
        <p class="text-sm uppercase tracking-[0.3em] text-accent"><?php esc_html_e('Client Portal v1', 'tradeexpansion'); ?></p>
        <h1 class="text-3xl font-bold leading-tight"><?php esc_html_e('Bem-vindo à Área do Cliente Trade Expansion', 'tradeexpansion'); ?></h1>
        <p class="text-secondary/70"><?php esc_html_e('Acompanhe inspeções, relatórios e indicadores de forma segura em um único painel.', 'tradeexpansion'); ?></p>
      </div>

      <ul class="space-y-3 text-sm text-secondary/80">
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span><?php esc_html_e('Relatórios técnicos com status atualizado.', 'tradeexpansion'); ?></span>
        </li>
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span><?php esc_html_e('Galeria das últimas inspeções e registros fotográficos.', 'tradeexpansion'); ?></span>
        </li>
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span><?php esc_html_e('Visão financeira resumida com próximos vencimentos.', 'tradeexpansion'); ?></span>
        </li>
      </ul>

      <div class="text-xs uppercase tracking-wide text-secondary/60">
        <?php esc_html_e('Em breve: Projetos, Chat com a Petra e KPIs interativos.', 'tradeexpansion'); ?>
      </div>
    </div>

    <div class="bg-white/80 p-10 backdrop-blur space-y-6">
      <div class="flex items-center justify-center">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="<?php esc_attr_e('Trade Expansion', 'tradeexpansion'); ?>" class="h-12 w-auto">
      </div>
      <?php if ($status_message) : ?>
        <div class="mb-6 rounded-2xl border px-4 py-3 text-sm <?php echo $status_message['type'] === 'success' ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : ($status_message['type'] === 'warning' ? 'border-amber-300 bg-amber-50 text-amber-900' : 'border-rose-300 bg-rose-50 text-rose-900'); ?>">
          <?php echo esc_html($status_message['text']); ?>
        </div>
      <?php endif; ?>

      <?php if ($already_logged) : ?>
        <div class="space-y-4 rounded-2xl border border-secondary/10 bg-secondary/5 p-5 text-center">
          <p class="text-lg font-semibold text-secondary">
            <?php printf(esc_html__('Você já está autenticado como %s.', 'tradeexpansion'), esc_html($current_user->display_name ?: $current_user->user_login)); ?>
          </p>
          <div class="flex flex-col gap-3">
            <a href="<?php echo esc_url(home_url('/dashboard/')); ?>" class="w-full inline-flex justify-center items-center bg-secondary text-custom1 rounded-xl py-3 font-semibold hover:bg-secondary/90 transition">
              <?php esc_html_e('Ir para o dashboard', 'tradeexpansion'); ?>
            </a>
            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-2">
              <input type="hidden" name="action" value="te_client_logout">
              <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
              <button type="submit" class="w-full bg-accent/10 text-accent border border-accent/30 rounded-xl py-3 font-semibold hover:bg-accent hover:text-white transition">
                <?php esc_html_e('Fazer logout', 'tradeexpansion'); ?>
              </button>
            </form>
          </div>
        </div>
      <?php else : ?>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-5">
          <input type="hidden" name="action" value="te_client_login">
          <?php wp_nonce_field('te_client_login', 'te_client_nonce'); ?>

          <div>
            <label for="username" class="block text-sm font-semibold text-secondary mb-1"><?php esc_html_e('Usuário ou E-mail', 'tradeexpansion'); ?></label>
            <input type="text" id="username" name="username" required class="w-full border border-secondary/20 rounded-xl px-4 py-3 focus:ring-2 focus:ring-accent/70 focus:outline-none" placeholder="<?php esc_attr_e('cliente@tradeexpansion.com', 'tradeexpansion'); ?>">
          </div>

          <div>
            <label for="password" class="block text-sm font-semibold text-secondary mb-1"><?php esc_html_e('Senha', 'tradeexpansion'); ?></label>
            <input type="password" id="password" name="password" required class="w-full border border-secondary/20 rounded-xl px-4 py-3 focus:ring-2 focus:ring-accent/70 focus:outline-none" placeholder="••••••••">
          </div>

          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="remember" class="rounded border-secondary/30 text-accent focus:ring-accent">
              <span><?php esc_html_e('Lembrar acesso neste dispositivo', 'tradeexpansion'); ?></span>
            </label>
            <span class="text-secondary/50"><?php esc_html_e('Esqueceu a senha? Contate o suporte.', 'tradeexpansion'); ?></span>
          </div>

          <button type="submit" class="w-full bg-secondary text-custom1 rounded-xl py-3 font-semibold hover:bg-secondary/90 transition">
            <?php esc_html_e('Entrar', 'tradeexpansion'); ?>
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
