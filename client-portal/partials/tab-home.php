<?php
/**
 * Tab: Home (KPIs & Insights)
 */
if (!defined('ABSPATH')) exit;

// Idioma baseado no cliente: Magma e Global Marmol -> Espanhol. Restante -> Português.
$is_spanish_client = false; 
$client_name = $current_user->display_name;
if (stripos($client_name, 'Magma') !== false || stripos($client_name, 'Global Marmol') !== false) {
    $is_spanish_client = true;
}

$labels = [
    'title' => $is_spanish_client ? 'Panel Estratégico' : 'Painel Estratégico',
    'subtitle' => $is_spanish_client ? 'Análisis de datos e indicadores de performance.' : 'Análise de dados e indicadores de performance.',
    'inspections' => $is_spanish_client ? 'Inspecciones' : 'Inspeções',
    'quality' => $is_spanish_client ? 'Calidad' : 'Qualidade',
    'mix' => $is_spanish_client ? 'Mix de Pedidos' : 'Mix de Pedidos',
    'logistics' => $is_spanish_client ? 'Logística' : 'Logística',
    'total' => $is_spanish_client ? 'Total realizado' : 'Total realizado',
    'approval' => $is_spanish_client ? 'Tasa de aprobación' : 'Taxa de aprovação',
    'materials' => $is_spanish_client ? 'Materiales diferentes' : 'Materiais diferentes',
    'active' => $is_spanish_client ? 'Activo' : 'Ativo',
    'monitoring' => $is_spanish_client ? 'Monitoreo en tiempo real' : 'Monitoramento em tempo real',
    'trend_title' => $is_spanish_client ? 'Tendencia de Inspecciones' : 'Volume de Inspeções por Mês',
    'dist_title' => $is_spanish_client ? 'Distribución por Material' : 'Distribuição por Material',
];
?>

<div class="space-y-12">
    <!-- KPI Header -->
    <div class="flex flex-col gap-2 border-b border-white/5 pb-6">
        <h2 class="text-3xl font-bold text-white"><?php echo $labels['title']; ?></h2>
        <p class="text-white/40 text-sm font-light italic">
            <?php echo $labels['subtitle']; ?>
        </p>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total de Inspeções -->
        <div class="luxury-card p-8 group">
            <div class="flex items-center justify-between mb-4">
                <span class="label-secondary"><?php echo $labels['inspections']; ?></span>
                <div class="w-2 h-2 rounded-full bg-gold transition-all group-hover:shadow-[0_0_10px_#D6A354]"></div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter"><?php echo count($inspections); ?></p>
            <p class="label-secondary opacity-40 mt-4"><?php echo $labels['total']; ?></p>
        </div>

        <!-- Relatórios Aprovados -->
        <?php 
        $aprovados = array_filter($reports, function($r) { return strtolower($r['status_slug'] ?? '') === 'aprovado'; });
        $taxa_aprovacao = count($reports) > 0 ? (count($aprovados) / count($reports)) * 100 : 0;
        ?>
        <div class="luxury-card p-8 group">
            <div class="flex items-center justify-between mb-4">
                <span class="label-secondary"><?php echo $labels['quality']; ?></span>
                <div class="w-2 h-2 rounded-full bg-emerald-400 transition-all group-hover:shadow-[0_0_10px_#34d399]"></div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter"><?php echo number_format($taxa_aprovacao, 0); ?>%</p>
            <p class="label-secondary opacity-40 mt-4"><?php echo $labels['approval']; ?></p>
        </div>

        <!-- Materiais Únicos -->
        <?php 
        $materiais = [];
        foreach($inspections as $ins) {
            if (!empty($ins['materials'])) {
                foreach($ins['materials'] as $m) {
                    $materiais[] = $m['name'];
                }
            }
        }
        $materiais_unicos = count(array_unique($materiais));
        ?>
        <div class="luxury-card p-8 group">
            <div class="flex items-center justify-between mb-4">
                <span class="label-secondary"><?php echo $labels['mix']; ?></span>
                <div class="w-2 h-2 rounded-full bg-blue-400 transition-all group-hover:shadow-[0_0_10px_#60a5fa]"></div>
            </div>
            <p class="text-5xl font-bold text-white tracking-tighter"><?php echo $materiais_unicos; ?></p>
            <p class="label-secondary opacity-40 mt-4"><?php echo $labels['materials']; ?></p>
        </div>

        <div class="luxury-card p-8 group">
            <div class="flex items-center justify-between mb-4">
                <span class="label-secondary"><?php echo $labels['logistics']; ?></span>
                <div class="w-2 h-2 rounded-full bg-rose-400 transition-all group-hover:shadow-[0_0_10px_#f87171]"></div>
            </div>
            <p class="text-3xl font-bold text-white tracking-tighter"><?php echo $labels['active']; ?></p>
            <p class="label-secondary opacity-40 mt-4"><?php echo $labels['monitoring']; ?></p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="luxury-card p-8">
            <h3 class="editorial-title text-sm mb-8 opacity-60"><?php echo $labels['trend_title']; ?></h3>
            <div class="h-[300px] relative">
                <canvas id="inspectionsTrendChart"></canvas>
            </div>
        </div>
        <div class="luxury-card p-8">
            <h3 class="editorial-title text-sm mb-8 opacity-60"><?php echo $labels['dist_title']; ?></h3>
            <div class="h-[300px] relative">
                <canvas id="materialsDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxTrend = document.getElementById('inspectionsTrendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: ['Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'],
            datasets: [{
                label: 'Inspeções',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: '#D6A354',
                backgroundColor: 'rgba(214, 163, 84, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.3)' } },
                x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.3)' } }
            }
        }
    });

    const ctxDist = document.getElementById('materialsDistributionChart').getContext('2d');
    new Chart(ctxDist, {
        type: 'doughnut',
        data: {
            labels: ['Granito', 'Quartzito', 'Mármore'],
            datasets: [{
                data: [45, 30, 25],
                backgroundColor: ['#D6A354', '#10b981', '#3b82f6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.5)', padding: 20 } }
            }
        }
    });
});
</script>