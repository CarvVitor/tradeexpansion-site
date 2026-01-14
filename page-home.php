<?php
/**
 * Template Name: Home Page
 * Template Post Type: page
 * Description: Página principal da Trade Expansion — Premium B2B
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>

    <style>
        /* Estilos específicos da Home */

        /* Layered Parallax (Hero) */
        .parallax-hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #102724; /* Forest Green (Layer 0 base) */
        }

        .parallax-layer {
            position: absolute;
            inset: 0;
            will-change: transform;
        }

        .parallax-hero .layer-0 {
            z-index: 0;
        }

        .parallax-hero .layer-1 {
            z-index: 1;
            pointer-events: none;
        }

        .parallax-hero .layer-2 {
            z-index: 2;
            position: relative;
        }

        .parallax-hero .hero-video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            opacity: 0.6;
        }

        .parallax-hero .hero-overlay {
            background: radial-gradient(circle at center, rgba(16, 39, 36, 0.4) 0%, rgba(5, 8, 8, 0.9) 100%);
            position: absolute;
            inset: 0;
        }

        .organic-stone {
            position: absolute;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.95;
            filter: saturate(1.05) contrast(1.05);
            transform: translate3d(0, 0, 0);
            will-change: transform;
            /* “Formato orgânico” sem depender de PNG transparente */
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
        }

        /* Fade-in-up */
        .fade-up {
            opacity: 0;
            transform: translate3d(0, 18px, 0);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }

        @media (prefers-reduced-motion: reduce) {
            .parallax-layer,
            .organic-stone,
            .fade-up {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }

        /* Pillars Section */
        .pillars-section {
            padding: 100px 0;
            background: linear-gradient(to bottom, var(--secondary), #0a1816);
            position: relative;
        }

        .pillars-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 60px auto 0;
            padding: 0 20px;
        }

        .pillar-card {
            padding: 40px 30px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .pillar-card:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-10px);
            border-color: var(--gold);
        }

        .pillar-icon {
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 20px;
            display: block;
        }

        /* Dashboard Mockup - Prova de Valor */
        .dashboard-section {
            padding: 120px 0;
            background: url('<?php echo get_template_directory_uri(); ?>/assets/images/pattern_tech.png'), var(--secondary);
            position: relative;
            overflow: hidden;
        }

        .dashboard-mockup {
            background: #f4f6f8;
            /* Light gray bg for dashboard */
            border-radius: 12px;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.5),
                0 30px 60px -30px rgba(0, 0, 0, 0.6);
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: perspective(1000px) rotateX(2deg) translateY(20px);
            transition: transform 0.6s ease;
        }

        .dashboard-mockup:hover {
            transform: perspective(1000px) rotateX(0deg) translateY(0);
        }

        /* Mockup Header */
        .mock-header {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e1e4e8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mock-sidebar {
            width: 240px;
            background: #1a1c23;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            padding-top: 80px;
        }

        .mock-body {
            margin-left: 240px;
            /* Sidebar width */
            padding: 30px;
            background: #f4f6f8;
            min-height: 500px;
        }

        /* CSS para simular interface */
        .mock-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .mock-row {
            display: flex;
            gap: 20px;
        }

        .mock-stat {
            flex: 1;
            height: 100px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid var(--success);
        }

        .mock-table-line {
            height: 12px;
            background: #eee;
            border-radius: 4px;
            margin-bottom: 15px;
            width: 100%;
        }

        @media (max-width: 960px) {
            .parallax-hero .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                padding-top: 100px;
            }

            .pillars-grid {
                grid-template-columns: 1fr;
            }

            .mock-sidebar {
                display: none;
            }

            .mock-body {
                margin-left: 0;
            }

            .layer-1 {
                display: none;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>

    <?php get_header(); ?>

    <main>

        <!-- HERO SECTION - LAYERED PARALLAX -->
        <section class="parallax-hero" id="home-hero">

            <!-- LAYER 0: Background -->
            <div class="parallax-layer layer-0">
                <video class="hero-video" autoplay muted loop playsinline
                    poster="<?php echo get_template_directory_uri(); ?>/assets/images/hero-home-fallback.jpg">
                    <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero-home.mp4"
                        type="video/mp4" />
                </video>
                <div class="hero-overlay">
                </div>
            </div>

            <!-- LAYER 1: Floating Organic Stones -->
            <div class="parallax-layer layer-1">
                <!-- Esquerda Superior -->
                <div class="organic-stone stone-shape-1"
                    style="top: 15%; left: 5%; width: 250px; height: 300px; background-image: url('https://images.unsplash.com/photo-1596496336495-a2291583ffcd?w=600');">
                </div>

                <!-- Direita Inferior -->
                <div class="organic-stone stone-shape-2"
                    style="bottom: 10%; right: 8%; width: 300px; height: 350px; background-image: url('https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=600');">
                </div>

                <!-- Centro Fundo (Blur) -->
                <div class="organic-stone stone-shape-3"
                    style="top: 40%; left: 45%; width: 150px; height: 150px; opacity: 0.4; filter: blur(4px); background-image: url('https://images.unsplash.com/photo-1600607686527-6fb886090705?w=600');">
                </div>
            </div>

            <!-- LAYER 2: Conteúdo -->
            <div class="parallax-layer layer-2"
                style="display: flex; align-items: center; justify-content: center; width: 100%;">
                <div class="hero-content"
                    style="max-width: 1200px; padding: 0 2rem; display: grid; gap: 4rem; grid-template-columns: 1.2fr 0.8fr;">

                    <div class="glass-panel-overlap fade-up"
                        style="background: rgba(16, 39, 36, 0.6); backdrop-filter: blur(10px);">
                        <span
                            style="letter-spacing: 0.2em; text-transform: uppercase; color: var(--gold); font-size: 0.85rem; display: block; margin-bottom: 1.5rem;">Global
                            Trade Intelligence</span>
                        <h1 style="font-size: clamp(2.5rem, 5vw, 4.2rem); margin-bottom: 1.5rem;">
                            Sua visão técnica no <br><span class="text-gradient">mercado global</span>.
                        </h1>
                        <p
                            style="font-size: 1.1rem; max-width: 600px; margin-bottom: 2.5rem; color: rgba(255,255,255,0.85);">
                            Aliamos expertise aduaneira com tecnologia de inspeção em tempo real. Tenha o controle total
                            da sua carga, da extração ao porto, através do nosso dashboard exclusivo.
                        </p>

                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <a href="<?php echo esc_url(home_url('/contato')); ?>" class="btn-primary">Solicite uma
                                Consultoria</a>
                            <a href="#dashboard-preview" class="btn-secondary">Acesse o Portal</a>
                        </div>
                    </div>

                    <!-- Hero Glass Card (Lateral) -->
                    <div class="glass-panel fade-up delay-200"
                        style="padding: 2.5rem; border-radius: 12px; display: none; margin-left: auto; @media(min-width: 960px){display:block;}">
                        <h3 style="font-size: 1.2rem; color: var(--gold); margin-bottom: 1rem;">Status da Operação</h3>
                        <div
                            style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                            <div
                                style="font-size: 0.8rem; color: #999; text-transform: uppercase; margin-bottom: 0.3rem;">
                                Volume Exportado (Mês)</div>
                            <div style="font-size: 1.8rem; font-weight: 300; color: white;">12.450 m²</div>
                        </div>
                        <div>
                            <div
                                style="font-size: 0.8rem; color: #999; text-transform: uppercase; margin-bottom: 0.3rem;">
                                Taxa de Aprovação Técnica</div>
                            <div style="font-size: 1.8rem; font-weight: 300; color: white;">98.2%</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DIFERENCIAL - 3 PILARES -->
        <section class="pillars-section">
            <div style="text-align: center; max-width: 800px; margin: 0 auto; padding: 0 20px;" class="fade-up">
                <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">O Diferencial Trade Expansion</h2>
                <p>Por que as maiores construtoras e importadores confiam na nossa validação.</p>
            </div>

            <div class="pillars-grid">
                <!-- Pilar 1 -->
                <article class="pillar-card fade-up delay-100">
                    <span class="pillar-icon">🔍</span>
                    <h3>Rigor de Inspeção</h3>
                    <p>Não fazemos apenas o "confere visual". Nossa equipe técnica usa ferramentas de precisão para
                        detectar microfissuras, variação de espessura e tonalidade. O que entra no container é
                        exatamente o que você comprou.</p>
                </article>

                <!-- Pilar 2 -->
                <article class="pillar-card fade-up delay-200">
                    <span class="pillar-icon">📊</span>
                    <h3>Transparência Digital</h3>
                    <p>Esqueça PDFs estáticos. Nosso sistema proprietário gera links de visualização em tempo real. Veja
                        fotos em alta resolução e pareceres técnicos assim que a inspeção termina.</p>
                </article>

                <!-- Pilar 3 -->
                <article class="pillar-card fade-up delay-300">
                    <span class="pillar-icon">⚖️</span>
                    <h3>Inteligência Aduaneira</h3>
                    <p>Além da qualidade da pedra, garantimos a segurança jurídica. Classificação fiscal correta,
                        documentos de origem e compliance internacional para evitar surpresas no porto de destino.</p>
                </article>
            </div>
        </section>

        <!-- PROVA DE VALOR (DASHBOARD MOCKUP) -->
        <section id="dashboard-preview" class="dashboard-section">
            <div style="text-align: center; margin-bottom: 60px; padding: 0 20px;" class="fade-up">
                <span
                    style="color: var(--gold); letter-spacing: 0.2em; text-transform: uppercase; font-size: 0.9rem;">Tecnologia
                    Proprietária</span>
                <h2 style="font-size: 3rem; margin: 15px 0 20px;">Transformamos dados técnicos em <br>decisões seguras.
                </h2>
            </div>

            <!-- The CSS Mockup -->
            <div class="dashboard-mockup fade-up delay-200">
                <!-- Sidebar -->
                <div class="mock-sidebar">
                    <div style="padding: 0 20px; color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-bottom: 10px;">
                        MENU</div>
                    <div
                        style="padding: 12px 20px; color: white; border-left: 3px solid var(--gold); background: rgba(255,255,255,0.05);">
                        Dashboard</div>
                    <div style="padding: 12px 20px; color: rgba(255,255,255,0.7);">Meus Relatórios</div>
                    <div style="padding: 12px 20px; color: rgba(255,255,255,0.7);">Romaneios</div>
                    <div style="padding: 12px 20px; color: rgba(255,255,255,0.7);">Certificados</div>
                </div>

                <!-- Header -->
                <div class="mock-header">
                    <div style="font-weight: bold; color: #333; font-family: var(--font-sans);">Portal do Cliente v2.0
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <div style="width: 30px; height: 30px; background: #eee; border-radius: 50%;"></div>
                        <div style="width: 30px; height: 30px; background: #eee; border-radius: 50%;"></div>
                    </div>
                </div>

                <!-- Body -->
                <div class="mock-body">
                    <!-- Stats Row -->
                    <div class="mock-row" style="margin-bottom: 30px;">
                        <div class="mock-stat" style="display: flex; align-items: center; padding: 0 20px;">
                            <div>
                                <div style="font-size: 0.8rem; color: #888;">INSPEÇÕES ATIVAS</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">04 Lotes</div>
                            </div>
                        </div>
                        <div class="mock-stat"
                            style="border-left-color: #333; display: flex; align-items: center; padding: 0 20px;">
                            <div>
                                <div style="font-size: 0.8rem; color: #888;">DOCUMENTOS PENDENTES</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">Nenhum</div>
                            </div>
                        </div>
                        <div class="mock-stat"
                            style="border-left-color: var(--gold); display: flex; align-items: center; padding: 0 20px;">
                            <div>
                                <div style="font-size: 0.8rem; color: #888;">PRÓXIMO EMBARQUE</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #333;">14 Jan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Card -->
                    <div class="mock-card">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                            <h4 style="color: #333; margin: 0;">Relatórios Recentes</h4>
                            <span style="color: var(--gold); font-size: 0.8rem;">Ver Todos</span>
                        </div>

                        <!-- Table Header -->
                        <div
                            style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <span style="font-size: 0.75rem; color: #999; font-weight: bold;">MATERIAL</span>
                            <span style="font-size: 0.75rem; color: #999; font-weight: bold;">DATA</span>
                            <span style="font-size: 0.75rem; color: #999; font-weight: bold;">STATUS</span>
                            <span style="font-size: 0.75rem; color: #999; font-weight: bold;">AÇÃO</span>
                        </div>

                        <!-- Row 1 -->
                        <div
                            style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; align-items: center; margin-bottom: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 30px; height: 30px; background: #ddd; border-radius: 4px;"></div>
                                <span style="color: #333; font-size: 0.9rem;">Taj Mahal Quartzite - Premium Block</span>
                            </div>
                            <span style="color: #666; font-size: 0.9rem;">Hoje, 09:30</span>
                            <span
                                style="padding: 4px 8px; background: #e6ffed; color: #004d00; border-radius: 4px; font-size: 0.75rem; width: fit-content;">Aprovado</span>
                            <span style="color: var(--gold); font-size: 0.8rem;">PDF</span>
                        </div>

                        <!-- Row 2 -->
                        <div
                            style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; align-items: center; margin-bottom: 15px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 30px; height: 30px; background: #ddd; border-radius: 4px;"></div>
                                <span style="color: #333; font-size: 0.9rem;">Black Galaxy Granite - Slab #442</span>
                            </div>
                            <span style="color: #666; font-size: 0.9rem;">Ontem</span>
                            <span
                                style="padding: 4px 8px; background: #e6ffed; color: #004d00; border-radius: 4px; font-size: 0.75rem; width: fit-content;">Aprovado</span>
                            <span style="color: var(--gold); font-size: 0.8rem;">PDF</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA FINAL -->
        <section
            style="padding: 100px 0; background: radial-gradient(circle at center, #5d2713 0%, var(--secondary) 100%); text-align: center;">
            <div style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">Pronto para elevar o nível da sua operação?</h2>
                <p style="margin-bottom: 2.5rem; font-size: 1.1rem; opacity: 0.9;">Não arrisque sua reputação com
                    materiais duvidosos. Tenha a certeza técnica da Trade Expansion.</p>
                <a href="<?php echo esc_url(home_url('/contato')); ?>" class="btn-primary"
                    style="background: var(--cream); color: var(--secondary);">Solicitar Cotação de Inspeção</a>
            </div>
        </section>

    </main>

    <!-- Scripts para Animações -->
    <script>
        (() => {
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isMobile = window.matchMedia('(max-width: 768px)').matches;

            // Fade-in-up (IntersectionObserver)
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                }, { threshold: 0.12 });

                document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
            });

            // Layered Parallax only for Hero (smooth via rAF)
            if (prefersReduced || isMobile) return;

            const hero = document.getElementById('home-hero');
            if (!hero) return;

            const layer0 = hero.querySelector('.layer-0');
            const layer1 = hero.querySelector('.layer-1');

            let currentY = window.scrollY;
            let targetY = window.scrollY;

            const lerp = (a, b, t) => a + (b - a) * t;

            function tick() {
                targetY = window.scrollY;
                currentY = lerp(currentY, targetY, 0.10); // smoothness

                // Only animate while the hero is on screen (cheap optimization)
                const heroHeight = hero.offsetHeight || 0;
                if (currentY < heroHeight + 200) {
                    // Layer 1 (stones) speed ~ 0.4
                    if (layer1) {
                        layer1.style.transform = `translate3d(0, ${(currentY * 0.4).toFixed(2)}px, 0)`;
                    }
                    // Subtle depth on background/video
                    if (layer0) {
                        layer0.style.transform = `translate3d(0, ${(currentY * 0.12).toFixed(2)}px, 0)`;
                    }
                }

                requestAnimationFrame(tick);
            }

            requestAnimationFrame(tick);
        })();
    </script>

    <?php get_footer(); ?>
</body>

</html>