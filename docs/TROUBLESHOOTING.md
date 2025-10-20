# 🔧 Troubleshooting: Errores de Conexión Openpay

Guía completa para resolver errores de conexión a Openpay.

---

## 🚨 Errores Comunes

### Error 1: "No se pudo conectar al servidor"

**Síntoma:** 
- Haces clic en "Donar"
- Ves un modal
- Completas el formulario
- Recibes error: "No se pudo conectar al servidor"

**Causas posibles:**

#### 1️⃣ Credenciales no configuradas
```
Solución:
1. Ve a Donaciones Openpay → Configuración
2. Asegúrate que ambos campos estén rellenados:
   ✅ Merchant ID: [tu id]
   ✅ Private Key: [tu clave privada]
3. Guarda cambios
4. Recarga la página
5. Intenta de nuevo
```

#### 2️⃣ Merchant ID incorrecto
```
Merchant ID incorrecto:
❌ Vacío
❌ Copiado de forma incompleta
❌ Con espacios al inicio o final
❌ De producción cuando está en Sandbox

Cómo verificar:
1. Ve a https://dashboard.openpay.mx/settings
2. En la sección "API Keys"
3. Copia exactamente como aparece
4. Pega en WordPress
5. Guarda
```

#### 3️⃣ Private Key incorrecta
```
Private Key incorrecta:
❌ Usaste la Public Key (comienza con pk_)
❌ La copiaste incompleta
❌ Tiene espacios
❌ Es de otro ambiente (Sandbox/Production)

Cómo verificar:
1. Abre dashboard.openpay.mx/settings
2. En "API Keys" busca "Private Key"
3. Verifica que comience con "sk_"
4. Cópialos sin espacios
5. Pega en el plugin
6. Guarda
```

#### 4️⃣ Ambiente incorrecto
```
Si estás en Sandbox:
✅ Usa credenciales de Sandbox (sk_test_...)
❌ No uses credenciales de Production

Si estás en Production:
✅ Usa credenciales de Production (sk_live_...)
❌ No uses credenciales de Sandbox
```

---

### Error 2: "Verifica tus credenciales"

**Síntoma:**
- La donación parece procesar
- Recibes error: "Verifica tus credenciales"

**Solución:**
```
HTTP 401 - Credenciales inválidas
↓
Significa: La Private Key es rechazada por Openpay

Pasos:
1. Ve a dashboard.openpay.mx
2. Navega a Settings → API Keys
3. Copia la Private Key exactamente
4. Pégala en WordPress (Configuración)
5. Verifica:
   - Sin espacios al inicio/final
   - Completa (no cortada)
   - Correcta (sk_test_ o sk_live_)
6. Guarda
7. Intenta de nuevo
```

---

### Error 3: "Error de validación"

**Síntoma:**
- Recibes: "Error de validación" o "Error 400"

**Causas:**
```
1. Moneda incorrecta (plugin usa MXN)
   - Verifica que tu cuenta Openpay esté en México

2. Monto inválido
   - Monto debe ser mayor a $0
   - Monto debe ser número válido
   - ¿Ingresaste letras? (solo números)

3. Email inválido
   - Formato debe ser: usuario@dominio.com
   - Sin espacios
   - Válido

4. Proyecto vacío
   - El shortcode necesita: [openpay_donate project="Nombre"]
   - El "project" no puede estar vacío
```

**Solución:**
```
Para Monto:
✅ Solo números: 50, 100, 250
❌ No textos: "cincuenta", "$100"
❌ No símbolos: "100 MXN"

Para Email:
✅ formato@valido.com
❌ email inválido
❌ sin @ o .com

Para Proyecto:
✅ [openpay_donate project="Mi Proyecto"]
❌ [openpay_donate] (sin project)
```

---

### Error 4: "No se encontró la respuesta"

**Síntoma:**
- Error: "No se encontró la respuesta" o "Respuesta inválida de Openpay"

**Significado:**
Openpay respondió pero no con los datos esperados

**Causas:**
```
1. Openpay está en mantenimiento
   Solución: Espera y vuelve a intentar

2. Conexión interrumpida
   Solución: Verifica tu internet y reintenta

3. Problemas con el servidor WordPress
   Solución: Reinicia el servidor o contacta hosting
```

---

## 🔍 Cómo Diagnosticar el Problema

### Paso 1: Verificar Configuración

```bash
# En WordPress:
1. Ve a Donaciones Openpay → Configuración
2. Verifica estos campos:

   Merchant ID:        [¿Tiene valor?] ✅ o ❌
   Private Key:        [¿Tiene valor?] ✅ o ❌
   Modo:               [Sandbox o Production?]

Si alguno está vacío → Rellena y guarda
```

### Paso 2: Verificar Credenciales en Openpay

```
1. Abre https://dashboard.openpay.mx/settings
2. En "API Keys" verifica:
   ✅ ¿Ves "Merchant ID"?
   ✅ ¿Ves "Private Key" (sk_...)?
   ✅ ¿Ves "Public Key" (pk_...)?
   
   Si falta algo → Tu cuenta de Openpay no está lista
```

### Paso 3: Verificar Logs del Servidor

**Si tienes acceso a WordPress:**

```php
1. Ve a: Herramientas → Salud del Sitio
2. Busca mensajes de error relacionados con Openpay
3. Si hay errores PHP, mostrarán aquí
```

**Si tienes acceso FTP/SSH:**

```bash
# Ver errores del servidor
tail -f /path/to/wordpress/wp-content/debug.log

# O si usas hosting administrado:
# Pregunta al hosting por los logs de error
```

### Paso 4: Verificar Consola del Navegador

```
1. En tu página web, haz clic en "Donar"
2. Presiona F12 (Abre Developer Tools)
3. Ve a la pestaña "Console"
4. Intenta una donación
5. Busca mensajes rojos (errores)
6. Cópialos y verifica qué dicen
```

---

## 🛠️ Soluciones Específicas

### Solución A: Reiniciar Configuración

Si nada funciona, intenta resetear:

```
1. Ve a Donaciones Openpay → Configuración
2. Vacía todos los campos
3. Guarda
4. Recarga la página
5. Rellena de nuevo (copia desde dashboard)
6. Guarda
7. Prueba
```

### Solución B: Verificar Permisos

```
1. Ve a wp-admin
2. Usuarios → Tu usuario
3. Verifica que tengas rol "Administrador"
4. Si no → Pide a administrador que lo cambie
```

### Solución C: Desactivar Plugins

Si el error persiste:

```
1. Ve a Plugins
2. Desactiva TODOS excepto "Openpay Donate"
3. Intenta la donación
4. Si funciona → Algún plugin conflictúa
5. Activa plugins uno por uno para identificar cuál
```

### Solución D: Verificar SSL/HTTPS

```
Tu sitio debe tener HTTPS

Cómo verificar:
1. Ve a tu sitio: www.tunombre.com
2. En la URL verás:
   ✅ https://tunombre.com (verde con candado)
   ❌ http://tunombre.com (sin HTTPS)

Si ves http:
- Contacta a tu hosting
- Pide activar SSL certificate
- Sin HTTPS no funciona Openpay
```

---

## 📊 Tabla de Errores HTTP

| Código | Significado | Causa | Solución |
|--------|-------------|-------|----------|
| **200/201** | ✅ Éxito | Donación procesada | Nada (funciona) |
| **400** | ❌ Solicitud Inválida | Datos incompletos | Verifica email/monto/proyecto |
| **401** | ❌ No Autorizado | Credenciales malas | Revisa Private Key |
| **403** | ❌ Prohibido | Cuenta limitada | Contacta Openpay |
| **500** | ❌ Error del Servidor | Problema en Openpay | Espera e intenta después |
| **503** | ❌ Servicio No Disponible | Mantenimiento | Espera e intenta después |

---

## ✅ Checklist de Solución

Cuando recibas un error, verifica en orden:

```
□ ¿Está configurado el Merchant ID?
□ ¿Está configurada la Private Key?
□ ¿La Private Key comienza con "sk_"?
□ ¿No hay espacios en las credenciales?
□ ¿El Modo coincide con las credenciales (Sandbox/Production)?
□ ¿Tu sitio tiene HTTPS?
□ ¿Ingresaste una cantidad válida (número > 0)?
□ ¿Ingresaste un email válido (formato correcto)?
□ ¿El proyecto está especificado en el shortcode?
□ ¿Otros plugins no conflictúan?
□ ¿El servidor de Openpay está activo?
□ ¿Tu servidor tiene acceso a internet?
```

Si marcaste todos → **El plugin funciona perfectamente** ✅

---

## 📞 Obtener Ayuda

Si nada funciona:

1. **Contacta Openpay:** support@openpay.mx
   - Envía: Merchant ID, error recibido, momento cuando ocurre
   
2. **Contacta tu Hosting:**
   - Pregunta: ¿HTTPS funciona? ¿Acceso a internet? ¿Logs de error?

3. **Verifica Documentación:** [openpay.mx/docs](https://www.openpay.mx/)

---

**Última actualización:** 2024
**Versión del plugin:** 1.2+
