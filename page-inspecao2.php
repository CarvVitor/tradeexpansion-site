<?php
/**
 * Template Name: Inspeção Técnica Scrollytelling (Headless)
 * Description: Experiência Isolada High-Performance
 */

$base_asset_path = get_template_directory_uri() . '/assets/Video%20Frames%20Sequence/';
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
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

    <style>
        /* === RESET & CORE === */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background-color: #102724; 
            overflow-x: hidden; 
            font-family: 'Vollkorn', serif;
            color: #F1F1D9;
        }

        /* === HEADLESS UI === */
        nav#headless-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 24px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: rgba(16, 39, 36, 0.4);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #F1F1D9;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 0.05em;
        }

        .nav-back {
            font-family: sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #D6A354;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s;
        }
        .nav-back:hover { opacity: 0.8; }

        /* === CANVAS LAYOUT === */
        canvas { 
            display: block; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100vw; 
            height: 100vh; 
            z-index: 1; 
        }

        #scrolly-container { 
            height: 1000vh; /* LONG SCROLL */
            position: relative; 
            z-index: 2; 
        }

        /* === TEXT LAYERS === */
        .scrolly-text-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .text-panel {
            position: absolute;
            opacity: 0;
            transform: translateY(30px);
            /* Centering Default */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) translateY(30px);
            text-align: center;
            
            background: rgba(16, 39, 36, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 3rem 4rem;
            border-radius: 12px;
            border: 1px solid rgba(241, 241, 217, 0.1);
            width: 90%;
            max-width: 600px;
        }

        .text-panel h2 {
            font-size: 2.5rem;
            color: #D6A354;
            margin-bottom: 1rem;
            line-height: 1.1;
        }

        .text-panel p {
            font-family: sans-serif;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #F1F1D9;
        }

        /* === LOADER === */
        #headless-loader {
            position: fixed;
            inset: 0;
            background: #102724;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease-out;
        }
        .loader-percent {
            font-size: 4rem;
            font-weight: 700;
            color: #D6A354;
            font-variant-numeric: tabular-nums;
        }
        .loader-label {
            margin-top: 10px;
            font-family: sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.8rem;
            opacity: 0.6;
        }

        /* === FOOTER === */
        #headless-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 40px;
            text-align: center;
            font-family: sans-serif;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
            opacity: 0;
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav id="headless-nav">
        <a href="/" class="nav-logo">Trade Expansion</a>
        <a href="/" class="nav-back">
            <span>Voltar</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </a>
    </nav>

    <!-- LOADER -->
    <div id="headless-loader">
        <div class="loader-percent" id="loader-val">0%</div>
        <div class="loader-label">Synchronizing Assets</div>
    </div>

    <!-- CANVAS -->
    <canvas id="cinema-canvas"></canvas>

    <!-- SCROLL CONTAINER -->
    <div id="scrolly-container">
        <div id="headless-footer">
            Trade Expansion © <?php echo date('Y'); ?>. All rights reserved.
        </div>
    </div>

    <!-- TEXT OVERLAYS (Fixed structure, animated via GSAP) -->
    <div class="scrolly-text-layer">
        <div class="text-panel" id="panel-01">
            <h2>A Origem</h2>
            <p>Seleção rigorosa na pedreira. Começamos onde a natureza termina.</p>
        </div>
        <div class="text-panel" id="panel-02">
            <h2>Curadoria</h2>
            <p>Apenas 3% dos blocos atendem aos nosso critérios de exportação.</p>
        </div>
        <div class="text-panel" id="panel-03">
            <h2>Processamento</h2>
            <p>Tecnologia de ponta para garantir a integridade da chapa.</p>
        </div>
        <div class="text-panel" id="panel-04">
            <h2>Inspeção Final</h2>
            <p>Cada centímetro é analisado digitalmente antes do envio.</p>
        </div>
        <div class="text-panel" id="panel-05">
            <h2>Aprovado</h2>
            <p>Sua carga está pronta para viajar o mundo.</p>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            // --- CONFIG ---
            const totalFrames = 300;
            const framePath = "<?php echo $base_asset_path; ?>";
            const canvas = document.getElementById("cinema-canvas");
            const context = canvas.getContext("2d", { alpha: false });
            const images = [];
            const playhead = { frame: 0 };

            // --- 1. RETINA SETUP ---
            function resize() {
                const dpr = window.devicePixelRatio || 1;
                canvas.width = window.innerWidth * dpr;
                canvas.height = window.innerHeight * dpr;
                context.scale(dpr, dpr);
                
                context.imageSmoothingEnabled = true;
                context.imageSmoothingQuality = "high";
                
                render();
            }
            window.addEventListener("resize", resize);
            resize();

            // --- 2. RENDERER (ASPECT FILL) ---
            function render() {
                const frameIndex = Math.min(totalFrames - 1, Math.round(playhead.frame));
                const img = images[frameIndex];
                
                if (!img || !img.complete) return;

                const dpr = window.devicePixelRatio || 1;
                const canvasW = canvas.width / dpr;
                const canvasH = canvas.height / dpr;
                
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

            // --- 3. PRELOADER (PROMISE.ALL) ---
            const promises = [];
            let loaded = 0;
            const loaderVal = document.getElementById("loader-val");

            for (let i = 0; i < totalFrames; i++) {
                promises.push(new Promise((resolve) => {
                    const img = new Image();
                    const id = String(i + 1).padStart(3, "0");
                    img.src = `${framePath}frame_${id}.webp`;
                    img.onload = () => {
                        loaded++;
                        loaderVal.innerText = Math.round((loaded/totalFrames)*100) + "%";
                        resolve(img);
                    };
                    img.onerror = () => {
                        console.warn("Err frame", i);
                        loaded++; // resolve anyway
                        resolve(img);
                    }
                    images[i] = img;
                }));
            }

            Promise.all(promises).then(() => {
                // FADE OUT LOADER
                gsap.to("#headless-loader", { opacity: 0, duration: 0.8, onComplete: () => {
                    document.getElementById("headless-loader").style.display = 'none';
                }});
                startExperience();
            });

            // --- 4. SCROLL LOGIC ---
            function startExperience() {
                // Main Image Scrub
                gsap.to(playhead, {
                    frame: totalFrames - 1,
                    ease: "none",
                    scrollTrigger: {
                        trigger: "#scrolly-container",
                        start: "top top",
                        end: "bottom bottom",
                        scrub: 0.5, // slightly tighter scrub
                        snap: {
                            snapTo: [0, 0.2, 0.4, 0.6, 0.8, 1],
                            duration: { min: 0.3, max: 0.6 },
                            ease: "power1.inOut"
                        }
                    },
                    onUpdate: render
                });

                // Text Animations (Checkpoints)
                // We define ranges relative to scroll
                const texts = [
                    { id: "#panel-01", start: 0.05, end: 0.15 },
                    { id: "#panel-02", start: 0.25, end: 0.35 },
                    { id: "#panel-03", start: 0.45, end: 0.55 },
                    { id: "#panel-04", start: 0.65, end: 0.75 },
                    { id: "#panel-05", start: 0.85, end: 0.95 },
                ];

                texts.forEach(t => {
                    // Reveal
                    gsap.to(t.id, {
                        opacity: 1,
                        y: "-50%", // Center vertically (undo translateY(30px) partially? No, let's just fade in to clean center)
                        transform: "translate(-50%, -50%) translateY(0px)",
                        scrollTrigger: {
                            trigger: "#scrolly-container",
                            start: () => "top+=" + (t.start * 100) + "% top",
                            end: () => "top+=" + (t.end * 100) + "% top",
                            toggleActions: "play reverse play reverse",
                            scrub: 1
                        }
                    });
                });

                // Footer Reveal
                gsap.to("#headless-footer", {
                    opacity: 1,
                    scrollTrigger: {
                        trigger: "#scrolly-container",
                        start: "98% bottom",
                        end: "100% bottom",
                        scrub: true
                    }
                });
                
                render();
            }
        });
    </script>
    
    <?php wp_footer(); ?>
</body>
</html>