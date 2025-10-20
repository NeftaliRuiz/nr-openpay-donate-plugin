# Guía de Personalización - Openpay Donaciones Plugin

## 🎨 Cambiar el Esquema de Colores

### Colores Predeterminados
El plugin usa estos colores principales (puedes verlos en `css/openpay-admin.css`):

```css
:root {
    --color-primary: #0066cc;        /* Azul Openpay */
    --color-primary-dark: #0052a3;   /* Azul oscuro */
    --color-primary-light: #e6f0ff;  /* Azul claro */
    --color-success: #10b981;        /* Verde éxito */
    --color-error: #ef4444;          /* Rojo error */
    --color-warning: #f59e0b;        /* Amarillo advertencia */
}
```

### Ejemplo: Cambiar a Verde
Edita `/css/openpay-admin.css` y reemplaza:

```css
:root {
    --color-primary: #22c55e;        /* Verde principal */
    --color-primary-dark: #16a34a;   /* Verde oscuro */
    --color-primary-light: #dcfce7;  /* Verde claro */
    /* resto igual... */
}
```

## 🔤 Cambiar Textos del Plugin

### Textos del Formulario de Donación
En `openpay-donate-plugin.php`, busca la sección del shortcode y personaliza:

```php
// Cambiar "Hacer una Donación"
<h2>Hacer una Donación</h2>

// Cambiar "Proyecto:"
<span class="nr-label">Proyecto:</span>

// Cambiar placeholders
placeholder="tu@correo.com"
placeholder="0.00"

// Cambiar botón
<button id="nr-donate-now" class="nr-btn-donate">
    Continuar con Openpay
</button>
```

### Textos del Panel de Administración

En `openpay-donate-plugin.php`, sección `nr_openpay_admin_dashboard()`:

```php
// Cambiar título
<h1>Resumen de Donaciones</h1>

// Cambiar etiquetas
<h3>Monto Total</h3>
<h3>Total de Donaciones</h3>
<h2>Historial de Donaciones</h2>
```

## 📐 Modificar Tamaños y Espaciados

### Ancho del Formulario
En `/css/openpay-donate.css`:

```css
.nr-openpay-donate {
    max-width: 420px; /* Cambiar este valor */
}
```

### Padding y Márgenes
```css
.nr-openpay-form {
    padding: 28px 24px; /* Cambiar espacios internos */
}

.nr-form-group {
    margin-bottom: 20px; /* Cambiar espacio entre campos */
}
```

### Tamaño de Fuentes
```css
.nr-admin-header h1 {
    font-size: 28px; /* Cambiar de 28px a otro valor */
}

.nr-form-group label {
    font-size: 13px; /* Cambiar tamaño de etiquetas */
}
```

## ✏️ Personalizar el Encabezado (Header)

### Cambiar Color de Fondo
En `/css/openpay-donate.css` o `/css/openpay-admin.css`:

```css
.nr-openpay-header {
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    /* Cambiar los colores hex #0066cc y #0052a3 */
}

/* O usar un color sólido */
.nr-openpay-header {
    background: #0066cc;
}
```

### Cambiar el Icono del Header
En `openpay-donate-plugin.php`, reemplaza el SVG:

```php
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
    <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
</svg>

<!-- Por ejemplo, un icono de corazón: -->
<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
</svg>
```

## 🔘 Cambiar Estilos del Botón

### Color del Botón
En `/css/openpay-donate.css`:

```css
.nr-btn-donate {
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    /* Cambiar a un color sólido: */
    /* background: #22c55e; */
}
```

### Tamaño del Botón
```css
.nr-btn-donate {
    padding: 14px;       /* Cambiar padding */
    font-size: 15px;     /* Cambiar tamaño de texto */
    border-radius: 6px;  /* Cambiar redondez */
}
```

### Efecto al Pasar el Mouse
```css
.nr-btn-donate:hover {
    transform: translateY(-2px); /* Cambiar movimiento */
    box-shadow: 0 6px 20px rgba(0, 102, 204, 0.3); /* Cambiar sombra */
}
```

## 💳 Personalizar la Tabla de Donaciones

### Cambiar Color de Estados
En `/css/openpay-admin.css`:

```css
.nr-status-created {
    background: #fef3c7;    /* Cambiar fondo */
    color: #92400e;        /* Cambiar texto */
}

.nr-status-completed {
    background: #d1fae5;
    color: #065f46;
}

.nr-status-failed {
    background: #fee2e2;
    color: #991b1b;
}
```

### Cambiar Diseño de Cards de Estadísticas
En `/css/openpay-admin.css`:

```css
.nr-stat-card {
    background: var(--color-bg-white);
    border-radius: 8px;    /* Cambiar redondez */
    padding: 24px;         /* Cambiar espacios */
    box-shadow: var(--shadow-sm); /* Cambiar sombra */
}
```

## 🌐 Cambiar Ancho Máximo del Panel

En `/css/openpay-admin.css`:

```css
.nr-admin-container {
    max-width: 1200px; /* Cambiar ancho máximo */
    margin: 20px 0;
    padding: 0 20px;
}
```

## 📱 Puntos de Ruptura Responsivos

El plugin es responsive. Para cambiar comportamiento en móviles, edita:

En `/css/openpay-donate.css`:
```css
@media (max-width: 480px) {
    /* Estilos para móviles */
    .nr-openpay-donate-container {
        padding: 12px;
    }
}
```

En `/css/openpay-admin.css`:
```css
@media (max-width: 768px) {
    /* Estilos para tablets */
}

@media (max-width: 480px) {
    /* Estilos para móviles */
}
```

## 🎯 Cambiar Mensaje de Seguridad

En `/css/openpay-donate.css`, la línea del footer:

```php
<p>Pagos seguros procesados por Openpay</p>
<!-- Cambiar a: -->
<p>Transacciones seguras con Openpay</p>
```

## 💡 Ejemplos de Personalización Común

### Tema Oscuro
```css
body.openpay_page_openpay_donations {
    background: #1a1a1a !important;
}

.nr-admin-container {
    background: #2d2d2d;
    color: #ffffff;
}
```

### Tema Corporativo
```css
:root {
    --color-primary: #1e3a8a;      /* Azul corporativo */
    --color-primary-dark: #1e40af;
    --color-primary-light: #dbeafe;
}
```

### Aumentar Espaciados (Diseño Relajado)
```css
.nr-form-group {
    margin-bottom: 32px; /* Cambiar de 20px */
}

.nr-settings-card {
    padding: 40px;      /* Cambiar de 28px */
}
```

## 🔄 Revertir Cambios

Si haces cambios y algo se ve mal:

1. **Guarda una copia** del archivo original antes de modificar
2. **Usa Browser DevTools** (F12) para probar cambios
3. **Recarga el caché** del navegador (Ctrl+Shift+R)
4. **Limpia el caché** de WordPress si existe

## 📝 Tips Importantes

✅ **Siempre haz backups** antes de editar
✅ **Usa DevTools** para probar cambios antes de aplicarlos
✅ **Mantén la estructura HTML** intacta
✅ **Usa variables CSS** (--color-primary) para coherencia
✅ **Prueba en mobile** después de cambios
✅ **Comenta tus cambios** en el código

## 🆘 Ayuda

Si algo no funciona después de personalizar:

1. Revisa la consola del navegador (F12 → Console)
2. Busca errores en `/wp-admin/` → Herramientas → Salud del sitio
3. Restaura los archivos originales
4. Intenta de nuevo más cuidadosamente
