# 🔑 Guía de Configuración de Credenciales Openpay

Sigue estos pasos para obtener tus credenciales de Openpay y configurar el plugin.

---

## Paso 1: Crear Cuenta en Openpay

1. Ve a [openpay.mx](https://www.openpay.mx/) 
2. Haz clic en **"Crear Cuenta"** o **"Sign Up"**
3. Completa el formulario con:
   - **Nombre de la empresa/proyecto**
   - **Email**
   - **Contraseña**
   - **Teléfono**
   - **País** (México)

4. Verifica tu email
5. Completa tu perfil de negocio

---

## Paso 2: Acceder al Dashboard de Openpay

1. Inicia sesión en tu cuenta de Openpay
2. Verás el dashboard principal con tus datos

---

## Paso 3: Obtener tus Credenciales API

### 📍 Ubicación en Dashboard:
- Ve a **"Configuración"** o **"Settings"**
- Busca la sección **"API Keys"** o **"Claves API"**
- O ve directamente a: `https://dashboard.openpay.mx/settings`

### 🔍 Credenciales a Copiar:

Verás dos sets de credenciales:

#### **SANDBOX (Para Pruebas)**
```
Merchant ID:  m1234567890abcdef
Private Key:  sk_test_1234567890abcdef
Public Key:   pk_test_1234567890abcdef
```

#### **PRODUCTION (Para Dinero Real)**
```
Merchant ID:  m0987654321fedcba
Private Key:  sk_live_1234567890abcdef
Public Key:   pk_live_1234567890abcdef
```

---

## Paso 4: Configurar el Plugin

### En WordPress Admin Panel:

1. Ve a **Donaciones Openpay → Configuración**
2. Rellena los campos:

| Campo | Valor | Ejemplo |
|-------|-------|---------|
| **Merchant ID** | Copia del dashboard | `m1234567890abcdef` |
| **Private Key** | Copia del dashboard | `sk_test_1234567890abcdef` |
| **Modo** | Sandbox o Production | Sandbox (para pruebas) |

3. ⚠️ **IMPORTANTE:**
   - Usa **Sandbox** primero para hacer pruebas
   - Solo usa **Production** cuando estés listo
   - Asegúrate de copiar la **Private Key** (no la Public Key)
   - No incluyas espacios al copiar

4. Haz clic en **"Guardar Cambios"**

---

## Paso 5: Hacer una Donación de Prueba

1. Ve a tu página web donde está el botón de donación
2. Haz clic en **"Donar"**
3. Completa el formulario
4. Si te pide datos de tarjeta:
   - **En Sandbox:** Usa estas tarjetas de prueba:
     - **4111 1111 1111 1111** (Visa)
     - **5555 5555 5555 4444** (Mastercard)
   - Fecha: cualquier futura (ej: 12/25)
   - CVV: cualquier número (ej: 123)

5. Si la donación se procesa correctamente ✅ → **¡Listo!**
6. Si te da error → Ve a la sección **"Solución de Problemas"**

---

## 📋 Solución de Problemas

### ❌ Error: "No se pudo conectar al servidor"

**Causa 1: Credenciales incorrectas**
- ✅ Copia de nuevo el Merchant ID del dashboard
- ✅ Copia de nuevo la Private Key del dashboard
- ✅ Verifica sin espacios al principio o final
- ✅ Guarda los cambios

**Causa 2: Private Key incorrecta**
- ✅ Asegúrate de usar la **Private Key** (comienza con `sk_`)
- ❌ No uses la **Public Key** (comienza con `pk_`)

**Causa 3: Credenciales no coinciden**
- ✅ Si estás en **Sandbox**: Usa credenciales de **Sandbox**
- ✅ Si estás en **Production**: Usa credenciales de **Production**
- ❌ No mezcles credenciales de Sandbox con Production

**Causa 4: Problemas de servidor**
- ✅ Verifica que tu servidor tenga acceso a internet
- ✅ Verifica que SSL/HTTPS esté habilitado
- ✅ Si usas Sandbox, la URL debe ser: `sandbox-api.openpay.mx`

---

### ❌ Error: "Verifica tus credenciales"

Esto significa que Openpay rechazó la Private Key:
- Copia la Private Key exactamente como aparece en el dashboard
- Sin espacios
- Completa (no cortada)

---

### ❌ La página de pago no abre

1. Verifica que la donación se haya creado en **Historial**
2. Revisa la consola de JavaScript (F12 → Console) para mensajes de error
3. Comprueba que el proyecto esté configurado correctamente

---

### ❌ La donación se procesa pero no aparece en Openpay

Esto es normal si estás en Sandbox. En Sandbox:
- Las donaciones no son reales
- No se transfiere dinero
- Solo es para probar la integración

Para dinero real, cambia a **Production** con tus credenciales de producción.

---

## 🧪 Pruebas Recomendadas

### Prueba 1: Conexión Básica
1. Configura Sandbox
2. Haz clic en **"Donar"**
3. Si se abre la página de pago → ✅ Conexión funciona

### Prueba 2: Pago de Prueba
1. Completa el formulario de donación
2. Usa tarjeta de prueba: **4111 1111 1111 1111**
3. Si se procesa → ✅ API funciona completamente

### Prueba 3: Múltiples Montos
1. Prueba diferentes montos: $10, $50, $100
2. Verifica que aparezcan en el **Historial**

### Prueba 4: Cambio a Production
1. Obtén credenciales de Production de Openpay
2. Cambia en **Configuración** a Production
3. Prueba con dinero real (monto pequeño)

---

## 💡 Consejos

- 📌 **Guarda tus credenciales en lugar seguro** (gestor de contraseñas)
- 📌 **Nunca compartas tu Private Key** con nadie
- 📌 **Usa Sandbox para todas las pruebas**
- 📌 **Monitorea el dashboard de Openpay** para ver transacciones
- 📌 **Activa notificaciones** en Openpay para recibir alertas

---

## ❓ Preguntas Frecuentes

**P: ¿Necesito pagar para usar Openpay?**
R: No. Openpay es gratis hasta que proceses dinero. Entonces aplican comisiones.

**P: ¿Puedo cambiar de Sandbox a Production?**
R: Sí, en cualquier momento desde **Configuración**.

**P: ¿Las donaciones en Sandbox son reales?**
R: No, son solo para pruebas. No se transfiere dinero.

**P: ¿Dónde veo el dinero que recibo?**
R: En tu cuenta bancaria registrada en Openpay (toma 1-2 días).

**P: ¿Qué pasa si me equivoco con las credenciales?**
R: Puedes cambiarlas en cualquier momento. El plugin no guarda historial.

---

## 🚀 ¡Listo!

Si seguiste todos estos pasos y tu donación se procesó correctamente, **¡tu plugin de Openpay funciona perfectamente!** 🎉

---

**Última actualización:** 2024
**Versión del plugin:** 1.2+
**Documentación oficial:** [openpay.mx/docs](https://www.openpay.mx/)
