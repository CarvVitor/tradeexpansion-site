<?php
/**
 * Tab: Orders & Materials
 */
if (!isset($active_tab)) {
    return;
}

// Idioma baseado no cliente
$is_spanish_client = false; 
if (isset($current_user)) {
    $client_name = $current_user->display_name;
    if (stripos($client_name, 'Magma') !== false || stripos($client_name, 'Global Marmol') !== false) {
        $is_spanish_client = true;
    }
}

$labels = [
    'title' => $is_spanish_client ? 'Materiales y Pedidos' : 'Materiais e Pedidos',
    'subtitle' => $is_spanish_client ? 'Solicite nuevos materiales o siga sus pedidos en curso.' : 'Solicite novos materiais ou acompanhe seus pedidos em andamento.',
    'request_quote' => $is_spanish_client ? 'Solicitar Presupuesto' : 'Solicitar Orçamento',
    'chat_msg' => $is_spanish_client ? 'Hola! Me gustaría solicitar un presupuesto para o material: ' : 'Olá! Gostaria de solicitar um orçamento para o material: ',
    'email_fallback' => $is_spanish_client ? 'Solicitud enviada por e-mail a Trade Expansion: ' : 'Solicitação enviada por e-mail para Trade Expansion: ',
];
?>

<div data-tab-panel="orders" class="space-y-8 <?php echo $active_tab === 'orders' ? '' : 'hidden'; ?>">
    <div class="flex flex-col gap-2 border-b border-white/5 pb-6">
        <h2 class="text-3xl font-bold text-white"><?php echo $labels['title']; ?></h2>
        <p class="text-white/40 text-sm font-light italic">
            <?php echo $labels['subtitle']; ?>
        </p>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        // Materiais fictícios para interface, poderiam vir de uma API/Taxonomia futuramente
        $available_materials = [
            ['name' => 'Granito Branco Ceará', 'type' => 'Granito', 'image' => 'https://images.unsplash.com/photo-1615529182904-14819c35db37?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Quartzito Ocean Blue', 'type' => 'Quartzito', 'image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=400'],
            ['name' => 'Mármore Calacatta Premium', 'type' => 'Mármore', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=400'],
        ];
        foreach($available_materials as $mat): 
        ?>
        <div class="luxury-card overflow-hidden group">
            <div class="h-48 bg-white/5 overflow-hidden">
                <img src="<?php echo $mat['image']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="p-6">
                <span class="label-secondary opacity-40"><?php echo $mat['type']; ?></span>
                <h4 class="text-xl font-bold text-white mt-1"><?php echo $mat['name']; ?></h4>
                <button type="button" class="btn-minimalist w-full mt-6" onclick="requestMaterial('<?php echo esc_js($mat['name']); ?>')">
                    <?php echo $labels['request_quote']; ?>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function requestMaterial(name) {
    const msg = "<?php echo $labels['chat_msg']; ?>" + name;
    if (window.TidioChatApi) {
        window.TidioChatApi.open();
        window.TidioChatApi.sendNotification(msg);
    } else {
        alert("<?php echo $labels['email_fallback']; ?>" + name);
    }
}
</script>