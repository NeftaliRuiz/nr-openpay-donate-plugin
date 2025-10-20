# ⚡ Inicio Rápido (5 minutos)

## 🚀 3 Pasos para Empezar

### Paso 1: Instalar ✅
```bash
1. Descarga la carpeta openpay-donate-plugin-admin
2. Sube a /wp-content/plugins/ de tu WordPress
3. Ve a Panel WordPress → Plugins
4. Activa "Openpay Donaciones Seguro Admin"
```

### Paso 2: Configurar ✅
```bash
1. Ve a Panel → Openpay Donaciones → Configuración
2. Ingresa tu Merchant ID (de Openpay)
3. Ingresa tu Private Key (de Openpay)
4. Selecciona "Sandbox" para probar (o "Producción" si estás listo)
5. Haz clic en "Guardar Configuración"
```

### Paso 3: Usar ✅
```bash
1. Abre una página en WordPress
2. Donde desees el formulario, copia esto:
   [openpay_donate project="Mi Proyecto"]
3. ¡Listo! El formulario aparecerá
```

---

## 📍 Ubicaciones Importantes

| Lo que necesitas | Dónde encontrarlo |
|-----------------|------------------|
| Merchant ID | openpay.mx → Tu Panel → Credenciales |
| Private Key | openpay.mx → Tu Panel → Credenciales |
| Acceder a Panel | Panel WordPress → Openpay Donaciones |
| Ver Donaciones | Panel → Openpay Donaciones (Dashboard) |
| Cambiar Credenciales | Panel → Openpay Donaciones → Configuración |
| Personalizar Diseño | Edita `/css/openpay-donate.css` |

---

## 💡 Tips Importantes

### ✅ Debes Hacer
```
1. Prueba en SANDBOX primero (no cobra)
2. Lee README.md si tienes dudas
3. Personaliza con tus colores y textos
4. Haz backup antes de cambiar cosas
```

### ❌ NO Hagas
```
1. No compartas tu Private Key
2. No vayas directo a Producción
3. No modifiques archivos core de WP
4. No olvides hacer backup
```

---

## 🧪 Modo Sandbox (Pruebas)

Para probar sin gastar dinero:

```
1. En Configuración, selecciona "Sandbox"
2. Usa esta tarjeta de prueba:
   - Número: 4111111111111111
   - Mes/Año: 12/25
   - CVV: 123
3. Completa el formulario
4. ¡Las donaciones NO se cobran!
5. Aparecen en el panel como "Test"
```

---

## 🎯 Primeras Acciones

### Día 1: Instalación
- [ ] Descargar plugin
- [ ] Activar en WordPress
- [ ] Guardar credenciales
- [ ] Leer README.md

### Día 2: Pruebas
- [ ] Agregar shortcode en página
- [ ] Probar formulario en Sandbox
- [ ] Personalizar textos
- [ ] Cambiar colores

### Día 3: Producción
- [ ] Cambiar a modo Producción
- [ ] Cambiar credenciales a producción
- [ ] Hacer un test con dinero real
- [ ] Monitorear panel

---

## 📞 Cuando Necesites Ayuda

| Pregunta | Dónde mirar |
|---------|-----------|
| Cómo instalar | README.md |
| Cómo configurar | README.md + FAQ.md |
| Cómo personalizar | CUSTOMIZATION.md |
| Ejemplos de uso | EXAMPLES.md |
| Error que no entiendo | FAQ.md |
| Estructura técnica | STRUCTURE.md |
| Diseño/Colores | VISUAL_GUIDE.md |

---

## ✨ Ejemplos de Shortcodes

### Ejemplo 1: ONG
```
[openpay_donate project="ONG Educación"]
```

### Ejemplo 2: Blog
```
[openpay_donate project="Fondo Editorial"]
```

### Ejemplo 3: Causa Social
```
[openpay_donate project="Emergencia Sanitaria"]
```

### Múltiples en misma página
```
[openpay_donate project="Proyecto A"]

[openpay_donate project="Proyecto B"]

[openpay_donate project="Proyecto C"]
```

---

## 🔍 Verificar que Todo Funcione

### 1. Plugin Activo ✅
```
Panel WordPress → Plugins
Busca "Openpay Donaciones"
Debe estar ACTIVO (azul)
```

### 2. Credenciales Guardadas ✅
```
Panel → Openpay Donaciones → Configuración
Debes ver:
- Merchant ID (rellenado)
- Private Key (rellenado)
- Modo (Sandbox o Producción)
```

### 3. Formulario Aparece ✅
```
Abre página con: [openpay_donate project="Test"]
Debes ver:
- Header azul "Hacer una Donación"
- Campo de email
- Campo de monto
- Botón azul "Continuar con Openpay"
```

### 4. Prueba Funciona ✅
```
En modo Sandbox:
1. Ingresa email de prueba
2. Ingresa monto $10.00
3. Haz clic en botón
4. Deberías ir a Openpay checkout
5. Completa con tarjeta 4111111111111111
6. Deberías ver confirmación
7. Donación debe aparecer en panel
```

---

## 🎨 Primera Personalización (10 minutos)

### Cambiar Color Principal
```
1. Abre /css/openpay-donate.css
2. Busca: --color-primary: #0066cc
3. Cambia #0066cc a tu color (ej: #22c55e para verde)
4. Guarda el archivo
5. Recarga página en navegador (Ctrl+Shift+R)
```

### Cambiar Textos
```
1. Abre openpay-donate-plugin.php
2. Busca el texto que quieras cambiar
3. Por ejemplo: "Hacer una Donación"
4. Cámbialo por tu texto
5. Recarga página
```

---

## 📊 Ver Donaciones

```
1. Panel WordPress
2. Openpay Donaciones (menú)
3. Verás:
   ✓ Monto Total recaudado
   ✓ Número de donaciones
   ✓ Lista con cada donación
   ✓ Email de donante
   ✓ Monto
   ✓ Estado
   ✓ Fecha
```

---

## 🔄 Proceso de Donación

```
Usuario ve formulario
        ↓
Ingresa email y monto
        ↓
Hace clic "Continuar"
        ↓
Se valida información
        ↓
Se abre Openpay checkout
        ↓
Usuario paga con tarjeta
        ↓
Donación confirmada
        ↓
Aparece en tu panel
```

---

## 📱 Prueba en Móvil

```
1. Abre página en tu teléfono
2. El formulario debe verse bien
3. Todos los campos deben ser clickeables
4. Botón debe ser fácil de presionar
5. Textos legibles sin zoom
```

---

## ⚠️ Posibles Problemas

### "Formulario no aparece"
```
✓ Verifica que el shortcode esté correcto
✓ Recarga página (Ctrl+Shift+R)
✓ Verifica que el plugin esté ACTIVO
```

### "Error configuración incompleta"
```
✓ Ve a Configuración
✓ Completa todos los campos
✓ Haz clic en Guardar
```

### "Botón no funciona"
```
✓ Abre consola (F12)
✓ Recarga página
✓ Intenta de nuevo
✓ Si persiste, contacta soporte
```

---

## 🎓 Siguiente Lectura

```
1. Terminaste esto? → Lee README.md (10 min)
2. Quieres personalizar? → Lee CUSTOMIZATION.md (15 min)
3. Necesitas ejemplos? → Lee EXAMPLES.md (10 min)
4. Tienes dudas? → Consulta FAQ.md (5 min)
```

---

## 🎉 ¡Felicidades!

Ya tienes:
- ✅ Plugin instalado
- ✅ Credenciales configuradas
- ✅ Formulario funcionando
- ✅ Panel de admin activo

**¡Ahora sí puedes recibir donaciones! 💰**

---

## 📝 Checklist Rápido

- [ ] Plugin activado
- [ ] Credenciales guardadas
- [ ] Shortcode insertado
- [ ] Formulario visible
- [ ] Prueba en Sandbox completada
- [ ] Panel funcionando

Si todas están marcadas: **¡ÉXITO! 🎊**

---

**Tiempo total:** 5-10 minutos  
**Nivel:** Principiante  
**Resultado:** Aceptando donaciones

¡Listo! 🚀
