<?php get_header(); ?>

<?php
$current_user = wp_get_current_user();
$reports = te_client_portal_fetch_reports($current_user->ID);
$inspections = te_client_portal_fetch_inspections($current_user->ID);
$financial = te_client_portal_fetch_financial_data($current_user->ID);
$projects_placeholder = te_client_portal_fetch_projects_placeholder();
$chat_placeholder = te_client_portal_get_chat_placeholder();
$kpi_placeholder = te_client_portal_get_kpis_placeholder();
$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
?>

<main class="bg-custom1 text-secondary min-h-[80vh] py-12">
  <div class="max-w-6xl mx-auto px-6 space-y-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div>
        <p class="text-sm uppercase tracking-[0.4em] text-accent">Dashboard</p>
        <h1 class="text-3xl font-bold mb-1">Olá, <?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?></h1>
        <p class="text-secondary/70">Aqui estão os últimos movimentos da sua operação com a Trade Expansion.</p>
      </div>
      <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="te_client_logout">
        <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
        <button type="submit" class="inline-flex items-center gap-2 bg-secondary text-custom1 px-5 py-2 rounded-xl hover:bg-secondary/90 transition">
          <span>Sair</span>
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V5m6 6a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </button>
      </form>
    </div>

    <?php if ($status_message) : ?>
      <div class="rounded-2xl border px-4 py-3 text-sm <?php echo $status_message['type'] === 'success' ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : ($status_message['type'] === 'warning' ? 'border-amber-300 bg-amber-50 text-amber-900' : 'border-rose-300 bg-rose-50 text-rose-900'); ?>">
        <?php echo esc_html($status_message['text']); ?>
      </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-xl p-6">
      <div class="flex flex-wrap items-center gap-3 border-b border-secondary/10 pb-4 mb-6">
        <button class="portal-tab portal-tab-active" data-tab-target="reports">Relatórios</button>
        <button class="portal-tab" data-tab-target="inspections">Inspeções</button>
        <button class="portal-tab" data-tab-target="financial">Financeiro</button>
      </div>

      <section data-tab-panel="reports" class="space-y-4">
        <?php foreach ($reports as $report) : ?>
          <article class="flex flex-col md:flex-row md:items-center justify-between gap-4 border border-secondary/10 rounded-2xl p-5">
            <div>
              <p class="text-sm uppercase tracking-wide text-secondary/60">Publicado em <?php echo esc_html(date_i18n('d M Y', strtotime($report['date']))); ?></p>
              <h3 class="text-xl font-semibold text-secondary"><?php echo esc_html($report['title']); ?></h3>
            </div>
            <div class="flex items-center gap-3">
              <?php
              $status_class = [
                'Aprovado' => 'bg-emerald-100 text-emerald-800',
                'Pendente' => 'bg-amber-100 text-amber-800',
                'Reprovado' => 'bg-rose-100 text-rose-800',
              ];
              $chip_class = isset($status_class[$report['status']]) ? $status_class[$report['status']] : 'bg-secondary text-custom1';
              ?>
              <span class="px-4 py-2 rounded-full text-sm font-medium <?php echo esc_attr($chip_class); ?>"><?php echo esc_html($report['status']); ?></span>
              <a href="<?php echo esc_url($report['url']); ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-secondary/30 text-secondary hover:bg-secondary hover:text-custom1 transition">
                Ver PDF
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 3h7m0 0v7m0-7L10 14"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 11v10h10"/></svg>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
        <p class="text-xs text-secondary/60 italic">Função fetchReports() pronta para integrar Airtable/Drive via API.</p>
      </section>

      <section data-tab-panel="inspections" class="space-y-5 hidden">
        <div class="grid md:grid-cols-2 gap-5">
          <?php foreach ($inspections as $inspection) : ?>
            <figure class="border border-secondary/10 rounded-2xl overflow-hidden bg-secondary/5">
              <img src="<?php echo esc_url($inspection['image']); ?>" alt="Registro de inspeção" class="w-full h-48 object-cover">
              <figcaption class="p-4 text-sm text-secondary/80"><?php echo esc_html($inspection['note']); ?></figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
        <p class="text-xs text-secondary/60 italic">fetchInspections() aguardando conexão com Google Drive / upload interno.</p>
      </section>

      <section data-tab-panel="financial" class="space-y-6 hidden">
        <div class="grid md:grid-cols-2 gap-4">
          <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
            <p class="text-sm uppercase tracking-wide text-rose-800">Saldo pendente</p>
            <p class="text-3xl font-bold text-rose-900">R$ <?php echo esc_html(number_format_i18n($financial['summary']['pending'], 2)); ?></p>
          </div>
          <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
            <p class="text-sm uppercase tracking-wide text-emerald-800">Total pago em 2024</p>
            <p class="text-3xl font-bold text-emerald-900">R$ <?php echo esc_html(number_format_i18n($financial['summary']['paid'], 2)); ?></p>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="text-left text-secondary/60">
                <th class="pb-2">Descrição</th>
                <th class="pb-2">Valor</th>
                <th class="pb-2">Status</th>
                <th class="pb-2">Vencimento</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-secondary/10">
              <?php foreach ($financial['entries'] as $entry) : ?>
                <tr>
                  <td class="py-3 font-medium"><?php echo esc_html($entry['description']); ?></td>
                  <td class="py-3">R$ <?php echo esc_html(number_format_i18n($entry['amount'], 2)); ?></td>
                  <td class="py-3">
                    <?php
                    $finance_status = $entry['status'] === 'Pago' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800';
                    ?>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo esc_attr($finance_status); ?>"><?php echo esc_html($entry['status']); ?></span>
                  </td>
                  <td class="py-3"><?php echo esc_html(date_i18n('d/m/Y', strtotime($entry['due']))); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="text-xs text-secondary/60 italic">fetchFinancialData() preparado para Google Sheets API.</p>
      </section>
    </div>

    <section class="grid md:grid-cols-3 gap-4">
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2">Projetos</p>
        <h2 class="text-xl font-semibold mb-2">Pedidos e materiais</h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($projects_placeholder['message']); ?></p>
      </article>
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2">Chat Petra</p>
        <h2 class="text-xl font-semibold mb-2">Gemini AI</h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($chat_placeholder['message']); ?></p>
      </article>
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2">KPIs</p>
        <h2 class="text-xl font-semibold mb-2">Visão estratégica</h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($kpi_placeholder['message']); ?></p>
      </article>
    </section>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.portal-tab');
    const panels = document.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.getAttribute('data-tab-target');

        tabButtons.forEach(b => b.classList.remove('portal-tab-active'));
        btn.classList.add('portal-tab-active');

        panels.forEach(panel => {
          panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== target);
        });
      });
    });
  });
</script>

<style>
  .portal-tab {
    padding: 0.5rem 1.5rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid rgba(16, 39, 36, 0.2);
    color: rgba(16, 39, 36, 0.7);
    transition: all 0.2s ease;
  }
  .portal-tab-active {
    background-color: #102724;
    color: #F1F1D9;
    border-color: #102724;
  }
</style>

<?php get_footer(); ?>
