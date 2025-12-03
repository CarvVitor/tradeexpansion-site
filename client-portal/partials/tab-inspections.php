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
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-2xl font-bold text-primary"><?php esc_html_e('Inspeções Técnicas', 'tradeexpansion'); ?></h2>
      <p class="text-sm text-secondary/70 mt-1"><?php esc_html_e('Visualize fotos e detalhes dos bundles inspecionados', 'tradeexpansion'); ?></p>
    </div>
    <?php if (!empty($can_manage_inspections)) : ?>
      <button type="button" class="bg-realce text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm font-medium">
        <?php esc_html_e('+ Nova Inspeção', 'tradeexpansion'); ?>
      </button>
    <?php endif; ?>
  </div>

  <?php if (!empty($inspections)) : ?>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($inspections as $inspection) : 
        // Coleta todas as fotos de todos os materiais
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
        
        // Pega o número do bundle (ID da inspeção formatado)
        $bundle_number = isset($inspection['id']) ? str_pad($inspection['id'], 5, '0', STR_PAD_LEFT) : '00000';
        $total_photos = count($all_photos);
        $primeira_foto = !empty($all_photos) ? $all_photos[0] : null;
      ?>
        <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
          <!-- FOTO DO BUNDLE (DESTAQUE) -->
          <div class="relative h-56 bg-gradient-to-br from-secondary to-primary flex items-center justify-center overflow-hidden group">
            <?php if ($primeira_foto) : ?>
              <img 
                src="<?php echo esc_url($primeira_foto['image']); ?>" 
                alt="Bundle #<?php echo esc_attr($bundle_number); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
              <!-- Badge do Material -->
              <?php if (!empty($primeira_foto['material_name'])) : ?>
                <span class="absolute top-3 right-3 bg-realce text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                  <?php echo esc_html($primeira_foto['material_name']); ?>
                </span>
              <?php endif; ?>
              <!-- Contador de fotos -->
              <?php if ($total_photos > 1) : ?>
                <span class="absolute bottom-3 right-3 bg-black/70 text-white px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm">
                  <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <?php printf(_n('%s foto', '%s fotos', $total_photos, 'tradeexpansion'), number_format_i18n($total_photos)); ?>
                </span>
              <?php endif; ?>
            <?php else : ?>
              <!-- Sem fotos - ícone placeholder -->
              <div class="text-center text-white/60">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm font-medium"><?php esc_html_e('Sem fotos', 'tradeexpansion'); ?></p>
              </div>
            <?php endif; ?>
          </div>

          <!-- INFORMAÇÕES DO BUNDLE -->
          <div class="p-5">
            <!-- Número do Bundle -->
            <div class="mb-3">
              <span class="text-xs text-secondary/60 uppercase tracking-wider font-medium">
                <?php esc_html_e('Bundle', 'tradeexpansion'); ?>
              </span>
              <h3 class="text-2xl font-bold text-primary mt-1">
                #<?php echo esc_html($bundle_number); ?>
              </h3>
            </div>

            <!-- Título da Inspeção -->
            <h4 class="text-base font-semibold text-secondary mb-2 line-clamp-2">
              <?php echo esc_html($inspection['title']); ?>
            </h4>

            <!-- Data -->
            <?php if (!empty($inspection['date'])) : ?>
              <p class="text-xs text-secondary/60 mb-4 flex items-center">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?php echo esc_html(date_i18n('d/m/Y', strtotime($inspection['date']))); ?>
              </p>
            <?php endif; ?>

            <!-- Botões de ação -->
            <div class="flex gap-2">
              <button 
                type="button"
                onclick="viewInspectionDetails(<?php echo (int) $inspection['id']; ?>)"
                class="flex-1 bg-primary text-white py-2.5 px-4 rounded-lg hover:bg-primary/90 transition text-sm font-medium"
              >
                <?php esc_html_e('Ver Detalhes', 'tradeexpansion'); ?>
              </button>
              <?php if (!empty($can_manage_inspections) && !empty($inspection['id'])) : ?>
                <button 
                  type="button" 
                  class="inspection-add-photo bg-secondary/10 text-secondary py-2.5 px-4 rounded-lg hover:bg-secondary/20 transition text-sm font-medium" 
                  data-inspection-id="<?php echo (int) $inspection['id']; ?>"
                  title="<?php esc_attr_e('Adicionar fotos', 'tradeexpansion'); ?>"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </button>
              <?php endif; ?>
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

  <?php else : ?>
    <!-- Mensagem quando não há inspeções -->
    <div class="text-center py-16 bg-white rounded-lg shadow">
      <svg class="w-20 h-20 mx-auto mb-4 text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
