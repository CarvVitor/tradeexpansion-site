<?php
/**
 * Template Name: Inspeção Técnica
 * Description: Página institucional de Inspeção Técnica de Rochas Ornamentais
 */

$lang = get_query_var('te_lang') ?: 'pt';

$t = [
  'meta_title' => [
    'pt' => 'Inspeção Técnica de Rochas Ornamentais | Trade Expansion',
    'en' => 'Natural Stone Inspection in Brazil | Trade Expansion',
    'es' => 'Inspección de Piedras Naturales en Brasil | Trade Expansion'
  ],
  'meta_desc' => [
    'pt' => 'A Trade Expansion realiza inspeção técnica presencial para compradores internacionais de rochas ornamentais no Brasil. Relatórios em 24–48h no ES, MG e BA.',
    'en' => 'Trade Expansion provides on-site technical inspection for ornamental stone buyers importing from Brazil. Reports in 24–48h, covering quartzite, marble, and granite — in Espírito Santo, Minas Gerais, and Bahia.',
    'es' => 'Trade Expansion ofrece inspección técnica in situ para compradores internacionales de piedras ornamentales en Brasil. Informes en 24–48h en ES, MG y BA.'
  ],
  'hero_kicker' => [
    'pt' => 'Inspeção Técnica · Relatório Fotográfico · Checklist',
    'en' => 'Technical Inspection · Photographic Report · Checklist',
    'es' => 'Inspección Técnica · Informe Fotográfico · Checklist'
  ],
  'hero_title' => [
    'pt' => 'Inspeção Técnica de Rochas',
    'en' => 'Natural Stone Technical Inspection',
    'es' => 'Inspección Técnica de Piedras Naturales'
  ],
  'hero_subtitle' => [
    'pt' => 'Seja seus olhos no Brasil: critérios objetivos de aceite, evidência por lote e transparência total antes do embarque.',
    'en' => 'Your eyes in Brazil: objective acceptance criteria, per-batch evidence, and full transparency before shipment.',
    'es' => 'Sus ojos en Brasil: criterios objetivos de aceptación, evidencia por lote y transparencia total antes del embarque.'
  ],
  'hero_cta_primary' => [
    'pt' => 'Solicitar Inspeção',
    'en' => 'Request Inspection',
    'es' => 'Solicitar Inspección'
  ],
  'hero_cta_secondary' => [
    'pt' => 'Falar no WhatsApp',
    'en' => 'Speak on WhatsApp',
    'es' => 'Hablar por WhatsApp'
  ],
  'scroll' => [
    'pt' => 'Desça',
    'en' => 'Scroll',
    'es' => 'Bajar'
  ],
  'loader' => [
    'pt' => 'Validando documentação…',
    'en' => 'Validating documentation…',
    'es' => 'Validando documentación…'
  ],
  'num_kicker' => [
    'pt' => 'Rigor técnico em escala',
    'en' => 'Technical rigor at scale',
    'es' => 'Rigor técnico a escala'
  ],
  'num_title' => [
    'pt' => 'Confiança se constrói com evidência',
    'en' => 'Trust is built on evidence',
    'es' => 'La confianza se construye con evidencia'
  ],
  'num_sub' => [
    'pt' => 'Relatórios claros, fotos por lote e inspeção alinhada ao que o seu cliente realmente aceita.',
    'en' => 'Clear reports, per-batch photos, and inspection aligned with your actual acceptance standards.',
    'es' => 'Informes claros, fotos por lote e inspección alineada con sus estándares reales de aceptación.'
  ],
  'num_c1_title' => [
    'pt' => 'Tempo',
    'en' => 'Turnaround',
    'es' => 'Tiempo'
  ],
  'num_c1_txt' => [
    'pt' => 'Relatório em 24–48h, com fotos e checklist.',
    'en' => 'Report delivered in 24–48h with photos and checklist.',
    'es' => 'Informe en 24–48h con fotos y checklist.'
  ],
  'num_c2_title' => [
    'pt' => 'Critério',
    'en' => 'Criteria',
    'es' => 'Criterio'
  ],
  'num_c2_txt' => [
    'pt' => 'Aceite por tolerância: metragem, acabamento, padrão e lote.',
    'en' => 'Acceptance by tolerance: dimensions, finish, pattern, and batch.',
    'es' => 'Aceptación por tolerancia: medidas, acabado, patrón y lote.'
  ],
  'num_c3_title' => [
    'pt' => 'Transparência',
    'en' => 'Transparency',
    'es' => 'Transparencia'
  ],
  'num_c3_txt' => [
    'pt' => 'Você decide com base em prova, não em promessa.',
    'en' => 'You decide based on proof, not on promises.',
    'es' => 'Usted decide con base en prueba, no en promesa.'
  ],
  'parc_kicker' => [
    'pt' => 'Seu padrão, nosso método',
    'en' => 'Your standard, our method',
    'es' => 'Su estándar, nuestro método'
  ],
  'parc_title' => [
    'pt' => 'Seu parceiro estratégico no Brasil',
    'en' => 'Your strategic partner in Brazil',
    'es' => 'Su socio estratégico en Brasil'
  ],
  'parc_txt' => [
    'pt' => 'A Trade Expansion atua com inspeção técnica, intermediação e inteligência de mercado para operações internacionais de rochas ornamentais. Nosso trabalho reduz disputa pós-embarque e aumenta previsibilidade no aceite.',
    'en' => 'Trade Expansion provides technical inspection, intermediation, and market intelligence for international ornamental stone operations. Our work reduces post-shipment disputes and increases acceptance predictability.',
    'es' => 'Trade Expansion ofrece inspección técnica, intermediación e inteligencia de mercado para operaciones internacionales de piedras ornamentales. Nuestro trabajo reduce disputas post-embarque y aumenta la previsibilidad en la aceptación.'
  ],
  'parc_cta' => [
    'pt' => 'Ver o processo',
    'en' => 'See the process',
    'es' => 'Ver el proceso'
  ],
  'parc_img_alt' => [
    'pt' => 'Inspeção técnica de rochas ornamentais no campo',
    'en' => 'On-site technical inspection of ornamental stones',
    'es' => 'Inspección técnica de piedras ornamentales en campo'
  ],
  'proc_kicker' => [
    'pt' => 'Metodologia',
    'en' => 'Methodology',
    'es' => 'Metodología'
  ],
  'proc_title' => [
    'pt' => 'Processo objetivo, sem achismo',
    'en' => 'Objective process. No guesswork.',
    'es' => 'Proceso objetivo. Sin suposiciones.'
  ],
  'proc_sub' => [
    'pt' => 'Do alinhamento de especificação ao relatório final: tudo rastreável.',
    'en' => 'From specification alignment to final report: everything traceable.',
    'es' => 'Desde la alineación de especificaciones hasta el informe final: todo trazable.'
  ],
  'proc_s1_t' => [
    'pt' => 'Brief técnico',
    'en' => 'Technical Brief',
    'es' => 'Brief técnico'
  ],
  'proc_s1_d' => [
    'pt' => 'Especificações, tolerâncias e padrão de aceite.',
    'en' => 'Specifications, tolerances, and acceptance standards.',
    'es' => 'Especificaciones, tolerancias y estándar de aceptación.'
  ],
  'proc_s2_t' => [
    'pt' => 'Inspeção in loco',
    'en' => 'On-site Inspection',
    'es' => 'Inspección in situ'
  ],
  'proc_s2_d' => [
    'pt' => 'Pedreira, fábrica ou porto, conforme etapa.',
    'en' => 'Quarry, factory, or port — depending on the stage.',
    'es' => 'Cantera, fábrica o puerto, según la etapa.'
  ],
  'proc_s3_t' => [
    'pt' => 'Checklist + fotos',
    'en' => 'Checklist + Photos',
    'es' => 'Checklist + fotos'
  ],
  'proc_s3_d' => [
    'pt' => 'Registro por lote, ângulos e detalhes críticos.',
    'en' => 'Per-batch record with angles and critical details.',
    'es' => 'Registro por lote, ángulos y detalles críticos.'
  ],
  'proc_s4_t' => [
    'pt' => 'Relatório',
    'en' => 'Report',
    'es' => 'Informe'
  ],
  'proc_s4_d' => [
    'pt' => 'Conclusões e recomendações em 24–48h.',
    'en' => 'Conclusions and recommendations within 24–48h.',
    'es' => 'Conclusiones y recomendaciones en 24–48h.'
  ],
  'proc_s5_t' => [
    'pt' => 'Suporte',
    'en' => 'Support',
    'es' => 'Soporte'
  ],
  'proc_s5_d' => [
    'pt' => 'Apoio na decisão e follow-up com fornecedor.',
    'en' => 'Decision support and supplier follow-up.',
    'es' => 'Apoyo en la decisión y seguimiento con el proveedor.'
  ],
  'ben_kicker' => [
    'pt' => 'Benefícios',
    'en' => 'Benefits',
    'es' => 'Beneficios'
  ],
  'ben_title' => [
    'pt' => 'Por que a Trade Expansion',
    'en' => 'Why Trade Expansion',
    'es' => 'Por qué Trade Expansion'
  ],
  'ben_sub' => [
    'pt' => 'O que você ganha quando troca "fé" por "prova".',
    'en' => 'What you gain when you replace faith with proof.',
    'es' => 'Lo que gana cuando cambia la "fe" por la "prueba".'
  ],
  'ben_c1_t' => [
    'pt' => 'Rigor técnico',
    'en' => 'Technical Rigor',
    'es' => 'Rigor técnico'
  ],
  'ben_c1_d' => [
    'pt' => 'Critérios claros, tolerâncias e padrão de aceite registrado.',
    'en' => 'Clear criteria, tolerances, and documented acceptance standards.',
    'es' => 'Criterios claros, tolerancias y estándar de aceptación registrado.'
  ],
  'ben_c2_t' => [
    'pt' => 'Transparência total',
    'en' => 'Full Transparency',
    'es' => 'Transparencia total'
  ],
  'ben_c2_d' => [
    'pt' => 'Evidência por lote: fotos, medições e checklist.',
    'en' => 'Per-batch evidence: photos, measurements, and checklist.',
    'es' => 'Evidencia por lote: fotos, mediciones y checklist.'
  ],
  'ben_c3_t' => [
    'pt' => 'Menos disputa',
    'en' => 'Fewer Disputes',
    'es' => 'Menos disputas'
  ],
  'ben_c3_d' => [
    'pt' => 'Redução de retrabalho, atraso e conflito pós-embarque.',
    'en' => 'Reduced rework, delays, and post-shipment conflict.',
    'es' => 'Reducción de retrabajo, retrasos y conflictos post-embarque.'
  ],
  'case_kicker' => ['pt'=>'Caso real · Lição aprendida', 'en'=>'Real case · Lesson learned', 'es'=>'Caso real · Lección aprendida'],
  'case_label' => ['pt'=>'O custo de embarcar sem inspeção', 'en'=>'The cost of shipping without inspection', 'es'=>'El costo de embarcar sin inspección'],
  'case_loss' => ['pt'=>'+$40k', 'en'=>'+$40k', 'es'=>'+$40k'],
  'case_loss_label' => ['pt'=>'em prejuízo direto', 'en'=>'in direct losses', 'es'=>'en pérdidas directas'],
  'case_title' => ['pt'=>'"Depois disso, nenhum contêiner sai sem a Trade Expansion."', 'en'=>'"After this, not a single container leaves without Trade Expansion."', 'es'=>'"Después de esto, ningún contenedor sale sin Trade Expansion."'],
  'case_p1' => ['pt'=>'Um importador americano de pedras — com muitos anos de experiência no mercado — fez um pedido de 800 m² de um quartzito exótico brasileiro raro. O material havia sido especificado por um arquiteto, aprovado pela equipe do projeto e pelo cliente final, para um empreendimento residencial de alto padrão em Los Angeles. Preço por m²: premium. Prazo: o quanto antes.', 'en'=>'An American stone importer — with many years in the business — placed an order for 800 m² of a rare exotic Brazilian quartzite. The material had been specified by an architect, approved by the project team and the end client, for a high-end residential project in Los Angeles. Price per m²: premium. Deadline: as soon as possible.', 'es'=>'Un importador americano de piedras — con muchos años de experiencia — realizó un pedido de 800 m² de una cuarcita exótica brasileña rara. El material había sido especificado por un arquitecto, aprobado por el equipo del proyecto y el cliente final, para un proyecto residencial de alto nivel en Los Angeles. Precio por m²: premium. Plazo: lo antes posible.'],
  'case_p2' => ['pt'=>'O fornecedor enviou fotos. As amostras pareciam certas. O preço foi acordado. O contêiner embarcou. Quando chegou ao Porto de Los Angeles, o importador abriu os caixotes e encontrou algo diferente. O movimento de cor não correspondia ao combinado. Várias chapas tinham micro-fraturas e problemas estruturais invisíveis em fotos — e o acabamento estava longe do padrão esperado. A espessura variava muito além da especificação. Mais de 30% do material foi rejeitado na chegada.', 'en'=>'The supplier sent photos. The samples looked right. The price was agreed. The container shipped. When it arrived at the Port of Los Angeles, the importer opened the crates and found something different. The color movement didn\'t match what had been agreed. Several slabs had micro-fractures and structural issues invisible in photos — and the finish was far from the standard expected. Thickness varied well beyond spec. Over 30% of the material was rejected on arrival.', 'es'=>'El proveedor envió fotos. Las muestras parecían correctas. El precio fue acordado. El contenedor se envió. Al llegar al Puerto de Los Angeles, el importador abrió los embalajes y encontró algo diferente. El movimiento de color no coincidía con lo acordado. Varias losas tenían micro-fracturas y problemas estructurales invisibles en fotos. Más del 30% del material fue rechazado a la llegada.'],
  'case_p3' => ['pt'=>'O prejuízo superou $40.000. O arquiteto passou a especificar outro fornecedor. A relação com o cliente final foi danificada de forma irreparável. Alguns meses depois, o mesmo importador entrou em contato com a Trade Expansion antes de fechar um novo pedido.', 'en'=>'The financial loss exceeded $40,000. The architect moved on to a different supplier. The relationship with the end client was damaged beyond repair. A few months later, the same importer contacted Trade Expansion before placing a new order.', 'es'=>'Las pérdidas superaron los $40.000. El arquitecto cambió de proveedor. La relación con el cliente final quedó dañada irreparablemente. Unos meses después, el mismo importador contactó a Trade Expansion antes de cerrar un nuevo pedido.'],
  'case_quote' => ['pt'=>'"Confiei nas fotos e na palavra do fornecedor. Achei que o conhecia bem o suficiente. Errei nas duas apostas — e paguei caro por isso."', 'en'=>'"I trusted photos and a handshake. I thought I knew the supplier well enough. I was wrong on both counts — and it cost me."', 'es'=>'"Confié en las fotos y en la palabra del proveedor. Pensé que lo conocía suficientemente bien. Me equivoqué en ambas — y lo pagué caro."'],
  'case_footer' => ['pt'=>'Hoje, todo contêiner que ele embarca passa por uma inspeção da Trade Expansion antes de sair do Brasil. Não porque ele é obrigado. Porque ele sabe o que acontece quando não faz.', 'en'=>'Today, every container he ships goes through a Trade Expansion inspection before it leaves Brazil. Not because he has to. Because he knows what happens when he doesn\'t.', 'es'=>'Hoy, cada contenedor que embarca pasa por una inspección de Trade Expansion antes de salir de Brasil. No porque deba hacerlo. Porque sabe lo que ocurre cuando no lo hace.'],
  'report_kicker' => ['pt'=>'Transparência total · Documento proprietário', 'en'=>'Full transparency · Proprietary document', 'es'=>'Transparencia total · Documento propio'],
  'report_title' => ['pt'=>'Como é um relatório Trade Expansion', 'en'=>'What a Trade Expansion report looks like', 'es'=>'Cómo es un informe Trade Expansion'],
  'report_sub' => ['pt'=>'Cada inspeção gera um relatório estruturado: identificação do lote, medições por chapa, inspeção visual com fotos reais e notas técnicas. Entregue em 24–48h, em inglês.', 'en'=>'Every inspection produces a structured report: batch identification, per-slab measurements, visual inspection with real photos, and technical notes. Delivered in 24–48h, in English.', 'es'=>'Cada inspección genera un informe estructurado: identificación del lote, mediciones por losa, inspección visual con fotos reales y notas técnicas. Entregado en 24–48h, en inglés.'],
  'report_note' => ['pt'=>'Amostra reduzida · Uso demonstrativo', 'en'=>'Sample copy · Demonstrative use only', 'es'=>'Copia de muestra · Solo uso demostrativo'],
  'car_kicker' => [
    'pt' => 'Evidência real · Casos documentados',
    'en' => 'Real Evidence · Documented Cases',
    'es' => 'Evidencia real · Casos documentados'
  ],
  'car_title' => [
    'pt' => 'O que encontramos no campo',
    'en' => 'What we find in the field',
    'es' => 'Lo que encontramos en el campo'
  ],
  'car_sub' => [
    'pt' => 'Problemas reais, documentados, que compradores remotos nunca veriam sem presença local.',
    'en' => 'Real problems, documented, that remote buyers would never catch without local presence.',
    'es' => 'Problemas reales, documentados, que compradores remotos nunca verían sin presencia local.'
  ],
  'form_kicker' => [
    'pt' => 'Vamos alinhar a inspeção',
    'en' => 'Let\'s align the inspection',
    'es' => 'Vamos a alinear la inspección'
  ],
  'form_title' => [
    'pt' => 'Solicitar inspeção',
    'en' => 'Request inspection',
    'es' => 'Solicitar inspección'
  ],
  'form_sub' => [
    'pt' => 'Conte o material, quantidade e destino. A gente responde com próximos passos.',
    'en' => 'Tell us the material, quantity and destination. We will reply with the next steps.',
    'es' => 'Cuéntenos el material, cantidad y destino. Le responderemos con los próximos pasos.'
  ],
  'f_name' => [
    'pt' => 'Nome completo *',
    'en' => 'Full name *',
    'es' => 'Nombre completo *'
  ],
  'f_email' => [
    'pt' => 'E-mail *',
    'en' => 'E-mail *',
    'es' => 'E-mail *'
  ],
  'f_comp' => [
    'pt' => 'Empresa',
    'en' => 'Company',
    'es' => 'Empresa'
  ],
  'f_mat' => [
    'pt' => 'Material',
    'en' => 'Material',
    'es' => 'Material'
  ],
  'f_mat_pl' => [
    'pt' => 'Ex.: Quartzito, granito, mármore',
    'en' => 'E.g.: Quartzite, granite, marble',
    'es' => 'Ej.: Cuarcita, granito, mármol'
  ],
  'f_det' => [
    'pt' => 'Detalhes do projeto *',
    'en' => 'Project details *',
    'es' => 'Detalles del proyecto *'
  ],
  'f_det_pl' => [
    'pt' => 'Quantidades, acabamentos, destino e qualquer exigência específica…',
    'en' => 'Quantities, finishes, destination and any specific requirements…',
    'es' => 'Cantidades, acabados, destino y cualquier requisito específico…'
  ],
  'f_btn' => [
    'pt' => 'Enviar solicitação',
    'en' => 'Send request',
    'es' => 'Enviar solicitud'
  ],
  'float_cta' => [
    'pt' => 'Solicitar inspeção',
    'en' => 'Request Inspection',
    'es' => 'Solicitar Inspección'
  ]
];

// Injeção de Meta Tags de SEO correspondentes ao idioma antes do header global
add_action('wp_head', function() use ($t, $lang) {
    echo '<title>' . esc_html($t['meta_title'][$lang]) . '</title>' . "\n";
    echo '<meta name="description" content="' . esc_attr($t['meta_desc'][$lang]) . '">' . "\n";
}, 1);

get_header();

$hero_video = get_theme_file_uri('assets/videos/inspection-hero.mp4');
$hero_img   = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg');
$whatsapp   = 'https://wa.me/5527992284517';
?>

<style>
:root {
  --secondary: #102724;
  --cream: #F1F1D9;
  --text: #E1E2DA;
  --ink: #1D1F1E;
  --gold: #D6A354;
}

.te-inspecao {
  font-family: 'Vollkorn', Georgia, serif;
  color: var(--ink);
  overflow-x: hidden;
}

.te-inspecao section {
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

/* SEÇÕES */
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
  margin: 0 auto;
}

.te-grid-3 {
  margin-top: 3.2rem;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.4rem;
}

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
  margin: 0 0 .7rem;
  font-size: 1.25rem;
  letter-spacing: .03em;
  color: var(--cream);
}

.te-card p {
  margin: 0;
  opacity: .86;
  line-height: 1.75;
}

.te-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2.4rem;
  align-items: center;
  margin-top: 3rem;
}

.te-img {
  width: 100%;
  height: 560px;
  border-radius: 18px;
  overflow: hidden;
  border: 1px solid rgba(214,163,84,0.18);
  box-shadow: 0 22px 80px rgba(0,0,0,0.35);
}

.te-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.te-steps {
  margin-top: 3rem;
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 1rem;
}

.te-step {
  background: rgba(0,0,0,0.18);
  border: 1px solid rgba(241,241,217,0.12);
  border-radius: 16px;
  padding: 1.6rem 1.2rem;
  text-align: center;
}

.te-step__n {
  font-size: 2.4rem;
  font-weight: 700;
  color: rgba(214,163,84,0.75);
  margin-bottom: .2rem;
}

.te-step h4 {
  margin: .2rem 0 .5rem;
  color: var(--cream);
  font-size: 1.05rem;
}

.te-step p {
  margin: 0;
  opacity: .86;
  line-height: 1.65;
  font-size: .98rem;
}

/* MARQUEE CAROUSEL */
.te-marquee {
  position: relative;
  width: 100%;
  overflow: hidden;
  margin-top: 3.2rem;
  padding: 1rem 0;
  display: flex;
}

.te-marquee__track {
  display: flex;
  width: max-content;
  animation: teMarquee 35s linear infinite;
}

.te-marquee__track:hover {
  animation-play-state: paused;
}

.te-marquee__group {
  display: flex;
  gap: 2rem;
  padding-right: 2rem;
}

.te-marquee__item {
  width: 320px;
  height: 400px;
  border-radius: 16px;
  overflow: hidden;
  flex-shrink: 0;
  box-shadow: 0 14px 40px rgba(0,0,0,0.4);
  border: 1px solid rgba(214,163,84,0.18);
}

.te-marquee__item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.te-marquee__item:hover img {
  transform: scale(1.05);
}

@keyframes teMarquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* FORM */
.te-form {
  max-width: 880px;
  margin: 0 auto;
  margin-top: 2.6rem;
  text-align: left;
  background: rgba(241,241,217,0.95);
  border-radius: 18px;
  padding: 2.2rem;
  border: 1px solid rgba(214,163,84,0.18);
  box-shadow: 0 22px 80px rgba(0,0,0,0.25);
  color: var(--secondary);
}

.te-form label {
  display: block;
  font-weight: 700;
  letter-spacing: .02em;
  margin: 0 0 .35rem;
}

.te-form input,
.te-form textarea {
  width: 100%;
  padding: 1rem 1rem;
  border-radius: 12px;
  border: 1px solid rgba(16,39,36,0.18);
  background: rgba(255,255,255,0.9);
  font-family: 'Vollkorn', Georgia, serif;
  font-size: 1rem;
  outline: none;
}

.te-form input:focus,
.te-form textarea:focus {
  border-color: rgba(214,163,84,0.5);
  box-shadow: 0 0 0 3px rgba(214,163,84,0.18);
}

.te-form__grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.te-form__row {
  margin-bottom: 1rem;
}

.te-form__actions {
  display: flex;
  flex-wrap: wrap;
  gap: .8rem;
  margin-top: .8rem;
}

/* LOADER (frosted) */
#te-loader {
  position: fixed;
  inset: 0;
  background: rgba(241,241,217,0.92);
  backdrop-filter: blur(8px);
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .8s ease, visibility .8s ease;
}

#te-loader .te-loader__inner {
  text-align: center;
}

#te-loader .te-loader__spin {
  width: 54px;
  height: 54px;
  border: 2px solid rgba(16,39,36,0.22);
  border-top-color: rgba(214,163,84,0.95);
  border-radius: 9999px;
  animation: teSpin 1s linear infinite;
  margin: 0 auto 1rem;
}

#te-loader .te-loader__txt {
  font-size: .85rem;
  letter-spacing: .3em;
  text-transform: uppercase;
  color: rgba(16,39,36,0.82);
}

@keyframes teSpin {
  to { transform: rotate(360deg); }
}

/* FLOATING CTA */
#te-floating {
  position: fixed;
  bottom: 1.6rem;
  right: 1.6rem;
  z-index: 9000;
  opacity: 0;
  transform: translateY(16px);
  transition: all .35s ease;
  pointer-events: none;
}

#te-floating a {
  pointer-events: auto;
  display: inline-flex;
  align-items: center;
  gap: .7rem;
  padding: .95rem 1.3rem;
  border-radius: 9999px;
  background: linear-gradient(135deg, rgba(214,163,84,0.98) 0%, rgba(214,163,84,0.78) 100%);
  color: var(--secondary);
  text-decoration: none;
  font-weight: 800;
  letter-spacing: .03em;
  box-shadow: 0 18px 60px rgba(0,0,0,0.35);
}

#te-floating a:hover {
  transform: translateY(-2px);
}

@media (max-width: 1024px) {
  .te-grid-3 { grid-template-columns: 1fr; }
  .te-grid-2 { grid-template-columns: 1fr; }
  .te-img { height: 420px; }
  .te-steps { grid-template-columns: 1fr; }
  .te-form__grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
  .te-marquee__item {
    width: 260px;
    height: 320px;
  }
}

@media (max-width: 860px) {
  .te-case-grid { grid-template-columns: 1fr !important; }
}

@media (max-width: 480px) {
  #te-floating a span { display: none; }
}
</style>

<div class="te-inspecao">

  <!-- LOADER -->
  <div id="te-loader" aria-hidden="true">
    <div class="te-loader__inner">
      <div class="te-loader__spin"></div>
      <div class="te-loader__txt"><?php echo $t['loader'][$lang]; ?></div>
    </div>
  </div>

  <!-- HERO -->
  <section class="te-hero">
    <div class="te-hero__glow" aria-hidden="true"></div>

    <video class="te-hero__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
      <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4" />
    </video>

    <img class="te-hero__img" data-src="<?php echo esc_url($hero_img); ?>" alt="" aria-hidden="true" />

    <div class="te-hero__overlay" aria-hidden="true"></div>

    <div class="te-hero__content">
      <div class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['hero_kicker'][$lang]; ?></div>
      <h1 class="te-hero__title"><?php echo $t['hero_title'][$lang]; ?></h1>
      <p class="te-hero__subtitle">
        <?php echo $t['hero_subtitle'][$lang]; ?>
      </p>
      <div class="te-hero__actions">
        <a class="te-btn te-btn--primary" href="#contato"><?php echo $t['hero_cta_primary'][$lang]; ?></a>
        <a class="te-btn te-btn--ghost" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener"><?php echo $t['hero_cta_secondary'][$lang]; ?></a>
      </div>
    </div>

    <div class="te-scroll" aria-hidden="true">
      <div class="te-scroll__bar"><div class="te-scroll__dot"></div></div>
      <span><?php echo $t['scroll'][$lang]; ?></span>
    </div>
  </section>

  <!-- NÚMEROS -->
  <section class="te-band--cream">
    <div class="te-wrap te-center">
      <p class="te-kicker" style="background: rgba(16,39,36,0.06); border-color: rgba(16,39,36,0.15); color: rgba(16,39,36,0.85);">
        <span class="te-kicker__dot"></span> <?php echo $t['num_kicker'][$lang]; ?>
      </p>
      <h2 class="te-h2" style="color: var(--secondary);"><?php echo $t['num_title'][$lang]; ?></h2>
      <p class="te-p" style="color: rgba(16,39,36,0.85);"><?php echo $t['num_sub'][$lang]; ?></p>

      <div class="te-grid-3" style="margin-top:2.4rem;">
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);"><?php echo $t['num_c1_title'][$lang]; ?></h3>
          <p><?php echo $t['num_c1_txt'][$lang]; ?></p>
        </div>
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);"><?php echo $t['num_c2_title'][$lang]; ?></h3>
          <p><?php echo $t['num_c2_txt'][$lang]; ?></p>
        </div>
        <div class="te-card" style="background: rgba(16,39,36,0.04); color: rgba(16,39,36,0.92); border-color: rgba(16,39,36,0.12);">
          <h3 style="color: var(--secondary);"><?php echo $t['num_c3_title'][$lang]; ?></h3>
          <p><?php echo $t['num_c3_txt'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- O QUE É -->
  <section class="te-band--green">
    <div class="te-wrap">
      <div class="te-grid-2">
        <div>
          <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['parc_kicker'][$lang]; ?></p>
          <h2 class="te-h2"><?php echo $t['parc_title'][$lang]; ?></h2>
          <p class="te-p" style="margin:0; max-width: 760px;">
            <?php echo $t['parc_txt'][$lang]; ?>
          </p>
          <div class="te-hero__actions" style="justify-content:flex-start; margin-top: 1.6rem;">
            <a class="te-btn te-btn--ghost" href="#processo"><?php echo $t['parc_cta'][$lang]; ?></a>
          </div>
        </div>
        <div class="te-img">
          <img src="<?php echo get_theme_file_uri('assets/images/inspection-hero-photo.jpg'); ?>" alt="<?php echo esc_attr($t['parc_img_alt'][$lang]); ?>" />
        </div>
      </div>
    </div>
  </section>

  <!-- PROCESSO -->
  <section id="processo" class="te-band--green">
    <div class="te-wrap te-center" style="padding-top: 0;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['proc_kicker'][$lang]; ?></p>
      <h2 class="te-h2"><?php echo $t['proc_title'][$lang]; ?></h2>
      <p class="te-p"><?php echo $t['proc_sub'][$lang]; ?></p>

      <div class="te-steps">
        <div class="te-step">
          <div class="te-step__n">01</div>
          <h4><?php echo $t['proc_s1_t'][$lang]; ?></h4>
          <p><?php echo $t['proc_s1_d'][$lang]; ?></p>
        </div>
        <div class="te-step">
          <div class="te-step__n">02</div>
          <h4><?php echo $t['proc_s2_t'][$lang]; ?></h4>
          <p><?php echo $t['proc_s2_d'][$lang]; ?></p>
        </div>
        <div class="te-step">
          <div class="te-step__n">03</div>
          <h4><?php echo $t['proc_s3_t'][$lang]; ?></h4>
          <p><?php echo $t['proc_s3_d'][$lang]; ?></p>
        </div>
        <div class="te-step">
          <div class="te-step__n">04</div>
          <h4><?php echo $t['proc_s4_t'][$lang]; ?></h4>
          <p><?php echo $t['proc_s4_d'][$lang]; ?></p>
        </div>
        <div class="te-step">
          <div class="te-step__n">05</div>
          <h4><?php echo $t['proc_s5_t'][$lang]; ?></h4>
          <p><?php echo $t['proc_s5_d'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- BENEFÍCIOS -->
  <section class="te-band--green">
    <div class="te-wrap te-center" style="padding-top: 0;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['ben_kicker'][$lang]; ?></p>
      <h2 class="te-h2"><?php echo $t['ben_title'][$lang]; ?></h2>
      <p class="te-p"><?php echo $t['ben_sub'][$lang]; ?></p>

      <div class="te-grid-3">
        <div class="te-card">
          <h3><?php echo $t['ben_c1_t'][$lang]; ?></h3>
          <p><?php echo $t['ben_c1_d'][$lang]; ?></p>
        </div>
        <div class="te-card">
          <h3><?php echo $t['ben_c2_t'][$lang]; ?></h3>
          <p><?php echo $t['ben_c2_d'][$lang]; ?></p>
        </div>
        <div class="te-card">
          <h3><?php echo $t['ben_c3_t'][$lang]; ?></h3>
          <p><?php echo $t['ben_c3_d'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- CASE STUDY -->
  <section class="te-band--green">
    <div class="te-wrap">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['case_kicker'][$lang]; ?></p>
      <p style="font-size:.85rem;text-transform:uppercase;letter-spacing:.18em;opacity:.6;margin:.2rem 0 2.4rem;"><?php echo $t['case_label'][$lang]; ?></p>
      <div class="te-case-grid" style="display:grid;grid-template-columns:280px 1fr;gap:4rem;align-items:start;">
        <div style="text-align:center;padding:2rem;background:rgba(0,0,0,0.25);border-radius:18px;border:1px solid rgba(214,163,84,0.2);position:sticky;top:2rem;">
          <div style="font-size:4.5rem;font-weight:800;color:var(--gold);line-height:1;"><?php echo $t['case_loss'][$lang]; ?></div>
          <div style="font-size:.9rem;opacity:.7;margin-top:.4rem;text-transform:uppercase;letter-spacing:.12em;"><?php echo $t['case_loss_label'][$lang]; ?></div>
          <div style="margin-top:1.6rem;padding-top:1.4rem;border-top:1px solid rgba(241,241,217,0.1);font-size:.8rem;opacity:.55;line-height:1.6;">30%<br>material rejected<br><br>1 project lost<br><br>1 client relationship<br>irreparably damaged</div>
        </div>
        <div>
          <h2 class="te-h2" style="font-size:clamp(1.6rem,3vw,2.4rem);text-transform:none;margin-bottom:1.8rem;"><?php echo $t['case_title'][$lang]; ?></h2>
          <p class="te-p" style="margin:0 0 1.2rem;max-width:100%;opacity:.85;"><?php echo $t['case_p1'][$lang]; ?></p>
          <p class="te-p" style="margin:0 0 1.2rem;max-width:100%;opacity:.85;"><?php echo $t['case_p2'][$lang]; ?></p>
          <p class="te-p" style="margin:0 0 2rem;max-width:100%;opacity:.85;"><?php echo $t['case_p3'][$lang]; ?></p>
          <blockquote style="border-left:3px solid var(--gold);padding-left:1.4rem;margin:0 0 1.8rem;font-style:italic;font-size:1.15rem;color:var(--cream);opacity:.95;line-height:1.7;"><?php echo $t['case_quote'][$lang]; ?></blockquote>
          <p class="te-p" style="margin:0;max-width:100%;font-weight:600;font-size:1.05rem;opacity:1;"><?php echo $t['case_footer'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- REPORT SAMPLE -->
  <section class="te-band--cream">
    <div class="te-wrap te-center">
      <p class="te-kicker" style="background:rgba(16,39,36,0.06);border-color:rgba(16,39,36,0.15);color:rgba(16,39,36,0.85);">
        <span class="te-kicker__dot"></span> <?php echo $t['report_kicker'][$lang]; ?>
      </p>
      <h2 class="te-h2" style="color:var(--secondary);"><?php echo $t['report_title'][$lang]; ?></h2>
      <p class="te-p" style="color:rgba(16,39,36,0.85);"><?php echo $t['report_sub'][$lang]; ?></p>
      <div style="margin-top:2.4rem;border-radius:16px;overflow:hidden;box-shadow:0 22px 80px rgba(0,0,0,0.18);border:1px solid rgba(16,39,36,0.1);max-width:860px;margin-left:auto;margin-right:auto;">
        <iframe
          src="https://docs.google.com/viewer?url=<?php echo urlencode(get_theme_file_uri('assets/inspection-sample.pdf')); ?>&embedded=true"
          width="100%"
          height="680"
          style="display:block;border:none;"
          title="<?php echo esc_attr($t['report_title'][$lang]); ?>"
        ></iframe>
      </div>
      <p style="margin-top:1rem;font-size:.78rem;text-transform:uppercase;letter-spacing:.18em;color:rgba(16,39,36,0.45);"><?php echo $t['report_note'][$lang]; ?></p>
    </div>
  </section>

<?php
$carousel_dir = get_theme_file_path('assets/images/');
$carousel_images = glob($carousel_dir . 'inspection-*.jpg');

if (!empty($carousel_images)):
?>
  <!-- NOVO CARROSSEL DE INSPEÇÕES DINÂMICO -->
  <section class="te-band--green">
    <div class="te-wrap te-center" style="padding-top: 0; padding-bottom: 2rem;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['car_kicker'][$lang]; ?></p>
      <h2 class="te-h2"><?php echo $t['car_title'][$lang]; ?></h2>
      <p class="te-p"><?php echo $t['car_sub'][$lang]; ?></p>
    </div>

    <div class="te-marquee">
      <div class="te-marquee__track">
        <!-- Grupo 1 -->
        <div class="te-marquee__group">
          <?php foreach ($carousel_images as $img_path): 
            $img_url = get_theme_file_uri('assets/images/' . basename($img_path));
          ?>
            <div class="te-marquee__item">
              <img src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy">
            </div>
          <?php endforeach; ?>
        </div>
        
        <!-- Grupo 2 para criar o loop perfeito -->
        <div class="te-marquee__group" aria-hidden="true">
          <?php foreach ($carousel_images as $img_path): 
            $img_url = get_theme_file_uri('assets/images/' . basename($img_path));
          ?>
            <div class="te-marquee__item">
              <img src="<?php echo esc_url($img_url); ?>" alt="" loading="lazy">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- CONTATO -->
  <section id="contato" class="te-band--cream">
    <div class="te-wrap te-center">
      <p class="te-kicker" style="background: rgba(16,39,36,0.06); border-color: rgba(16,39,36,0.15); color: rgba(16,39,36,0.85);">
        <span class="te-kicker__dot"></span> <?php echo $t['form_kicker'][$lang]; ?>
      </p>
      <h2 class="te-h2" style="color: var(--secondary);"><?php echo $t['form_title'][$lang]; ?></h2>
      <p class="te-p" style="color: rgba(16,39,36,0.85);"><?php echo $t['form_sub'][$lang]; ?></p>

      <form class="te-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="submit_inspection_request">
        <?php wp_nonce_field('inspection_request', 'inspection_nonce'); ?>

        <div class="te-form__grid">
          <div class="te-form__row">
            <label for="name"><?php echo $t['f_name'][$lang]; ?></label>
            <input type="text" id="name" name="name" required>
          </div>
          <div class="te-form__row">
            <label for="email"><?php echo $t['f_email'][$lang]; ?></label>
            <input type="email" id="email" name="email" required>
          </div>
        </div>

        <div class="te-form__grid">
          <div class="te-form__row">
            <label for="company"><?php echo $t['f_comp'][$lang]; ?></label>
            <input type="text" id="company" name="company">
          </div>
          <div class="te-form__row">
            <label for="material"><?php echo $t['f_mat'][$lang]; ?></label>
            <input type="text" id="material" name="material" placeholder="<?php echo esc_attr($t['f_mat_pl'][$lang]); ?>">
          </div>
        </div>

        <div class="te-form__row">
          <label for="message"><?php echo $t['f_det'][$lang]; ?></label>
          <textarea id="message" name="message" required rows="6" placeholder="<?php echo esc_attr($t['f_det_pl'][$lang]); ?>"></textarea>
        </div>

        <div class="te-form__actions">
          <button type="submit" class="te-btn te-btn--primary"><?php echo $t['f_btn'][$lang]; ?></button>
          <a class="te-btn te-btn--ghost" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">WhatsApp</a>
        </div>
      </form>
    </div>
  </section>

  <!-- FLOATING CTA -->
  <div id="te-floating">
    <a href="#contato" aria-label="<?php echo esc_attr($t['float_cta'][$lang]); ?>">
      <span><?php echo $t['float_cta'][$lang]; ?></span>
      <svg style="width:20px;height:20px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
  </div>

</div>

<script>
// Loader
window.addEventListener('load', function() {
  const loader = document.getElementById('te-loader');
  if (!loader) return;
  setTimeout(function() {
    loader.style.opacity = '0';
    loader.style.visibility = 'hidden';
    setTimeout(function(){ loader.remove(); }, 850);
  }, 650);
});

// Fallback inteligente para vídeo do hero
const heroVideoEl = document.querySelector('.te-hero__video');
const heroImgEl = document.querySelector('.te-hero__img');
if (heroVideoEl && heroImgEl) {
  heroVideoEl.addEventListener('error', function() {
    heroImgEl.src = heroImgEl.dataset.src;
    heroImgEl.style.display = 'block';
  });
  // Também mostrar fallback se o vídeo não carregar em 4 segundos
  setTimeout(function() {
    if (heroVideoEl.readyState === 0) {
      heroImgEl.src = heroImgEl.dataset.src;
      heroImgEl.style.display = 'block';
    }
  }, 4000);
}

// Parallax suave no hero
window.addEventListener('scroll', function() {
  const scrolled = window.pageYOffset || document.documentElement.scrollTop || 0;
  const heroVideo = document.querySelector('.te-hero__video');
  if (!heroVideo) return;
  if (scrolled < window.innerHeight) {
    heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.22}px)) scale(1.1)`;
  }
});

// Floating CTA
window.addEventListener('scroll', function() {
  const el = document.getElementById('te-floating');
  if (!el) return;
  if (window.scrollY > 900) {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0)';
    el.style.pointerEvents = 'auto';
  } else {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.pointerEvents = 'none';
  }
});

// Smooth scroll para âncoras internas
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    const target = href ? document.querySelector(href) : null;
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
</script>

<?php
get_footer();