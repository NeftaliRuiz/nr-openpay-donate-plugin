<?php
/**
 * Plugin Name: Openpay Donaciones
 * Description: Donaciones con Openpay, panel de administración para claves y resumen de donativos.
 * Version: 1.2
 * Author: Neftalí Ruiz
 * Author URI: https://neft.com.mx
 */

// ============================================================================
// Seguridad: Evitar acceso directo al archivo
// ============================================================================
if (!defined('ABSPATH')) exit;

// ============================================================================
// Utilidad: Sanitizar descripciones para Openpay (ASCII, tamaño y caracteres válidos)
// ====================================================================================
if (!function_exists('nr_openpay_sanitize_description')) {
    function nr_openpay_sanitize_description($text) {
        // Remover etiquetas y espacios extremos
        $text = wp_strip_all_tags($text);
        $text = trim($text);
        // Quitar acentos/diacríticos
        if (function_exists('remove_accents')) {
            $text = remove_accents($text);
        }
        // Permitir solo letras/numeros/espacios y puntuación común segura
        // Permitidos: letra, número, espacio, punto, coma, guion, guion bajo, dos puntos, #, @, /
        $text = preg_replace('/[^A-Za-z0-9 \.,_:\-#@\/]*/', '', $text);
        // Colapsar espacios múltiples
        $text = preg_replace('/\s+/', ' ', $text);
        // Asegurar longitud razonable (p.ej. 140)
        if (strlen($text) > 140) {
            $text = substr($text, 0, 140);
        }
        // Fallback si queda vacío
        if ($text === '') {
            $text = 'Donacion';
        }
        return $text;
    }
}

// ============================================================================
// ACTIVACIÓN: Crear tabla de base de datos para donaciones
// ============================================================================
register_activation_hook(__FILE__, function(){
    global $wpdb;
    $table = $wpdb->prefix . 'openpay_donations';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        project VARCHAR(255) NOT NULL,
        donor_name VARCHAR(255) NOT NULL DEFAULT '',
        amount DECIMAL(10,2) NOT NULL,
        email VARCHAR(255) NOT NULL,
        session_id VARCHAR(255) DEFAULT '',
        status VARCHAR(50) DEFAULT '',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    ) $charset;";
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Migración: Agregar columna donor_name si no existe (para instalaciones existentes)
    $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $table LIKE 'donor_name'");
    if(empty($column_exists)){
        $wpdb->query("ALTER TABLE $table ADD donor_name VARCHAR(255) NOT NULL DEFAULT '' AFTER project");
    }
});

// ============================================================================
// FRONTEND: Cargar scripts y estilos en el sitio web
// ============================================================================
add_action('wp_enqueue_scripts', function(){
    wp_enqueue_script('nr-openpay-donate', plugin_dir_url(__FILE__).'js/openpay-donate.js', ['jquery'], '1.0', true);
    wp_enqueue_style('nr-openpay-donate', plugin_dir_url(__FILE__).'css/openpay-donate.css', [], '1.0');
    wp_localize_script('nr-openpay-donate','nrOpenpayDonate',[
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('nr_openpay_nonce'),
    ]);
});

// ============================================================================
// ADMIN: Cargar estilos en el panel de administración
// ============================================================================
add_action('admin_enqueue_scripts', function(){
    wp_enqueue_style('nr-openpay-admin', plugin_dir_url(__FILE__).'css/openpay-admin.css', [], '1.0');
});

// ============================================================================
// SHORTCODE: [openpay_donate] - Botón para abrir modal de donación
// ============================================================================
add_shortcode('openpay_donate', function($atts, $content = null){
    // Aceptar sinónimos en español y contenido como nombre de proyecto
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $atts = shortcode_atts([
        'project' => '',
        'proyecto' => '',
        'nombre' => '',
        'titulo' => ''
    ], $atts, 'openpay_donate');
    $project = $atts['project'] ?: $atts['proyecto'] ?: $atts['nombre'] ?: $atts['titulo'] ?: '';
    if ($project === '' && isset($content)) {
        $project = trim(wp_kses_post($content));
    }
    if ($project === '') { $project = 'Proyecto'; }

    // País y moneda
    $country  = get_option('nr_openpay_country', 'mx');
    $currency = ($country === 'co') ? 'COP' : 'MXN';

    static $modal_loaded = false;
    ob_start();
    
    // Obtener color primario del tema de WordPress
    $primary_color = get_theme_mod('custom_color_1', '#042e58');
    ?>
    <button 
        class="nr-donate-btn-open" 
        data-project="<?php echo esc_attr($project); ?>"
        style="background: <?php echo esc_attr($primary_color); ?>;"
    >
        Donar Ahora
    </button>

    <?php if(!$modal_loaded): $modal_loaded = true; ?>
    <!-- ========================================== -->
    <!-- MODAL: Ventana emergente para donaciones  -->
    <!-- ========================================== -->
    <div id="nr-openpay-modal" class="nr-openpay-modal">
        <div class="nr-openpay-modal-content">
            <button class="nr-openpay-modal-close">&times;</button>
            
            <!-- Header del Modal -->
            <div class="nr-openpay-header">
                <!-- <div class="nr-openpay-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                </div> -->
                <h2>Hacer una Donación</h2>
            </div>
            
            <!-- Formulario de Donación -->
            <div class="nr-openpay-form">
                <div class="nr-form-group">
                    <label>Proyecto:</label>
                    <div class="nr-project-display" id="nr-modal-project"></div>
                </div>

                <!-- Campo: Nombre -->
                <div class="nr-form-group">
                    <label for="nr-donate-name">Nombre completo</label>
                    <input 
                        type="text" 
                        id="nr-donate-name" 
                        class="nr-input"
                        required 
                    />
                    <small>Tu nombre para identificar la donación</small>
                </div>

                <!-- Campo: Email -->
                <div class="nr-form-group">
                    <label for="nr-donate-email">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="nr-donate-email" 
                        placeholder="tu@correo.com"
                        class="nr-input"
                        required 
                    />
                    <small>Tu correo para confirmación de donación</small>
                </div>

                <!-- Campo: Monto -->
                <div class="nr-form-group">
                    <label for="nr-donate-amount">Monto de donación (<?php echo esc_html($currency); ?>)</label>
                    <div class="nr-input-money">
                        <span class="nr-currency">$</span>
                        <input 
                            type="number" 
                            id="nr-donate-amount" 
                            min="1" 
                            step="<?php echo ($currency === 'COP') ? '1' : '0.01'; ?>" 
                            placeholder="<?php echo ($currency === 'COP') ? '0' : '0.00'; ?>"
                            class="nr-input"
                            required 
                        />
                    </div>
                    <small>Monto mínimo: $1.00 <?php echo esc_html($currency); ?></small>
                </div>

                <!-- Área de Mensajes -->
                <div id="nr-donate-message" class="nr-message"></div>

                <!-- Botón de Envío -->
                <button id="nr-donate-now" class="nr-btn-donate">
                    Continuar con Openpay
                </button>

                <!-- Footer de Seguridad -->
                <div class="nr-openpay-footer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4.5 8-10c0-4.418-3.582-8-8-8s-8 3.582-8 8c0 5.5 8 10 8 10z"/>
                        <circle cx="12" cy="11" r="3"/>
                    </svg>
                    <p>Pagos seguros procesados por Openpay</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
});

// ============================================================================
// AJAX: Crear sesión de pago en Openpay
// ============================================================================
add_action('wp_ajax_nopriv_nr_openpay_donate', 'nr_openpay_donate_create_session');
add_action('wp_ajax_nr_openpay_donate', 'nr_openpay_donate_create_session');

function nr_openpay_donate_create_session(){
    // Verificar seguridad (CSRF token)
    check_ajax_referer('nr_openpay_nonce','nonce');
    
    // Obtener datos del formulario
    global $wpdb;
    $project = isset($_POST['project']) ? sanitize_text_field($_POST['project']) : '';
    $amount  = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : 'Donante';

    // Validar datos
    if(!$project || $amount <= 0 || !$email || !$name){
        wp_send_json_error(['message'=>'Datos inválidos. Por favor completa todos los campos.']);
    }

    // Obtener credenciales de Openpay
    $merchant_id = get_option('nr_openpay_merchant_id','');
    $private_key = get_option('nr_openpay_private_key','');
    $mode = get_option('nr_openpay_mode','sandbox');
    $country = strtolower(get_option('nr_openpay_country','mx'));
    
    if(!$merchant_id || !$private_key){
        wp_send_json_error(['message'=>'Configuración de Openpay incompleta. Por favor configura Merchant ID y Private Key.']);
    }

    try {
        // Preparar la solicitud a Openpay
        // Usar directamente cURL en lugar de la SDK si no está instalada
        
        // Endpoint por país y modo
        if ($country === 'co') {
            $url = ($mode === 'production')
                ? 'https://api.openpay.co/v1/' . $merchant_id . '/checkouts'
                : 'https://sandbox-api.openpay.co/v1/' . $merchant_id . '/checkouts';
        } else {
            $url = ($mode === 'production')
                ? 'https://api.openpay.mx/v1/' . $merchant_id . '/checkouts'
                : 'https://sandbox-api.openpay.mx/v1/' . $merchant_id . '/checkouts';

        }

        // Normalizar monto y moneda según el país para evitar errores de decimales
        $currency = ($country === 'co') ? 'COP' : 'MXN';
        if ($currency === 'COP') {
            // Entero (sin decimales). Mantener como entero o string numérica segura
            $amount_clean = (int) round($amount);
        } else {
            // Cadena con exactamente 2 decimales para evitar imprecisiones de punto flotante
            // Calculamos en centavos y luego formateamos a string con 2 decimales
            $cents = (int) round($amount * 100);
            $amount_clean = number_format($cents / 100, 2, '.', ''); // string "xx.yy"
        }

    // Construir descripción compatible con Openpay (ASCII/longitud/charset)
        $description_raw = $project;
        $description = nr_openpay_sanitize_description($description_raw);

    // Sanitizar nombre SOLO para el payload de Openpay (mantener original para DB/reportes)
    $name_for_openpay = nr_openpay_sanitize_description($name);

        $sessionData = [
            'amount' => $amount_clean,
            'currency' => $currency,
            'description' => $description,
            'order_id' => 'donation_' . time() . '_' . rand(1000, 9999),
            'customer' => [
                'name' => $name_for_openpay,
                'email' => $email,
                'phone_number' => ''
            ],
            'redirect_url' => home_url('/gracias-por-donar/'),
        ];
        
        // Hacer solicitud a la API de Openpay
        $response = wp_remote_post($url, [
            'method' => 'POST',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($private_key . ':'),
                    'Content-Type' => 'application/json; charset=utf-8',
            ],
                // Usar codificación segura de WP y no escapar unicode
                'body' => wp_json_encode($sessionData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'timeout' => 30,
            'sslverify' => true,
        ]);
        
        // Verificar si hubo error en la conexión
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Error de conexión: ' . $response->get_error_message()]);
        }
        
        // Obtener el cuerpo de la respuesta
        $body = wp_remote_retrieve_body($response);
        $http_code = wp_remote_retrieve_response_code($response);
        
    // Decodificar JSON
    $result = json_decode($body, true);
        
        // Verificar respuesta
        if ($http_code !== 201 && $http_code !== 200) {
            $error_msg = isset($result['description']) ? $result['description'] : (isset($result['message']) ? $result['message'] : 'Error desconocido de Openpay');
            wp_send_json_error([
                'message' => 'Error de Openpay: ' . $error_msg . ' (Código: ' . $http_code . ')',
                'debug' => [
                    'http_code' => $http_code,
                    'response' => is_string($body) ? $body : json_encode($result)
                ]
            ]);
        }
        
        if (!is_array($result)) {
            wp_send_json_error(['message' => 'Respuesta inválida de Openpay. Verifica tus credenciales.', 'debug' => $body]);
        }
        
        // Buscar URL de pago en distintas claves posibles
        $session_url = null;
        if (isset($result['payment_url'])) {
            $session_url = $result['payment_url'];
        } elseif (isset($result['checkout_url'])) {
            $session_url = $result['checkout_url'];
        } elseif (isset($result['checkout_link'])) {
            $session_url = $result['checkout_link'];
        } elseif (isset($result['url'])) {
            $session_url = $result['url'];
        } elseif (isset($result['links']['checkout'])) {
            $session_url = $result['links']['checkout'];
        }
        
        if (!$session_url) {
            wp_send_json_error([
                'message' => 'Openpay no devolvió la URL de pago. Revisa tu configuración y permisos.',
                'debug' => $result
            ]);
        }

        // Guardar donación en base de datos
        $table = $wpdb->prefix . 'openpay_donations';
        $wpdb->insert($table,[
            'project'=>$project,
            'donor_name'=>$name,
            'amount'=>$amount_clean,
            'email'=>$email,
            'session_id'=> isset($result['id']) ? $result['id'] : '',
            'status'=>'created'
        ]);

        // Enviar URL de pago (normalizada)
        wp_send_json_success(['session_url' => $session_url]);

    } catch(Exception $e){
        wp_send_json_error(['message' => 'Error: ' . $e->getMessage()]);
    }
}

// ============================================================================
// ADMIN MENU: Agregar menú en panel de administración
// ============================================================================
add_action('admin_menu', function(){
    add_menu_page(
        'Openpay Donaciones',
        'Openpay Donaciones',
        'manage_options',
        'openpay_donations',
        'nr_openpay_admin_dashboard',
        plugin_dir_url(__FILE__) . 'assets/icons/donate-hand.svg',
        6
    );
    // Sobrescribir el primer submenú (que por defecto replica el título del menú principal)
    add_submenu_page(
        'openpay_donations',
        'Resumen Donaciones',
        'Resumen Donaciones',
        'manage_options',
        'openpay_donations',
        'nr_openpay_admin_dashboard'
    );
    add_submenu_page(
        'openpay_donations',
        'Configuración',
        'Configuración',
        'manage_options',
        'openpay_donations_settings',
        'nr_openpay_settings_page'
    );
});

// ============================================================================
// EXPORT: Manejar exportación a Excel (.xls) temprano para evitar HTML mezclado
// ============================================================================
add_action('admin_init', function(){
    if (!is_admin()) return;
    if (!isset($_GET['page']) || $_GET['page'] !== 'openpay_donations') return;
    if (!isset($_GET['export']) || !in_array($_GET['export'], ['excel','xls','xlsx','csv'], true)) return;

    global $wpdb;
    $table = $wpdb->prefix . 'openpay_donations';
    $country = get_option('nr_openpay_country','mx');
    $currency = ($country === 'co') ? 'COP' : 'MXN';

    // Filtros (mismos que en el dashboard, sin montos por ahora)
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $filter_type = isset($_GET['filter_type']) ? sanitize_text_field($_GET['filter_type']) : 'all';
    $date_from = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
    $date_to = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';

    $where_clauses = [];
    if (!empty($search)) {
        if ($filter_type === 'donor') {
            $where_clauses[] = $wpdb->prepare("donor_name LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        } elseif ($filter_type === 'project') {
            $where_clauses[] = $wpdb->prepare("project LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        } else {
            $where_clauses[] = $wpdb->prepare(
                "(donor_name LIKE %s OR project LIKE %s)",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        }
    }
    if (!empty($date_from)) {
        $where_clauses[] = $wpdb->prepare("DATE(created_at) >= %s", $date_from);
    }
    if (!empty($date_to)) {
        $where_clauses[] = $wpdb->prepare("DATE(created_at) <= %s", $date_to);
    }
    $where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

    // Obtener filas filtradas
    $rows = $wpdb->get_results("SELECT * FROM $table $where_sql ORDER BY created_at DESC", ARRAY_A);

    // Encabezados para CSV (Excel lo abre perfectamente)
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="donaciones_' . date('Ymd_His') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Salida CSV compatible (Excel abrirá .xlsx con este MIME)
    $out = fopen('php://output', 'w');
    // BOM para UTF-8
    fprintf($out, "%s", "\xEF\xBB\xBF");
    
    // Título del reporte
    fputcsv($out, ['REPORTE DE DONACIONES - ' . date('d/m/Y H:i')]);
    fputcsv($out, []);
    
    // Encabezados con estilo (en mayúsculas)
    fputcsv($out, ['FECHA', 'PROYECTO', 'DONANTE', 'EMAIL', 'MONTO', 'MONEDA', 'ESTADO']);
    
    $total_periodo = 0.0;
    $count = 0;
    foreach ($rows as $r) {
        $fecha = isset($r['created_at']) ? date('Y-m-d H:i', strtotime($r['created_at'])) : '';
        $proy = isset($r['project']) ? $r['project'] : '';
        $donor = isset($r['donor_name']) ? $r['donor_name'] : 'Anónimo';
        $email = isset($r['email']) ? $r['email'] : '';
        $monto_float = isset($r['amount']) ? (float)$r['amount'] : 0.0;
        $amount = number_format($monto_float, 2, '.', '');
        $estado = isset($r['status']) ? ucfirst($r['status']) : '';
        $total_periodo += $monto_float;
        $count++;
        fputcsv($out, [$fecha, $proy, $donor, $email, $amount, $currency, $estado]);
    }
    
    // Separador y totales
    fputcsv($out, []);
    fputcsv($out, ['', '', '', 'TOTAL DONACIONES:', $count, '', '']);
    fputcsv($out, ['', '', '', 'MONTO TOTAL:', number_format($total_periodo, 2, '.', ''), $currency, '']);
    fclose($out);
    exit;
});

// ============================================================================
// PÁGINA: Configuración de credenciales de Openpay
// ============================================================================
function nr_openpay_settings_page(){
    // Guardar configuración si se envía el formulario
    if(isset($_POST['nr_openpay_save'])) {
        check_admin_referer('nr_openpay_settings_nonce');
        update_option('nr_openpay_merchant_id', sanitize_text_field($_POST['merchant_id']));
        update_option('nr_openpay_private_key', sanitize_text_field($_POST['private_key']));
        update_option('nr_openpay_mode', sanitize_text_field($_POST['mode']));
        if (isset($_POST['country'])) {
            update_option('nr_openpay_country', sanitize_text_field($_POST['country']));
        }
        echo '<div class="nr-notice nr-notice-success"><p>✓ Configuración guardada correctamente.</p></div>';
    }

    // Obtener valores guardados
    $merchant_id = get_option('nr_openpay_merchant_id','');
    $private_key = get_option('nr_openpay_private_key','');
    $mode = get_option('nr_openpay_mode','sandbox');
    $country = get_option('nr_openpay_country','mx');
    ?>
    <div class="nr-admin-container">
        <div class="nr-admin-header">
            <h1>Configuración de Openpay </h1>
            <p class="nr-subtitle">Gestiona tus credenciales de pago seguro</p>
        </div>

        <!-- Formulario de Configuración -->
        <form method="post" class="nr-settings-form">
            <?php wp_nonce_field('nr_openpay_settings_nonce'); ?>
            
            <div class="nr-settings-card">
                <!-- Campo: Identificador de comercio (ID) -->
                <div class="nr-form-group">
                    <label for="merchant_id">Identificador de comercio (ID)</label>
                    <input 
                        type="text" 
                        id="merchant_id"
                        name="merchant_id" 
                        value="<?php echo esc_attr($merchant_id); ?>" 
                        class="nr-input-field"
                        placeholder="Tu Identificador de comercio (ID) de Openpay"
                        required
                    />
                    <small>Encuentra esto en tu panel de Openpay</small>
                </div>

                <!-- Campo: Private Key -->
                <div class="nr-form-group">
                    <label for="private_key">Private Key</label>
                    <input 
                        type="password" 
                        id="private_key"
                        name="private_key" 
                        value="<?php echo esc_attr($private_key); ?>" 
                        class="nr-input-field"
                        placeholder="Tu Private Key de Openpay"
                        required
                    />
                    <small>Mantén esto seguro y nunca lo compartas</small>
                </div>

                <!-- Campo: Modo de Operación -->
                <div class="nr-form-group">
                    <label for="mode">Modo de Operación</label>
                    <select name="mode" id="mode" class="nr-select-field">
                        <option value="sandbox" <?php selected($mode,'sandbox'); ?>>Sandbox (Pruebas)</option>
                        <option value="production" <?php selected($mode,'production'); ?>>Producción (En vivo)</option>
                    </select>
                    <small>En Sandbox puedes probar sin cobrar. En Producción se realizarán pagos reales.</small>
                </div>

                <!-- Campo: País -->
                <div class="nr-form-group">
                    <label for="country">País</label>
                    <select name="country" id="country" class="nr-select-field">
                        <option value="mx" <?php selected($country,'mx'); ?>>México (MXN)</option>
                        <option value="co" <?php selected($country,'co'); ?>>Colombia (COP)</option>
                    </select>
                    <small>Selecciona el país en el que operas con Openpay.</small>
                </div>
            </div>

            <!-- Botón de Guardar -->
            <div class="nr-form-actions">
                <button type="submit" name="nr_openpay_save" class="nr-btn-primary">
                    Guardar Configuración
                </button>
            </div>
        </form>

        <!-- Caja de Ayuda -->
        <div class="nr-info-box">
            <h3>¿Cómo obtener tus credenciales?</h3>
            <p><strong>Paso 1:</strong> Crea una cuenta en <a href="https://www.openpay.mx/" target="_blank">openpay.mx</a></p>
            <p><strong>Paso 2:</strong> Ve a tu panel de Openpay → Configuración → API Keys</p>
            <p><strong>Paso 3:</strong> Copia:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Identificador de comercio (ID):</strong> Lo encuentras como "Identificador de comercio (ID)" o "Merchant ID"</li>
                <li><strong>Private Key:</strong> La clave privada (comienza con "sk_")</li>
            </ul>
            <p><strong>Paso 4:</strong> Pega el cuadro de texto del formulario y guarda</p>
            
            <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
            
            <h3>Solución de Problemas</h3>
            <p><strong>Si te da error "No se pudo conectar al servidor":</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>✓ Verifica que el Identificador de comercio (ID) esté correctamente copiado</li>
                <li>✓ Verifica que la Private Key esté correctamente copiada (sin espacios)</li>
                <li>✓ Asegúrate de usar la Private Key, no la Public Key</li>
                <li>✓ Si está en Sandbox, usa credenciales de sandbox</li>
                <li>✓ Si está en Producción, usa credenciales de producción</li>
                <li>✓ Comprueba que tu servidor tenga acceso a internet</li>
            </ul>
        </div>
    </div>
    <?php
}

// ============================================================================
// PANEL: Dashboard con resumen y historial de donaciones
// ============================================================================
function nr_openpay_admin_dashboard(){
    global $wpdb;
    $table = $wpdb->prefix . 'openpay_donations';
    $country = get_option('nr_openpay_country','mx');
    $currency = ($country === 'co') ? 'COP' : 'MXN';
    
    // Filtros de búsqueda
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $filter_type = isset($_GET['filter_type']) ? sanitize_text_field($_GET['filter_type']) : 'all';
    $date_from = isset($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
    $date_to = isset($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';
    // $amount_min = isset($_GET['amount_min']) ? floatval($_GET['amount_min']) : '';
    // $amount_max = isset($_GET['amount_max']) ? floatval($_GET['amount_max']) : '';
    
    // Construir query con filtros
    $where_clauses = [];
    
    // Filtro de texto (donante/proyecto)
    if (!empty($search)) {
        if ($filter_type === 'donor') {
            $where_clauses[] = $wpdb->prepare("donor_name LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        } elseif ($filter_type === 'project') {
            $where_clauses[] = $wpdb->prepare("project LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        } else {
            // Buscar en ambos campos
            $where_clauses[] = $wpdb->prepare(
                "(donor_name LIKE %s OR project LIKE %s)",
                '%' . $wpdb->esc_like($search) . '%',
                '%' . $wpdb->esc_like($search) . '%'
            );
        }
    }
    
    // Filtro de fecha desde
    if (!empty($date_from)) {
        $where_clauses[] = $wpdb->prepare("DATE(created_at) >= %s", $date_from);
    }
    
    // Filtro de fecha hasta
    if (!empty($date_to)) {
        $where_clauses[] = $wpdb->prepare("DATE(created_at) <= %s", $date_to);
    }
    
    // Filtros de monto deshabilitados temporalmente
    // if ($amount_min !== '' && $amount_min > 0) {
    //     $where_clauses[] = $wpdb->prepare("amount >= %f", $amount_min);
    // }
    // if ($amount_max !== '' && $amount_max > 0) {
    //     $where_clauses[] = $wpdb->prepare("amount <= %f", $amount_max);
    // }
    
    $where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

    // Exportación movida a admin_init para evitar HTML mezclado antes de cabeceras

    // Paginación
    $per_page = isset($_GET['per_page']) ? max(1, intval($_GET['per_page'])) : 20;
    $paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $offset = ($paged - 1) * $per_page;

    // Total filtrado para paginación
    $total_filtered = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table $where_sql");
    $total_pages = max(1, (int) ceil($total_filtered / $per_page));

    // Obtener donaciones filtradas (paginadas)
    $donations = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table $where_sql ORDER BY created_at DESC LIMIT %d OFFSET %d",
        $per_page, $offset
    ));
    
    // Calcular estadísticas (siempre totales, no filtradas)
    $total_donations = $wpdb->get_var("SELECT COUNT(*) FROM $table");
    $total_amount = $wpdb->get_var("SELECT SUM(amount) FROM $table");
    $total_amount = $total_amount ? number_format($total_amount, 2) : '0.00';
    ?>
    <div class="nr-admin-container">
        <!-- Header del Dashboard -->
        <div class="nr-admin-header">
            <h1>Resumen de Donaciones</h1>
            <p class="nr-subtitle">Historial completo de todas tus donaciones recibidas</p>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="nr-stats-grid">
            <!-- Stat: Monto Total -->
            <div class="nr-stat-card">
                <div class="nr-stat-content">
                    <h3>Monto Total</h3>
                    <p class="nr-stat-value">$<?php echo esc_html($total_amount); ?> <?php echo esc_html($currency); ?></p>
                </div>
            </div>
            
            <!-- Stat: Total de Donaciones -->
            <div class="nr-stat-card">
                <div class="nr-stat-content">
                    <h3>Total de Donaciones</h3>
                    <p class="nr-stat-value"><?php echo esc_html($total_donations); ?></p>
                </div>
            </div>
        </div>

        <!-- Tabla de Historial -->
        <div class="nr-table-container">
            <div class="nr-table-header">
                <div>
                    <h2>Historial de Donaciones</h2>
                    <?php if(!empty($donations)): ?>
                        <p class="nr-table-info"><?php echo count($donations); ?> donaciones<?php echo !empty($search) ? ' encontradas' : ' en esta página'; ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filtros de Búsqueda -->
            <div class="nr-search-filters" style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                <form method="get" action="" style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                    <input type="hidden" name="page" value="openpay_donations" />
                    
                    <!-- Búsqueda por texto -->
                    <div style="flex: 1; min-width: 200px;">
                        <label for="search" style="display: block; margin-bottom: 5px; font-weight: 500;">Buscar:</label>
                        <input 
                            type="text" 
                            id="search" 
                            name="search" 
                            value="<?php echo esc_attr($search); ?>" 
                            placeholder="Nombre o proyecto..."
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        />
                    </div>
                    
                    <div style="min-width: 150px;">
                        <label for="filter_type" style="display: block; margin-bottom: 5px; font-weight: 500;">Filtrar por:</label>
                        <select 
                            id="filter_type" 
                            name="filter_type" 
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        >
                            <option value="all" <?php selected($filter_type, 'all'); ?>>Todo</option>
                            <option value="donor" <?php selected($filter_type, 'donor'); ?>>Donante</option>
                            <option value="project" <?php selected($filter_type, 'project'); ?>>Proyecto</option>
                        </select>
                    </div>
                    
                    <!-- Filtro de fecha -->
                    <div style="min-width: 140px;">
                        <label for="date_from" style="display: block; margin-bottom: 5px; font-weight: 500;">Desde:</label>
                        <input 
                            type="date" 
                            id="date_from" 
                            name="date_from" 
                            value="<?php echo esc_attr($date_from); ?>"
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        />
                    </div>
                    
                    <div style="min-width: 140px;">
                        <label for="date_to" style="display: block; margin-bottom: 5px; font-weight: 500;">Hasta:</label>
                        <input 
                            type="date" 
                            id="date_to" 
                            name="date_to" 
                            value="<?php echo esc_attr($date_to); ?>"
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        />
                    </div>
                    
                    <!-- Filtro de monto (deshabilitado temporalmente)
                    <div style="min-width: 120px;">
                        <label for="amount_min" style="display: block; margin-bottom: 5px; font-weight: 500;">Monto mín:</label>
                        <input 
                            type="number" 
                            id="amount_min" 
                            name="amount_min" 
                            value="<?php echo esc_attr($amount_min); ?>"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        />
                    </div>
                    
                    <div style="min-width: 120px;">
                        <label for="amount_max" style="display: block; margin-bottom: 5px; font-weight: 500;">Monto máx:</label>
                        <input 
                            type="number" 
                            id="amount_max" 
                            name="amount_max" 
                            value="<?php echo esc_attr($amount_max); ?>"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                        />
                    </div>
                    -->
                    
                    <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <button 
                            type="submit" 
                            style="padding: 8px 16px; background: #0073aa; color: #fff; border: none; border-radius: 4px; cursor: pointer;"
                        >
                            Buscar
                        </button>
                        <button 
                            type="submit" 
                            name="export" 
                            value="csv" 
                            style="padding: 8px 16px; background: #10b981; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);"
                            title="Exportar resultados a CSV (compatible con Excel)"
                        >
                            Exportar Excel
                        </button>
                        <?php if(!empty($search) || !empty($date_from) || !empty($date_to) ): ?>
                            <a 
                                href="?page=openpay_donations" 
                                style="padding: 8px 16px; background: #ddd; color: #333; text-decoration: none; border-radius: 4px; display: inline-block;"
                            >
                                Limpiar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if($donations): ?>
                <!-- Tabla de Donaciones (compacta por columnas) -->
                <table class="widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Donante</th>
                            <th>Email</th>
                            <th style="text-align:right;">Monto (<?php echo esc_html($currency); ?>)</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($donations as $d): ?>
                            <tr>
                                <td><?php echo esc_html(date('Y-m-d H:i', strtotime($d->created_at))); ?></td>
                                <td><?php echo esc_html($d->project); ?></td>
                                <td><?php echo esc_html($d->donor_name ?: 'Anónimo'); ?></td>
                                <td><?php echo esc_html($d->email); ?></td>
                                <td style="text-align:right;"><strong>$<?php echo number_format($d->amount, 2); ?></strong></td>
                                <td>
                                    <span class="nr-status-badge <?php echo esc_attr(strtolower($d->status)); ?>">
                                        <?php echo esc_html(ucfirst($d->status)); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <?php if ($total_pages > 1): ?>
                    <div class="tablenav">
                        <div class="tablenav-pages" style="margin-top: 10px;">
                            <?php
                            $base_args = [
                                'page' => 'openpay_donations',
                                'search' => $search,
                                'filter_type' => $filter_type,
                                'date_from' => $date_from,
                                'date_to' => $date_to,
                                'per_page' => $per_page,
                            ];
                            $page_link = function($p) use ($base_args) {
                                $args = array_merge($base_args, ['paged' => $p]);
                                return esc_url(add_query_arg(array_filter($args, fn($v) => $v !== '' && $v !== null)));
                            };
                            ?>
                            <span class="displaying-num"><?php echo esc_html($total_filtered); ?> donaciones</span>
                            <span class="pagination-links">
                                <?php if ($paged > 1): ?>
                                    <a class="prev-page" href="<?php echo $page_link($paged - 1); ?>">«</a>
                                <?php else: ?>
                                    <span class="tablenav-pages-navspan">«</span>
                                <?php endif; ?>
                                <span class="paging-input">Página <?php echo esc_html($paged); ?> de <span class="total-pages"><?php echo esc_html($total_pages); ?></span></span>
                                <?php if ($paged < $total_pages): ?>
                                    <a class="next-page" href="<?php echo $page_link($paged + 1); ?>">»</a>
                                <?php else: ?>
                                    <span class="tablenav-pages-navspan">»</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Estado Vacío -->
                <div class="nr-empty-state">
                    <div class="nr-empty-icon">📭</div>
                    <?php if(!empty($search)): ?>
                        <h3>No se encontraron resultados</h3>
                        <p>No hay donaciones que coincidan con tu búsqueda.</p>
                        <a href="?page=openpay_donations" class="nr-btn-reset">← Ver todas las donaciones</a>
                    <?php else: ?>
                        <h3>No hay donaciones registradas</h3>
                        <p>Las donaciones aparecerán aquí cuando se realicen a través de tu sitio web.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
