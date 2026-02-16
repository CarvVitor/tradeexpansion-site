<?php
/**
 * Template Name: Magma Report Page
 */

// Proteção de acesso: Apenas usuários logados podem ver esta página
if (!is_user_logged_in()) {
    wp_redirect(home_url('/area-do-cliente/'));
    exit;
}

// ============================================
// PROXY API (Handle before any HTML output)
// ============================================

if (isset($_GET['proxy_action']) && $_GET['proxy_action'] === 'fetch_sheet') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $APPS_SCRIPT_URL = 'https://script.google.com/macros/s/AKfycbx_H9mSsVcsCpqRjsoJMbuaRCSkqUcllQ1P5uvSHqYF7y8-HnNFkYCdwrx4-qKijnFj/exec';

    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $APPS_SCRIPT_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Erro cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception('HTTP Error: ' . $httpCode);
        }

        echo $response;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    exit; // Stop here, don't render HTML
}

// ============================================
// MAIN PAGE LOGIC
// ============================================

// Get the logged-in user from Basic Auth or similar environment variables
$user_login = $_SERVER['PHP_AUTH_USER'] ?? ($_SERVER['REMOTE_USER'] ?? '');

// Default permissions (nothing visible)
$can_view_favorita = false;
$can_view_policast = false;

// Define Access Rules
// admin.magma -> Can see everything
// magma.favbr -> Can see ONLY Favorita
// magma.policast -> Can see ONLY Policast

if ($user_login === 'admin.magma') {
    $can_view_favorita = true;
    $can_view_policast = true;
    $user_display_name = 'Admin';
} elseif ($user_login === 'magma.favbr') {
    $can_view_favorita = true;
    $user_display_name = 'Favorita do Brasil';
} elseif ($user_login === 'magma.policast') {
    $can_view_policast = true;
    $user_display_name = 'Policast';
} else {
    // If no user is logged in (development?), maybe handle gracefully or show error
    $user_display_name = 'Guest';
    // For safety, show nothing by default in production
}

// Data Arrays (PHP) - RESTORED ORIGINAL DATA
$favorita_data = [
    ["m" => "Crysttal Rosa", "b" => "", "bn" => "01", "s" => "Unknown", "f" => "UNKNOWN", "p" => 81.00, "i" => "Crysttal Rosa, 01 bd, $ 81,00.jpeg"],
    ["m" => "New Patagonia", "b" => "", "bn" => "04", "s" => "Unknown", "f" => "UNKNOWN", "p" => 151.00, "i" => "NEW PATAGONIA, BD 04, 4 151,00.jpeg"],
    ["m" => "New Patagonia", "b" => "", "bn" => "05", "s" => "Unknown", "f" => "UNKNOWN", "p" => 151.00, "i" => "NEW PATAGONIA, BD 05, $ 151,00.jpeg"],
    ["m" => "New Patagonia", "b" => "", "bn" => "06", "s" => "Unknown", "f" => "UNKNOWN", "p" => 151.00, "i" => "NEW PATAGONIA, BD 06, $ 151,00.jpeg"],
    ["m" => "Patagonia Top", "b" => "Top", "bn" => "01", "s" => "Unknown", "f" => "UNKNOWN", "p" => 109.00, "i" => "PATAGONIA TOP. 01 BD  , $ 109,00.jpeg"],
    ["m" => "Taj Mahal", "b" => "10468", "bn" => "02 (11-20)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 108.00, "i" => "TAJ MAHAL - BL 10468- Bd 02 - 11 a 20...$108.jpeg"],
    ["m" => "Taj Mahal", "b" => "10468", "bn" => "03 (21-30)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 108.00, "i" => "TAJ MAHAL - BL 10468- Bd 03 - 21 a 30 ....$108.jpeg"],
    ["m" => "Taj Mahal", "b" => "10470", "bn" => "03 (19-27)", "s" => "330x199", "f" => "UNKNOWN", "p" => 128.00, "i" => "TAJ MAHAL - BL 10470 - BD 03 - 19 a 27 - 3,30 x 1,99.... $128.jpeg"],
    ["m" => "Taj Mahal", "b" => "10463", "bn" => "02 (11-20)", "s" => "340x199", "f" => "UNKNOWN", "p" => 128.00, "i" => "TAJ MAHAL BL10463 - Bd 02 - 11 a 20 - 3,40 x 1,99....$128.jpeg"],
    ["m" => "Taj Mahal", "b" => "10385", "bn" => "02 (10-16)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 128.00, "i" => "TAJ MAHAL- BL 10385 - Bd 02 - 10 a 16.....$128.jpeg"],
    ["m" => "Taj Mahal", "b" => "10468", "bn" => "01 (01-10)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 108.00, "i" => "TAJ MAHAL- BL 10468- Bd 01 - 01 a 10....$108.jpeg"],
    ["m" => "Taj Mahal", "b" => "10470", "bn" => "04 (28-36)", "s" => "330x199", "f" => "UNKNOWN", "p" => 128.00, "i" => "TAJ MAHAL- BL 10470 - BD 04 - 28 a 36 - 3,30 x 1,99....$ 128,00.jpeg"],
    ["m" => "Taj Mahal", "b" => "10385", "bn" => "01 (1-09)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 128.00, "i" => "Taj Mahal - BL 10385 - Bd 01 - 1 a 09.....$128  👆🏻.jpeg"],
    ["m" => "Taj Mahal", "b" => "10247", "bn" => "03 (19-29)", "s" => "Unknown", "f" => "UNKNOWN", "p" => 108.00, "i" => "Taj mahal - BL 10247- Bd 03 - 19 a 29...$108.jpeg"],
    ["m" => "Tourmaline Top", "b" => "53", "bn" => "Multi (19 slabs)", "s" => "297x193", "f" => "POLISHED", "p" => 70.00, "i" => "Tourmaline Top 2cm Polished - Bl. 53 (2 bundles - 19 slabs) - 297 x  193 cm ......$ 70.jpeg"]
];

$policast_data = [
    ["m" => "Gris Corumbá", "b" => "", "bn" => "Primero Paquete", "s" => "Unknown", "f" => "Pulido", "p" => 15.00, "i" => "GRIS CORUMA PRIMERO PAQUETE PULIDO, $ 15.jpeg"],
    ["m" => "Gris Corumbá", "b" => "", "bn" => "Segundo Paquete", "s" => "Unknown", "f" => "Unknown", "p" => 15.00, "i" => "GRIS CORUMA SEGUNDO PAQUETE , $ 15.jpeg"],
    ["m" => "New Caledonia", "b" => "", "bn" => "Primero Paquete", "s" => "Unknown", "f" => "Unknown", "p" => null, "i" => "NEW CALEDONIA PRIMERO PAQUETE.jpeg"],
    ["m" => "New Caledonia", "b" => "", "bn" => "Segundo Paquete", "s" => "Unknown", "f" => "Unknown", "p" => null, "i" => "NEW CALEDONIA SEGUNDO PAQUETE.jpeg"],
    ["m" => "New Caledonia", "b" => "", "bn" => "Segundo Paquete", "s" => "Unknown", "f" => "Pulido", "p" => null, "i" => "NEW CALEDÔNIA SEGUNDO PAQUETE PULIDO.jpeg"],
    ["m" => "Vía Láctea", "b" => "", "bn" => "Primero Paquete", "s" => "Unknown", "f" => "Cepillado", "p" => null, "i" => "VÍA LÁCTEA PRIMERO PAQUETE, CEPILLADO.jpeg"],
    ["m" => "Vía Láctea", "b" => "", "bn" => "Quarto Paquete", "s" => "Unknown", "f" => "Cepillado", "p" => null, "i" => "VÍA LÁCTEA QUARTO PAQUETE, CEPILLADO.jpeg"],
    ["m" => "Vía Láctea", "b" => "", "bn" => "Segundo Paquete", "s" => "Unknown", "f" => "Cepillado", "p" => null, "i" => "VÍA LÁCTEA SEGUNDO PAQUETE, CEPILLADO.jpeg"],
    ["m" => "Vía Láctea", "b" => "", "bn" => "Tercero Paquete", "s" => "Unknown", "f" => "Cepillado", "p" => null, "i" => "VÍA LÁCTEA TERCERO PAQUETE, CEPILLADO.jpeg"]
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Prevent caching to ensure login changes reflect immediately -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>Material Report | Trade Expansion & Magma Superficies</title>

    <!-- Typography: Vollkorn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <!-- Extra fonts for Management View -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Export Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        /* ============================================ */
        /* THEME SYSTEM - Dark & Light Mode Support */
        /* ============================================ */

        :root {
            /* Dark Theme (Default) */
            --primary: #D6A354;
            --secondary: #5D2713;
            --bg-dark: #102724;
            --bg-header: #0b1d1b;
            --bg-card: rgba(16, 39, 36, 0.85);
            --text-bright: #F1F1D9;
            --text-muted: #a8b0bf;
            --border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(16px);
            --gradient: linear-gradient(135deg, #D6A354, #5D2713);

            /* Theme-specific colors */
            --theme-bg: #102724;
            --theme-bg-secondary: #0b1d1b;
            --theme-text: #F1F1D9;
            --theme-text-secondary: #a8b0bf;
            --theme-card-bg: rgba(16, 39, 36, 0.85);
            --theme-border: rgba(255, 255, 255, 0.08);
            --theme-shadow: rgba(0, 0, 0, 0.3);
            --theme-glass-bg: rgba(11, 29, 27, 0.6);
        }

        /* Light Theme */
        body.light-theme {
            --theme-bg: #F5F1E8;
            --theme-bg-secondary: #E8E4D9;
            --theme-text: #2C2416;
            --theme-text-secondary: #6B5D4F;
            --theme-card-bg: rgba(255, 255, 255, 0.9);
            --theme-border: rgba(0, 0, 0, 0.08);
            --theme-shadow: rgba(0, 0, 0, 0.1);
            --theme-glass-bg: rgba(255, 255, 255, 0.7);
        }

        * {
            box-sizing: border-box;
            transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }

        body {
            margin: 0;
            font-family: 'Vollkorn', serif;
            background-color: var(--theme-bg);
            background-image:
                radial-gradient(circle at 10% 20%, rgba(214, 163, 84, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(93, 39, 19, 0.15) 0%, transparent 40%);
            background-attachment: fixed;
            color: var(--theme-text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            padding-top: 100px;
        }

        /* Co-Branded Header */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: rgba(7, 8, 10, 0.9);
            backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            z-index: 1000;
        }

        .logos-wrapper {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .logo-te {
            height: 40px;
            display: block;
        }

        .divider {
            height: 40px;
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .logo-client {
            height: 50px;
            display: block;
            opacity: 0.9;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #D6A354;
            border-radius: 10px;
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #D6A354 rgba(255, 255, 255, 0.05);
        }

        .glass-panel {
            background: rgba(11, 29, 27, 0.7);
            /* Matching brand dark green */
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Widescreen overrides for Management View */
        body.is-mgmt .container {
            max-width: 98% !important;
            width: 98% !important;
        }

        #management-view .container {
            max-width: 100% !important;
        }

        /* Prevent layout shift during loading */
        .mgmt-grid-container {
            min-height: 400px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-family: 'Vollkorn', serif;
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--theme-text);
        }

        .hero h1 span {
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            color: var(--theme-text-secondary);
            max-width: 600px;
            margin: 0 auto;
            letter-spacing: 0.12em;
            font-weight: 300;
            text-transform: uppercase;
        }

        .supplier-badge {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 25px;
            border-radius: 50px;
            border: 1px solid var(--border);
        }

        .supplier-info {
            text-align: left;
        }

        .supplier-info span {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .supplier-info strong {
            color: #fff;
            font-size: 15px;
        }

        .supplier-logo {
            height: 35px;
            /* Filter removed to allow logos to appear as-is, especially for colored/white logos */
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        <?php if (!$can_view_favorita && !$can_view_policast): ?>
            .tab-nav {
                display: none;
            }

            .hero {
                display: none;
            }

            /* Hide hero if no access */
        <?php endif; ?>

        .tab-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-family: inherit;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .tab-btn.active {
            background: var(--primary);
            color: var(--bg-dark);
            border-color: var(--primary);
            font-weight: 700;
        }

        /* Masonry Grid Layout */
        .masonry-grid {
            column-count: 3;
            column-gap: 25px;
            margin-top: 40px;
        }

        .grid-item {
            break-inside: avoid;
            margin-bottom: 30px;
            background: var(--theme-card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--theme-border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px var(--theme-shadow);
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 45px var(--theme-shadow),
                0 0 0 1px rgba(214, 163, 84, 0.3);
            border-color: rgba(214, 163, 84, 0.4);
        }

        .card-img-wrapper {
            position: relative;
            cursor: zoom-in;
        }

        .card-img-wrapper img {
            width: 100%;
            display: block;
            transition: transform 0.5s;
        }

        .card-content {
            padding: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .mat-name {
            font-family: 'Vollkorn', serif;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.1em;
            color: var(--theme-text);
            line-height: 1.2;
        }

        .mat-price {
            font-family: 'Vollkorn', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            white-space: nowrap;
            letter-spacing: 0.05em;
        }

        .mat-price span {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            color: var(--theme-text-secondary);
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .mat-details {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 24px;
            margin-top: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--theme-border);
        }

        .det-item {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
            font-weight: 300;
            color: var(--theme-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .det-item strong {
            display: block;
            color: var(--theme-text-secondary);
            font-weight: 500;
            font-size: 9px;
            margin-bottom: 4px;
            opacity: 0.7;
        }


        /* Video Section */
        .video-feature {
            margin: 60px 0;
            padding: 40px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
            border-radius: 20px;
            text-align: center;
        }

        .video-feature h2 {
            color: #fff;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .video-wrapper {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        video {
            width: 100%;
            display: block;
        }

        /* Footer */
        .site-footer {
            margin-top: 80px;
            padding: 60px 20px;
            background: rgba(0, 0, 0, 0.4);
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .f-logo-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            opacity: 0.8;
        }

        /* Lightbox */
        #lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: zoom-out;
            padding: 40px;
        }

        #lightbox img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 0 50px rgba(214, 163, 84, 0.2);
        }

        /* MANAGEMENT VIEW STYLES */
        .mgmt-hidden {
            display: none !important;
        }

        .mgmt-btn {
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            margin-left: 20px;
        }

        .mgmt-btn:hover,
        .mgmt-btn.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #000;
        }


        /* ============================================ */
        /* LUXURY MANAGEMENT VIEW STYLES */
        /* ============================================ */

        #management-view {
            padding-top: 40px;
            font-family: 'Outfit', sans-serif;
        }

        /* Editorial Typography */
        #management-view h2,
        #management-view th {
            font-family: 'Vollkorn', serif;
            letter-spacing: 0.15em;
            font-weight: 600;
        }

        #management-view .text-3xl {
            letter-spacing: 0.12em;
            font-weight: 500;
        }

        /* Refined Glassmorphism - Table Panel */
        #management-view .glass-panel {
            background: rgba(11, 29, 27, 0.6) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.37),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.05);
        }

        /* Table Luxury Spacing */
        #management-view table th {
            padding: 24px 20px !important;
            font-size: 11px;
            font-weight: 200;
            text-transform: uppercase;
        }

        #management-view table td {
            padding: 20px !important;
            font-family: 'Vollkorn', serif;
            font-size: 15px;
        }

        /* Prestigious Row Hover */
        #management-view table tbody tr {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        #management-view table tbody tr:hover {
            transform: translateY(-1px);
            background: rgba(214, 163, 84, 0.03) !important;
            box-shadow:
                0 0 0 1px rgba(214, 163, 84, 0.2),
                0 4px 12px rgba(214, 163, 84, 0.1);
        }

        /* Champagne Input Focus */
        #management-view [contenteditable]:focus {
            outline: none;
            background: rgba(214, 163, 84, 0.08) !important;
            border-color: rgba(214, 163, 84, 0.6) !important;
            box-shadow:
                0 0 0 2px rgba(214, 163, 84, 0.2),
                inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Minimalist Buttons */
        #management-view button {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.08em;
            font-weight: 300;
        }

        #management-view button:hover {
            background: rgba(214, 163, 84, 0.15);
            border-color: rgba(214, 163, 84, 0.5);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(214, 163, 84, 0.2);
        }

        #management-view button.bg-\[#D6A354\] {
            background: linear-gradient(135deg, #D6A354 0%, #B58842 100%) !important;
            border: none;
        }

        #management-view button.bg-\[#D6A354\]:hover {
            background: linear-gradient(135deg, #E5B365 0%, #C69953 100%) !important;
            box-shadow: 0 6px 20px rgba(214, 163, 84, 0.4);
        }

        /* Elegant Progress Indicator */
        #luxury-progress {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #D6A354, transparent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            z-index: 9999;
            opacity: 0;
        }

        #luxury-progress.active {
            opacity: 1;
            animation: luxuryProgress 1.5s ease-in-out infinite;
        }

        @keyframes luxuryProgress {
            0% {
                transform: scaleX(0) translateX(0);
            }

            50% {
                transform: scaleX(0.6) translateX(50%);
            }

            100% {
                transform: scaleX(0) translateX(100%);
            }
        }

        /* Luxury Modal Animations */
        #modal .modal-panel {
            animation: luxuryModalIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes luxuryModalIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Minimalist Modal Inputs */
        #modal input {
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid rgba(214, 163, 84, 0.3) !important;
            border-radius: 0 !important;
            padding: 12px 4px !important;
            font-family: 'Vollkorn', serif;
            color: #ffffff !important;
            transition: all 0.3s ease;
        }

        #modal input:focus {
            outline: none;
            border-bottom-color: rgba(214, 163, 84, 0.8) !important;
            box-shadow: 0 1px 0 0 rgba(214, 163, 84, 0.5);
        }

        #modal label {
            font-family: 'Outfit', sans-serif;
            font-weight: 200;
            font-size: 10px;
            letter-spacing: 0.12em;
        }

        /* Image Blur Effect (Optional Luxury Touch) */
        .mgmt-card-img img {
            transition: filter 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            filter: blur(2px) brightness(0.9);
        }

        .mgmt-card-img:hover img {
            filter: blur(0) brightness(1);
        }

        /* Refined Scrollbar */
        #management-view .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        #management-view .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        #management-view .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(214, 163, 84, 0.3);
            border-radius: 3px;
        }

        #management-view .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(214, 163, 84, 0.5);
        }

        .mgmt-card-img {
            position: relative;
        }

        .mgmt-delete-btn {
            background: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        /* Spinner & Toast */
        .loader-ring {
            display: inline-block;
            position: relative;
            width: 40px;
            height: 40px;
        }

        .loader-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 32px;
            height: 32px;
            margin: 4px;
            border: 2px solid var(--primary);
            border-radius: 50%;
            animation: loader-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: var(--primary) transparent transparent transparent;
        }

        .loader-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .loader-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .loader-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes loader-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .modal-bg {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }


        /* Responsive */
        @media(max-width: 1000px) {
            .masonry-grid {
                column-count: 2;
            }
        }

        @media(max-width: 600px) {
            .masonry-grid {
                column-count: 1;
            }

            .site-header {
                height: 80px;
                padding: 0 20px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .logos-wrapper {
                gap: 15px;
            }

            .logo-te {
                height: 25px;
            }

            .logo-client {
                height: 30px;
            }
        }

        /* Download Dropdown Styles */
        .download-dropdown {
            position: relative;
            display: inline-block;
        }

        .download-btn {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            text-transform: none;
            letter-spacing: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .download-btn:hover {
            background: rgba(214, 163, 84, 0.1);
            color: var(--primary);
            border-color: var(--primary);
            transform: none;
            box-shadow: none;
        }

        .download-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: rgba(11, 29, 27, 0.95);
            backdrop-filter: blur(20px);
            min-width: 200px;
            border-radius: 15px;
            border: 1px solid var(--border);
            z-index: 1001;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .download-dropdown:hover .download-content {
            display: block;
            animation: fadeInDown 0.3s ease forwards;
        }

        .download-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: var(--text-bright);
            text-decoration: none;
            font-size: 14px;
            border-radius: 10px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .download-item:hover {
            background: rgba(214, 163, 84, 0.15);
            color: var(--primary);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Comment System */
        .comment-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            color: var(--text-muted);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .comment-btn:hover {
            background: var(--primary);
            color: var(--bg-dark);
            border-color: var(--primary);
        }

        .comment-area {
            margin-top: 15px;
            padding: 12px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid var(--border);
            display: none;
        }

        .comment-area textarea {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--text-bright);
            font-size: 13px;
            resize: none;
            outline: none;
            font-family: inherit;
        }

        .comment-area.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* PDF Styles */
        .exporting-pdf {
            background-color: #102724 !important;
            color: #ffffff !important;
            width: 1000px !important;
            margin: 0 !important;
        }

        .exporting-pdf .masonry-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 20px !important;
            column-count: auto !important;
        }

        .exporting-pdf .grid-item {
            break-inside: avoid;
            page-break-inside: avoid;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        @media print {
            body {
                background: #102724 !important;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body id="main-body">

    <header class="site-header">
        <div class="flex items-center">
            <div class="logos-wrapper">
                <img src="https://tradeexpansion.com.br/wp-content/themes/tradeexpansion-site-main/assets/images/logo.jpg"
                    alt="Trade Expansion" class="logo-te">
                <div class="divider"></div>
                <img src="https://www.magmasuperficies.com/site/wp-content/uploads/2023/03/Mesa-de-trabajo-2.png"
                    alt="Magma Superficies" class="logo-client">
            </div>

            <?php if ($user_login == 'admin.magma'): ?>
                <button onclick="toggleManagementView()" id="mgmt-btn" class="mgmt-btn">
                    Gestionar Inventario
                </button>
            <?php endif; ?>
        </div>

        <div style="color:var(--text-muted); font-size:12px; letter-spacing:1px; text-transform:uppercase;">
            Vista Previa Exclusiva
            <?php if ($user_login) {
                echo " | " . htmlspecialchars($user_display_name);
            } ?>
        </div>
    </header>

    <div class="container relative">

        <?php if (!$can_view_favorita && !$can_view_policast): ?>
            <div style="text-align:center; padding: 100px 20px;">
                <h1 style="color:#fff;">Acceso Restringido</h1>
                <p style="color:var(--text-muted);">Ha iniciado sesión como:
                    <strong><?php echo htmlspecialchars($user_login); ?></strong>
                </p>
                <p style="color:var(--text-muted);">Este usuario no tiene permiso para ver este reporte.</p>
            </div>
        <?php else: ?>

            <!-- PUBLIC REPORT VIEW -->
            <div id="public-view" class="fade-in">
                <section class="hero">
                    <h1>Reporte de <span>Inventario Seleccionado</span></h1>
                    <p>Preparado exclusivamente para Magma Superficies (Israel).</p>

                    <div class="tab-nav flex-wrap">
                        <div class="flex gap-4">
                            <?php if ($can_view_favorita): ?>
                                <button
                                    class="tab-btn <?php echo (!$can_view_policast || $can_view_favorita) ? 'active' : ''; ?>"
                                    onclick="switchTab('favorita')">Favorita do Brasil</button>
                            <?php endif; ?>

                            <?php if ($can_view_policast): ?>
                                <button class="tab-btn <?php echo (!$can_view_favorita) ? 'active' : ''; ?>"
                                    onclick="switchTab('policast')">Policast</button>
                            <?php endif; ?>
                        </div>

                        <!-- High Luxury Download Button -->
                        <div class="download-dropdown">
                            <button class="download-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Exportar
                            </button>
                            <div class="download-content">
                                <div class="download-item" onclick="exportToExcel()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-green-500">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    Exportar como Excel
                                </div>
                                <div class="download-item" onclick="exportToPDF()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-red-500">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <path d="M12 18V9"></path>
                                        <path d="M9 15l3 3 3-3"></path>
                                    </svg>
                                    Exportar como PDF
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="supplier-badge">
                        <div class="supplier-info">
                            <span>Materiales de</span>
                            <strong>-</strong>
                        </div>
                        <img src="" alt="Supplier Logo" class="supplier-logo" style="display:none">
                    </div>
                </section>

                <!-- Masonry Grid -->
                <div id="materialGrid" class="masonry-grid">
                    <!-- JS Injection -->
                </div>

                <section class="video-feature">
                    <h2>Material Destacado: Tourmaline</h2>
                    <div class="video-wrapper">
                        <video controls>
                            <source
                                src="Materiais%20Favorita%20-%20Israel/Tourmaline%20Top%202cm%20Polished%20-%20Bl.%2053%20(2%20bundles%20-%2019%20slabs)%20-%20297%20x%20%20193%20cm%20......$%2070.mp4"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <p style="margin-top:15px; color:var(--text-muted);">
                        Inspección detallada de Tourmaline Bloque 53.
                    </p>
                </section>

                <footer class="site-footer">
                    <div class="f-logo-row">
                        <img src="https://tradeexpansion.com.br/wp-content/themes/tradeexpansion-site-main/assets/images/logo.jpg"
                            style="height:30px">
                        <span>&times;</span>
                        <img src="https://www.magmasuperficies.com/site/wp-content/uploads/2023/03/Mesa-de-trabajo-2.png"
                            style="height:35px; filter:brightness(0) invert(1)">
                    </div>
                    <p style="font-size:13px; color:var(--theme-text-secondary)">
                        Suministrado por <a href="#" target="_blank"
                            style="color:var(--primary); text-decoration:none;">Trade Expansion</a>.
                    </p>
                </footer>
            </div>
            <!-- END PUBLIC VIEW -->

            <!-- MANAGEMENT VIEW (Hidden by default) -->
            <div id="management-view" class="mgmt-hidden">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif text-[#D6A354] mb-2">Panel de Gestión</h2>
                    <p class="text-slate-400">Edite los artículos directamente en la hoja de cálculo.</p>
                </div>

                <div class="flex justify-end mb-6 gap-4">
                    <!-- Theme Toggle Button -->
                    <button onclick="toggleTheme()" id="theme-toggle"
                        class="px-4 py-2 border border-white/20 rounded-lg hover:bg-white/10 text-sm text-white transition flex items-center gap-2"
                        title="Cambiar Tema">
                        <svg id="theme-icon-dark" class="hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        <svg id="theme-icon-light" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <span id="theme-text">Claro</span>
                    </button>
                    <!-- Management Export Button -->
                    <div class="download-dropdown">
                        <button
                            class="px-4 py-2 border border-white/20 rounded-lg hover:bg-white/10 text-sm text-white transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Exportar
                        </button>
                        <div class="download-content">
                            <div class="download-item" onclick="mgmt_exportToExcel()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-green-500">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                Exportar como Excel
                            </div>
                            <div class="download-item" onclick="mgmt_exportToPDF()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-red-500">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <path d="M12 18V9"></path>
                                    <path d="M9 15l3 3 3-3"></path>
                                </svg>
                                Exportar como PDF
                            </div>
                        </div>
                    </div>

                    <button onclick="mgmt_fetchData()"
                        class="px-4 py-2 border border-white/20 rounded-lg hover:bg-white/10 text-sm text-white transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                            <path d="M16 21h5v-5" />
                        </svg>
                        Sincronizar
                    </button>
                    <button onclick="mgmt_openModal()"
                        class="px-6 py-2 bg-[#D6A354] hover:bg-[#b58842] text-slate-900 rounded-lg font-bold text-sm transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Añadir Nuevo
                    </button>
                </div>

                <!-- Grid Container -->
                <div id="mgmt-grid" class="w-full">
                    <!-- Injected -->
                </div>
            </div>
            <!-- END MANAGEMENT VIEW -->

        <?php endif; ?>
    </div>

    <!-- Shared UI: Lightbox -->
    <div id="lightbox" onclick="this.style.display='none'"><img id="lbImg" src=""></div>

    <!-- Luxury Progress Indicator -->
    <div id="luxury-progress"></div>

    <!-- Management UI: Loading/Toast/Modal -->
    <div id="loader"
        class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="loader-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p class="text-[#D6A354] mt-4 font-mono text-xs uppercase tracking-widest animate-pulse">Procesando...</p>
    </div>

    <div id="toast"
        class="fixed bottom-8 right-8 z-50 translate-x-40 opacity-0 transition-all duration-500 rounded-lg p-4 flex items-center gap-4 bg-[#1e293b] border-l-4 border-[#D6A354] shadow-2xl">
        <div id="toast-icon" class="text-[#D6A354]"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg></div>
        <div>
            <h4 class="text-white font-medium text-sm">Notificación</h4>
            <p class="text-slate-400 text-xs" id="toast-message">Éxito.</p>
        </div>
    </div>

    <!-- Management Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 modal-bg transition-opacity opacity-0" onclick="mgmt_closeModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-[#1e293b] border border-white/10 text-left shadow-2xl transition-all sm:w-full sm:max-w-lg opacity-0 translate-y-4 modal-panel">
                    <div class="px-6 py-8">
                        <h3 class="text-2xl font-serif text-[#D6A354] mb-6">Nuevo Registro</h3>
                        <div class="space-y-4" id="modal-fields"></div>
                    </div>
                    <div class="bg-[#0f172a] px-6 py-4 flex flex-row-reverse gap-3 border-t border-white/5">
                        <button type="button" onclick="mgmt_submitNewRow()"
                            class="px-6 py-2 bg-[#D6A354] text-slate-900 rounded font-bold text-sm hover:bg-[#b58842] transition">Guardar</button>
                        <button type="button" onclick="mgmt_closeModal()"
                            class="px-6 py-2 text-slate-400 hover:text-white text-sm font-medium transition">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden File Input for Management Uploads -->
    <input type="file" id="mgmt-file-input" class="hidden" onchange="mgmt_handleFileUpload(event)">

    <script>
        // ==========================================
        // THEME MANAGEMENT SYSTEM
        // ==========================================
        (function () {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.body.classList.add('light-theme');
            }
        })();

        window.addEventListener('DOMContentLoaded', () => {
            updateThemeUI();
        });

        function toggleTheme() {
            document.body.classList.toggle('light-theme');
            const isLight = document.body.classList.contains('light-theme');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            updateThemeUI();
        }

        function updateThemeUI() {
            const isLight = document.body.classList.contains('light-theme');
            const toggle = document.getElementById('theme-toggle');
            if (!toggle) return;

            const iconDark = document.getElementById('theme-icon-dark');
            const iconLight = document.getElementById('theme-icon-light');
            const text = document.getElementById('theme-text');

            if (isLight) {
                iconDark.classList.remove('hidden');
                iconLight.classList.add('hidden');
                text.textContent = 'Oscuro';
                toggle.style.borderColor = 'rgba(0,0,0,0.2)';
                toggle.style.color = '#2C2416';
            } else {
                iconDark.classList.add('hidden');
                iconLight.classList.remove('hidden');
                text.textContent = 'Claro';
                toggle.style.borderColor = 'rgba(255,255,255,0.2)';
                toggle.style.color = 'white';
            }
        }

        // ==========================================
        // ORIGINAL PUBLIC VIEW LOGIC
        // ==========================================
        const collections = {};

        <?php if ($can_view_favorita): ?>
            collections.favorita = {
                name: "Favorita do Brasil",
                logo: "https://www.favoritabrasil.com/images/logo-favorita-brasile.svg",
                folder: "Materiais Favorita - Israel/",
                url: "https://www.favoritabrasil.com/pt",
                data: <?php echo json_encode($favorita_data); ?>
            };
        <?php endif; ?>

        <?php if ($can_view_policast): ?>
            collections.policast = {
                name: "Policast",
                logo: "Materiais - Policast/Policast Logomarca.png",
                folder: "Materiais - Policast/",
                url: "#",
                data: <?php echo json_encode($policast_data); ?>
            };
        <?php endif; ?>

        <?php
        if ($can_view_favorita) {
            echo "let currentKey = 'favorita';";
        } elseif ($can_view_policast) {
            echo "let currentKey = 'policast';";
        } else {
            echo "let currentKey = null;";
        }
        ?>

        function init() {
            if (currentKey && collections[currentKey]) {
                switchTab(currentKey);
            }
        }

        function switchTab(key) {
            if (!collections[key]) return;
            currentKey = key;
            const supplier = collections[key];
            renderGrid(supplier.data, supplier.folder);

            // Update UI elements
            const badgeLogo = document.querySelector('.supplier-logo');
            document.querySelector('.supplier-info strong').textContent = supplier.name;
            badgeLogo.src = encodeURI(supplier.logo);
            badgeLogo.alt = supplier.name;
            badgeLogo.style.display = 'block';

            // Fix Policyast logo visibility on dark background
            if (key === 'policast') {
                badgeLogo.style.filter = 'brightness(0) invert(1)';
            } else {
                badgeLogo.style.filter = 'none';
            }

            // Update Tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                const isActive = btn.getAttribute('onclick').includes(key);
                btn.classList.toggle('active', isActive);
            });

            // Toggle Video
            const videoSection = document.querySelector('.video-feature');
            if (videoSection) videoSection.style.display = (key === 'favorita') ? 'block' : 'none';
        }

        function renderGrid(data, folder) {
            const grid = document.getElementById('materialGrid');
            if (!grid) return;
            grid.innerHTML = '';

            if (data.length === 0) {
                grid.innerHTML = '<div style="text-align:center; padding:40px; color:var(--text-muted); grid-column:1/-1;">No se encontraron materiales.</div>';
                return;
            }

            data.forEach((item, index) => {
                // Filter out 'close up' or 'detalhe' photos if it's Policast
                const imgLower = (item.i || '').toLowerCase();
                if (currentKey === 'policast' && (imgLower.includes('close up') || imgLower.includes('detalhe') || imgLower.includes('closeup'))) {
                    return;
                }

                const priceDisplay = item.p ? '$ ' + item.p.toFixed(2) : '-';
                const card = document.createElement('div');
                card.className = 'grid-item';
                const imgPath = folder + encodeURIComponent(item.i);
                const cardId = `card-${currentKey}-${index}`;
                const savedComment = localStorage.getItem(cardId) || '';

                card.innerHTML = `
                  <div class="card-img-wrapper" onclick="openLightbox('${imgPath}')">
                      <img src="${imgPath}" loading="lazy" onerror="this.src='https://placehold.co/400x300?text=No+Image'; this.style.opacity=0.5">
                  </div>
                  <div class="card-content">
                      <div class="card-header">
                          <div class="flex-1">
                              <span class="mat-name">${item.m}</span>
                              <div class="mat-price">${priceDisplay} <span>/m²</span></div>
                          </div>
                          <button class="comment-btn" onclick="toggleComment('${cardId}')" title="Añadir comentario">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                          </button>
                      </div>
                      <div class="mat-details">
                          <div class="det-item"><strong>Bloque</strong>${item.b || '-'}</div>
                          <div class="det-item"><strong>Paquete</strong>${item.bn || '-'}</div>
                      </div>
                      <div id="comment-${cardId}" class="comment-area ${savedComment ? 'active' : ''}">
                          <textarea placeholder="Añadir nota privada..." 
                                    onblur="saveComment('${cardId}', this.value)">${savedComment}</textarea>
                      </div>
                  </div>
                `;
                grid.appendChild(card);
            });
        }

        function openLightbox(src) {
            document.getElementById('lbImg').src = src;
            document.getElementById('lightbox').style.display = 'flex';
        }

        /**
         * New Feature Functions
         */

        function toggleComment(cardId) {
            const area = document.getElementById(`comment-${cardId}`);
            if (area) area.classList.toggle('active');
        }

        function saveComment(cardId, value) {
            localStorage.setItem(cardId, value);
            showToast('Comentario guardado localmente', 'success');
        }

        function exportToExcel() {
            if (!currentKey || !collections[currentKey]) {
                showToast('Seleccione una colección primero', 'error');
                return;
            }

            const supplier = collections[currentKey];
            const data = supplier.data;

            // Prepare data for Excel
            const worksheetData = data.map(item => ({
                'Material': item.m,
                'Bloque': item.b || '-',
                'Paquete': item.bn || '-',
                'Precio ($/m²)': item.p || '-',
                'Estado': 'Disponible'
            }));

            const worksheet = XLSX.utils.json_to_sheet(worksheetData);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, supplier.name);

            // Export
            XLSX.writeFile(workbook, `Inventario_${supplier.name.replace(/\s+/g, '_')}.xlsx`);
            showToast('Excel generado con éxito', 'success');
        }

        function exportToPDF() {
            const element = document.getElementById('public-view');
            const supplier = collections[currentKey] ? collections[currentKey].name : 'Reporte';

            showToast('Generando PDF...', 'info');

            // Force visual styles for export
            const originalBg = element.style.backgroundColor;
            const originalPadding = element.style.padding;
            element.style.backgroundColor = '#102724';
            element.style.padding = '40px';
            element.classList.add('exporting-pdf');

            const opt = {
                margin: [0.3, 0.3],
                filename: `Reporte_${supplier.replace(/\s+/g, '_')}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#102724',
                    letterRendering: true,
                    scrollY: 0
                },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Temporary hide elements for cleaner PDF
            const tabNav = document.querySelector('.tab-nav');
            if (tabNav) tabNav.style.display = 'none';

            html2pdf().set(opt).from(element).save().then(() => {
                // Restore styles
                element.style.backgroundColor = originalBg;
                element.style.padding = originalPadding;
                element.classList.remove('exporting-pdf');
                if (tabNav) tabNav.style.display = 'flex';
                showToast('PDF generado con éxito', 'success');
            }).catch(err => {
                console.error('PDF Error:', err);
                showToast('Error al generar PDF', 'error');
                element.style.backgroundColor = originalBg;
                element.style.padding = originalPadding;
                element.classList.remove('exporting-pdf');
                if (tabNav) tabNav.style.display = 'flex';
            });
        }

        function mgmt_exportToExcel() {
            if (mgmt_allData.length === 0) {
                showToast('No hay datos para exportar', 'error');
                return;
            }

            const worksheetData = mgmt_allData.map(row => {
                let cleanRow = {};
                mgmt_headers.forEach(h => {
                    cleanRow[h] = mgmt_formatValue(h, row[h]);
                });
                return cleanRow;
            });

            const worksheet = XLSX.utils.json_to_sheet(worksheetData);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Inventario_Gestion');

            XLSX.writeFile(workbook, `Gestion_Inventario_${new Date().toLocaleDateString().replace(/\//g, '_')}.xlsx`);
            showToast('Excel generado con éxito', 'success');
        }

        function mgmt_exportToPDF() {
            const tableElement = document.querySelector('#mgmt-grid');
            if (!tableElement || mgmt_allData.length === 0) {
                showToast('No hay datos para exportar', 'error');
                return;
            }

            showToast('Generando PDF de gestión...', 'info');

            const opt = {
                margin: [0.5, 0.3],
                filename: `Gestion_Inventario_${new Date().toLocaleDateString().replace(/\//g, '_')}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#0b1d1b',
                    letterRendering: true
                },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(tableElement).save().then(() => {
                showToast('PDF generado con éxito', 'success');
            }).catch(err => {
                console.error('PDF Error:', err);
                showToast('Error al generar PDF', 'error');
            });
        }

        // ==========================================
        // MANAGEMENT VIEW LOGIC
        // ==========================================
        let isMgmtView = false;
        // Usando arquivo proxy separado (mais simples e confiável)
        const API_URL = 'proxy-sheet.php';
        let mgmt_allData = [];
        let mgmt_headers = [];

        function toggleManagementView() {
            isMgmtView = !isMgmtView;

            const publicView = document.getElementById('public-view');
            const mgmtView = document.getElementById('management-view');
            const btn = document.getElementById('mgmt-btn');

            if (isMgmtView) {
                publicView.classList.add('mgmt-hidden');
                mgmtView.classList.remove('mgmt-hidden');
                btn.classList.add('active');
                btn.textContent = 'Volver al Informe';

                // Load data first time
                if (mgmt_allData.length === 0) mgmt_fetchData();
            } else {
                publicView.classList.remove('mgmt-hidden');
                mgmtView.classList.add('mgmt-hidden');
                btn.classList.remove('active');
                btn.textContent = 'Gestionar Inventario';
            }

            // Add class to body for wider container
            document.body.classList.toggle('is-mgmt', isMgmtView);
        }

        async function mgmt_fetchData() {
            setLoading(true);

            // Tentar primeiro o proxy, depois fallback para URL direta
            const urls = [
                API_URL, // Proxy PHP (funciona no servidor)
                'https://script.google.com/macros/s/AKfycbx_H9mSsVcsCpqRjsoJMbuaRCSkqUcllQ1P5uvSHqYF7y8-HnNFkYCdwrx4-qKijnFj/exec' // Fallback direto
            ];

            let lastError = null;

            for (const url of urls) {
                try {
                    console.log('Tentando buscar de:', url);
                    const response = await fetch(url, {
                        credentials: 'include' // CRUCIAL: Pass HTTP Basic Auth credentials
                    });

                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const text = await response.text();
                    console.log('Response text (first 200 chars):', text.substring(0, 200));

                    // Verificar se é HTML (erro) ou JSON
                    if (text.trim().startsWith('<')) {
                        throw new Error('Resposta em HTML, não JSON. Proxy pode não estar funcionando.');
                    }

                    const data = JSON.parse(text);
                    console.log('Parsed data:', data);
                    console.log('Data is array?', Array.isArray(data));
                    console.log('First element is array?', Array.isArray(data[0]));

                    if (Array.isArray(data) && data.length > 0 && Array.isArray(data[0])) {
                        mgmt_headers = data[0];
                        const rawRows = data.slice(1).map(row => {
                            let obj = {};
                            mgmt_headers.forEach((h, i) => obj[h] = row[i]);
                            return obj;
                        });

                        // Sorting Logic: by FECHA DE VENCIMIENTO (oldest to newest)
                        const dateFields = ['FECHA DE VENCIMIENTO', 'VENCIMIENTO', 'FECHA'];
                        const dateHeader = mgmt_headers.find(h => dateFields.some(f => h.toUpperCase().includes(f)));

                        if (dateHeader) {
                            rawRows.sort((a, b) => {
                                let dateA = new Date(a[dateHeader]);
                                let dateB = new Date(b[dateHeader]);
                                let timeA = isNaN(dateA.getTime()) ? Infinity : dateA.getTime();
                                let timeB = isNaN(dateB.getTime()) ? Infinity : dateB.getTime();
                                return timeA - timeB;
                            });
                        }

                        mgmt_allData = rawRows;
                        showToast('Datos sincronizados con éxito', 'success');
                    } else if (Array.isArray(data) && data.length > 0) {
                        mgmt_headers = Object.keys(data[0]);
                        mgmt_allData = data;
                        showToast('Datos sincronizados con éxito', 'success');
                    } else {
                        throw new Error('Estructura de datos inválida');
                    }

                    mgmt_renderGrid();
                    return; // Sucesso! Sair da função

                } catch (error) {
                    console.error('Erro ao tentar URL:', url, error);
                    lastError = error;
                    // Continuar para próxima URL
                }
            }

            // Se chegou aqui, todas as URLs falharam
            console.error('Erro completo:', lastError);
            showToast('Error al cargar datos: ' + (lastError?.message || 'Desconocido'), 'error');
            setLoading(false);
        }

        // Helper to format values (especially dates and currency)
        function mgmt_formatValue(key, val) {
            if (val === null || val === undefined || val === '') return '-';

            const k = key.toUpperCase();

            // Check if it's a date field
            const dateHeaders = ['FECHA DE VENCIMIENTO', 'FECHA PAGO', 'FECHA', 'DATE', 'VENCIMIENTO', 'VENC', 'PAGO'];
            const isDateHeader = dateHeaders.some(h => k.includes(h));

            if (isDateHeader) {
                // Handle ISO strings or strings that look like dates
                if (typeof val === 'string') {
                    const date = new Date(val);
                    if (!isNaN(date.getTime())) {
                        return date.toLocaleDateString('pt-BR'); // DD/MM/YYYY
                    }
                }
            }

            // Format numbers with currency if it's a value field
            const valueHeaders = ['VALOR', 'SALDO', 'PRECIO', 'COSTO', 'TOTAL', 'PRICE', 'AMOUNT'];
            if (valueHeaders.some(h => k.includes(h))) {
                const num = parseFloat(String(val).replace(/[^0-9.,-]/g, '').replace(',', '.'));
                if (!isNaN(num)) {
                    return '$ ' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            }

            return val;
        }

        function mgmt_renderGrid() {
            try {
                console.log('Rendering premium management table...');
                const grid = document.getElementById('mgmt-grid');
                if (!grid) throw new Error('Elemento mgmt-grid não encontrado');

                grid.innerHTML = '';

                if (mgmt_allData.length === 0) {
                    grid.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-24 glass-panel rounded-2xl border border-white/10">
                            <div class="text-[#D6A354] mb-4">
                                <svg class="w-12 h-12 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <div class="text-slate-400 font-light tracking-widest uppercase text-xs">Esperando Sincronización</div>
                        </div>
                    `;
                    setLoading(false);
                    return;
                }

                // Premium Sticky Header Table with Glassmorphism and widened layout
                const headerCells = mgmt_headers.map(h => {
                    return `
                        <th class="px-3 py-5 text-left">
                            <span class="font-bold text-[#D6A354] uppercase tracking-[0.12em] whitespace-nowrap text-[11px]">${h}</span>
                        </th>
                    `;
                }).join('');

                const rowHtml = mgmt_allData.map((row, rowIndex) => {
                    const rowCells = mgmt_headers.map((header) => {
                        const rawValue = row[header] || '';
                        const displayValue = mgmt_formatValue(header, rawValue);

                        // Specialized rendering for Document/Invoice column
                        if (header.toUpperCase().includes('DOCUME')) {
                            const hasDoc = rawValue && (rawValue.startsWith('http') || rawValue.includes('drive.google.com'));
                            return `
                                <td class="px-3 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        ${hasDoc ? `
                                            <a href="${rawValue}" target="_blank" 
                                               class="p-2 bg-blue-500/20 text-blue-400 rounded-full hover:bg-blue-500/40 transition-all duration-300"
                                               title="Ver Documento">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        ` : ''}
                                        <button onclick="mgmt_triggerUpload(${rowIndex}, '${header}')"
                                                class="p-2 ${hasDoc ? 'bg-white/10 text-white/40' : 'bg-[#D6A354]/20 text-[#D6A354]'} rounded-full hover:bg-[#D6A354]/40 hover:text-white transition-all duration-300"
                                                title="Subir Documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            `;
                        }

                        return `
                            <td class="px-3 py-4 text-white">
                                <div contenteditable="true" 
                                     class="outline-none focus:text-[#D6A354] focus:bg-white/10 px-2 py-1 rounded transition-all duration-300 border border-transparent focus:border-[#D6A354]/40 min-w-[50px] text-[14px]"
                                     onblur="mgmt_saveEdit(this, ${rowIndex}, '${header}')">${displayValue}</div>
                            </td>
                        `;
                    }).join('');

                    return `
                        <tr class="group hover:bg-white/[0.05] transition-colors duration-300">
                            ${rowCells}
                            <td class="px-4 py-4 text-center sticky right-0 bg-[#0b1d1b]/95 backdrop-blur-md border-l border-white/10">
                                <button onclick="mgmt_deleteRow(${rowIndex})" 
                                        class="opacity-60 group-hover:opacity-100 hover:bg-red-500/30 hover:text-red-400 p-2.5 rounded-full transition-all duration-300 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');

                const tableHTML = `
                    <div class="glass-panel rounded-2xl overflow-hidden border border-white/10 shadow-2xl transition-all duration-500 mx-auto max-w-full">
                        <div class="overflow-x-auto max-h-[750px] custom-scrollbar">
                            <table class="w-full text-[14px] border-collapse table-auto">
                                <thead class="sticky top-0 z-20 backdrop-blur-xl bg-[#0b1d1b] border-b border-white/10">
                                    <tr>
                                        ${headerCells}
                                        <th class="px-4 py-5 text-center sticky right-0 bg-[#0b1d1b] border-l border-white/10">
                                            <span class="font-bold text-[#D6A354] uppercase tracking-[0.12em] text-[12px]">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5 font-light tracking-wide">
                                    ${rowHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end mr-4">
                        <span class="text-white/40 text-[10px] uppercase tracking-widest font-bold">${mgmt_allData.length} Registros Procesados</span>
                    </div>
                `;

                grid.innerHTML = tableHTML;
                console.log('Premium luxury table rendered.');

            } catch (error) {
                console.error('Render error:', error);
                showToast('Error de diseño: ' + error.message, 'error');
            } finally {
                setLoading(false);
            }
        }

        async function mgmt_saveEdit(el, index, field) {
            const val = el.innerText;
            const cleanVal = val.replace('$', '').trim(); // Basic clean

            if (mgmt_allData[index][field] == cleanVal) return;

            mgmt_allData[index][field] = cleanVal;

            // Map field name to column index (Need robust mapping in production)
            // Simplified: Assuming 'Material' is col 1, 'Preco' is col 6 (check your sheet!)
            // Ideally pass full row object to GAS to handle mapping.

            await mgmt_syncBackend({
                action: 'update',
                rowIndex: index + 2,
                value: cleanVal,
                rowData: JSON.stringify(mgmt_allData[index])
            });
        }

        async function mgmt_deleteRow(index) {
            if (!confirm("¿Eliminar artículo?")) return;
            const rowData = mgmt_allData[index];
            mgmt_allData.splice(index, 1);
            mgmt_renderGrid();

            await mgmt_syncBackend({
                action: 'delete',
                rowIndex: index + 2,
                rowData: JSON.stringify(rowData)
            });
        }

        async function mgmt_syncBackend(payload) {
            showToast('Guardando...', 'info');
            try {
                const formData = new FormData();
                for (const k in payload) formData.append(k, payload[k]);

                const response = await fetch(API_URL, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include' // Pass authentication
                });

                const result = await response.json();
                if (result.error) throw new Error(result.error);

                showToast('¡Guardado!', 'success');
                return result;
            } catch (e) {
                console.error(e);
                showToast('Error al guardar: ' + e.message, 'error');
                throw e;
            }
        }

        // Upload Handlers
        let currentUploadContext = null;

        function mgmt_triggerUpload(rowIndex, colName) {
            currentUploadContext = { rowIndex, colName };
            const input = document.getElementById('mgmt-file-input');
            input.value = '';
            input.click();
        }

        async function mgmt_handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file || !currentUploadContext) return;

            setLoading(true);
            showToast('Subiendo archivo...', 'info');

            try {
                const reader = new FileReader();
                reader.onload = async (e) => {
                    const base64 = e.target.result.split(',')[1];
                    const payload = {
                        action: 'upload',
                        fileBase64: base64,
                        fileName: file.name,
                        mimeType: file.type,
                        rowIndex: currentUploadContext.rowIndex + 2,
                        colName: currentUploadContext.colName
                    };

                    const result = await mgmt_syncBackend(payload);
                    if (result.success && result.fileUrl) {
                        mgmt_allData[currentUploadContext.rowIndex][currentUploadContext.colName] = result.fileUrl;
                        mgmt_renderGrid();
                        showToast('¡Archivo subido con éxito!', 'success');
                    }
                };
                reader.readAsDataURL(file);
            } catch (error) {
                console.error('Upload error:', error);
                showToast('Error al subir archivo', 'error');
            } finally {
                setLoading(false);
            }
        }

        // Modal & Utils
        function mgmt_openModal() {
            const modal = document.getElementById('modal');
            const c = document.getElementById('modal-fields');
            c.innerHTML = mgmt_headers.map((h, i) => `
                <div><label class="block text-xs uppercase text-[#D6A354]">${h}</label><input id="new_f_${i}" class="w-full bg-[#0B1120] border border-white/20 p-2 text-white rounded"></div>
            `).join('');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.querySelector('.modal-bg').classList.remove('opacity-0');
                modal.querySelector('.modal-panel').classList.remove('opacity-0', 'translate-y-4');
            }, 10);
        }

        function mgmt_closeModal() {
            const modal = document.getElementById('modal');
            modal.querySelector('.modal-bg').classList.add('opacity-0');
            modal.querySelector('.modal-panel').classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        async function mgmt_submitNewRow() {
            const newObj = {};
            mgmt_headers.forEach((h, i) => newObj[h] = document.getElementById(`new_f_${i}`).value);

            mgmt_closeModal();
            mgmt_allData.push(newObj);
            mgmt_renderGrid();

            await mgmt_syncBackend({
                action: 'create',
                rowData: JSON.stringify(Object.values(newObj))
            });
        }

        function setLoading(b) {
            const luxuryProgress = document.getElementById('luxury-progress');
            const oldLoader = document.getElementById('loader');

            if (b) {
                luxuryProgress.classList.add('active');
                // Keep old loader hidden for cleaner experience
                oldLoader.classList.add('hidden');
            } else {
                luxuryProgress.classList.remove('active');
                oldLoader.classList.add('hidden');
            }
        }

        function showToast(msg, type) {
            const t = document.getElementById('toast');
            document.getElementById('toast-message').textContent = msg;
            if (type == 'error') t.style.borderLeftColor = '#ef4444';
            else t.style.borderLeftColor = '#D6A354';

            t.classList.remove('translate-x-40', 'opacity-0');
            setTimeout(() => t.classList.add('translate-x-40', 'opacity-0'), 3000);
        }

        // Init
        window.addEventListener('load', init);

    </script>
</body>

</html>