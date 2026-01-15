<?php
/**
 * Template Name: Inspeção Técnica Scrollytelling
 * Description: Experiência de Scrollytelling para Trade Expansion
 */

get_header();

// Asset paths
// Ensure spaces are encoded for URLs
$base_asset_path = get_template_directory_uri() . '/assets/Video%20Frames%20Sequence/';
?>

<style>
    :root {
        --te-green: #102724;
        --te-gold: #D6A354;
        --te-cream: #F1F1D9;
        --te-glass: rgba(16, 39, 36, 0.65);
    }

    body {
        background: var(--te-green);
        margin: 0;
        overflow-x: hidden;
    }

    /* === UI OVERRIDES (CRITICAL) === */
    /* Force Transparent Fixed Header */
    #teHeader {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        z-index: 9999 !important;
    }

    /* Whitewash Logo & Menu for contrast */
    #teHeader img,
    #teHeader svg,
    #teHeader a,
    #teHeader span,
    #teHeader button {
        filter: brightness(0) invert(1) !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    /* Remove original flags border if needed */
    #teHeader img.rounded-full {
        border-color: rgba(255, 255, 255, 0.3) !important;
    }

    /* Hide Standard Footer */
    footer,
    .floating-cta {
        display: none !important;
    }

    /* === SCROLLY LAYOUT === */
    .scrolly-wrapper {
        position: relative;
        width: 100%;
        height: 1000vh;
        /* Increased for "Cinematic" feel */
        background-color: var(--te-green);
    }

    .sticky-canvas-container {
        position: sticky;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        z-index: 1;
    }

    canvas#stone-canvas {
        display: block;
        /* Positioning handled by generic cover logic, but we center it generally */
        width: 100%;
        height: 100%;
    }

    /* LOADER */
    #scrolly-loader {
        position: fixed;
        inset: 0;
        background: var(--te-green);
        /* Solid green to hide everything */
        z-index: 10000;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--te-gold);
        font-family: 'Vollkorn', serif;
        transition: opacity 0.8s ease-out;
    }

    .loader-spinner {
        width: 60px;
        height: 60px;
        border: 3px solid rgba(214, 163, 84, 0.2);
        border-top-color: var(--te-gold);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 24px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* TEXT OVERLAYS */
    .scrolly-text-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
    }

    .scrolly-stage {
        position: absolute;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        /* JS handles visibility */
    }

    /* Staggered visual placement helpers */
    .scrolly-stage:nth-child(1) {
        top: 100vh;
    }

    .scrolly-stage:nth-child(2) {
        top: 300vh;
    }

    .scrolly-stage:nth-child(3) {
        top: 500vh;
    }

    .scrolly-stage:nth-child(4) {
        top: 700vh;
    }

    .scrolly-stage:nth-child(5) {
        top: 900vh;
    }

    .glass-panel {
        background: rgba(16, 39, 36, 0.45);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(241, 241, 217, 0.15);
        padding: 3rem 4rem;
        border-radius: 20px;
        max-width: 600px;
        color: var(--te-cream);
        pointer-events: auto;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        text-align: center;
    }

    /* Layout variated alignment */
    .stage-left .glass-panel {
        margin-right: 30%;
        text-align: left;
    }

    .stage-right .glass-panel {
        margin-left: 30%;
        text-align: right;
    }

    .stage-center .glass-panel {
        margin: 0 auto;
        text-align: center;
    }

    .glass-panel h2 {
        font-family: 'Vollkorn', serif;
        font-size: 2.8rem;
        margin: 0 0 1rem 0;
        color: var(--te-gold);
        line-height: 1.1;
    }

    .glass-panel p {
        font-family: sans-serif;
        font-size: 1.25rem;
        line-height: 1.7;
        margin: 0;
        opacity: 0.95;
        font-weight: 300;
    }

    .btn-contact {
        display: inline-block;
        margin-top: 2rem;
        padding: 1.2rem 2.8rem;
        background: var(--te-gold);
        color: var(--te-green);
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 100px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(214, 163, 84, 0.3);
    }

    .btn-contact:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(214, 163, 84, 0.5);
        background: #e0b468;
    }

    /* CUSTOM MINIMAL FOOTER */
    .custom-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 3rem;
        text-align: center;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        z-index: 50;
        opacity: 0;
    }

    @media (max-width: 768px) {
        .scrolly-wrapper {
            height: 800vh;
        }

        /* Slightly shorter on mobile */
        .glass-panel {
            padding: 2rem;
            margin: 0 1.5rem !important;
            width: auto;
            max-width: none;
        }

        .glass-panel h2 {
            font-size: 2rem;
        }

        .stage-left,
        .stage-right,
        .stage-center {
            justify-content: center;
        }

        .stage-left .glass-panel,
        .stage-right .glass-panel {
            text-align: center;
        }
    }
</style>

<!-- LOADER -->
<div id="scrolly-loader">
    <div class="loader-spinner"></div>
    <div style="font-size: 1.2rem; letter-spacing: 0.05em;">Carregando Experiência...</div>
    <div id="loader-progress" style="margin-top: 10px; font-size: 0.9rem; opacity: 0.7;">0%</div>
</div>

<!-- WRAPPER -->
<div class="scrolly-wrapper">
    <div class="sticky-canvas-container">
        <canvas id="stone-canvas"></canvas>
    </div>

    <div class="scrolly-text-layer">
        <div class="scrolly-stage stage-center" id="stage-1">
            <div class="glass-panel">
                <h2>A Origem</h2>
                <p>Seleção rigorosa na pedreira.</p>
            </div>
        </div>
        <div class="scrolly-stage stage-left" id="stage-2">
            <div class="glass-panel">
                <h2>Curadoria Técnica</h2>
                <p>Identificando o bloco perfeito com critérios objetivos.</p>
            </div>
        </div>
        <div class="scrolly-stage stage-right" id="stage-3">
            <div class="glass-panel">
                <h2>Engenharia de Precisão</h2>
                <p>A transformação bruta em chapas de alta performance.</p>
            </div>
        </div>
        <div class="scrolly-stage stage-left" id="stage-4">
            <div class="glass-panel">
                <h2>Refinamento</h2>
                <p>Escaneamento digital de veios, fissuras e integridade.</p>
            </div>
        </div>
        <div class="scrolly-stage stage-center" id="stage-5">
            <div class="glass-panel">
                <h2>Incerteza Zero</h2>
                <p>Sua carga aprovada, garantida e pronta para embarque.</p>
                <a href="/contato" class="btn-contact">Falar com Especialista</a>
            </div>
        </div>
    </div>

    <div class="custom-footer">
        © <?php echo date('Y'); ?> Trade Expansion. Excellence in Natural Stone.
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Initializing Cinematic Scrollytelling...");

        gsap.registerPlugin(ScrollTrigger);

        const canvas = document.getElementById("stone-canvas");
        const context = canvas.getContext("2d", { alpha: false }); // Optimize
        // Apply Hardware filter
        context.filter = 'contrast(1.1) brightness(1.05)';

        const totalFrames = 300;
        const framePath = "<?php echo $base_asset_path; ?>";
        const images = [];

        // Playhead for GSAP
        const playhead = { frame: 0 };

        let loadedCount = 0;

        // --- 1. RESIZE WITH RETINA SUPPORT ---
        function resizeCanvas() {
            const dpr = window.devicePixelRatio || 1;

            // CSS dimensions
            const w = window.innerWidth;
            const h = window.innerHeight;

            canvas.style.width = w + "px";
            canvas.style.height = h + "px";

            // Logical Dimensions (Internal buffer)
            canvas.width = w * dpr;
            canvas.height = h * dpr;

            // Important: Scale context so drawing operations use CSS pixels
            context.scale(dpr, dpr);

            // Re-apply filter (context reset on resize)
            context.filter = 'contrast(1.1) brightness(1.05)';

            render();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        // --- 2. PRELOAD ALL IMAGES (STRICT) ---
        function preloadImages() {
            const updateProgress = () => {
                const pct = Math.round((loadedCount / totalFrames) * 100);
                const el = document.getElementById("loader-progress");
                if (el) el.innerText = pct + "%";
            };

            for (let i = 0; i < totalFrames; i++) {
                const img = new Image();
                // Format ID
                const paddedIndex = String(i + 1).padStart(3, '0');
                img.src = `${framePath}frame_${paddedIndex}.jpg`;

                img.onload = () => {
                    loadedCount++;
                    updateProgress();
                    if (loadedCount === totalFrames) {
                        startExperience();
                    }
                };
                img.onerror = () => {
                    // If a frame fails, we count it anyway to avoid hanging
                    console.warn("Frame failed:", i);
                    loadedCount++;
                    updateProgress();
                    if (loadedCount === totalFrames) {
                        startExperience();
                    }
                };
                images.push(img);
            }
        }

        // --- 3. RENDER (COVER LOGIC) ---
        function render() {
            // Use floor/round to pick frame
            const frameIndex = Math.min(totalFrames - 1, Math.round(playhead.frame));
            const img = images[frameIndex];

            if (!img || !img.complete) return;

            // Visual Canvas Size (CSS pixels, since we used context.scale)
            const canvasW = canvas.width / (window.devicePixelRatio || 1);
            const canvasH = canvas.height / (window.devicePixelRatio || 1);

            const imgRatio = img.width / img.height;
            const canvasRatio = canvasW / canvasH;

            // Cover Logic
            let drawW, drawH, offsetX, offsetY;

            if (canvasRatio > imgRatio) {
                // Screen is wider -> Fit width, crop height
                drawW = canvasW;
                drawH = canvasW / imgRatio;
                offsetX = 0;
                offsetY = (canvasH - drawH) / 2;
            } else {
                // Screen is taller -> Fit height, crop width
                drawH = canvasH;
                drawW = canvasH * imgRatio;
                offsetX = (canvasW - drawW) / 2;
                offsetY = 0;
            }

            // Draw
            context.drawImage(img, offsetX, offsetY, drawW, drawH);
        }

        // --- 4. START EXPERIENCE ---
        function startExperience() {
            // Fade out loader
            gsap.to("#scrolly-loader", {
                opacity: 0,
                duration: 1.0,
                onComplete: () => { document.getElementById("scrolly-loader").style.display = 'none'; }
            });

            // Setup Main Timeline
            // Scrub 2.5 for "Weighty" feel
            gsap.to(playhead, {
                frame: totalFrames - 1,
                ease: "none",
                scrollTrigger: {
                    trigger: ".scrolly-wrapper",
                    start: "top top",
                    end: "bottom bottom",
                    scrub: 2.5,
                },
                onUpdate: render
            });

            setupCinematicText();
            setupFooter();
            render();
        }

        // --- 5. TEXT ANIMATION (No Overlap) ---
        function setupCinematicText() {
            // Total scroll range is large. We assign specific slots.
            // Stage 1: 5% - 18%
            // Stage 2: 25% - 38%
            // Stage 3: 45% - 58%
            // Stage 4: 65% - 78%
            // Stage 5: 85% - 95%

            const stages = [
                { id: "#stage-1", start: 0.05, end: 0.18 },
                { id: "#stage-2", start: 0.25, end: 0.38 },
                { id: "#stage-3", start: 0.45, end: 0.58 },
                { id: "#stage-4", start: 0.65, end: 0.78 },
                { id: "#stage-5", start: 0.85, end: 0.95 }
            ];

            stages.forEach((stage) => {
                const panel = document.querySelector(`${stage.id} .glass-panel`);
                if (!panel) return;

                // Animate In: Blur -> Sharp + Fade Up
                gsap.fromTo(panel,
                    { opacity: 0, y: 50, filter: "blur(20px)" },
                    {
                        opacity: 1, y: 0, filter: "blur(0px)",
                        scrollTrigger: {
                            trigger: ".scrolly-wrapper",
                            // Convert pct to scroll pos
                            start: () => `top+=${stage.start * 100}% top`,
                            end: () => `top+=${(stage.start + 0.05) * 100}% top`, // Fast reveal
                            scrub: 1,
                            toggleActions: "play reverse play reverse"
                        }
                    }
                );

                // Animate Out: Fade Down + Blur
                gsap.to(panel, {
                    opacity: 0, y: -50, filter: "blur(20px)",
                    scrollTrigger: {
                        trigger: ".scrolly-wrapper",
                        start: () => `top+=${(stage.end - 0.05) * 100}% top`,
                        end: () => `top+=${stage.end * 100}% top`,
                        scrub: 1
                    }
                });
            });
        }

        function setupFooter() {
            gsap.to(".custom-footer", {
                opacity: 1,
                scrollTrigger: {
                    trigger: ".scrolly-wrapper",
                    start: "98% bottom",
                    end: "100% bottom",
                    scrub: 1
                }
            });
        }

        // Kickoff
        preloadImages();
    });
</script>

<?php get_footer(); ?>