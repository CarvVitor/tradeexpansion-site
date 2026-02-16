<?php
/**
 * Dashboard View
 */
$current_user = wp_get_current_user();
$reports = te_client_portal_fetch_reports($current_user->ID);
$inspections = te_client_portal_fetch_inspections($current_user->ID);
$projects_placeholder = te_client_portal_fetch_projects_placeholder();
$chat_placeholder = te_client_portal_get_chat_placeholder();
$kpi_placeholder = te_client_portal_get_kpis_placeholder();
$status_code = isset($_GET['portal_status']) ? sanitize_text_field(wp_unslash($_GET['portal_status'])) : '';
$status_message = $status_code ? te_client_portal_get_status_message($status_code) : null;
$can_edit_reports = current_user_can('edit_posts');
$can_view_financial = false; // function_exists('tec_portal_user_has_financial') ? tec_portal_user_has_financial(get_current_user_id()) : false;
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

<style>
  :root {
    --primary-gold: #D6A354;
    --champagne: #F1F1D9;
    --deep-green: #0B1D1B;
    --glass-bg: rgba(11, 29, 27, 0.6);
    --glass-border: rgba(255, 255, 255, 0.05);
    --text-bright: #F1F1D9;
    --sans-font: 'Inter', sans-serif;
  }

  .luxury-portal {
    background-color: var(--deep-green);
    min-height: 100vh;
    color: var(--text-bright);
    font-family: 'Vollkorn', serif;
  }

  #sync-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 0%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--primary-gold), var(--primary-gold), transparent);
    z-index: 9999;
    transition: width 0.4s cubic-bezier(0.1, 0.7, 1.0, 0.1);
    display: none;
  }

  h1,
  h2,
  h3,
  h4,
  .editorial-title {
    letter-spacing: 0.15em !important;
    text-transform: uppercase;
    font-weight: 700;
  }

  .label-secondary {
    font-family: var(--sans-font);
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    font-size: 10px;
    color: rgba(241, 241, 217, 0.3);
  }

  .luxury-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 4px;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .luxury-card:hover {
    transform: translateY(-1px);
    border-color: rgba(214, 163, 84, 0.3);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(214, 163, 84, 0.15);
    background: rgba(11, 29, 27, 0.7);
  }

  .portal-tab {
    padding: 12px 24px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.3em;
    color: rgba(241, 241, 217, 0.2);
    border: none;
    background: transparent;
    transition: all 0.3s;
    border-bottom: 2px solid transparent;
    border-radius: 0;
  }

  .portal-tab-active {
    color: var(--primary-gold);
    border-bottom: 2px solid var(--primary-gold);
    background: transparent !important;
  }

  .btn-minimalist {
    background: transparent;
    border: 1px solid rgba(214, 163, 84, 0.3);
    color: var(--primary-gold);
    padding: 10px 24px;
    border-radius: 100px;
    font-family: var(--sans-font);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: all 0.4s;
  }

  .btn-minimalist:hover {
    background: var(--primary-gold);
    color: var(--deep-green);
    border-color: var(--primary-gold);
  }

  .minimal-input {
    background: transparent !important;
    border: none !important;
    border-bottom: 1px solid rgba(214, 163, 84, 0.2) !important;
    padding: 15px 0 !important;
    width: 100%;
    color: var(--text-bright) !important;
    font-family: 'Vollkorn', serif !important;
    font-size: 18px !important;
    transition: all 0.4s;
    border-radius: 0 !important;
  }

  .minimal-input:focus {
    outline: none !important;
    border-bottom-color: var(--primary-gold) !important;
    box-shadow: 0 8px 15px -10px var(--champagne) !important;
    filter: brightness(1.2);
  }

  table th {
    letter-spacing: 0.15em !important;
    text-transform: uppercase;
    font-size: 10px !important;
    font-weight: 800 !important;
    padding: 20px !important;
    color: var(--primary-gold) !important;
    border-bottom: 1px solid var(--glass-border) !important;
  }

  table td {
    padding: 20px !important;
    font-size: 14px;
    border-bottom: 1px solid var(--glass-border) !important;
  }
</style>

<div id="sync-progress"></div>

<main class="luxury-portal min-h-screen py-20">
  <div class="max-w-7xl mx-auto px-6 space-y-12">
    <!-- Header Editorial -->
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between border-b border-white/5 pb-10">
      <div>
        <span class="label-secondary mb-3 block"><?php esc_html_e('Inteligência B2B', 'tradeexpansion'); ?></span>
        <h1 class="text-6xl font-bold mb-2 tracking-tighter">
          <?php printf(esc_html__('Olá, %s', 'tradeexpansion'), esc_html($current_user->display_name ?: $current_user->user_login)); ?>
        </h1>
        <p class="text-white/30 text-xl font-light italic">
          <?php esc_html_e('Gestión técnica y operativa de su portafolio.', 'tradeexpansion'); ?>
        </p>
      </div>

      <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="te_client_logout">
        <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
        <button type="submit" class="label-secondary hover:text-rose-400 transition-colors flex items-center gap-3">
          <span><?php esc_html_e('Salir', 'tradeexpansion'); ?></span>
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          </svg>
        </button>
      </form>
    </div>

    <?php if ($status_message): ?>
      <div
        class="rounded-2xl border px-4 py-3 text-sm <?php echo $status_message['type'] === 'success' ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : ($status_message['type'] === 'warning' ? 'border-amber-300 bg-amber-50 text-amber-900' : 'border-rose-300 bg-rose-50 text-rose-900'); ?>">
        <?php echo esc_html($status_message['text']); ?>
      </div>
    <?php endif; ?>

    <div class="luxury-card p-4 mb-12">
      <div class="flex flex-wrap items-center gap-1 border-b border-white/5">
        <?php $is_first = true; ?>
        <?php foreach ($portal_tabs as $slug => $label): ?>
          <button class="portal-tab <?php echo $is_first ? 'portal-tab-active' : ''; ?>"
            data-tab-target="<?php echo esc_attr($slug); ?>">
            <?php echo esc_html($label); ?>
          </button>
          <?php $is_first = false; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <section data-tab-panel="reports" class="space-y-6 <?php echo $active_tab === 'reports' ? '' : 'hidden'; ?>">
      <?php if (empty($reports)): ?>
        <p class="text-white/30 italic text-center py-10">
          <?php esc_html_e('No hay informes registrados para este cliente hasta ahora.', 'tradeexpansion'); ?>
        </p>
      <?php endif; ?>
      <?php foreach ($reports as $report): ?>
        <article class="luxury-card p-8 flex flex-col md:flex-row md:items-center justify-between gap-8 group">
          <div>
            <span class="label-secondary mb-2 block">
              <?php printf(esc_html__('Publicado em %s', 'tradeexpansion'), esc_html(date_i18n('d M Y', strtotime($report['date'])))); ?>
            </span>
            <h3 class="text-3xl font-bold text-white mb-2 group-hover:text-gold transition-colors"
              data-report-title="<?php echo (int) ($report['post_id'] ?? 0); ?>"><?php echo esc_html($report['title']); ?>
            </h3>
            <p class="text-white/40 text-lg font-light leading-relaxed max-w-2xl report-note"
              data-report-note="<?php echo (int) ($report['post_id'] ?? 0); ?>">
              <?php echo $report['note'] ? esc_html($report['note']) : esc_html__('Sin observaciones registradas.', 'tradeexpansion'); ?>
            </p>
          </div>
          <div class="flex items-center gap-4 flex-wrap justify-end">
            <?php
            $status_slug = isset($report['status_slug']) ? strtolower($report['status_slug']) : strtolower($report['status']);
            $status_color = [
              'aprovado' => 'text-emerald-400',
              'pendente' => 'text-amber-400',
              'reprovado' => 'text-rose-400',
            ][$status_slug] ?? 'text-white/40';
            ?>
            <span class="label-secondary <?php echo $status_color; ?> px-4 py-2 border border-current opacity-60">
              <?php echo esc_html($report['status']); ?>
            </span>

            <?php if (!empty($report['post_id'])): ?>
              <a class="btn-minimalist" href="<?php echo esc_url(tec_relatorio_pdf_url((int) $report['post_id'], true)); ?>"
                target="_blank" rel="noopener">
                <?php esc_html_e('Descargar PDF', 'tradeexpansion'); ?>
              </a>
            <?php endif; ?>

            <?php if ($can_edit_reports && !empty($report['post_id'])): ?>
              <button type="button" class="btn-minimalist report-inline-edit-btn"
                data-report-id="<?php echo (int) $report['post_id']; ?>">
                <?php esc_html_e('Editar', 'tradeexpansion'); ?>
              </button>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
      <p class="text-xs text-secondary/60 italic">
        <?php esc_html_e('Função fetchReports() pronta para integrar Airtable/Drive via API.', 'tradeexpansion'); ?>
      </p>

      <script>
        // Funções para o modal de novo relatório
        document.addEventListener('DOMContentLoaded', function () {
          window.openNewReportModal = function () {
            const modal = document.getElementById('newReportModal');
            if (modal) {
              modal.style.display = 'block';
              document.body.style.overflow = 'hidden';
              console.log('✅ Modal aberto');
            } else {
              console.error('❌ Modal #newReportModal não encontrado');
            }
          };

          window.closeNewReportModal = function () {
            const modal = document.getElementById('newReportModal');
            if (modal) {
              modal.style.display = 'none';
              document.body.style.overflow = 'auto';
              const form = document.getElementById('newReportForm');
              if (form) form.reset();
            }
          };

          window.updateFileName = function (input) {
            const fileName = input.files[0] ? input.files[0].name : 'Clique ou arraste um arquivo PDF';
            const fileNameEl = document.getElementById('fileName');
            if (fileNameEl) fileNameEl.textContent = fileName;
          };
        });
      </script>

      <?php if ($can_edit_reports): ?>
        <div
          style="margin: 2rem 0; padding: 1.5rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 1rem; border: 2px dashed #dee2e6; display: flex !important; flex-direction: row !important; justify-content: space-between !important; align-items: center !important; gap: 2rem;">
          <div style="flex: 1;">
            <p
              style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: #6c757d; margin-bottom: 0.5rem; margin-top: 0;">
              <?php esc_html_e('Visão administrativa', 'tradeexpansion'); ?>
            </p>
            <h4 style="font-size: 1.25rem; font-weight: 700; color: #212529; margin: 0 0 0.25rem 0;">
              <?php esc_html_e('Gerenciar relatórios', 'tradeexpansion'); ?>
            </h4>
            <p style="font-size: 0.875rem; color: #6c757d; margin: 0;">
              <?php esc_html_e('Crie, edite e organize os relatórios diretamente aqui.', 'tradeexpansion'); ?>
            </p>
          </div>
          <div style="flex-shrink: 0;">
            <button type="button" onclick="openNewReportModal()"
              style="padding: 1rem 2rem !important; background: linear-gradient(135deg, #5D2713 0%, #3d1a0c 100%) !important; color: white !important; border: none !important; border-radius: 0.75rem !important; font-weight: 600 !important; font-size: 1rem !important; cursor: pointer !important; box-shadow: 0 4px 12px rgba(93, 39, 19, 0.3) !important; transition: all 0.3s ease !important; white-space: nowrap !important; display: inline-flex !important; align-items: center !important; gap: 0.5rem !important;"
              onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(93, 39, 19, 0.4)';"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(93, 39, 19, 0.3)';">
              <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
              </svg>
              <span><?php esc_html_e('Novo Relatório', 'tradeexpansion'); ?></span>
            </button>
          </div>
        </div>
      <?php endif; ?>


      <?php if ($can_edit_reports): ?>
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
              <p>
                <?php esc_html_e('Preencha os campos, anexe as fotos e utilize o botão de impressão para gerar um PDF ou salvar como rascunho.', 'tradeexpansion'); ?>
              </p>
            </div>
            <span class="report-mock__tag"><?php esc_html_e('Mockup acelerador', 'tradeexpansion'); ?></span>
          </div>

          <form id="reportMockForm" class="report-mock__form" autocomplete="off">
            <section class="report-mock__section">
              <h4><?php esc_html_e('Dados gerais', 'tradeexpansion'); ?></h4>
              <div class="report-mock__grid">
                <label>
                  <span><?php esc_html_e('Empresa / Cliente', 'tradeexpansion'); ?></span>
                  <input type="text" name="empresa"
                    placeholder="<?php esc_attr_e('Empresa Exemplo LTDA', 'tradeexpansion'); ?>" required>
                </label>
                <label>
                  <span><?php esc_html_e('Responsável Trade Expansion', 'tradeexpansion'); ?></span>
                  <input type="text" name="responsavel"
                    placeholder="<?php esc_attr_e('Nome do inspetor', 'tradeexpansion'); ?>">
                </label>
                <label>
                  <span><?php esc_html_e('Local de inspeção', 'tradeexpansion'); ?></span>
                  <input type="text" name="local"
                    placeholder="<?php esc_attr_e('Pedreira / Porto / Fábrica', 'tradeexpansion'); ?>">
                </label>
                <label>
                  <span><?php esc_html_e('Material', 'tradeexpansion'); ?></span>
                  <input type="text" name="material"
                    placeholder="<?php esc_attr_e('Granito Branco Ceará', 'tradeexpansion'); ?>">
                </label>
                <label>
                  <span><?php esc_html_e('Lote / Pedido', 'tradeexpansion'); ?></span>
                  <input type="text" name="lote"
                    placeholder="<?php esc_attr_e('Lote 24 / Pedido 2045', 'tradeexpansion'); ?>">
                </label>
                <label>
                  <span><?php esc_html_e('Data', 'tradeexpansion'); ?></span>
                  <input type="date" name="data">
                </label>
              </div>
              <label class="report-mock__full">
                <span><?php esc_html_e('Resumo da inspeção', 'tradeexpansion'); ?></span>
                <textarea name="resumo" rows="3"
                  placeholder="<?php esc_attr_e('Resumo rápido sobre objetivo, escopo e principais achados.', 'tradeexpansion'); ?>"></textarea>
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
                    <?php foreach ($report_checklist_items as $index => $label): ?>
                      <tr>
                        <td>
                          <input type="text" value="<?php echo esc_attr($label); ?>"
                            name="checklist_item_<?php echo (int) $index; ?>">
                        </td>
                        <td>
                          <select name="checklist_status_<?php echo (int) $index; ?>">
                            <option value="aprovado"><?php esc_html_e('Aprovado', 'tradeexpansion'); ?></option>
                            <option value="pendente"><?php esc_html_e('Pendente', 'tradeexpansion'); ?></option>
                            <option value="reprovado"><?php esc_html_e('Reprovado', 'tradeexpansion'); ?></option>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="checklist_obs_<?php echo (int) $index; ?>"
                            placeholder="<?php esc_attr_e('Detalhes adicionais', 'tradeexpansion'); ?>">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </section>

            <section class="report-mock__section">
              <h4><?php esc_html_e('Observações detalhadas', 'tradeexpansion'); ?></h4>
              <textarea name="observacoes" rows="4"
                placeholder="<?php esc_attr_e('Notas detalhadas, recomendações, ajustes solicitados...', 'tradeexpansion'); ?>"></textarea>
            </section>

            <section class="report-mock__section">
              <div class="report-mock__section-head">
                <h4><?php esc_html_e('Registro fotográfico', 'tradeexpansion'); ?></h4>
                <p>
                  <?php esc_html_e('As imagens selecionadas aparecem nos quadros e serão incluídas na impressão.', 'tradeexpansion'); ?>
                </p>
              </div>
              <div class="report-mock__photos">
                <?php
                $report_photos = [
                  ['label' => __('Foto principal', 'tradeexpansion'), 'id' => 'report-photo-1'],
                  ['label' => __('Detalhe técnico', 'tradeexpansion'), 'id' => 'report-photo-2'],
                  ['label' => __('Contexto / embalagem', 'tradeexpansion'), 'id' => 'report-photo-3'],
                ];
                foreach ($report_photos as $photo):
                  ?>
                  <label class="report-photo-slot">
                    <span><?php echo esc_html($photo['label']); ?></span>
                    <input type="file" class="report-photo-input" accept="image/*"
                      data-preview="<?php echo esc_attr($photo['id']); ?>">
                    <div class="report-photo-frame">
                      <img id="<?php echo esc_attr($photo['id']); ?>" class="report-photo-preview hidden"
                        alt="<?php esc_attr_e('Pré-visualização da imagem', 'tradeexpansion'); ?>">
                      <p class="report-photo-placeholder">
                        <?php esc_html_e('Clique ou arraste uma imagem', 'tradeexpansion'); ?>
                      </p>
                    </div>
                  </label>
                <?php endforeach; ?>
              </div>
            </section>

            <div class="report-mock__actions print-hidden">
              <button type="button" class="report-mock__btn"
                id="report-clear-btn"><?php esc_html_e('Limpar campos', 'tradeexpansion'); ?></button>
              <button type="button" class="report-mock__btn report-mock__btn-primary" id="report-print-btn">
                <?php esc_html_e('Imprimir / Exportar PDF', 'tradeexpansion'); ?>
              </button>
            </div>
            <p class="report-mock__note print-hidden">
              <?php esc_html_e('Este mockup não salva automaticamente as informações. Use para preparar o texto, gerar PDF e depois suba o arquivo final no campo de Relatórios.', 'tradeexpansion'); ?>
            </p>
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

    <?php if ($can_view_financial): ?>
      <script>
        // Define a função financialDashboard GLOBALMENTE
        window.financialDashboard = function () {
          return {
            financialData: [
              {
                "PROVEDORES": "ARGOS Brasil",
                "INVOICE": "INV-001",
                "VALOR": "28600",
                "ADV": "5000",
                "PRAZO": "30 días",
                "FECHA DE VENCIMIENTO": "2025-11-15",
                "FECHA PAGO": "",
                "SALDO ABIERTO": "23600",
                "SALDO CREDITO": "0"
              },
              {
                "PROVEDORES": "BRAMAGRAN",
                "INVOICE": "INV-002",
                "VALOR": "15400",
                "ADV": "3000",
                "PRAZO": "45 días",
                "FECHA DE VENCIMIENTO": "2025-12-01",
                "FECHA PAGO": "2025-10-20",
                "SALDO ABIERTO": "0",
                "SALDO CREDITO": "1200"
              },
              {
                "PROVEDORES": "Mármores Sul",
                "INVOICE": "INV-003",
                "VALOR": "42000",
                "PRAZO": "60 días",
                "FECHA DE VENCIMIENTO": "2025-12-20",
                "FECHA PAGO": "",
                "SALDO ABIERTO": "32000",
                "SALDO CREDITO": "0"
              }
            ],
            loading: false,
            showFullSheet: false,
            showNewOrderModal: false,
            totalAbierto: 0,
            totalCredito: 0,
            totalPagado: 0,
            totalInvoicesPendientes: 0,
            totalInvoicesPagos: 0,
            proximoVencimiento: null,
            diasProximoVencimiento: '',
            newOrder: {
              proveedor: '',
              invoice: '',
              valor: '',
              adv: '',
              prazo: '',
              vencimiento: '',
              documentos: ''
            },

            init() {
              this.calculateKPIs();
              this.renderCharts();
              console.log('✅ Dashboard financeiro inicializado!');
            },

            calculateKPIs() {
              this.totalAbierto = this.financialData.reduce((sum, row) => {
                return sum + (parseFloat(row['SALDO ABIERTO']) || 0);
              }, 0);

              this.totalCredito = this.financialData.reduce((sum, row) => {
                return sum + (parseFloat(row['SALDO CREDITO']) || 0);
              }, 0);

              this.totalInvoicesPendientes = this.financialData.filter(row => !row['FECHA PAGO']).length;
              this.totalInvoicesPagos = this.financialData.filter(row => row['FECHA PAGO']).length;

              this.totalPagado = this.financialData
                .filter(row => row['FECHA PAGO'])
                .reduce((sum, row) => sum + (parseFloat(row.VALOR) || 0), 0);

              const pendientes = this.financialData
                .filter(row => !row['FECHA PAGO'] && row['FECHA DE VENCIMIENTO'])
                .map(row => ({
                  date: new Date(row['FECHA DE VENCIMIENTO']),
                  original: row['FECHA DE VENCIMIENTO']
                }))
                .sort((a, b) => a.date - b.date);

              if (pendientes.length > 0) {
                const proxima = pendientes[0];
                this.proximoVencimiento = proxima.original;
                const dias = Math.ceil((proxima.date - new Date()) / (1000 * 60 * 60 * 24));

                if (dias > 0) {
                  this.diasProximoVencimiento = `En ${dias} día${dias !== 1 ? 's' : ''}`;
                } else if (dias === 0) {
                  this.diasProximoVencimiento = '⚠️ Vence hoy';
                } else {
                  this.diasProximoVencimiento = `🔴 Vencido hace ${Math.abs(dias)} días`;
                }
              }
            },

            renderCharts() {
              setTimeout(() => {
                if (typeof Chart === 'undefined') {
                  console.error('Chart.js não carregado');
                  return;
                }

                const statusChart = document.getElementById('paymentStatusChart');
                const suppliersChart = document.getElementById('suppliersChart');

                if (statusChart) {
                  new Chart(statusChart, {
                    type: 'doughnut',
                    data: {
                      labels: ['Pagados', 'Pendientes'],
                      datasets: [{
                        data: [this.totalInvoicesPagos, this.totalInvoicesPendientes],
                        backgroundColor: ['#10b981', '#f59e0b'],
                        borderWidth: 0
                      }]
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                        legend: {
                          position: 'bottom'
                        }
                      }
                    }
                  });
                }

                if (suppliersChart) {
                  const proveedorCount = {};
                  this.financialData.forEach(row => {
                    const prov = row.PROVEDORES;
                    proveedorCount[prov] = (proveedorCount[prov] || 0) + 1;
                  });

                  const topProveedores = Object.entries(proveedorCount)
                    .sort((a, b) => b[1] - a[1])
                    .slice(0, 5);

                  new Chart(suppliersChart, {
                    type: 'bar',
                    data: {
                      labels: topProveedores.map(p => p[0]),
                      datasets: [{
                        label: 'Invoices',
                        data: topProveedores.map(p => p[1]),
                        backgroundColor: '#5D2713',
                        borderRadius: 6
                      }]
                    },
                    options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                        legend: {
                          display: false
                        }
                      },
                      scales: {
                        y: {
                          beginAtZero: true,
                          ticks: {
                            stepSize: 1
                          }
                        }
                      }
                    }
                  });
                }
              }, 100);
            },

            formatCurrency(value) {
              return parseFloat(value || 0).toLocaleString('es-MX', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              });
            },

            submitNewOrder() {
              console.log('Nuevo pedido:', this.newOrder);
              alert('¡Pedido enviado con éxito!');
              this.showNewOrderModal = false;
              this.newOrder = { proveedor: '', invoice: '', valor: '', adv: '', prazo: '', vencimiento: '', documentos: '' };
            }
          };
        };
      </script>
    <?php endif; ?>

    <?php if ($can_view_financial):
      $apps_script_url = 'https://script.google.com/macros/s/AKfycbzkmSrwwDcTmv5f_mfHobv2hWZwaqV6ozikD54xP3S1XI0ZksMyUvyhBkutrXwASdO9/exec';
      $sheet_id = '1rjttHjcDt5eszTv8CAcLer2kjOthCleQIzJJeH6KTu8'; // IMPORTANTE: Cole o ID da sua planilha Google Sheets aqui
      ?>

      <section data-tab-panel="financial" class="space-y-6 <?php echo $active_tab === 'financial' ? '' : 'hidden'; ?>"
        x-data="financialDashboard()">
        <!-- CABEÇALHO -->
        <div class="flex items-center justify-between border-b border-white/5 pb-6">
          <div>
            <h2 class="text-3xl font-bold text-white"><?php esc_html_e('Gestión Financiera', 'tradeexpansion'); ?></h2>
            <p class="text-white/40 text-sm font-light italic mt-1">
              <?php esc_html_e('Control de pagos, créditos y plazos', 'tradeexpansion'); ?>
            </p>
          </div>
          <button @click="showNewOrderModal = true" class="btn-minimalist">
            <?php esc_html_e('Nuevo Pedido', 'tradeexpansion'); ?>
          </button>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Total em Aberto -->
          <div class="luxury-card p-10 group">
            <div class="flex items-center justify-between mb-6">
              <span class="label-secondary"
                title="Valor total pendiente de pago"><?php esc_html_e('Pendiente', 'tradeexpansion'); ?></span>
              <div class="w-1.5 h-1.5 rounded-full bg-amber-400 group-hover:shadow-[0_0_10px_#fbbf24] transition-all">
              </div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalAbierto)">$0</p>
            <p class="label-secondary opacity-40 mt-4" x-text="totalInvoicesPendientes + ' invoices abiertos'">0 invoices
            </p>
          </div>

          <!-- Crédito a Favor -->
          <div class="luxury-card p-10 group">
            <div class="flex items-center justify-between mb-6">
              <span class="label-secondary"
                title="Crédito que la fábrica debe reembolsar"><?php esc_html_e('Crédito', 'tradeexpansion'); ?></span>
              <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 group-hover:shadow-[0_0_10px_#34d399] transition-all">
              </div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalCredito)">$0</p>
            <p class="label-secondary opacity-40 mt-4"><?php esc_html_e('A favor de Israel', 'tradeexpansion'); ?></p>
          </div>

          <!-- Próximo Vencimento -->
          <div class="luxury-card p-10 group">
            <div class="flex items-center justify-between mb-6">
              <span class="label-secondary"><?php esc_html_e('Próximo', 'tradeexpansion'); ?></span>
              <div class="w-1.5 h-1.5 rounded-full bg-rose-400 group-hover:shadow-[0_0_10px_#f87171] transition-all">
              </div>
            </div>
            <p class="text-3xl font-bold text-white tracking-tighter" x-text="proximoVencimiento || 'N/A'">--</p>
            <p class="label-secondary opacity-40 mt-4" x-text="diasProximoVencimiento || 'Sin vencimientos'"></p>
          </div>

          <!-- Total Pago -->
          <div class="luxury-card p-10 group">
            <div class="flex items-center justify-between mb-6">
              <span class="label-secondary"><?php esc_html_e('Total Pagado', 'tradeexpansion'); ?></span>
              <div class="w-1.5 h-1.5 rounded-full bg-blue-400 group-hover:shadow-[0_0_10px_#60a5fa] transition-all">
              </div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalPagado)">$0</p>
            <p class="label-secondary opacity-40 mt-4" x-text="totalInvoicesPagos + ' pagos realizados'">0 pagos</p>
          </div>
        </div>

        <!-- GRÁFICOS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="luxury-card p-10">
            <h3 class="editorial-title text-sm mb-10 opacity-60">
              <?php esc_html_e('Estado de Pagos', 'tradeexpansion'); ?>
            </h3>
            <div class="h-[300px]">
              <canvas id="paymentStatusChart"></canvas>
            </div>
          </div>

          <div class="luxury-card p-10">
            <h3 class="editorial-title text-sm mb-10 opacity-60">
              <?php esc_html_e('Top 5 Proveedores', 'tradeexpansion'); ?>
            </h3>
            <div class="h-[300px]">
              <canvas id="suppliersChart"></canvas>
            </div>
          </div>
        </div>

        <!-- TABELA COMPLETA -->
        <div class="luxury-card overflow-hidden">
          <div class="p-10 border-b border-white/5 flex items-center justify-between">
            <div>
              <h3 class="text-2xl font-bold text-white"><?php esc_html_e('Invoices Detalladas', 'tradeexpansion'); ?></h3>
              <p class="label-secondary opacity-40 mt-1">
                <?php esc_html_e('Historial de transacciones y estados', 'tradeexpansion'); ?>
              </p>
            </div>
            <button @click="showFullSheet = !showFullSheet" class="btn-minimalist text-xs">
              <span x-text="showFullSheet ? 'Cerrar vista completa' : 'Ver planilla completa'"></span>
            </button>
          </div>

          <div x-show="!showFullSheet" class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b border-white/5">
                  <th class="px-8 py-6 label-secondary opacity-40"><?php esc_html_e('Proveedor', 'tradeexpansion'); ?>
                  </th>
                  <th class="px-8 py-6 label-secondary opacity-40 text-center">
                    <?php esc_html_e('Invoice', 'tradeexpansion'); ?>
                  </th>
                  <th class="px-8 py-6 label-secondary opacity-40 text-right">
                    <?php esc_html_e('Valor', 'tradeexpansion'); ?>
                  </th>
                  <th class="px-8 py-6 label-secondary opacity-40 text-center">
                    <?php esc_html_e('Vencimiento', 'tradeexpansion'); ?>
                  </th>
                  <th class="px-8 py-6 label-secondary opacity-40 text-center">
                    <?php esc_html_e('Estado', 'tradeexpansion'); ?>
                  </th>
                  <th class="px-8 py-6 label-secondary opacity-40 text-right">
                    <?php esc_html_e('Saldo', 'tradeexpansion'); ?>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-white/5">
                <template x-for="(row, index) in financialData" :key="index">
                  <tr class="group hover:bg-white/[0.02] transition-colors">
                    <td class="px-8 py-8 font-bold text-white text-lg" x-text="row.PROVEDORES"></td>
                    <td class="px-8 py-8 text-white/40 font-mono text-xs text-center" x-text="row.INVOICE"></td>
                    <td class="px-8 py-8 text-right font-bold text-white text-xl tracking-tighter"
                      x-text="'$' + formatCurrency(row.VALOR)"></td>
                    <td class="px-8 py-8 text-center label-secondary opacity-60 text-[10px]"
                      x-text="row['FECHA DE VENCIMIENTO'] || '-'"></td>
                    <td class="px-8 py-8 text-center">
                      <span class="label-secondary px-3 py-1 border text-[10px]"
                        :class="row['FECHA PAGO'] ? 'border-emerald-500/30 text-emerald-400 bg-emerald-500/5' : 'border-amber-500/30 text-amber-400 bg-amber-500/5'"
                        x-text="row['FECHA PAGO'] ? 'PAGADO' : 'PENDIENTE'"></span>
                    </td>
                    <td class="px-8 py-8 text-right font-bold text-emerald-400"
                      :class="parseFloat(row['SALDO ABIERTO'] || 0) > 0 ? 'text-rose-400' : 'text-emerald-400'"
                      x-text="'$' + formatCurrency(row['SALDO ABIERTO'])"></td>
                  </tr>
                </template>
              </tbody>
            </table>

            <!-- Loading -->
            <div x-show="loading" class="text-center py-16 text-secondary/60">
              <svg class="animate-spin h-10 w-10 mx-auto mb-3 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
              <p class="font-medium"><?php esc_html_e('Cargando datos financieros...', 'tradeexpansion'); ?></p>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && financialData.length === 0" class="text-center py-16">
              <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p class="text-gray-500"><?php esc_html_e('No hay datos disponibles', 'tradeexpansion'); ?></p>
            </div>
          </div>

          <!-- Google Sheets Iframe -->
          <div x-show="showFullSheet" class="p-4 bg-gray-50">
            <div class="bg-white rounded-lg border-2 border-primary/20 overflow-hidden">
              <iframe src="https://docs.google.com/spreadsheets/d/<?php echo esc_attr($sheet_id); ?>/edit?usp=sharing"
                class="w-full" style="height: 700px; border: none;" loading="lazy"></iframe>
              <div class="p-4 bg-gradient-to-r from-primary/5 to-secondary/5 border-t border-gray-200">
                <div class="flex items-start gap-3">
                  <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <p class="text-sm text-secondary">
                    <strong><?php esc_html_e('Modo edición activo:', 'tradeexpansion'); ?></strong>
                    <?php esc_html_e('Puede editar la planilla directamente. Los cambios se guardan automáticamente en Google Sheets.', 'tradeexpansion'); ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- MODAL: NUEVO PEDIDO -->
        <div x-show="showNewOrderModal"
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-xl p-6"
          x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100" style="display: none;">
          <div class="luxury-card max-w-2xl w-full p-12 relative" @click.away="showNewOrderModal = false">
            <button @click="showNewOrderModal = false"
              class="absolute top-8 right-8 text-white/20 hover:text-white transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            <div class="mb-10">
              <span
                class="label-secondary opacity-40 mb-2 block"><?php esc_html_e('Gestión de Suministros', 'tradeexpansion'); ?></span>
              <h2 class="text-3xl font-bold text-white tracking-tighter">
                <?php esc_html_e('Nuevo Pedido', 'tradeexpansion'); ?>
              </h2>
            </div>

            <form @submit.prevent="submitNewOrder" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                  <label
                    class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Proveedor', 'tradeexpansion'); ?></label>
                  <input type="text" x-model="newOrder.proveedor" class="luxury-input w-full"
                    placeholder="Ej: ARGOS Brasil" required>
                </div>
                <div class="space-y-1">
                  <label
                    class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Invoice ID', 'tradeexpansion'); ?></label>
                  <input type="text" x-model="newOrder.invoice" class="luxury-input w-full" placeholder="INV-000"
                    required>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1">
                  <label
                    class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Valor Total', 'tradeexpansion'); ?></label>
                  <input type="number" step="0.01" x-model="newOrder.valor" class="luxury-input w-full" placeholder="0.00"
                    required>
                </div>
                <div class="space-y-1">
                  <label
                    class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Anticipo', 'tradeexpansion'); ?></label>
                  <input type="number" step="0.01" x-model="newOrder.adv" class="luxury-input w-full" placeholder="0.00">
                </div>
                <div class="space-y-1">
                  <label
                    class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Plazo (Días)', 'tradeexpansion'); ?></label>
                  <input type="text" x-model="newOrder.prazo" class="luxury-input w-full" placeholder="30 días">
                </div>
              </div>

              <div class="space-y-1">
                <label
                  class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Fecha Vencimiento', 'tradeexpansion'); ?></label>
                <input type="date" x-model="newOrder.vencimiento" class="luxury-input w-full" required>
              </div>

              <div class="space-y-1">
                <label
                  class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Especificaciones Adicionales', 'tradeexpansion'); ?></label>
                <textarea x-model="newOrder.documentos" rows="3" class="luxury-input w-full resize-none"
                  placeholder="Notas sobre el pedido..."></textarea>
              </div>

              <button type="submit" class="btn-minimalist w-full py-4 mt-4">
                <?php esc_html_e('Confirmar Pedido Prime', 'tradeexpansion'); ?>
              </button>
            </form>
          </div>
        </div>
      </section>

      <!-- JAVASCRIPT -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

      <!-- MODAL: NOVO RELATÓRIO -->
      <div id="newReportModal" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-xl p-6">
        <div class="luxury-card max-w-3xl w-full p-12 relative" @click.away="closeNewReportModal()">
          <button onclick="closeNewReportModal()"
            class="absolute top-8 right-8 text-white/20 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <div class="mb-12">
            <span
              class="label-secondary opacity-40 mb-2 block"><?php esc_html_e('Inteligencia Estratégica', 'tradeexpansion'); ?></span>
            <h3 class="text-xl font-bold text-white"><?php esc_html_e('Nuevo Informe', 'tradeexpansion'); ?>
            </h3>
            <p class="text-white/70 text-sm">
              <?php esc_html_e('Publique información técnica detallada directamente en el portal del cliente.', 'tradeexpansion'); ?>
            </p>
          </div>

          <form id="newReportForm" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div class="space-y-2">
                <label
                  class="label-secondary text-[10px] opacity-40"><?php esc_html_e('Cliente', 'tradeexpansion'); ?></label>
                <select id="report_client" name="client_id" class="luxury-input w-full appearance-none" required>
                  <option value=""><?php esc_html_e('Seleccione Cliente', 'tradeexpansion'); ?></option>
                  <?php
                  $clients = get_users(['role' => 'cliente']);
                  foreach ($clients as $client) {
                    echo '<option value="' . esc_attr($client->ID) . '">' . esc_html($client->display_name) . '</option>';
                  }
                  ?>
                </select>
              </div>

              <!-- Botões -->
              <div class="flex gap-3 pt-4 border-t">
                <button type="button" onclick="closeNewReportModal()"
                  class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg text-secondary font-medium hover:bg-gray-50 transition">
                  <?php esc_html_e('Cancelar', 'tradeexpansion'); ?>
                </button>
                <button type="submit"
                  class="flex-1 px-4 py-3 bg-realce text-white rounded-lg hover:opacity-90 transition font-semibold shadow-lg shadow-realce/30">
                  <?php esc_html_e('✓ Crear Informe', 'tradeexpansion'); ?>
                </button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      function openNewReportModal() {
        const modal = document.getElementById('newReportModal');
        if (modal) {
          modal.style.display = 'flex';
          document.body.style.overflow = 'hidden';
        }
      }

      function closeNewReportModal() {
        const modal = document.getElementById('newReportModal');
        if (modal) {
          modal.style.display = 'none';
          document.body.style.overflow = 'auto';
          const form = document.getElementById('newReportForm');
          if (form) form.reset();
          const label = document.querySelector('label[for="report_pdf"] span');
          if (label) label.textContent = '<?php echo esc_js(__('Haz clic para subir el documento PDF oficial', 'tradeexpansion')); ?>';
        }
      }

      // Feedback de nome de arquivo no upload
      document.addEventListener('change', (e) => {
        if (e.target.id === 'report_pdf') {
          const fileName = e.target.files[0] ? e.target.files[0].name : '<?php echo esc_js(__('Haz clic para subir el documento PDF oficial', 'tradeexpansion')); ?>';
          const span = e.target.nextElementSibling.querySelector('span');
          if (span) span.textContent = fileName;
        }
      });

      // Submit do formulário com feedback visual premium
      document.getElementById('newReportForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = '<?php echo esc_js(__('Publicando...', 'tradeexpansion')); ?>';
        formData.append('client_id', document.getElementById('report_client').value);
        formData.append('status', document.getElementById('report_status').value);
        formData.append('content', document.getElementById('report_content').value);

        const pdfFile = document.getElementById('report_pdf').files[0];
        if (pdfFile) {
          formData.append('pdf', pdfFile);
        }

        try {
          const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
          });

          const result = await response.json();

          if (result.success) {
            alert('✓ Informe creado con éxito!');
            closeNewReportModal();
            location.reload(); // Recarga para mostrar el nuevo informe
          } else {
            alert('✗ Error al crear el informe: ' + result.data);
          }
        } catch (error) {
          alert('✗ Error al crear el informe');
          console.error(error);
        }
      });
    </script>

    <style>
      [x-cloak] {
        display: none !important;
      }
    </style>

  <?php endif; ?>

  <section class="grid md:grid-cols-3 gap-8 mt-24">
    <article class="luxury-card p-10 group">
      <span class="label-secondary mb-4 block"><?php esc_html_e('Projetos', 'tradeexpansion'); ?></span>
      <h2 class="text-2xl font-bold mb-4 group-hover:text-gold transition-colors">
        <?php esc_html_e('Pedidos y materiales', 'tradeexpansion'); ?>
      </h2>
      <p class="text-white/40 text-lg font-light leading-relaxed">
        <?php echo esc_html($projects_placeholder['message']); ?>
      </p>
    </article>
    <article class="luxury-card p-10 group">
      <span class="label-secondary mb-4 block"><?php esc_html_e('Chat Petra', 'tradeexpansion'); ?></span>
      <h2 class="text-2xl font-bold mb-4 group-hover:text-gold transition-colors">
        <?php esc_html_e('Gemini AI', 'tradeexpansion'); ?>
      </h2>
      <p class="text-white/40 text-lg font-light leading-relaxed">
        <?php echo esc_html($chat_placeholder['message']); ?>
      </p>
    </article>
    <article class="luxury-card p-10 group">
      <span class="label-secondary mb-4 block"><?php esc_html_e('KPIs', 'tradeexpansion'); ?></span>
      <h2 class="text-2xl font-bold mb-4 group-hover:text-gold transition-colors">
        <?php esc_html_e('Visão estratégica', 'tradeexpansion'); ?>
      </h2>
      <p class="text-white/40 text-lg font-light leading-relaxed"><?php echo esc_html($kpi_placeholder['message']); ?>
      </p>
    </article>
  </section>


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const i18nDashboard = {
        saveError: '<?php echo esc_js(__('Error al guardar el informe.', 'tradeexpansion')); ?>',
        saveFail: '<?php echo esc_js(__('No se pudo guardar. Inténtelo de nuevo.', 'tradeexpansion')); ?>',
        saving: '<?php echo esc_js(__('Guardando...', 'tradeexpansion')); ?>',
        endpointMissing: '<?php echo esc_js(__('Endpoint no disponible.', 'tradeexpansion')); ?>',
        sending: '<?php echo esc_js(__('Enviando...', 'tradeexpansion')); ?>',
        addPhotos: '<?php echo esc_js(__('Agregar fotos', 'tradeexpansion')); ?>',
        attachFail: '<?php echo esc_js(__('No se pudieron adjuntar las imágenes. Inténtelo de nuevo.', 'tradeexpansion')); ?>',
        mediaUnavailable: '<?php echo esc_js(__('Biblioteca de medios no disponible.', 'tradeexpansion')); ?>',
        mediaTitle: '<?php echo esc_js(__('Seleccionar fotos de la inspección', 'tradeexpansion')); ?>',
        promptMaterial: '<?php echo esc_js(__('Material (nombre o ID). Deje en blanco para mantener lo configurado en cada imagen.', 'tradeexpansion')); ?>',
        promptObservation: '<?php echo esc_js(__('Observación (opcional):', 'tradeexpansion')); ?>',
        attachError: '<?php echo esc_js(__('Error al adjuntar imágenes.', 'tradeexpansion')); ?>',
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
              : reportContainer.dataset.emptyNote || 'Sin observaciones registradas.';
          }
        };

        reportContainer.dataset.emptyNote = '<?php echo esc_js(__('Sin observaciones registradas.', 'tradeexpansion')); ?>';

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

  </div>
  </div>
</main>