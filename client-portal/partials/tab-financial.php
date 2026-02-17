/**
* Tab: Financial
*/
if (!isset($active_tab, $can_view_financial)) {
return;
}

// Idioma baseado no cliente
$is_spanish_client = false;
if (isset($current_user)) {
$client_name = $current_user->display_name;
if (stripos($client_name, 'Magma') !== false || stripos($client_name, 'Global Marmol') !== false) {
$is_spanish_client = true;
}
}

$labels = [
'title' => $is_spanish_client ? 'Gestión Financiera' : 'Gestão Financeira',
'subtitle' => $is_spanish_client ? 'Control de pagos, créditos y plazos' : 'Controle de pagamentos, créditos e prazos',
'new_order' => $is_spanish_client ? 'Nuevo Pedido' : 'Novo Pedido',
'pending' => $is_spanish_client ? 'Pendiente' : 'Pendente',
'pending_note' => $is_spanish_client ? 'Valor total pendiente de pago' : 'Valor total pendente de pagamento',
'invoices_open' => $is_spanish_client ? 'invoices abiertos' : 'invoices abertas',
'credit' => $is_spanish_client ? 'Crédito' : 'Crédito',
'credit_note' => $is_spanish_client ? 'Crédito que la fábrica debe reembolsar' : 'Crédito que a fábrica deve
reembolsar',
'israel_credit' => $is_spanish_client ? 'A favor de Israel' : 'A favor do Cliente',
'next' => $is_spanish_client ? 'Próximo' : 'Próximo',
'total_paid' => $is_spanish_client ? 'Total Pagado' : 'Total Pago',
'payments_realized' => $is_spanish_client ? 'pagos realizados' : 'pagamentos realizados',
'status_title' => $is_spanish_client ? 'Estado de Pagos' : 'Status de Pagamentos',
'suppliers_title' => $is_spanish_client ? 'Top 5 Proveedores' : 'Top 5 Fornecedores',
'details_title' => $is_spanish_client ? 'Invoices Detalladas' : 'Invoices Detalhadas',
'history' => $is_spanish_client ? 'Historial de transacciones e estados' : 'Histórico de transações e status',
'close_view' => $is_spanish_client ? 'Cerrar vista completa' : 'Fechar vista completa',
'open_view' => $is_spanish_client ? 'Ver planilla completa' : 'Ver planilha completa',
'supplier' => $is_spanish_client ? 'Proveedor' : 'Fornecedor',
'invoice' => $is_spanish_client ? 'Invoice' : 'Invoice',
'value' => $is_spanish_client ? 'Valor' : 'Valor',
'due_date' => $is_spanish_client ? 'Vencimiento' : 'Vencimento',
'status' => $is_spanish_client ? 'Estado' : 'Status',
'balance' => $is_spanish_client ? 'Saldo' : 'Saldo',
'paid' => $is_spanish_client ? 'PAGADO' : 'PAGO',
'pending_status' => $is_spanish_client ? 'PENDIENTE' : 'PENDENTE',
];
?>

<section data-tab-panel="financial" class="space-y-6 <?php echo $active_tab === 'financial' ? '' : 'hidden'; ?>"
  x-data="financialDashboard()">
  <!-- CABEÇALHO -->
  <div class="flex items-center justify-between border-b border-white/5 pb-6">
    <div>
      <h2 class="text-3xl font-bold text-white"><?php echo $labels['title']; ?></h2>
      <p class="text-white/40 text-sm font-light italic mt-1">
        <?php echo $labels['subtitle']; ?>
      </p>
    </div>
    <button @click="showNewOrderModal = true" class="btn-minimalist">
      <?php echo $labels['new_order']; ?>
    </button>
  </div>

  <!-- KPIs -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="luxury-card p-10 group">
      <div class="flex items-center justify-between mb-6">
        <span class="label-secondary"
          title="<?php echo $labels['pending_note']; ?>"><?php echo $labels['pending']; ?></span>
        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 group-hover:shadow-[0_0_10px_#fbbf24] transition-all"></div>
      </div>
      <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalAbierto)">$0</p>
      <p class="label-secondary opacity-40 mt-4"
        x-text="totalInvoicesPendientes + ' <?php echo $labels['invoices_open']; ?>'">0 invoices</p>
    </div>

    <div class="luxury-card p-10 group">
      <div class="flex items-center justify-between mb-6">
        <span class="label-secondary"
          title="<?php echo $labels['credit_note']; ?>"><?php echo $labels['credit']; ?></span>
        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 group-hover:shadow-[0_0_10px_#34d399] transition-all"></div>
      </div>
      <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalCredito)">$0</p>
      <p class="label-secondary opacity-40 mt-4"><?php echo $labels['israel_credit']; ?></p>
    </div>

    <div class="luxury-card p-10 group">
      <div class="flex items-center justify-between mb-6">
        <span class="label-secondary"><?php echo $labels['next']; ?></span>
        <div class="w-1.5 h-1.5 rounded-full bg-rose-400 group-hover:shadow-[0_0_10px_#f87171] transition-all"></div>
      </div>
      <p class="text-3xl font-bold text-white tracking-tighter" x-text="proximoVencimiento || 'N/A'">--</p>
      <p class="label-secondary opacity-40 mt-4"
        x-text="diasProximoVencimiento || (isSpanish ? 'Sin vencimientos' : 'Sem vencimentos')"></p>
    </div>

    <div class="luxury-card p-10 group">
      <div class="flex items-center justify-between mb-6">
        <span class="label-secondary"><?php echo $labels['total_paid']; ?></span>
        <div class="w-1.5 h-1.5 rounded-full bg-blue-400 group-hover:shadow-[0_0_10px_#60a5fa] transition-all"></div>
      </div>
      <p class="text-5xl font-bold text-white tracking-tighter" x-text="'$' + formatCurrency(totalPagado)">$0</p>
      <p class="label-secondary opacity-40 mt-4"
        x-text="totalInvoicesPagos + ' <?php echo $labels['payments_realized']; ?>'">0 pagos</p>
    </div>
  </div>

  <!-- GRÁFICOS -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="luxury-card p-10">
      <h3 class="editorial-title text-sm mb-10 opacity-60"><?php esc_html_e('Estado de Pagos', 'tradeexpansion'); ?>
      </h3>
      <div class="h-[300px]"><canvas id="paymentStatusChart"></canvas></div>
    </div>
    <div class="luxury-card p-10">
      <h3 class="editorial-title text-sm mb-10 opacity-60"><?php esc_html_e('Top 5 Proveedores', 'tradeexpansion'); ?>
      </h3>
      <div class="h-[300px]"><canvas id="suppliersChart"></canvas></div>
    </div>
  </div>

  <!-- TABELA COMPLETA -->
  <div class="luxury-card overflow-hidden">
    <div class="p-10 border-b border-white/5 flex items-center justify-between">
      <div>
        <h3 class="text-2xl font-bold text-white"><?php esc_html_e('Invoices Detalladas', 'tradeexpansion'); ?></h3>
        <p class="label-secondary opacity-40 mt-1">
          <?php esc_html_e('Historial de transacciones e estados', 'tradeexpansion'); ?>
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
            <th class="px-8 py-6 label-secondary opacity-40"><?php echo $labels['supplier']; ?></th>
            <th class="px-8 py-6 label-secondary opacity-40 text-center">
              <?php echo $labels['invoice']; ?>
            </th>
            <th class="px-8 py-6 label-secondary opacity-40 text-right"><?php echo $labels['value']; ?>
            </th>
            <th class="px-8 py-6 label-secondary opacity-40 text-center">
              <?php echo $labels['due_date']; ?>
            </th>
            <th class="px-8 py-6 label-secondary opacity-40 text-center">
              <?php echo $labels['status']; ?>
            </th>
            <th class="px-8 py-6 label-secondary opacity-40 text-right"><?php echo $labels['balance']; ?>
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
                  x-text="row['FECHA PAGO'] ? '<?php echo $labels['paid']; ?>' : '<?php echo $labels['pending_status']; ?>'"></span>
              </td>
              <td class="px-8 py-8 text-right font-bold text-emerald-400"
                :class="parseFloat(row['SALDO ABIERTO'] || 0) > 0 ? 'text-rose-400' : 'text-emerald-400'"
                x-text="'$' + formatCurrency(row['SALDO ABIERTO'])"></td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div x-show="showFullSheet" class="p-4 bg-gray-50">
      <div class="bg-white rounded-lg border-2 border-primary/20 overflow-hidden">
        <iframe src="https://docs.google.com/spreadsheets/d/<?php echo esc_attr($sheet_id); ?>/edit?usp=sharing"
          class="w-full" style="height: 700px; border: none;" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>