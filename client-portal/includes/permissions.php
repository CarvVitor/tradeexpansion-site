<?php
/**
 * Trade Expansion - Sistema de Permissões
 * Funções helper para verificação de permissões granulares
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registra roles customizados (Cliente e Vendedor)
 * Executado apenas uma vez após ativação do tema
 */
function te_register_custom_roles()
{
    // Remove roles antigos se existirem (para atualização)
    remove_role('te_cliente');
    remove_role('te_vendedor');

    // Role: Cliente
    add_role(
        'te_cliente',
        'Cliente',
        [
            'read' => true,
            'te_view_own_materials' => true,
            'te_view_own_reports' => true,
            'te_view_own_inspections' => true,
            'te_view_own_financials' => true,
        ]
    );

    // Role: Vendedor
    add_role(
        'te_vendedor',
        'Vendedor',
        [
            'read' => true,
            'te_view_client_materials' => true,
            'te_view_client_reports' => true,
            'te_view_client_inspections' => true,
            // NÃO tem te_view_client_financials
        ]
    );

    // Adicionar capabilities aos administradores
    $admin_role = get_role('administrator');
    if ($admin_role) {
        $admin_role->add_cap('te_view_own_materials');
        $admin_role->add_cap('te_view_own_reports');
        $admin_role->add_cap('te_view_own_inspections');
        $admin_role->add_cap('te_view_own_financials');
        $admin_role->add_cap('te_view_client_materials');
        $admin_role->add_cap('te_view_client_reports');
        $admin_role->add_cap('te_view_client_inspections');
        $admin_role->add_cap('te_view_client_financials');
        $admin_role->add_cap('te_manage_client_portal');
    }
}

/**
 * Verifica se usuário pode acessar página de um cliente específico
 * 
 * @param int $user_id ID do usuário
 * @param string $client_id ID do cliente (ex: 'magma', 'globalmarmol')
 * @return bool
 */
function te_user_can_view_client_page($user_id, $client_id)
{
    if (!$user_id) {
        return false;
    }

    $user = get_userdata($user_id);
    if (!$user) {
        return false;
    }

    // Admin tem acesso total
    if (in_array('administrator', $user->roles)) {
        return true;
    }

    // Cliente: pode acessar apenas a própria página
    if (in_array('te_cliente', $user->roles)) {
        $user_company_id = get_user_meta($user_id, 'te_client_company_id', true);
        return $user_company_id === $client_id;
    }

    // Vendedor: pode acessar páginas de clientes vinculados
    if (in_array('te_vendedor', $user->roles)) {
        $vendor_clients = get_user_meta($user_id, 'te_vendor_clients', true);
        if (!is_array($vendor_clients)) {
            $vendor_clients = [];
        }
        return in_array($client_id, $vendor_clients);
    }

    return false;
}

/**
 * Verifica se usuário pode visualizar dados financeiros de um cliente
 * 
 * @param int $user_id ID do usuário
 * @param string $client_id ID do cliente
 * @return bool
 */
function te_user_can_view_financials($user_id, $client_id)
{
    if (!$user_id) {
        return false;
    }

    $user = get_userdata($user_id);
    if (!$user) {
        return false;
    }

    // Admin tem acesso total
    if (in_array('administrator', $user->roles)) {
        return true;
    }

    // Cliente: pode ver financeiro da própria empresa
    if (in_array('te_cliente', $user->roles)) {
        $user_company_id = get_user_meta($user_id, 'te_client_company_id', true);
        return $user_company_id === $client_id && user_can($user_id, 'te_view_own_financials');
    }

    // Vendedor: NÃO pode ver dados financeiros
    if (in_array('te_vendedor', $user->roles)) {
        return false;
    }

    return false;
}

/**
 * Retorna lista de clientes vinculados a um vendedor
 * 
 * @param int $user_id ID do vendedor
 * @return array Array de IDs de clientes
 */
function te_get_vendor_clients($user_id)
{
    $vendor_clients = get_user_meta($user_id, 'te_vendor_clients', true);
    if (!is_array($vendor_clients)) {
        return [];
    }
    return $vendor_clients;
}

/**
 * Retorna ID da empresa de um cliente
 * 
 * @param int $user_id ID do cliente
 * @return string|false ID da empresa ou false
 */
function te_get_user_company_id($user_id)
{
    return get_user_meta($user_id, 'te_client_company_id', true);
}

/**
 * Retorna ID do fornecedor de um vendedor
 * 
 * @param int $user_id ID do vendedor
 * @return string|false ID do fornecedor ou false
 */
function te_get_vendor_supplier_id($user_id)
{
    return get_user_meta($user_id, 'te_vendor_supplier_id', true);
}

/**
 * Verifica se usuário pode ver materiais de um fornecedor específico
 * 
 * @param int $user_id ID do usuário
 * @param string $supplier_id ID do fornecedor (ex: 'favorita_br', 'policast')
 * @param string $client_id ID do cliente
 * @return bool
 */
function te_user_can_view_supplier_materials($user_id, $supplier_id, $client_id)
{
    if (!$user_id) {
        return false;
    }

    $user = get_userdata($user_id);
    if (!$user) {
        return false;
    }

    // Admin vê tudo
    if (in_array('administrator', $user->roles)) {
        return true;
    }

    // Cliente vê todos os materiais da própria empresa
    if (in_array('te_cliente', $user->roles)) {
        $user_company_id = get_user_meta($user_id, 'te_client_company_id', true);
        return $user_company_id === $client_id;
    }

    // Vendedor vê apenas materiais do próprio fornecedor
    if (in_array('te_vendedor', $user->roles)) {
        $user_supplier_id = get_user_meta($user_id, 'te_vendor_supplier_id', true);
        $vendor_clients = get_user_meta($user_id, 'te_vendor_clients', true);

        if (!is_array($vendor_clients)) {
            $vendor_clients = [];
        }

        // Deve ser do mesmo fornecedor E ter acesso ao cliente
        return $user_supplier_id === $supplier_id && in_array($client_id, $vendor_clients);
    }

    return false;
}

/**
 * Retorna nome amigável do role
 * 
 * @param string $role Slug do role
 * @return string Nome amigável
 */
function te_get_role_display_name($role)
{
    $roles = [
        'administrator' => 'Administrador',
        'te_cliente' => 'Cliente',
        'te_vendedor' => 'Vendedor',
    ];

    return isset($roles[$role]) ? $roles[$role] : $role;
}

/**
 * Retorna todos os clientes disponíveis para vinculação
 * 
 * @return array Array com ['id' => 'nome']
 */
function te_get_available_clients()
{
    return [
        'magma' => 'Magma Superficies',
        'globalmarmol' => 'Global Marmol',
    ];
}

/**
 * Retorna todos os fornecedores disponíveis
 * 
 * @return array Array com ['id' => 'nome']
 */
function te_get_available_suppliers()
{
    return [
        'favorita_br' => 'Favorita do Brasil',
        'policast' => 'Policast',
    ];
}
