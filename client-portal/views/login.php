<?php get_header(); ?>

<?php
$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
?>

<main class="min-h-[80vh] flex items-center justify-center py-16 px-6 bg-gradient-to-br from-secondary to-primary">
  <div class="w-full max-w-4xl bg-custom1 text-secondary rounded-3xl shadow-2xl grid md:grid-cols-2 overflow-hidden">
    <div class="p-10 space-y-6">
      <div class="space-y-2">
        <p class="text-sm uppercase tracking-[0.3em] text-accent">Client Portal v1</p>
        <h1 class="text-3xl font-bold leading-tight">Bem-vindo à Área do Cliente Trade Expansion</h1>
        <p class="text-secondary/70">Acompanhe inspeções, relatórios e indicadores de forma segura em um único painel.</p>
      </div>

      <ul class="space-y-3 text-sm text-secondary/80">
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span>Relatórios técnicos com status atualizado.</span>
        </li>
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span>Galeria das últimas inspeções e registros fotográficos.</span>
        </li>
        <li class="flex items-start space-x-2">
          <span class="mt-1 h-2 w-2 rounded-full bg-accent"></span>
          <span>Visão financeira resumida com próximos vencimentos.</span>
        </li>
      </ul>

      <div class="text-xs uppercase tracking-wide text-secondary/60">
        Em breve: Projetos, Chat com a Petra e KPIs interativos.
      </div>
    </div>

    <div class="bg-white/80 p-10 backdrop-blur space-y-6">
      <div class="flex items-center justify-center">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo.png'); ?>" alt="Trade Expansion" class="h-12 w-auto">
      </div>
      <?php if ($status_message) : ?>
        <div class="mb-6 rounded-2xl border px-4 py-3 text-sm <?php echo $status_message['type'] === 'success' ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : ($status_message['type'] === 'warning' ? 'border-amber-300 bg-amber-50 text-amber-900' : 'border-rose-300 bg-rose-50 text-rose-900'); ?>">
          <?php echo esc_html($status_message['text']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-5">
        <input type="hidden" name="action" value="te_client_login">
        <?php wp_nonce_field('te_client_login', 'te_client_nonce'); ?>

        <div>
          <label for="username" class="block text-sm font-semibold text-secondary mb-1">Usuário ou E-mail</label>
          <input type="text" id="username" name="username" required class="w-full border border-secondary/20 rounded-xl px-4 py-3 focus:ring-2 focus:ring-accent/70 focus:outline-none" placeholder="cliente@tradeexpansion.com">
        </div>

        <div>
          <label for="password" class="block text-sm font-semibold text-secondary mb-1">Senha</label>
          <input type="password" id="password" name="password" required class="w-full border border-secondary/20 rounded-xl px-4 py-3 focus:ring-2 focus:ring-accent/70 focus:outline-none" placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="remember" class="rounded border-secondary/30 text-accent focus:ring-accent">
            <span>Lembrar acesso neste dispositivo</span>
          </label>
          <span class="text-secondary/50">Esqueceu a senha? Contate o suporte.</span>
        </div>

        <button type="submit" class="w-full bg-secondary text-custom1 rounded-xl py-3 font-semibold hover:bg-secondary/90 transition">
          Entrar
        </button>
      </form>
    </div>
  </div>
</main>

<?php get_footer(); ?>
