<?php
if (!defined('ABSPATH')) exit;

$can = is_user_logged_in() && current_user_can('edit_posts');
if (!$can) {
  echo '<div class="te-alert bg-yellow-50 border border-yellow-200 text-yellow-900 p-3 rounded">Acesso restrito. Faça login como administrador ou editor.</div>';
  return;
}

$clientes = function_exists('tec_get_client_users') ? tec_get_client_users() : [];
?>
<form method="post" enctype="multipart/form-data" class="te-relatorio-form">
  <?php wp_nonce_field('te_relatorio_form','te_relatorio_nonce'); ?>

  <div>
    <label for="te_title" class="block font-medium mb-1">Título do relatório</label>
    <input type="text" id="te_title" name="te_title" required class="w-full border rounded px-3 py-2" placeholder="Ex.: Relatório de Inspeção – Lote 23">
  </div>

  <div>
    <label for="te_resumo" class="block font-medium mb-1">Resumo</label>
    <textarea id="te_resumo" name="te_resumo" rows="3" class="w-full border rounded px-3 py-2" placeholder="Resumo curto do relatório (2–3 linhas)..."></textarea>
  </div>

  <div>
    <label for="tec_cliente_id" class="block font-medium mb-1">Cliente</label>
    <select id="tec_cliente_id" name="tec_cliente_id" required class="w-full border rounded px-3 py-2">
      <option value="">— selecione —</option>
      <?php foreach ($clientes as $u): ?>
        <option value="<?php echo (int)$u->ID; ?>"><?php echo esc_html($u->display_name); ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label for="tec_status" class="block font-medium mb-1">Status</label>
    <select id="tec_status" name="tec_status" class="w-full border rounded px-3 py-2">
      <option value="aprovado">Aprovado</option>
      <option value="pendente" selected>Pendente</option>
      <option value="reprovado">Reprovado</option>
    </select>
  </div>

  <!-- ==== BUNDLES (repetidor) ==== -->
  <div class="te-bundles" id="teBundles">
    <h3 class="text-lg font-semibold mb-2">Bundles / Chapas</h3>

    <div class="te-bundle" data-index="0">
      <h4>Item #1</h4>
      <div class="grid">
        <div>
          <label>Ident.</label>
          <input type="text" name="bundles[0][ident]" class="w-full border rounded px-2 py-1" placeholder="029">
        </div>
        <div class="col-span-2">
          <label>Descrição/Material</label>
          <input type="text" name="bundles[0][descricao]" class="w-full border rounded px-2 py-1" placeholder="SANTA CECILIA">
        </div>
        <div>
          <label>Acabamento</label>
          <input type="text" name="bundles[0][acabamento]" class="w-full border rounded px-2 py-1" placeholder="PULIDO">
        </div>
        <div>
          <label>Quant.</label>
          <input type="number" step="1" min="1" name="bundles[0][quant]" class="w-full border rounded px-2 py-1" placeholder="2">
        </div>
        <div>
          <label>Obs.</label>
          <input type="text" name="bundles[0][obs]" class="w-full border rounded px-2 py-1" placeholder="Observação opcional">
        </div>

        <div>
          <label>Comp. (m)</label>
          <input type="number" step="0.01" min="0" name="bundles[0][comp]" class="w-full border rounded px-2 py-1" placeholder="2,93">
        </div>
        <div>
          <label>Altura (m)</label>
          <input type="number" step="0.01" min="0" name="bundles[0][altura]" class="w-full border rounded px-2 py-1" placeholder="1,93">
        </div>
        <div>
          <label>Espess. (cm)</label>
          <input type="number" step="0.1" min="0" name="bundles[0][esp]" class="w-full border rounded px-2 py-1" placeholder="2.0">
        </div>
        <div class="col-span-2">
          <label>Foto do bundle</label>
          <input type="file" name="bundle_photo[]" accept="image/*" class="w-full">
        </div>
      </div>
      <div class="mt-2">
        <button type="button" class="btn btn-remove te-remove-bundle">Remover item</button>
      </div>
    </div>
  </div>

  <div class="te-actions space-x-2">
    <button type="button" id="btnAddBundle" class="btn">+ Adicionar bundle</button>
    <button type="submit" class="btn btn-primary">Criar relatório</button>
  </div>
</form>

<template id="tplBundle">
  <div class="te-bundle" data-index="{i}">
    <h4>Item #{n}</h4>
    <div class="grid">
      <div><label>Ident.</label><input type="text" name="bundles[{i}][ident]" class="w-full border rounded px-2 py-1" placeholder="030"></div>
      <div class="col-span-2"><label>Descrição/Material</label><input type="text" name="bundles[{i}][descricao]" class="w-full border rounded px-2 py-1" placeholder="SANTA CECILIA"></div>
      <div><label>Acabamento</label><input type="text" name="bundles[{i}][acabamento]" class="w-full border rounded px-2 py-1" placeholder="PULIDO"></div>
      <div><label>Quant.</label><input type="number" step="1" min="1" name="bundles[{i}][quant]" class="w-full border rounded px-2 py-1" value="2"></div>
      <div><label>Obs.</label><input type="text" name="bundles[{i}][obs]" class="w-full border rounded px-2 py-1" placeholder="Observação opcional"></div>
      <div><label>Comp. (m)</label><input type="number" step="0.01" min="0" name="bundles[{i}][comp]" class="w-full border rounded px-2 py-1" placeholder="2,93"></div>
      <div><label>Altura (m)</label><input type="number" step="0.01" min="0" name="bundles[{i}][altura]" class="w-full border rounded px-2 py-1" placeholder="1,93"></div>
      <div><label>Espess. (cm)</label><input type="number" step="0.1" min="0" name="bundles[{i}][esp]" class="w-full border rounded px-2 py-1" placeholder="2.0"></div>
      <div class="col-span-2"><label>Foto do bundle</label><input type="file" name="bundle_photo[]" accept="image/*" class="w-full"></div>
    </div>
    <div class="mt-2"><button type="button" class="btn btn-remove te-remove-bundle">Remover item</button></div>
  </div>
</template>

<script>
(function(){
  const root = document.getElementById('teBundles');
  const btnAdd = document.getElementById('btnAddBundle');
  const tpl = document.getElementById('tplBundle').innerHTML;

  function renumber(){
    [...root.querySelectorAll('.te-bundle')].forEach((el,idx)=>{
      el.dataset.index = idx;
      el.querySelector('h4').textContent = `Item #${idx+1}`;
    });
  }

  root.addEventListener('click', (e)=>{
    if(e.target && e.target.classList.contains('te-remove-bundle')){
      const box = e.target.closest('.te-bundle');
      if(root.querySelectorAll('.te-bundle').length > 1){
        box.remove();
        renumber();
      }
    }
  });

  btnAdd.addEventListener('click', ()=>{
    const i = root.querySelectorAll('.te-bundle').length;
    const html = tpl.replaceAll('{i}', i).replaceAll('{n}', i+1);
    const div = document.createElement('div');
    div.innerHTML = html;
    root.appendChild(div.firstElementChild);
    renumber();
  });
})();
</script>
