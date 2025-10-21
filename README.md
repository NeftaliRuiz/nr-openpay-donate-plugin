# Openpay Donaciones - Plugin WordPress

Un plugin WordPress minimalista y seguro para recibir donaciones a través de **Openpay** usando Checkout Sessions.

## 🎯 Características

✨ **Panel de Administración Moderno**
- Diseño minimalista similar a Openpay
- Estadísticas en tiempo real (monto total, número de donaciones)
- Historial completo de todas las donaciones
- Interfaz responsive y mobile-friendly

💰 **Procesamiento de Pagos Seguro**
- Integración con Openpay Checkout Sessions
- Soporte para modo Sandbox (pruebas) y Producción
- Gestión de credenciales segura
- Registro automático de transacciones

📋 **Shortcode para Formulario**
- Formulario de donación embebible en cualquier página
- Validaciones en tiempo real
- Interfaz limpia y moderna
- Soporte multi-proyecto

⚙️ **Fácil Configuración**
- Interfaz intuitiva para ingresar credenciales
- Selector de modo (Sandbox/Producción)
- Base de datos integrada para registro de donaciones

## 📦 Instalación

1. Descarga el plugin en tu carpeta `/wp-content/plugins/`
2. Activa el plugin desde el panel de administración de WordPress
3. Ve a **Openpay Donaciones** → **Configuración**
4. Ingresa tus credenciales de Openpay

## 🔑 Configuración

### Paso 1: Obtener Credenciales
1. Ve a [Openpay.mx](https://www.openpay.mx/)
2. Crea una cuenta o inicia sesión
3. En tu dashboard, encuentra:
   - **Merchant ID** (ID de comerciante)
   - **Private Key** (Clave privada)

### Paso 2: Configurar el Plugin
1. En el panel de WordPress, ve a **Openpay Donaciones → Configuración**
2. Copia y pega:
   - Tu **Merchant ID**
   - Tu **Private Key**
3. Selecciona el modo:
   - **Sandbox**: Para pruebas (sin cobrar)
   - **Producción**: Para cobrar en vivo
4. Haz clic en "Guardar Configuración"

## 📱 Usar el Shortcode

Inserta el shortcode en cualquier página o post:

```
[openpay_donate project="Mi Proyecto"]
```

### Parámetros disponibles:
- `project` (string): Nombre del proyecto para el cual se reciben donaciones
  - Por defecto: "Proyecto"
  - Ejemplo: `[openpay_donate project="Fondo de Educación"]`

### Ejemplos:

```
[openpay_donate project="Ayuda Humanitaria"]

[openpay_donate project="Becas Universitarias"]

[openpay_donate project="Proyecto Comunitario"]
```

## 📚 Documentación Completa

| Documento | Contenido |
|-----------|----------|
| **[OPENPAY_SETUP.md](OPENPAY_SETUP.md)** | 🔑 Cómo obtener credenciales, paso a paso |
| **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** | 🔧 Solución de problemas y errores comunes |
| **[TESTING_GUIDE.md](TESTING_GUIDE.md)** | 🧪 Guía completa de pruebas antes de usar |

👉 **¿Tu primera vez? Empieza con [OPENPAY_SETUP.md](OPENPAY_SETUP.md)**

## 📊 Panel de Donaciones

El panel muestra:

### Estadísticas
- **Monto Total**: Suma de todas las donaciones
- **Total de Donaciones**: Número de transacciones registradas

### Historial
Para cada donación se registra:
- Proyecto
- Email del donante
- Monto en MXN
- Estado (Creado, Pendiente, Completado, Fallido)
- Fecha y hora

## 🔒 Seguridad

✅ Verificación de nonce en todas las solicitudes AJAX
✅ Sanitización de inputs
✅ Validación de emails
✅ La Private Key se encripta en la base de datos
✅ Las credenciales solo se acceden en backend

## 📋 Estructura de la Base de Datos

```
wp_openpay_donations
├── id (BIGINT) - Identificador único
├── project (VARCHAR) - Nombre del proyecto
├── amount (DECIMAL) - Monto en MXN
├── email (VARCHAR) - Email del donante
├── session_id (VARCHAR) - ID de sesión de Openpay
├── status (VARCHAR) - Estado de la donación
└── created_at (DATETIME) - Fecha de creación
```

## 🎨 Personalización

### Cambiar Colores

Edita `/css/openpay-admin.css` y `/css/openpay-donate.css`:

```css
:root {
    --color-primary: #0066cc;      /* Color principal */
    --color-primary-dark: #0052a3; /* Color oscuro */
    --color-success: #10b981;      /* Color éxito */
}
```

### Cambiar Textos

En el archivo principal `openpay-donate-plugin.php`:

- Busca los textos que deseas cambiar
- Mantén las etiquetas PHP intactas
- Reemplaza solo el contenido visible

## 🐛 Solución de Problemas

### ⚠️ Problemas Comunes

| Problema | Solución |
|----------|----------|
| "No se pudo conectar al servidor" | Ve a [TROUBLESHOOTING.md](TROUBLESHOOTING.md#error-1-no-se-pudo-conectar-al-servidor) |
| "Verifica tus credenciales" | Ve a [TROUBLESHOOTING.md](TROUBLESHOOTING.md#error-2-verifica-tus-credenciales) |
| El formulario no aparece | Verifica que el shortcode esté correctamente escrito |
| No se pueden guardar las credenciales | Verifica que tengas permisos de administrador |
| Las donaciones no se registran | Confirma que las credenciales sean correctas |

👉 **Documentación completa de errores:** [TROUBLESHOOTING.md](TROUBLESHOOTING.md)

## 📞 Soporte

Para ayuda con:
- **Plugin**: Revisa la documentación
- **Openpay**: [Contacta a Openpay](https://www.openpay.mx/)
- **Plugin Erro**: [Contacta a @neft](https://www.neft.com.mx/)


## 🚀 Changelog

### v1.2
- Nuevo diseño minimalista estilo Openpay
- Panel de administración mejorado
- Estadísticas en tiempo real
- Mejor experiencia de usuario (UX/UI)
- Validaciones mejoradas

### v1.1
- Funcionalidad base del plugin
- Shortcode inicial
- Panel de administración básico

## 👨‍💻 Desarrollo

### Archivos principales
- `openpay-donate-plugin.php` - Archivo principal del plugin
- `js/openpay-donate.js` - Lógica del formulario
- `css/openpay-donate.css` - Estilos del formulario
- `css/openpay-admin.css` - Estilos del panel admin
