<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Tren - Blog Ferrocarriles</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" href="../images/Icono web.png" type="image/x-icon">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <img src="../images/logo-ferrocarril-esp.png" alt="Logo Blog Ferrocarril">
                <h1>Blog Ferrocarriles</h1>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../lineas/ancho-iberico.html">Ancho ibérico</a></li>
                    <li><a href="../proyectos/proyectos-estudio.html">Proyectos en estudio</a></li>
                    <li><a href="../ciudades/sevilla.html">Sevilla</a></li>
                    <li><a href="../estaciones/index.php">Estaciones de tren</a></li>
                </ul>
            </nav>
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="category-header">
                <h2>🚉 Estaciones de Tren</h2>
                <p>Descubre las estaciones ferroviarias más importantes de España</p>
            </div>

            <!-- Filtro de categorías adicionales -->
            <div class="additional-filters">
                <h3>Filtrar por categorías adicionales:</h3>
                <div class="filter-options">
                    <label><input type="checkbox" value="sevilla" onchange="filterByAdditionalCategory()"> Sevilla</label>
                    <label><input type="checkbox" value="madrid" onchange="filterByAdditionalCategory()"> Madrid</label>
                    <label><input type="checkbox" value="barcelona" onchange="filterByAdditionalCategory()"> Barcelona</label>
                    <label><input type="checkbox" value="ancho_iberico" onchange="filterByAdditionalCategory()"> Ancho Ibérico</label>
                </div>
            </div>

            <!-- Contenido filtrado -->
            <div id="filteredContent" class="filtered-content">
                <!-- El contenido se cargará dinámicamente -->
            </div>

            <!-- Botón para volver -->
            <div class="back-button">
                <a href="../index.php" class="btn btn-primary">← Volver al Inicio</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Blog Ferrocarriles. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../script.js"></script>
    <script>
        // Script específico para esta página
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar contenido de la categoría "estaciones_principales"
            loadCategoryContent('estaciones_principales');
        });
    </script>
</body>
</html>
