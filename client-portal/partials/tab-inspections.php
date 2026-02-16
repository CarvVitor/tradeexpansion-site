<?php
if (!isset($inspections, $active_tab)) {
  return;
}

$materials_json = !empty($material_options) ? wp_json_encode($material_options) : '[]';
$materials_json = $materials_json ? esc_attr($materials_json) : '[]';
$empty_material_text = esc_attr__('Sem registros de imagens para este material.', 'tradeexpansion');
?>
<section data-tab-panel="inspections" class="space-y-5 <?php echo $active_tab === 'inspections' ? '' : 'hidden'; ?>"
  data-inspections-rest-url="<?php echo esc_attr($inspection_rest_url); ?>"
  data-inspections-rest-nonce="<?php echo esc_attr($inspection_rest_nonce); ?>"
  data-material-options="<?php echo $materials_json; ?>" data-inspections-empty="<?php echo $empty_material_text; ?>">
  <div class="flex items-center justify-between border-b border-white/5 pb-6 mb-12">
    <div>
      <h2 class="text-3xl font-bold text-white"><?php esc_html_e('Inspeções Técnicas', 'tradeexpansion'); ?></h2>
      <p class="text-white/40 text-sm font-light italic mt-1">
        <?php esc_html_e('Visualize fotos e detalhes dos bundles inspecionados', 'tradeexpansion'); ?></p>
    </div>
    <?php if (!empty($can_manage_inspections)): ?>
      <button type="button" class="btn-minimalist">
        <?php esc_html_e('+ Nova Inspeção', 'tradeexpansion'); ?>
      </button>
    <?php endif; ?>
  </div>

  <?php if (!empty($inspections)): ?>
    <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($inspections as $inspection):
        $all_photos = [];
        if (!empty($inspection['materials'])) {
          foreach ($inspection['materials'] as $material) {
            if (!empty($material['photos'])) {
              foreach ($material['photos'] as $photo) {
                $photo['material_name'] = $material['name'];
                $all_photos[] = $photo;
              }
            }
          }
        }

        $bundle_number = isset($inspection['id']) ? str_pad($inspection['id'], 5, '0', STR_PAD_LEFT) : '00000';
        $total_photos = count($all_photos);
        $primeira_foto = !empty($all_photos) ? $all_photos[0] : null;
        ?>
        <article class="luxury-card overflow-hidden group">
          <!-- FOTO DO BUNDLE (DESTAQUE) -->
          <div class="relative h-72 bg-white/5 overflow-hidden">
            <?php if ($primeira_foto): ?>
              <img src="<?php echo esc_url($primeira_foto['image']); ?>" alt="Bundle #<?php echo esc_attr($bundle_number); ?>"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60"></div>

              <!-- Badge do Material -->
              <?php if (!empty($primeira_foto['material_name'])): ?>
                <span class="absolute top-6 left-6 label-secondary bg-gold/90 text-primary-dark px-3 py-1 shadow-2xl">
                  <?php echo esc_html($primeira_foto['material_name']); ?>
                </span>
              <?php endif; ?>

              <!-- Contador de fotos -->
              <?php if ($total_photos > 1): ?>
                <span
                  class="absolute bottom-6 right-6 label-secondary text-[10px] bg-black/40 backdrop-blur-md px-3 py-1 text-white/80">
                  <?php printf(_n('%s foto', '%s fotos', $total_photos, 'tradeexpansion'), number_format_i18n($total_photos)); ?>
                </span>
              <?php endif; ?>
            <?php else: ?>
              <div class="flex items-center justify-center h-full text-white/10">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            <?php endif; ?>
          </div>

          <!-- INFORMAÇÕES DO BUNDLE -->
          <div class="p-10">
            <div class="mb-4">
              <span class="label-secondary opacity-40"><?php esc_html_e('Bundle', 'tradeexpansion'); ?></span>
              <h3
                class="text-4xl font-bold text-white mt-2 tracking-tighter hover:text-gold transition-colors duration-500">
                #<?php echo esc_html($bundle_number); ?>
              </h3>
            </div>

            <h4 class="text-lg font-light text-white/60 mb-8 italic line-clamp-2">
              <?php echo esc_html($inspection['title']); ?>
            </h4>

            <div class="flex items-center justify-between border-t border-white/5 pt-8">
              <?php if (!empty($inspection['date'])): ?>
                <span class="label-secondary opacity-30 text-[10px]">
                  <?php echo esc_html(date_i18n('d M Y', strtotime($inspection['date']))); ?>
                </span>
              <?php endif; ?>

              <div class="flex gap-4">
                <button type="button" onclick="viewInspectionDetails(<?php echo (int) $inspection['id']; ?>)"
                  class="btn-minimalist text-xs py-2 px-4">
                  <?php esc_html_e('Detalles', 'tradeexpansion'); ?>
                </button>
                <?php if (!empty($can_manage_inspections) && !empty($inspection['id'])): ?>
                  <button type="button" class="btn-minimalist text-xs py-2 px-3 inspection-add-photo"
                    data-inspection-id="<?php echo (int) $inspection['id']; ?>">
                    +
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <!-- Modal/Expandir para ver todas as fotos (opcional - implementar depois) -->
    <script>
      function viewInspectionDetails(inspectionId) {
        // Aqui você pode implementar um modal ou redirecionar para página de detalhes
        console.log('Ver inspeção:', inspectionId);
        // Exemplo: window.location.href = '/inspecao/' + inspectionId;
      }
    </script>

  <?php else: ?>
    <!-- Mensagem quando não há inspeções -->
    <div class="text-center py-16 bg-white rounded-lg shadow">
      <svg class="w-20 h-20 mx-auto mb-4 text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3 class="text-xl font-semibold text-secondary mb-2">
        <?php esc_html_e('Nenhuma inspeção encontrada', 'tradeexpansion'); ?>
      </h3>
      <p class="text-secondary/60">
        <?php esc_html_e('As inspeções realizadas aparecerão aqui.', 'tradeexpansion'); ?>
      </p>
    </div>
  <?php endif; ?>

  <p class="text-xs text-secondary/50 italic mt-6 text-center">
    <?php esc_html_e('Sistema de inspeções integrado. Novas fotos podem ser adicionadas através do botão (+) em cada bundle.', 'tradeexpansion'); ?>
  </p>
</section>