# 🚂 Blog de Ferrocarriles Españoles

Un blog moderno y responsive para compartir historias, noticias y curiosidades sobre el sistema ferroviario español.

## ✨ Características

- **Diseño Responsive** - Se ve perfecto en móviles, tablets y ordenadores
- **Menú de Navegación** - Con secciones y subsecciones organizadas
- **Sistema de Comentarios** - Los visitantes pueden comentar en las entradas
- **Información del Autor** - Sección personalizable con tu foto y redes sociales
- **Colores Personalizables** - Usa el color #f0dfd0 que especificaste
- **Sin Base de Datos** - Funciona completamente en el navegador

## 📁 Estructura de Archivos

```
BlogFerrocarriles/
├── index.html          # Página principal del blog
├── styles.css          # Estilos y diseño responsive
├── script.js           # Funcionalidades JavaScript
├── config.js           # Configuración personalizable
└── README.md           # Este archivo
```

## 🚀 Cómo Usar

### 1. Personalizar tu Información

Abre el archivo `config.js` y cambia:

```javascript
const AUTHOR_CONFIG = {
    name: "Tu Nombre Completo", // ← Cambia esto
    bio: "Tu biografía aquí...", // ← Cambia esto
    photo: "tu-foto.jpg", // ← URL de tu foto
    social: {
        twitter: "https://twitter.com/tu-usuario", // ← Tu Twitter
        linkedin: "https://linkedin.com/in/tu-perfil", // ← Tu LinkedIn
        instagram: "https://instagram.com/tu-usuario", // ← Tu Instagram
        youtube: "https://youtube.com/@tu-canal" // ← Tu YouTube
    }
};
```

### 2. Añadir tu Foto

**Opción A: Foto Local**
1. Crea una carpeta `images` en el directorio
2. Pon tu foto ahí (ej: `images/mi-foto.jpg`)
3. En `config.js`, pon: `photo: "images/mi-foto.jpg"`

**Opción B: Foto de Internet**
1. Sube tu foto a un servicio como Imgur o Google Drive
2. Copia la URL
3. En `config.js`, pon: `photo: "https://url-de-tu-foto.jpg"`

### 3. Abrir el Blog

Simplemente haz doble clic en `index.html` para abrirlo en tu navegador.

## 🎨 Secciones del Blog

El blog incluye todas las secciones que planificaste:

### 🚆 Líneas
- Ancho ibérico
- Ancho métrico  
- Ancho internacional
- Distintos tipos de líneas (metro, tram, etc.)
- Líneas Cerradas

### 📋 Proyectos
- Proyectos cancelados
- Proyectos actuales
- Proyectos en marcha
- Proyectos solo en estudio

### 🔍 Otras Secciones
- Curiosidades
- Billetes
- Desarrollo ciudades con los años
- FAQ

## 💻 Funcionalidades Técnicas

- **Menú Dropdown** - Secciones y subsecciones visibles al hacer hover
- **Comentarios** - Sistema funcional con localStorage
- **Responsive Design** - Adaptable a todos los dispositivos
- **Navegación Suave** - Scroll suave entre secciones
- **Notificaciones** - Mensajes de confirmación para comentarios

## 📱 Diseño Responsive

- **Desktop**: Layout de 2 columnas (contenido + sidebar)
- **Tablet**: Layout de 1 columna, menú adaptado
- **Móvil**: Menú hamburguesa, diseño optimizado

## 🔧 Personalización Avanzada

### Cambiar Colores

En `styles.css`, puedes cambiar los colores principales:

```css
:root {
    --primary-color: #f0dfd0;    /* Color principal */
    --secondary-color: #2c3e50;  /* Color secundario */
    --accent-color: #34495e;     /* Color de acento */
}
```

### Añadir Nuevas Secciones

1. En `index.html`, añade la nueva sección en el menú
2. En `styles.css`, añade estilos para la nueva sección
3. En `script.js`, añade funcionalidades si es necesario

## 📝 Añadir Contenido

### Crear Nuevas Entradas

1. En `index.html`, busca la sección `latest-posts`
2. Añade nuevas entradas siguiendo este formato:

```html
<div class="post">
    <h4>Título de la Nueva Entrada</h4>
    <p class="post-meta">Por tu-nombre • fecha</p>
    <p>Descripción de la entrada...</p>
</div>
```

### Crear Páginas de Sección

1. Copia `index.html` y renómbralo (ej: `lineas.html`)
2. Modifica el contenido para esa sección específica
3. Actualiza los enlaces en el menú principal

## 🌐 Subir a Internet

### Opción 1: GitHub Pages (Gratis)
1. Crea un repositorio en GitHub
2. Sube todos los archivos
3. Activa GitHub Pages en la configuración

### Opción 2: Netlify (Gratis)
1. Ve a netlify.com
2. Arrastra la carpeta del blog
3. ¡Listo! Tu blog estará online

### Opción 3: Azure (Como tenías)
1. Sube los archivos a tu hosting de Azure
2. Configura el servidor web para servir archivos estáticos

## 🐛 Solución de Problemas

### Los comentarios no se guardan
- Verifica que JavaScript esté habilitado en tu navegador
- Los comentarios se guardan en localStorage del navegador

### La foto no aparece
- Verifica que la URL sea correcta
- Asegúrate de que la imagen sea accesible públicamente
- Si usas imagen local, verifica la ruta

### El menú no funciona en móvil
- Verifica que todos los archivos JavaScript estén cargados
- Recarga la página

## 📞 Soporte

Si tienes problemas o quieres añadir funcionalidades:

1. **Revisa este README** - La mayoría de problemas están cubiertos aquí
2. **Verifica la consola del navegador** - F12 → Console para ver errores
3. **Comprueba que todos los archivos estén en el mismo directorio**

## 🎯 Próximos Pasos

Una vez que tengas el blog funcionando, puedes:

- **Añadir más contenido** en las diferentes secciones
- **Personalizar el diseño** cambiando colores y estilos
- **Añadir funcionalidades** como búsqueda o filtros
- **Integrar con redes sociales** para compartir contenido
- **Añadir analytics** para ver estadísticas de visitantes

---

**¡Tu blog de ferrocarriles está listo para usar! 🚂✨**

Recuerda: Este es un blog completamente funcional que puedes personalizar y expandir según tus necesidades. No necesitas conocimientos técnicos avanzados para usarlo.
