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
// ACTIVACIÓN: Crear tabla de base de datos para donaciones
// ============================================================================
register_activation_hook(__FILE__, function(){
    global $wpdb;
    $table = $wpdb->prefix . 'openpay_donations';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        project VARCHAR(255) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        email VARCHAR(255) NOT NULL,
        session_id VARCHAR(255) DEFAULT '',
        status VARCHAR(50) DEFAULT '',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    ) $charset;";
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
});

// ============================================================================
// FRONTEND: Cargar scripts y estilos en el sitio web
// ============================================================================
add_action('wp_enqueue_scripts', function(){
    wp_enqueue_script('nr-openpay-donate', plugin_dir_url(__FILE__).'js/openpay-donate.js', ['jquery'], '1.0', true);
    wp_enqueue_style('nr-openpay-donate', plugin_dir_url(__FILE__).'css/openpay-donate.css', [], '1.0');
    wp_localize_script('nr-openpay-donate','nrOpenpayDonate',[
        'ajax_url'=>admin_url('admin-ajax.php'),
        'nonce'=>wp_create_nonce('nr_openpay_nonce')
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
add_shortcode('openpay_donate', function($atts){
    $atts = shortcode_atts(['project'=>'Proyecto'], $atts, 'openpay_donate');
    static $modal_loaded = false;
    ob_start();
    
    // Obtener color primario del tema de WordPress
    $primary_color = get_theme_mod('custom_color_1', '#042e58');
    ?>
    <button 
        class="nr-donate-btn-open" 
        data-project="<?php echo esc_attr($atts['project']); ?>"
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
                <div class="nr-openpay-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h2>Hacer una Donación</h2>
            </div>
            
            <!-- Formulario de Donación -->
            <div class="nr-openpay-form">
                <div class="nr-form-group">
                    <label>Proyecto:</label>
                    <div class="nr-project-display" id="nr-modal-project"><?php echo esc_html($atts['project']); ?></div>
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
                    <label for="nr-donate-amount">Monto de donación (MXN)</label>
                    <div class="nr-input-money">
                        <span class="nr-currency">$</span>
                        <input 
                            type="number" 
                            id="nr-donate-amount" 
                            min="1" 
                            step="0.01" 
                            placeholder="0.00"
                            class="nr-input"
                            required 
                        />
                    </div>
                    <small>Monto mínimo: $1.00 MXN</small>
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

    // Validar datos
    if(!$project || $amount <= 0 || !$email){
        wp_send_json_error(['message'=>'Datos inválidos']);
    }

    // Obtener credenciales de Openpay
    $merchant_id = get_option('nr_openpay_merchant_id','');
    $private_key = get_option('nr_openpay_private_key','');
    $mode = get_option('nr_openpay_mode','sandbox');
    
    if(!$merchant_id || !$private_key){
        wp_send_json_error(['message'=>'Configuración de Openpay incompleta. Por favor configura Merchant ID y Private Key.']);
    }

    try {
        // Preparar la solicitud a Openpay
        // Usar directamente cURL en lugar de la SDK si no está instalada
        
        $url = $mode === 'production' 
            ? 'https://api.openpay.mx/v1/' . $merchant_id . '/checkout'
            : 'https://sandbox-api.openpay.mx/v1/' . $merchant_id . '/checkout';
        
        $sessionData = [
            'amount' => $amount,
            'currency' => 'MXN',
            'description' => 'Donación para: ' . $project,
            'order_id' => 'donation_' . time() . '_' . rand(1000, 9999),
            'customer' => [
                'name' => 'Donante',
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
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($sessionData),
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
            $error_msg = isset($result['description']) ? $result['description'] : 'Error desconocido de Openpay';
            wp_send_json_error(['message' => 'Error de Openpay: ' . $error_msg . ' (Código: ' . $http_code . ')']);
        }
        
        if (!isset($result['id'])) {
            wp_send_json_error(['message' => 'Respuesta inválida de Openpay. Verifica tus credenciales.']);
        }

        // Guardar donación en base de datos
        $table = $wpdb->prefix . 'openpay_donations';
        $wpdb->insert($table,[
            'project'=>$project,
            'amount'=>$amount,
            'email'=>$email,
            'session_id'=>$result['id'],
            'status'=>'created'
        ]);

        // Enviar URL de pago
        wp_send_json_success(['session_url' => $result['payment_url']]);

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
        'dashicons-heart',
        6
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
// PÁGINA: Configuración de credenciales de Openpay
// ============================================================================
function nr_openpay_settings_page(){
    // Guardar configuración si se envía el formulario
    if(isset($_POST['nr_openpay_save'])) {
        check_admin_referer('nr_openpay_settings_nonce');
        update_option('nr_openpay_merchant_id', sanitize_text_field($_POST['merchant_id']));
        update_option('nr_openpay_private_key', sanitize_text_field($_POST['private_key']));
        update_option('nr_openpay_mode', sanitize_text_field($_POST['mode']));
        echo '<div class="nr-notice nr-notice-success"><p>✓ Configuración guardada correctamente.</p></div>';
    }

    // Obtener valores guardados
    $merchant_id = get_option('nr_openpay_merchant_id','');
    $private_key = get_option('nr_openpay_private_key','');
    $mode = get_option('nr_openpay_mode','sandbox');
    ?>
    <div class="nr-admin-container">
        <div class="nr-admin-header">
            <h1>Configuración de Openpay</h1>
            <p class="nr-subtitle">Gestiona tus credenciales de pago seguro</p>
        </div>

        <!-- Formulario de Configuración -->
        <form method="post" class="nr-settings-form">
            <?php wp_nonce_field('nr_openpay_settings_nonce'); ?>
            
            <div class="nr-settings-card">
                <!-- Campo: Merchant ID -->
                <div class="nr-form-group">
                    <label for="merchant_id">Merchant ID</label>
                    <input 
                        type="text" 
                        id="merchant_id"
                        name="merchant_id" 
                        value="<?php echo esc_attr($merchant_id); ?>" 
                        class="nr-input-field"
                        placeholder="Tu Merchant ID de Openpay"
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
            <h3>❓ ¿Cómo obtener tus credenciales?</h3>
            <p><strong>Paso 1:</strong> Crea una cuenta en <a href="https://www.openpay.mx/" target="_blank">openpay.mx</a></p>
            <p><strong>Paso 2:</strong> Ve a tu panel de Openpay → Configuración → API Keys</p>
            <p><strong>Paso 3:</strong> Copia:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Merchant ID:</strong> Lo encuentras como "Merchant ID"</li>
                <li><strong>Private Key:</strong> La clave privada (comienza con "sk_")</li>
            </ul>
            <p><strong>Paso 4:</strong> Pega aquí y guarda</p>
            
            <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
            
            <h3>⚠️ Solución de Problemas</h3>
            <p><strong>Si te da error "No se pudo conectar al servidor":</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>✓ Verifica que el Merchant ID esté correctamente copiado</li>
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
    
    // Obtener todas las donaciones
    $donations = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
    
    // Calcular estadísticas
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
                <div class="nr-stat-icon">💰</div>
                <div class="nr-stat-content">
                    <h3>Monto Total</h3>
                    <p class="nr-stat-value">$<?php echo esc_html($total_amount); ?> MXN</p>
                </div>
            </div>
            
            <!-- Stat: Total de Donaciones -->
            <div class="nr-stat-card">
                <div class="nr-stat-icon">🎁</div>
                <div class="nr-stat-content">
                    <h3>Total de Donaciones</h3>
                    <p class="nr-stat-value"><?php echo esc_html($total_donations); ?></p>
                </div>
            </div>
        </div>

        <!-- Tabla de Historial -->
        <div class="nr-table-container">
            <div class="nr-table-header">
                <h2>Historial de Donaciones</h2>
                <?php if(!empty($donations)): ?>
                    <p class="nr-table-info"><?php echo count($donations); ?> donaciones registradas</p>
                <?php endif; ?>
            </div>

            <?php if($donations): ?>
                <!-- Lista de Donaciones -->
                <div class="nr-donations-list">
                    <?php foreach($donations as $d): ?>
                        <!-- Item: Donación Individual -->
                        <div class="nr-donation-item">
                            <!-- Información Izquierda -->
                            <div class="nr-donation-left">
                                <div class="nr-donation-project">
                                    <span class="nr-label">Proyecto:</span>
                                    <span class="nr-value"><?php echo esc_html($d->project); ?></span>
                                </div>
                                <div class="nr-donation-email">
                                    <span class="nr-label">Email:</span>
                                    <span class="nr-value"><?php echo esc_html($d->email); ?></span>
                                </div>
                            </div>
                            
                            <!-- Información Derecha -->
                            <div class="nr-donation-right">
                                <div class="nr-donation-amount">
                                    <span class="nr-amount">$<?php echo number_format($d->amount, 2); ?></span>
                                    <span class="nr-currency">MXN</span>
                                </div>
                                <div class="nr-donation-status">
                                    <span class="nr-status nr-status-<?php echo esc_attr($d->status); ?>">
                                        <?php echo esc_html(ucfirst($d->status)); ?>
                                    </span>
                                    <span class="nr-date"><?php echo esc_html(date('d/m/Y', strtotime($d->created_at))); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Estado Vacío -->
                <div class="nr-empty-state">
                    <div class="nr-empty-icon">📭</div>
                    <h3>Sin donaciones aún</h3>
                    <p>Las donaciones aparecerán aquí cuando se realicen a través de tu sitio web.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
