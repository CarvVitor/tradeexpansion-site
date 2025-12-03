<?php
/*
Template Name: Catálogo de Rochas
Description: Galeria de produtos com filtros e modal de detalhes
*/
get_header();

// Array de produtos (futuramente pode vir de CPT ou ACF)
$produtos = [
  [
    'id' => 'granito-branco-ceara',
    'nome' => __('Granito Branco Ceará', 'tradeexpansion'),
    'nome_geologico' => 'Granito',
    'tipo' => 'granito',
    'cor' => 'claro',
    'origem' => __('Ceará, Brasil', 'tradeexpansion'),
    'imagem_principal' => get_template_directory_uri() . '/assets/images/catalog/granito-branco-ceara-1.jpg',
    'imagens_adicionais' => [
      get_template_directory_uri() . '/assets/images/catalog/granito-branco-ceara-2.jpg',
      get_template_directory_uri() . '/assets/images/catalog/granito-branco-ceara-3.jpg',
    ],
    'caracteristicas' => [
      'absorcao' => '0.4%',
      'densidade' => '2.630 kg/m³',
      'resistencia' => __('Alta', 'tradeexpansion'),
    ],
    'acabamentos' => __('Polido, Flameado, Levigado', 'tradeexpansion'),
    'aplicacoes' => __('Pisos, Revestimentos, Bancadas', 'tradeexpansion'),
    'descricao' => __('Granito de tonalidade clara com leve movimentação, ideal para ambientes modernos e sofisticados.', 'tradeexpansion'),
  ],
  [
    'id' => 'quartzito-azul-bahia',
    'nome' => __('Quartzito Azul Bahia', 'tradeexpansion'),
    'nome_geologico' => 'Quartzito',
    'tipo' => 'quartzito',
    'cor' => 'colorido',
    'origem' => __('Bahia, Brasil', 'tradeexpansion'),
    'imagem_principal' => get_template_directory_uri() . '/assets/images/catalog/quartzito-azul-bahia-1.jpg',
    'imagens_adicionais' => [
      get_template_directory_uri() . '/assets/images/catalog/quartzito-azul-bahia-2.jpg',
      get_template_directory_uri() . '/assets/images/catalog/quartzito-azul-bahia-3.jpg',
    ],
    'caracteristicas' => [
      'absorcao' => '0.2%',
      'densidade' => '2.650 kg/m³',
      'resistencia' => __('Muito Alta', 'tradeexpansion'),
    ],
    'acabamentos' => __('Polido, Escovado', 'tradeexpansion'),
    'aplicacoes' => __('Revestimentos, Decoração', 'tradeexpansion'),
    'descricao' => __('Quartzito de rara beleza com tons azulados intensos, perfeito para projetos exclusivos e de alto padrão.', 'tradeexpansion'),
  ],
  [
    'id' => 'marmore-carrara',
    'nome' => __('Mármore Carrara Brasileiro', 'tradeexpansion'),
    'nome_geologico' => 'Mármore',
    'tipo' => 'marmore',
    'cor' => 'claro',
    'origem' => __('Espírito Santo, Brasil', 'tradeexpansion'),
    'imagem_principal' => get_template_directory_uri() . '/assets/images/catalog/marmore-carrara-1.jpg',
    'imagens_adicionais' => [
      get_template_directory_uri() . '/assets/images/catalog/marmore-carrara-2.jpg',
      get_template_directory_uri() . '/assets/images/catalog/marmore-carrara-3.jpg',
    ],
    'caracteristicas' => [
      'absorcao' => '0.3%',
      'densidade' => '2.710 kg/m³',
      'resistencia' => __('Média', 'tradeexpansion'),
    ],
    'acabamentos' => __('Polido, Levigado, Apicoado', 'tradeexpansion'),
    'aplicacoes' => __('Revestimentos Internos, Bancadas, Decoração', 'tradeexpansion'),
    'descricao' => __('Mármore branco com veios cinzas suaves, semelhante ao clássico Carrara italiano, com qualidade premium.', 'tradeexpansion'),
  ],
  [
    'id' => 'granito-preto-absoluto',
    'nome' => __('Granito Preto Absoluto', 'tradeexpansion'),
    'nome_geologico' => 'Granito',
    'tipo' => 'granito',
    'cor' => 'escuro',
    'origem' => __('Minas Gerais, Brasil', 'tradeexpansion'),
    'imagem_principal' => get_template_directory_uri() . '/assets/images/catalog/granito-preto-absoluto-1.jpg',
    'imagens_adicionais' => [
      get_template_directory_uri() . '/assets/images/catalog/granito-preto-absoluto-2.jpg',
      get_template_directory_uri() . '/assets/images/catalog/granito-preto-absoluto-3.jpg',
    ],
    'caracteristicas' => [
      'absorcao' => '0.1%',
      'densidade' => '2.790 kg/m³',
      'resistencia' => __('Muito Alta', 'tradeexpansion'),
    ],
    'acabamentos' => __('Polido, Flameado, Jateado', 'tradeexpansion'),
    'aplicacoes' => __('Pisos, Revestimentos, Bancadas, Túmulos', 'tradeexpansion'),
    'descricao' => __('Granito preto puro sem movimentação, considerado um dos mais nobres do mundo para projetos de alto luxo.', 'tradeexpansion'),
  ],
];
?>

<!-- HERO SECTION com Slideshow -->
<section class="relative h-[70vh] flex items-center justify-center overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-primary via-secondary to-primary"></div>
  <div class="absolute inset-0 opacity-20">
    <div class="slideshow-container w-full h-full">
      <?php foreach (array_slice($produtos, 0, 4) as $index => $produto) : ?>
        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?> absolute inset-0 w-full h-full transition-opacity duration-1000">
          <img src="<?php echo esc_url($produto['imagem_principal']); ?>" alt="<?php echo esc_attr($produto['nome']); ?>" class="w-full h-full object-cover">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="relative z-10 text-center px-6 text-custom1">
    <h1 class="text-5xl md:text-6xl font-bold mb-4 tracking-wide uppercase">
      <?php _e('Catálogo Premium de Rochas Ornamentais', 'tradeexpansion'); ?>
    </h1>
    <p class="text-lg md:text-xl max-w-3xl mx-auto mb-8">
      <?php _e('Excelência brasileira em granitos, mármores, quartzitos e quartzos para projetos internacionais', 'tradeexpansion'); ?>
    </p>
  </div>
</section>

<!-- FILTROS -->
<section class="bg-custom1 py-8 px-6 md:px-20 sticky top-0 z-30 shadow-md">
  <div class="max-w-6xl mx-auto">
    <div class="flex flex-wrap gap-3 items-center justify-center">
      <span class="text-sm font-semibold text-secondary uppercase tracking-wide"><?php _e('Filtrar por:', 'tradeexpansion'); ?></span>
      
      <button class="filter-btn active" data-filter="all">
        <?php _e('Todos', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="granito">
        <?php _e('Granitos', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="marmore">
        <?php _e('Mármores', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="quartzito">
        <?php _e('Quartzitos', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="claro">
        <?php _e('Cores Claras', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="escuro">
        <?php _e('Cores Escuras', 'tradeexpansion'); ?>
      </button>
      <button class="filter-btn" data-filter="colorido">
        <?php _e('Coloridos', 'tradeexpansion'); ?>
      </button>
    </div>
  </div>
</section>

<!-- GALERIA DE PRODUTOS -->
<section class="bg-primary py-20 px-6 md:px-20">
  <div class="max-w-7xl mx-auto">
    <div id="products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($produtos as $produto) : ?>
        <article class="product-card group cursor-pointer" 
                 data-tipo="<?php echo esc_attr($produto['tipo']); ?>" 
                 data-cor="<?php echo esc_attr($produto['cor']); ?>"
                 data-product-id="<?php echo esc_attr($produto['id']); ?>">
          <div class="relative overflow-hidden rounded-2xl shadow-lg bg-secondary">
            <img src="<?php echo esc_url($produto['imagem_principal']); ?>" 
                 alt="<?php echo esc_attr($produto['nome']); ?>" 
                 class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-6">
              <div class="text-custom1">
                <h3 class="text-2xl font-bold mb-1"><?php echo esc_html($produto['nome']); ?></h3>
                <p class="text-sm text-custom1/80"><?php echo esc_html($produto['origem']); ?></p>
              </div>
              <button class="open-modal bg-accent text-custom1 px-4 py-2 rounded-lg hover:bg-custom1 hover:text-accent transition-colors font-semibold">
                <?php _e('Ver Detalhes', 'tradeexpansion'); ?>
              </button>
            </div>
          </div>
          <div class="mt-4 text-center">
            <h3 class="text-xl font-bold text-custom1"><?php echo esc_html($produto['nome']); ?></h3>
            <p class="text-sm text-custom1/70"><?php echo esc_html($produto['origem']); ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- MODAL DE DETALHES -->
<div id="product-modal" class="fixed inset-0 bg-secondary/95 z-50 hidden items-center justify-center p-6">
  <div class="bg-custom1 rounded-3xl max-w-5xl w-full max-h-[90vh] overflow-y-auto relative">
    <button id="close-modal" class="absolute top-6 right-6 text-secondary hover:text-accent transition z-10">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <div id="modal-content" class="p-8">
      <!-- Conteúdo será inserido via JavaScript -->
    </div>
  </div>
</div>

<!-- CTA FINAL -->
<section class="bg-custom1 text-secondary py-20 px-6 md:px-20 text-center">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold mb-6 uppercase tracking-wide">
      <?php _e('Não encontrou o que procura?', 'tradeexpansion'); ?>
    </h2>
    <p class="text-lg leading-relaxed mb-8">
      <?php _e('Este catálogo representa apenas uma amostra do nosso portfólio completo. Trabalhamos com centenas de materiais adicionais e oferecemos soluções personalizadas para cada projeto.', 'tradeexpansion'); ?>
    </p>
    <div class="flex flex-col md:flex-row gap-4 justify-center">
      <a href="<?php echo get_template_directory_uri(); ?>/assets/docs/catalogo-rochas.pdf" 
         download 
         class="bg-secondary text-custom1 px-8 py-4 rounded-xl font-semibold hover:bg-secondary/90 transition inline-flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <?php _e('Baixar Catálogo Completo (PDF)', 'tradeexpansion'); ?>
      </a>
      <a href="#contato" 
         class="bg-accent text-custom1 px-8 py-4 rounded-xl font-semibold hover:bg-accent/90 transition inline-flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <?php _e('Fale com Nossa Equipe', 'tradeexpansion'); ?>
      </a>
    </div>
  </div>
</section>

<style>
  .filter-btn {
    padding: 0.5rem 1.25rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 2px solid rgba(16, 39, 36, 0.2);
    color: rgba(16, 39, 36, 0.7);
    background-color: white;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .filter-btn:hover {
    border-color: #102724;
    color: #102724;
  }
  .filter-btn.active {
    background-color: #102724;
    color: #F1F1D9;
    border-color: #102724;
  }
  .product-card {
    animation: fadeIn 0.5s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .slide {
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }
  .slide.active {
    opacity: 1;
  }
</style>

<script>
  // Sistema de Filtros
  const filterBtns = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.getAttribute('data-filter');
      
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      productCards.forEach(card => {
        if (filter === 'all') {
          card.style.display = 'block';
        } else {
          const tipo = card.getAttribute('data-tipo');
          const cor = card.getAttribute('data-cor');
          
          if (tipo === filter || cor === filter) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        }
      });
    });
  });

  // Sistema de Modal
  const produtos = <?php echo json_encode($produtos); ?>;
  const modal = document.getElementById('product-modal');
  const modalContent = document.getElementById('modal-content');
  const closeModalBtn = document.getElementById('close-modal');

  document.querySelectorAll('.open-modal').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const card = e.target.closest('.product-card');
      const productId = card.getAttribute('data-product-id');
      const produto = produtos.find(p => p.id === productId);
      
      if (produto) {
        showModal(produto);
      }
    });
  });

  function showModal(produto) {
    const imagens = [produto.imagem_principal, ...produto.imagens_adicionais];
    
    modalContent.innerHTML = `
      <div class="grid md:grid-cols-2 gap-8">
        <div>
          <div class="mb-4">
            <img id="main-modal-image" src="${produto.imagem_principal}" alt="${produto.nome}" class="w-full h-96 object-cover rounded-2xl shadow-lg">
          </div>
          <div class="grid grid-cols-3 gap-2">
            ${imagens.map(img => `
              <img src="${img}" alt="${produto.nome}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-75 transition modal-thumb">
            `).join('')}
          </div>
        </div>
        <div class="space-y-6">
          <div>
            <p class="text-xs uppercase tracking-[0.3em] text-accent mb-1">${produto.nome_geologico}</p>
            <h2 class="text-4xl font-bold text-secondary mb-2">${produto.nome}</h2>
            <p class="text-secondary/70">${produto.origem}</p>
          </div>
          <p class="text-secondary/90 leading-relaxed">${produto.descricao}</p>
          
          <div class="border-t border-secondary/10 pt-6 space-y-4">
            <div>
              <h3 class="font-semibold text-secondary mb-2"><?php _e('Características Técnicas:', 'tradeexpansion'); ?></h3>
              <ul class="space-y-1 text-sm text-secondary/80">
                <li><strong><?php _e('Absorção de água:', 'tradeexpansion'); ?></strong> ${produto.caracteristicas.absorcao}</li>
                <li><strong><?php _e('Densidade:', 'tradeexpansion'); ?></strong> ${produto.caracteristicas.densidade}</li>
                <li><strong><?php _e('Resistência:', 'tradeexpansion'); ?></strong> ${produto.caracteristicas.resistencia}</li>
              </ul>
            </div>
            
            <div>
              <h3 class="font-semibold text-secondary mb-2"><?php _e('Acabamentos:', 'tradeexpansion'); ?></h3>
              <p class="text-sm text-secondary/80">${produto.acabamentos}</p>
            </div>
            
            <div>
              <h3 class="font-semibold text-secondary mb-2"><?php _e('Aplicações:', 'tradeexpansion'); ?></h3>
              <p class="text-sm text-secondary/80">${produto.aplicacoes}</p>
            </div>
          </div>

          <a href="#contato" class="inline-block bg-accent text-custom1 px-8 py-3 rounded-xl font-semibold hover:bg-accent/90 transition">
            <?php _e('Solicitar Cotação', 'tradeexpansion'); ?>
          </a>
        </div>
      </div>
    `;

    // Adicionar evento de clique nas thumbnails
    document.querySelectorAll('.modal-thumb').forEach(thumb => {
      thumb.addEventListener('click', (e) => {
        document.getElementById('main-modal-image').src = e.target.src;
      });
    });

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  closeModalBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Slideshow do Hero
  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');
  
  function nextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
  }

  setInterval(nextSlide, 4000);
</script>

<?php get_footer(); ?>