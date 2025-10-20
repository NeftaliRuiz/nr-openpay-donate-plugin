# FAQ - Preguntas Frecuentes

## 🆘 Instalación y Configuración

### P: ¿Cómo instalo el plugin?
**R:** 
1. Descarga la carpeta del plugin
2. Sube a `/wp-content/plugins/`
3. Actívalo desde WordPress
4. Ve a Openpay Donaciones → Configuración
5. Ingresa tus credenciales

### P: ¿Dónde consigo mis credenciales de Openpay?
**R:** 
1. Ve a [openpay.mx](https://www.openpay.mx/)
2. Inicia sesión en tu cuenta
3. En el dashboard, busca "Credenciales" o "API Keys"
4. Copia tu Merchant ID y Private Key

### P: ¿Qué es Merchant ID?
**R:** Es el identificador único de tu negocio en Openpay. Es público y se puede compartir.

### P: ¿Qué es Private Key?
**R:** Es tu contraseña para la API. **Nunca la compartas** públicamente.

### P: ¿Cuál es la diferencia entre Sandbox y Producción?
**R:**
- **Sandbox**: Modo de pruebas. NO cobra dinero real.
- **Producción**: Modo en vivo. SÍ cobra dinero real.

Siempre prueba en Sandbox primero.

---

## 💻 Uso del Plugin

### P: ¿Cómo agrego un formulario de donación a mi página?
**R:** Usa el shortcode en cualquier página o post:
```
[openpay_donate project="Mi Proyecto"]
```

### P: ¿Puedo tener múltiples formularios?
**R:** Sí, usa el shortcode varias veces con diferentes nombres de proyecto.

### P: ¿Puedo cambiar el nombre del proyecto?
**R:** Sí, modifica el atributo `project`:
```
[openpay_donate project="Nuevo Nombre"]
```

### P: ¿Qué información se registra de cada donación?
**R:** Se registra:
- Email del donante
- Monto donado
- Proyecto
- Estado de la donación
- Fecha y hora

### P: ¿Dónde veo las donaciones recibidas?
**R:** En el panel WordPress:
1. Ve a Openpay Donaciones (en el menú)
2. Verás estadísticas y historial completo

---

## 🔒 Seguridad

### P: ¿Es seguro compartir mi email en el formulario?
**R:** Sí, se almacena de forma segura. Solo lo ves tú en el panel.

### P: ¿Es seguro ingresar mi tarjeta?
**R:** Sí, el pago es procesado por Openpay con encriptación.

### P: ¿Alguien puede ver mis credenciales?
**R:** No, están protegidas y solo se usan en el backend.

### P: ¿Qué pasa si pierdo mi Private Key?
**R:** Puedes generar una nueva desde el panel de Openpay.

---

## 💰 Pagos y Dinero

### P: ¿Cuánto cuesta usar el plugin?
**R:** El plugin es gratuito. Openpay cobra comisión por transacción.

### P: ¿Cuál es la comisión de Openpay?
**R:** Varía según tu tipo de cuenta. Revisa [openpay.mx](https://www.openpay.mx/) para detalles.

### P: ¿Cuál es el monto mínimo de donación?
**R:** $1.00 MXN (puede variar según Openpay)

### P: ¿Cuál es el monto máximo?
**R:** Sin límite especificado por el plugin, depende de Openpay.

### P: ¿A dónde va el dinero?
**R:** A tu cuenta bancaria vinculada con Openpay.

### P: ¿En cuánto tiempo recibo el dinero?
**R:** Generalmente en 1-2 días hábiles (según Openpay)

---

## 🎨 Personalización

### P: ¿Puedo cambiar los colores?
**R:** Sí, edita `/css/openpay-donate.css` o `/css/openpay-admin.css`
Ver archivo `CUSTOMIZATION.md` para detalles.

### P: ¿Puedo cambiar los textos?
**R:** Sí, edita `openpay-donate-plugin.php` y busca los textos que desees cambiar.

### P: ¿Puedo usar un logo personalizado?
**R:** Sí, reemplaza el SVG en el header del formulario.

### P: ¿Puedo cambiar el idioma?
**R:** Actualmente está en español. Puedes modificar los textos directamente.

---

## 🐛 Solución de Problemas

### P: El formulario no aparece
**R:** 
- Verifica que el shortcode esté bien escrito
- Confirma que el plugin está activo
- Recarga la página (Ctrl+Shift+R)
- Revisa la consola del navegador (F12)

### P: "Configuración incompleta"
**R:** 
- Ve a Openpay Donaciones → Configuración
- Llena Merchant ID y Private Key
- Haz clic en "Guardar Configuración"

### P: Las donaciones no se registran
**R:**
- Verifica credenciales correctas
- Comprueba que estés en el modo correcto (Sandbox/Producción)
- Revisa la conexión a la API de Openpay
- Intenta hacer una donación de prueba

### P: Veo un error de nonce
**R:**
- El nonce es un mecanismo de seguridad
- Recarga la página
- Si persiste, contacta al soporte

### P: El botón no funciona
**R:**
- Verifica que tengas JavaScript habilitado
- Recarga la página
- Prueba en otra navegador
- Revisa la consola (F12 → Console)

### P: Los estilos no se ven
**R:**
- Limpia el caché del navegador (Ctrl+Shift+R)
- Ve a Herramientas → Salud del sitio en WordPress
- Verifica que los archivos CSS existan en `/css/`

---

## 📊 Panel de Administración

### P: ¿Qué significa cada estado?
**R:**
- **Creado**: La sesión de pago fue creada
- **Pendiente**: El pago está siendo procesado
- **Completado**: El pago fue exitoso ✓
- **Fallido**: El pago no se completó ✗

### P: ¿Puedo editar una donación?
**R:** No, por seguridad las donaciones no se pueden editar. Solo se pueden ver.

### P: ¿Puedo eliminar una donación?
**R:** No está recomendado por razones de auditoría. Contacta a soporte si es necesario.

### P: ¿Puedo exportar el historial?
**R:** En v1.2 no. Está en roadmap para v1.3.

### P: ¿Puedo ver qué donaciones son de cada proyecto?
**R:** Sí, el historial muestra la columna "Proyecto" para cada donación.

---

## 🔄 Actualizaciones

### P: ¿Cómo actualizo a una nueva versión?
**R:**
1. Desactiva el plugin
2. Reemplaza los archivos
3. Activa el plugin
4. Verifica que todo funcione

### P: ¿Se pierden los datos al actualizar?
**R:** No, la base de datos se conserva siempre.

### P: ¿Hay cambios incompatibles?
**R:** v1.2 es compatible hacia atrás con v1.1.

---

## 📞 Contacto y Soporte

### P: ¿Dónde reporto un bug?
**R:** 
- Revisa si está en el CHANGELOG.md
- Verifica documentación en README.md
- Contacta al desarrollador

### P: ¿A quién contacto para soporte?
**R:**
- **Del plugin**: Revisa README.md
- **De Openpay**: Contacta a soporte@openpay.mx

### P: ¿Puedo pedir una nueva feature?
**R:** Sí, ve al Roadmap en CHANGELOG.md para ver lo planeado.

---

## 🌐 Integración

### P: ¿Funciona con otros plugins?
**R:** Sí, generalmente es compatible. Si hay conflictos, desactiva otros plugins de pago.

### P: ¿Funciona con todos los temas de WordPress?
**R:** Sí, el plugin no depende del tema.

### P: ¿Puedo usar múltiples instancias?
**R:** Solo se necesita una instalación. Usa shortcodes múltiples si necesitas.

### P: ¿Funciona con WooCommerce?
**R:** Este plugin es para donaciones, no para tienda. Pero ambos pueden coexistir.

---

## 📱 Móvil

### P: ¿El formulario funciona en móvil?
**R:** Sí, está completamente optimizado para móviles.

### P: ¿El panel de admin funciona en tablet?
**R:** Sí, es responsive.

### P: ¿Puedo aceptar donaciones desde cualquier dispositivo?
**R:** Sí, funciona en desktop, tablet y móvil.

---

## ⚡ Performance

### P: ¿El plugin ralentiza mi sitio?
**R:** No, es muy ligero. Los estilos y JavaScript son optimizados.

### P: ¿Cuántas donaciones puede procesar?
**R:** Sin límite técnico, depende de tu hosting.

---

## 💡 Tips

### Tip 1: Prueba siempre en Sandbox
Antes de usar credenciales de Producción, haz pruebas.

### Tip 2: Guarda tus credenciales seguras
No compartas tu Private Key con nadie.

### Tip 3: Monitorea el panel regularmente
Revisa las donaciones frecuentemente.

### Tip 4: Personaliza según tu marca
Cambia colores y textos para que coincidan.

### Tip 5: Haz backup regularmente
Guarda tu base de datos frecuentemente.

---

## ❓ ¿No encuentras respuesta?

1. Revisa README.md - Documentación completa
2. Revisa CUSTOMIZATION.md - Para personalización
3. Revisa EXAMPLES.md - Para casos de uso
4. Contacta al soporte de Openpay

---

**Última actualización**: 20 de Octubre de 2025
