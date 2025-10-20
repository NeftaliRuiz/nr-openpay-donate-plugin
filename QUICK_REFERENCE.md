# ⚡ Quick Reference Card

Una tarjeta de referencia rápida para consultar mientras usas el plugin.

---

## 🎯 Shortcode

```
[openpay_donate project="Nombre del Proyecto"]
```

**Ejemplo completo:**
```
[openpay_donate project="Fondo de Educación"]
[openpay_donate project="Ayuda Humanitaria"]
[openpay_donate project="Becas Universitarias"]
```

---

## ⚙️ Configuración del Plugin

**Ubicación:** WordPress → Donaciones Openpay → Configuración

### Campos Requeridos

| Campo | Ejemplo | Nota |
|-------|---------|------|
| **Merchant ID** | `m1234567890abcdef` | Del dashboard Openpay |
| **Private Key** | `sk_test_1234567890` | Comienza con `sk_` |
| **Modo** | Sandbox o Production | Sandbox para pruebas |

### Obtener Credenciales

1. Ve a: https://dashboard.openpay.mx/
2. Login con tu cuenta
3. Ve a: Settings → API Keys
4. Copia Merchant ID y Private Key
5. Pega en el plugin
6. Guarda

---

## 📊 Panel de Admin

**Ubicación:** WordPress → Donaciones Openpay

### Qué ves:

- **Donaciones Totales:** Número total de transacciones
- **Ingresos Totales:** Suma de todos los montos en MXN
- **Último Donante:** Email de quién donó más recientemente
- **Historial:** Lista de todas las donaciones

### Información por Donación:

| Campo | Significado |
|-------|-------------|
| Proyecto | Nombre del proyecto |
| Email | Email del donante |
| Monto | Cantidad en MXN |
| Estado | created/completed/failed |
| Fecha | Cuándo se hizo |

---

## 🧪 Tarjetas de Prueba (Sandbox)

Usa estas en modo Sandbox para probar:

| Tarjeta | Número | Resultado |
|---------|--------|-----------|
| Visa | 4111 1111 1111 1111 | ✅ Aprobada |
| Mastercard | 5555 5555 5555 4444 | ✅ Aprobada |

**Fecha de Vencimiento:** Cualquier fecha futura (ej: 12/25)
**CVV:** Cualquier número (ej: 123)
**Nombre:** Cualquier texto

---

## 🚨 Errores Comunes & Soluciones

### Error: "No se pudo conectar al servidor"

| Causa | Solución |
|-------|----------|
| Credenciales vacías | Rellena Merchant ID y Private Key |
| Credenciales incorrectas | Cópialas de nuevo del dashboard |
| Private Key (no Public Key) | Asegúrate que sea `sk_` no `pk_` |
| Sandbox/Production mismatch | Usa credenciales del mismo ambiente |
| Sin HTTPS | Tu sitio debe tener HTTPS |

### Error: "Verifica tus credenciales"

→ Código HTTP 401
→ La Private Key es rechazada por Openpay
→ Cópialas de nuevo exactamente como aparece

### Error: "Datos inválidos"

→ Código HTTP 400
→ Revisa:
- ¿Monto es número?
- ¿Email tiene formato correcto?
- ¿Proyecto está especificado en shortcode?

---

## 🎨 Personalización

### Cambiar Color del Botón

**Archivo:** `css/openpay-donate.css` (línea ~23)

```css
background: linear-gradient(135deg, #TUCOLOR1 0%, #TUCOLOR2 100%);
```

**Ejemplo - Color azul:**
```css
background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
```

### Cambiar Textos

**Archivo:** `openpay-donate-plugin.php`

Busca la palabra que quieres cambiar y reemplazala.
No cambies código PHP, solo textos visibles.

---

## 💾 Base de Datos

### Tabla: wp_openpay_donations

**Campos:**
- `id` - Identificador único
- `project` - Nombre proyecto
- `amount` - Monto en MXN
- `email` - Email donante
- `session_id` - ID de Openpay
- `status` - Estado transacción
- `created_at` - Fecha/hora

**Hacer Backup:**
```bash
mysqldump -u usuario -p base_datos wp_openpay_donations > backup.sql
```

---

## ✅ Checklist: Antes de Producción

```
□ Merchant ID configurado ✓
□ Private Key configurada ✓
□ Plugin activado ✓
□ Botón "Donar" visible ✓
□ Modal abre correctamente ✓
□ Donación de prueba funciona ✓
□ Estadísticas actualizan ✓
□ HTTPS activado en sitio ✓
□ Credenciales guardadas (respaldo) ✓
□ Primer usuario notificado ✓
```

Cuando todo esté ✓:
1. Obtén credenciales de Production en Openpay
2. En plugin: Cambia credenciales
3. En plugin: Cambia Modo a "Production"
4. Guarda cambios
5. ¡Listo para dinero real!

---

## 📞 Contactos

| Problema | Contacto |
|----------|----------|
| Plugin no funciona | Revisa [TROUBLESHOOTING.md](TROUBLESHOOTING.md) |
| Error de Openpay | support@openpay.mx |
| Problema de servidor | Tu proveedor hosting |
| Pregunta técnica | Documentación en el plugin |

---

## 🔗 Enlaces Rápidos

- 📖 [Documentación Completa](DOCUMENTATION_INDEX.md)
- 🔑 [Setup Detallado](OPENPAY_SETUP.md)
- 🔧 [Solución de Problemas](TROUBLESHOOTING.md)
- 🧪 [Guía de Testing](TESTING_GUIDE.md)
- 🏠 [README](README.md)

---

## 🌐 Openpay Info

**Sitio Web:** https://www.openpay.mx/
**Dashboard:** https://dashboard.openpay.mx/
**Documentación:** https://www.openpay.mx/docs
**Soporte:** support@openpay.mx

---

## ⌨️ Atajos

| Atajo | Significa |
|-------|-----------|
| wp-admin | Panel de administración WordPress |
| AJAX | Solicitud asíncrona sin recargar página |
| Nonce | Token de seguridad único |
| Sandbox | Ambiente de pruebas |
| Production | Ambiente real con dinero |
| HTTP 200/201 | ✅ Éxito |
| HTTP 401 | ❌ Credenciales mal |
| HTTP 400 | ❌ Datos inválidos |
| HTTP 500 | ❌ Error servidor Openpay |

---

## 🎯 Flujo de Donación

```
Usuario
   ↓
[Haz clic: "Donar"]
   ↓
[Modal abre]
   ↓
[Completa: Monto, Email]
   ↓
[Clic: "Procesar"]
   ↓
[AJAX → Servidor]
   ↓
[Server → Openpay API]
   ↓
[Openpay: Crea session]
   ↓
[Redirige a pago]
   ↓
[Usuario: Paga tarjeta]
   ↓
[Openpay: Procesa pago]
   ↓
[Redirige a sitio]
   ↓
[Admin: Ve en panel]
```

---

## 🔐 Seguridad Rápida

✅ **Private Key:** Nunca la compartas
✅ **HTTPS:** Sitio debe tener certificado SSL
✅ **Backups:** Haz backup de BD regularmente
✅ **Actualizaciones:** Mantén WordPress actualizado
✅ **Permisos:** Solo admin puede configurar plugin

---

## 📊 Estadísticas

**Montos Típicos:**
- Mínimo sugerido: $1 MXN
- Máximo: Depende de Openpay

**Transacciones:**
- Sandbox: Inmediatas (no cobran)
- Production: En tiempo real

**Dinero:**
- Aparece en: 1-2 días hábiles
- Comisión: Según contrato con Openpay
- Retiros: Desde dashboard Openpay

---

## 🎓 Glosario

- **Merchant ID** = Tu identificador único
- **Private Key** = Tu contraseña de API
- **Public Key** = ❌ No uses (solo frontend)
- **Session** = Sesión de pago única
- **Checkout** = Página de pago
- **Webhook** = Notificación automática
- **Nonce** = Token de seguridad

---

## 📱 Responsive

El plugin funciona en:
- ✅ Desktop (monitor)
- ✅ Tablet (iPad)
- ✅ Móvil (celular)

Sin configuración adicional.

---

## ⚙️ Requerimientos

- **WordPress:** 5.0+
- **PHP:** 7.4+
- **MySQL:** 5.6+
- **HTTPS:** Obligatorio
- **Internet:** Conexión requerida

---

## 💡 Tips Útiles

1. **Sandbox primero** → Siempre prueba antes
2. **Backup de credenciales** → Guárdalas en lugar seguro
3. **Monitorea donaciones** → Revisa panel regularmente
4. **Comunica cambios** → Avisa a usuarios si cambias
5. **Lee documentación** → Tenemos 30+ archivos

---

## 🆘 SOS Rápido

**El plugin no funciona:**
1. ¿Está activado? → Plugins → Activa
2. ¿Credenciales configuradas? → Configuración → Rellena
3. ¿HTTPS activo? → URL debe ser https://
4. ¿Sin errores? → Mira [TROUBLESHOOTING.md](TROUBLESHOOTING.md)

**La donación falla:**
1. Mira el error exacto
2. Busca en [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
3. Sigue la solución

**No sé cómo empezar:**
1. Lee [OPENPAY_SETUP.md](OPENPAY_SETUP.md)
2. Obtén credenciales
3. Configura en WordPress
4. Haz prueba

---

**Versión:** 1.2+
**Última Actualización:** 2024
**Estado:** ✅ Producción Lista

---

## 🎯 Siguientes Pasos

1. **Ahora:** Lee [DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md)
2. **Después:** Sigue [OPENPAY_SETUP.md](OPENPAY_SETUP.md)
3. **Luego:** Haz pruebas con [TESTING_GUIDE.md](TESTING_GUIDE.md)
4. **Finalmente:** ¡Recibe donaciones! 🎉
