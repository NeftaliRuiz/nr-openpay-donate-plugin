# 🎁 Modal de Donación - Guía Actualizada

## ¿Qué cambió?

El shortcode ahora muestra solo un **botón limpio**, y al hacer clic se abre un **modal elegante** con el formulario de donación. Es mucho más profesional y menos intrusivo.

---

## 📱 Cómo se ve

### Antes (v1.2 original)
```
Formulario visible directamente en la página
(Ocupaba mucho espacio)
```

### Ahora (v1.2+ con Modal)
```
[🎁 Donar Ahora]  ← Solo un botón

Al hacer clic → Se abre un modal elegante
                 ↓
            [Modal con formulario]
```

---

## 🚀 Cómo usar el shortcode

### Sintaxis
```
[openpay_donate project="Mi Proyecto"]
```

### Ejemplo 1: ONG
```
[openpay_donate project="ONG Educación"]
```
Resultado: Un botón "🎁 Donar Ahora"

### Ejemplo 2: Blog
```
[openpay_donate project="Fondo Editorial"]
```
Resultado: Un botón "🎁 Donar Ahora"

### Ejemplo 3: Múltiples proyectos
```
<h2>Proyectos</h2>

[openpay_donate project="Educación"]

[openpay_donate project="Salud"]

[openpay_donate project="Emergencias"]
```
Resultado: 3 botones independientes

---

## 🎨 Características del Modal

### Botón (Cerrado)
```
┌──────────────────┐
│ 🎁 Donar Ahora   │
└──────────────────┘
```

### Modal (Abierto)
```
Fondo semi-transparente (Backdrop)
├─ Click afuera cierra el modal
└─ Esc también cierra

Modal Elegante
├─ Header azul con icono
├─ Formulario completo
├─ Botón cerrar (X)
└─ Animaciones suaves
```

---

## 📋 Interacciones

### 1. Abrir Modal
```
Usuario hace clic en botón "🎁 Donar Ahora"
        ↓
Se abre modal con animación
        ↓
Formulario está listo para rellenar
```

### 2. Rellenar Formulario
```
Proyecto: (Se llena automáticamente)
Email: (Usuario ingresa)
Monto: (Usuario ingresa)
        ↓
Usuario hace clic en "Continuar con Openpay"
```

### 3. Cerrar Modal
```
Opción 1: Clic en botón X
Opción 2: Presionar Esc
Opción 3: Clic fuera del modal
Opción 4: Después de enviar (redirección)
```

---

## 🎯 Ventajas del Modal

✅ **Menos intrusivo** - El contenido se ve limpio  
✅ **Más profesional** - Aspecto moderno  
✅ **Mejor UX** - Foco en la donación  
✅ **Reutilizable** - Un solo modal para múltiples botones  
✅ **Animaciones** - Entrada/salida suave  
✅ **Responsivo** - Se adapta a móvil  
✅ **Accesible** - Se cierra con Esc  
✅ **Overlay** - Fondo oscuro para enfocar  

---

## 💻 Cómo se ve en Móvil

### En Desktop (768px+)
```
┌────────────────────────────┐
│                            │
│  [Botón]                   │
│                            │
│           (Modal centrado)  │
│  ┌───────────────────────┐ │
│  │ 🎁 Hacer Donación     │ │
│  ├───────────────────────┤ │
│  │ Proyecto: ...         │ │
│  │ Email: [input]        │ │
│  │ Monto: [$]           │ │
│  │ [Botón]               │ │
│  └───────────────────────┘ │
│                            │
└────────────────────────────┘
```

### En Móvil (<480px)
```
┌────────────────┐
│                │
│  [Botón]       │
│                │
│  (Modal)       │
│  ┌────────────┐│
│  │ 🎁 Donar   ││
│  ├────────────┤│
│  │ Proyecto   ││
│  │ Email []   ││
│  │ Monto [$]  ││
│  │ [Botón]    ││
│  └────────────┘│
│                │
└────────────────┘
```

---

## 🎨 Estilos del Modal

### Animaciones
```
Entrada: Fade in + Slide up (0.3s)
Salida: Fade out (0.3s)

Botón Donar:
- Hover: Elevarse + sombra más fuerte
- Click: Volver a posición normal

Modal:
- Al abrir: Aparece suavemente
- Al cerrar: Desaparece suavemente
```

### Colores
```
Fondo modal: #ffffff (blanco)
Fondo backdrop: rgba(0,0,0,0.5) con blur
Header: Gradiente azul Openpay
Botón cierre: Gris neutro
```

---

## 🔧 Personalización

### Cambiar texto del botón
Edita `/openpay-donate-plugin.php`, busca:
```php
<button class="nr-donate-btn-open" data-project="<?php echo esc_attr($atts['project']); ?>">
    🎁 Donar Ahora  // ← Cambia aquí
</button>
```

Ejemplo:
```php
Apóyanos Ahora
Contribuir
Donar
Ayudanos
```

### Cambiar emoji
```php
🎁 Donar Ahora    // Donar
❤️ Donar Ahora     // Corazón
💝 Donar Ahora     // Regalo
💰 Donar Ahora     // Dinero
```

### Cambiar estilos del botón
En `/css/openpay-donate.css`, edita:
```css
.nr-donate-btn-open {
    padding: 12px 24px;        // Tamaño
    background: linear-gradient(...); // Color
    font-size: 14px;           // Texto
    border-radius: 6px;        // Redondez
}
```

---

## 📊 Flujo de Donación con Modal

```
┌─────────────────┐
│ Página normal   │
│ [🎁 Donar Ahora]│
└────────┬────────┘
         │ Click
         ▼
    ┌─────────────┐
    │ Se abre     │
    │ Modal       │
    │ Animación:  │
    │ Fade in +   │
    │ Slide up    │
    └────────┬────┘
             │
    ┌────────▼────────┐
    │ Modal abierto   │
    │ [X] para cerrar │
    │ Esc para cerrar │
    └────────┬────────┘
             │
    ┌────────▼────────────┐
    │ Usuario llena form  │
    │ Email: xxx@xxx.com  │
    │ Monto: $100         │
    └────────┬────────────┘
             │
    ┌────────▼─────────────────┐
    │ Validación en tiempo real│
    │ - Email válido          │
    │ - Monto > $0.99         │
    └────────┬─────────────────┘
             │
    ┌────────▼────────────────┐
    │ Click en "Continuar"    │
    │ Se envía AJAX           │
    │ Botón deshabilitado     │
    └────────┬────────────────┘
             │
    ┌────────▼────────────────┐
    │ Se crea sesión Openpay  │
    │ Respuesta OK/Error      │
    └────────┬────────────────┘
             │
    OK   YES │ ERROR
     ╱──────────╲
    ▼           ▼
 REDIRECT    MUESTRA
  A OPENPAY  ERROR
             EN MODAL
```

---

## 🔒 Seguridad

El modal mantiene toda la seguridad del plugin:

✅ **Verificación de nonce** - CSRF protegido  
✅ **Sanitización de datos** - Datos limpios  
✅ **Validación de emails** - Formato verificado  
✅ **Validación de montos** - Solo números válidos  
✅ **Credenciales protegidas** - No se exponen  

---

## 🐛 Solución de Problemas

### El modal no se abre
```
✓ Verifica que el shortcode esté correcto
✓ Abre consola (F12 → Console)
✓ Busca errores de JavaScript
✓ Recarga la página (Ctrl+Shift+R)
```

### El modal se cierra solo
```
✓ Verifica que haya internet (para AJAX)
✓ Revisa la consola del navegador
✓ Comprueba credenciales de Openpay
```

### El botón no se ve
```
✓ Verifica que el shortcode esté en la página
✓ Recarga página (Ctrl+Shift+R)
✓ Limpia caché del navegador
```

---

## 📝 Notas Técnicas

### HTML generado
```html
<!-- Botón abierto al página -->
<button class="nr-donate-btn-open" data-project="Mi Proyecto">
    🎁 Donar Ahora
</button>

<!-- Modal (se carga una sola vez) -->
<div id="nr-openpay-modal" class="nr-openpay-modal">
    <div class="nr-openpay-modal-content">
        <!-- Formulario aquí -->
    </div>
</div>
```

### JavaScript eventos
```javascript
.nr-donate-btn-open     // Abre modal
.nr-openpay-modal-close // Cierra modal
Esc                      // Cierra modal
Click fuera             // Cierra modal
```

### CSS importante
```css
.nr-openpay-modal {
    position: fixed;      // Cubre toda la pantalla
    backdrop-filter: blur // Efecto blur del fondo
    z-index: 9999;        // Siempre encima
}
```

---

## ✨ Mejoras Futuras

En próximas versiones podremos agregar:
- [ ] Animación de confeti al completar donación
- [ ] Historial de donaciones en cliente
- [ ] Guardado de montos frecuentes
- [ ] Temas personalizados para el modal
- [ ] Sonido de confirmación

---

## 🎯 Resumen

El nuevo sistema con modal es:
- ✅ Más limpio
- ✅ Más profesional
- ✅ Más amigable
- ✅ Más accesible
- ✅ Mejor experiencia de usuario

**¡Una mejora importante en la experiencia de donación!**

---

**Versión:** 1.2+  
**Fecha:** 20 de Octubre de 2025  
**Estado:** ✅ Implementado
