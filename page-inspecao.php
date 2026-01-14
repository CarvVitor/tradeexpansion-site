<?php
/**
 * Template Name: Inspeção Técnica
 * Description: Página institucional de Inspeção Técnica de Rochas Ornamentais
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- HEADER COM FUNDO SEMI-TRANSPARENTE ESCURO -->
<header style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; padding: 1.5rem 2rem; background: rgba(16, 39, 36, 0.9); backdrop-filter: blur(10px); transition: all 0.4s ease;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
        <!-- Logo -->
        <a href="<?php echo home_url(); ?>" style="font-family: 'Volkhorn', serif; font-size: 1.5rem; font-weight: 300; color: #F1F1D9; text-decoration: none; letter-spacing: 0.1em; transition: color 0.3s;">
            TRADE EXPANSION
        </a>
        
        <!-- Menu -->
        <nav style="display: flex; gap: 2.5rem; align-items: center;">
            <a href="<?php echo home_url(); ?>" style="color: #E1E2DA; text-decoration: none; font-size: 0.95rem; letter-spacing: 0.05em; transition: color 0.3s; font-family: 'Volkhorn', serif;">Home</a>
            <a href="<?php echo home_url('/sobre'); ?>" style="color: #E1E2DA; text-decoration: none; font-size: 0.95rem; letter-spacing: 0.05em; transition: color 0.3s; font-family: 'Volkhorn', serif;">About</a>
            <a href="#contact" style="color: #E1E2DA; text-decoration: none; font-size: 0.95rem; letter-spacing: 0.05em; transition: color 0.3s; font-family: 'Volkhorn', serif;">Contact</a>
            <a href="#contact" style="padding: 0.8rem 1.8rem; background: #5D2713; color: #F1F1D9; text-decoration: none; border-radius: 50px; font-size: 0.9rem; letter-spacing: 0.05em; transition: all 0.3s; font-family: 'Volkhorn', serif; box-shadow: 0 4px 15px rgba(93, 39, 19, 0.3);">Get Quote</a>
        </nav>
    </div>
</header>

<!-- Compensar altura do header fixo -->
<body {
  margin: 0 !important;
  padding: 0 !important;
}
>
<!-- CSS Customizado -->
<style>
  
:root {
  --primary: #484942;
  --secondary: #102724;
  --accent: #5D2713;
  --text: #E1E2DA;
  --cream: #F1F1D9;
  --gold: #D6A354;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Volkhorn', Georgia, serif;
  color: var(--primary);
  overflow-x: hidden;
}

/* Garantir que seções não se sobreponham */
section {
  position: relative;
  clear: both;
  width: 100%;
  overflow: hidden;
}

/* Header responsivo */
@media (max-width: 768px) {
  header nav {
    display: none !important;
  }
  
  header::after {
    content: '☰';
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--cream);
    font-size: 1.8rem;
    cursor: pointer;
  }
}

/* ==================== HERO SECTION ==================== */
.hero-section {
  position: relative;
  height: 100vh;
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.hero-video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translate(-50%, -50%);
  z-index: 0;
  object-fit: cover;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(180deg, rgba(16, 39, 36, 0.6) 0%, rgba(93, 39, 19, 0.4) 100%);
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 0 2rem;
  max-width: 1200px;
}

.hero-title {
  font-size: clamp(3rem, 8vw, 6rem);
  font-weight: 300;
  color: var(--cream);
  letter-spacing: 0.02em;
  margin-bottom: 1.5rem;
  line-height: 1.1;
}

.hero-subtitle {
  font-size: clamp(1.2rem, 2.5vw, 1.8rem);
  color: var(--text);
  font-weight: 300;
  letter-spacing: 0.05em;
  margin-bottom: 3rem;
  opacity: 0.9;
}

.hero-cta {
  display: inline-block;
  padding: 1.2rem 3rem;
  background: transparent;
  border: 2px solid var(--cream);
  color: var(--cream);
  font-size: 1rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.4s ease;
  font-family: 'Volkhorn', serif;
}

.hero-cta:hover {
  background: var(--cream);
  color: var(--primary);
  transform: translateY(-3px);
}

/* ==================== TRUSTED NUMBERS ==================== */
.trusted-numbers {
  background: linear-gradient(180deg, #F1F1D9 0%, #E5E5D5 100%);
  padding: 5rem 2rem;
}

.numbers-grid {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 3rem;
  text-align: center;
}

.number-value {
  font-size: clamp(3.5rem, 6vw, 5rem);
  font-weight: 300;
  color: var(--accent);
  margin-bottom: 0.5rem;
}

.number-label {
  font-size: 1rem;
  color: var(--primary);
  letter-spacing: 0.15em;
  text-transform: uppercase;
}

/* ==================== WHAT IS SECTION ==================== */
.what-is-section {
  background: linear-gradient(180deg, #E5E5D5 0%, #D8D8C8 100%);
  padding: 8rem 2rem;
}

.what-is-content {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  align-items: center;
}

.what-is-text h2 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--primary);
  margin-bottom: 2rem;
}

.what-is-text p {
  font-size: 1.15rem;
  line-height: 1.8;
  color: var(--primary);
  opacity: 0.85;
  margin-bottom: 1.5rem;
}

.what-is-image {
  width: 100%;
  height: 600px;
  border-radius: 8px;
  overflow: hidden;
}

.what-is-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* ==================== PROCESS SECTION ==================== */
.process-section {
  background: linear-gradient(180deg, #D8D8C8 0%, #C0C0B0 100%);
  padding: 8rem 2rem;
  color: var(--primary); /* Texto escuro */
}

.process-header {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 5rem;
}

.process-header h2 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--cream);
}

.process-timeline {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 3rem;
}

.process-step {
  text-align: center;
  padding: 2rem;
}

.process-number {
  font-size: 4rem;
  font-weight: 300;
  color: var(--gold);
  opacity: 0.3;
  margin-bottom: 1rem;
}

.process-step h3 {
  font-size: 1.5rem;
  color: var(--cream);
  margin-bottom: 1rem;
}

/* ==================== BENEFITS SECTION ==================== */
.benefits-section {
  background: linear-gradient(180deg, #C0C0B0 0%, #A8A898 100%);
  padding: 8rem 2rem;
  color: var(--primary); /* Texto escuro */
}

.benefits-header {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 5rem;
}

.benefits-header h2 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--cream);
}

.benefits-grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 3rem;
}

.benefit-card {
  padding: 3rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 8px;
}

.benefit-card h3 {
  font-size: 1.5rem;
  color: var(--cream);
  margin-bottom: 1rem;
}

/* ==================== CONTACT SECTION ==================== */
.contact-section {
  background: linear-gradient(180deg, #A8A898 0%, #E5E5D5 100%);
  padding: 8rem 2rem;
}

.contact-content {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
}

.contact-content h2 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--primary);
  margin-bottom: 1.5rem;
}

.contact-form {
  display: grid;
  gap: 1.5rem;
  margin-top: 3rem;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 1.2rem;
  border: 2px solid rgba(72, 73, 66, 0.2);
  background: white;
  font-family: 'Volkhorn', serif;
  font-size: 1rem;
  border-radius: 4px;
}

.form-submit {
  padding: 1.2rem 3rem;
  background: var(--accent);
  border: none;
  color: var(--cream);
  font-size: 1rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  cursor: pointer;
  font-family: 'Volkhorn', serif;
  border-radius: 4px;
  margin-top: 1rem;
  transition: all 0.4s ease;
}

.form-submit:hover {
  background: var(--primary);
  transform: translateY(-3px);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 968px) {
  .what-is-content {
    grid-template-columns: 1fr;
  }
  
  .what-is-image {
    height: 400px;
  }
  
  .process-timeline,
  .benefits-grid {
    grid-template-columns: 1fr;
  }
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes bounce {
  0%, 100% {
    transform: translateX(-50%) translateY(0);
  }
  50% {
    transform: translateX(-50%) translateY(-10px);
  }
}

/* ========== MICROINTERAÇÕES ========== */
@media (min-width: 1024px) {
  body {
    cursor: url('image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8" fill="rgba(93,39,19,0.2)"/></svg>'), auto;
  }
  
  a, button {
    cursor: url('image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="16" r="12" fill="rgba(93,39,19,0.4)"/></svg>'), pointer;
  }
}

html {
  scroll-behavior: smooth;
}

.hero-video {
  transform: translate(-50%, -50%) scale(1.1);
  transition: transform 8s ease-out;
}

.hero-section:hover .hero-video {
  transform: translate(-50%, -50%) scale(1);
}

/* Reduzir padding em mobile */
  .what-is-section,
  .process-section,
  .benefits-section,
  .gallery-section,
  .contact-section {
    padding: 4rem 1.5rem;
  }
  
  .numbers-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .number-value {
    font-size: 3rem;
  }
  
  /* Floating CTA menor em mobile */
  #floating-cta {
    bottom: 1rem;
    right: 1rem;
  }
  
  #floating-cta a {
    padding: 0.8rem 1.2rem;
    font-size: 0.85rem;
  }

/* ==================== CORREÇÃO ÍCONES E IMAGENS ==================== */

/* Controlar tamanho dos ícones nos cards de benefícios */
.benefit-card svg {
  width: 50px;
  height: 50px;
  margin-bottom: 1.5rem;
  color: var(--gold);
}

/* Controlar tamanho dos ícones no processo */
.process-step svg {
  width: 60px;
  height: 60px;
  margin: 0 auto 1.5rem;
  color: var(--gold);
}

/* Texto dos cards */
.benefit-card p,
.process-step p {
  font-size: 1rem;
  line-height: 1.7;
  opacity: 0.85;
}

/* ==================== GALERIA CORRIGIDA ==================== */
.gallery-section {
  padding: 8rem 2rem;
  background: #fff;
}

.gallery-header {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 5rem;
}

.gallery-header h2 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--primary);
  margin-bottom: 1rem;
}

.gallery-grid {
  max-width: 1600px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 2rem;
}

.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  height: 400px;
  cursor: pointer;
}

.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.gallery-item:hover img {
  transform: scale(1.1);
}

.gallery-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
  padding: 2rem;
  transform: translateY(100%);
  transition: transform 0.4s ease;
}

.gallery-item:hover .gallery-overlay {
  transform: translateY(0);
}

.gallery-overlay h3 {
  color: white;
  font-size: 1.2rem;
  font-weight: 400;
  margin-bottom: 0.5rem;
}

.gallery-overlay p {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.9rem;
}

/* ========== HEADER FIXO ========== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  padding: 1.5rem 2rem;
  background: rgba(241, 241, 217, 0);
  backdrop-filter: blur(0px);
  transition: all 0.4s ease;
}

.site-header.scrolled {
  background: rgba(16, 39, 36, 0.6);
  backdrop-filter: blur(10px);
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
  padding: 1rem 2rem;
}

/* Compensar altura do header fixo */

<!-- FLOATING CTA BUTTON -->
<div id="floating-cta" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 100; opacity: 0; transform: translateY(20px); transition: all 0.4s ease;">
  <a href="#contact" style="display: flex; align-items: center; gap: 0.8rem; background: var(--accent); color: var(--cream); padding: 1rem 1.5rem; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 40px rgba(93, 39, 19, 0.3); font-size: 0.95rem; letter-spacing: 0.05em; font-weight: 500;">
    <span>Request Inspection</span>
    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
  </a>
</div>

<script>
window.addEventListener('scroll', () => {
  const cta = document.getElementById('floating-cta');
  if (window.scrollY > 800) {
    cta.style.opacity = '1';
    cta.style.transform = 'translateY(0)';
  } else {
    cta.style.opacity = '0';
    cta.style.transform = 'translateY(20px)';
  }
});
</script>

<!-- LOADING SCREEN -->
<div id="loading-screen" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: var(--cream); z-index: 9999; display: flex; align-items: center; justify-content: center; transition: opacity 0.8s ease;">
  <div style="text-align: center;">
    <div style="width: 50px; height: 50px; border: 2px solid var(--accent); border-top-color: transparent; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1.5rem;"></div>
    <p style="font-size: 0.875rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--primary);">Loading Excellence</p>
  </div>
</div>

<style>
@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>

<script>
window.addEventListener('load', () => {
  const loader = document.getElementById('loading-screen');
  loader.style.opacity = '0';
  setTimeout(() => loader.style.display = 'none', 800);
});
</script>

</style>

<!-- HERO SECTION -->
<section class="hero-section">
  <!-- Vídeo de fundo - SUBSTITUA pela URL do seu vídeo -->
  <video class="hero-video" autoplay muted loop playsinline>
    <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/inspection-hero.mp4" type="video/mp4">
    <!-- Fallback: use imagem se não tiver vídeo -->
  </video>
  
  <div class="hero-overlay"></div>
  
  <div class="hero-content">
    <h1 class="hero-title">Excellence Carved in Stone</h1>
    <p class="hero-subtitle">25 Years Inspecting Brazil's Finest Ornamental Stones</p>
    <a href="#contact" class="hero-cta">Request Inspection</a>
  </div>
  
  <div class="scroll-indicator">Scroll Down</div>
</section>

<!-- TRUSTED NUMBERS -->
<section class="trusted-numbers">
  <div class="numbers-grid">
    <div class="number-item">
      <div class="number-value">25+</div>
      <div class="number-label">Years of Excellence</div>
    </div>
    <div class="number-item">
      <div class="number-value">2000+</div>
      <div class="number-label">Inspections Completed</div>
    </div>
    <div class="number-item">
      <div class="number-value">30+</div>
      <div class="number-label">Countries Served</div>
    </div>
  </div>
</section>

<!-- TRUSTED BY LOGOS -->
<section style="background:rgba(16, 39, 36, 0.9); padding: 4rem 2rem; border-top: 1px solid rgba(72,73,66,0.1);">
  <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
    <p style="font-size: 0.875rem; letter-spacing: 0.2em; text-transform: uppercase; color: #F1F1D9; opacity: 0.7; margin-bottom: 2rem;">Trusted Worldwide</p>
    <div style="display: flex; justify-content: center; align-items: center; gap: 4rem; flex-wrap: wrap; opacity: 0.4; filter: grayscale(100%);">
      <!-- SUBSTITUA por logos reais de clientes (PNG ou SVG, altura ~40px) -->
      <div style="font-size: 1.5rem; color: #F1F1D9; font-weight: 300; letter-spacing: 0.1em;">CLIENT LOGO 1</div>
      <div style="font-size: 1.5rem; color: #F1F1D9; font-weight: 300; letter-spacing: 0.1em;">CLIENT LOGO 2</div>
      <div style="font-size: 1.5rem; color: #F1F1D9; font-weight: 300; letter-spacing: 0.1em;">CLIENT LOGO 3</div>
      <div style="font-size: 1.5rem; color: #F1F1D9; font-weight: 300; letter-spacing: 0.1em;">CLIENT LOGO 4</div>
      <div style="font-size: 1.5rem; color: #F1F1D9; font-weight: 300; letter-spacing: 0.1em;">CLIENT LOGO 5</div>
    </div>
  </div>
</section>

<!-- WHAT IS SECTION -->
<section class="what-is-section">
  <div class="what-is-content">
    <div class="what-is-text">
      <h2>Your Strategic Partner for Stone Inspection in Brazil</h2>
      <p>We are Trade Expansion, specialists in the inspection of marble, granite, and ornamental stones. For over 25 years, we've been connecting Brazilian suppliers with international clients, ensuring quality, compliance, and trust.</p>
      <p>Acting as your eyes and hands in Brazil, we deliver detailed reports, technical precision, and unmatched reliability. Every slab, every block, every detail—inspected to perfection.</p>
    </div>
    <div class="what-is-image">
      <!-- SUBSTITUA pela imagem real -->
      <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=800" alt="Stone Inspection">
    </div>
  </div>
</section>

<!-- PROCESS SECTION -->
<section class="process-section">
  <div class="process-header">
    <h2>Our Meticulous Process</h2>
  </div>
  
  <div class="process-timeline">
    <div class="process-step">
      <div class="process-number">01</div>
      <svg class="process-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
      </svg>
      <h3>Initial Consultation</h3>
      <p>We understand your project requirements, specifications, and quality standards in detail.</p>
    </div>
    
    <div class="process-step">
      <div class="process-number">02</div>
      <svg class="process-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <h3>On-Site Inspection</h3>
      <p>Our experts visit quarries, factories, or ports to inspect materials with precision and thoroughness.</p>
    </div>
    
    <div class="process-step">
      <div class="process-number">03</div>
      <svg class="process-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3>Quality Assessment</h3>
      <p>We evaluate integrity, dimensions, finish, color consistency, and compliance with international standards.</p>
    </div>
    
    <div class="process-step">
      <div class="process-number">04</div>
      <svg class="process-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3>Detailed Reporting</h3>
      <p>You receive comprehensive reports with photos, measurements, and technical analysis within 24-48 hours.</p>
    </div>
    
    <div class="process-step">
      <div class="process-number">05</div>
      <svg class="process-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
      </svg>
      <h3>Ongoing Support</h3>
      <p>We provide continuous assistance and follow-up to ensure your complete satisfaction and project success.</p>
    </div>
  </div>
</section>

<!-- ==================== CASE STUDY: REAL RESULTS ==================== -->
<section style="background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%); padding: 8rem 2rem; color: var(--text); position: relative; overflow: hidden;">
  
  <!-- Padrão de fundo sutil -->
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.03; background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px); pointer-events: none;"></div>
  
  <div style="max-width: 1400px; margin: 0 auto; position: relative; z-index: 1;">
    
    <!-- Header da seção -->
    <div style="text-align: center; margin-bottom: 5rem;">
      <p style="font-size: 0.875rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; font-weight: 500;">Success Story</p>
      <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 300; color: var(--cream); margin-bottom: 1rem; line-height: 1.2;">Real Results, Real Savings</h2>
      <p style="font-size: 1.15rem; opacity: 0.8; max-width: 600px; margin: 0 auto;">See how our inspection prevented a costly mistake for a major international client</p>
    </div>
    
    <!-- Conteúdo do Case Study -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
      
      <!-- Imagem com selo REJECTED -->
      <div style="position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);">
        <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=800&q=80&auto=format&fit=crop" alt="Rejected Stone Shipment" style="width: 100%; display: block; filter: grayscale(100%) brightness(0.5);">
        
        <!-- Selo vermelho de REJECTED -->
        <div style="position: absolute; top: 40%; left: 60%; transform: translate(-40%, -70%) rotate(-15deg);">
          <div style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%); color: white; width: 120px; height: 120px; border-radius: 40%; display: flex; align-items: center; justify-content: center; flex-direction: column; box-shadow: 0 15px 35px rgba(220, 38, 38, 0.6); border: 4px solid rgba(255, 255, 255, 0.9);">
            <span style="font-size: 3.5rem; font-weight: bold; line-height: 1; margin-bottom: -10px;">✗</span>
            <span style="font-size: 0.9rem; font-weight: 600; letter-spacing: 0.1em;">REJECTED</span>
          </div>
        </div>
        
        <!-- Tag de valor salvo -->
        <div style="position: absolute; bottom: 2rem; left: 2rem; background: rgba(16, 39, 36, 0.95); backdrop-filter: blur(10px); padding: 1rem 1.5rem; border-radius: 8px; border-left: 4px solid var(--gold);">
          <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gold); margin-bottom: 0.3rem;">Loss Prevented</p>
          <p style="font-size: 1.8rem; font-weight: 600; color: white; margin: 0;">$180,000</p>
        </div>
      </div>
      
      <!-- Texto do Case Study -->
      <div>
        <h3 style="font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--cream); margin-bottom: 1.5rem; line-height: 1.2; font-weight: 400;">Critical Defects Identified Before Shipment</h3>
        
        <p style="font-size: 1.1rem; line-height: 1.8; opacity: 0.85; margin-bottom: 2rem;">
          A major European importer ordered 40 marble slabs from a Brazilian supplier. Our pre-shipment inspection uncovered critical defects that would have resulted in <strong style="color: var(--gold);">complete project rejection</strong> and a six-month delay.
        </p>
        
        <!-- Lista de descobertas -->
        <div style="background: rgba(241, 241, 217, 0.05); border-left: 3px solid var(--gold); padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
          <h4 style="font-size: 1rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--gold); margin-bottom: 1.5rem; font-weight: 600;">What We Found</h4>
          <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 1rem;">
              <span style="color: var(--gold); font-size: 1.5rem; line-height: 1; flex-shrink: 0;">✓</span>
              <span style="line-height: 1.6; opacity: 0.9;"><strong style="color: var(--cream);">Structural micro-cracks</strong> invisible to the naked eye, detected with specialized equipment</span>
            </li>
            <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 1rem;">
              <span style="color: var(--gold); font-size: 1.5rem; line-height: 1; flex-shrink: 0;">✓</span>
              <span style="line-height: 1.6; opacity: 0.9;"><strong style="color: var(--cream);">Color inconsistency</strong> across batches that didn't match client specifications</span>
            </li>
            <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 1rem;">
              <span style="color: var(--gold); font-size: 1.5rem; line-height: 1; flex-shrink: 0;">✓</span>
              <span style="line-height: 1.6; opacity: 0.9;"><strong style="color: var(--cream);">Dimensional errors</strong> in 12 slabs that would have prevented proper installation</span>
            </li>
            <li style="display: flex; align-items: flex-start; gap: 1rem;">
              <span style="color: var(--gold); font-size: 1.5rem; line-height: 1; flex-shrink: 0;">✓</span>
              <span style="line-height: 1.6; opacity: 0.9;"><strong style="color: var(--cream);">Surface defects</strong> that would have become visible only after installation</span>
            </li>
          </ul>
        </div>
        
        <!-- Resultado -->
        <div style="background: linear-gradient(135deg, rgba(211, 163, 84, 0.1) 0%, rgba(211, 163, 84, 0.05) 100%); padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(211, 163, 84, 0.2);">
          <p style="font-size: 1rem; line-height: 1.7; margin: 0; opacity: 0.95;">
            <strong style="color: var(--gold);">Result:</strong> The supplier replaced all defective materials at no cost to our client. The project was completed on time with flawless quality, and our client's reputation remained intact.
          </p>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Responsivo -->
  <style>
  @media (max-width: 968px) {
    section[style*="grid-template-columns: 1fr 1fr"] > div > div:nth-child(2) {
      grid-template-columns: 1fr !important;
      gap: 3rem !important;
    }
  }
  </style>
</section>

<!-- BENEFITS SECTION -->
<section class="benefits-section">
  <div class="benefits-header">
    <h2>Why Choose Trade Expansion</h2>
  </div>
  
  <div class="benefits-grid">
    <div class="benefit-card">
      <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
      </svg>
      <h3>Unmatched Expertise</h3>
      <p>25+ years of experience in ornamental stone inspection, serving the most demanding international markets.</p>
    </div>
    
    <div class="benefit-card">
      <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3>Local Knowledge, Global Standards</h3>
      <p>Deep understanding of Brazilian quarries and suppliers, combined with international quality certifications.</p>
    </div>
    
    <div class="benefit-card">
      <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3>Fast Turnaround</h3>
      <p>Detailed inspection reports delivered within 24-48 hours, keeping your projects on schedule.</p>
    </div>
    
    <div class="benefit-card">
      <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
      </svg>
      <h3>Complete Transparency</h3>
      <p>Honest assessments, detailed photographic documentation, and clear communication at every step.</p>
    </div>
  </div>
</section>

<!-- GALLERY SECTION -->
<section class="gallery-section">
  <div class="gallery-header">
    <h2>Our Work in Action</h2>
  </div>
  
  <div class="gallery-grid">
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=600" alt="Marble Inspection">
      <div class="gallery-overlay">
        <h3>Marble Slabs Inspection</h3>
        <p>Carrara White - São Paulo</p>
      </div>
    </div>
    
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=600" alt="Granite Blocks">
      <div class="gallery-overlay">
        <h3>Granite Blocks Quality Check</h3>
        <p>Black Galaxy - Espírito Santo</p>
      </div>
    </div>
    
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600" alt="Quarry Inspection">
      <div class="gallery-overlay">
        <h3>Quarry Site Inspection</h3>
        <p>Travertine Romano - Minas Gerais</p>
      </div>
    </div>
    
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1600566753151-384129cf4e3e?w=600" alt="Quality Control">
      <div class="gallery-overlay">
        <h3>Cut-to-Size Precision</h3>
        <p>Emperador Brown - Bahia</p>
      </div>
    </div>
    
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1615874694520-474822394e73?w=600" alt="Container Loading">
      <div class="gallery-overlay">
        <h3>Container Loading Supervision</h3>
        <p>Mixed Marble - Port of Santos</p>
      </div>
    </div>
    
    <div class="gallery-item">
      <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=600" alt="Final Inspection">
      <div class="gallery-overlay">
        <h3>Final Quality Inspection</h3>
        <p>Premium Granite Selection</p>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="contact-section">
  <div class="contact-content">
    <h2>Schedule Your Inspection</h2>
    <p>Ready to ensure the quality of your ornamental stones? Contact us today for a personalized consultation.</p>
    
    <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <input type="hidden" name="action" value="submit_inspection_request">
      <?php wp_nonce_field('inspection_request', 'inspection_nonce'); ?>
      
      <div class="form-group">
        <label for="name">Full Name *</label>
        <input type="text" id="name" name="name" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" required>
      </div>
      
      <div class="form-group">
        <label for="company">Company Name</label>
        <input type="text" id="company" name="company">
      </div>
      
      <div class="form-group">
        <label for="material">Material Type</label>
        <input type="text" id="material" name="material" placeholder="e.g., Granite, Marble, Travertine">
      </div>
      
      <div class="form-group">
        <label for="message">Project Details *</label>
        <textarea id="message" name="message" required placeholder="Tell us about your project, quantities, delivery location, and any specific requirements..."></textarea>
      </div>
      
      <button type="submit" class="form-submit">Send Request</button>
    </form>
  </div>
</section>

<script>
window.addEventListener('scroll', () => {
  const header = document.querySelector('.site-header');
  if (header) {
    if (window.scrollY > 100) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }
});
</script>

<!-- FOOTER CUSTOMIZADO LUXURY -->
<footer style="background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%); color: var(--text); padding: 5rem 2rem 2rem;">
  <div style="max-width: 1400px; margin: 0 auto;">
    
    <!-- Seção principal do footer -->
    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 4rem; margin-bottom: 4rem;">
      
      <!-- Coluna 1: Sobre -->
      <div>
        <h3 style="font-family: 'Volkhorn', serif; font-size: 1.8rem; font-weight: 300; color: var(--cream); margin-bottom: 1.5rem; letter-spacing: 0.1em;">TRADE EXPANSION</h3>
        <p style="font-size: 1rem; line-height: 1.8; opacity: 0.85; margin-bottom: 1.5rem; max-width: 400px;">Connecting Brazilian suppliers with international clients through precision, trust, and 25 years of excellence in ornamental stone inspection.</p>
        
        <!-- Ícones Sociais -->
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
          <a href="https://linkedin.com" target="_blank" style="width: 40px; height: 40px; border: 1px solid rgba(241, 241, 217, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cream); transition: all 0.3s; text-decoration: none;" onmouseover="this.style.background='var(--accent)'; this.style.borderColor='var(--accent)';" onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(241, 241, 217, 0.3)';">
            <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
          </a>
          <a href="https://instagram.com" target="_blank" style="width: 40px; height: 40px; border: 1px solid rgba(241, 241, 217, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cream); transition: all 0.3s; text-decoration: none;" onmouseover="this.style.background='var(--accent)'; this.style.borderColor='var(--accent)';" onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(241, 241, 217, 0.3)';">
            <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="mailto:contato@tradeexpansion.com.br" style="width: 40px; height: 40px; border: 1px solid rgba(241, 241, 217, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--cream); transition: all 0.3s; text-decoration: none;" onmouseover="this.style.background='var(--accent)'; this.style.borderColor='var(--accent)';" onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(241, 241, 217, 0.3)';">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </a>
        </div>
      </div>
      
      <!-- Coluna 2: Services -->
      <div>
        <h4 style="font-size: 1rem; font-weight: 600; color: var(--cream); margin-bottom: 1.5rem; letter-spacing: 0.1em; text-transform: uppercase;">Services</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Stone Inspection</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Quality Control</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Trade Consulting</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Market Access</a></li>
        </ul>
      </div>
      
      <!-- Coluna 3: Company -->
      <div>
        <h4 style="font-size: 1rem; font-weight: 600; color: var(--cream); margin-bottom: 1.5rem; letter-spacing: 0.1em; text-transform: uppercase;">Company</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 0.8rem;"><a href="<?php echo home_url('/sobre'); ?>" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">About Us</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Our Team</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Careers</a></li>
          <li style="margin-bottom: 0.8rem;"><a href="#contact" style="color: var(--text); text-decoration: none; opacity: 0.8; transition: all 0.3s; font-size: 0.95rem;" onmouseover="this.style.opacity='1'; this.style.color='var(--cream)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--text)';">Contact</a></li>
        </ul>
      </div>
      
      <!-- Coluna 4: Contact -->
      <div>
        <h4 style="font-size: 1rem; font-weight: 600; color: var(--cream); margin-bottom: 1.5rem; letter-spacing: 0.1em; text-transform: uppercase;">Contact</h4>
        <ul style="list-style: none; padding: 0; margin: 0;">
          <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.8rem; font-size: 0.95rem; opacity: 0.8; line-height: 1.6;">
            <svg style="width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            <span>+55 11 99999-9999</span>
          </li>
          <li style="margin-bottom: 1rem; display: flex; align-items: flex-start; gap: 0.8rem; font-size: 0.95rem; opacity: 0.8; line-height: 1.6;">
            <svg style="width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <a href="mailto:contato@tradeexpansion.com.br" style="color: var(--text); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--cream)';" onmouseout="this.style.color='var(--text)';">contato@tradeexpansion.com.br</a>
          </li>
          <li style="display: flex; align-items: flex-start; gap: 0.8rem; font-size: 0.95rem; opacity: 0.8; line-height: 1.6;">
            <svg style="width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>São Paulo, Brazil</span>
          </li>
        </ul>
      </div>
      
    </div>
    
    <!-- Linha divisória -->
    <div style="height: 1px; background: rgba(16, 39, 36, 0.6); margin: 3rem 0;"></div>
    
    <!-- Bottom bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; opacity: 0.7;">
      <p style="margin: 0;">© <?php echo date('Y'); ?> Trade Expansion. All rights reserved.</p>
      <div style="display: flex; gap: 2rem;">
        <a href="#" style="color: var(--text); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--cream)';" onmouseout="this.style.color='var(--text)';">Privacy Policy</a>
        <a href="#" style="color: var(--text); text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--cream)';" onmouseout="this.style.color='var(--text)';">Terms of Service</a>
      </div>
    </div>
    
  </div>
  
  <!-- Responsivo -->
  <style>
  @media (max-width: 968px) {
    footer > div > div:first-child {
      grid-template-columns: 1fr !important;
      gap: 3rem !important;
    }
    
    footer > div > div:last-child {
      flex-direction: column !important;
      gap: 1rem !important;
      text-align: center;
    }
  }
  </style>
</footer>

<!-- ==================== LOADING SCREEN LUXURY ==================== -->
<div id="luxury-loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #F1F1D9 0%, #E5E5D5 100%); z-index: 99999; display: flex; align-items: center; justify-content: center; transition: opacity 0.8s ease, visibility 0.8s ease;">
  <div style="text-align: center;">
    <!-- Logo animado -->
    <div style="width: 80px; height: 80px; margin: 0 auto 2rem; position: relative;">
      <div style="width: 80px; height: 80px; border: 3px solid var(--accent); border-top-color: transparent; border-radius: 50%; animation: luxurySpin 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite; position: absolute; top: 0; left: 0;"></div>
      <div style="width: 60px; height: 60px; border: 3px solid var(--gold); border-top-color: transparent; border-radius: 50%; animation: luxurySpin 1.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite reverse; position: absolute; top: 10px; left: 10px;"></div>
    </div>
    
    <!-- Texto elegante -->
    <p style="font-family: 'Volkhorn', Georgia, serif; font-size: 1rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--primary); font-weight: 300; opacity: 0; animation: fadeInText 0.8s ease 0.3s forwards;">Loading Excellence</p>
  </div>
</div>

<style>
/* Animação do spinner */
@keyframes luxurySpin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Animação do texto */
@keyframes fadeInText {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 0.7;
    transform: translateY(0);
  }
}
</style>

<script>
// Esconder loader quando página carregar
window.addEventListener('load', function() {
  const loader = document.getElementById('luxury-loader');
  
  // Pequeno delay para criar sensação de qualidade
  setTimeout(function() {
    loader.style.opacity = '0';
    loader.style.visibility = 'hidden';
    
    // Remover do DOM após animação
    setTimeout(function() {
      loader.remove();
    }, 800);
  }, 900); // 900ms = tempo mínimo que o loader fica visível
});
</script>

<!-- ==================== FLOATING CTA BUTTON ==================== -->
<div id="floating-cta" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 9000; opacity: 0; transform: translateY(20px); transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); pointer-events: none;">
  <a href="#contact" style="display: flex; align-items: center; gap: 0.8rem; background: linear-gradient(135deg, var(--accent) 0%, #4a1f0f 100%); color: var(--cream); padding: 1rem 1.8rem; border-radius: 50px; text-decoration: none; box-shadow: 0 10px 40px rgba(93, 39, 19, 0.3); font-size: 0.95rem; letter-spacing: 0.05em; font-family: 'Volkhorn', serif; font-weight: 500; transition: all 0.3s ease; pointer-events: auto;">
    <span>Request Inspection</span>
    <svg style="width: 20px; height: 20px; transition: transform 0.3s ease;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
  </a>
</div>

<style>
/* Hover no botão flutuante */
#floating-cta a:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 50px rgba(93, 39, 19, 0.4);
}

#floating-cta a:hover svg {
  transform: translateX(5px);
}

/* Esconder em mobile pequeno */
@media (max-width: 480px) {
  #floating-cta {
    bottom: 1rem;
    right: 1rem;
  }
  
  #floating-cta a {
    padding: 0.9rem 1.4rem;
    font-size: 0.85rem;
  }
  
  #floating-cta span {
    display: none; /* Só mostra o ícone em telas muito pequenas */
  }
}
</style>

<script>
// Mostrar/esconder botão baseado no scroll
window.addEventListener('scroll', function() {
  const floatingCTA = document.getElementById('floating-cta');
  const scrollPosition = window.scrollY;
  
  // Aparecer depois de 800px de scroll
  if (scrollPosition > 800) {
    floatingCTA.style.opacity = '1';
    floatingCTA.style.transform = 'translateY(0)';
    floatingCTA.style.pointerEvents = 'auto';
  } else {
    floatingCTA.style.opacity = '0';
    floatingCTA.style.transform = 'translateY(20px)';
    floatingCTA.style.pointerEvents = 'none';
  }
  
  // Esconder quando chegar perto do footer (para não sobrepor)
  const footer = document.querySelector('footer');
  if (footer) {
    const footerTop = footer.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;
    
    if (footerTop < windowHeight + 100) {
      floatingCTA.style.opacity = '0';
      floatingCTA.style.transform = 'translateY(20px)';
    }
  }
});

// Smooth scroll ao clicar
document.addEventListener('DOMContentLoaded', function() {
  const floatingCTA = document.getElementById('floating-cta');
  const ctaLink = floatingCTA.querySelector('a');
  
  ctaLink.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector('#contact');
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
</script>

<!-- ==================== MICROINTERAÇÕES LUXURY ==================== --> 
<style>
<html {
  scroll-behavior: smooth;
}

@media (min-width: 1024px) {
  body {
    cursor: url('image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="16" r="10" fill="rgba(93,39,19,0.15)" stroke="rgba(93,39,19,0.3)" stroke-width="1"/></svg>') 16 16, auto;
  }
  
  a, button, .hero-cta, .form-submit, .gallery-item {
    cursor: url('image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"><circle cx="20" cy="20" r="15" fill="rgba(93,39,19,0.25)" stroke="rgba(93,39,19,0.5)" stroke-width="2"/></svg>') 20 20, pointer;
  }
}

.hero-video {
  transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
  will-change: transform;
}

.benefit-card:hover,
.process-step:hover {
  transform: translateY(-8px);
}

.number-value {
  animation: pulseNumber 1s ease-out;
}>

@keyframes pulseNumber {
  0% { 
    transform: scale(0.8);
    opacity: 0;
  }>
  50% {
    transform: scale(1.05);
  }>
  100% { 
    transform: scale(1);
    opacity: 1;
  }>
}>
</style>
 <!-- ← Certifique-se que o CSS está ANTES dessa linha -->

<!-- ==================== PARALLAX EFFECT ==================== -->
<script>
// Parallax suave no hero
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset;
  const heroVideo = document.querySelector('.hero-video');
  
  if (heroVideo && scrolled < window.innerHeight) {
    // Movimento sutil (30% da velocidade do scroll)
    heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px)) scale(1.1)`;
  }
});

// Intersection Observer para animações ao scrollar
const observerOptions = {
  threshold: 0.15,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = 'running';
    }
  });
}, observerOptions);

// Observar elementos com animação
document.addEventListener('DOMContentLoaded', function() {
  const animatedElements = document.querySelectorAll('.number-item, .process-step, .benefit-card');
  
  animatedElements.forEach(el => {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
  });
});
</script>

<!-- ==================== PARALLAX + ANIMAÇÕES ==================== -->
<script>
// 1. PARALLAX suave no Hero
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset;
  const heroVideo = document.querySelector('.hero-video');
  
  if (heroVideo && scrolled < window.innerHeight) {
    // Movimento sutil - 30% da velocidade do scroll
    heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px)) scale(1.1)`;
  }
});

// 2. ANIMAÇÕES ao scrollar (Intersection Observer)
document.addEventListener('DOMContentLoaded', function() {
  // Configurar observer
  const observerOptions = {
    threshold: 0.2,
    rootMargin: '0px 0px -80px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
      }
    });
  }, observerOptions);

  // Observar elementos que devem animar
  const animateElements = document.querySelectorAll('.number-item, .process-step, .benefit-card, .what-is-content > *');
  
  animateElements.forEach(el => {
    observer.observe(el);
  });
});

// 3. SMOOTH SCROLL para links internos
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});
</script>

<?php wp_footer(); ?>
</body>
</html>