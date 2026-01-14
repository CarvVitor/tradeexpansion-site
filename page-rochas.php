<?php
/**
 * Template Name: Rochas Ornamentais
 * Description: Página de catálogo de rochas ornamentais brasileiras
 */

get_header();
?>

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

/* HERO */
.rochas-hero {
  position: relative;
  height: 80vh;
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: linear-gradient(135deg, #F1F1D9 0%, #E5E5D5 100%);
}

.rochas-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=1920&q=80');
  background-size: cover;
  background-position: center;
  opacity: 0.4;
  z-index: 0;
}

.rochas-hero-content {
  position: relative;
  z-index: 1;
  text-align: center;
  padding: 0 2rem;
  max-width: 1000px;
}

.rochas-hero h1 {
  font-size: clamp(2.5rem, 6vw, 5rem);
  font-weight: 300;
  color: var(--primary);
  margin-bottom: 1rem;
  line-height: 1.2;
}

.rochas-hero p {
  font-size: clamp(1.1rem, 2vw, 1.5rem);
  color: rgba(72, 73, 66, 0.8);
  margin-bottom: 2rem;
  font-weight: 300;
}

.rochas-badge {
  display: inline-block;
  background: var(--accent);
  color: var(--cream);
  padding: 0.8rem 1.8rem;
  border-radius: 50px;
  font-size: 0.9rem;
  letter-spacing: 0.1em;
  margin-bottom: 1.5rem;
}

/* VALUE PROPOSITION */
.rochas-vantagem {
  background: linear-gradient(180deg, #ffffff 0%, #F5F5E8 100%);
  padding: 5rem 2rem;
}

.rochas-vantagem-grid {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 3rem;
  text-align: center;
}

.rochas-vantagem-card {
  padding: 2rem;
}

.rochas-vantagem-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.rochas-vantagem-card h3 {
  font-size: 1.5rem;
  color: var(--primary);
  margin-bottom: 1rem;
  font-weight: 400;
}

.rochas-vantagem-card p {
  font-size: 1rem;
  color: rgba(72, 73, 66, 0.75);
  line-height: 1.6;
}

/* CATÁLOGO */
.rochas-catalogo {
  background: linear-gradient(180deg, #E5E5D5 0%, #D8D8C8 100%);
  padding: 5rem 2rem;
}

.rochas-catalogo-header {
  max-width: 1400px;
  margin: 0 auto 3rem;
  text-align: center;
}

.rochas-catalogo-header h2 {
  font-size: clamp(2rem, 4vw, 3rem);
  color: var(--primary);
  margin-bottom: 1rem;
  font-weight: 300;
}

/* FILTROS */
.rochas-filtros {
  max-width: 1400px;
  margin: 0 auto 3rem;
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: center;
}

.rochas-filtro {
  padding: 0.8rem 1.5rem;
  border: 2px solid rgba(72, 73, 66, 0.2);
  background: white;
  border-radius: 50px;
  cursor: pointer;
  font-family: 'Volkhorn', serif;
  font-size: 0.95rem;
  transition: all 0.3s ease;
}

.rochas-filtro:hover,
.rochas-filtro.ativo {
  background: var(--accent);
  color: var(--cream);
  border-color: var(--accent);
}

/* GRID DE ROCHAS */
.rochas-grid {
  max-width: 1400px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 2rem;
}

.rocha-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
  cursor: pointer;
}

.rocha-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
}

.rocha-imagem {
  width: 100%;
  height: 250px;
  overflow: hidden;
  background: #f0f0f0;
  position: relative;
}

.rocha-imagem img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.rocha-card:hover .rocha-imagem img {
  transform: scale(1.08);
}

.rocha-info {
  padding: 1.5rem;
}

.rocha-tipo {
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--accent);
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.rocha-nome {
  font-size: 1.3rem;
  color: var(--primary);
  margin-bottom: 0.8rem;
  font-weight: 400;
}

.rocha-descricao {
  font-size: 0.95rem;
  color: rgba(72, 73, 66, 0.7);
  line-height: 1.5;
  margin-bottom: 1.5rem;
  min-height: 3em;
}

.rocha-cta {
  display: inline-block;
  padding: 0.8rem 1.5rem;
  background: var(--accent);
  color: var(--cream);
  text-decoration: none;
  border-radius: 50px;
  font-size: 0.9rem;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  transition: all 0.3s ease;
}

.rocha-cta:hover {
  background: var(--primary);
  transform: translateX(3px);
}

/* SEÇÃO INSPEÇÃO */
.rochas-inspecao {
  background: linear-gradient(135deg, #102724 0%, #0d1f1c 100%);
  padding: 5rem 2rem;
  color: var(--text);
}

.rochas-inspecao-content {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.rochas-inspecao-imagem {
  width: 100%;
  height: 400px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
}

.rochas-inspecao-imagem img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.rochas-inspecao-texto h2 {
  font-size: clamp(2rem, 4vw, 3rem);
  color: var(--cream);
  margin-bottom: 1.5rem;
  font-weight: 300;
}

.rochas-inspecao-texto p {
  font-size: 1.1rem;
  line-height: 1.8;
  margin-bottom: 1.5rem;
  opacity: 0.9;
}

.rochas-inspecao-lista {
  list-style: none;
  margin: 2rem 0;
}

.rochas-inspecao-lista li {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  font-size: 1rem;
}

.rochas-inspecao-lista span:first-child {
  color: var(--gold);
  font-weight: bold;
  flex-shrink: 0;
}

.rochas-inspecao-cta {
  display: inline-block;
  padding: 1rem 2rem;
  background: var(--accent);
  color: var(--cream);
  text-decoration: none;
  border-radius: 50px;
  font-size: 0.95rem;
  letter-spacing: 0.05em;
  margin-top: 1.5rem;
  transition: all 0.3s ease;
}

.rochas-inspecao-cta:hover {
  background: var(--cream);
  color: var(--accent);
  transform: translateY(-3px);
}

/* RESPONSIVE */
@media (max-width: 968px) {
  .rochas-grid {
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
  }

  .rochas-inspecao-content {
    grid-template-columns: 1fr;
    gap: 3rem;
  }

  .rochas-inspecao-imagem {
    height: 300px;
  }

  .rochas-filtros {
    justify-content: flex-start;
    overflow-x: auto;
    padding-bottom: 0.5rem;
  }
}

@media (max-width: 480px) {
  .rochas-hero h1 {
    font-size: 2rem;
  }

  .rochas-grid {
    grid-template-columns: 1fr;
  }

  .rochas-filtro {
    padding: 0.7rem 1.2rem;
    font-size: 0.85rem;
  }
}
</style>

<!-- HERO -->
<section class="rochas-hero">
  <div class="rochas-hero-content">
    <div class="rochas-badge">💎 <?php _e( 'Rochas Ornamentais Brasileiras', 'tradeexpansion' ); ?></div>
    <h1><?php _e( 'Onde a Natureza Encontra a Perfeição', 'tradeexpansion' ); ?></h1>
    <p><?php _e( 'Direto da pedreira para seu projeto. Todo pedido inclui inspeção de qualidade gratuita.', 'tradeexpansion' ); ?></p>
  </div>
</section>

<!-- VANTAGENS -->
<section class="rochas-vantagem">
  <div class="rochas-vantagem-grid">
    <div class="rochas-vantagem-card">
      <div class="rochas-vantagem-icon">🏔️</div>
      <h3><?php _e( 'Origem Direta', 'tradeexpansion' ); ?></h3>
      <p><?php _e( 'Fonte direta das pedreiras brasileiras sem intermediários.', 'tradeexpansion' ); ?></p>
    </div>
    <div class="rochas-vantagem-card">
      <div class="rochas-vantagem-icon">🔍</div>
      <h3><?php _e( 'Inspeção Gratuita', 'tradeexpansion' ); ?></h3>
      <p><?php _e( 'Valor de R$ 2.500 incluído em todo pedido. Qualidade garantida.', 'tradeexpansion' ); ?></p>
    </div>
    <div class="rochas-vantagem-card">
      <div class="rochas-vantagem-icon">🌍</div>
      <h3><?php _e( 'Logística Global', 'tradeexpansion' ); ?></h3>
      <p><?php _e( 'De 1 chapa até container cheio. Sem pedido mínimo.', 'tradeexpansion' ); ?></p>
    </div>
  </div>
</section>

<!-- CATÁLOGO -->
<section class="rochas-catalogo">
  <div class="rochas-catalogo-header">
    <h2><?php _e( 'Explore Nossa Coleção', 'tradeexpansion' ); ?></h2>
    <p><?php _e( '100+ materiais disponíveis. Granitos, quartzitos e mármores premium.', 'tradeexpansion' ); ?></p>
  </div>

  <!-- FILTROS -->
  <div class="rochas-filtros">
    <button class="rochas-filtro ativo" data-filter="*"><?php _e( 'Todas', 'tradeexpansion' ); ?></button>
    <button class="rochas-filtro" data-filter="granito"><?php _e( 'Granitos', 'tradeexpansion' ); ?></button>
    <button class="rochas-filtro" data-filter="quartzito"><?php _e( 'Quartzitos', 'tradeexpansion' ); ?></button>
    <button class="rochas-filtro" data-filter="marmore"><?php _e( 'Mármores', 'tradeexpansion' ); ?></button>
  </div>

  <!-- GRID DE ROCHAS -->
  <div class="rochas-grid">
    <?php
    $args = array(
      'post_type'      => 'rocha',
      'posts_per_page' => -1,
      'orderby'        => 'meta_value_num',
      'meta_key'       => '_rocha_ordem',
      'order'          => 'ASC',
      'meta_query'     => array(
        array(
          'key'    => '_rocha_ordem',
          'value'  => 0,
          'compare' => '!=',
          'type'   => 'NUMERIC'
        )
      )
    );

    $rochas = new WP_Query( $args );

    if ( $rochas->have_posts() ) {
      while ( $rochas->have_posts() ) {
        $rochas->the_post();
        $tipo = get_the_terms( get_the_ID(), 'rocha_tipo' );
        $tipo_slug = $tipo ? strtolower( str_replace( ' ', '', $tipo[0]->name ) ) : '';
        ?>
        <div class="rocha-card" data-tipo="<?php echo esc_attr( $tipo_slug ); ?>">
          <div class="rocha-imagem">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
            <?php else : ?>
              <img src="https://via.placeholder.com/400x300?text=<?php echo urlencode( get_the_title() ); ?>" alt="<?php the_title_attribute(); ?>" />
            <?php endif; ?>
          </div>
          <div class="rocha-info">
            <?php if ( $tipo ) : ?>
              <div class="rocha-tipo"><?php echo esc_html( $tipo[0]->name ); ?></div>
            <?php endif; ?>
            <div class="rocha-nome"><?php the_title(); ?></div>
            <div class="rocha-descricao"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></div>
            <a href="#contato" class="rocha-cta"><?php _e( 'Solicitar Cotação', 'tradeexpansion' ); ?></a>
          </div>
        </div>
        <?php
      }
      wp_reset_postdata();
    } else {
      echo '<p>' . __( 'Nenhuma rocha encontrada. Adicione rochas no painel administrativo.', 'tradeexpansion' ) . '</p>';
    }
    ?>
  </div>
</section>

<!-- SEÇÃO INSPEÇÃO -->
<section class="rochas-inspecao">
  <div class="rochas-inspecao-content">
    <div class="rochas-inspecao-imagem">
      <img src="https://images.unsplash.com/photo-1615874959474-d609969a20ed?w=800&q=80" alt="<?php _e( 'Inspeção de Rochas', 'tradeexpansion' ); ?>" />
    </div>
    <div class="rochas-inspecao-texto">
      <h2><?php _e( 'Inspeção de Qualidade Incluída', 'tradeexpansion' ); ?></h2>
      <p><?php _e( 'Cada compra inclui inspeção profissional de qualidade. Isso significa que suas rochas são verificadas antes do envio.', 'tradeexpansion' ); ?></p>
      
      <ul class="rochas-inspecao-lista">
        <li><span>✓</span> <span><?php _e( 'Detecção de microfissuras invisíveis', 'tradeexpansion' ); ?></span></li>
        <li><span>✓</span> <span><?php _e( 'Verificação de consistência de cor', 'tradeexpansion' ); ?></span></li>
        <li><span>✓</span> <span><?php _e( 'Dimensões precisas medidas', 'tradeexpansion' ); ?></span></li>
        <li><span>✓</span> <span><?php _e( 'Relatório detalhado incluído', 'tradeexpansion' ); ?></span></li>
      </ul>

      <a href="<?php echo home_url( '/inspecao' ); ?>" class="rochas-inspecao-cta"><?php _e( 'Saiba Mais Sobre Nossa Inspeção', 'tradeexpansion' ); ?> →</a>
    </div>
  </div>
</section>

<!-- ==================== FRONTEND FORM - SÓ PARA ADMINS ==================== -->

<?php
// Verifica se o usuário é ADMIN
if ( current_user_can( 'manage_options' ) ) {
    
    // Processa o formulário quando enviado
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['adicionar_rocha_nonce'] ) ) {
        
        if ( wp_verify_nonce( $_POST['adicionar_rocha_nonce'], 'adicionar_rocha_action' ) ) {
            
            $nome = sanitize_text_field( $_POST['nome_rocha'] );
            $sku = sanitize_text_field( $_POST['sku_rocha'] );
            $tipo = sanitize_text_field( $_POST['tipo_rocha'] );
            $cor = sanitize_text_field( $_POST['cor_rocha'] );
            $descricao = wp_kses_post( $_POST['descricao_rocha'] );
            
            $erro = false;
            $mensagem = '';
            
            if ( empty( $nome ) ) {
                $erro = true;
                $mensagem = __( '❌ Erro: Nome do material é obrigatório!', 'tradeexpansion' );
            } elseif ( ! preg_match( '/^[A-Z]{3}-[0-9]{3}$/', $sku ) ) {
                $erro = true;
                $mensagem = __( '❌ Erro: SKU deve ter o formato XXX-000 (3 letras, hífen, 3 números)', 'tradeexpansion' );
            } else {
                $sku_existe = get_posts( array(
                    'post_type'      => 'rocha',
                    'posts_per_page' => 1,
                    'meta_query'     => array(
                        array(
                            'key'   => '_rocha_sku',
                            'value' => $sku,
                        )
                    ),
                    'fields'         => 'ids'
                ));
            
                if ( ! empty( $sku_existe ) ) {
                    $erro = true;
                    $mensagem = sprintf( 
                        __( '❌ Erro: O SKU %s já existe! Use um número diferente.', 'tradeexpansion' ), 
                        '<strong>' . esc_html( $sku ) . '</strong>'
                    );
                }
            }
            
            if ( ! $erro && empty( $tipo ) ) {
                $erro = true;
                $mensagem = __( '❌ Erro: Selecione um tipo de rocha!', 'tradeexpansion' );
            }
            
            if ( ! $erro && empty( $cor ) ) {
                $erro = true;
                $mensagem = __( '❌ Erro: Selecione uma cor!', 'tradeexpansion' );
            }
            
            if ( ! $erro ) {
                $post_id = wp_insert_post( array(
                    'post_title'   => $nome,
                    'post_content' => $descricao,
                    'post_type'    => 'rocha',
                    'post_status'  => 'publish',
                ));
                
                if ( ! is_wp_error( $post_id ) ) {
                    update_post_meta( $post_id, '_rocha_sku', $sku );
                    wp_set_post_terms( $post_id, intval( $tipo ), 'rocha_tipo' );
                    wp_set_post_terms( $post_id, intval( $cor ), 'rocha_cor' );
                    
                    echo '<div style="background: #d4edda; border: 3px solid #28a745; color: #155724; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; text-align: center; font-size: 1.1rem; font-weight: 600;">
                        ✅ ' . sprintf( __( 'Rocha "%s" adicionada com sucesso!', 'tradeexpansion' ), esc_html( $nome ) ) . '<br>
                        <small style="color: #155724;">' . __( 'Atualizando página...', 'tradeexpansion' ) . '</small>
                    </div>';
                    
                    echo '<script>setTimeout(function() { location.reload(); }, 2000);</script>';
                    exit;
                }
            }
            
            if ( $erro ) {
                ?>
                <div style="background: #f8d7da; border: 3px solid #f5c6cb; color: #721c24; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; font-size: 1.05rem; font-weight: 600;">
                    <?php echo $mensagem; ?>
                </div>
                <?php
            }
        }
    }
    
    $tipos = get_terms( array( 'taxonomy' => 'rocha_tipo', 'hide_empty' => false ) );
    $cores = get_terms( array( 'taxonomy' => 'rocha_cor', 'hide_empty' => false ) );
    ?>
    
    <!-- FORMULÁRIO -->
    <section style="background: linear-gradient(180deg, #D8D8C8 0%, #C0C0B0 100%); padding: 5rem 2rem; margin-top: 3rem;">
        <div style="max-width: 800px; margin: 0 auto;">
            
            <h2 style="font-size: 2.5rem; font-weight: 300; color: var(--primary); margin-bottom: 1rem; text-align: center;">
                <?php _e( '➕ Adicionar Nova Rocha', 'tradeexpansion' ); ?>
            </h2>
            <p style="text-align: center; color: rgba(72, 73, 66, 0.7); margin-bottom: 2.5rem;">
                <?php _e( 'Preencha o formulário abaixo para cadastrar um novo material.', 'tradeexpansion' ); ?>
            </p>
            
            <form method="POST" style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);">
                
                <?php wp_nonce_field( 'adicionar_rocha_action', 'adicionar_rocha_nonce' ); ?>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--primary);">
                        <?php _e( 'Nome do Material', 'tradeexpansion' ); ?> *
                    </label>
                    <input 
                        type="text" 
                        name="nome_rocha" 
                        required 
                        placeholder="<?php _e( 'Ex: Emerald Green', 'tradeexpansion' ); ?>"
                        style="width: 100%; padding: 0.8rem; border: 2px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: 'Volkhorn', serif;"
                    />
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--primary);">
                        <?php _e( 'SKU (Código Único)', 'tradeexpansion' ); ?> *
                    </label>
                    <input 
                        type="text" 
                        name="sku_rocha" 
                        required 
                        placeholder="<?php _e( 'Ex: TUL-056', 'tradeexpansion' ); ?>"
                        maxlength="7"
                        pattern="[A-Z]{3}-[0-9]{3}"
                        style="width: 100%; padding: 0.8rem; border: 2px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: monospace;"
                    />
                    <small style="display: block; margin-top: 0.5rem; color: #666;">
                        📌 <?php _e( 'Formato: 3 LETRAS - 3 NÚMEROS (ex: TUL-056)', 'tradeexpansion' ); ?>
                    </small>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--primary);">
                        <?php _e( 'Tipo de Rocha', 'tradeexpansion' ); ?> *
                    </label>
                    <select 
                        name="tipo_rocha" 
                        required 
                        style="width: 100%; padding: 0.8rem; border: 2px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: 'Volkhorn', serif;"
                    >
                        <option value=""><?php _e( 'Selecione um tipo', 'tradeexpansion' ); ?></option>
                        <?php foreach ( $tipos as $tipo ) : ?>
                            <option value="<?php echo esc_attr( $tipo->term_id ); ?>">
                                <?php echo esc_html( $tipo->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--primary);">
                        <?php _e( 'Cor', 'tradeexpansion' ); ?> *
                    </label>
                    <select 
                        name="cor_rocha" 
                        required 
                        style="width: 100%; padding: 0.8rem; border: 2px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: 'Volkhorn', serif;"
                    >
                        <option value=""><?php _e( 'Selecione uma cor', 'tradeexpansion' ); ?></option>
                        <?php foreach ( $cores as $cor ) : ?>
                            <option value="<?php echo esc_attr( $cor->term_id ); ?>">
                                <?php echo esc_html( $cor->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--primary);">
                        <?php _e( 'Descrição', 'tradeexpansion' ); ?>
                    </label>
                    <textarea 
                        name="descricao_rocha" 
                        placeholder="<?php _e( 'Descreva o material...', 'tradeexpansion' ); ?>"
                        style="width: 100%; padding: 0.8rem; border: 2px solid #ccc; border-radius: 6px; font-size: 1rem; font-family: 'Volkhorn', serif; min-height: 120px;"
                    ></textarea>
                </div>
                
                <button 
                    type="submit" 
                    style="width: 100%; padding: 1.2rem; background: var(--accent); color: var(--cream); border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; font-family: 'Volkhorn', serif;"
                    onmouseover="this.style.background='var(--primary)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.2)';"
                    onmouseout="this.style.background='var(--accent)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                >
                    <?php _e( '✅ Adicionar Rocha', 'tradeexpansion' ); ?>
                </button>
                
            </form>
            
        </div>
    </section>
    
    <?php
} // Fim da verificação de admin
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var skuInput = document.querySelector('input[name="sku_rocha"]');
    var formulario = document.querySelector('form[method="POST"]');
    var botaoEnviar = formulario.querySelector('button[type="submit"]');
    
    if ( ! skuInput ) return;
    
    skuInput.addEventListener('input', function() {
        var sku = this.value.trim().toUpperCase();
        
        if ( ! sku ) {
            remover_aviso_sku();
            botaoEnviar.disabled = false;
            botaoEnviar.style.opacity = '1';
            botaoEnviar.style.cursor = 'pointer';
            return;
        }
        
        if ( ! /^[A-Z]{3}-[0-9]{3}$/.test(sku) ) {
            mostrar_aviso_sku('📌 Formato: 3 LETRAS - 3 NÚMEROS (ex: TUL-056)', 'aviso');
            botaoEnviar.disabled = false;
            return;
        }
        
        verificar_sku_existe(sku);
    });
    
    function verificar_sku_existe(sku) {
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=verificar_sku_rocha&sku=' + encodeURIComponent(sku)
        })
        .then(response => response.json())
        .then(data => {
            if (data.existe) {
                mostrar_aviso_sku('❌ Este SKU já existe! Digite outro número.', 'erro');
                botaoEnviar.disabled = true;
                botaoEnviar.style.opacity = '0.5';
                botaoEnviar.style.cursor = 'not-allowed';
            } else {
                mostrar_aviso_sku('✅ SKU disponível!', 'sucesso');
                botaoEnviar.disabled = false;
                botaoEnviar.style.opacity = '1';
                botaoEnviar.style.cursor = 'pointer';
            }
        });
    }
    
    function mostrar_aviso_sku(mensagem, tipo) {
        remover_aviso_sku();
        
        var aviso = document.createElement('div');
        aviso.id = 'aviso_sku';
        aviso.style.marginTop = '0.5rem';
        aviso.style.padding = '0.8rem';
        aviso.style.borderRadius = '6px';
        aviso.style.fontSize = '0.9rem';
        aviso.style.fontWeight = '600';
        
        if (tipo === 'erro') {
            aviso.style.background = '#f8d7da';
            aviso.style.color = '#721c24';
            aviso.style.border = '2px solid #f5c6cb';
        } else if (tipo === 'sucesso') {
            aviso.style.background = '#d4edda';
            aviso.style.color = '#155724';
            aviso.style.border = '2px solid #28a745';
        } else {
            aviso.style.background = '#fff3cd';
            aviso.style.color = '#856404';
            aviso.style.border = '2px solid #ffc107';
        }
        
        aviso.innerHTML = mensagem;
        skuInput.parentElement.appendChild(aviso);
    }
    
    function remover_aviso_sku() {
        var aviso = document.getElementById('aviso_sku');
        if (aviso) {
            aviso.remove();
        }
    }
});
</script>

<?php get_footer(); ?>