<?php
if (!isset($inspections, $active_tab)) {
  return;
}

$materials_json = !empty($material_options) ? wp_json_encode($material_options) : '[]';
$materials_json = $materials_json ? esc_attr($materials_json) : '[]';
$empty_material_text = esc_attr__('Sem registros de imagens para este material.', 'tradeexpansion');
?>
<section
  data-tab-panel="inspections"
  class="space-y-5 <?php echo $active_tab === 'inspections' ? '' : 'hidden'; ?>"
  data-inspections-rest-url="<?php echo esc_attr($inspection_rest_url); ?>"
  data-inspections-rest-nonce="<?php echo esc_attr($inspection_rest_nonce); ?>"
  data-material-options="<?php echo $materials_json; ?>"
  data-inspections-empty="<?php echo $empty_material_text; ?>"
>
  <?php foreach ($inspections as $inspection) : ?>
    <article class="inspection-card" data-inspection-card="<?php echo (int) $inspection['id']; ?>">
      <div class="inspection-card__header">
        <div>
          <p class="inspection-card__eyebrow"><?php echo esc_html(__('Inspeção', 'tradeexpansion')); ?></p>
          <h3 class="inspection-card__title"><?php echo esc_html($inspection['title']); ?></h3>
          <?php if (!empty($inspection['date'])) : ?>
            <p class="inspection-card__date"><?php echo esc_html(date_i18n('d M Y', strtotime($inspection['date']))); ?></p>
          <?php endif; ?>
        </div>
        <?php if (!empty($can_manage_inspections) && !empty($inspection['id'])) : ?>
          <button type="button" class="inspection-add-photo" data-inspection-id="<?php echo (int) $inspection['id']; ?>">
            <?php esc_html_e('Adicionar fotos', 'tradeexpansion'); ?>
          </button>
        <?php endif; ?>
      </div>

      <div class="inspection-materials">
        <?php if (!empty($inspection['materials'])) : ?>
          <?php foreach ($inspection['materials'] as $material) : ?>
            <section class="inspection-material">
              <div class="inspection-material__header">
                <h4><?php echo esc_html($material['name']); ?></h4>
                <span class="inspection-material__count">
                  <?php
                  $count = isset($material['photos']) ? count($material['photos']) : 0;
                  printf(_n('%s foto', '%s fotos', $count, 'tradeexpansion'), number_format_i18n($count));
                  ?>
                </span>
              </div>
              <div class="inspection-material__grid">
                <?php if (!empty($material['photos'])) : ?>
                  <?php foreach ($material['photos'] as $photo) : ?>
                    <figure class="inspection-photo-card">
                      <img src="<?php echo esc_url($photo['image']); ?>" alt="<?php echo esc_attr($photo['material'] ?? ''); ?>" loading="lazy">
                      <?php if (!empty($photo['note'])) : ?>
                        <figcaption><?php echo esc_html($photo['note']); ?></figcaption>
                      <?php endif; ?>
                    </figure>
                  <?php endforeach; ?>
                <?php else : ?>
                  <p class="inspection-empty"><?php echo esc_html__('Sem imagens cadastradas.', 'tradeexpansion'); ?></p>
                <?php endif; ?>
              </div>
            </section>
          <?php endforeach; ?>
        <?php else : ?>
          <p class="inspection-empty"><?php echo esc_html__('Sem imagens cadastradas para esta inspeção.', 'tradeexpansion'); ?></p>
        <?php endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
  <p class="text-xs text-secondary/60 italic">
    <?php esc_html_e('fetchInspections() pronto para integrar upload interno/Google Drive. Novas fotos podem ser adicionadas diretamente acima.', 'tradeexpansion'); ?>
  </p>
</section>
