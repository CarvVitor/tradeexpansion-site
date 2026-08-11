<?php
/**
 * Template Name: Global Marmol Portal
 * Description: Premium Portal with Google Sheets Integration
 */

// ============================================
// AUTHENTICATION & ACCESS CONTROL
// ============================================
if (!is_user_logged_in()) {
    wp_redirect(home_url('/area-do-cliente'));
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_display_name = $current_user->display_name ?: $current_user->user_login;

// Get user permissions (stored in user meta)
$can_view_favorita = get_user_meta($user_id, 'gm_can_view_favorita', true) ?: false;
$can_view_policast = get_user_meta($user_id, 'gm_can_view_policast', true) ?: false;
$can_view_management = get_user_meta($user_id, 'gm_can_view_management', true) ?: current_user_can('manage_options');

// For development: grant all permissions to admins
if (current_user_can('manage_options')) {
    $can_view_favorita = true;
    $can_view_policast = true;
    $can_view_management = true;
}

// Mock data for suppliers (replace with real data later)
$favorita_data = [
    ["m" => "Calacatta Borghini", "b" => "BL-902", "bn" => "01", "p" => 185.00, "i" => "https://images.unsplash.com/photo-1628155930542-3c7a64e2c833?auto=format&fit=crop&q=80&w=800"],
    ["m" => "Statuario Extra", "b" => "BL-774", "bn" => "03", "p" => 210.00, "i" => "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=800"],
];

$policast_data = [
    ["m" => "Gris Corumbá", "b" => "", "bn" => "Primero Paquete", "p" => 15.00, "i" => "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=800"],
];

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />

    <title>Portal Global Marmol | Trade Expansion</title>

    <!-- Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Vollkorn:ital,wght@0,400..900;1,400..900&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Export Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        :root {
            /* Trade Expansion Base */
            --te-green: #102724;
            --te-green-dark: #0b1d1b;
            --te-gold: #D6A354;

            /* Global Marmol Identity */
            --gm-copper: #CB9D54;
            --gm-navy: #1F2230;

            /* Theme Variables (Dark by default) */
            --theme-bg: #102724;
            --theme-bg-secondary: #0b1d1b;
            --theme-text: #F1F1D9;
            --theme-text-secondary: #a8b0bf;
            --theme-card-bg: rgba(16, 39, 36, 0.85);
            --theme-border: rgba(255, 255, 255, 0.08);
            --theme-shadow: rgba(0, 0, 0, 0.3);
        }

        /* Light Theme */
        body.light-theme {
            --theme-bg: #F5F1E8;
            --theme-bg-secondary: #E8E4D9;
            --theme-text: #2C2416;
            --theme-text-secondary: #6B5D4F;
            --theme-card-bg: rgba(255, 255, 255, 0.9);
            --theme-border: rgba(0, 0, 0, 0.08);
            --theme-shadow: rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--theme-bg);
            background-image:
                radial-gradient(circle at 0% 0%, rgba(203, 157, 84, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(31, 34, 48, 0.2) 0%, transparent 50%);
            background-attachment: fixed;
            color: var(--theme-text);
            min-height: 100vh;
            padding-top: 100px;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        .editorial {
            font-family: 'Vollkorn', serif;
        }

        /* Header */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: rgba(11, 29, 27, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--theme-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 60px;
            z-index: 1000;
        }

        .logos-wrapper {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .logo-te {
            height: 32px;
            opacity: 0.9;
        }

        .divider {
            height: 30px;
            width: 1px;
            background: var(--theme-border);
        }

        .logo-client {
            height: 45px;
        }

        .user-meta {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--te-gold);
            font-weight: 700;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        body.is-mgmt .container {
            max-width: 98% !important;
        }

        /* Hero */
        .hero {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInDown 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero h1 {
            font-size: clamp(40px, 6vw, 72px);
            margin: 0 0 20px;
            line-height: 1;
            font-weight: 400;
            font-style: italic;
        }

        .hero h1 span {
            color: var(--gm-copper);
            display: block;
            font-style: normal;
            font-weight: 800;
            letter-spacing: -0.03em;
            text-transform: uppercase;
        }

        /* Tabs */
        .tab-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: transparent;
            border: 1px solid var(--theme-border);
            color: var(--theme-text-secondary);
            padding: 12px 28px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
        }

        .tab-btn:hover {
            border-color: var(--gm-copper);
            color: var(--theme-text);
        }

        .tab-btn.active {
            background: var(--gm-copper);
            border-color: var(--gm-copper);
            color: var(--te-green);
        }

        /* Masonry Grid */
        .masonry-grid {
            column-count: 3;
            column-gap: 30px;
        }

        .grid-item {
            break-inside: avoid;
            margin-bottom: 30px;
            background: var(--theme-card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--theme-border);
            border-radius: 2px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .grid-item:hover {
            transform: translateY(-8px);
            border-color: var(--gm-copper);
            box-shadow: 0 20px 40px var(--theme-shadow);
        }

        .img-container {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4/5;
            background: var(--te-green-dark);
        }

        .grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .grid-item:hover img {
            transform: scale(1.08);
        }

        .card-content {
            padding: 25px;
        }

        .card-title {
            font-size: 22px;
            margin: 0 0 15px;
            color: var(--theme-text);
            font-weight: 400;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--theme-border);
            padding-top: 15px;
            font-size: 12px;
            color: var(--theme-text-secondary);
        }

        .price-tag {
            color: var(--gm-copper);
            font-weight: 700;
            font-size: 16px;
        }

        /* Management View */
        #management-view {
            display: none;
        }

        #management-view.active {
            display: block;
        }

        .mgmt-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .mgmt-btn {
            background: transparent;
            border: 1px solid var(--theme-border);
            padding: 12px 24px;
            border-radius: 4px;
            color: var(--theme-text);
            cursor: pointer;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        .mgmt-btn:hover {
            background: rgba(203, 157, 84, 0.15);
            border-color: var(--gm-copper);
        }

        .mgmt-btn.primary {
            background: linear-gradient(135deg, #CB9D54 0%, #A87D3E 100%);
            border: none;
            color: #fff;
        }

        .mgmt-btn.primary:hover {
            background: linear-gradient(135deg, #DCAE65 0%, #B98E4F 100%);
            box-shadow: 0 6px 20px rgba(203, 157, 84, 0.4);
        }

        .glass-panel {
            background: rgba(11, 29, 27, 0.6);
            backdrop-filter: blur(25px);
            border: 1px solid var(--theme-border);
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 8px 32px var(--theme-shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            padding: 24px 20px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            text-align: left;
            border-bottom: 1px solid var(--theme-border);
            color: var(--theme-text-secondary);
        }

        table td {
            padding: 20px;
            font-size: 15px;
            border-bottom: 1px solid var(--theme-border);
        }

        table tbody tr {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        table tbody tr:hover {
            transform: translateY(-1px);
            background: rgba(203, 157, 84, 0.03);
            box-shadow: 0 0 0 1px rgba(203, 157, 84, 0.2);
        }

        [contenteditable]:focus {
            outline: none;
            background: rgba(203, 157, 84, 0.08);
            border-radius: 2px;
        }

        /* Footer */
        .site-footer {
            margin-top: 80px;
            padding: 60px 20px;
            background: rgba(0, 0, 0, 0.4);
            border-top: 1px solid var(--theme-border);
            text-align: center;
        }

        .f-logo-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            opacity: 0.8;
        }

        /* Lightbox */
        #lightbox {
            position: fixed;
            inset: 0;
            background: rgba(11, 29, 27, 0.98);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: zoom-out;
            padding: 40px;
            backdrop-filter: blur(10px);
        }

        #lightbox img {
            max-width: 90%;
            max-height: 90%;
            border: 1px solid var(--theme-border);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media(max-width: 1100px) {
            .masonry-grid {
                column-count: 2;
            }
        }

        @media(max-width: 768px) {
            .masonry-grid {
                column-count: 1;
            }

            .site-header {
                padding: 0 20px;
            }

            .hero h1 {
                font-size: 40px;
            }

            .logo-te {
                display: none;
            }

            .divider {
                display: none;
            }
        }

        /* Loading State */
        .loading {
            text-align: center;
            padding: 100px;
            color: var(--theme-text-secondary);
        }

        .spinner {
            border: 2px solid var(--theme-border);
            border-top-color: var(--gm-copper);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <header class="site-header">
        <div class="logos-wrapper">
            <img src="https://tradeexpansion.com.br/wp-content/themes/tradeexpansion-site-main/assets/images/logo.jpg"
                alt="Trade Expansion" class="logo-te">
            <div class="divider"></div>
            <img src="https://globalmarmol.com/wp-content/uploads/2022/10/LOGO-FINAL-GLOBAL-MARMOL-400px.png"
                alt="Global Marmol" class="logo-client">
        </div>
        <div class="user-meta">
            <span class="editorial">Exclusivo:</span>
            <span><?php echo esc_html($user_display_name); ?></span>
        </div>
    </header>

    <div class="container">

        <section class="hero">
            <h1 class="editorial">Portal <span>Global Marmol</span></h1>
            <p style="color: var(--theme-text-secondary); font-size: 18px; max-width: 600px; margin: 0 auto;">
                Gestión integral de materiales y estado de cuenta
            </p>
        </section>

        <nav class="tab-nav">
            <?php if ($can_view_favorita): ?>
                <button class="tab-btn active" onclick="switchTab('favorita')">Favorita do Brasil</button>
            <?php endif; ?>

            <?php if ($can_view_policast): ?>
                <button class="tab-btn" onclick="switchTab('policast')">Policast</button>
            <?php endif; ?>

            <?php if ($can_view_management): ?>
                <button class="tab-btn" onclick="switchTab('management')">Estado de Cuenta</button>
            <?php endif; ?>
        </nav>

        <!-- Materials Grid -->
        <div id="materials-view">
            <div id="materialGrid" class="masonry-grid"></div>
        </div>

        <!-- Management View -->
        <?php if ($can_view_management): ?>
            <div id="management-view">
                <div class="mgmt-controls">
                    <button class="mgmt-btn" onclick="toggleTheme()">
                        <span id="theme-icon">🌙</span> <span id="theme-text">Claro</span>
                    </button>
                    <button class="mgmt-btn" onclick="exportExcel()">📊 Exportar Excel</button>
                    <button class="mgmt-btn" onclick="exportPDF()">📄 Exportar PDF</button>
                    <button class="mgmt-btn" onclick="syncData()">🔄 Sincronizar</button>
                    <button class="mgmt-btn primary" onclick="addNewRow()">➕ Añadir Nuevo</button>
                </div>

                <div class="glass-panel">
                    <div id="table-container">
                        <div class="loading">
                            <div class="spinner"></div>
                            <p>Cargando datos...</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="f-logo-row">
            <img src="https://tradeexpansion.com.br/wp-content/themes/tradeexpansion-site-main/assets/images/logo.jpg"
                style="height:30px">
            <span style="color: var(--theme-text-secondary);">×</span>
            <img src="https://globalmarmol.com/wp-content/uploads/2022/10/LOGO-FINAL-GLOBAL-MARMOL-400px.png"
                style="height:35px">
        </div>
        <p style="font-size:13px; color: var(--theme-text-secondary)">
            Portal exclusivo desarrollado por <a href="https://tradeexpansion.com.br" target="_blank"
                style="color:var(--gm-copper); text-decoration:none;">Trade Expansion</a>
        </p>
    </footer>

    <div id="lightbox" onclick="this.style.display='none'"><img id="lbImg" src=""></div>

    <script>
        // ============================================
        // CONFIGURATION
        // ============================================
        const PROXY_URL = '<?php echo esc_url(get_template_directory_uri() . '/proxy-globalmarmol.php'); ?>';
        const USER_ID = <?php echo $user_id; ?>;

        // ============================================
        // DATA STORE
        // ============================================
        const store = {
            <?php if ($can_view_favorita): ?>
                favorita: {
                    data: <?php echo json_encode($favorita_data); ?>,
                    label: "Favorita do Brasil",
                    logo: "https://www.favoritabrasil.com/images/logo-favorita-brasile.svg"
                },
            <?php endif; ?>
            
            <?php if ($can_view_policast): ?>
                policast: {
                    data: <?php echo json_encode($policast_data); ?>,
                    label: "Policast",
                    logo: "https://via.placeholder.com/150x50?text=Policast"
                },
            <?php endif; ?>
        };

        let currentTab = '<?php echo $can_view_favorita ? "favorita" : ($can_view_policast ? "policast" : "management"); ?>';
        let sheetData = [];

        // ============================================
        // TAB SWITCHING
        // ============================================
        function switchTab(key) {
            currentTab = key;

            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Toggle views
            if (key === 'management') {
                document.getElementById('materials-view').style.display = 'none';
                document.getElementById('management-view').classList.add('active');
                document.body.classList.add('is-mgmt');
                loadSheetData();
            } else {
                document.getElementById('materials-view').style.display = 'block';
                document.getElementById('management-view').classList.remove('active');
                document.body.classList.remove('is-mgmt');
                renderMaterials(key);
            }
        }

        // ============================================
        // MATERIALS RENDERING
        // ============================================
        function renderMaterials(key) {
            const grid = document.getElementById('materialGrid');
            const items = store[key]?.data || [];

            grid.innerHTML = '';

            if (items.length === 0) {
                grid.innerHTML = `<div style="grid-column: 1/-1; text-align: center; padding: 100px; color: var(--theme-text-secondary);">
                    No hay materiales disponibles en esta categoría.
                </div>`;
                return;
            }

            items.forEach((item, index) => {
                const card = document.createElement('div');
                card.className = 'grid-item reveal';
                card.style.transitionDelay = `${index * 0.1}s`;

                card.innerHTML = `
                    <div class="img-container" onclick="openLightbox('${item.i}')">
                        <img src="${item.i}" alt="${item.m}" loading="lazy">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title editorial">${item.m}</h3>
                        <div class="card-meta">
                            <div>
                                <strong>BLOQUE</strong> ${item.b || '-'}<br>
                                <strong>PAQUETE</strong> ${item.bn || '-'}
                            </div>
                            <div class="price-tag">
                                $ ${item.p ? item.p.toFixed(2) : '-'} <span>/m²</span>
                            </div>
                        </div>
                    </div>
                `;
                grid.appendChild(card);

                setTimeout(() => card.classList.add('visible'), 50);
            });
        }

        function openLightbox(src) {
            document.getElementById('lbImg').src = src;
            document.getElementById('lightbox').style.display = 'flex';
        }

        // ============================================
        // GOOGLE SHEETS INTEGRATION
        // ============================================
        async function loadSheetData() {
            const container = document.getElementById('table-container');
            container.innerHTML = '<div class="loading"><div class="spinner"></div><p>Cargando datos...</p></div>';

            try {
                const response = await fetch(PROXY_URL);
                const result = await response.json();

                if (result.status === 'success') {
                    sheetData = result.data;
                    renderTable();
                } else {
                    throw new Error(result.message || 'Error al cargar datos');
                }
            } catch (error) {
                container.innerHTML = `<div class="loading"><p style="color: #ef4444;">Error: ${error.message}</p></div>`;
            }
        }

        function renderTable() {
            if (sheetData.length === 0) {
                document.getElementById('table-container').innerHTML = '<p style="text-align:center; padding:40px; color: var(--theme-text-secondary);">No hay datos disponibles</p>';
                return;
            }

            const headers = Object.keys(sheetData[0]);

            let html = `
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                ${headers.map(h => `<th>${h.toUpperCase()}</th>`).join('')}
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            sheetData.forEach((row, index) => {
                html += '<tr>';
                headers.forEach(header => {
                    let value = row[header];

                    // Format dates
                    if (header.toLowerCase().includes('fecha') || header.toLowerCase().includes('vencimiento')) {
                        value = formatDate(value);
                    }

                    // Format money
                    if (header.toLowerCase().includes('monto') || header.toLowerCase().includes('precio')) {
                        value = formatMoney(value);
                    }

                    html += `<td>${value}</td>`;
                });
                html += `<td><button class="mgmt-btn" onclick="deleteRow(${row.id})" style="padding: 8px 16px; font-size: 11px;">🗑️ Eliminar</button></td>`;
                html += '</tr>';
            });

            html += '</tbody></table></div>';
            document.getElementById('table-container').innerHTML = html;
        }

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const date = new Date(dateStr);
            if (isNaN(date)) return dateStr;
            return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }

        function formatMoney(value) {
            if (!value) return '-';
            return `$ ${parseFloat(value).toFixed(2)}`;
        }

        // ============================================
        // CRUD OPERATIONS
        // ============================================
        async function deleteRow(id) {
            if (!confirm('¿Está seguro de eliminar este registro?')) return;

            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);

                const response = await fetch(PROXY_URL, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.status === 'success') {
                    alert('Registro eliminado correctamente');
                    loadSheetData();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }

        function addNewRow() {
            alert('Funcionalidad de añadir nuevo registro en desarrollo');
            // TODO: Implement modal for adding new rows
        }

        async function syncData() {
            await loadSheetData();
            alert('Datos sincronizados correctamente');
        }

        // ============================================
        // EXPORT FUNCTIONS
        // ============================================
        function exportExcel() {
            const ws = XLSX.utils.json_to_sheet(sheetData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Estado de Cuenta");
            XLSX.writeFile(wb, `GlobalMarmol_${new Date().toISOString().split('T')[0]}.xlsx`);
        }

        function exportPDF() {
            const element = document.getElementById('table-container');
            html2pdf().from(element).save(`GlobalMarmol_${new Date().toISOString().split('T')[0]}.pdf`);
        }

        // ============================================
        // THEME TOGGLE
        // ============================================
        function toggleTheme() {
            document.body.classList.toggle('light-theme');
            const isLight = document.body.classList.contains('light-theme');
            document.getElementById('theme-icon').textContent = isLight ? '☀️' : '🌙';
            document.getElementById('theme-text').textContent = isLight ? 'Oscuro' : 'Claro';
            localStorage.setItem('gm-theme', isLight ? 'light' : 'dark');
        }

        // Load saved theme
        if (localStorage.getItem('gm-theme') === 'light') {
            toggleTheme();
        }

        // ============================================
        // INITIALIZATION
        // ============================================
        window.addEventListener('load', () => {
            if (currentTab === 'management') {
                document.getElementById('management-view').classList.add('active');
                document.getElementById('materials-view').style.display = 'none';
                document.body.classList.add('is-mgmt');
                loadSheetData();
            } else {
                renderMaterials(currentTab);
            }
        });
    </script>
</body>

</html>