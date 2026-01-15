<?php
if (!defined('ABSPATH')) {
  exit;
}

if (!is_user_logged_in()) {
  $login_slug = defined('TE_CLIENT_PORTAL_LOGIN_SLUG') ? TE_CLIENT_PORTAL_LOGIN_SLUG : 'wp-login.php';
  wp_safe_redirect(home_url('/' . trim($login_slug, '/') . '/'));
  exit;
}

$post_id = (int) get_query_var('tec_export_post');
if (!$post_id && isset($_GET['id'])) { // fallback
  $post_id = (int) $_GET['id'];
}

if (!$post_id) {
  wp_die(__('ID de relatório inválido.', 'tradeexpansion'));
}

$post = get_post($post_id);
if (!$post || $post->post_type !== 'tec_relatorio') {
  wp_die(__('Relatório não encontrado.', 'tradeexpansion'));
}

$current_user = wp_get_current_user();
$client_id = (int) get_post_meta($post_id, 'tec_cliente_id', true);
$can_edit = current_user_can('edit_post', $post_id);
$can_view_as_client = ($client_id && $current_user && (int) $current_user->ID === $client_id);

if (!$can_edit && !$can_view_as_client) {
  wp_die(__('Você não tem permissão para acessar este relatório.', 'tradeexpansion'), __('Acesso negado', 'tradeexpansion'), ['response' => 403]);
}

$report_title   = get_the_title($post);
$report_date    = get_post_time('d/m/Y', false, $post, true);
$status_slug    = get_post_meta($post_id, 'tec_status', true);
$status_label   = te_client_portal_format_report_status($status_slug);
$cliente_nome   = function_exists('tec_portal_get_client_name') ? tec_portal_get_client_name($client_id) : '';
$responsavel    = get_the_author_meta('display_name', $post->post_author);
$material_nome  = get_post_meta($post_id, 'tec_material_nome', true);
$lote_codigo    = get_post_meta($post_id, 'tec_lote_codigo', true);
$local_inspecao = get_post_meta($post_id, 'tec_local', true);
$data_inspecao  = get_post_meta($post_id, 'tec_data_inspecao', true);
if (!$data_inspecao) {
  $data_inspecao = get_post_time('Y-m-d', false, $post, true);
}
$resumo         = get_post_meta($post_id, 'tec_resumo', true);
$observacoes    = trim($post->post_content);
$observacoes    = $observacoes ? apply_filters('the_content', $observacoes) : '<p>' . esc_html__('Nenhuma observação adicional registrada.', 'tradeexpansion') . '</p>';

$checklist_items = [
  __('Integridade das chapas/blocos', 'tradeexpansion'),
  __('Acabamento superficial', 'tradeexpansion'),
  __('Dimensões e espessura', 'tradeexpansion'),
  __('Umidade / manchas', 'tradeexpansion'),
  __('Embalagem e amarração', 'tradeexpansion'),
];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo esc_html($report_title); ?> – <?php bloginfo('name'); ?></title>
  <style>
    @page {
      size: A4;
      margin: 20mm;
    }
    :root {
      --primary: #102724;
      --accent: #5D2713;
      --bg: #ffffff;
      --muted: rgba(16, 39, 36, 0.65);
    }
    body {
      font-family: 'Vollkorn', serif;
      margin: 0;
      background: #f5f5f0;
      color: var(--primary);
    }
    .pdf-wrap {
      max-width: 800px;
      margin: 0 auto;
      background: var(--bg);
      padding: 32px 40px 48px;
      box-shadow: 0 20px 60px rgba(16, 39, 36, 0.08);
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid rgba(16, 39, 36, 0.08);
      padding-bottom: 16px;
      margin-bottom: 28px;
    }
    header img {
      height: 48px;
    }
    header h1 {
      font-size: 1.4rem;
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    .meta {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 24px;
    }
    .meta span {
      display: block;
      font-size: 0.8rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .meta strong {
      font-size: 1rem;
    }
    section {
      margin-bottom: 28px;
    }
    section h2 {
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.3em;
      color: var(--accent);
      margin-bottom: 12px;
    }
    .grid-two {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 16px;
    }
    .grid-two label {
      display: block;
      font-size: 0.85rem;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .grid-two p,
    .grid-two div {
      font-size: 1rem;
      border: 1px solid rgba(16, 39, 36, 0.15);
      border-radius: 12px;
      padding: 10px 14px;
      min-height: 42px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.95rem;
    }
    table th,
    table td {
      border: 1px solid rgba(16, 39, 36, 0.2);
      padding: 10px;
      text-align: left;
    }
    table th {
      background: rgba(16, 39, 36, 0.05);
      text-transform: uppercase;
      letter-spacing: 0.2em;
      font-size: 0.75rem;
    }
    .note-block {
      border: 1px dashed rgba(16, 39, 36, 0.3);
      border-radius: 16px;
      padding: 18px;
      background: rgba(241, 241, 217, 0.5);
    }
    .status-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 999px;
      background: rgba(93, 39, 19, 0.1);
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.3em;
    }
    footer {
      margin-top: 32px;
      font-size: 0.8rem;
      color: var(--muted);
      text-align: center;
    }
    @media print {
      body {
        background: #fff;
      }
      .pdf-wrap {
        box-shadow: none;
        padding: 0;
      }
    }
  </style>
  <?php wp_head(); ?>
</head>
<body class="pdf-report">
  <div class="pdf-wrap">
    <header>
      <div>
        <h1><?php esc_html_e('Relatório de Inspeção', 'tradeexpansion'); ?></h1>
        <small><?php echo bloginfo('name'); ?></small>
      </div>
      <?php $logo = get_template_directory_uri() . '/assets/logo.png'; ?>
      <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">
    </header>

    <section class="meta">
      <div>
        <span><?php esc_html_e('Relatório', 'tradeexpansion'); ?></span>
        <strong><?php echo esc_html($report_title); ?></strong>
      </div>
      <div>
        <span><?php esc_html_e('Data', 'tradeexpansion'); ?></span>
        <strong><?php echo esc_html($report_date); ?></strong>
      </div>
      <div>
        <span><?php esc_html_e('Status', 'tradeexpansion'); ?></span>
        <strong class="status-chip"><?php echo esc_html($status_label); ?></strong>
      </div>
    </section>

    <section>
      <h2><?php esc_html_e('Dados gerais', 'tradeexpansion'); ?></h2>
      <div class="grid-two">
        <div>
          <label><?php esc_html_e('Empresa / Cliente', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($cliente_nome ?: __('Não informado', 'tradeexpansion')); ?></div>
        </div>
        <div>
          <label><?php esc_html_e('Responsável Trade Expansion', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($responsavel ?: '—'); ?></div>
        </div>
        <div>
          <label><?php esc_html_e('Local da inspeção', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($local_inspecao ?: '—'); ?></div>
        </div>
        <div>
          <label><?php esc_html_e('Material', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($material_nome ?: '—'); ?></div>
        </div>
        <div>
          <label><?php esc_html_e('Lote / Pedido', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($lote_codigo ?: '—'); ?></div>
        </div>
        <div>
          <label><?php esc_html_e('Data da inspeção', 'tradeexpansion'); ?></label>
          <div><?php echo esc_html($data_inspecao ?: '—'); ?></div>
        </div>
      </div>
    </section>

    <section>
      <h2><?php esc_html_e('Resumo da inspeção', 'tradeexpansion'); ?></h2>
      <div class="note-block">
        <?php echo wpautop($resumo ?: __('Resumo não informado.', 'tradeexpansion')); ?>
      </div>
    </section>

    <section>
      <h2><?php esc_html_e('Checklist técnico', 'tradeexpansion'); ?></h2>
      <table>
        <thead>
          <tr>
            <th><?php esc_html_e('Item avaliado', 'tradeexpansion'); ?></th>
            <th><?php esc_html_e('Condição', 'tradeexpansion'); ?></th>
            <th><?php esc_html_e('Observações', 'tradeexpansion'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($checklist_items as $item) : ?>
            <tr>
              <td><?php echo esc_html($item); ?></td>
              <td><?php echo esc_html__('—', 'tradeexpansion'); ?></td>
              <td><?php echo esc_html__('—', 'tradeexpansion'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section>
      <h2><?php esc_html_e('Observações detalhadas', 'tradeexpansion'); ?></h2>
      <div class="note-block">
        <?php echo $observacoes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>
    </section>

    <footer>
      <?php esc_html_e('Documento gerado automaticamente pelo Client Portal v1 – Trade Expansion.', 'tradeexpansion'); ?>
    </footer>
  </div>
  <?php wp_footer(); ?>
</body>
</html>
