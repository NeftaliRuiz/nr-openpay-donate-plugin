# 🧪 Guía de Testing y Pruebas

Cómo probar completamente el plugin de Openpay antes de usarlo en producción.

---

## 📋 Antes de Empezar

### Requisitos:
- ✅ Cuenta de Openpay (sandbox)
- ✅ WordPress 5.0+ instalado
- ✅ Plugin Openpay Donate instalado
- ✅ Acceso a wp-admin
- ✅ Acceso a dashboard.openpay.mx

---

## 🔧 Prueba 1: Configuración Básica

### Objetivo: Verificar que el plugin está activado y configurado

**Pasos:**
```
1. En WordPress, ve a: wp-admin/admin.php?page=openpay_donations
   Resultado esperado:
   ✅ Ves página "Donaciones Openpay"
   ✅ Ves gráfico de estadísticas
   ✅ Ves historial de donaciones (vacío al inicio)

2. Haz clic en "Configuración"
   Resultado esperado:
   ✅ Ves formulario con 3 campos:
      - Merchant ID (vacío)
      - Private Key (vacío)
      - Modo: Sandbox / Production (Sandbox seleccionado)

3. Ve a tu página web donde está el shortcode
   [openpay_donate project="MiProyecto"]
   
   Resultado esperado:
   ✅ Ves un botón azul que dice "Donar"
   ✅ El botón se ve compacto
   ✅ El botón responde al hover (color más oscuro)
```

---

## 🔐 Prueba 2: Configuración de Credenciales

### Objetivo: Verificar que las credenciales se guardan correctamente

**Pasos:**
```
1. Ve a Donaciones Openpay → Configuración

2. En dashboard.openpay.mx/settings:
   - Copia tu Merchant ID
   - Copia tu Private Key (sk_test_...)

3. En WordPress, en el formulario de Configuración:
   - Pega Merchant ID en el primer campo
   - Pega Private Key en el segundo campo
   - Verifica "Sandbox" está seleccionado

4. Haz clic en "Guardar Cambios"
   Resultado esperado:
   ✅ Ves mensaje "Configuración guardada"
   ✅ Los campos mantienen tus valores

5. Recarga la página
   Resultado esperado:
   ✅ Los valores siguen ahí
   ✅ La configuración se guardó en base de datos
```

---

## 🎯 Prueba 3: Interfaz del Modal

### Objetivo: Verificar que el modal se abre correctamente

**Pasos:**
```
1. Ve a tu página web con el botón de donación

2. Haz clic en el botón "Donar"
   Resultado esperado:
   ✅ Aparece un modal oscuro de fondo (backdrop)
   ✅ En el centro aparece un formulario blanco
   ✅ El formulario tiene estos campos:
      - Proyecto (lectura, no editable): "MiProyecto"
      - Monto (input numérico): [_____]
      - Email (input email): [_____]
      - Botón "Procesar Donación"
      - Botón "Cerrar" (X en la esquina)

3. Haz clic en la X para cerrar
   Resultado esperado:
   ✅ El modal desaparece
   ✅ Estás de vuelta en la página normal

4. Abre el modal de nuevo
   Haz clic fuera del modal (en el fondo oscuro)
   Resultado esperado:
   ✅ El modal se cierra
   ✅ Funciona el click fuera para cerrar
```

---

## ✏️ Prueba 4: Validación de Formulario

### Objetivo: Verificar que el formulario valida datos correctamente

**Pasos:**

#### 4.1 - Monto vacío
```
1. Abre el modal
2. Deja "Monto" vacío
3. Completa Email: test@test.com
4. Haz clic "Procesar Donación"

Resultado esperado:
❌ Error: "Por favor completa todos los campos"
   O similar
✅ La donación NO se procesa
```

#### 4.2 - Monto inválido
```
1. Abre el modal
2. Ingresa Monto: "abc" (letras)
3. Completa Email: test@test.com
4. Haz clic "Procesar Donación"

Resultado esperado:
❌ Error: "El monto debe ser un número"
   O no permite ingresar letras
✅ La donación NO se procesa
```

#### 4.3 - Monto negativo
```
1. Abre el modal
2. Ingresa Monto: "-100"
3. Completa Email: test@test.com
4. Haz clic "Procesar Donación"

Resultado esperado:
❌ Error: "El monto debe ser mayor a 0"
   O "Monto inválido"
✅ La donación NO se procesa
```

#### 4.4 - Email vacío
```
1. Abre el modal
2. Ingresa Monto: 50
3. Deja Email vacío
4. Haz clic "Procesar Donación"

Resultado esperado:
❌ Error: "Por favor completa todos los campos"
✅ La donación NO se procesa
```

#### 4.5 - Email inválido
```
1. Abre el modal
2. Ingresa Monto: 50
3. Ingresa Email: "notanemail" (sin @)
4. Haz clic "Procesar Donación"

Resultado esperado:
❌ Error: "Email inválido"
   O no acepta el formato
✅ La donación NO se procesa
```

#### 4.6 - Datos válidos
```
1. Abre el modal
2. Ingresa Monto: 50
3. Ingresa Email: test@example.com
4. Haz clic "Procesar Donación"

Resultado esperado:
✅ El modal se disuelve/cierra
✅ Se muestra un mensaje de procesamiento
✅ Redirige a página de Openpay (o muestra URL)
```

---

## 💳 Prueba 5: Donación Completa en Sandbox

### Objetivo: Hacer una donación real de prueba

**Pasos:**

#### Fase 1: Enviar formulario
```
1. Abre el modal del botón "Donar"
2. Ingresa:
   Monto: 50
   Email: tuEmail@tudominio.com
3. Haz clic "Procesar Donación"

Resultado esperado:
✅ Ves un spinner/loading
✅ Se conecta a Openpay
✅ Dentro de 2-3 segundos aparece página de pago de Openpay
  (O la ves en otra ventana)
```

#### Fase 2: Página de Pago en Openpay
```
En la página de Openpay verás:
✅ Formulario para ingresar tarjeta
✅ El monto: $50 MXN
✅ Descripción: "Donación para: MiProyecto"

Completa con tarjeta de prueba:
Tarjeta:    4111 1111 1111 1111
Mes/Año:    12/25 (cualquier fecha futura)
CVV:        123 (cualquier número)
Nombre:     Test User (cualquier nombre)

Resultado esperado:
✅ Se acepta la tarjeta
✅ Ves "Transacción exitosa" o "Donación procesada"
```

#### Fase 3: Confirmación
```
Después de confirmar en Openpay:
✅ Redirige a tu sitio (página de "Gracias")
✅ En WordPress, ve a Donaciones Openpay
✅ En "Historial" ves tu donación:
   - Proyecto: MiProyecto
   - Monto: $50.00 MXN
   - Email: tuEmail@tudominio.com
   - Estado: Completado
   - Fecha: Hoy
```

---

## 🧮 Prueba 6: Múltiples Montos

### Objetivo: Verificar que funciona con diferentes montos

**Pasos:**
```
1. Haz donación de $10 (monto mínimo sugerido)
   ✅ Se procesa
   ✅ Aparece en historial

2. Haz donación de $100
   ✅ Se procesa
   ✅ Aparece en historial

3. Haz donación de $500
   ✅ Se procesa
   ✅ Aparece en historial

4. Haz donación de $0.50 (centavos)
   Resultado esperado:
   ❌ Rechazada (Openpay requiere mínimo, usualmente $1)
   O ✅ Si permite, aparece como $0.50

5. En Historial:
   ✅ Ves todas las donaciones listadas
   ✅ Los montos son correctos
   ✅ Las fechas son correctas
```

---

## 👥 Prueba 7: Múltiples Emails

### Objetivo: Verificar que funciona con diferentes usuarios

**Pasos:**
```
1. Donación con: usuario1@ejemplo.com
   ✅ Se procesa
   ✅ Aparece en historial

2. Donación con: usuario2@ejemplo.com
   ✅ Se procesa
   ✅ Aparece en historial

3. Donación con el mismo email again: usuario1@ejemplo.com
   ✅ Se procesa
   ✅ Aparece otra entrada en historial (sin problema)

4. En Historial:
   ✅ Ves todas las donaciones con sus emails
   ✅ Emails están correctamente guardados
   ✅ Se permite mismo email múltiples veces
```

---

## 📊 Prueba 8: Panel de Administración

### Objetivo: Verificar que estadísticas se actualizan

**Pasos:**
```
1. Ve a Donaciones Openpay (Panel Principal)

Deberías ver:
✅ "Donaciones Totales": Número total de donaciones
✅ "Ingresos Totales": Suma de todos los montos
✅ "Último Donante": Email del donante más reciente
✅ Gráfico que muestra tendencia de donaciones

2. Compara con tus donaciones de prueba:
   Si hiciste: $50 + $100 + $500 = $650
   Panel debe mostrar: $650.00 MXN

3. Recarga la página admin:
   ✅ Las estadísticas se mantienen
   ✅ No se pierden datos

4. En "Historial":
   ✅ Ves todas las donaciones listadas
   ✅ En orden cronológico (más reciente primero)
   ✅ Cada una muestra: Proyecto, Monto, Email, Fecha, Estado
```

---

## 🌐 Prueba 9: Responsive Design

### Objetivo: Verificar que funciona en móvil y tablet

**Pasos:**
```
En Computadora (Desktop):
1. Abre tu página web
2. Presiona F12 (Developer Tools)
3. Haz clic en el ícono de "Device Toolbar" (celular)
4. Selecciona diferentes dispositivos:
   - iPhone X
   - Samsung Galaxy
   - iPad

En cada dispositivo:
✅ El botón "Donar" se ve bien
✅ El botón es clickeable
✅ El modal se abre correctamente
✅ El formulario es legible
✅ Los inputs responden al toque
✅ Se puede scrollear si es necesario
✅ Al completar se procesa igual
```

**En Celular Real:**
```
1. Abre tu sitio en tu celular
2. Haz clic en "Donar"
✅ Funciona igual que en desktop
✅ Modal se ve bien
✅ Formulario completo y legible
✅ Se puede procesar la donación
```

---

## 🔄 Prueba 10: Cambio a Production

### Objetivo: Verificar configuración para dinero real

**⚠️ IMPORTANTE: Solo haz esto cuando estés listo para dinero real**

**Pasos:**
```
1. En Openpay, obtén tus credenciales de PRODUCCIÓN
   (No confundas con Sandbox)

2. En WordPress → Donaciones Openpay → Configuración:
   - Reemplaza Merchant ID con el de Production
   - Reemplaza Private Key con la de Production
   - Cambia Modo de "Sandbox" a "Production"
   - Guarda cambios

3. Haz una donación pequeña ($1 máximo para probar)
   ✅ Se procesa correctamente
   ✅ Aparece en historial con "Production"
   ✅ Se refleja en tu cuenta bancaria (1-2 días)

4. Después de verificar:
   - Cambia a monto real de donación
   - Ya estás listo para recibir dinero real
```

---

## 🚨 Prueba 11: Manejo de Errores

### Objetivo: Verificar que los errores se manejan bien

**Pasos:**

#### Error 1: Credenciales inválidas
```
1. Ve a Configuración
2. Cambia la Private Key a algo inválido: "test123"
3. Guarda
4. Haz una donación
✅ Ves error específico: "Verifica tus credenciales"
✅ El error no rompe WordPress
✅ Puedes intentar de nuevo
```

#### Error 2: Merchant ID vacío
```
1. Ve a Configuración
2. Borra el Merchant ID
3. Guarda
4. Haz una donación
✅ Ves error: "Configuración incompleta"
✅ Te pide rellenar campos
```

#### Error 3: Moneda no soportada
```
(Este error es raro, pero si ocurre)
✅ Ves mensaje claro sobre la moneda
✅ No se congela WordPress
```

---

## 📋 Checklist de Testing Completo

```
CONFIGURACIÓN:
☐ Plugin activado correctamente
☐ Página admin accesible
☐ Botón de donación visible
☐ Credenciales guardadas

INTERFAZ:
☐ Modal se abre con clic
☐ Modal se cierra con X
☐ Modal se cierra con clic afuera
☐ Formulario visible y completo

VALIDACIÓN:
☐ Rechaza monto vacío
☐ Rechaza monto inválido
☐ Rechaza email vacío
☐ Rechaza email inválido
☐ Acepta datos válidos

DONACIÓN:
☐ Sandbox: Primer donativo procesa
☐ Historial: Se registra donación
☐ Panel: Estadísticas actualizan
☐ Múltiples donaciones: Todas se registran

RESPONSIVE:
☐ Desktop: Funciona
☐ Tablet: Funciona
☐ Móvil: Funciona

ERRORES:
☐ Credenciales inválidas: Mensaje claro
☐ Campos incompletos: Mensaje claro
☐ Sin internet: Mensaje claro
☐ Servidor Openpay caído: Mensaje claro

PRODUCCIÓN:
☐ Cambio a Production: OK
☐ Primer donativo real: OK
☐ Dinero recibido en cuenta: OK
```

---

## 🐛 Reporte de Bugs

Si encuentras un problema:

1. **Documenta:**
   - Qué hiciste
   - Qué esperabas
   - Qué sucedió
   - Screenshot del error

2. **Verifica:**
   - ¿Credenciales correctas?
   - ¿Datos válidos?
   - ¿Internet funciona?

3. **Contacta:**
   - support@openpay.mx (si es Openpay)
   - Tu hosting (si es del servidor)

---

**Última actualización:** 2024
**Versión del plugin:** 1.2+
