# 🚀 Quick Start - One Pager

**¿Qué es esto?** Un resumen super breve (2 minutos) para empezar YA.

---

## 1️⃣ Instalar Plugin

```
1. Carpeta: wp-content/plugins/openpay-donate/
2. WordPress → Plugins → Activar "Openpay Donate"
✅ LISTO
```

---

## 2️⃣ Obtener Credenciales

```
1. Ve a: https://dashboard.openpay.mx/
2. Login
3. Settings → API Keys
4. Copia:
   - Merchant ID
   - Private Key (comienza con sk_)
✅ Tienes dos códigos
```

---

## 3️⃣ Configurar Plugin

```
En WordPress:

Donaciones Openpay → Configuración

Pega:
□ Merchant ID: [tu codigo]
□ Private Key: [tu codigo]
□ Modo: Sandbox ← IMPORTANTE
□ Guardar Cambios

✅ Configurado
```

---

## 4️⃣ Usar en tu Página

```
En cualquier página/post:

[openpay_donate project="Mi Proyecto"]

Ejemplo:
[openpay_donate project="Educación"]
[openpay_donate project="Salud"]

✅ Botón "Donar" aparece
```

---

## 5️⃣ Hacer Prueba

```
1. Haz clic en "Donar"
2. Modal abre
3. Ingresa:
   Monto: 50
   Email: tu@correo.com
4. Clic "Procesar"
5. Página de pago Openpay

Tarjeta prueba:
4111 1111 1111 1111
Mes/Año: 12/25
CVV: 123

✅ ¡Donación hecha!
```

---

## 6️⃣ Ver en Admin

```
WordPress → Donaciones Openpay

Ves:
✅ Estadísticas (montos, cantidad)
✅ Historial (todas donaciones)
✅ Tu donación de prueba

✅ ¡TODO FUNCIONA!
```

---

## 🆘 Si Algo Falla

### Error: "No se pudo conectar"
→ Copia credenciales de nuevo (sin espacios)

### Error: "Datos inválidos"
→ Monto debe ser número, email válido

### No aparece el botón
→ Revisa que el shortcode esté bien escrito

**Más ayuda:** Ver [TROUBLESHOOTING.md](TROUBLESHOOTING.md)

---

## ⏰ Tiempo Total

- Instalar: 2 min
- Obtener credenciales: 5 min
- Configurar: 2 min
- Hacer prueba: 5 min

**Total: ~15 minutos** ⏱️

---

## 📞 Documentación Completa

- 📖 Setup detallado: [OPENPAY_SETUP.md](OPENPAY_SETUP.md)
- 🔧 Si hay errores: [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
- 🧪 Pruebas completas: [TESTING_GUIDE.md](TESTING_GUIDE.md)
- 📚 Índice completo: [DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md)

---

**¿Listo?** → Empieza en paso 1️⃣

**¿Atascado?** → Ve [TROUBLESHOOTING.md](TROUBLESHOOTING.md)

**¿Preguntas?** → Lee [DOCUMENTATION_INDEX.md](DOCUMENTATION_INDEX.md)

---

✅ **Hecho en 15 minutos**
