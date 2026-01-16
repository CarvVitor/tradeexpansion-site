<?php
/**
 * Template Name: Inspeção Técnica Scrollytelling (Diagnostic Mode)
 * Description: High-Performance Scrollytelling with Integrated Debugging Console
 */

// BULLETPROOF ASSET PATH - Using PHP site_url()
$asset_url = site_url('/wp-content/themes/tema_teste_html/assets/Video%20Frames%20Sequence/');
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
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    <?php wp_head(); ?>

    <style>
        /* === RESET & CORE === */
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: #102724 !important;
            color: #F1F1D9 !important;
            font-family: 'Vollkorn', serif !important;
            overflow-x: hidden !important;
            -webkit-font-smoothing: antialiased;
        }

        /* === DIAGNOSTIC CONSOLE === */
        #diagnostic-console {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.9);
            color: #00FF00;
            font-family: monospace;
            font-size: 12px;
            z-index: 10000;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            border-bottom: 2px solid #00FF00;
        }

        #diagnostic-console.error {
            background: rgba(100, 0, 0, 0.95);
            border-bottom-color: #FF0000;
        }

        #diagnostic-console .stat {
            display: flex;
            gap: 5px;
        }

        #diagnostic-console .label {
            color: #888;
        }

        #diagnostic-console .value {
            font-weight: bold;
        }

        #diagnostic-console .ok {
            color: #00FF00;
        }

        #diagnostic-console .warn {
            color: #FFFF00;
        }

        #diagnostic-console .fail {
            color: #FF0000;
        }

        #skip-btn {
            padding: 8px 16px;
            background: #D6A354;
            color: #102724;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-left: auto;
        }

        #error-log {
            width: 100%;
            max-height: 80px;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px;
            margin-top: 10px;
            font-size: 10px;
            color: #FF6666;
        }

        /* === UI OVERLAY === */
        nav#headless-nav {
            position: fixed;
            top: 60px;
            /* Below diagnostic console */
            left: 0;
            width: 100%;
            padding: 30px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: linear-gradient(to bottom, rgba(16, 39, 36, 0.6), transparent);
        }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #F1F1D9;
            text-transform: uppercase;
            text-decoration: none;
        }

        .nav-back {
            font-family: sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: #D6A354;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* === LOADER === */
        #site-loader {
            position: fixed;
            inset: 0;
            background-color: #102724;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease-out;
        }

        .loader-percent {
            font-size: 5rem;
            color: #D6A354;
            font-weight: 700;
        }

        .loader-label {
            margin-top: 15px;
            font-family: sans-serif;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: rgba(241, 241, 217, 0.6);
        }

        /* === CANVAS === */
        canvas {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 1 !important;
            background-color: #102724 !important;
        }

        /* === SCROLL CONTAINER === */
        #scrolly-wrapper {
            position: relative;
            height: 800vh;
            z-index: 2;
        }

        /* === TEXT PANELS === */
        .scrolly-text-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .glass-panel {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 550px;
            background: rgba(16, 39, 36, 0.45);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(241, 241, 217, 0.15);
            padding: 3rem 4rem;
            border-radius: 12px;
            text-align: center;
            opacity: 0;
        }

        .glass-panel h2 {
            font-size: 2.8rem;
            color: #D6A354;
            margin-bottom: 1rem;
        }

        .glass-panel p {
            font-family: sans-serif;
            font-size: 1.15rem;
            color: #F1F1D9;
        }
    </style>
</head>

<body>

    <!-- DIAGNOSTIC CONSOLE -->
    <div id="diagnostic-console">
        <div class="stat">
            <span class="label">GSAP:</span>
            <span class="value" id="diag-gsap">CHECKING...</span>
        </div>
        <div class="stat">
            <span class="label">ScrollTrigger:</span>
            <span class="value" id="diag-st">CHECKING...</span>
        </div>
        <div class="stat">
            <span class="label">Images:</span>
            <span class="value" id="diag-images">0 / 300</span>
        </div>
        <div class="stat">
            <span class="label">Canvas:</span>
            <span class="value" id="diag-canvas">CHECKING...</span>
        </div>
        <div class="stat">
            <span class="label">Asset Path:</span>
            <span class="value" id="diag-path"
                style="font-size: 10px; max-width: 300px; overflow: hidden; text-overflow: ellipsis;">...</span>
        </div>
        <button id="skip-btn" onclick="forceStart()">Pular Carregamento</button>
        <div id="error-log"></div>
    </div>

    <!-- PRELOADER -->
    <div id="site-loader">
        <div class="loader-percent">0%</div>
        <div class="loader-label">Synchronizing Assets</div>
    </div>

    <!-- UI -->
    <nav id="headless-nav">
        <a href="/" class="nav-logo">Trade Expansion</a>
        <a href="/" class="nav-back">
            <span>Voltar</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 12h18M3 12l6-6m-6 6l6 6" />
            </svg>
        </a>
    </nav>

    <!-- CANVAS -->
    <canvas id="cinema-canvas"></canvas>

    <!-- CONTENT -->
    <div id="scrolly-wrapper">
        <div
            style="position: absolute; bottom: 0; width: 100%; text-align: center; padding: 40px; color: rgba(255,255,255,0.3); font-family: sans-serif; font-size: 0.8rem;">
            Trade Expansion © <?php echo date('Y'); ?>
        </div>
    </div>

    <!-- OVERLAYS -->
    <div class="scrolly-text-container">
        <div class="glass-panel" id="panel-1">
            <h2>A Origem</h2>
            <p>Seleção rigorosa na pedreira. A excelência começa na rocha bruta.</p>
        </div>
        <div class="glass-panel" id="panel-2">
            <h2>Curadoria</h2>
            <p>Critérios objetivos de qualidade. Apenas 3% do material é aprovado.</p>
        </div>
        <div class="glass-panel" id="panel-3">
            <h2>Processamento</h2>
            <p>Tecnologia avançada para garantir integridade estrutural e estética.</p>
        </div>
        <div class="glass-panel" id="panel-4">
            <h2>Inspeção</h2>
            <p>Varredura digital completa para detecção de falhas imperceptíveis.</p>
        </div>
        <div class="glass-panel" id="panel-5">
            <h2>Pronto</h2>
            <p>Sua carga está liberada para exportação com garantia total.</p>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        // ============================================
        // DIAGNOSTIC HELPERS
        // ============================================
        const diagConsole = document.getElementById('diagnostic-console');
        const diagGsap = document.getElementById('diag-gsap');
        const diagSt = document.getElementById('diag-st');
        const diagImages = document.getElementById('diag-images');
        const diagCanvas = document.getElementById('diag-canvas');
        const diagPath = document.getElementById('diag-path');
        const errorLog = document.getElementById('error-log');

        function logError(msg) {
            console.error(msg);
            errorLog.innerHTML += msg + '<br>';
            diagConsole.classList.add('error');
        }

        function updateDiag(id, status, className) {
            const el = document.getElementById(id);
            if (el) {
                el.innerText = status;
                el.className = 'value ' + className;
            }
        }

        // ============================================
        // FORCE START (Skip Button)
        // ============================================
        let experienceStarted = false;

        function forceStart() {
            if (experienceStarted) return;
            console.warn("FORCE START TRIGGERED");
            startExperience();
        }

        // Auto-force after 10 seconds
        setTimeout(() => {
            if (!experienceStarted) {
                console.warn("AUTO FORCE START (10s timeout)");
                forceStart();
            }
        }, 10000);

        // ============================================
        // MAIN LOGIC
        // ============================================
        document.addEventListener("DOMContentLoaded", () => {
            console.log("=== DIAGNOSTIC MODE ACTIVE ===");

            // --- CHECK GSAP ---
            if (typeof gsap !== 'undefined') {
                updateDiag('diag-gsap', 'LOADED ✓', 'ok');
                gsap.registerPlugin(ScrollTrigger);
                console.log("GSAP loaded successfully");
            } else {
                updateDiag('diag-gsap', 'FAILED ✗', 'fail');
                logError("GSAP failed to load!");
            }

            // --- CHECK SCROLLTRIGGER ---
            if (typeof ScrollTrigger !== 'undefined') {
                updateDiag('diag-st', 'LOADED ✓', 'ok');
                console.log("ScrollTrigger loaded successfully");
            } else {
                updateDiag('diag-st', 'FAILED ✗', 'fail');
                logError("ScrollTrigger failed to load!");
            }

            // --- CANVAS SETUP ---
            const canvas = document.getElementById("cinema-canvas");
            const context = canvas.getContext("2d", { alpha: false });

            if (canvas && context) {
                updateDiag('diag-canvas', 'OK ✓', 'ok');
                console.log("Canvas initialized");
            } else {
                updateDiag('diag-canvas', 'FAILED ✗', 'fail');
                logError("Canvas failed to initialize!");
            }

            // --- ASSET PATH (FROM PHP) ---
            const assetPath = "<?php echo esc_js($asset_url); ?>";
            diagPath.innerText = assetPath;
            console.log("Asset Path:", assetPath);

            const totalFrames = 300;
            const images = [];
            const playhead = { frame: 0 };

            // --- CANVAS RESIZE ---
            function resize() {
                const dpr = window.devicePixelRatio || 1;
                const width = window.innerWidth;
                const height = window.innerHeight;

                canvas.width = width * dpr;
                canvas.height = height * dpr;
                canvas.style.width = width + 'px';
                canvas.style.height = height + 'px';

                context.scale(dpr, dpr);
                context.imageSmoothingEnabled = true;
                context.imageSmoothingQuality = "high";

                // Draw test rect to confirm canvas is working
                context.fillStyle = '#102724';
                context.fillRect(0, 0, width, height);

                render();
            }
            window.addEventListener("resize", resize);
            resize();

            // --- SIMPLIFIED RENDER ---
            function render() {
                const frameIndex = Math.min(totalFrames - 1, Math.round(playhead.frame));
                const img = images[frameIndex];

                // Skip if image not ready
                if (!img || !img.complete || img.width === 0) {
                    return;
                }

                const canvasW = window.innerWidth;
                const canvasH = window.innerHeight;

                const imgRatio = img.width / img.height;
                const canvasRatio = canvasW / canvasH;

                let drawW, drawH, offsetX, offsetY;

                if (canvasRatio > imgRatio) {
                    drawW = canvasW;
                    drawH = canvasW / imgRatio;
                    offsetX = 0;
                    offsetY = (canvasH - drawH) / 2;
                } else {
                    drawH = canvasH;
                    drawW = canvasH * imgRatio;
                    offsetX = (canvasW - drawW) / 2;
                    offsetY = 0;
                }

                context.drawImage(img, offsetX, offsetY, drawW, drawH);
            }

            // --- PRELOADER ---
            let loadedCount = 0;
            let errorCount = 0;
            const loaderEl = document.getElementById("site-loader");
            const loaderPct = document.querySelector(".loader-percent");

            function checkLoad() {
                loadedCount++;
                const pct = Math.round((loadedCount / totalFrames) * 100);
                loaderPct.innerText = pct + "%";
                diagImages.innerText = loadedCount + ' / ' + totalFrames + (errorCount > 0 ? ' (' + errorCount + ' errors)' : '');

                if (errorCount > 0) {
                    diagImages.className = 'value warn';
                }

                if (loadedCount === totalFrames) {
                    if (errorCount === totalFrames) {
                        updateDiag('diag-images', 'ALL FAILED ✗', 'fail');
                        logError("All 300 images failed to load!");
                    }
                    startExperience();
                }
            }

            console.log("Starting Asset Preload...");

            for (let i = 0; i < totalFrames; i++) {
                const img = new Image();
                const id = String(i + 1).padStart(3, "0");
                const url = `${assetPath}frame_${id}.webp`;
                img.src = url;

                img.onload = () => {
                    checkLoad();
                    if (i === 0) {
                        console.log("First frame loaded successfully:", url);
                        updateDiag('diag-images', 'LOADING...', 'ok');
                    }
                };

                img.onerror = () => {
                    errorCount++;
                    logError("404: " + url);
                    checkLoad();
                };

                images[i] = img;
            }

            // --- START EXPERIENCE ---
            function startExperience() {
                if (experienceStarted) return;
                experienceStarted = true;

                console.log("Starting Experience. Loaded:", loadedCount, "Errors:", errorCount);

                // Fade out loader
                gsap.to(loaderEl, {
                    opacity: 0,
                    duration: 1,
                    onComplete: () => {
                        loaderEl.style.display = 'none';
                    }
                });

                // Main Timeline
                gsap.to(playhead, {
                    frame: totalFrames - 1,
                    ease: "none",
                    scrollTrigger: {
                        trigger: "#scrolly-wrapper",
                        start: "top top",
                        end: "bottom bottom",
                        scrub: 2,
                        snap: {
                            snapTo: [0, 0.2, 0.4, 0.6, 0.8, 1],
                            duration: { min: 0.3, max: 0.8 },
                            delay: 0.2,
                            ease: "power2.out"
                        }
                    },
                    onUpdate: render
                });

                // Text Panels
                const panels = [
                    { id: "#panel-1", start: 0.05, end: 0.15 },
                    { id: "#panel-2", start: 0.25, end: 0.35 },
                    { id: "#panel-3", start: 0.45, end: 0.55 },
                    { id: "#panel-4", start: 0.65, end: 0.75 },
                    { id: "#panel-5", start: 0.85, end: 0.95 }
                ];

                panels.forEach((p) => {
                    const el = document.querySelector(p.id);

                    gsap.fromTo(el,
                        { opacity: 0, filter: "blur(10px)", transform: "translate(-50%, -40%)" },
                        {
                            opacity: 1,
                            filter: "blur(0px)",
                            transform: "translate(-50%, -50%)",
                            scrollTrigger: {
                                trigger: "#scrolly-wrapper",
                                start: () => "top+=" + (p.start * 100) + "% top",
                                end: () => "top+=" + ((p.start + 0.05) * 100) + "% top",
                                scrub: 1
                            }
                        }
                    );

                    gsap.to(el, {
                        opacity: 0,
                        filter: "blur(10px)",
                        transform: "translate(-50%, -60%)",
                        scrollTrigger: {
                            trigger: "#scrolly-wrapper",
                            start: () => "top+=" + ((p.end - 0.05) * 100) + "% top",
                            end: () => "top+=" + (p.end * 100) + "% top",
                            scrub: 1
                        }
                    });
                });

                render();
            }
        });
    </script>

    <?php wp_footer(); ?>
</body>

</html>