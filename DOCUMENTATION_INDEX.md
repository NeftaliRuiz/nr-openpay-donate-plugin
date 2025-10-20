# 📖 Documentación Completa - Openpay Donate Plugin

Bienvenido al plugin de Openpay para WordPress. Aquí encontrarás toda la documentación que necesitas.

---

## 🚀 Empezar Rápido (5 minutos)

### 1️⃣ Instalar el Plugin
```
1. Copia la carpeta del plugin a: wp-content/plugins/
2. Ve a WordPress → Plugins
3. Busca "Openpay Donate"
4. Haz clic en "Activar"
```

### 2️⃣ Obtener Credenciales
👉 **[Ver: OPENPAY_SETUP.md](OPENPAY_SETUP.md)** - Pasos detallados

### 3️⃣ Configurar el Plugin
```
1. Ve a: Donaciones Openpay → Configuración
2. Pega tu Merchant ID
3. Pega tu Private Key
4. Guarda cambios
```

### 4️⃣ Hacer Primera Donación
```
1. Ve a tu página con: [openpay_donate project="Nombre"]
2. Haz clic en "Donar"
3. Completa el formulario
4. ¡Hecho!
```

---

## 📚 Documentación por Tópico

### 🎯 Setup & Configuración

| Documento | Descripción | Tiempo |
|-----------|-------------|--------|
| **[OPENPAY_SETUP.md](OPENPAY_SETUP.md)** | 🔑 Cómo obtener credenciales de Openpay paso a paso | 10 min |
| **[README.md](README.md)** | 📖 Descripción general del plugin | 5 min |

### 🔧 Troubleshooting

| Documento | Descripción | Tiempo |
|-----------|-------------|--------|
| **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** | 🚨 Solución a errores comunes y diagnóstico | 15 min |

### 🧪 Testing & QA

| Documento | Descripción | Tiempo |
|-----------|-------------|--------|
| **[TESTING_GUIDE.md](TESTING_GUIDE.md)** | 🧪 Guía completa para probar el plugin | 30 min |

### 📋 Referencia Rápida

| Documento | Descripción | Tiempo |
|-----------|-------------|--------|
| **[00_START_HERE.md](00_START_HERE.md)** | ⚡ Quick start inicial | 2 min |
| **[QUICK_START.md](QUICK_START.md)** | ⚡ Guía rápida | 3 min |

---

## 🎓 Casos de Uso

### Caso 1: "No tengo Openpay aún"
```
1. Ve a: https://www.openpay.mx/
2. Crea una cuenta
3. Sigue: [OPENPAY_SETUP.md](OPENPAY_SETUP.md) → Paso 1
4. Regresa aquí cuando tengas credenciales
```

### Caso 2: "Tengo Openpay pero no sé configurar el plugin"
```
Sigue en orden:
1. [OPENPAY_SETUP.md](OPENPAY_SETUP.md) → Paso 3 a 5
2. [README.md](README.md) → Sección "Configuración"
3. [TESTING_GUIDE.md](TESTING_GUIDE.md) → Prueba 2
```

### Caso 3: "Me da un error en el plugin"
```
Sigue:
1. Copia el texto exacto del error
2. Ve a: [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
3. Busca tu error en la tabla
4. Sigue la solución indicada
```

### Caso 4: "Quiero hacer pruebas antes de producción"
```
Sigue completamente:
[TESTING_GUIDE.md](TESTING_GUIDE.md)

Incluye 11 pruebas diferentes que cubren:
- Configuración básica
- Interfaz del modal
- Validaciones
- Donación completa
- Múltiples montos/emails
- Panel admin
- Responsive design
- Manejo de errores
- Cambio a producción
```

### Caso 5: "Quiero pasar a dinero real (Production)"
```
1. Obtén credenciales de Production en Openpay
2. Ve a: Donaciones Openpay → Configuración
3. Reemplaza credenciales por las de Production
4. Cambia Modo a "Production"
5. Guarda
6. Haz test con monto pequeño ($1 MXN)
7. Verifica que aparezca en tu cuenta
8. ¡Listo! Ya puedes recibir donaciones reales
```

---

## 📊 Flujo Típico de Implementación

```
┌─────────────────────────────────────────────┐
│  1. SETUP INICIAL                            │
│  - Crear cuenta Openpay                      │
│  - Obtener credenciales (Merchant + Key)     │
│  📖 Ver: OPENPAY_SETUP.md                    │
└────────────┬────────────────────────────────┘
             ↓
┌─────────────────────────────────────────────┐
│  2. CONFIGURACIÓN PLUGIN                     │
│  - Activar plugin en WordPress               │
│  - Ingresar credenciales                     │
│  - Seleccionar Sandbox (pruebas)             │
│  📖 Ver: README.md → Configuración            │
└────────────┬────────────────────────────────┘
             ↓
┌─────────────────────────────────────────────┐
│  3. TESTING & PRUEBAS                        │
│  - Hacer donaciones de prueba                │
│  - Verificar funcionalidad                   │
│  - Revisar panel admin                       │
│  📖 Ver: TESTING_GUIDE.md                    │
└────────────┬────────────────────────────────┘
             ↓
┌─────────────────────────────────────────────┐
│  4. SOLUCIÓN DE PROBLEMAS (SI APLICA)       │
│  - Si algo falla, diagnosticar               │
│  - Aplicar soluciones recomendadas           │
│  📖 Ver: TROUBLESHOOTING.md                  │
└────────────┬────────────────────────────────┘
             ↓
┌─────────────────────────────────────────────┐
│  5. PRODUCCIÓN                               │
│  - Obtener credenciales Production           │
│  - Cambiar a modo Production                 │
│  - Monitorear donaciones reales              │
│  📖 Ver: TESTING_GUIDE.md → Prueba 10        │
└─────────────────────────────────────────────┘
```

---

## 🆘 ¿Necesitas Ayuda?

### Encuentro un Error...
1. Anota el **texto exacto del error**
2. Ve a **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)**
3. Busca tu error en la sección de "Errores Comunes"
4. Sigue la solución

### Si el error no está en Troubleshooting...
1. Ve a **[TESTING_GUIDE.md](TESTING_GUIDE.md)** → "Reporte de Bugs"
2. Documenta:
   - Qué hiciste
   - Qué esperabas
   - Qué sucedió
   - Screenshot del error
3. Contacta:
   - Openpay: support@openpay.mx
   - Tu hosting: si es del servidor

### Preguntas Sobre Openpay
- 📖 Documentación: https://www.openpay.mx/docs
- 💬 Soporte: support@openpay.mx

---

## 🎓 Glosario de Términos

| Término | Explicación |
|---------|-------------|
| **Merchant ID** | Tu identificador único en Openpay |
| **Private Key** | Tu clave privada para autenticación (comienza con `sk_`) |
| **Public Key** | Tu clave pública (⚠️ NO la uses en backend, comienza con `pk_`) |
| **Sandbox** | Ambiente de pruebas, no cobra dinero real |
| **Production** | Ambiente real, cobra dinero real |
| **Session ID** | Identificador único de cada transacción |
| **Checkout Session** | La sesión de pago de Openpay |

---

## ⚙️ Archivos del Plugin

```
openpay-donate-plugin/
├── openpay-donate-plugin.php    ← Archivo principal
├── js/
│   └── openpay-donate.js        ← Lógica JavaScript
├── css/
│   ├── openpay-donate.css       ← Estilos formulario
│   └── openpay-admin.css        ← Estilos panel admin
│
├── 📖 DOCUMENTACIÓN:
├── README.md                    ← General
├── OPENPAY_SETUP.md             ← Setup detallado
├── TROUBLESHOOTING.md           ← Errores
├── TESTING_GUIDE.md             ← Pruebas
├── 00_START_HERE.md             ← Quick start
│
└── (Otros archivos de referencia)
```

---

## ✅ Checklist: ¿Estoy Listo?

Antes de usar en producción, asegúrate de marcar todo:

```
SETUP:
☐ Tengo cuenta de Openpay
☐ Tengo Merchant ID
☐ Tengo Private Key
☐ Plugin activado en WordPress

CONFIGURACIÓN:
☐ Credenciales ingresadas en el plugin
☐ Modo "Sandbox" seleccionado
☐ Cambios guardados

TESTING:
☐ Página del plugin carga sin errores
☐ Botón "Donar" visible
☐ Modal se abre correctamente
☐ Puedo hacer donación de prueba
☐ Donación aparece en historial
☐ Panel admin muestra estadísticas

PRODUCCIÓN:
☐ Tengo credenciales de Production
☐ He hecho prueba con dinero real ($1)
☐ El dinero llegó a mi cuenta bancaria
☐ Estoy listo para recibir donaciones reales
```

---

## 🎯 Resumen por Rol

### 👤 Administrador del Sitio
**Tu tarea:** Instalar y configurar el plugin
- **Leer:** [OPENPAY_SETUP.md](OPENPAY_SETUP.md)
- **Tiempo:** 15 minutos
- **Resultado:** Plugin funcionando

### 🧪 Tester/QA
**Tu tarea:** Verificar que todo funciona
- **Leer:** [TESTING_GUIDE.md](TESTING_GUIDE.md)
- **Tiempo:** 1-2 horas
- **Resultado:** Reporte de calidad

### 🔧 Desarrollador
**Tu tarea:** Mantener y mejorar el plugin
- **Leer:** [README.md](README.md) + código fuente
- **Referencia:** [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
- **Tiempo:** Variables

---

## 📅 Últimas Actualizaciones

| Archivo | Cambio | Fecha |
|---------|--------|-------|
| **openpay-donate-plugin.php** | Mejorada ayuda de configuración | 2024 |
| **css/openpay-admin.css** | Estilos mejorados para caja de ayuda | 2024 |
| **OPENPAY_SETUP.md** | 📄 Creado - Guía setup detallada | 2024 |
| **TROUBLESHOOTING.md** | 📄 Creado - Solución de errores | 2024 |
| **TESTING_GUIDE.md** | 📄 Creado - Guía de pruebas | 2024 |

---

## 🚀 ¿Listo para Empezar?

### Opción A: Primer Tiempo
```
1. Lee: 00_START_HERE.md (2 min)
2. Lee: OPENPAY_SETUP.md (10 min)
3. Configura el plugin (5 min)
4. Haz primera prueba (5 min)
✅ Total: ~25 minutos
```

### Opción B: Quiero Hacerlo Bien
```
1. Lee: README.md (5 min)
2. Lee: OPENPAY_SETUP.md (10 min)
3. Lee: TESTING_GUIDE.md (30 min)
4. Prueba todas las 11 pruebas (1 hora)
5. Si hay error, ve a TROUBLESHOOTING.md
✅ Total: ~2 horas
```

### Opción C: Solo Tengo Problemas
```
1. Ve a: TROUBLESHOOTING.md
2. Busca tu error
3. Sigue la solución
✅ Total: ~5-15 minutos
```

---

**¿Qué vas a hacer?** 👇

- 🚀 [Empezar Setup (OPENPAY_SETUP.md)](OPENPAY_SETUP.md)
- 🧪 [Hacer Pruebas (TESTING_GUIDE.md)](TESTING_GUIDE.md)
- 🔧 [Resolver Error (TROUBLESHOOTING.md)](TROUBLESHOOTING.md)
- 📖 [Ver Documentación General (README.md)](README.md)

---

**Versión del Plugin:** 1.2+
**Última Actualización:** 2024
**Estado:** ✅ Producción Lista
