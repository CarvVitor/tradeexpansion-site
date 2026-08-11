<?php
/**
 * Template Name: Sobre
 * Template Post Type: page
 */

// 1. SISTEMA DE IDIOMAS
$lang = get_query_var('te_lang') ?: 'pt';

// Array de Traduções
$t = [
  'hero_kicker' => ['pt'=>'Inteligência · Curadoria · Inspeção Técnica', 'en'=>'Intelligence · Curation · Technical Inspection', 'es'=>'Inteligencia · Curaduría · Inspección Técnica'],
  'hero_title' => ['pt'=>'Sobre a Trade Expansion', 'en'=>'About Trade Expansion', 'es'=>'Sobre Trade Expansion'],
  'hero_sub' => ['pt'=>'Não somos uma trading house. Somos o seu parceiro de inteligência no Brasil — do campo ao embarque.', 'en'=>'We are not a trading house. We are your intelligence partner in Brazil — from the field to the shipment.', 'es'=>'No somos una trading house. Somos su socio de inteligencia en Brasil — del campo al embarque.'],
  'hero_scroll' => ['pt'=>'Desça', 'en'=>'Scroll', 'es'=>'Bajar'],

  'man_kicker' => ['pt'=>'Quem somos', 'en'=>'Who we are', 'es'=>'Quiénes somos'],
  'man_title' => ['pt'=>'Uma empresa construída sobre evidência, não sobre promessa', 'en'=>'A company built on evidence, not on promises', 'es'=>'Una empresa construida sobre evidencia, no sobre promesas'],
  'man_p1' => ['pt'=>'A Trade Expansion nasceu no Brasil com um propósito claro: eliminar o "achismo" das operações internacionais de rochas ornamentais. Em um setor onde reputação vale mais que slogan, entendemos cedo que o que sustenta um negócio duradouro não é preço — é critério, controle e documentação.', 'en'=>'Trade Expansion was founded in Brazil with a clear purpose: to eliminate guesswork from international ornamental stone operations. In an industry where reputation outlasts any slogan, we understood early that what sustains a lasting business is not price — it is criteria, control, and documentation.', 'es'=>'Trade Expansion nació en Brasil con un propósito claro: eliminar las suposiciones de las operaciones internacionales de piedras ornamentales. En un sector donde la reputación vale más que cualquier eslogan, entendimos pronto que lo que sostiene un negocio duradero no es el precio — sino el criterio, el control y la documentación.'],
  'man_p2' => ['pt'=>'Operamos como uma boutique — não como uma trading. Isso significa que cada operação recebe atenção dedicada, um especialista responsável do início ao fim, e um processo que é verificável em cada etapa. Sem filas. Sem surpresas.', 'en'=>'We operate as a boutique — not as a trading company. This means every operation receives dedicated attention, one specialist responsible from start to finish, and a process that is verifiable at every stage. No queues. No surprises.', 'es'=>'Operamos como una boutique — no como una trading. Eso significa que cada operación recibe atención dedicada, un especialista responsable de principio a fin, y un proceso verificable en cada etapa. Sin colas. Sin sorpresas.'],
  'man_p3' => ['pt'=>'Hoje, atendemos importadores na Europa, Ásia e América do Norte — com operações de inspeção técnica no Espírito Santo, Minas Gerais e Bahia. Nossa assinatura é simples: quando o processo é claro, o negócio flui.', 'en'=>'Today, we serve importers in Europe, Asia, and North America — with technical inspection operations in Espírito Santo, Minas Gerais, and Bahia. Our signature is simple: when the process is clear, business flows.', 'es'=>'Hoy atendemos importadores en Europa, Asia y Norteamérica — con operaciones de inspección técnica en Espírito Santo, Minas Gerais y Bahía. Nuestra firma es simple: cuando el proceso es claro, el negocio fluye.'],

  'bout_kicker' => ['pt'=>'Por que boutique', 'en'=>'Why boutique', 'es'=>'Por qué boutique'],
  'bout_title' => ['pt'=>'O que nos separa de uma trading convencional', 'en'=>'What separates us from a conventional trading company', 'es'=>'Lo que nos separa de una trading convencional'],
  'bout_c1_t' => ['pt'=>'Especialista dedicado', 'en'=>'Dedicated specialist', 'es'=>'Especialista dedicado'],
  'bout_c1_d' => ['pt'=>'Cada operação tem um responsável único — do alinhamento técnico ao relatório final. Não existe fila, não existe terceirização de atenção.', 'en'=>'Every operation has a single point of responsibility — from technical alignment to final report. No queue, no outsourced attention.', 'es'=>'Cada operación tiene un único responsable — desde la alineación técnica hasta el informe final. Sin colas, sin atención tercerizada.'],
  'bout_c2_t' => ['pt'=>'Processo verificável', 'en'=>'Verifiable process', 'es'=>'Proceso verificable'],
  'bout_c2_d' => ['pt'=>'Critérios objetivos, registro fotográfico por lote e checkpoints documentados. Cada etapa é rastreável — para você e para o seu cliente final.', 'en'=>'Objective criteria, per-batch photographic records, and documented checkpoints. Every stage is traceable — for you and your end client.', 'es'=>'Criterios objetivos, registros fotográficos por lote y checkpoints documentados. Cada etapa es trazable — para usted y su cliente final.'],
  'bout_c3_t' => ['pt'=>'Inteligência de mercado', 'en'=>'Market intelligence', 'es'=>'Inteligencia de mercado'],
  'bout_c3_d' => ['pt'=>'Não fazemos só inspeção. Fazemos curadoria: conhecemos os fornecedores, sabemos o que cada pedreira produz e o que o mercado internacional está absorvendo.', 'en'=>'We don\'t just inspect. We curate: we know the suppliers, we know what each quarry produces, and we know what the international market is absorbing.', 'es'=>'No solo inspeccionamos. Curamos: conocemos a los proveedores, sabemos qué produce cada cantera y qué está absorbiendo el mercado internacional.'],

  'geo_kicker' => ['pt'=>'Onde operamos', 'en'=>'Where we operate', 'es'=>'Dónde operamos'],
  'geo_title' => ['pt'=>'Brasil como base. Mundo como mercado.', 'en'=>'Brazil as base. The world as market.', 'es'=>'Brasil como base. El mundo como mercado.'],
  'geo_text' => ['pt'=>'Nossa presença técnica no Brasil cobre as três principais regiões produtoras de rochas ornamentais do país — garantindo que nenhum fornecedor relevante fique fora do nosso alcance.', 'en'=>'Our technical presence in Brazil covers the three main ornamental stone producing regions in the country — ensuring that no relevant supplier is out of our reach.', 'es'=>'Nuestra presencia técnica en Brasil cubre las tres principales regiones productoras de piedras ornamentales del país — asegurando que ningún proveedor relevante esté fuera de nuestro alcance.'],
  
  'geo_b1_t' => ['pt'=>'Operações de inspeção', 'en'=>'Inspection operations', 'es'=>'Operaciones de inspección'],
  'geo_b1_i1' => ['pt'=>'Espírito Santo · Principal polo produtor', 'en'=>'Espírito Santo · Main production hub', 'es'=>'Espírito Santo · Principal polo productor'],
  'geo_b1_i2' => ['pt'=>'Minas Gerais · Granitos e mármores', 'en'=>'Minas Gerais · Granites and marbles', 'es'=>'Minas Gerais · Granitos y mármoles'],
  'geo_b1_i3' => ['pt'=>'Bahia · Quartzitos exóticos', 'en'=>'Bahia · Exotic quartzites', 'es'=>'Bahia · Cuarcitas exóticas'],
  
  'geo_b2_t' => ['pt'=>'Compradores atendidos', 'en'=>'Markets served', 'es'=>'Mercados atendidos'],
  'geo_b2_i1' => ['pt'=>'Europa · Principais mercados', 'en'=>'Europe · Primary markets', 'es'=>'Europa · Principales mercados'],
  'geo_b2_i2' => ['pt'=>'Ásia · Crescimento acelerado', 'en'=>'Asia · Fast-growing demand', 'es'=>'Asia · Crecimiento acelerado'],
  'geo_b2_i3' => ['pt'=>'América do Norte · Alta especificação', 'en'=>'North America · High-specification projects', 'es'=>'Norteamérica · Proyectos de alta especificación'],

  'team_kicker' => ['pt'=>'Time', 'en'=>'Team', 'es'=>'Equipo'],
  'team_title' => ['pt'=>'Founders & Partners', 'en'=>'Founders & Partners', 'es'=>'Founders & Partners'],
  'team_label' => ['pt'=>'Founders & Partners · Trade Expansion', 'en'=>'Founders & Partners · Trade Expansion', 'es'=>'Founders & Partners · Trade Expansion'],
  'team_p1' => ['pt'=>'A Trade Expansion é liderada por profissionais com experiência direta em operações internacionais de rochas ornamentais — presença de campo, conhecimento técnico de materiais e fluência nos dois lados da negociação: o fornecedor brasileiro e o comprador internacional.', 'en'=>'Trade Expansion is led by professionals with direct experience in international ornamental stone operations — field presence, technical knowledge of materials, and fluency on both sides of the negotiation: the Brazilian supplier and the international buyer.', 'es'=>'Trade Expansion está liderada por profesionales con experiencia directa en operaciones internacionales de piedras ornamentales — presencia en campo, conocimiento técnico de materiales y fluidez en ambos lados de la negociación: el proveedor brasileño y el comprador internacional.'],
  'team_p2' => ['pt'=>'Cada inspeção é conduzida pessoalmente. Cada relatório é assinado com responsabilidade técnica. Não terceirizamos o que é essencial.', 'en'=>'Every inspection is conducted in person. Every report is signed with technical accountability. We do not outsource what is essential.', 'es'=>'Cada inspección se realiza en persona. Cada informe se firma con responsabilidad técnica. No tercerizamos lo que es esencial.'],
  'team_cta' => ['pt'=>'Falar com a equipe', 'en'=>'Speak with the team', 'es'=>'Hablar con el equipo'],

  'prin_kicker' => ['pt'=>'Princípios', 'en'=>'Principles', 'es'=>'Principios'],
  'prin_title' => ['pt'=>'O que orienta cada decisão', 'en'=>'What guides every decision', 'es'=>'Lo que guía cada decisión'],
  'prin_m_t' => ['pt'=>'Missão', 'en'=>'Mission', 'es'=>'Misión'],
  'prin_m_d' => ['pt'=>'Conectar compradores internacionais a rochas ornamentais brasileiras com rigor técnico, documentação impecável e transparência total — do campo ao desembarque.', 'en'=>'To connect international buyers to Brazilian ornamental stones with technical rigor, impeccable documentation, and full transparency — from the field to the final delivery.', 'es'=>'Conectar compradores internacionales con piedras ornamentales brasileñas con rigor técnico, documentación impecable y transparencia total — del campo al desembarque.'],
  'prin_v_t' => ['pt'=>'Visão', 'en'=>'Vision', 'es'=>'Visión'],
  'prin_v_d' => ['pt'=>'Ser a referência global em operações boutique de rochas ornamentais brasileiras — onde cada etapa é verificável e cada cliente é atendido como único.', 'en'=>'To be the global reference for boutique Brazilian ornamental stone operations — where every stage is verifiable and every client is treated as one of a kind.', 'es'=>'Ser la referencia global en operaciones boutique de piedras ornamentales brasileñas — donde cada etapa es verificable y cada cliente es tratado como único.'],
  'prin_val_t' => ['pt'=>'Valores', 'en'=>'Values', 'es'=>'Valores'],
  'prin_val_d' => ['pt'=>'Disciplina técnica. Transparência radical. Documentação sem lacunas. E respeito pelo que sustenta qualquer negócio duradouro: reputação e entrega.', 'en'=>'Technical discipline. Radical transparency. Documentation without gaps. And respect for what sustains any lasting business: reputation and delivery.', 'es'=>'Disciplina técnica. Transparencia radical. Documentación sin lagunas. Y respeto por lo que sostiene cualquier negocio duradero: reputación y entrega.'],

  'cta_kicker' => ['pt'=>'Pronto para começar', 'en'=>'Ready to start', 'es'=>'Listo para comenzar'],
  'cta_title' => ['pt'=>'Vamos conversar sobre sua próxima operação', 'en'=>'Let\'s talk about your next operation', 'es'=>'Hablemos sobre su próxima operación'],
  'cta_sub' => ['pt'=>'Inspeção técnica, curadoria de materiais ou intermediação comercial — estamos prontos para qualquer escala.', 'en'=>'Technical inspection, stone curation, or commercial intermediation — we are ready for any scale.', 'es'=>'Inspección técnica, curaduría de materiales o intermediación comercial — estamos listos para cualquier escala.'],
  'cta_b1' => ['pt'=>'Falar pelo WhatsApp', 'en'=>'Speak on WhatsApp', 'es'=>'Hablar por WhatsApp'],
  'cta_b2' => ['pt'=>'Ver serviço de inspeção', 'en'=>'View inspection service', 'es'=>'Ver servicio de inspección'],
];

// 2. META TAGS (Title e Description Dinâmicos)
add_action('wp_head', function() use ($lang) {
  $titles = [
    'pt' => 'Sobre a Trade Expansion | Inteligência em Exportação de Rochas',
    'en' => 'About Trade Expansion | Natural Stone Export Intelligence',
    'es' => 'Sobre Trade Expansion | Inteligencia en Exportación de Piedras'
  ];
  $descs = [
    'pt' => 'Conheça a Trade Expansion: boutique brasileira de exportação de rochas ornamentais com inspeção técnica, curadoria e inteligência operacional para compradores internacionais.',
    'en' => 'Trade Expansion is a Brazilian boutique natural stone export company. We provide technical inspection, stone curation, and operational intelligence for international buyers in Europe, Asia, and North America.',
    'es' => 'Trade Expansion es una boutique brasileña de exportación de piedras naturales. Ofrecemos inspección técnica, curaduría y inteligencia operacional para compradores internacionales.'
  ];
  echo '<title>' . $titles[$lang] . '</title>' . "\n";
  echo '<meta name="description" content="' . $descs[$lang] . '">' . "\n";
}, 1);

get_header();

$hero_vid = get_theme_file_uri('assets/videos/about-hero.mp4');
$hero_img = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg');
$team_img = get_theme_file_uri('assets/images/inspection-hero-photo.jpg');
?>

<style>
:root {
  --secondary: #102724;
  --cream: #F1F1D9;
  --text: #E1E2DA;
  --ink: #1D1F1E;
  --gold: #D6A354;
}

.te-sobre {
  font-family: 'Vollkorn', Georgia, serif;
  color: var(--ink);
  overflow-x: hidden;
}

.te-sobre section {
  position: relative;
  clear: both;
  width: 100%;
}

/* HERO */
.te-hero {
  position: relative;
  height: 100vh;
  min-height: 640px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: var(--secondary);
}

.te-hero__glow {
  position: absolute;
  inset: 0;
  background: radial-gradient(1000px 520px at 50% 15%, rgba(214,163,84,0.18), transparent 60%);
  pointer-events: none;
}

.te-hero__video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translate(-50%, -50%) scale(1.1);
  object-fit: cover;
  opacity: 0.22;
  will-change: transform;
}

.te-hero__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.14;
  display: none;
}

.te-hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(16,39,36,0.35) 0%, rgba(16,39,36,0.78) 55%, rgba(16,39,36,1) 100%);
}

.te-hero__content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 0 1.5rem;
  max-width: 1100px;
  color: var(--cream);
}

.te-kicker {
  display: inline-flex;
  align-items: center;
  gap: .6rem;
  padding: .75rem 1.1rem;
  border-radius: 9999px;
  border: 1px solid rgba(214,163,84,0.35);
  background: rgba(0,0,0,0.18);
  backdrop-filter: blur(10px);
  text-transform: uppercase;
  letter-spacing: 0.22em;
  font-size: .78rem;
  color: rgba(241,241,217,0.92);
  margin-bottom: 1.25rem;
}

.te-kicker__dot {
  width: .5rem;
  height: .5rem;
  border-radius: 9999px;
  background: var(--gold);
}

.te-hero__title {
  font-size: clamp(2.8rem, 7vw, 4.8rem);
  font-weight: 600;
  letter-spacing: 0.03em;
  line-height: 1.05;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

.te-hero__subtitle {
  font-size: clamp(1.05rem, 2.2vw, 1.5rem);
  color: rgba(225,226,218,0.92);
  font-weight: 400;
  letter-spacing: 0.04em;
  margin: 0 auto 2.2rem;
  max-width: 760px;
  line-height: 1.6;
}

.te-scroll {
  position: absolute;
  bottom: 1.4rem;
  left: 50%;
  transform: translateX(-50%);
  color: rgba(241,241,217,0.75);
  text-transform: uppercase;
  letter-spacing: 0.28em;
  font-size: .72rem;
  display: flex;
  align-items: center;
  gap: .6rem;
  z-index: 2;
}

.te-scroll__bar {
  width: 22px;
  height: 36px;
  border: 1px solid rgba(241,241,217,0.35);
  border-radius: 9999px;
  position: relative;
}

.te-scroll__dot {
  width: 6px;
  height: 6px;
  background: rgba(214,163,84,0.9);
  border-radius: 9999px;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  top: 8px;
  animation: teScroll 1.2s ease-in-out infinite;
}

@keyframes teScroll {
  0%, 100% { transform: translateX(-50%) translateY(0); opacity: .9; }
  50% { transform: translateX(-50%) translateY(10px); opacity: .35; }
}

/* SEÇÕES COMUNS */
.te-band--cream {
  background: linear-gradient(180deg, var(--cream) 0%, #E5E5D5 100%);
}

.te-band--green {
  background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%);
  color: var(--text);
}

.te-wrap {
  max-width: 1400px;
  margin: 0 auto;
  padding: 5.5rem 1.5rem;
}

.te-center {
  text-align: center;
}

.te-h2 {
  font-size: clamp(2.2rem, 4vw, 3.4rem);
  font-weight: 600;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  margin: .8rem 0 1.2rem;
}

.te-p {
  font-size: 1.08rem;
  line-height: 1.8;
  opacity: .9;
  max-width: 860px;
  margin: 0 auto 1.2rem;
}

.te-p:last-child {
  margin-bottom: 0;
}

/* GRIDS */
.te-grid-3 {
  margin-top: 3.2rem;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.4rem;
}

.te-grid-2 {
  margin-top: 3.2rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

/* CARDS */
.te-card {
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(241,241,217,0.12);
  border-radius: 16px;
  padding: 2.2rem 1.8rem;
  backdrop-filter: blur(10px);
  transition: transform .2s ease, border-color .2s ease;
}
.te-card:hover {
  transform: translateY(-6px);
  border-color: rgba(214,163,84,0.35);
}
.te-card h3 {
  font-size: 1.35rem;
  font-weight: 600;
  color: var(--gold);
  margin-bottom: 1rem;
}
.te-card p {
  font-size: 1rem;
  line-height: 1.6;
  opacity: .85;
}

/* VARIANTES DO CARD (MISSÃO / VISÃO / VALORES) */
.te-card--light {
  background: rgba(16,39,36,0.04);
  border: 1px solid rgba(16,39,36,0.12);
}
.te-card--light:hover {
  border-color: rgba(16,39,36,0.35);
}
.te-card--light h3 {
  color: var(--secondary);
}
.te-card--light p {
  color: rgba(16,39,36,0.85);
}

/* LISTAS DE GEOGRAFIA */
.te-list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.te-list li {
  padding: 1.2rem 0;
  border-bottom: 1px solid rgba(16,39,36,0.1);
  font-size: 1.05rem;
  color: rgba(16,39,36,0.85);
}
.te-list li:last-child {
  border-bottom: none;
}
.te-geo-block h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--secondary);
  margin-bottom: 1rem;
}

/* IMAGEM DA EQUIPE */
.te-img-wrap {
  position: relative;
  width: 100%;
  border-radius: 16px;
  overflow: hidden;
}

.te-img {
  width: 100%;
  height: 540px;
  object-fit: cover;
  display: block;
}

.te-img-label {
  position: absolute;
  bottom: 1.2rem;
  left: 1.2rem;
  background: rgba(16,39,36,0.82);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(214,163,84,0.25);
  border-radius: 9999px;
  padding: .5rem 1rem;
  font-size: .75rem;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: rgba(241,241,217,0.9);
}

/* BOTÕES */
.te-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .6rem;
  padding: 1rem 1.6rem;
  border-radius: 14px;
  font-weight: 700;
  text-decoration: none;
  transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
  letter-spacing: 0.04em;
}
.te-btn--primary {
  background: var(--gold);
  color: var(--secondary);
  border: 1px solid rgba(214,163,84,0.55);
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}
.te-btn--primary:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.85);
}
.te-btn--ghost {
  background: rgba(0,0,0,0.18);
  color: var(--cream);
  border: 1px solid rgba(241,241,217,0.2);
}
.te-btn--ghost:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.55);
}
.te-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: .8rem;
  justify-content: center;
  margin-top: 2rem;
}

/* ANIMAÇÕES */
.fade-in-up {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity .6s ease, transform .6s ease;
}
.fade-in-up.visible {
  opacity: 1;
  transform: translateY(0);
}

@media (max-width: 1024px) {
  .te-grid-3 { grid-template-columns: 1fr; }
  .te-grid-2 { grid-template-columns: 1fr; gap: 3rem; }
  .te-img { height: 420px; }
}
</style>

<main class="te-sobre">
  
  <!-- SEÇÃO 1: HERO -->
  <section class="te-hero">
    <video class="te-hero__video" autoplay muted loop playsinline preload="auto" aria-hidden="true">
      <source src="<?php echo esc_url($hero_vid); ?>" type="video/mp4" />
    </video>
    <img class="te-hero__img" data-src="<?php echo esc_url($hero_img); ?>" alt="" aria-hidden="true" />
    <div class="te-hero__overlay" aria-hidden="true"></div>

    <div class="te-hero__content fade-in-up">
      <div class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['hero_kicker'][$lang]; ?></div>
      <h1 class="te-hero__title"><?php echo $t['hero_title'][$lang]; ?></h1>
      <p class="te-hero__subtitle"><?php echo $t['hero_sub'][$lang]; ?></p>
    </div>

    <div class="te-scroll" aria-hidden="true">
      <div class="te-scroll__bar"><div class="te-scroll__dot"></div></div>
      <?php echo $t['hero_scroll'][$lang]; ?>
    </div>
  </section>

  <!-- SEÇÃO 2: MANIFESTO -->
  <section class="te-band--cream">
    <div class="te-wrap te-center">
      <div class="fade-in-up">
        <p class="te-kicker" style="background:rgba(16,39,36,0.06);border-color:rgba(16,39,36,0.15);color:rgba(16,39,36,0.85);">
          <span class="te-kicker__dot"></span> <?php echo $t['man_kicker'][$lang]; ?>
        </p>
        <h2 class="te-h2" style="color:var(--secondary); margin-bottom: 2rem;"><?php echo $t['man_title'][$lang]; ?></h2>
        <p class="te-p" style="color:rgba(16,39,36,0.85);"><?php echo $t['man_p1'][$lang]; ?></p>
        <p class="te-p" style="color:rgba(16,39,36,0.85);"><?php echo $t['man_p2'][$lang]; ?></p>
        <p class="te-p" style="color:rgba(16,39,36,0.85);"><?php echo $t['man_p3'][$lang]; ?></p>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 3: O MODELO BOUTIQUE -->
  <section class="te-band--green">
    <div class="te-wrap">
      <div class="te-center fade-in-up">
        <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['bout_kicker'][$lang]; ?></p>
        <h2 class="te-h2"><?php echo $t['bout_title'][$lang]; ?></h2>
      </div>
      <div class="te-grid-3 fade-in-up">
        <div class="te-card">
          <h3><?php echo $t['bout_c1_t'][$lang]; ?></h3>
          <p><?php echo $t['bout_c1_d'][$lang]; ?></p>
        </div>
        <div class="te-card">
          <h3><?php echo $t['bout_c2_t'][$lang]; ?></h3>
          <p><?php echo $t['bout_c2_d'][$lang]; ?></p>
        </div>
        <div class="te-card">
          <h3><?php echo $t['bout_c3_t'][$lang]; ?></h3>
          <p><?php echo $t['bout_c3_d'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 4: PRESENÇA GEOGRÁFICA -->
  <section class="te-band--cream">
    <div class="te-wrap">
      <div class="te-grid-2 fade-in-up">
        <div>
          <p class="te-kicker" style="background:rgba(16,39,36,0.06);border-color:rgba(16,39,36,0.15);color:rgba(16,39,36,0.85);">
            <span class="te-kicker__dot"></span> <?php echo $t['geo_kicker'][$lang]; ?>
          </p>
          <h2 class="te-h2" style="color:var(--secondary); text-align: left; margin: 0 0 1.2rem;"><?php echo $t['geo_title'][$lang]; ?></h2>
          <p class="te-p" style="color:rgba(16,39,36,0.85); text-align: left; margin-left: 0;"><?php echo $t['geo_text'][$lang]; ?></p>
        </div>
        
        <div>
          <div class="te-geo-block" style="margin-bottom: 3rem;">
            <h3><?php echo $t['geo_b1_t'][$lang]; ?></h3>
            <ul class="te-list">
              <li><?php echo $t['geo_b1_i1'][$lang]; ?></li>
              <li><?php echo $t['geo_b1_i2'][$lang]; ?></li>
              <li><?php echo $t['geo_b1_i3'][$lang]; ?></li>
            </ul>
          </div>
          <div class="te-geo-block">
            <h3><?php echo $t['geo_b2_t'][$lang]; ?></h3>
            <ul class="te-list">
              <li><?php echo $t['geo_b2_i1'][$lang]; ?></li>
              <li><?php echo $t['geo_b2_i2'][$lang]; ?></li>
              <li><?php echo $t['geo_b2_i3'][$lang]; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 5: FUNDADORES -->
  <section class="te-band--green">
    <div class="te-wrap">
      <div class="te-grid-2 fade-in-up">
        <div class="te-img-wrap">
          <img class="te-img" src="<?php echo esc_url($team_img); ?>" alt="Founders">
          <div class="te-img-label"><?php echo $t['team_label'][$lang]; ?></div>
        </div>
        
        <div>
          <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['team_kicker'][$lang]; ?></p>
          <h2 class="te-h2" style="text-align: left; margin: 0 0 1.2rem;"><?php echo $t['team_title'][$lang]; ?></h2>
          <p class="te-p" style="text-align: left; margin-left: 0;"><?php echo $t['team_p1'][$lang]; ?></p>
          <p class="te-p" style="text-align: left; margin-left: 0; margin-bottom: 2rem;"><?php echo $t['team_p2'][$lang]; ?></p>
          
          <a class="te-btn te-btn--primary" href="https://wa.me/5527992284517" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
            </svg>
            <?php echo $t['team_cta'][$lang]; ?>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 6: MISSÃO / VISÃO / VALORES -->
  <section class="te-band--cream">
    <div class="te-wrap">
      <div class="te-center fade-in-up">
        <p class="te-kicker" style="background:rgba(16,39,36,0.06);border-color:rgba(16,39,36,0.15);color:rgba(16,39,36,0.85);">
          <span class="te-kicker__dot"></span> <?php echo $t['prin_kicker'][$lang]; ?>
        </p>
        <h2 class="te-h2" style="color:var(--secondary);"><?php echo $t['prin_title'][$lang]; ?></h2>
      </div>
      <div class="te-grid-3 fade-in-up">
        <div class="te-card te-card--light">
          <h3><?php echo $t['prin_m_t'][$lang]; ?></h3>
          <p><?php echo $t['prin_m_d'][$lang]; ?></p>
        </div>
        <div class="te-card te-card--light">
          <h3><?php echo $t['prin_v_t'][$lang]; ?></h3>
          <p><?php echo $t['prin_v_d'][$lang]; ?></p>
        </div>
        <div class="te-card te-card--light">
          <h3><?php echo $t['prin_val_t'][$lang]; ?></h3>
          <p><?php echo $t['prin_val_d'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 7: CTA FINAL -->
  <section class="te-band--green">
    <div class="te-wrap te-center fade-in-up" style="padding-top: 8rem; padding-bottom: 8rem;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['cta_kicker'][$lang]; ?></p>
      <h2 class="te-h2" style="margin-bottom: 1rem;"><?php echo $t['cta_title'][$lang]; ?></h2>
      <p class="te-p" style="margin-bottom: 2.5rem; opacity: .8;"><?php echo $t['cta_sub'][$lang]; ?></p>
      
      <div class="te-hero__actions">
        <a class="te-btn te-btn--primary" href="https://wa.me/5527992284517" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
          </svg>
          <?php echo $t['cta_b1'][$lang]; ?>
        </a>
        <a class="te-btn te-btn--ghost" href="<?php echo esc_url(home_url('/inspecao')); ?>">
          <?php echo $t['cta_b2'][$lang]; ?>
        </a>
      </div>
    </div>
  </section>

</main>

<script>
  // Fallback inteligente para vídeo do hero
  document.addEventListener('DOMContentLoaded', function() {
    const heroVideoEl = document.querySelector('.te-hero__video');
    const heroImgEl = document.querySelector('.te-hero__img');
    if (heroVideoEl && heroImgEl) {
      heroVideoEl.addEventListener('error', function() {
        heroImgEl.src = heroImgEl.dataset.src;
        heroImgEl.style.display = 'block';
      });
      setTimeout(function() {
        if (heroVideoEl.readyState === 0) {
          heroImgEl.src = heroImgEl.dataset.src;
          heroImgEl.style.display = 'block';
        }
      }, 4000);
    }
  });

  // Efeito Parallax no vídeo
  window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset || document.documentElement.scrollTop || 0;
    const heroVideo = document.querySelector('.te-hero__video');
    if (!heroVideo) return;
    if (scrolled < window.innerHeight) {
      heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.22}px)) scale(1.1)`;
    }
  });

  // Fade-in via IntersectionObserver
  const fadeEls = document.querySelectorAll('.fade-in-up');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
  }, { threshold: 0.15 });
  fadeEls.forEach(el => observer.observe(el));
</script>

<?php get_footer(); ?>