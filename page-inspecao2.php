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
        /* Shorthand to overwrite theme's background-image gradient */
        margin: 0;
        overflow-x: hidden;
    }

    /* === UI OVERRIDES START === */
    /* Transparent Header Integration */
    #teHeader {
        background: transparent !important;
        box-shadow: none !important;
        position: fixed !important;
        /* Fixed to stay on top while scrolling */
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999 !important;
        transition: background 0.5s ease;
        border: none !important;
    }

    /* Ensure text readability on transparent background */
    #teHeader a,
    #teHeader span,
    #teHeader button {
        color: #ffffff !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Hide Global Footer & Floating CTA */
    footer,
    .floating-cta {
        display: none !important;
    }

    /* === UI OVERRIDES END === */

    /* MAIN WRAPPER */
    .scrolly-wrapper {
        position: relative;
        width: 100%;
        /* 600vh total height for 5 stages (roughly 100vh per stage + buffer) */
        height: 600vh;
        background-color: var(--te-green);
    }

    /* STICKY CANVAS CONTAINER */
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
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Controlled by JS */
    }

    /* LOADING SCREEN */
    #scrolly-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--te-green);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--te-gold);
        font-family: 'Vollkorn', serif;
        transition: opacity 0.8s ease-out;
    }

    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 2px solid rgba(214, 163, 84, 0.2);
        border-top-color: var(--te-gold);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* TEXT OVERLAYS (STAGES) */
    .scrolly-text-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        /* Let clicks pass through to potential canvas interactions if any */
        z-index: 10;
    }

    .scrolly-stage {
        position: absolute;
        width: 100%;
        height: 100vh;
        /* One viewport height */
        display: flex;
        align-items: center;
        justify-content: center;
        /* Opacity controlled by GSAP, but starting transparent helps avoid flash */
        opacity: 0;
    }

    /* Positioning of stages based on percentage of execution - approximate visual placement */
    /* Note: Logic is driven by ScrollTrigger, but these help visualization */
    .scrolly-stage:nth-child(1) {
        top: 50vh;
    }

    .scrolly-stage:nth-child(2) {
        top: 150vh;
    }

    .scrolly-stage:nth-child(3) {
        top: 250vh;
    }

    .scrolly-stage:nth-child(4) {
        top: 350vh;
    }

    .scrolly-stage:nth-child(5) {
        top: 450vh;
    }

    .glass-panel {
        background: rgba(16, 39, 36, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(241, 241, 217, 0.15);
        padding: 2.5rem 3rem;
        border-radius: 16px;
        max-width: 500px;
        color: var(--te-cream);
        pointer-events: auto;
        /* Re-enable pointer events for buttons */
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        /* Note: transform removed here as GSAP handles movement */
    }

    .glass-panel h2 {
        font-family: 'Vollkorn', serif;
        font-size: 2.2rem;
        margin: 0 0 0.5rem 0;
        color: var(--te-gold);
    }

    .glass-panel p {
        font-family: sans-serif;
        font-size: 1.1rem;
        line-height: 1.6;
        margin: 0;
        opacity: 0.9;
    }

    /* Specific Stage Alignments */
    .stage-center {
        justify-content: center;
        text-align: center;
    }

    .stage-left {
        justify-content: flex-start;
        padding-left: 10%;
    }

    .stage-right {
        justify-content: flex-end;
        padding-right: 10%;
    }

    /* Contact Button */
    .btn-contact {
        display: inline-block;
        margin-top: 1.5rem;
        padding: 1rem 2rem;
        background: var(--te-gold);
        color: var(--te-green);
        text-decoration: none;
        font-weight: 700;
        border-radius: 50px;
        transition: transform 0.2s;
    }

    .btn-contact:hover {
        transform: scale(1.05);
    }

    /* CUSTOM INTEGRATED FOOTER */
    .integrated-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 1.5rem 2rem;
        background: linear-gradient(to top, rgba(16, 39, 36, 0.95), transparent);
        color: rgba(255, 255, 255, 0.6);
        text-align: center;
        font-size: 0.85rem;
        z-index: 20;
        opacity: 0;
        /* Hidden initially, revealed by GSAP */
        pointer-events: none;
        /* Let events pass until visible */
    }

    /* Mobile Adjustments */
    @media (max-width: 768px) {
        .glass-panel {
            padding: 1.5rem;
            margin: 0 1rem;
            max-width: 100%;
        }

        .glass-panel h2 {
            font-size: 1.8rem;
        }

        .stage-left,
        .stage-right {
            justify-content: center;
            padding-left: 1rem;
            padding-right: 1rem;
            text-align: center;
            /* Center everything on mobile usually looks better */
        }
    }
</style>

<!-- LOADER -->
<div id="scrolly-loader">
    <div class="loader-spinner"></div>
    <div>Carregando Inspeção...</div>
</div>

<!-- MAIN CONTAINER -->
<div class="scrolly-wrapper">

    <!-- STICKY CANVAS -->
    <div class="sticky-canvas-container">
        <canvas id="stone-canvas"></canvas>
    </div>

    <!-- TEXT STAGES -->
    <div class="scrolly-text-layer">
        <!-- Stages 1-5 -->
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
</div>

<!-- INTEGRATED FOOTER -->
<div class="integrated-footer" id="te-footer-overlay">
    © <?php echo date('Y'); ?> Trade Expansion - Excellence in Stone Inspection.
</div>

<!-- GSAP + SCROLLTRIGGER -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Initializing Retina Scrollytelling...");

        gsap.registerPlugin(ScrollTrigger);

        const canvas = document.getElementById("stone-canvas");
        const context = canvas.getContext("2d", { alpha: false });
        // Apply Hardware Accelerated Filter (Contrast/Brightness pop)
        context.filter = 'contrast(1.1) brightness(1.05)';

        const totalFrames = 300;
        const framePath = "<?php echo $base_asset_path; ?>";

        // State object to hold current frame index
        const playhead = { frame: 0 };

        // Images cache
        const images = [];
        const imagesToLoadInitially = 50;
        let imagesLoadedCount = 0;
        let isLoaded = false;

        // Helper to format frame number (e.g., 1 -> "001")
        const getFrameUrl = (index) => {
            const paddedIndex = String(index + 1).padStart(3, '0');
            return `${framePath}frame_${paddedIndex}.jpg`;
        };

        // --- 1. RESIZE & CANVAS SETUP (RETINA FIX) ---
        function resizeCanvas() {
            // Get Device Pixel Ratio (e.g., 2 for Retina, 3 for Super Retina)
            const dpr = window.devicePixelRatio || 1;

            // CSS Display Size (Visual)
            const displayWidth = window.innerWidth;
            const displayHeight = window.innerHeight;

            // Internal Canvas Size (Physical Pixels)
            canvas.width = displayWidth * dpr;
            canvas.height = displayHeight * dpr;

            // Enforce CSS size to match window
            canvas.style.width = displayWidth + "px";
            canvas.style.height = displayHeight + "px";

            // --- Note: We do NOT use context.scale(dpr, dpr) here.
            // Instead, we will scale the image drawing coordinates to map 
            // the visual dimensions to the physical pixel dimensions manually 
            // to ensure "cover" logic works on the physical buffer. ---

            // Re-apply filter after resize (context reset)
            context.filter = 'contrast(1.1) brightness(1.05)';

            render();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        // --- 2. IMAGE PRELOADING ---
        function preloadImages() {
            for (let i = 0; i < totalFrames; i++) {
                const img = new Image();
                img.src = getFrameUrl(i);
                images.push(img);

                if (i < imagesToLoadInitially) {
                    img.onload = () => {
                        imagesLoadedCount++;
                        // Update loader text occasionally
                        if (imagesLoadedCount % 10 === 0) {
                            const loaderTxt = document.querySelector('#scrolly-loader div:not(.loader-spinner)');
                            if (loaderTxt) loaderTxt.innerText = `Carregando Imersão... ${Math.round((imagesLoadedCount / imagesToLoadInitially) * 100)}%`;
                        }

                        if (imagesLoadedCount === imagesToLoadInitially && !isLoaded) {
                            startAnimation();
                        }
                    };
                    img.onerror = () => {
                        console.error(`Failed to load frame ${i}: ${img.src}`);
                        const loaderTxt = document.querySelector('#scrolly-loader div:not(.loader-spinner)');
                        if (loaderTxt) loaderTxt.innerHTML = `<span style="color:#ff6b6b">Erro.<br>${img.src}</span>`;
                    };
                }
            }
        }

        // --- 3. RENDER LOOP (ASPECT FILL / COVER) ---
        // Mimic 'object-fit: cover' behavior
        function render() {
            const img = images[Math.round(playhead.frame)]; // Round to nearest integer frame
            if (!img || !img.complete) return;

            // Current logical dimensions
            const cw = canvas.width;  // Physical width
            const ch = canvas.height; // Physical height

            // We want to fill 'cw' and 'ch' with 'img' preserving aspect ratio.
            const imgRatio = img.width / img.height;
            const canvasRatio = cw / ch;

            let drawWidth, drawHeight, offsetX, offsetY;

            if (canvasRatio > imgRatio) {
                // Canvas is wider relative to height -> Limit by Width
                drawWidth = cw;
                drawHeight = cw / imgRatio;
                offsetX = 0;
                offsetY = (ch - drawHeight) / 2;
            } else {
                // Canvas is taller relative to width -> Limit by Height
                drawHeight = ch;
                drawWidth = ch * imgRatio;
                offsetX = (cw - drawWidth) / 2;
                offsetY = 0;
            }

            // Draw to physical pixels
            context.drawImage(img, offsetX, offsetY, drawWidth, drawHeight);
        }

        // --- 4. START ANIMATION (INIT) ---
        function startAnimation() {
            isLoaded = true;

            // Hide loader
            gsap.to("#scrolly-loader", {
                opacity: 0,
                duration: 1.0,
                ease: "power2.out",
                onComplete: () => {
                    document.getElementById("scrolly-loader").style.display = 'none';
                }
            });

            // Setup ScrollTrigger for Image Sequence
            gsap.to(playhead, {
                frame: totalFrames - 1,
                snap: "frame", // Optional: snap to whole numbers if jittery, but 'round' in render handles it
                ease: "none",
                scrollTrigger: {
                    trigger: ".scrolly-wrapper",
                    start: "top top",
                    end: "bottom bottom",
                    scrub: 1.5, // Momentum scrubbing
                },
                onUpdate: render
            });

            setupTextAnimations();
            render(); // First frame
        }

        // --- 5. CINEMATIC TEXT REVEAL (Blur Focus) ---
        function setupTextAnimations() {
            const stages = ["#stage-1", "#stage-2", "#stage-3", "#stage-4", "#stage-5"];

            stages.forEach((stageId, index) => {
                const startPct = index * 0.2;

                // "Focus Reveal": Blur + Opacity + slight Y move
                // We animate the .glass-panel inside the stage
                const panel = document.querySelector(`${stageId} .glass-panel`);

                if (panel) {
                    gsap.fromTo(panel,
                        {
                            opacity: 0,
                            y: 40,
                            filter: "blur(15px)"
                        },
                        {
                            opacity: 1,
                            y: 0,
                            filter: "blur(0px)",
                            duration: 1,
                            ease: "power3.out",
                            scrollTrigger: {
                                trigger: ".scrolly-wrapper",
                                start: `top+=${startPct * 100}% top`,
                                end: `top+=${(startPct + 0.1) * 100}% top`,
                                scrub: true,
                                toggleActions: "play reverse play reverse"
                            }
                        }
                    );

                    // Fade Out (except last)
                    if (index < stages.length - 1) {
                        gsap.to(panel, {
                            opacity: 0,
                            y: -40,
                            filter: "blur(10px)",
                            scrollTrigger: {
                                trigger: ".scrolly-wrapper",
                                start: `top+=${(startPct + 0.15) * 100}% top`,
                                end: `top+=${(startPct + 0.2) * 100}% top`,
                                scrub: true
                            }
                        });
                    }
                }
            });

            // Footer Fade In
            const footer = document.getElementById("te-footer-overlay");
            gsap.to(footer, {
                opacity: 1,
                pointerEvents: "auto",
                scrollTrigger: {
                    trigger: ".scrolly-wrapper",
                    start: "90% bottom", // Near end
                    end: "bottom bottom",
                    scrub: true
                }
            });
        }

        // Kickoff
        preloadImages();
    });
</script>

<?php get_footer(); ?>