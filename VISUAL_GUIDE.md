# 🎨 Guía Visual - Openpay Donaciones Plugin

## 📱 Vista del Formulario (Frontend)

### En Desktop
```
┌─────────────────────────────────┐
│  🎁  Hacer una Donación         │
├─────────────────────────────────┤
│                                 │
│  Proyecto                       │
│  Mi Proyecto Especial           │
│                                 │
│  Correo electrónico             │
│  ┌─────────────────────────────┐│
│  │ tu@correo.com               ││
│  └─────────────────────────────┘│
│                                 │
│  Monto de donación (MXN)        │
│  ┌─────────────────────────────┐│
│  │ $  0.00                     ││
│  └─────────────────────────────┘│
│                                 │
│  ┌─────────────────────────────┐│
│  │ CONTINUAR CON OPENPAY       ││
│  └─────────────────────────────┘│
│                                 │
│  🔒 Pagos seguros por Openpay   │
│                                 │
└─────────────────────────────────┘
```

### En Móvil
```
┌───────────────┐
│ 🎁 Hacer una  │
│    Donación   │
├───────────────┤
│               │
│ Proyecto      │
│ Mi Proyecto   │
│               │
│ Correo        │
│ ┌───────────┐ │
│ │ tu@correo ││ │
│ └───────────┘ │
│               │
│ Monto (MXN)   │
│ ┌───────────┐ │
│ │ $ 0.00    ││ │
│ └───────────┘ │
│               │
│ ┌───────────┐ │
│ │ CONTINUAR ││ │
│ └───────────┘ │
│ 🔒 Pagos      │
│    seguros    │
└───────────────┘
```

---

## 📊 Panel de Administración

### Dashboard Principal
```
┌────────────────────────────────────────┐
│ 📊 Resumen de Donaciones              │
│ Historial completo de tus donaciones  │
├────────────────────────────────────────┤
│                                        │
│  ┌──────────────────┐ ┌─────────────┐ │
│  │ 💰 Monto Total   │ │ 🎁 Donacio. │ │
│  │ $15,450.00 MXN   │ │     128     │ │
│  └──────────────────┘ └─────────────┘ │
│                                        │
├────────────────────────────────────────┤
│ Historial de Donaciones (128 total)   │
├────────────────────────────────────────┤
│                                        │
│ Proyecto: ONG Educación               │ ├─  Email: juan@ejemplo.com        │
│                        $500.00 MXN     │ │ Completado | 15/10/2025         │
│                                        │ │
│ Proyecto: Becas Universitarias        │ ├─  Email: maria@ejemplo.com       │
│                        $1,000.00 MXN   │ │ Completado | 14/10/2025         │
│                                        │ │
│ Proyecto: Fondo de Emergencia         │ ├─  Email: carlos@ejemplo.com      │
│                        $300.00 MXN     │ │ Pendiente | 13/10/2025          │
│                                        │ │
│ ... más donaciones ...                │
│                                        │
└────────────────────────────────────────┘
```

### Página de Configuración
```
┌────────────────────────────────────────┐
│ ⚙️ Configuración de Openpay           │
│ Gestiona tus credenciales de pago     │
├────────────────────────────────────────┤
│                                        │
│ Merchant ID                            │
│ ┌────────────────────────────────────┐│
│ │ mk_live_1234567890abcdef...        ││
│ └────────────────────────────────────┘│
│ Encuéntralo en tu panel de Openpay    │
│                                        │
│ Private Key                            │
│ ┌────────────────────────────────────┐│
│ │ ••••••••••••••••••••••••••••        ││
│ └────────────────────────────────────┘│
│ Mantén esto seguro y nunca lo comp... │
│                                        │
│ Modo de Operación                      │
│ ┌────────────────────────────────────┐│
│ │ [v] Sandbox (Pruebas)              ││
│ │ [ ] Producción (En vivo)           ││
│ └────────────────────────────────────┘│
│ En Sandbox sin cobrar. Prod. real...  │
│                                        │
│ [GUARDAR CONFIGURACIÓN]                │
│                                        │
├────────────────────────────────────────┤
│ ❓ ¿Necesitas ayuda?                   │
│ Si no tienes credenciales, crea       │
│ una cuenta aquí: openpay.mx           │
└────────────────────────────────────────┘
```

---

## 🎨 Esquema de Colores

### Colores Principales
```
┌──────────────────────────────────┐
│ Azul Openpay Primario            │ #0066cc
│ ███████████████████████████████  │
└──────────────────────────────────┘

┌──────────────────────────────────┐
│ Azul Openpay Oscuro              │ #0052a3
│ ███████████████████████████████  │
└──────────────────────────────────┘

┌──────────────────────────────────┐
│ Azul Claro (Fondo)               │ #e6f0ff
│ ███████████████████████████████  │
└──────────────────────────────────┘
```

### Estados
```
✅ Éxito:    #10b981 ███ Verde
❌ Error:    #ef4444 ███ Rojo
⚠️  Advertencia: #f59e0b ███ Amarillo
⏳ Pendiente: #dbeafe ███ Azul claro
```

---

## 🔄 Flujo Visual de Donación

```
┌─────────────┐
│ 👤 Usuario  │
│ Accede a    │
│ página      │
└──────┬──────┘
       │
       ▼
┌──────────────────┐
│ 📋 Ve formulario │
│ Openpay moderno  │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ ✍️  Completa:    │
│ • Email          │
│ • Monto          │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ 🔍 Se valida     │
│ información      │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ 🌐 Abre Openpay  │
│ Checkout         │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ 💳 Usuario entra │
│ datos de tarjeta │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ ✔️  Openpay      │
│ procesa pago     │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ ✨ Donación      │
│ confirmada       │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ 📊 Aparece en    │
│ panel admin      │
└──────────────────┘
```

---

## 📱 Responsive Breakpoints

### Desktop (1200px+)
```
┌──────────────────────────────────┐
│                                  │
│    [Formulario de Donación]      │
│    [Panel 100% visible]          │
│                                  │
└──────────────────────────────────┘
```

### Tablet (768px - 1199px)
```
┌────────────────────┐
│                    │
│  [Formulario]      │
│  [Adaptado]        │
│                    │
└────────────────────┘
```

### Móvil (480px - 767px)
```
┌──────────┐
│          │
│[Formula] │
│[Compacto]│
│          │
└──────────┘
```

---

## 🎯 Componentes Visuales

### Card de Estadísticas
```
┌─────────────────────┐
│ 💰                  │
│ Monto Total         │
│ $15,450.00 MXN      │
└─────────────────────┘

┌─────────────────────┐
│ 🎁                  │
│ Total de Donaciones │
│ 128                 │
└─────────────────────┘
```

### Item de Donación
```
┌───────────────────────────────────────┐
│                                       │
│ Proyecto: ONG Educación               │
│ Email: donante@ejemplo.com            │
│                                       │
│                    $500.00 MXN        │
│                    Completado         │
│                    15/10/2025         │
│                                       │
└───────────────────────────────────────┘
```

### Botón Principal
```
Normal:
┌─────────────────────────────────┐
│ CONTINUAR CON OPENPAY           │
└─────────────────────────────────┘

Hover:
┌─────────────────────────────────┐
│ CONTINUAR CON OPENPAY           │ ▲ (Sube un poco)
└─────────────────────────────────┘
   ▬ (Sombra más pronunciada)

Clic:
┌─────────────────────────────────┐
│ PROCESANDO...                   │
└─────────────────────────────────┘
```

---

## 🌐 Estructura de Menús (Admin)

```
WordPress Admin
├── Openpay Donaciones (Principal) ⭐
│   ├── Dashboard 📊
│   │   ├── Estadísticas
│   │   └── Historial de Donaciones
│   │
│   └── Configuración ⚙️
│       ├── Merchant ID
│       ├── Private Key
│       └── Modo (Sandbox/Producción)
│
└── (Otros menús de WordPress)
```

---

## 📊 Tabla de Donaciones

```
┌─────────────────────────────────────────────────────────────┐
│ Historial de Donaciones                                     │
├──────┬─────────────────┬────────┬───────────┬────────────────┤
│ ID   │ Proyecto        │ Email  │ Monto     │ Estado | Fecha │
├──────┼─────────────────┼────────┼───────────┼────────────────┤
│ 128  │ ONG Educación   │ j@c.mx │ $500.00   │ ✅ 15/10/2025 │
├──────┼─────────────────┼────────┼───────────┼────────────────┤
│ 127  │ Becas Univ.     │ m@c.mx │ $1000.00  │ ✅ 14/10/2025 │
├──────┼─────────────────┼────────┼───────────┼────────────────┤
│ 126  │ Emergencia      │ c@c.mx │ $300.00   │ ⏳ 13/10/2025 │
├──────┼─────────────────┼────────┼───────────┼────────────────┤
│ ...  │ ...             │ ...    │ ...       │ ...            │
└──────┴─────────────────┴────────┴───────────┴────────────────┘
```

---

## 🎨 Variaciones de Diseño Personalizados

### Tema Verde (Ecología)
```
Primario: #22c55e (Verde)
├── #16a34a (Verde oscuro)
└── #dcfce7 (Verde claro)

Uso: Proyectos de sostenibilidad
```

### Tema Rojo (Urgencia/Salud)
```
Primario: #ef4444 (Rojo)
├── #dc2626 (Rojo oscuro)
└── #fee2e2 (Rojo claro)

Uso: Emergencias sanitarias
```

### Tema Púrpura (Premium)
```
Primario: #a855f7 (Púrpura)
├── #9333ea (Púrpura oscuro)
└── #f3e8ff (Púrpura claro)

Uso: Servicios premium
```

---

## 💬 Mensajes Visuales

### Error
```
┌───────────────────────────────┐
│ ❌ Por favor ingresa un correo  │
│    electrónico válido.         │
└───────────────────────────────┘
(Fondo rojo claro, texto rojo)
```

### Éxito
```
┌───────────────────────────────┐
│ ✅ Configuración guardada     │
│    correctamente.             │
└───────────────────────────────┘
(Fondo verde claro, texto verde)
```

### Información
```
┌───────────────────────────────┐
│ ℹ️  Estás en modo Sandbox      │
│    (Pruebas sin cobrar).      │
└───────────────────────────────┘
(Fondo azul claro, texto azul)
```

---

## 🖼️ Composición del Formulario

```
Header (Gradiente Azul)
├── Icono (SVG)
└── Título "Hacer una Donación"

Contenido Formulario
├── Campo: Proyecto (Solo lectura)
├── Campo: Email (Input)
├── Campo: Monto (Input con $)
├── Mensaje (Error/Éxito)
├── Botón Principal
└── Footer Seguridad

Footer (Borde superior)
├── Icono Candado
└── Texto "Pagos seguros..."
```

---

## 📊 Estados de Donaciones (Colores)

```
Creado 🟨
┌─────────────────┐
│ CREADO          │
│ (Amarillo)      │
└─────────────────┘

Pendiente 🟦
┌─────────────────┐
│ PENDIENTE       │
│ (Azul)          │
└─────────────────┘

Completado 🟩
┌─────────────────┐
│ COMPLETADO      │
│ (Verde)         │
└─────────────────┘

Fallido 🟥
┌─────────────────┐
│ FALLIDO         │
│ (Rojo)          │
└─────────────────┘
```

---

## 🎯 Áreas Interactivas

### Click en:
- Botón "Continuar" → Valida y envía
- Campo Email → Acepta input
- Campo Monto → Acepta números
- Menú Openpay → Abre Dashboard
- Configuración → Edita credenciales

### Hover en:
- Botones → Se elevan
- Links → Subrayado
- Cards → Cambio de sombra

---

## 📱 Ejemplo de Shortcode Visual

### Input:
```
[openpay_donate project="Salva Vidas"]
```

### Output:
```
┌─────────────────────────────────┐
│  🎁  Hacer una Donación         │
├─────────────────────────────────┤
│                                 │
│  Proyecto: Salva Vidas          │
│                                 │
│  Correo electrónico             │
│  [_________________________]     │
│                                 │
│  Monto de donación (MXN)        │
│  [$ ________________________]    │
│                                 │
│  [CONTINUAR CON OPENPAY]        │
│                                 │
│  🔒 Pagos seguros por Openpay   │
│                                 │
└─────────────────────────────────┘
```

---

## 🚀 Animaciones y Transiciones

### Botón Hover
```
Estado normal → Estado hover
Sube 2px (transform: translateY(-2px))
Sombra más pronunciada
Transición suave (0.3s)
```

### Mensajes
```
Fade in cuando aparecen
Fade out cuando desaparecen
Duración: 300ms
```

### Carga
```
Botón → Disabled state
Opacidad reducida
Cursor not-allowed
```

---

## 🎓 Tipografía

### Jerarquía
```
Títulos (h1, h2): 28px, 600 bold
Etiquetas: 13px, 600 bold
Texto normal: 14px, 400 regular
Small/Helper: 12px, 400 regular
```

### Espaciados
```
Padding botón: 12-14px
Margin campos: 20px
Gap componentes: 8-20px
Border radius: 6-8px
```

---

Este documento visual ayuda a entender el diseño completo del plugin.

**Generado:** 20 de Octubre de 2025  
**Plugin:** Openpay Donaciones v1.2
