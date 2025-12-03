<?php
if (!defined('ABSPATH')) exit;

$can = is_user_logged_in() && current_user_can('edit_posts');
if (!$can) {
    echo '<div class="te-alert">Acesso restrito. Faça login como administrador ou editor.</div>';
    return;
}

$clientes = function_exists('tec_get_client_users') ? tec_get_client_users() : array();
?>

<div class="te-form-relatorio-container">
    <h1>Novo Relatório</h1>
    
    <form method="post" enctype="multipart/form-data" class="te-relatorio-form">
        <?php wp_nonce_field('te_relatorio_form', 'te_relatorio_nonce'); ?>
        
        <!-- Informações Básicas -->
        <div class="te-form-section">
            <h3>📋 Informações Básicas</h3>
            
            <div class="te-field">
                <label for="te_title">Título do Relatório</label>
                <input type="text" id="te_title" name="te_title" required 
                       placeholder="Ex: Relatório de Inspeção - Lote 23">
            </div>
            
            <div class="te-field">
                <label for="te_resumo">Resumo</label>
                <textarea id="te_resumo" name="te_resumo" rows="3" 
                          placeholder="Resumo curto do relatório (2-3 linhas)..."></textarea>
            </div>
            
            <div class="te-field-row">
                <div class="te-field">
                    <label for="tec_cliente_id">Cliente</label>
                    <select id="tec_cliente_id" name="tec_cliente_id" required>
                        <option value="">— Selecione o cliente —</option>
                        <?php foreach ($clientes as $u): ?>
                        <option value="<?php echo (int) $u->ID; ?>">
                            <?php echo esc_html($u->display_name); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="te-field">
                    <label for="tec_status">Status</label>
                    <select id="tec_status" name="tec_status">
                        <option value="aprovado">Aprovado</option>
                        <option value="pendente" selected>Pendente</option>
                        <option value="reprovado">Reprovado</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Cavaletes / Seções -->
        <div class="te-form-section">
            <h3>📦 Cavaletes / Materiais (máx. 9 por contêiner)</h3>
            <p class="te-help-text">Adicione até 9 cavaletes com chapas de rochas ornamentais</p>
            
            <div id="te-cavaletes-container">
                <!-- O primeiro cavalete já vem criado -->
                <div class="te-cavalete" data-index="0">
                    <div class="te-cavalete-header">
                        <h4>🗄️ Cavalete #1</h4>
                        <button type="button" class="te-btn-remove-cavalete" title="Remover este cavalete">
                            ✕
                        </button>
                    </div>
                    
                    <div class="te-cavalete-fields">
                        <div class="te-field">
                            <label>Ident. (Item #)</label>
                            <input type="text" name="cavaletes[0][ident]" placeholder="029" maxlength="10">
                        </div>
                        
                        <div class="te-field">
                            <label>Material / Descrição</label>
                            <input type="text" name="cavaletes[0][material]" placeholder="SANTA CECILIA">
                        </div>
                        
                        <div class="te-field">
                            <label>Acabamento</label>
                            <input type="text" name="cavaletes[0][acabamento]" placeholder="PULIDO">
                        </div>
                        
                        <div class="te-field-row">
                            <div class="te-field">
                                <label>Quantidade</label>
                                <input type="number" name="cavaletes[0][quantidade]" placeholder="2" min="1" step="1">
                            </div>
                            
                            <div class="te-field">
                                <label>Comp. (m)</label>
                                <input type="number" name="cavaletes[0][comp_m]" placeholder="2.93" step="0.01">
                            </div>
                            
                            <div class="te-field">
                                <label>Altura (m)</label>
                                <input type="number" name="cavaletes[0][altura_m]" placeholder="1.93" step="0.01">
                            </div>
                            
                            <div class="te-field">
                                <label>Espess. (cm)</label>
                                <input type="number" name="cavaletes[0][espess_cm]" placeholder="2.0" step="0.1">
                            </div>
                        </div>
                        
                        <div class="te-field">
                            <label>Observações</label>
                            <input type="text" name="cavaletes[0][obs]" placeholder="Observação opcional">
                        </div>
                        
                        <div class="te-field">
                            <label>📷 Fotos do Cavalete (1 a 3 fotos)</label>
                            <div class="te-photos-container">
                                <div class="te-photo-item">
                                    <input type="file" name="cavalete_photo_0[]" accept="image/*" required>
                                    <small style="color: #666;">Foto 1 (obrigatória)</small>
                                </div>
                                <div class="te-photo-item">
                                    <input type="file" name="cavalete_photo_0[]" accept="image/*">
                                    <small style="color: #666;">Foto 2 (opcional)</small>
                                </div>
                                <div class="te-photo-item">
                                    <input type="file" name="cavalete_photo_0[]" accept="image/*">
                                    <small style="color: #666;">Foto 3 (opcional)</small>
                                </div>
                            </div>
                        </div>
            
            <div class="te-actions-cavaletes">
                <button type="button" id="te-btn-add-cavalete" class="te-btn te-btn-secondary">
                    ➕ Adicionar Cavalete
                </button>
                <span class="te-cavalete-counter">1 / 9 cavaletes</span>
            </div>
        </div>
        
        <!-- Botões de Ação -->
        <div class="te-form-actions">
            <button type="submit" name="action" value="save_draft" class="te-btn te-btn-outline">
                💾 Salvar Rascunho
            </button>
            <button type="submit" name="action" value="finalize" class="te-btn te-btn-primary">
                ✅ Finalizar Relatório
            </button>
        </div>
    </form>
</div>

<script>
(function() {
    const container = document.getElementById('te-cavaletes-container');
    const btnAdd = document.getElementById('te-btn-add-cavalete');
    const counter = document.querySelector('.te-cavalete-counter');
    const MAX_CAVALETES = 9;
    
    function updateCounter() {
        const count = container.querySelectorAll('.te-cavalete').length;
        counter.textContent = `${count} / ${MAX_CAVALETES} cavaletes`;
        btnAdd.disabled = count >= MAX_CAVALETES;
    }
    
    function renumberCavaletes() {
        container.querySelectorAll('.te-cavalete').forEach((el, idx) => {
            el.dataset.index = idx;
            el.querySelector('h4').textContent = `🗄️ Cavalete #${idx + 1}`;
            
            // Atualiza os names dos inputs
            el.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('cavaletes[')) {
                    input.setAttribute('name', name.replace(/cavaletes\[\d+\]/, `cavaletes[${idx}]`));
                }
            });
        });
        updateCounter();
    }
    
    // Adicionar cavalete
    btnAdd.addEventListener('click', () => {
        const count = container.querySelectorAll('.te-cavalete').length;
        if (count >= MAX_CAVALETES) {
            alert(`Máximo de ${MAX_CAVALETES} cavaletes por contêiner!`);
            return;
        }
        
        const template = container.querySelector('.te-cavalete').cloneNode(true);
        
        // Limpa os valores
        template.querySelectorAll('input, select, textarea').forEach(input => {
            if (input.type === 'file') {
                input.value = '';
            } else {
                input.value = '';
            }
        });
        
        container.appendChild(template);
        renumberCavaletes();
        
        // Scroll para o novo cavalete
        template.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
    
    // Remover cavalete
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('te-btn-remove-cavalete')) {
            const count = container.querySelectorAll('.te-cavalete').length;
            if (count === 1) {
                alert('Você precisa de pelo menos 1 cavalete!');
                return;
            }
            
            if (confirm('Remover este cavalete?')) {
                e.target.closest('.te-cavalete').remove();
                renumberCavaletes();
            }
        }
    });
    
    updateCounter();
})();
</script>

<script>
(function() {
    const container = document.getElementById('te-cavaletes-container');
    const btnAdd = document.getElementById('te-btn-add-cavalete');
    const counter = document.querySelector('.te-cavalete-counter');
    const MAX_CAVALETES = 9;
    
    function updateCounter() {
        const count = container.querySelectorAll('.te-cavalete').length;
        counter.textContent = `${count} / ${MAX_CAVALETES} cavaletes`;
        btnAdd.disabled = count >= MAX_CAVALETES;
    }
    
    function renumberCavaletes() {
        container.querySelectorAll('.te-cavalete').forEach((el, idx) => {
            el.dataset.index = idx;
            el.querySelector('h4').textContent = `🗄️ Cavalete #${idx + 1}`;
            
            // Atualiza os names dos inputs
            el.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('cavaletes[')) {
                    input.setAttribute('name', name.replace(/cavaletes\[\d+\]/, `cavaletes[${idx}]`));
                }
                // Atualiza os names das fotos
                if (name && name.includes('cavalete_photo_')) {
                    input.setAttribute('name', `cavalete_photo_${idx}[]`);
                }
            });
        });
        updateCounter();
    }
    
    // Adicionar cavalete
    btnAdd.addEventListener('click', () => {
        const count = container.querySelectorAll('.te-cavalete').length;
        if (count >= MAX_CAVALETES) {
            alert(`Máximo de ${MAX_CAVALETES} cavaletes por contêiner!`);
            return;
        }
        
        const template = container.querySelector('.te-cavalete').cloneNode(true);
        
        // Limpa os valores
        template.querySelectorAll('input:not([type="file"]), select, textarea').forEach(input => {
            input.value = '';
        });
        
        // Limpa os file inputs
        template.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });
        
        container.appendChild(template);
        renumberCavaletes();
        
        // Scroll para o novo cavalete
        template.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
    
    // Remover cavalete
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('te-btn-remove-cavalete') || 
            e.target.parentElement.classList.contains('te-btn-remove-cavalete')) {
            const count = container.querySelectorAll('.te-cavalete').length;
            if (count === 1) {
                alert('Você precisa de pelo menos 1 cavalete!');
                return;
            }
            
            if (confirm('Remover este cavalete?')) {
                const btn = e.target.classList.contains('te-btn-remove-cavalete') ? 
                           e.target : e.target.parentElement;
                btn.closest('.te-cavalete').remove();
                renumberCavaletes();
            }
        }
    });
    
    updateCounter();
})();
</script>
