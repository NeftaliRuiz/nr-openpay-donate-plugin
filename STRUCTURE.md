# Estructura del Proyecto

## 📁 Directorios y Archivos

```
openpay-donate-plugin-admin/
│
├── openpay-donate-plugin.php          # Archivo principal del plugin
├── README.md                           # Documentación principal
├── CUSTOMIZATION.md                    # Guía de personalización
├── EXAMPLES.md                         # Ejemplos de uso
├── CHANGELOG.md                        # Historial de cambios
├── FAQ.md                              # Preguntas frecuentes
├── STRUCTURE.md                        # Este archivo
│
├── js/                                 # JavaScript
│   └── openpay-donate.js              # Lógica del formulario frontend
│
└── css/                                # Estilos CSS
    ├── openpay-donate.css             # Estilos del formulario
    └── openpay-admin.css              # Estilos del panel admin
```

## 📄 Descripción de Archivos

### openpay-donate-plugin.php (208 líneas)
Archivo principal del plugin. Contiene:

**Funciones principales:**
- `register_activation_hook()` - Crea tabla de BD
- `add_action('wp_enqueue_scripts')` - Carga assets frontend
- `add_action('admin_enqueue_scripts')` - Carga assets admin
- `add_shortcode('openpay_donate')` - Define shortcode
- `nr_openpay_donate_create_session()` - Crea sesión en Openpay
- `nr_openpay_admin_dashboard()` - Panel principal
- `nr_openpay_settings_page()` - Página de configuración

**Hooks:**
- `wp_enqueue_scripts` - Cargar JS/CSS frontend
- `admin_enqueue_scripts` - Cargar CSS admin
- `admin_menu` - Agregar menús admin
- `wp_ajax_nopriv_nr_openpay_donate` - AJAX público
- `wp_ajax_nr_openpay_donate` - AJAX autenticado

### js/openpay-donate.js (60+ líneas)
Lógica del formulario de donaciones:

**Características:**
- Validación de formulario
- Verificación de email
- Envío AJAX
- Manejo de errores
- Feedback del usuario
- Estados de carga

**Funciones:**
- `isValidEmail()` - Valida formato de email
- `showMessage()` - Muestra mensajes
- `resetButton()` - Restaura botón

### css/openpay-donate.css (280+ líneas)
Estilos del formulario frontend:

**Componentes:**
- `.nr-openpay-donate-container` - Contenedor
- `.nr-openpay-donate` - Card principal
- `.nr-openpay-header` - Header con gradiente
- `.nr-openpay-form` - Área del formulario
- `.nr-form-group` - Grupos de input
- `.nr-input` - Campos de input
- `.nr-input-money` - Input con símbolo $
- `.nr-btn-donate` - Botón de donación
- `.nr-message` - Mensajes de error/éxito
- `.nr-openpay-footer` - Footer con icono

**Responsive:**
- `@media (max-width: 480px)` - Móviles
- Diseño fluido

### css/openpay-admin.css (400+ líneas)
Estilos del panel de administración:

**Variables CSS:**
- `--color-primary` - Azul principal
- `--color-success` - Verde
- `--color-error` - Rojo
- `--color-border` - Bordes

**Componentes:**
- `.nr-admin-container` - Contenedor
- `.nr-admin-header` - Header con gradiente
- `.nr-settings-form` - Formulario de configuración
- `.nr-stats-grid` - Grid de estadísticas
- `.nr-stat-card` - Tarjeta de estadística
- `.nr-table-container` - Contenedor de tabla
- `.nr-donations-list` - Lista de donaciones
- `.nr-donation-item` - Item de donación
- `.nr-status` - Estados coloreados
- `.nr-empty-state` - Estado vacío

**Responsive:**
- `@media (max-width: 768px)` - Tablets
- `@media (max-width: 480px)` - Móviles

### README.md
Documentación principal con:
- Descripción del proyecto
- Características
- Instrucciones de instalación
- Configuración paso a paso
- Uso del shortcode
- Descripción del panel
- Seguridad
- Estructura de BD
- Personalización básica
- Troubleshooting
- Changelog

### CUSTOMIZATION.md
Guía de personalización con:
- Cambiar colores
- Cambiar textos
- Modificar tamaños
- Personalizar header
- Cambiar iconos
- Estilos de botón
- Tablas
- Ejemplos prácticos

### EXAMPLES.md
Ejemplos prácticos con:
- Instalación rápida
- Ejemplos de shortcodes
- Casos de uso reales
- Sandbox vs Producción
- Panel de control
- Estados posibles
- Mejores prácticas
- Flujo de donación
- Personalizar experiencia

### CHANGELOG.md
Historial de versiones:
- v1.2 - Rediseño completo
- v1.1 - Funcionalidad base
- v1.0 - Versión inicial
- Roadmap futuro
- Bugs arreglados

### FAQ.md
Preguntas frecuentes:
- Instalación y configuración
- Uso del plugin
- Seguridad
- Pagos y dinero
- Personalización
- Solución de problemas
- Panel de administración
- Actualizaciones

---

## 🔄 Flujo de Archivos

### Frontend (Usuario visitante)
```
1. Usuario accede a página
2. Navegador carga openpay-donate.js
3. Navegador carga openpay-donate.css
4. Shortcode renderiza formulario
5. Usuario completa y envía
6. JS valida y envía AJAX
7. Plugin procesa en backend
```

### Backend (PHP)
```
1. AJAX request llega a wp_ajax_nr_openpay_donate
2. Se validan nonce y datos
3. Se conecta a API de Openpay
4. Se crea sesión de pago
5. Se guarda en BD
6. Se envía URL de pago
7. Usuario es redirigido
```

### Admin (Panel WordPress)
```
1. Admin accede a Openpay Donaciones
2. Navegador carga openpay-admin.css
3. PHP genera HTML del dashboard
4. Se obtienen datos de BD
5. Se calculan estadísticas
6. Se renderiza tabla
7. Admin ve historial
```

---

## 🗄️ Base de Datos

### Tabla: wp_openpay_donations

```sql
CREATE TABLE wp_openpay_donations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    email VARCHAR(255) NOT NULL,
    session_id VARCHAR(255) DEFAULT '',
    status VARCHAR(50) DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Campos:**
- `id` - Identificador único
- `project` - Nombre del proyecto
- `amount` - Monto en MXN
- `email` - Email del donante
- `session_id` - ID de sesión Openpay
- `status` - Estado de la donación
- `created_at` - Fecha/hora

---

## 🔐 Opciones de WordPress Usadas

El plugin guarda en options:
- `nr_openpay_merchant_id` - Merchant ID
- `nr_openpay_private_key` - Private Key
- `nr_openpay_mode` - Modo (sandbox/production)

**Ubicación:** Tabla `wp_options`

---

## 📦 Dependencias Externas

**PHP:**
- Openpay API (requerida manualmente)

**JavaScript:**
- jQuery (incluido en WordPress)

**CSS:**
- Ninguna (estilos nativos)

**WordPress:**
- Core (versión moderna)

---

## 🚀 Puntos de Extensión

### Hooks (para desarrolladores)

```php
// Antes de crear sesión
do_action('nr_openpay_before_create_session', $project, $amount, $email);

// Después de crear sesión
do_action('nr_openpay_after_create_session', $session);

// Antes de guardar en BD
do_action('nr_openpay_before_save_donation', $data);
```

### Filtros

```php
// Modificar datos de sesión
apply_filters('nr_openpay_session_data', $sessionData);

// Modificar query de donaciones
apply_filters('nr_openpay_donations_query', $query);
```

---

## 🎯 Estructura de Respuestas AJAX

### Success
```javascript
{
    success: true,
    data: {
        session_url: "https://openpay.mx/checkout/..."
    }
}
```

### Error
```javascript
{
    success: false,
    data: {
        message: "Mensaje de error"
    }
}
```

---

## 💾 Almacenamiento Local

**WordPress Options:**
```
nr_openpay_merchant_id     → Credencial
nr_openpay_private_key     → Credencial  
nr_openpay_mode            → Configuración
```

**Base de Datos:**
```
wp_openpay_donations       → Historial de donaciones
```

---

## 🔧 Información Técnica

**Versión PHP:** 7.0+
**Versión WordPress:** 5.0+
**jQuery:** Incluido en WP
**CSS3:** Completo

**Compatibilidad:**
- Chrome ✓
- Firefox ✓
- Safari ✓
- Edge ✓
- Mobile browsers ✓

---

## 📊 Complejidad del Código

- **Archivo Principal:** Media (208 líneas, bien estructurado)
- **JavaScript:** Baja (Simple validación)
- **CSS:** Media (Responsive, variables)
- **General:** Fácil de mantener y extender

---

## 🎓 Cómo Entender el Código

### Para principiantes:
1. Lee README.md
2. Lee openpay-donate-plugin.php (comentarios)
3. Prueba cambiar textos simples

### Para desarrolladores:
1. Entiende los hooks de WordPress
2. Revisa la estructura de BD
3. Estudia AJAX flow
4. Lee CUSTOMIZATION.md

---

## 📝 Notas de Desarrollo

- El código está en español (comentarios)
- Sigue estándares de WordPress
- Usa prefijo `nr_` para evitar conflictos
- Bien organizado en funciones

---

**Última actualización:** 20 de Octubre de 2025
