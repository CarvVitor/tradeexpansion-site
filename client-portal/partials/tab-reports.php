<?php
/**
 * Tab: Reports
 */
if (!isset($reports, $active_tab)) {
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
    'no_reports' => $is_spanish_client ? 'No hay informes registrados para este cliente hasta ahora.' : 'Não há relatórios registrados para este cliente até agora.',
    'published' => $is_spanish_client ? 'Publicado em %s' : 'Publicado em %s',
    'no_obs' => $is_spanish_client ? 'Sin observaciones registradas.' : 'Sem observações registradas.',
    'download' => $is_spanish_client ? 'Descargar PDF' : 'Baixar PDF',
    'edit' => $is_spanish_client ? 'Editar' : 'Editar',
    'footer_note' => $is_spanish_client ? 'Los informes son generados por el equipo técnico de Trade Expansion.' : 'Os relatórios são gerados pela equipe técnica da Trade Expansion.',
    'admin_area' => $is_spanish_client ? 'Área Administrativa' : 'Área Administrativa',
    'manage_content' => $is_spanish_client ? 'Gestionar Contenido' : 'Gerenciar Conteúdo',
    'new_report' => $is_spanish_client ? 'Nuevo Informe' : 'Novo Relatório',
];
?>

<section data-tab-panel="reports" class="space-y-6 <?php echo $active_tab === 'reports' ? '' : 'hidden'; ?>">
    <?php if (empty($reports)): ?>
        <p class="text-white/30 italic text-center py-10">
            <?php echo $labels['no_reports']; ?>
        </p>
    <?php endif; ?>

    <?php foreach ($reports as $report): ?>
        <article class="luxury-card p-8 flex flex-col md:flex-row md:items-center justify-between gap-8 group">
            <div>
                <span class="label-secondary mb-2 block">
                    <?php printf($labels['published'], esc_html(date_i18n('d M Y', strtotime($report['date'])))); ?>
                </span>
                <h3 class="text-3xl font-bold text-white mb-2 group-hover:text-gold transition-colors"
                    data-report-title="<?php echo (int) ($report['post_id'] ?? 0); ?>">
                    <?php echo esc_html($report['title']); ?>
                </h3>
                <p class="text-white/40 text-lg font-light leading-relaxed max-w-2xl report-note"
                    data-report-note="<?php echo (int) ($report['post_id'] ?? 0); ?>">
                    <?php echo $report['note'] ? esc_html($report['note']) : $labels['no_obs']; ?>
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

                $status_label = $report['status']; // Mantém o status original (geralmente já vem traduzido do banco/lógica)
                ?>
                <span class="label-secondary <?php echo $status_color; ?> px-4 py-2 border border-current opacity-60">
                    <?php echo esc_html($status_label); ?>
                </span>

                <?php if (!empty($report['post_id'])): ?>
                    <a class="btn-minimalist"
                        href="<?php echo esc_url(tec_relatorio_pdf_url((int) $report['post_id'], true)); ?>" target="_blank"
                        rel="noopener">
                        <?php echo $labels['download']; ?>
                    </a>
                <?php endif; ?>

                <?php if ($can_edit_reports && !empty($report['post_id'])): ?>
                    <button type="button" class="btn-minimalist report-inline-edit-btn"
                        data-report-id="<?php echo (int) $report['post_id']; ?>">
                        <?php echo $labels['edit']; ?>
                    </button>
                <?php endif; ?>

                <button type="button" class="btn-minimalist opacity-50 hover:opacity-100"
                    onclick="openChatWithContext('<?php echo esc_js($report['title']); ?>')">
                    ?
                </button>
            </div>
        </article>
    <?php endforeach; ?>

    <p class="text-xs text-secondary/60 italic text-center">
        <?php echo $labels['footer_note']; ?>
    </p>

    <?php if ($can_edit_reports): ?>
        <div class="mt-12 bg-white/5 border border-dashed border-white/10 p-8 rounded-lg">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <p class="label-secondary mb-2"><?php echo $labels['admin_area']; ?></p>
                    <h4 class="text-xl font-bold text-white"><?php echo $labels['manage_content']; ?></h4>
                </div>
                <button type="button" onclick="openNewReportModal()"
                    class="btn-minimalist bg-gold text-primary-dark border-none">
                    <?php echo $labels['new_report']; ?>
                </button>
            </div>
        </div>
    <?php endif; ?>
</section>