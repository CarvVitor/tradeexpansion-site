<?php
/**
 * Template Name: Página de Contato
 * Description: Página de contato com fundo em imagem, card com formulário, envio por e-mail e salvamento como Lead (CPT).
 */

if ( ! defined('ABSPATH') ) { exit; }

// === Configurações rápidas ===
$te_recipients = ['valeria@tradeexpansion.com.br','vitor@tradeexpansion.com.br'];
$te_whatsapp   = 'https://wa.me/5527992284517';
$bg_img        = get_theme_file_uri('assets/images/hero-rochas-fallback.jpg'); // temporário

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
    $subject = isset($_POST['te_subject']) ? sanitize_text_field($_POST['te_subject']) : '';
    $message = isset($_POST['te_message']) ? sanitize_textarea_field($_POST['te_message']) : '';
    $lgpd    = ! empty($_POST['te_lgpd']) ? 'yes' : 'no';

    if ( $name === '' )   { $te_errors[] = 'Informe seu nome.'; }
    if ( ! is_email($email) ) { $te_errors[] = 'Informe um e-mail válido.'; }
    if ( $subject === '' ) { $te_errors[] = 'Informe o assunto.'; }
    if ( $message === '' ) { $te_errors[] = 'Escreva uma mensagem.'; }
    if ( $lgpd !== 'yes' ) { $te_errors[] = 'Confirme o consentimento LGPD.'; }

    if ( empty($te_errors) ) {
        // 1) Envia e-mail
        $site  = wp_specialchars_decode( get_bloginfo('name'), ENT_QUOTES );
        $title = $subject ? $subject : 'Novo contato do site';
        $body  = '<h2>Novo contato</h2>'
               . '<p><strong>Nome:</strong> ' . esc_html($name) . '</p>'
               . '<p><strong>E-mail:</strong> ' . esc_html($email) . '</p>'
               . '<p><strong>Empresa:</strong> ' . esc_html($company) . '</p>'
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

<main id="primary" class="site-main">

  <section class="relative min-h-[70vh] flex items-center justify-center">
    <img src="<?php echo esc_url($bg_img); ?>" alt="" class="absolute inset-0 w-full h-full object-cover" />
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative w-full max-w-6xl px-6 py-16 grid grid-cols-1 md:grid-cols-12 gap-8">
      <!-- Texto lateral (esquerda) -->
      <div class="md:col-span-6 text-gray-100">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Fale com a Trade Expansion</h1>
        <p class="text-base md:text-lg opacity-90 mb-6">
          Conte com nossa equipe para exportação de rochas ornamentais e inspeções técnicas. Preencha o formulário ou fale direto no WhatsApp.
        </p>

        <ul class="space-y-2 text-sm md:text-base">
          <li><strong>E-mail:</strong> <a class="underline hover:opacity-80" href="mailto:valeria@tradeexpansion.com.br">valeria@tradeexpansion.com.br</a> / <a class="underline hover:opacity-80" href="mailto:vitor@tradeexpansion.com.br">vitor@tradeexpansion.com.br</a></li>
          <li><strong>WhatsApp:</strong> <a class="underline hover:opacity-80" href="<?php echo esc_url($te_whatsapp); ?>" target="_blank" rel="noopener">Falar com um especialista</a></li>
        </ul>
      </div>

      <!-- Card (direita) -->
      <div class="md:col-span-6">
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl p-6 md:p-8">
          <?php if ( $te_success ) : ?>
            <div class="p-4 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 mb-6">
              Mensagem enviada com sucesso! Em breve entraremos em contato.
            </div>
          <?php elseif ( ! empty($te_errors) ) : ?>
            <div class="p-4 rounded-md bg-rose-50 text-rose-800 border border-rose-200 mb-6">
              <ul class="list-disc list-inside">
                <?php foreach ($te_errors as $e) : ?>
                  <li><?php echo esc_html($e); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="space-y-4">
            <?php wp_nonce_field('te_contact','te_contact_nonce'); ?>

            <!-- Honeypot -->
            <div style="position:absolute; left:-9999px;" aria-hidden="true">
              <label>Seu website</label>
              <input type="text" name="te_company_website" tabindex="-1" autocomplete="off" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome*</label>
                <input class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                       type="text" name="te_name" required value="<?php echo isset($name) ? esc_attr($name) : ''; ?>">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail*</label>
                <input class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                       type="email" name="te_email" required value="<?php echo isset($email) ? esc_attr($email) : ''; ?>">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
              <input class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                     type="text" name="te_company" value="<?php echo isset($company) ? esc_attr($company) : ''; ?>">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Assunto*</label>
              <input class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                     type="text" name="te_subject" required value="<?php echo isset($subject) ? esc_attr($subject) : ''; ?>">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Mensagem*</label>
              <textarea class="w-full rounded-lg border border-gray-300 px-3 py-2 h-32 focus:outline-none focus:ring-2 focus:ring-emerald-600"
                        name="te_message" required><?php echo isset($message) ? esc_textarea($message) : ''; ?></textarea>
            </div>

            <label class="inline-flex items-start gap-2 text-sm text-gray-700">
              <input type="checkbox" name="te_lgpd" value="1" required class="mt-1">
              <span>Autorizo o tratamento dos meus dados para que a Trade Expansion entre em contato. Posso revogar a qualquer momento.</span>
            </label>

            <div class="flex flex-wrap gap-3 pt-2">
              <button type="submit" class="te-btn"
                      style="background:#484942; color:#E1E2DA; border-color:#484942;">
                Enviar mensagem
              </button>
              <a href="<?php echo esc_url($te_whatsapp); ?>" target="_blank" rel="noopener"
                 class="te-btn te-btn--ghost"
                 style="color:#102724; border-color:#102724;">
                 Falar com um especialista
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Mapa (troque o src pelo embed oficial do endereço da Trade Expansion) -->
  <section class="py-10">
    <div class="w-full max-w-6xl mx-auto px-6">
      <div class="aspect-[16/9] w-full rounded-xl overflow-hidden shadow-md">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.8088225068846!2d-41.1271985234266!3d-20.839425067273847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb95d4df8c9ddf9%3A0x6d354a2298242c18!2sR.%20Astor%20Dillen%20dos%20Santos%2C%2024%20-%20Vila%20Rica%2C%20Cachoeiro%20de%20Itapemirim%20-%20ES%2C%2029301-041!5e0!3m2!1spt-BR!2sbr!4v1761677530661!5m2!1spt-BR!2sbr"
          style="width:100%; height:100%; border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>