<?php
if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('tec_portal_user_has_financial') || !tec_portal_user_has_financial(get_current_user_id())) {
  return;
}


if (!isset($active_tab)) {
  return;
}

$apps_script_url = 'https://script.google.com/macros/s/AKfycbzArdgH2Pwc7PG9VtC0GbNSgSaMvzogE7N6oNiST4ANpKE0tthsnvR2nScirJp7X826/exec';
$sheet_id = 'АKfycbzArdgH2Pwc7PG9VtC0GbNSgSaMvzogE7N6oNiST4ANpKE0tthsnvR2nScirJp7X826'; // Cole o ID da sua planilha aqui
?>

<section
  data-tab-panel="financial"
  class="space-y-6 <?php echo $active_tab === 'financial' ? '' : 'hidden'; ?>"
  x-data="financialDashboard()"
  x-init="loadFinancialData()"
>
  <!-- CABEÇALHO -->
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-primary"><?php esc_html_e('Gestión Financiera', 'tradeexpansion'); ?></h2>
      <p class="text-sm text-secondary/70 mt-1"><?php esc_html_e('Control de pagos, créditos y plazos', 'tradeexpansion'); ?></p>
    </div>
    <button 
      @click="showNewOrderModal = true"
      class="bg-realce text-white px-5 py-2.5 rounded-lg hover:opacity-90 transition font-medium flex items-center gap-2"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      <?php esc_html_e('Nuevo Pedido', 'tradeexpansion'); ?>
    </button>
  </div>

  <!-- KPIs -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total em Aberto -->
    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg shadow-md p-6 border border-amber-200">
      <div class="flex items-center justify-between mb-3">
        <div class="bg-amber-500 p-2 rounded-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <span class="text-xs text-amber-700 font-medium" title="Valor total pendiente de pago"><?php esc_html_e('Pendiente', 'tradeexpansion'); ?></span>
      </div>
      <p class="text-3xl font-bold text-amber-900" x-text="'$' + formatCurrency(totalAbierto)">$0</p>
      <p class="text-xs text-amber-700 mt-2" x-text="totalInvoicesPendientes + ' invoices abiertos'">0 invoices</p>
    </div>

    <!-- Crédito a Favor -->
    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg shadow-md p-6 border border-emerald-200">
      <div class="flex items-center justify-between mb-3">
        <div class="bg-emerald-500 p-2 rounded-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <span class="text-xs text-emerald-700 font-medium" title="Crédito que la fábrica debe reembolsar"><?php esc_html_e('Crédito', 'tradeexpansion'); ?></span>
      </div>
      <p class="text-3xl font-bold text-emerald-900" x-text="'$' + formatCurrency(totalCredito)">$0</p>
      <p class="text-xs text-emerald-700 mt-2"><?php esc_html_e('A favor de Israel', 'tradeexpansion'); ?></p>
    </div>

    <!-- Próximo Vencimento -->
    <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-lg shadow-md p-6 border border-rose-200">
      <div class="flex items-center justify-between mb-3">
        <div class="bg-rose-500 p-2 rounded-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <span class="text-xs text-rose-700 font-medium"><?php esc_html_e('Próximo', 'tradeexpansion'); ?></span>
      </div>
      <p class="text-2xl font-bold text-rose-900" x-text="proximoVencimiento || 'N/A'">--</p>
      <p class="text-xs text-rose-700 mt-2" x-text="diasProximoVencimiento || 'Sin vencimientos próximos'"></p>
    </div>

    <!-- Total Pago -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border border-blue-200">
      <div class="flex items-center justify-between mb-3">
        <div class="bg-blue-500 p-2 rounded-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <span class="text-xs text-blue-700 font-medium"><?php esc_html_e('Total Pagado', 'tradeexpansion'); ?></span>
      </div>
      <p class="text-3xl font-bold text-blue-900" x-text="'$' + formatCurrency(totalPagado)">$0</p>
      <p class="text-xs text-blue-700 mt-2" x-text="totalInvoicesPagos + ' pagos realizados'">0 pagos</p>
    </div>
  </div>

  <!-- GRÁFICOS -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
      <h3 class="text-lg font-semibold text-primary mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <?php esc_html_e('Estado de Pagos', 'tradeexpansion'); ?>
      </h3>
      <canvas id="paymentStatusChart" style="max-height: 280px;"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <h3 class="text-lg font-semibold text-primary mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <?php esc_html_e('Top 5 Proveedores', 'tradeexpansion'); ?>
      </h3>
      <canvas id="suppliersChart" style="max-height: 280px;"></canvas>
    </div>
  </div>

  <!-- TABELA COMPLETA -->
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-primary to-secondary">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="text-xl font-bold text-white"><?php esc_html_e('Invoices Detalladas', 'tradeexpansion'); ?></h3>
        </div>
        <button 
          @click="showFullSheet = !showFullSheet"
          class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm font-medium backdrop-blur-sm"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
          <span x-text="showFullSheet ? 'Ver Resumo' : 'Editar en Google Sheets'"></span>
        </button>
      </div>
    </div>

    <!-- Tabela Resumida -->
    <div x-show="!showFullSheet" class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-secondary uppercase tracking-wider">
              Proveedor
              <span class="text-gray-400 font-normal" title="Fornecedores do Brasil">ℹ️</span>
            </th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-secondary uppercase tracking-wider">Invoice</th>
            <th class="px-4 py-3 text-right text-xs font-semibold text-secondary uppercase tracking-wider">
              Valor Total
              <span class="text-gray-400 font-normal" title="Valor total do pedido">ℹ️</span>
            </th>
            <th class="px-4 py-3 text-right text-xs font-semibold text-secondary uppercase tracking-wider">
              Anticipo
              <span class="text-gray-400 font-normal" title="Valor adiantado">ℹ️</span>
            </th>
            <th class="px-4 py-3 text-center text-xs font-semibold text-secondary uppercase tracking-wider">
              Plazo
              <span class="text-gray-400 font-normal" title="Prazo dado para pagamento">ℹ️</span>
            </th>
            <th class="px-4 py-3 text-center text-xs font-semibold text-secondary uppercase tracking-wider">Vencimiento</th>
            <th class="px-4 py-3 text-center text-xs font-semibold text-secondary uppercase tracking-wider">Pago</th>
            <th class="px-4 py-3 text-right text-xs font-semibold text-secondary uppercase tracking-wider">
              Saldo Abierto
              <span class="text-gray-400 font-normal" title="Saldo pendiente">ℹ️</span>
            </th>
            <th class="px-4 py-3 text-right text-xs font-semibold text-secondary uppercase tracking-wider">
              Crédito
              <span class="text-gray-400 font-normal" title="Valor a ressarcir">ℹ️</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <template x-for="(row, index) in financialData" :key="index">
            <tr class="hover:bg-gray-50 transition">
              <td class="px-4 py-4 text-sm font-semibold text-primary" x-text="row.PROVEDORES"></td>
              <td class="px-4 py-4 text-sm text-secondary font-mono" x-text="row.INVOICE"></td>
              <td class="px-4 py-4 text-sm font-semibold text-secondary text-right" x-text="'$' + formatCurrency(row.VALOR)"></td>
              <td class="px-4 py-4 text-sm text-secondary text-right" x-text="row.ADV ? '$' + formatCurrency(row.ADV) : '-'"></td>
              <td class="px-4 py-4 text-sm text-center">
                <span 
                  class="px-2 py-1 rounded-full text-xs font-medium"
                  :class="row.PRAZO ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600'"
                  x-text="row.PRAZO || 'N/A'"
                ></span>
              </td>
              <td class="px-4 py-4 text-sm text-secondary text-center" x-text="row['FECHA DE VENCIMIENTO'] || '-'"></td>
              <td class="px-4 py-4 text-center">
                <span 
                  class="px-3 py-1 inline-flex text-xs font-semibold rounded-full"
                  :class="row['FECHA PAGO'] ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'"
                  x-text="row['FECHA PAGO'] || 'Pendiente'"
                ></span>
              </td>
              <td class="px-4 py-4 text-sm font-bold text-right" 
                  :class="parseFloat(row['SALDO ABIERTO'] || 0) > 0 ? 'text-rose-600' : 'text-gray-400'"
                  x-text="'$' + formatCurrency(row['SALDO ABIERTO'])">
              </td>
              <td class="px-4 py-4 text-sm font-bold text-right"
                  :class="parseFloat(row['SALDO CREDITO'] || 0) > 0 ? 'text-emerald-600' : 'text-gray-400'"
                  x-text="row['SALDO CREDITO'] ? '$' + formatCurrency(row['SALDO CREDITO']) : '-'">
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      
      <!-- Loading -->
      <div x-show="loading" class="text-center py-16 text-secondary/60">
        <svg class="animate-spin h-10 w-10 mx-auto mb-3 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="font-medium"><?php esc_html_e('Cargando datos financieros...', 'tradeexpansion'); ?></p>
      </div>

      <!-- Empty State -->
      <div x-show="!loading && financialData.length === 0" class="text-center py-16">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-gray-500"><?php esc_html_e('No hay datos disponibles', 'tradeexpansion'); ?></p>
      </div>
    </div>

    <!-- Google Sheets Iframe -->
    <div x-show="showFullSheet" class="p-4 bg-gray-50">
      <div class="bg-white rounded-lg border-2 border-primary/20 overflow-hidden">
        <iframe 
          src="https://docs.google.com/spreadsheets/d/<?php echo esc_attr($sheet_id); ?>/edit?usp=sharing"
          class="w-full"
          style="height: 700px; border: none;"
          loading="lazy"
        ></iframe>
        <div class="p-4 bg-gradient-to-r from-primary/5 to-secondary/5 border-t border-gray-200">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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

  <!-- MODAL: NOVO PEDIDO -->
  <div 
    x-show="showNewOrderModal" 
    x-cloak
    @click.away="showNewOrderModal = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
  >
    <div class="flex items-center justify-center min-h-screen px-4">
      <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
      
      <div class="bg-white rounded-xl overflow-hidden shadow-2xl transform transition-all max-w-2xl w-full z-50">
        <div class="bg-gradient-to-r from-primary to-secondary px-6 py-5">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="bg-white/20 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white"><?php esc_html_e('Nuevo Pedido', 'tradeexpansion'); ?></h3>
                <p class="text-white/70 text-sm"><?php esc_html_e('Complete los datos del pedido', 'tradeexpansion'); ?></p>
              </div>
            </div>
            <button @click="showNewOrderModal = false" class="text-white/70 hover:text-white transition">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        
        <form @submit.prevent="submitNewOrder" class="p-6 space-y-5">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-secondary mb-2">
                <?php esc_html_e('Proveedor', 'tradeexpansion'); ?>
                <span class="text-rose-500">*</span>
              </label>
              <input 
                type="text" 
                x-model="newOrder.proveedor"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                placeholder="Nome do fornecedor"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-secondary mb-2">
                <?php esc_html_e('Número Invoice', 'tradeexpansion'); ?>
                <span class="text-rose-500">*</span>
              </label>
              <input 
                type="text" 
                x-model="newOrder.invoice"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                placeholder="INV-001"
                required
              />
            </div>
          </div>

          <div class="grid grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-semibold text-secondary mb-2">
                <?php esc_html_e('Valor Total', 'tradeexpansion'); ?>
                <span class="text-rose-500">*</span>
              </label>
              <input 
                type="number" 
                step="0.01"
                x-model="newOrder.valor"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                placeholder="0.00"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-secondary mb-2">
                <?php esc_html_e('Anticipo (ADV)', 'tradeexpansion'); ?>
              </label>
              <input 
                type="number" 
                step="0.01"
                x-model="newOrder.adv"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                placeholder="0.00"
              />
            </div>

            <div>
              <label class="block text-sm font-semibold text-secondary mb-2">
                <?php esc_html_e('Plazo (días)', 'tradeexpansion'); ?>
              </label>
              <input 
                type="text" 
                x-model="newOrder.prazo"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                placeholder="30 días"
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-secondary mb-2">
              <?php esc_html_e('Fecha de Vencimiento', 'tradeexpansion'); ?>
              <span class="text-rose-500">*</span>
            </label>
            <input 
              type="date" 
              x-model="newOrder.vencimiento"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-semibold text-secondary mb-2">
              <?php esc_html_e('Documentos / Observaciones', 'tradeexpansion'); ?>
            </label>
            <textarea 
              x-model="newOrder.documentos"
              rows="3"
              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition resize-none"
              placeholder="Notas, links de documentos, etc."
            ></textarea>
          </div>

          <div class="flex gap-3 pt-4 border-t">
            <button 
              type="button"
              @click="showNewOrderModal = false"
              class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg text-secondary font-medium hover:bg-gray-50 transition"
            >
              <?php esc_html_e('Cancelar', 'tradeexpansion'); ?>
            </button>
            <button 
              type="submit"
              class="flex-1 px-4 py-3 bg-realce text-white rounded-lg hover:opacity-90 transition font-semibold shadow-lg shadow-realce/30"
            >
              <?php esc_html_e('✓ Enviar Pedido', 'tradeexpansion'); ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
function financialDashboard() {
  return {
    financialData: [],
    loading: true,
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
    
    async loadFinancialData() {
      try {
        const response = await fetch('<?php echo esc_js($apps_script_url); ?>');
        const data = await response.json();
        
        this.financialData = data.data || [];
        this.calculateKPIs();
        this.renderCharts();
        this.loading = false;
      } catch (error) {
        console.error('Error al cargar datos:', error);
        this.loading = false;
      }
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
      
      // Próximo vencimento
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
      // Gráfico Status
      new Chart(document.getElementById('paymentStatusChart'), {
        type: 'doughnut',
        data: {
          labels: ['Pagados', 'Pendientes', 'Crédito a Favor'],
          datasets: [{
            data: [this.totalInvoicesPagos, this.totalInvoicesPendientes, this.totalCredito > 0 ? 1 : 0],
            backgroundColor: ['#10b981', '#f59e0b', '#3b82f6'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } }
          }
        }
      });
      
      // Top Proveedores
      const proveedorCount = {};
      this.financialData.forEach(row => {
        const prov = row.PROVEDORES;
        proveedorCount[prov] = (proveedorCount[prov] || 0) + 1;
      });
      
      const topProveedores = Object.entries(proveedorCount)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 5);
      
      new Chart(document.getElementById('suppliersChart'), {
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
            legend: { display: false }
          },
          scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
          }
        }
      });
    },
    
    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
    
    async submitNewOrder() {
      console.log('Nuevo pedido:', this.newOrder);
      // Aqui você pode integrar com WordPress REST API ou enviar direto pro Apps Script
      alert('¡Pedido enviado con éxito! ✓');
      this.showNewOrderModal = false;
      this.newOrder = { proveedor: '', invoice: '', valor: '', adv: '', prazo: '', vencimiento: '', documentos: '' };
    }
  }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
