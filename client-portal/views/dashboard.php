<?php get_header(); ?>

<?php
$current_user = wp_get_current_user();
$reports = te_client_portal_fetch_reports($current_user->ID);
$inspections = te_client_portal_fetch_inspections($current_user->ID);
$projects_placeholder = te_client_portal_fetch_projects_placeholder();
$chat_placeholder = te_client_portal_get_chat_placeholder();
$kpi_placeholder = te_client_portal_get_kpis_placeholder();
$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
$can_edit_reports = current_user_can('edit_posts');
$can_view_financial = function_exists('tec_portal_user_has_financial') ? tec_portal_user_has_financial(get_current_user_id()) : false;
$can_manage_inspections = current_user_can('upload_files');
if ($can_manage_inspections) {
  wp_enqueue_media();
}
$financial = $can_view_financial ? te_client_portal_fetch_financial_data($current_user->ID) : null;
$portal_tabs = [
  'reports' => __('Relatórios', 'tradeexpansion'),
  'inspections' => __('Inspeções', 'tradeexpansion'),
];
if ($can_view_financial) {
  $portal_tabs['financial'] = __('Financeiro', 'tradeexpansion');
}
$active_tab = key($portal_tabs);
$reports_rest_nonce = wp_create_nonce('wp_rest');
$reports_rest_url = esc_url(rest_url('te/v1/report/'));
$inspection_rest_nonce = wp_create_nonce('wp_rest');
$inspection_rest_url = esc_url(rest_url('te/v1/inspecao/'));
$material_terms = get_terms([
  'taxonomy' => 'tec_material',
  'hide_empty' => false,
]);
$material_options = [];
if (!is_wp_error($material_terms)) {
  foreach ($material_terms as $term) {
    $material_options[] = [
      'id' => $term->term_id,
      'name' => $term->name,
    ];
  }
}
?>

<main class="bg-custom1 text-secondary min-h-[80vh] py-12">
  <div class="max-w-6xl mx-auto px-6 space-y-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div>
        <p class="text-sm uppercase tracking-[0.4em] text-accent"><?php esc_html_e('Dashboard', 'tradeexpansion'); ?></p>
        <h1 class="text-3xl font-bold mb-1">
          <?php printf(esc_html__('Olá, %s', 'tradeexpansion'), esc_html($current_user->display_name ?: $current_user->user_login)); ?>
        </h1>
        <p class="text-secondary/70"><?php esc_html_e('Aqui estão os últimos movimentos da sua operação com a Trade Expansion.', 'tradeexpansion'); ?></p>
      </div>
      <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="te_client_logout">
        <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
        <button type="submit" class="inline-flex items-center gap-2 bg-secondary text-custom1 px-5 py-2 rounded-xl hover:bg-secondary/90 transition">
          <span><?php esc_html_e('Sair', 'tradeexpansion'); ?></span>
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V5m6 6a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </button>
      </form>
    </div>

    <?php if ($status_message) : ?>
      <div class="rounded-2xl border px-4 py-3 text-sm <?php echo $status_message['type'] === 'success' ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : ($status_message['type'] === 'warning' ? 'border-amber-300 bg-amber-50 text-amber-900' : 'border-rose-300 bg-rose-50 text-rose-900'); ?>">
        <?php echo esc_html($status_message['text']); ?>
      </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-xl p-6" data-report-rest="true" data-rest-url="<?php echo esc_attr($reports_rest_url); ?>" data-rest-nonce="<?php echo esc_attr($reports_rest_nonce); ?>">
      <div class="flex flex-wrap items-center gap-3 border-b border-secondary/10 pb-4 mb-6">
        <?php $is_first = true; ?>
        <?php foreach ($portal_tabs as $slug => $label) : ?>
          <button class="portal-tab <?php echo $is_first ? 'portal-tab-active' : ''; ?>" data-tab-target="<?php echo esc_attr($slug); ?>">
            <?php echo esc_html($label); ?>
          </button>
          <?php $is_first = false; ?>
        <?php endforeach; ?>
      </div>

      <section data-tab-panel="reports" class="space-y-4 <?php echo $active_tab === 'reports' ? '' : 'hidden'; ?>">
        <?php if (empty($reports)) : ?>
          <p class="text-sm text-secondary/70"><?php esc_html_e('Nenhum relatório cadastrado para este cliente até o momento.', 'tradeexpansion'); ?></p>
        <?php endif; ?>
        <?php foreach ($reports as $report) : ?>
          <article class="flex flex-col md:flex-row md:items-center justify-between gap-4 border border-secondary/10 rounded-2xl p-5">
            <div>
              <p class="text-sm uppercase tracking-wide text-secondary/60">
                <?php printf(esc_html__('Publicado em %s', 'tradeexpansion'), esc_html(date_i18n('d M Y', strtotime($report['date'])))); ?>
              </p>
              <h3 class="text-xl font-semibold text-secondary" data-report-title="<?php echo (int) ($report['post_id'] ?? 0); ?>"><?php echo esc_html($report['title']); ?></h3>
              <p class="text-sm text-secondary/70 mt-2 report-note" data-report-note="<?php echo (int) ($report['post_id'] ?? 0); ?>">
                <?php echo $report['note'] ? esc_html($report['note']) : esc_html__('Sem observações cadastradas.', 'tradeexpansion'); ?>
              </p>
            </div>
            <div class="flex items-center gap-3 flex-wrap justify-end">
              <?php
                $status_class = [
                  'aprovado' => 'bg-emerald-100 text-emerald-800',
                  'pendente' => 'bg-amber-100 text-amber-800',
                  'reprovado' => 'bg-rose-100 text-rose-800',
                ];
                $status_slug = isset($report['status_slug']) ? strtolower($report['status_slug']) : strtolower($report['status']);
                $chip_class  = $status_class[$status_slug] ?? 'bg-secondary text-custom1';
              ?>
              <span class="px-4 py-2 rounded-full text-sm font-medium <?php echo esc_attr($chip_class); ?>">
                <?php echo esc_html($report['status']); ?>
              </span>
              <?php if (!empty($report['post_id'])) : ?>
                <a class="btn" href="<?php echo esc_url( tec_relatorio_pdf_url( (int) $report['post_id'], true ) ); ?>" target="_blank" rel="noopener">
                  <?php esc_html_e('Baixar PDF', 'tradeexpansion'); ?>
                </a>
              <?php endif; ?>
              <?php if ($can_edit_reports && !empty($report['post_id'])) : ?>
                <button type="button" class="report-inline-edit-btn" data-report-id="<?php echo (int) $report['post_id']; ?>">
                  <?php esc_html_e('Editar', 'tradeexpansion'); ?>
                </button>
              <?php elseif (!empty($report['edit_link'])) : ?>
                <a href="<?php echo esc_url($report['edit_link']); ?>" class="report-edit-link">
                  <?php esc_html_e('Editar informações', 'tradeexpansion'); ?>
                </a>
              <?php endif; ?>
            </div>
            <?php if ($can_edit_reports && !empty($report['post_id'])) : ?>
              <div class="report-inline-editor hidden" id="report-editor-<?php echo (int) $report['post_id']; ?>">
                <label class="block text-sm font-semibold text-secondary mb-2" for="report-inline-title-<?php echo (int) $report['post_id']; ?>"><?php esc_html_e('Título', 'tradeexpansion'); ?></label>
                <input type="text" id="report-inline-title-<?php echo (int) $report['post_id']; ?>" class="report-inline-title" value="<?php echo esc_attr($report['title']); ?>">

                <label class="block text-sm font-semibold text-secondary mt-4 mb-2" for="report-inline-note-<?php echo (int) $report['post_id']; ?>"><?php esc_html_e('Nota / Observações', 'tradeexpansion'); ?></label>
                <textarea id="report-inline-note-<?php echo (int) $report['post_id']; ?>" rows="3" class="report-inline-note"><?php echo esc_textarea($report['content']); ?></textarea>

                <div class="report-inline-actions">
                  <button type="button" class="report-inline-save" data-report-id="<?php echo (int) $report['post_id']; ?>"><?php esc_html_e('Salvar', 'tradeexpansion'); ?></button>
                  <button type="button" class="report-inline-cancel" data-report-id="<?php echo (int) $report['post_id']; ?>"><?php esc_html_e('Cancelar', 'tradeexpansion'); ?></button>
                </div>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
        <p class="text-xs text-secondary/60 italic"><?php esc_html_e('Função fetchReports() pronta para integrar Airtable/Drive via API.', 'tradeexpansion'); ?></p>

        <?php if ($can_edit_reports) : ?>
          <div class="report-admin-tools">
          <div>
            <p class="report-admin-tools__eyebrow"><?php esc_html_e('Visão administrativa', 'tradeexpansion'); ?></p>
            <h4><?php esc_html_e('Personalize o que aparece para o cliente', 'tradeexpansion'); ?></h4>
            <p><?php esc_html_e('Use os botões ao lado para editar títulos, status e anexar PDFs diretamente do WordPress.', 'tradeexpansion'); ?></p>
          </div>
          <div class="report-admin-tools__actions">
            <a class="report-admin-tools__btn" href="<?php echo esc_url(admin_url('edit.php?post_type=tec_relatorio')); ?>" target="_blank" rel="noopener"><?php esc_html_e('Gerenciar relatórios', 'tradeexpansion'); ?></a>
            <a class="report-admin-tools__btn report-admin-tools__btn--primary" href="<?php echo esc_url(admin_url('post-new.php?post_type=tec_relatorio')); ?>" target="_blank" rel="noopener"><?php esc_html_e('Adicionar novo', 'tradeexpansion'); ?></a>
          </div>
          </div>
        <?php endif; ?>

        <?php if ($can_edit_reports) : ?>
          <?php
          $report_checklist_items = [
            __('Integridade das chapas/blocos', 'tradeexpansion'),
            __('Acabamento superficial', 'tradeexpansion'),
            __('Dimensões e espessura', 'tradeexpansion'),
            __('Umidade / manchas', 'tradeexpansion'),
            __('Embalagem e amarração', 'tradeexpansion'),
          ];
          ?>
          <div class="report-mock">
            <div class="report-mock__header">
              <div>
                <p class="report-mock__eyebrow"><?php esc_html_e('Uso interno', 'tradeexpansion'); ?></p>
                <h3><?php esc_html_e('Modelo rápido de Relatório de Inspeção', 'tradeexpansion'); ?></h3>
                <p><?php esc_html_e('Preencha os campos, anexe as fotos e utilize o botão de impressão para gerar um PDF ou salvar como rascunho.', 'tradeexpansion'); ?></p>
              </div>
              <span class="report-mock__tag"><?php esc_html_e('Mockup acelerador', 'tradeexpansion'); ?></span>
            </div>

            <form id="reportMockForm" class="report-mock__form" autocomplete="off">
              <section class="report-mock__section">
                <h4><?php esc_html_e('Dados gerais', 'tradeexpansion'); ?></h4>
                <div class="report-mock__grid">
                  <label>
                    <span><?php esc_html_e('Empresa / Cliente', 'tradeexpansion'); ?></span>
                    <input type="text" name="empresa" placeholder="<?php esc_attr_e('Empresa Exemplo LTDA', 'tradeexpansion'); ?>" required>
                  </label>
                  <label>
                    <span><?php esc_html_e('Responsável Trade Expansion', 'tradeexpansion'); ?></span>
                    <input type="text" name="responsavel" placeholder="<?php esc_attr_e('Nome do inspetor', 'tradeexpansion'); ?>">
                  </label>
                  <label>
                    <span><?php esc_html_e('Local de inspeção', 'tradeexpansion'); ?></span>
                    <input type="text" name="local" placeholder="<?php esc_attr_e('Pedreira / Porto / Fábrica', 'tradeexpansion'); ?>">
                  </label>
                  <label>
                    <span><?php esc_html_e('Material', 'tradeexpansion'); ?></span>
                    <input type="text" name="material" placeholder="<?php esc_attr_e('Granito Branco Ceará', 'tradeexpansion'); ?>">
                  </label>
                  <label>
                    <span><?php esc_html_e('Lote / Pedido', 'tradeexpansion'); ?></span>
                    <input type="text" name="lote" placeholder="<?php esc_attr_e('Lote 24 / Pedido 2045', 'tradeexpansion'); ?>">
                  </label>
                  <label>
                    <span><?php esc_html_e('Data', 'tradeexpansion'); ?></span>
                    <input type="date" name="data">
                  </label>
                </div>
                <label class="report-mock__full">
                  <span><?php esc_html_e('Resumo da inspeção', 'tradeexpansion'); ?></span>
                  <textarea name="resumo" rows="3" placeholder="<?php esc_attr_e('Resumo rápido sobre objetivo, escopo e principais achados.', 'tradeexpansion'); ?>"></textarea>
                </label>
              </section>

              <section class="report-mock__section">
                <h4><?php esc_html_e('Checklist técnico', 'tradeexpansion'); ?></h4>
                <div class="report-mock__table-wrap">
                  <table class="report-mock__table">
                    <thead>
                      <tr>
                        <th><?php esc_html_e('Item avaliado', 'tradeexpansion'); ?></th>
                        <th><?php esc_html_e('Condição', 'tradeexpansion'); ?></th>
                        <th><?php esc_html_e('Observações', 'tradeexpansion'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($report_checklist_items as $index => $label) : ?>
                        <tr>
                          <td>
                            <input type="text" value="<?php echo esc_attr($label); ?>" name="checklist_item_<?php echo (int) $index; ?>">
                          </td>
                          <td>
                            <select name="checklist_status_<?php echo (int) $index; ?>">
                              <option value="aprovado"><?php esc_html_e('Aprovado', 'tradeexpansion'); ?></option>
                              <option value="pendente"><?php esc_html_e('Pendente', 'tradeexpansion'); ?></option>
                              <option value="reprovado"><?php esc_html_e('Reprovado', 'tradeexpansion'); ?></option>
                            </select>
                          </td>
                          <td>
                            <input type="text" name="checklist_obs_<?php echo (int) $index; ?>" placeholder="<?php esc_attr_e('Detalhes adicionais', 'tradeexpansion'); ?>">
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </section>

              <section class="report-mock__section">
                <h4><?php esc_html_e('Observações detalhadas', 'tradeexpansion'); ?></h4>
                <textarea name="observacoes" rows="4" placeholder="<?php esc_attr_e('Notas detalhadas, recomendações, ajustes solicitados...', 'tradeexpansion'); ?>"></textarea>
              </section>

              <section class="report-mock__section">
                <div class="report-mock__section-head">
                  <h4><?php esc_html_e('Registro fotográfico', 'tradeexpansion'); ?></h4>
                  <p><?php esc_html_e('As imagens selecionadas aparecem nos quadros e serão incluídas na impressão.', 'tradeexpansion'); ?></p>
                </div>
                <div class="report-mock__photos">
                  <?php
                  $report_photos = [
                    ['label' => __('Foto principal', 'tradeexpansion'), 'id' => 'report-photo-1'],
                    ['label' => __('Detalhe técnico', 'tradeexpansion'), 'id' => 'report-photo-2'],
                    ['label' => __('Contexto / embalagem', 'tradeexpansion'), 'id' => 'report-photo-3'],
                  ];
                  foreach ($report_photos as $photo) :
                  ?>
                    <label class="report-photo-slot">
                      <span><?php echo esc_html($photo['label']); ?></span>
                      <input type="file" class="report-photo-input" accept="image/*" data-preview="<?php echo esc_attr($photo['id']); ?>">
                      <div class="report-photo-frame">
                        <img id="<?php echo esc_attr($photo['id']); ?>" class="report-photo-preview hidden" alt="<?php esc_attr_e('Pré-visualização da imagem', 'tradeexpansion'); ?>">
                        <p class="report-photo-placeholder"><?php esc_html_e('Clique ou arraste uma imagem', 'tradeexpansion'); ?></p>
                      </div>
                    </label>
                  <?php endforeach; ?>
                </div>
              </section>

              <div class="report-mock__actions print-hidden">
                <button type="button" class="report-mock__btn" id="report-clear-btn"><?php esc_html_e('Limpar campos', 'tradeexpansion'); ?></button>
                <button type="button" class="report-mock__btn report-mock__btn-primary" id="report-print-btn">
                  <?php esc_html_e('Imprimir / Exportar PDF', 'tradeexpansion'); ?>
                </button>
              </div>
              <p class="report-mock__note print-hidden"><?php esc_html_e('Este mockup não salva automaticamente as informações. Use para preparar o texto, gerar PDF e depois suba o arquivo final no campo de Relatórios.', 'tradeexpansion'); ?></p>
            </form>
          </div>
        <?php endif; ?>
      </section>

      <?php
        $inspections_partial = get_template_directory() . '/client-portal/partials/tab-inspections.php';
        if (file_exists($inspections_partial)) {
          include $inspections_partial;
        }
      ?>

      <?php if ($can_view_financial && $financial) : ?>
        <section data-tab-panel="financial" class="space-y-6 <?php echo $active_tab === 'financial' ? '' : 'hidden'; ?>">
          <div class="grid md:grid-cols-2 gap-4">
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
            <p class="text-sm uppercase tracking-wide text-rose-800"><?php esc_html_e('Saldo pendente', 'tradeexpansion'); ?></p>
              <p class="text-3xl font-bold text-rose-900">R$ <?php echo esc_html(number_format_i18n($financial['summary']['pending'], 2)); ?></p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
            <p class="text-sm uppercase tracking-wide text-emerald-800"><?php esc_html_e('Total pago em 2024', 'tradeexpansion'); ?></p>
              <p class="text-3xl font-bold text-emerald-900">R$ <?php echo esc_html(number_format_i18n($financial['summary']['paid'], 2)); ?></p>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead>
                <tr class="text-left text-secondary/60">
                  <th class="pb-2"><?php esc_html_e('Descrição', 'tradeexpansion'); ?></th>
                  <th class="pb-2"><?php esc_html_e('Valor', 'tradeexpansion'); ?></th>
                  <th class="pb-2"><?php esc_html_e('Status', 'tradeexpansion'); ?></th>
                  <th class="pb-2"><?php esc_html_e('Vencimento', 'tradeexpansion'); ?></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-secondary/10">
                <?php foreach ($financial['entries'] as $entry) : ?>
                  <tr>
                    <td class="py-3 font-medium"><?php echo esc_html($entry['description']); ?></td>
                    <td class="py-3">R$ <?php echo esc_html(number_format_i18n((float) $entry['amount'], 2)); ?></td>
                    <td class="py-3">
                      <?php
                      $finance_status = strtolower($entry['status']) === 'pago' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800';
                      ?>
                      <span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo esc_attr($finance_status); ?>"><?php echo esc_html($entry['status']); ?></span>
                    </td>
                    <td class="py-3">
                      <?php echo !empty($entry['due']) ? esc_html(date_i18n('d/m/Y', strtotime($entry['due']))) : '—'; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <p class="text-xs text-secondary/60 italic"><?php esc_html_e('Dados sincronizados via Google Sheets / Apps Script (configure o endpoint em TECE_FIN_URL).', 'tradeexpansion'); ?></p>
        </section>
      <?php endif; ?>
    </div>

    <section class="grid md:grid-cols-3 gap-4">
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2"><?php esc_html_e('Projetos', 'tradeexpansion'); ?></p>
        <h2 class="text-xl font-semibold mb-2"><?php esc_html_e('Pedidos e materiais', 'tradeexpansion'); ?></h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($projects_placeholder['message']); ?></p>
      </article>
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2"><?php esc_html_e('Chat Petra', 'tradeexpansion'); ?></p>
        <h2 class="text-xl font-semibold mb-2"><?php esc_html_e('Gemini AI', 'tradeexpansion'); ?></h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($chat_placeholder['message']); ?></p>
      </article>
      <article class="rounded-3xl border border-secondary/10 bg-white p-5">
        <p class="text-xs uppercase tracking-[0.4em] text-accent mb-2"><?php esc_html_e('KPIs', 'tradeexpansion'); ?></p>
        <h2 class="text-xl font-semibold mb-2"><?php esc_html_e('Visão estratégica', 'tradeexpansion'); ?></h2>
        <p class="text-sm text-secondary/70"><?php echo esc_html($kpi_placeholder['message']); ?></p>
      </article>
    </section>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const i18nDashboard = {
      saveError: '<?php echo esc_js(__('Erro ao salvar o relatório.', 'tradeexpansion')); ?>',
      saveFail: '<?php echo esc_js(__('Não foi possível salvar. Tente novamente.', 'tradeexpansion')); ?>',
      saving: '<?php echo esc_js(__('Salvando...', 'tradeexpansion')); ?>',
      endpointMissing: '<?php echo esc_js(__('Endpoint indisponível.', 'tradeexpansion')); ?>',
      sending: '<?php echo esc_js(__('Enviando...', 'tradeexpansion')); ?>',
      addPhotos: '<?php echo esc_js(__('Adicionar fotos', 'tradeexpansion')); ?>',
      attachFail: '<?php echo esc_js(__('Não foi possível anexar as imagens. Tente novamente.', 'tradeexpansion')); ?>',
      mediaUnavailable: '<?php echo esc_js(__('Biblioteca de mídia indisponível.', 'tradeexpansion')); ?>',
      mediaTitle: '<?php echo esc_js(__('Selecionar fotos da inspeção', 'tradeexpansion')); ?>',
      promptMaterial: '<?php echo esc_js(__('Material (nome ou ID). Deixe em branco para manter o configurado em cada imagem.', 'tradeexpansion')); ?>',
      promptObservation: '<?php echo esc_js(__('Observação (opcional):', 'tradeexpansion')); ?>',
      attachError: '<?php echo esc_js(__('Erro ao anexar imagens.', 'tradeexpansion')); ?>',
      photoSingle: '<?php echo esc_js(__('foto', 'tradeexpansion')); ?>',
      photoPlural: '<?php echo esc_js(__('fotos', 'tradeexpansion')); ?>'
    };

    const escapeHTML = (str = '') => String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');

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

    const photoInputs = document.querySelectorAll('.report-photo-input');
    photoInputs.forEach(input => {
      input.addEventListener('change', event => {
        const previewId = input.getAttribute('data-preview');
        const previewEl = document.getElementById(previewId);
        if (!previewEl) return;

        const file = event.target.files && event.target.files[0];
        if (!file) {
          previewEl.src = '';
          previewEl.classList.add('hidden');
          return;
        }

        const reader = new FileReader();
        reader.onload = e => {
          previewEl.src = e.target.result;
          previewEl.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
      });
    });

    const resetButton = document.getElementById('report-clear-btn');
    if (resetButton) {
      resetButton.addEventListener('click', () => {
        const form = document.getElementById('reportMockForm');
        if (form) {
          form.reset();
        }
        document.querySelectorAll('.report-photo-preview').forEach(img => {
          img.src = '';
          img.classList.add('hidden');
        });
      });
    }

    const printButton = document.getElementById('report-print-btn');
    if (printButton) {
      printButton.addEventListener('click', event => {
        event.preventDefault();
        window.print();
      });
    }

    const reportContainer = document.querySelector('[data-report-rest]');
    if (reportContainer) {
      const restUrl = reportContainer.dataset.restUrl;
      const restNonce = reportContainer.dataset.restNonce;

      const toggleEditor = (id, forceHide = null) => {
        const editor = document.getElementById(`report-editor-${id}`);
        if (!editor) return;
        if (forceHide === true) {
          editor.classList.add('hidden');
        } else if (forceHide === false) {
          editor.classList.remove('hidden');
        } else {
          editor.classList.toggle('hidden');
        }
      };

      const updateDom = (id, data) => {
        const titleEl = document.querySelector(`[data-report-title="${id}"]`);
        if (titleEl && data.title) {
          titleEl.textContent = data.title;
        }
        const noteEl = document.querySelector(`[data-report-note="${id}"]`);
        if (noteEl) {
          noteEl.textContent = data.note && data.note.trim().length
            ? data.note
            : reportContainer.dataset.emptyNote || 'Sem observações cadastradas.';
        }
      };

      reportContainer.dataset.emptyNote = '<?php echo esc_js(__('Sem observações cadastradas.', 'tradeexpansion')); ?>';

      reportContainer.addEventListener('click', event => {
        const editBtn = event.target.closest('.report-inline-edit-btn');
        if (editBtn) {
          toggleEditor(editBtn.dataset.reportId);
          return;
        }

        const cancelBtn = event.target.closest('.report-inline-cancel');
        if (cancelBtn) {
          toggleEditor(cancelBtn.dataset.reportId, true);
          return;
        }

          const saveBtn = event.target.closest('.report-inline-save');
        if (saveBtn) {
          const id = saveBtn.dataset.reportId;
          const editor = document.getElementById(`report-editor-${id}`);
          if (!editor) return;

          const titleInput = editor.querySelector('.report-inline-title');
          const noteInput = editor.querySelector('.report-inline-note');
          const payload = {
            title: titleInput ? titleInput.value : '',
            content: noteInput ? noteInput.value : '',
          };

          saveBtn.disabled = true;
          const originalText = saveBtn.textContent;
          saveBtn.textContent = i18nDashboard.saving;

          fetch(`${restUrl}${id}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': restNonce,
            },
            body: JSON.stringify(payload),
          })
            .then(response => {
              if (!response.ok) {
                throw new Error(i18nDashboard.saveError);
              }
              return response.json();
            })
            .then(data => {
              updateDom(id, data);
              toggleEditor(id, true);
            })
            .catch(error => {
              console.error(error);
              alert(i18nDashboard.saveFail);
            })
            .finally(() => {
              saveBtn.disabled = false;
              saveBtn.textContent = originalText;
            });
        }
      });
    }

    const inspectionsPanel = document.querySelector('[data-tab-panel="inspections"]');
    if (inspectionsPanel) {
      const restUrl = inspectionsPanel.dataset.inspectionsRestUrl || '';
      const restNonce = inspectionsPanel.dataset.inspectionsRestNonce || '';
      const emptyText = inspectionsPanel.dataset.inspectionsEmpty || 'Sem registros de imagens para este material.';
      let materialOptions = [];
      try {
        materialOptions = inspectionsPanel.dataset.materialOptions
          ? JSON.parse(inspectionsPanel.dataset.materialOptions)
          : [];
      } catch (error) {
        materialOptions = [];
      }

      const renderMaterials = (card, materials) => {
        const container = card.querySelector('.inspection-materials');
        if (!container) return;

        if (!materials || !materials.length) {
          container.innerHTML = `<p class="inspection-empty">${escapeHTML(emptyText)}</p>`;
          return;
        }

        const html = materials.map(material => {
          const photos = (material.photos || []).map(photo => {
            const image = photo.image ? escapeHTML(photo.image) : '';
            const note = photo.note ? `<figcaption>${escapeHTML(photo.note)}</figcaption>` : '';
            const alt = escapeHTML(photo.material || material.name || '');
            return `
              <figure class="inspection-photo-card">
                <img src="${image}" alt="${alt}" loading="lazy">
                ${note}
              </figure>
            `;
          }).join('');

          const count = material.photos ? material.photos.length : 0;
          const photoLabel = count === 1 ? i18nDashboard.photoSingle : i18nDashboard.photoPlural;
          return `
            <section class="inspection-material">
              <div class="inspection-material__header">
                <h4>${escapeHTML(material.name || '')}</h4>
                <span class="inspection-material__count">${escapeHTML(String(count))} ${escapeHTML(photoLabel)}</span>
              </div>
              <div class="inspection-material__grid">
                ${photos || `<p class="inspection-empty">${escapeHTML(emptyText)}</p>`}
              </div>
            </section>
          `;
        }).join('');

        container.innerHTML = html;
      };

      const submitAttachments = (inspectionId, payload) => {
        if (!restUrl || !restNonce) {
          alert(i18nDashboard.endpointMissing);
          return;
        }

        const card = document.querySelector(`[data-inspection-card="${inspectionId}"]`);
        const button = card ? card.querySelector('.inspection-add-photo') : null;
        if (button) {
          button.disabled = true;
          button.dataset.originalText = button.dataset.originalText || button.textContent;
          button.textContent = i18nDashboard.sending;
        }

        fetch(`${restUrl}${inspectionId}/`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce,
          },
          body: JSON.stringify(payload),
        })
          .then(response => {
            if (!response.ok) {
              throw new Error(i18nDashboard.attachError);
            }
            return response.json();
          })
          .then(data => {
            if (card) {
              renderMaterials(card, data.materials || []);
            }
          })
          .catch(error => {
            console.error(error);
            alert(i18nDashboard.attachFail);
          })
          .finally(() => {
            if (button) {
              button.disabled = false;
              button.textContent = button.dataset.originalText || i18nDashboard.addPhotos;
            }
          });
      };

      const openMediaPicker = inspectionId => {
        if (typeof wp === 'undefined' || !wp.media) {
          alert(i18nDashboard.mediaUnavailable);
          return;
        }

        const frame = wp.media({
          title: i18nDashboard.mediaTitle,
          multiple: true,
          library: { type: 'image' },
        });

        frame.on('select', () => {
          const selection = frame.state().get('selection');
          if (!selection || !selection.size()) {
            return;
          }

          const attachments = [];
          selection.each(attachment => {
            attachments.push(attachment.id);
          });

          if (!attachments.length) {
            return;
          }

          const materialName = window.prompt(
            i18nDashboard.promptMaterial,
            materialOptions.length ? materialOptions[0].name : ''
          ) || '';
          const obsText = window.prompt(i18nDashboard.promptObservation, '') || '';

          const payload = {
            attachments: attachments.map(id => ({
              id,
              tec_material: materialName,
              tec_obs: obsText,
            })),
          };

          submitAttachments(inspectionId, payload);
        });

        frame.open();
      };

      inspectionsPanel.addEventListener('click', event => {
        const addBtn = event.target.closest('.inspection-add-photo');
        if (!addBtn) {
          return;
        }

        const inspectionId = addBtn.dataset.inspectionId;
        if (!inspectionId) {
          return;
        }

        openMediaPicker(inspectionId);
      });
    }
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
