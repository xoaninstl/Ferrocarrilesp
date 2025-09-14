# Tema WordPress - Ferrocarril Esp

Este tema de WordPress convierte tu HTML estático en una plantilla de WordPress funcional, manteniendo toda la estructura visual original pero añadiendo la funcionalidad dinámica de WordPress.

## 📋 Características

- **Estructura estática preservada**: Mantiene todo el diseño y funcionalidad original del HTML
- **Posts dinámicos de WordPress**: Los artículos se cargan desde WordPress
- **Búsqueda híbrida**: Combina búsqueda en WordPress y contenido estático
- **Mapeo de categorías**: Sistema de correspondencia entre categorías HTML y WordPress
- **Sistema de comentarios**: Compatible con comentarios de WordPress
- **Responsive**: Mantiene toda la responsividad original

## 🗂️ Archivos del tema

### Archivos principales
- `index.php` - Plantilla principal (conversión del index.html original)
- `functions.php` - Funcionalidades de WordPress
- `style.css` - Archivo requerido por WordPress (importa styles.css)
- `styles.css` - Estilos principales (archivo original)
- `wp-style.css` - Estilos específicos para WordPress

### Scripts
- `script.js` - JavaScript principal (archivo original)
- `wp-search.js` - Búsqueda mejorada para WordPress
- `config.js` - Configuración JavaScript (archivo original)

## 🚀 Instalación

1. **Subir el tema**:
   ```
   - Copia todos los archivos a /wp-content/themes/ferrocarril-esp/
   - O sube como ZIP desde el admin de WordPress
   ```

2. **Activar el tema**:
   ```
   - Ve a Apariencia > Temas
   - Activa "Ferrocarril Esp"
   ```

3. **Configuración inicial**:
   ```
   - Las categorías se crearán automáticamente al activar el tema
   - Configura el nombre del blog en Ajustes > Generales
   - Añade una descripción del blog
   ```

## 📝 Mapeo de Categorías

El tema incluye un sistema de mapeo entre las categorías del HTML original y WordPress:

### Categorías Históricas
| HTML | WordPress |
|------|-----------|
| `ancho_iberico` | `ancho-iberico` |
| `ancho_metrico` | `ancho-metrico` |
| `ancho_internacional` | `ancho-internacional` |
| `lineas_cerradas` | `lineas-cerradas` |
| `proyectos_cancelados` | `proyectos-cancelados` |
| `proyectos_actuales` | `proyectos-actuales` |
| `proyectos_en_marcha` | `proyectos-en-marcha` |
| `proyectos_estudio` | `proyectos-en-estudio` |

### Categorías de Noticias
| HTML | WordPress |
|------|-----------|
| `noticias` | `noticias` |
| `metro` | `metro` |
| `tram` | `tranvia` |
| `ave` | `ave` |
| `cercanias` | `cercanias` |
| `apertura_linea` | `apertura-linea` |
| `inicio_obras` | `inicio-obras` |
| `fin_obras` | `fin-obras` |
| `evento_especial` | `evento-especial` |
| `mantenimiento` | `mantenimiento` |
| `aniversario` | `aniversario` |
| `cambio_horarios` | `cambio-horarios` |

### Categorías de Ciudades
| HTML | WordPress |
|------|-----------|
| `sevilla` | `sevilla` |
| `madrid` | `madrid` |
| `barcelona` | `barcelona` |
| `valencia` | `valencia` |
| `bilbao` | `bilbao` |

## ✍️ Crear Contenido

### Posts/Artículos
1. Ve a **Entradas > Añadir nueva**
2. Escribe tu artículo
3. Asigna las **categorías apropiadas** (se crean automáticamente)
4. En el metabox "Tipo de Contenido Ferrocarril", selecciona:
   - **Noticia**: Para noticias actuales
   - **Histórico**: Para contenido histórico
   - **Ciudad**: Para desarrollo urbano

### Usar las categorías
- Las categorías se mapean automáticamente entre HTML y WordPress
- Usa las categorías de WordPress normalmente
- El filtro avanzado del sidebar funcionará automáticamente

## 🔍 Sistema de Búsqueda

La búsqueda combina:
- **Contenido de WordPress**: Posts, páginas, etc.
- **Contenido estático**: Enlaces a las páginas HTML originales
- **Contenido de la página actual**: Títulos, párrafos, etc.

### Funcionalidades de búsqueda
- Autocompletado inteligente
- Búsqueda por relevancia
- Resaltado de términos
- Caché de resultados
- Navegación a contenido específico

## 🎨 Personalización

### Modificar estilos
- **Estilos generales**: Edita `styles.css`
- **Estilos específicos de WordPress**: Edita `wp-style.css`

### Añadir funcionalidades
- Edita `functions.php` para añadir nuevas funciones
- Modifica `wp-search.js` para personalizar la búsqueda

### Cambiar el mapeo de categorías
```php
// En functions.php, modifica la función get_category_mapping()
function get_category_mapping() {
    return array(
        'html_category' => 'wp-category-slug',
        // Añade más mapeos aquí
    );
}
```

## 🔧 Funciones Personalizadas

### Obtener posts por categoría HTML
```php
$posts = get_posts_by_html_category('ancho_iberico', 5);
```

### Obtener últimas noticias
```php
$news = get_latest_news(10);
```

### Formatear post para mostrar
```php
$formatted = format_post_for_display($post);
```

## 📱 Características Responsive

El tema mantiene toda la responsividad original:
- Menú móvil funcional
- Grid adaptativo
- Sidebar que se reubica en móvil
- Búsqueda optimizada para móvil

## 🐛 Solución de Problemas

### Las categorías no aparecen
- Verifica que el tema esté activado
- Ve a Entradas > Categorías para ver si se crearon

### La búsqueda no funciona
- Verifica que jQuery esté cargado
- Comprueba la consola del navegador por errores
- Asegúrate de que los ajaxes estén configurados correctamente

### Los estilos no se cargan
- Verifica que `styles.css` y `wp-style.css` existan
- Comprueba los permisos de archivos
- Limpia la caché del navegador

### Posts no se muestran
- Verifica que haya posts publicados
- Comprueba que tengan las categorías correctas
- Asegúrate de que el metabox "Tipo de Contenido" esté configurado

## 📧 Soporte

Para problemas específicos del tema:
1. Verifica la consola del navegador
2. Comprueba el log de errores de WordPress
3. Asegúrate de que todos los archivos estén en su lugar

## 🔄 Actualizaciones

Al actualizar el tema:
1. Haz backup de las personalizaciones
2. Sustituye los archivos del tema
3. Reaplica las personalizaciones si es necesario

---

**Nota**: Este tema está diseñado para mantener la estructura estática original mientras añade las ventajas de WordPress. Las páginas HTML originales (lineas/, proyectos/, ciudades/, etc.) deben mantenerse en su ubicación original para que los enlaces funcionen correctamente.