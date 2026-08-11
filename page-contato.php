<?php
/**
 * Template Name: Página de Contato
 * Description: Página de contato com formulário, envio por e-mail, salvamento como Lead (CPT) e suporte multilíngue.
 */

if ( ! defined('ABSPATH') ) { exit; }

// 1. SISTEMA DE IDIOMAS
$lang = get_query_var('te_lang') ?: 'pt';

$t = [
  'page_kicker' => ['pt'=>'Fale com um especialista', 'en'=>'Speak with a specialist', 'es'=>'Hable con un especialista'],
  'page_title' => ['pt'=>'Vamos conversar sobre sua próxima operação', 'en'=>'Let\'s talk about your next operation', 'es'=>'Hablemos sobre su próxima operación'],
  'page_sub' => ['pt'=>'Inspeção técnica, curadoria de rochas ou intermediação comercial. Respondemos em até 1 dia útil com próximos passos claros.', 'en'=>'Technical inspection, stone curation, or commercial intermediation. We respond within 1 business day with clear next steps.', 'es'=>'Inspección técnica, curaduría de piedras o intermediación comercial. Respondemos en 1 día hábil con pasos claros.'],
  
  'contact_email_label' => ['pt'=>'E-mail', 'en'=>'Email', 'es'=>'Correo'],
  'contact_wa_label' => ['pt'=>'WhatsApp', 'en'=>'WhatsApp', 'es'=>'WhatsApp'],
  'contact_wa_sub' => ['pt'=>'resposta rápida', 'en'=>'quick response', 'es'=>'respuesta rápida'],
  'contact_wa_cta' => ['pt'=>'Falar com um especialista', 'en'=>'Speak with a specialist', 'es'=>'Hablar con un especialista'],
  'contact_time_label' => ['pt'=>'Tempo de resposta', 'en'=>'Response time', 'es'=>'Tiempo de respuesta'],
  'contact_time_val' => ['pt'=>'Até 1 dia útil com próximos passos', 'en'=>'Within 1 business day with next steps', 'es'=>'En 1 día hábil con los próximos pasos'],
  'contact_tz' => ['pt'=>'Fuso horário: BRT (UTC-3) · Espírito Santo, Brasil', 'en'=>'Time zone: BRT (UTC-3) · Espírito Santo, Brazil', 'es'=>'Zona horaria: BRT (UTC-3) · Espírito Santo, Brasil'],
  
  'form_title' => ['pt'=>'Envie sua mensagem', 'en'=>'Send your message', 'es'=>'Envíe su mensaje'],
  'f_name' => ['pt'=>'Nome completo *', 'en'=>'Full name *', 'es'=>'Nombre completo *'],
  'f_email' => ['pt'=>'E-mail *', 'en'=>'Email *', 'es'=>'Correo electrónico *'],
  'f_company' => ['pt'=>'Empresa', 'en'=>'Company', 'es'=>'Empresa'],
  'f_country' => ['pt'=>'País', 'en'=>'Country', 'es'=>'País'],
  'f_country_pl' => ['pt'=>'Ex.: Portugal, Itália, EUA', 'en'=>'E.g.: Portugal, Italy, USA', 'es'=>'Ej.: España, Italia, EE.UU.'],
  'f_subject' => ['pt'=>'Assunto *', 'en'=>'Subject *', 'es'=>'Asunto *'],
  'f_subject_pl' => ['pt'=>'Ex.: Inspeção de quartzito, Curadoria de material', 'en'=>'E.g.: Quartzite inspection, Stone curation', 'es'=>'Ej.: Inspección de cuarcita, Curaduría de material'],
  'f_message' => ['pt'=>'Mensagem *', 'en'=>'Message *', 'es'=>'Mensaje *'],
  'f_message_pl' => ['pt'=>'Descreva o material, quantidade, destino e qualquer exigência específica...', 'en'=>'Describe the material, quantity, destination and any specific requirements...', 'es'=>'Describa el material, cantidad, destino y cualquier requisito específico...'],
  'f_lgpd' => ['pt'=>'Autorizo o tratamento dos meus dados para que a Trade Expansion entre em contato. Posso revogar a qualquer momento.', 'en'=>'I consent to my data being processed so Trade Expansion can contact me. I may withdraw consent at any time.', 'es'=>'Autorizo el tratamiento de mis datos para que Trade Expansion pueda contactarme. Puedo revocar este consentimiento en cualquier momento.'],
  'f_btn' => ['pt'=>'Enviar mensagem', 'en'=>'Send message', 'es'=>'Enviar mensaje'],
  'f_wa_btn' => ['pt'=>'Falar no WhatsApp', 'en'=>'WhatsApp', 'es'=>'WhatsApp'],
  
  'f_success' => ['pt'=>'Mensagem enviada! Entraremos em contato em até 1 dia útil.', 'en'=>'Message sent! We will get back to you within 1 business day.', 'es'=>'¡Mensaje enviado! Le responderemos en 1 día hábil.'],
  'f_error_name' => ['pt'=>'Informe seu nome.', 'en'=>'Please enter your name.', 'es'=>'Por favor ingrese su nombre.'],
  'f_error_email' => ['pt'=>'Informe um e-mail válido.', 'en'=>'Please enter a valid email.', 'es'=>'Por favor ingrese un correo válido.'],
  'f_error_subject' => ['pt'=>'Informe o assunto.', 'en'=>'Please enter a subject.', 'es'=>'Por favor ingrese el asunto.'],
  'f_error_message' => ['pt'=>'Escreva uma mensagem.', 'en'=>'Please write a message.', 'es'=>'Por favor escriba un mensaje.'],
  'f_error_lgpd' => ['pt'=>'Confirme o consentimento para continuar.', 'en'=>'Please confirm your consent to continue.', 'es'=>'Por favor confirme su consentimiento para continuar.'],
  
  'loader_txt' => ['pt'=>'Validando rota e documentação…', 'en'=>'Validating route and documentation…', 'es'=>'Validando ruta y documentación…'],
  
  'trust_kicker' => ['pt'=>'Como funciona', 'en'=>'How it works', 'es'=>'Cómo funciona'],
  'trust_title' => ['pt'=>'O que acontece depois que você envia', 'en'=>'What happens after you reach out', 'es'=>'Qué sucede después de contactarnos'],
  'trust_c1_t' => ['pt'=>'Recebemos sua mensagem', 'en'=>'We receive your message', 'es'=>'Recibimos su mensaje'],
  'trust_c1_d' => ['pt'=>'Você recebe uma confirmação imediata. Internamente, seu contato já entra no nosso sistema como Lead prioritário.', 'en'=>'You receive an immediate confirmation. Internally, your contact enters our system as a priority lead.', 'es'=>'Usted recibe una confirmación inmediata. Internamente, su contacto entra en nuestro sistema como lead prioritario.'],
  'trust_c2_t' => ['pt'=>'Análise técnica em até 1 dia útil', 'en'=>'Technical review within 1 business day', 'es'=>'Revisión técnica en 1 día hábil'],
  'trust_c2_d' => ['pt'=>'Um especialista avalia seu pedido e responde com uma proposta de próximos passos — inspeção, curadoria ou intermediação.', 'en'=>'A specialist reviews your request and responds with a proposed next step — inspection, curation, or intermediation.', 'es'=>'Un especialista revisa su solicitud y responde con un próximo paso propuesto — inspección, curaduría o intermediación.'],
  'trust_c3_t' => ['pt'=>'Alinhamento e início da operação', 'en'=>'Alignment and start of operation', 'es'=>'Alineación e inicio de la operación'],
  'trust_c3_d' => ['pt'=>'Definimos especificações, tolerâncias e cronograma. A partir daí, cada etapa é documentada e rastreável.', 'en'=>'We define specifications, tolerances, and timeline. From there, every stage is documented and traceable.', 'es'=>'Definimos especificaciones, tolerancias y cronograma. A partir de ahí, cada etapa es documentada y trazable.'],
  
  'map_kicker' => ['pt'=>'Onde estamos', 'en'=>'Where we are', 'es'=>'Dónde estamos'],
  'map_title' => ['pt'=>'Espírito Santo, Brasil', 'en'=>'Espírito Santo, Brazil', 'es'=>'Espírito Santo, Brasil'],
  'map_sub' => ['pt'=>'Sede operacional · Inspeções no ES, MG e BA', 'en'=>'Operational headquarters · Inspections in ES, MG and BA', 'es'=>'Sede operacional · Inspecciones en ES, MG y BA'],
];

// 2. META TAGS
add_action('wp_head', function() use ($lang) {
  $titles = [
    'pt' => 'Contato | Trade Expansion — Rochas Ornamentais para Exportação',
    'en' => 'Contact | Trade Expansion — Brazilian Natural Stone Export',
    'es' => 'Contacto | Trade Expansion — Exportación de Piedras Naturales'
  ];
  $descs = [
    'pt' => 'Entre em contato com a Trade Expansion para inspeção técnica, curadoria de rochas ornamentais ou intermediação comercial. Respondemos em até 1 dia útil.',
    'en' => 'Contact Trade Expansion for technical inspection, natural stone curation, or commercial intermediation. We respond within 1 business day.',
    'es' => 'Contacte a Trade Expansion para inspección técnica, curaduría de piedras naturales o intermediación comercial. Respondemos en 1 día hábil.'
  ];
  echo '<title>' . $titles[$lang] . '</title>' . "\n";
  echo '<meta name="description" content="' . $descs[$lang] . '">' . "\n";
}, 1);

// === Configurações rápidas ===
$te_recipients = ['valeria@tradeexpansion.com.br','vitor@tradeexpansion.com.br'];
$te_whatsapp   = 'https://wa.me/5527992284517';
$bg_img        = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg'); 
$bg_video      = get_theme_file_uri('assets/videos/contato-hero.mp4'); 
$map_embed_src = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.8088225068846!2d-41.1271985234266!3d-20.839425067273847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb95d4df8c9ddf9%3A0x6d354a2298242c18!2sR.%20Astor%20Dillen%20dos%20Santos%2C%2024%20-%20Vila%20Rica%2C%20Cachoeiro%20de%20Itapemirim%20-%20ES%2C%2029301-041!5e0!3m2!1spt-BR!2sbr!4v1761677530661!5m2!1spt-BR!2sbr';

// Estado de submissão
$te_success = false;
$te_errors  = [];

// Processa formulário
if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['te_contact_nonce']) && wp_verify_nonce( $_POST['te_contact_nonce'], 'te_contact' ) ) {
    // Honeypot
    if ( ! empty($_POST['te_company_website']) ) {
        $te_errors[] = 'Falha de validação.';
    }

    $name    = isset($_POST['te_name'])    ? sanitize_text_field($_POST['te_name']) : '';
    $email   = isset($_POST['te_email'])   ? sanitize_email($_POST['te_email'])     : '';
    $company = isset($_POST['te_company']) ? sanitize_text_field($_POST['te_company']) : '';
    $country = isset($_POST['te_country']) ? sanitize_text_field($_POST['te_country']) : '';
    $subject = isset($_POST['te_subject']) ? sanitize_text_field($_POST['te_subject']) : '';
    $message = isset($_POST['te_message']) ? sanitize_textarea_field($_POST['te_message']) : '';
    $lgpd    = ! empty($_POST['te_lgpd']) ? 'yes' : 'no';

    if ( $name === '' )   { $te_errors[] = $t['f_error_name'][$lang]; }
    if ( ! is_email($email) ) { $te_errors[] = $t['f_error_email'][$lang]; }
    if ( $subject === '' ) { $te_errors[] = $t['f_error_subject'][$lang]; }
    if ( $message === '' ) { $te_errors[] = $t['f_error_message'][$lang]; }
    if ( $lgpd !== 'yes' ) { $te_errors[] = $t['f_error_lgpd'][$lang]; }

    if ( empty($te_errors) ) {
        // 1) Envia e-mail
        $site  = wp_specialchars_decode( get_bloginfo('name'), ENT_QUOTES );
        $title = $subject ? $subject : 'Novo contato do site';
        $body  = '<h2>Novo contato</h2>'
               . '<p><strong>Nome:</strong> ' . esc_html($name) . '</p>'
               . '<p><strong>E-mail:</strong> ' . esc_html($email) . '</p>'
               . '<p><strong>Empresa:</strong> ' . esc_html($company) . '</p>'
               . '<p><strong>País:</strong> ' . esc_html($country) . '</p>'
               . '<p><strong>Assunto:</strong> ' . esc_html($subject) . '</p>'
               . '<p><strong>Mensagem:</strong><br>' . nl2br(esc_html($message)) . '</p>'
               . '<hr><p><small>LGPD: ' . ($lgpd === 'yes' ? 'consentiu' : 'não consentiu') . '</small></p>';

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: ' . $name . ' <' . $email . '>',
        ];

        wp_mail( $te_recipients, '[' . $site . '] ' . $title, $body, $headers );

        // 2) Salva como Lead (CPT te_lead)
        if ( post_type_exists('te_lead') ) {
            $lead_id = wp_insert_post([
                'post_type'   => 'te_lead',
                'post_status' => 'publish',
                'post_title'  => sprintf('Lead • %s • %s', $name, current_time('d/m/Y H:i')),
                'post_content'=> $message,
            ]);
            if ( $lead_id && ! is_wp_error($lead_id) ) {
                update_post_meta($lead_id, 'lead_name',    $name);
                update_post_meta($lead_id, 'lead_email',   $email);
                update_post_meta($lead_id, 'lead_company', $company);
                update_post_meta($lead_id, 'lead_country', $country);
                update_post_meta($lead_id, 'lead_subject', $subject);
                update_post_meta($lead_id, 'lead_lgpd',    $lgpd);
                update_post_meta($lead_id, 'lead_ip',      $_SERVER['REMOTE_ADDR'] ?? '');
                update_post_meta($lead_id, 'lead_ua',      $_SERVER['HTTP_USER_AGENT'] ?? '');
            }
        }

        $te_success = true;
    }
}

get_header();
?>

<style>
:root {
  --secondary: #102724;
  --cream: #F1F1D9;
  --text: #E1E2DA;
  --ink: #1D1F1E;
  --gold: #D6A354;
}

.te-contato {
  font-family: 'Vollkorn', Georgia, serif;
  color: var(--ink);
  overflow-x: hidden;
}

/* Loader */
#te-loader {
  position: fixed;
  inset: 0;
  background: rgba(241, 241, 217, 0.92);
  backdrop-filter: blur(10px);
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .85s ease, visibility .85s ease;
}
#te-loader .te-loader__spin {
  width: 54px;
  height: 54px;
  border: 2px solid rgba(16, 39, 36, 0.22);
  border-top-color: rgba(214, 163, 84, 0.95);
  border-radius: 9999px;
  animation: teSpin 1s linear infinite;
  margin: 0 auto 1rem;
}
#te-loader .te-loader__txt {
  font-size: .85rem;
  letter-spacing: .32em;
  text-transform: uppercase;
  color: rgba(16, 39, 36, 0.82);
  text-align: center;
}
@keyframes teSpin { to { transform: rotate(360deg); } }

/* Layout Geral */
.te-band--green {
  background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%);
  color: var(--text);
  position: relative;
}
.te-band--cream {
  background: linear-gradient(180deg, var(--cream) 0%, #E5E5D5 100%);
  position: relative;
}
.te-wrap {
  max-width: 1400px;
  margin: 0 auto;
  padding: 5.5rem 1.5rem;
  position: relative;
  z-index: 2;
}

/* SEÇÃO 1: HERO/HEADER (Altura adaptável ~60vh) */
.te-hero-contato {
  position: relative;
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  padding: 8rem 1.5rem 4rem; /* padding extra no topo para o menu */
}
.te-hero-contato__video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  transform: translate(-50%, -50%) scale(1.1);
  object-fit: cover;
  opacity: 0.15;
  will-change: transform;
}
.te-hero-contato__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.15;
  display: none;
}
.te-hero-contato__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(16,39,36,0.65) 0%, rgba(16,39,36,0.85) 55%, rgba(16,39,36,1) 100%);
}

.te-contato-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: start;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
}

/* Tipografia e Base */
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
.te-h2 {
  font-size: clamp(2.2rem, 4vw, 3.4rem);
  font-weight: 600;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  margin: .8rem 0 1.2rem;
  line-height: 1.1;
}
.te-p {
  font-size: 1.08rem;
  line-height: 1.8;
  opacity: .9;
  margin-bottom: 2rem;
}

/* Contato Itens */
.te-contact-item {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.2rem 0;
  border-bottom: 1px solid rgba(241,241,217,0.1);
}
.te-contact-item:last-child { border-bottom: none; }
.te-contact-icon {
  width: 40px;
  height: 40px;
  border-radius: 9999px;
  background: rgba(214,163,84,0.15);
  border: 1px solid rgba(214,163,84,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: var(--gold);
}
.te-contact-text h4 {
  font-size: .85rem;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: rgba(241,241,217,0.6);
  margin: 0 0 .2rem 0;
}
.te-contact-text p, .te-contact-text a {
  font-size: 1.05rem;
  color: var(--cream);
  text-decoration: none;
  margin: 0;
}
.te-contact-text a:hover { opacity: .8; }

/* Formulário e Card */
.te-form-card {
  background: var(--cream);
  color: var(--ink);
  border-radius: 16px;
  padding: 2.5rem;
  box-shadow: 0 24px 60px rgba(0,0,0,0.4);
}
.te-form-card h3 {
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 2rem;
  color: var(--secondary);
}

.te-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}
.te-form__row {
  display: flex;
  flex-direction: column;
  gap: .5rem;
}
.te-form__grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
}
.te-form label {
  font-size: .85rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: var(--secondary);
  opacity: .85;
}
.te-form input,
.te-form textarea {
  width: 100%;
  background: rgba(255,255,255,0.6);
  border: 1px solid rgba(16,39,36,0.15);
  border-radius: 8px;
  padding: .85rem 1rem;
  font-family: inherit;
  font-size: 1rem;
  color: var(--ink);
  transition: border-color .2s ease, background .2s ease;
}
.te-form input:focus,
.te-form textarea:focus {
  outline: none;
  border-color: rgba(214,163,84,0.6);
  background: #fff;
}
.te-form textarea {
  min-height: 120px;
  resize: vertical;
}
.te-form__checkbox {
  display: flex;
  align-items: flex-start;
  gap: .8rem;
  font-size: .9rem;
  line-height: 1.5;
  color: rgba(16,39,36,0.85);
  margin-top: .5rem;
}
.te-form__checkbox input {
  width: auto;
  margin-top: .2rem;
}

/* Botões */
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
  cursor: pointer;
}
.te-btn--primary {
  background: var(--gold);
  color: var(--secondary);
  border: 1px solid rgba(214,163,84,0.55);
  box-shadow: 0 18px 60px rgba(0,0,0,0.15);
  width: 100%;
}
.te-btn--primary:hover {
  transform: translateY(-2px);
  border-color: rgba(214,163,84,0.85);
}

/* Grids Inferiores (Seção 2) */
.te-grid-3 {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.4rem;
  margin-top: 3rem;
}
.te-card {
  border-radius: 16px;
  padding: 2.2rem 1.8rem;
  transition: transform .2s ease, border-color .2s ease;
}
.te-card:hover { transform: translateY(-6px); }
.te-card--light {
  background: rgba(16,39,36,0.04);
  border: 1px solid rgba(16,39,36,0.12);
}
.te-card--light:hover { border-color: rgba(16,39,36,0.35); }
.te-card h3 {
  font-size: 1.35rem;
  font-weight: 600;
  color: var(--secondary);
  margin-bottom: 1rem;
}
.te-card p {
  font-size: 1rem;
  line-height: 1.6;
  opacity: .85;
  color: rgba(16,39,36,0.85);
}

/* Alertas de form */
.te-alert {
  padding: 1rem 1.5rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  font-weight: 500;
}
.te-alert--success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.te-alert--error { background: #ffe4e6; color: #9f1239; border: 1px solid #fecdd3; }
.te-alert ul { margin: .5rem 0 0 1.5rem; padding: 0; }

/* Animações */
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
  .te-contato-grid { grid-template-columns: 1fr; gap: 3rem; }
  .te-grid-3 { grid-template-columns: 1fr; }
  .te-form__grid { grid-template-columns: 1fr; }
  .te-hero-contato { padding-top: 6rem; }
}
</style>

<main class="te-contato">

  <!-- Loader -->
  <div id="te-loader" aria-hidden="true">
    <div>
      <div class="te-loader__spin"></div>
      <div class="te-loader__txt"><?php echo $t['loader_txt'][$lang]; ?></div>
    </div>
  </div>

  <!-- SEÇÃO 1: HEADER & FORM -->
  <section class="te-band--green te-hero-contato">
    <video class="te-hero-contato__video te-hero__video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
      <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4" />
    </video>
    <img class="te-hero-contato__img te-hero__img" data-src="<?php echo esc_url($bg_img); ?>" alt="" aria-hidden="true" />
    <div class="te-hero-contato__overlay" aria-hidden="true"></div>

    <div class="te-contato-grid">
      
      <!-- Lado Esquerdo: Info -->
      <div class="fade-in-up">
        <div class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['page_kicker'][$lang]; ?></div>
        <h1 class="te-h2 text-custom1"><?php echo $t['page_title'][$lang]; ?></h1>
        <p class="te-p"><?php echo $t['page_sub'][$lang]; ?></p>

        <div>
          <!-- E-mail -->
          <div class="te-contact-item">
            <div class="te-contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
            <div class="te-contact-text">
              <h4><?php echo $t['contact_email_label'][$lang]; ?></h4>
              <p>
                <a href="mailto:valeria@tradeexpansion.com.br">valeria@tradeexpansion.com.br</a><br>
                <a href="mailto:vitor@tradeexpansion.com.br">vitor@tradeexpansion.com.br</a>
              </p>
            </div>
          </div>
          
          <!-- WhatsApp -->
          <div class="te-contact-item">
            <div class="te-contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            </div>
            <div class="te-contact-text">
              <h4><?php echo $t['contact_wa_label'][$lang]; ?></h4>
              <p>
                <a href="<?php echo esc_url($te_whatsapp); ?>" target="_blank" rel="noopener"><?php echo $t['contact_wa_cta'][$lang]; ?></a> 
                <span style="opacity:.6; font-size:.9rem;">(<?php echo $t['contact_wa_sub'][$lang]; ?>)</span>
              </p>
            </div>
          </div>

          <!-- Tempo de Resposta e Fuso -->
          <div class="te-contact-item">
            <div class="te-contact-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div class="te-contact-text">
              <h4><?php echo $t['contact_time_label'][$lang]; ?></h4>
              <p><?php echo $t['contact_time_val'][$lang]; ?></p>
              <p style="opacity:.6; font-size:.9rem; margin-top:.3rem;"><?php echo $t['contact_tz'][$lang]; ?></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Lado Direito: Formulário -->
      <div class="fade-in-up" style="transition-delay: .1s;">
        <div class="te-form-card">
          <h3><?php echo $t['form_title'][$lang]; ?></h3>

          <?php if ( $te_success ) : ?>
            <div class="te-alert te-alert--success">
              <?php echo $t['f_success'][$lang]; ?>
            </div>
          <?php elseif ( ! empty($te_errors) ) : ?>
            <div class="te-alert te-alert--error">
              <ul>
                <?php foreach ($te_errors as $e) : ?>
                  <li><?php echo esc_html($e); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="te-form">
            <?php wp_nonce_field('te_contact','te_contact_nonce'); ?>

            <!-- Honeypot -->
            <div style="position:absolute; left:-9999px;" aria-hidden="true">
              <label>Website</label>
              <input type="text" name="te_company_website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="te-form__grid">
              <div class="te-form__row">
                <label><?php echo $t['f_name'][$lang]; ?></label>
                <input type="text" name="te_name" required value="<?php echo isset($name) ? esc_attr($name) : ''; ?>">
              </div>
              <div class="te-form__row">
                <label><?php echo $t['f_email'][$lang]; ?></label>
                <input type="email" name="te_email" required value="<?php echo isset($email) ? esc_attr($email) : ''; ?>">
              </div>
            </div>

            <div class="te-form__grid">
              <div class="te-form__row">
                <label><?php echo $t['f_company'][$lang]; ?></label>
                <input type="text" name="te_company" value="<?php echo isset($company) ? esc_attr($company) : ''; ?>">
              </div>
              <div class="te-form__row">
                <label><?php echo $t['f_country'][$lang]; ?></label>
                <input type="text" name="te_country" placeholder="<?php echo esc_attr($t['f_country_pl'][$lang]); ?>" value="<?php echo isset($country) ? esc_attr($country) : ''; ?>">
              </div>
            </div>

            <div class="te-form__row">
              <label><?php echo $t['f_subject'][$lang]; ?></label>
              <input type="text" name="te_subject" placeholder="<?php echo esc_attr($t['f_subject_pl'][$lang]); ?>" required value="<?php echo isset($subject) ? esc_attr($subject) : ''; ?>">
            </div>

            <div class="te-form__row">
              <label><?php echo $t['f_message'][$lang]; ?></label>
              <textarea name="te_message" placeholder="<?php echo esc_attr($t['f_message_pl'][$lang]); ?>" required><?php echo isset($message) ? esc_textarea($message) : ''; ?></textarea>
            </div>

            <label class="te-form__checkbox">
              <input type="checkbox" name="te_lgpd" value="1" required>
              <span><?php echo $t['f_lgpd'][$lang]; ?></span>
            </label>

            <button type="submit" class="te-btn te-btn--primary">
              <?php echo $t['f_btn'][$lang]; ?>
            </button>
          </form>
        </div>
      </div>

    </div>
  </section>

  <!-- SEÇÃO 2: TRUST SIGNALS -->
  <section class="te-band--cream">
    <div class="te-wrap">
      <div class="te-center fade-in-up">
        <p class="te-kicker" style="background:rgba(16,39,36,0.06);border-color:rgba(16,39,36,0.15);color:rgba(16,39,36,0.85);">
          <span class="te-kicker__dot"></span> <?php echo $t['trust_kicker'][$lang]; ?>
        </p>
        <h2 class="te-h2" style="color:var(--secondary);"><?php echo $t['trust_title'][$lang]; ?></h2>
      </div>

      <div class="te-grid-3 fade-in-up">
        <div class="te-card te-card--light">
          <h3><?php echo $t['trust_c1_t'][$lang]; ?></h3>
          <p><?php echo $t['trust_c1_d'][$lang]; ?></p>
        </div>
        <div class="te-card te-card--light">
          <h3><?php echo $t['trust_c2_t'][$lang]; ?></h3>
          <p><?php echo $t['trust_c2_d'][$lang]; ?></p>
        </div>
        <div class="te-card te-card--light">
          <h3><?php echo $t['trust_c3_t'][$lang]; ?></h3>
          <p><?php echo $t['trust_c3_d'][$lang]; ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- SEÇÃO 3: MAPA -->
  <section class="te-band--green" style="padding-bottom: 2rem;">
    <div class="te-wrap te-center fade-in-up" style="padding-top: 5rem; padding-bottom: 3rem;">
      <p class="te-kicker"><span class="te-kicker__dot"></span> <?php echo $t['map_kicker'][$lang]; ?></p>
      <h2 class="te-h2" style="margin-bottom: .5rem;"><?php echo $t['map_title'][$lang]; ?></h2>
      <p style="opacity: .7; font-size: 1.05rem;"><?php echo $t['map_sub'][$lang]; ?></p>
    </div>

    <div class="te-wrap fade-in-up" style="padding-top: 0; padding-bottom: 5rem;">
      <div style="width: 100%; border-radius: 16px; overflow: hidden; border: 1px solid rgba(241,241,217,0.12); aspect-ratio: 16/9; max-height: 600px;">
        <iframe
          src="<?php echo esc_url($map_embed_src); ?>"
          style="width:100%; height:100%; border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

</main>

<script>
  // Loader
  window.addEventListener('load', function () {
    const loader = document.getElementById('te-loader');
    if (!loader) return;
    setTimeout(function () {
      loader.style.opacity = '0';
      loader.style.visibility = 'hidden';
      setTimeout(function () { loader.remove(); }, 900);
    }, 520);
  });

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
      heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.12}px)) scale(1.1)`;
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