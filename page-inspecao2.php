<?php
/**
 * Template Name: Inspeção Técnica Scrollytelling
 * Description: Experiência de Scrollytelling para Trade Expansion
 */

get_header();

// Asset paths
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
        /* Will be controlled by JS for object-fit behavior */
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
        opacity: 0;
        /* Hidden by default, controlled by GSAP */
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
        transform: translateY(20px);
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

        <!-- Stage 1 (0-20%) -->
        <div class="scrolly-stage stage-center" id="stage-1">
            <div class="glass-panel">
                <h2>A Origem</h2>
                <p>Seleção rigorosa na pedreira.</p>
            </div>
        </div>

        <!-- Stage 2 (20-40%) -->
        <div class="scrolly-stage stage-left" id="stage-2">
            <div class="glass-panel">
                <h2>Curadoria Técnica</h2>
                <p>Identificando o bloco perfeito com critérios objetivos.</p>
            </div>
        </div>

        <!-- Stage 3 (40-60%) -->
        <div class="scrolly-stage stage-right" id="stage-3">
            <div class="glass-panel">
                <h2>Engenharia de Precisão</h2>
                <p>A transformação bruta em chapas de alta performance.</p>
            </div>
        </div>

        <!-- Stage 4 (60-80%) -->
        <div class="scrolly-stage stage-left" id="stage-4">
            <div class="glass-panel">
                <h2>Refinamento</h2>
                <p>Escaneamento digital de veios, fissuras e integridade.</p>
            </div>
        </div>

        <!-- Stage 5 (80-100%) -->
        <div class="scrolly-stage stage-center" id="stage-5">
            <div class="glass-panel">
                <h2>Incerteza Zero</h2>
                <p>Sua carga aprovada, garantida e pronta para embarque.</p>
                <a href="/contato" class="btn-contact">Falar com Especialista</a>
            </div>
        </div>

    </div>
</div>

<!-- GSAP + SCROLLTRIGGER -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Initializing Scrollytelling...");

        gsap.registerPlugin(ScrollTrigger);

        const canvas = document.getElementById("stone-canvas");
        const context = canvas.getContext("2d", { alpha: false }); // Optimize for no transparency
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

        // --- 1. RESIZE & CANVAS SETUP ---
        function resizeCanvas() {
            // Mobile Optimization: Render at lower resolution on small screens
            const dpr = window.devicePixelRatio || 1;
            const isMobile = window.innerWidth < 768;
            const scaleFactor = isMobile ? 0.6 : 1; // Downscale canvas on mobile for FPS

            canvas.width = window.innerWidth * dpr * scaleFactor;
            canvas.height = window.innerHeight * dpr * scaleFactor;

            // CSS display size
            canvas.style.width = window.innerWidth + "px";
            canvas.style.height = window.innerHeight + "px";

            // Reset context scale
            context.scale(dpr * scaleFactor, dpr * scaleFactor);

            render(); // Re-render current frame
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
                            if (loaderTxt) loaderTxt.innerText = `Carregando... ${Math.round((imagesLoadedCount / imagesToLoadInitially) * 100)}%`;
                        }

                        if (imagesLoadedCount === imagesToLoadInitially && !isLoaded) {
                            startAnimation();
                        }
                    };
                    img.onerror = () => {
                        console.error(`Failed to load frame ${i} at: ${img.src}`);
                        // Show error to user
                        const loaderTxt = document.querySelector('#scrolly-loader div:not(.loader-spinner)');
                        if (loaderTxt) {
                            loaderTxt.innerHTML = `<span style="color: #ff6b6b">Erro ao carregar imagens.<br>Verifique o console (F12).</span><br><small>${img.src}</small>`;
                        }
                        // Stop spinner
                        const spinner = document.querySelector('.loader-spinner');
                        if (spinner) spinner.style.borderTopColor = '#ff6b6b';
                        if (spinner) spinner.style.animation = 'none';

                        // Still try to continue if possible, or just halt? 
                        // Let's halt for the first batch to avoid broken experiences.
                    };
                }
            }
        }

        // --- 3. RENDER LOOP ---
        // Mimic 'object-fit: cover' behavior
        function render() {
            const img = images[Math.round(playhead.frame)]; // Round to nearest integer frame
            if (!img || !img.complete) return;

            const cw = canvas.width / (window.devicePixelRatio || 1) / (window.innerWidth < 768 ? 0.6 : 1); // logic inversion from resize
            const ch = canvas.height / (window.devicePixelRatio || 1) / (window.innerWidth < 768 ? 0.6 : 1);

            // Calculate aspect ratios
            const imgRatio = img.width / img.height;
            const canvasRatio = cw / ch;

            let drawWidth, drawHeight, offsetX, offsetY;

            if (canvasRatio > imgRatio) {
                // Canvas is wider than image
                drawWidth = cw;
                drawHeight = cw / imgRatio;
                offsetX = 0;
                offsetY = (ch - drawHeight) / 2;
            } else {
                // Canvas is taller than image
                drawHeight = ch;
                drawWidth = ch * imgRatio;
                offsetX = (cw - drawWidth) / 2;
                offsetY = 0;
            }

            context.drawImage(img, offsetX, offsetY, drawWidth, drawHeight);
        }

        // --- 4. START ANIMATION (INIT) ---
        function startAnimation() {
            isLoaded = true;

            // Hide loader
            gsap.to("#scrolly-loader", {
                opacity: 0, duration: 0.8, onComplete: () => {
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
                    scrub: 0.5, // Smooth scrubbing (0.5s lag)
                },
                onUpdate: render
            });

            setupTextAnimations();
            render(); // First frame
        }

        // --- 5. TEXT STAGE ANIMATIONS ---
        function setupTextAnimations() {
            // We can hook into the same scroll timeline or create separate triggers
            // Since wrapper is 600vh, we can map percentages:
            // 0-20% = Stage 1, 20-40% = Stage 2, etc.

            const stages = ["#stage-1", "#stage-2", "#stage-3", "#stage-4", "#stage-5"];

            stages.forEach((stageId, index) => {
                const startPct = index * 0.2; // 0, 0.2, 0.4...
                // Trigger logic: Fade In at start of segment, Fade Out before end of segment

                // Fade In
                gsap.fromTo(stageId,
                    { opacity: 0, y: 50 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        scrollTrigger: {
                            trigger: ".scrolly-wrapper",
                            start: `top+=${startPct * 100}% top`,
                            end: `top+=${(startPct + 0.1) * 100}% top`, // Fade in over first half of segment
                            scrub: true,
                            toggleActions: "play reverse play reverse"
                        }
                    }
                );

                // Fade Out (except last one maybe? No, let's fade out all to keep focus)
                if (index < stages.length - 1) {
                    gsap.to(stageId, {
                        opacity: 0,
                        y: -50,
                        scrollTrigger: {
                            trigger: ".scrolly-wrapper",
                            start: `top+=${(startPct + 0.15) * 100}% top`, // Start fading out near end of segment
                            end: `top+=${(startPct + 0.2) * 100}% top`,
                            scrub: true
                        }
                    });
                }
            });
        }

        // Kickoff
        preloadImages();
    });
</script>

<?php get_footer(); ?>