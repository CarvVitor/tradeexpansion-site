<?php
/**
 * Template Name: Inspeção Técnica Scrollytelling (Fail-Safe Debug)
 * Description: Version with aggressive fail-safe and path debugging
 */

// THE "SPACE & PATH" FIX - Using get_template_directory_uri()
$asset_path = get_template_directory_uri() . '/assets/Video%20Frames%20Sequence/';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Inspeção Técnica | Trade Expansion</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:wght@400;700&display=swap" rel="stylesheet">

    <!-- GSAP IN HEAD (Library Check) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <?php wp_head(); ?>

    <style>
        /* === RESET === */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            background-color: #102724;
            color: #F1F1D9;
            font-family: 'Vollkorn', serif;
            overflow-x: hidden;
        }

        /* === LOADER (BRIGHT FOR VISIBILITY) === */
        #headless-loader {
            position: fixed;
            inset: 0;
            background-color: #1a1a1a;
            /* BRIGHT SO WE KNOW IT'S OURS */
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #F1F1D9;
            transition: opacity 0.5s;
        }

        #headless-loader h1 {
            font-size: 2rem;
            color: #D6A354;
            margin-bottom: 20px;
        }

        #headless-loader .pct {
            font-size: 4rem;
            font-weight: bold;
            color: #D6A354;
        }

        #headless-loader .hint {
            margin-top: 15px;
            font-size: 0.9rem;
            opacity: 0.6;
        }

        #headless-loader .path-debug {
            margin-top: 20px;
            font-size: 0.7rem;
            color: #888;
            max-width: 80%;
            word-break: break-all;
            text-align: center;
        }

        /* === UI === */
        nav#site-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: linear-gradient(to bottom, rgba(16, 39, 36, 0.8), transparent);
        }

        nav#site-nav a {
            color: #F1F1D9;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 700;
        }

        nav#site-nav .back {
            color: #D6A354;
            font-size: 0.9rem;
        }

        /* === CANVAS === */
        canvas#main-canvas {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
            background: #102724;
        }

        /* === SCROLL === */
        #scroll-container {
            position: relative;
            height: 800vh;
            z-index: 2;
        }

        /* === PANELS === */
        .panel-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 10;
        }

        .panel {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            max-width: 500px;
            padding: 2.5rem;
            background: rgba(16, 39, 36, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            text-align: center;
            opacity: 0;
        }

        .panel h2 {
            color: #D6A354;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .panel p {
            font-family: sans-serif;
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
</head>

<body>

    <!-- LOADER -->
    <div id="headless-loader">
        <h1>Carregando Experiência</h1>
        <div class="pct" id="load-pct">0%</div>
        <div class="hint">Se demorar, verifique o console (F12)</div>
        <div class="path-debug" id="path-debug">Path: loading...</div>
    </div>

    <!-- NAV -->
    <nav id="site-nav">
        <a href="/">Trade Expansion</a>
        <a href="/" class="back">← Voltar</a>
    </nav>

    <!-- CANVAS -->
    <canvas id="main-canvas"></canvas>

    <!-- SCROLL -->
    <div id="scroll-container"></div>

    <!-- PANELS -->
    <div class="panel-layer">
        <div class="panel" id="p1">
            <h2>A Origem</h2>
            <p>Seleção rigorosa na pedreira.</p>
        </div>
        <div class="panel" id="p2">
            <h2>Curadoria</h2>
            <p>Apenas 3% é aprovado.</p>
        </div>
        <div class="panel" id="p3">
            <h2>Processamento</h2>
            <p>Tecnologia avançada.</p>
        </div>
        <div class="panel" id="p4">
            <h2>Inspeção</h2>
            <p>Varredura digital completa.</p>
        </div>
        <div class="panel" id="p5">
            <h2>Pronto</h2>
            <p>Carga liberada.</p>
        </div>
    </div>

    <script>
        (function () {
            console.log("=== SCRIPT INICIADO ===");

            // === LIBRARY CHECK ===
            if (typeof gsap === 'undefined') {
                console.error("ERRO: GSAP não carregou!");
                document.body.innerHTML = '<h1 style="color:red;padding:50px;">ERRO: GSAP não carregou</h1>';
                return;
            }
            console.log("✓ GSAP OK");

            if (typeof ScrollTrigger === 'undefined') {
                console.error("ERRO: ScrollTrigger não carregou!");
                return;
            }
            gsap.registerPlugin(ScrollTrigger);
            console.log("✓ ScrollTrigger OK");

            // === PATH FROM PHP ===
            const rawPath = "<?php echo esc_js($asset_path); ?>";
            // Decode to handle %20 -> space
            const assetPath = decodeURIComponent(rawPath);
            console.log("Asset Path (raw):", rawPath);
            console.log("Asset Path (decoded):", assetPath);
            document.getElementById('path-debug').innerText = 'Path: ' + assetPath;

            // === SETUP ===
            const canvas = document.getElementById('main-canvas');
            const ctx = canvas.getContext('2d', { alpha: false });
            const totalFrames = 300;
            const images = [];
            const playhead = { frame: 0 };
            let loaded = 0;
            let errors = 0;
            let started = false;

            // === RESIZE ===
            function resize() {
                const dpr = window.devicePixelRatio || 1;
                canvas.width = window.innerWidth * dpr;
                canvas.height = window.innerHeight * dpr;
                ctx.scale(dpr, dpr);
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
            }
            window.addEventListener('resize', resize);
            resize();

            // === RENDER ===
            function render() {
                const idx = Math.min(totalFrames - 1, Math.round(playhead.frame));
                const img = images[idx];
                if (!img || !img.complete || img.width === 0) return;

                const cw = window.innerWidth;
                const ch = window.innerHeight;
                const ir = img.width / img.height;
                const cr = cw / ch;
                let dw, dh, ox, oy;

                if (cr > ir) {
                    dw = cw; dh = cw / ir; ox = 0; oy = (ch - dh) / 2;
                } else {
                    dh = ch; dw = ch * ir; ox = (cw - dw) / 2; oy = 0;
                }
                ctx.drawImage(img, ox, oy, dw, dh);
            }

            // === FORCE START (FAIL-SAFE) ===
            function forceStart() {
                if (started) return;
                started = true;
                console.log(">>> STARTING (loaded:", loaded, "errors:", errors, ")");

                const loader = document.getElementById('headless-loader');
                loader.style.opacity = '0';
                setTimeout(() => loader.style.display = 'none', 500);

                // GSAP Animation
                gsap.to(playhead, {
                    frame: totalFrames - 1,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '#scroll-container',
                        start: 'top top',
                        end: 'bottom bottom',
                        scrub: 2,
                        snap: { snapTo: [0, 0.2, 0.4, 0.6, 0.8, 1], duration: 0.5 }
                    },
                    onUpdate: render
                });

                // Panels
                const panels = [
                    { id: '#p1', s: 0.05, e: 0.15 },
                    { id: '#p2', s: 0.25, e: 0.35 },
                    { id: '#p3', s: 0.45, e: 0.55 },
                    { id: '#p4', s: 0.65, e: 0.75 },
                    { id: '#p5', s: 0.85, e: 0.95 }
                ];
                panels.forEach(p => {
                    const el = document.querySelector(p.id);
                    gsap.fromTo(el, { opacity: 0 }, {
                        opacity: 1,
                        scrollTrigger: {
                            trigger: '#scroll-container',
                            start: 'top+=' + (p.s * 100) + '% top',
                            end: 'top+=' + (p.e * 100) + '% top',
                            scrub: 1,
                            toggleActions: 'play reverse play reverse'
                        }
                    });
                });

                render();
            }

            // === TIMED FAIL-SAFE (5 SECONDS) ===
            setTimeout(() => {
                if (!started) {
                    console.warn("!!! TIMEOUT - Forçando início após 5s !!!");
                    forceStart();
                }
            }, 5000);

            // === LOAD IMAGES ===
            function check() {
                loaded++;
                document.getElementById('load-pct').innerText = Math.round((loaded / totalFrames) * 100) + '%';
                if (loaded === totalFrames) forceStart();
            }

            console.log("Iniciando carregamento de", totalFrames, "frames...");

            for (let i = 0; i < totalFrames; i++) {
                const img = new Image();
                const id = String(i + 1).padStart(3, '0');
                const url = assetPath + 'frame_' + id + '.webp';

                // CRITICAL: Log each URL attempt
                console.log("Tentando carregar:", url);

                img.onload = check;
                img.onerror = () => {
                    errors++;
                    console.error("ERRO 404:", url);
                    check(); // Continue anyway
                };

                img.src = url;
                images[i] = img;
            }
        })();
    </script>

    <?php wp_footer(); ?>
</body>

</html>