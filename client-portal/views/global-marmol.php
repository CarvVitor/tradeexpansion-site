<?php
/**
 * View template for Global Mármol Client Portal
 * Path: client-portal/views/global-marmol.php
 * Refined with Extreme Luxury Aesthetics (Editorial Look)
 */


$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Fetch client-specific settings
$client_name = te_client_portal_get_setting($user_id, 'client_name', 'Global Mármol');
$client_logo = te_client_portal_get_setting($user_id, 'client_logo', 'https://globalmarmol.com/wp-content/uploads/2022/10/logo-globalmarmol.png');

// Permissions
$is_admin = current_user_can('manage_options') || $current_user->user_login === 'admin.globalmarmol';
?>

<style>
    :root {
        --primary-gold: #D6A354;
        --champagne: #F1F1D9;
        --deep-green: #0B1D1B;
        /* Cor específica da Global Mármol */
        --glass-bg: rgba(11, 29, 27, 0.6);
        --glass-border: rgba(255, 255, 255, 0.05);
        --text-bright: #F1F1D9;
        --sans-font: 'Inter', sans-serif;
    }

    .premium-portal {
        background-color: var(--deep-green);
        min-height: 100vh;
        color: var(--text-bright);
        font-family: 'Vollkorn', serif;
        overflow-x: hidden;
        position: relative;
    }

    /* Elegant Sync Progress Bar */
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

    /* Cinematic Background */
    .bg-elements {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    .blob {
        position: absolute;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(214, 163, 84, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(80px);
    }

    .content-layer {
        position: relative;
        z-index: 1;
    }

    /* Editorial Look Typo */
    h1,
    h2,
    h3,
    .mat-name,
    .hero-title,
    .nav-item {
        letter-spacing: 0.15em !important;
        text-transform: uppercase;
    }

    .label-secondary {
        font-family: var(--sans-font);
        font-weight: 200;
        /* Extra Light */
        text-transform: uppercase;
        letter-spacing: 0.3em;
        font-size: 9px;
        color: rgba(241, 241, 217, 0.3);
    }

    /* Editorial Header */
    .editorial-hero {
        padding: 140px 0 100px;
        border-bottom: 1px solid var(--glass-border);
    }

    .hero-title {
        font-size: clamp(3.5rem, 12vw, 8rem);
        line-height: 0.8;
        font-weight: 700;
        margin-bottom: 40px;
    }

    .hero-title span {
        color: var(--primary-gold);
        display: block;
        font-style: italic;
        font-weight: 400;
        text-transform: none;
        letter-spacing: 0 !important;
    }

    .exclusive-pill {
        background: var(--primary-gold);
        color: var(--deep-green);
        padding: 8px 18px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 4px;
        border-radius: 2px;
        margin-bottom: 3rem;
        display: inline-block;
    }

    /* Grid & Cards (Luxury Gallery Look) */
    .masonry-container {
        columns: 3 380px;
        column-gap: 50px;
        padding: 100px 0;
    }

    .stone-card {
        break-inside: avoid;
        margin-bottom: 50px;
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .stone-card:hover {
        transform: translateY(-1px);
        /* Elevando 1px conforme solicitado */
        border-color: rgba(214, 163, 84, 0.5);
        box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.6),
            inset 0 0 15px rgba(214, 163, 84, 0.15);
        /* Sombra interna suave dourada */
        background: rgba(11, 29, 27, 0.7);
    }

    .stone-image-wrap {
        aspect-ratio: 4/5;
        overflow: hidden;
        background: #0b1a19;
    }

    .stone-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 2s cubic-bezier(0.165, 0.84, 0.44, 1);
        filter: saturate(0.8);
    }

    .stone-card:hover .stone-image-wrap img {
        transform: scale(1.05);
        filter: saturate(1.1);
    }

    .card-meta {
        padding: 35px;
    }

    .mat-name {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-bright);
    }

    .mat-price {
        color: var(--primary-gold);
        font-size: 22px;
        font-weight: 400;
        font-family: 'Vollkorn', serif;
    }

    /* Minimalist Management View */
    .mgmt-bar {
        position: fixed;
        bottom: 50px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        padding: 16px 40px;
        border-radius: 100px;
        border: 1px solid var(--glass-border);
        display: flex;
        gap: 30px;
        align-items: center;
        z-index: 1000;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
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
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .btn-minimalist:hover {
        background: var(--primary-gold);
        color: var(--deep-green);
        border-color: var(--primary-gold);
        box-shadow: 0 10px 20px rgba(214, 163, 84, 0.2);
    }

    /* Luxury Modal */
    .luxury-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 5000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(11, 29, 27, 0.85);
        backdrop-filter: blur(10px);
    }

    .modal-content {
        position: relative;
        width: 100%;
        max-width: 600px;
        background: var(--glass-bg);
        backdrop-filter: blur(30px);
        border: 1px solid var(--glass-border);
        padding: 60px;
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .luxury-modal.active .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .minimal-input {
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(214, 163, 84, 0.2);
        padding: 15px 0;
        width: 100%;
        color: var(--text-bright);
        font-family: 'Vollkorn', serif;
        font-size: 18px;
        transition: all 0.4s;
    }

    .minimal-input:focus {
        outline: none;
        border-bottom-color: var(--primary-gold);
        box-shadow: 0 8px 15px -10px var(--champagne);
        /* Brilho Champagne suave */
        filter: brightness(1.2);
    }

    /* Animation utils */
    .fade-up {
        animation: fadeUp 1.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="premium-portal">
    <!-- Slim Progress Line -->
    <div id="sync-progress"></div>

    <div class="bg-elements">
        <div class="blob" style="top: -200px; right: -200px;"></div>
        <div class="blob"
            style="bottom: -300px; left: -200px; background: radial-gradient(circle, rgba(93, 39, 19, 0.15) 0%, transparent 70%);">
        </div>
    </div>

    <div class="content-layer max-w-7xl mx-auto px-6">

        <!-- Luxury Hero -->
        <header class="editorial-hero fade-up">
            <div class="exclusive-pill"><?php _e('Curaduría de Alta Gama', 'tradeexpansion'); ?></div>
            <h1 class="hero-title">
                <?php echo esc_html($client_name); ?>
                <span>Selección Exclusiva 2026</span>
            </h1>

            <div class="grid md:grid-cols-2 gap-20 items-end">
                <div class="text-white/40 text-2xl leading-relaxed italic font-light">
                    <?php _e('Una curaduría técnica de piedras naturales diseñada para los proyectos más ambiciosos. Rigor, transparencia e impacto visual.', 'tradeexpansion'); ?>
                </div>

                <div class="flex md:justify-end items-center gap-10">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png"
                        style="height: 40px; opacity: 0.3; filter: grayscale(1);">
                    <div class="w-px h-10 bg-white/10"></div>
                    <img src="<?php echo esc_url($client_logo); ?>" alt="Client Logo"
                        class="h-12 w-auto filter brightness(0) invert(1) opacity-80">
                </div>
            </div>
        </header>

        <!-- Premium Nav -->
        <nav class="flex flex-wrap gap-16 mt-20 text-[10px] tracking-[0.4em] font-black border-b border-white/5 pb-10">
            <a href="#" class="text-primary-gold border-b-2 border-primary-gold pb-10 -mb-[42px] transition-all"
                onclick="switchTab('catalog')"><?php _e('Inventário Real', 'tradeexpansion'); ?></a>
            <a href="#" class="text-white/20 hover:text-white transition-all pb-10"
                onclick="switchTab('inspections')"><?php _e('Inspecciones', 'tradeexpansion'); ?></a>
            <a href="#" class="text-white/20 hover:text-white transition-all pb-10"
                onclick="switchTab('logistics')"><?php _e('Logística', 'tradeexpansion'); ?></a>
        </nav>

        <!-- Inventory Grid -->
        <div id="catalogContent" class="fade-up" style="animation-delay: 0.5s;">
            <div id="materialGrid" class="masonry-container">
                <!-- Skeleton Loading -->
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="stone-card loading-shimmer" style="height: 500px;"></div>
                <?php endfor; ?>
            </div>
        </div>

    </div>

    <!-- Management Bar (Premium Context) -->
    <div class="mgmt-bar fade-up" style="animation-delay: 1.2s;">
        <div class="flex items-center gap-4 border-r border-white/10 pr-8">
            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
            <div class="label-secondary" style="font-size: 11px; opacity: 0.6;">
                <?php echo $current_user->display_name; ?>
            </div>
        </div>

        <?php if ($is_admin): ?>
            <button onclick="openAddModal()" class="btn-minimalist">
                <?php _e('Añadir Nuevo', 'tradeexpansion'); ?>
            </button>
        <?php endif; ?>

        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="te_client_logout">
            <?php wp_nonce_field('te_client_logout', 'te_client_logout_nonce'); ?>
            <button type="submit" class="label-secondary hover:text-rose-400 transition-colors flex items-center gap-3">
                <span><?php _e('Salir', 'tradeexpansion'); ?></span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Luxury Add Modal -->
    <div id="luxuryModal" class="luxury-modal">
        <div class="modal-overlay" onclick="closeAddModal()"></div>
        <div class="modal-content">
            <div class="editorial-tag mb-10"
                style="color:var(--primary-gold); letter-spacing:0.4em; font-size:10px; font-weight:900;">Nuevo Registro
            </div>
            <h2 class="text-4xl font-bold mb-12">Detalles del Material</h2>

            <div class="space-y-12">
                <div>
                    <label class="label-secondary mb-2 block">Nombre del Material</label>
                    <input type="text" class="minimal-input" placeholder="Ej: Tourmaline Extreme">
                </div>
                <!-- Outros campos -->
            </div>

            <div class="flex justify-end gap-10 mt-20">
                <button onclick="closeAddModal()"
                    class="label-secondary hover:text-white py-4 transition"><?php _e('Cerrar', 'tradeexpansion'); ?></button>
                <button class="btn-minimalist px-12 py-5"><?php _e('Guardar Registro', 'tradeexpansion'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('materialGrid');
        const progressBar = document.getElementById('sync-progress');

        async function fetchMaterialData() {
            progressBar.style.display = 'block';
            progressBar.style.width = '30%';

            try {
                const response = await fetch('<?php echo admin_url('admin-post.php'); ?>?action=te_client_proxy');
                progressBar.style.width = '70%';
                const result = await response.json();

                if (result && result.data) {
                    renderInventory(result.data);
                    progressBar.style.width = '100%';
                    setTimeout(() => {
                        progressBar.style.display = 'none';
                        progressBar.style.width = '0%';
                    }, 500);
                } else {
                    grid.innerHTML = '<div class="col-span-full py-40 text-center text-rose-400 font-serif text-2xl italic">Error de sincronização. Revise los parâmetros.</div>';
                }
            } catch (error) {
                console.error('Fetch error:', error);
                grid.innerHTML = '<div class="col-span-full py-40 text-center text-white/20 font-serif text-2xl italic">La sesión ha expirado. Por favor reingrese.</div>';
            }
        }

        function renderInventory(data) {
            grid.innerHTML = '';
            data.forEach((item, idx) => {
                const card = document.createElement('div');
                card.className = 'stone-card fade-up';
                card.style.animationDelay = (idx * 0.1) + 's';

                const img = item.i || 'https://placehold.co/800x1200?text=Premium+Stone';
                const price = item.p ? `$ ${parseFloat(item.p).toFixed(2)}` : 'Consultar';

                card.innerHTML = `
                    <div class="stone-image-wrap">
                        <img src="${img}" loading="lazy">
                    </div>
                    <div class="card-meta">
                        <div class="flex justify-between items-start gap-6 mb-8">
                            <div>
                                <h3 class="mat-name">${item.m}</h3>
                                <div class="label-secondary" style="font-size: 10px;">${item.f || 'Selección Premium'}</div>
                            </div>
                            <div class="text-right">
                                <div class="mat-price">${price}</div>
                                <div class="label-secondary" style="color:rgba(214,163,84,0.4); margin-top:4px;">m² FOB / Brasil</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-10 pt-8 border-t border-white/5">
                            <div>
                                <span class="label-secondary block mb-3">Bloque</span>
                                <span class="text-lg font-light tracking-wide text-white/60">${item.b || '---'}</span>
                            </div>
                            <div>
                                <span class="label-secondary block mb-3">Paquete</span>
                                <span class="text-lg font-light tracking-wide text-white/60">${item.bn || '---'}</span>
                            </div>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        fetchMaterialData();
    });

    function openAddModal() {
        const modal = document.getElementById('luxuryModal');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
    }

    function closeAddModal() {
        const modal = document.getElementById('luxuryModal');
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 500);
    }

    function switchTab(tab) {
        console.log('Editorial Navigation:', tab);
    }
</script>