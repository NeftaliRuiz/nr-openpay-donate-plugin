# Ejemplos de Uso - Plugin Openpay Donaciones

## 📍 Instalación Rápida

### 1. Activar el Plugin
```
1. Ve a Panel de WordPress
2. Plugins → Plugins instalados
3. Busca "Openpay Donaciones"
4. Haz clic en "Activar"
```

### 2. Configurar Credenciales
```
1. Ve a Openpay Donaciones → Configuración
2. Ingresa tu Merchant ID
3. Ingresa tu Private Key
4. Selecciona modo (Sandbox o Producción)
5. Haz clic en "Guardar Configuración"
```

## 🎯 Ejemplos de Shortcodes

### Ejemplo 1: Donación Simple
```
[openpay_donate project="Mi Proyecto"]
```

**Resultado:** Formulario de donación para "Mi Proyecto"

---

### Ejemplo 2: Donación para ONG
```
[openpay_donate project="ONG Ayuda Humanitaria"]
```

**Uso:** En página "Ayudar" de una ONG
**Resultado:** Formulario personalizado con nombre de la organización

---

### Ejemplo 3: Donación para Educación
```
[openpay_donate project="Becas Universitarias 2025"]
```

**Uso:** En página de programa de becas
**Resultado:** Formulario para recibir donaciones a becas

---

### Ejemplo 4: Múltiples Proyectos en la Misma Página
```
<h2>Proyecto A - Educación</h2>
[openpay_donate project="Becas Educativas"]

<hr>

<h2>Proyecto B - Salud</h2>
[openpay_donate project="Clínica Móvil"]

<hr>

<h2>Proyecto C - Emergencias</h2>
[openpay_donate project="Fondo de Emergencia"]
```

**Resultado:** Página con 3 formularios independientes

---

## 💻 Casos de Uso Reales

### 1. Sitio Web de ONG
```
Página: "Donativos"
Shortcode: [openpay_donate project="ONG Nombre Organizacion"]
Modo: Producción (cobros reales)
```

### 2. Blog de Periodismo Independiente
```
Página: "Ayúdanos a Crecer"
Shortcode: [openpay_donate project="Fondo Editorial"]
Modo: Producción
```

### 3. Proyecto Comunitario
```
Página: "Apoya nuestro Proyecto"
Shortcode: [openpay_donate project="Proyecto Comunitario Local"]
Modo: Sandbox (para pruebas iniciales)
```

### 4. Tienda que Hace Donaciones
```
Página: "Causas que Apoyamos"
Shortcode múltiple:
[openpay_donate project="Medio Ambiente"]
[openpay_donate project="Educación Rural"]
[openpay_donate project="Salud Animal"]
```

### 5. Streaming o Contenido Creator
```
Página: "Apóyame"
Shortcode: [openpay_donate project="Contenido de Calidad"]
Modo: Producción
```

---

## 🧪 Modo Sandbox vs Producción

### Para Pruebas (Sandbox)
```
1. Configurar → Modo: Sandbox
2. Usar shortcode: [openpay_donate project="Pruebas"]
3. NO se realiza ningún cobro
4. Puedes probar el flujo completo
```

**Credenciales de prueba de Openpay:**
- Tarjeta: 4111111111111111
- Mes/Año: 12/25
- CVV: 123

### Para Producción (Cobros Reales)
```
1. Configurar → Modo: Producción
2. Usar shortcode: [openpay_donate project="Mi Proyecto"]
3. SÍ se realiza cobro real
4. El dinero va a tu cuenta de Openpay
```

⚠️ **IMPORTANTE:** Realiza pruebas en Sandbox antes de cambiar a Producción

---

## 📊 Panel de Administración

### Ver Donaciones Recibidas
```
1. Ve a Openpay Donaciones (menú principal)
2. Verás:
   - Monto Total (suma de todas las donaciones)
   - Total de Donaciones (cantidad de transacciones)
   - Historial completo con:
     * Proyecto
     * Email del donante
     * Monto
     * Estado
     * Fecha
```

### Estados Posibles
- **Creado**: La sesión fue creada
- **Pendiente**: Donación en proceso
- **Completado**: Donación exitosa ✓
- **Fallido**: Donación no completada ✗

---

## 🔒 Seguridad y Mejores Prácticas

### ✅ Haz Esto

```
✓ Usa Sandbox para probar primero
✓ Verifica tu Merchant ID y Private Key
✓ Mantén backups de tu base de datos
✓ Monitorea el panel regularmente
✓ Usa HTTPS en tu sitio (recomendado)
```

### ❌ No Hagas Esto

```
✗ No compartas tu Private Key
✗ No uses credenciales de prueba en Producción
✗ No modifiques la base de datos directamente
✗ No expongas tu Merchant ID públicamente
✗ No desactives el plugin sin hacer backup
```

---

## 🐛 Solución de Problemas Comunes

### Problema: El formulario no aparece
```
Solución:
1. Verifica que el shortcode esté correcto
2. Confirma que el plugin está activo
3. Recarga la página (Ctrl+Shift+R)
```

### Problema: "Configuración incompleta"
```
Solución:
1. Ve a Openpay Donaciones → Configuración
2. Ingresa Merchant ID y Private Key
3. Haz clic en "Guardar Configuración"
```

### Problema: Las donaciones no se registran
```
Solución:
1. Verifica credenciales en Configuración
2. Comprueba que estés en modo correcto (Sandbox o Producción)
3. Revisa que la sesión de Openpay se cree correctamente
4. Prueba el flujo completo
```

---

## 📈 Flujo de Donación

```
Usuario accede a página con shortcode
            ↓
Ve formulario de donación
            ↓
Ingresa email y monto
            ↓
Hace clic en "Continuar con Openpay"
            ↓
Se validan datos
            ↓
Se crea sesión en Openpay
            ↓
Usuario es redirigido a Openpay checkout
            ↓
Usuario ingresa datos de tarjeta
            ↓
Openpay procesa el pago
            ↓
Usuario ve confirmación
            ↓
Donación se registra en tu panel
            ↓
Plugin guarda registro en base de datos
```

---

## 💳 Información Guardada

Cada donación registra:
```
ID: Identificador único
Proyecto: "Mi Proyecto"
Monto: 100.00 MXN
Email: donante@ejemplo.com
Session ID: (ID de Openpay)
Estado: "completed"
Fecha: 2024-10-20 14:30:00
```

---

## 📱 Verificar Donaciones Recibidas

### Vía Panel del Plugin
```
1. Panel WordPress → Openpay Donaciones
2. Ver tabla con historial completo
```

### Vía Panel de Openpay
```
1. Ve a openpay.mx
2. Accede a tu cuenta
3. Ve a "Transacciones" o "Reportes"
4. Verifica los pagos recibidos
```

---

## 🎁 Personalizar Experiencia

### Cambiar Mensaje de Bienvenida
Edita `openpay-donate-plugin.php` y personaliza:
```php
<h2>Hacer una Donación</h2>
// Cambiar a:
<h2>Apóyanos Hoy</h2>
```

### Cambiar Colores
Edita `/css/openpay-donate.css` y cambia:
```css
--color-primary: #0066cc;  /* azul Openpay */
// A:
--color-primary: #22c55e;  /* verde */
```

Ver archivo `CUSTOMIZATION.md` para más detalles.

---

## 📞 Contacto y Ayuda

**Para ayuda con el plugin:**
- Revisa la documentación en README.md
- Verifica troubleshooting en este archivo

**Para ayuda con Openpay:**
- Contacta a: soporte@openpay.mx
- Web: https://www.openpay.mx/

---

## ✨ Tips Finales

```
💡 Siempre prueba en Sandbox primero
💡 Mantén tus credenciales seguras
💡 Monitorea el panel regularmente
💡 Comunica a donantes el propósito de las donaciones
💡 Envía confirmaciones personalizadas
```

¡Gracias por usar Openpay Donaciones! 🎉
