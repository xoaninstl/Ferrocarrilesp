# 🚀 Instrucciones para Azure - Solución CSS

## Problema Identificado
El tema no carga los estilos CSS en Azure. Esto es común en App Services.

## Solución: Subir archivos directamente

### Paso 1: Acceder a Kudu (Consola de Azure)
1. Ve a **Azure Portal** → **App Service "Ferrocarrilesp"**
2. Busca **"Herramientas de desarrollo"** → **"Consola avanzada (Kudu)"**
3. Haz clic en **"Ir"**

### Paso 2: Navegar a la carpeta del tema
En Kudu, ve a:
```
site/wwwroot/wp-content/themes/ferroblog/
```

### Paso 3: Verificar archivos existentes
Verifica que existan estos archivos:
- ✅ `style.css` (debe tener CSS embebido)
- ✅ `functions.php`
- ✅ `header.php`
- ✅ `footer.php`
- ✅ `index.php`
- ✅ `sidebar.php`

### Paso 4: Si faltan archivos, subirlos
1. En Kudu, haz clic en **"CMD"** (consola de comandos)
2. Navega a la carpeta del tema:
   ```bash
   cd site/wwwroot/wp-content/themes/ferroblog/
   ```
3. Verifica el contenido:
   ```bash
   dir
   ```

### Paso 5: Subir archivos manualmente (si es necesario)
1. En Kudu, ve a **"Debug console"** → **"CMD"**
2. Navega a la carpeta del tema
3. Usa el explorador de archivos de Kudu para subir archivos

### Paso 6: Verificar permisos
Los archivos deben tener permisos 644:
```bash
chmod 644 *.php *.css
```

### Paso 7: Limpiar caché
1. En WordPress Admin → **Plugins**
2. **Desactiva temporalmente** plugins de caché
3. **Presiona Ctrl+F5** en el navegador

## Alternativa: FTP
Si Kudu no funciona, usa FTP:
1. En Azure Portal → **App Service "Ferrocarrilesp"**
2. **"Centro de implementación"** → **"FTP"**
3. Usa las credenciales FTP para subir archivos

## Verificación Final
Después de subir los archivos:
1. Ve a tu sitio web
2. **Presiona Ctrl+F5** (limpiar caché)
3. El sitio debería mostrar los estilos correctamente

## Archivos Críticos
- `style.css` - DEBE tener CSS embebido
- `functions.php` - DEBE cargar estilos correctamente
- `header.php` - DEBE incluir wp_head()

## Contacto
Si el problema persiste, verifica:
1. Permisos de archivos (644)
2. Caché del servidor
3. Plugins de caché desactivados
