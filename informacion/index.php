<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información - Blog Ferrocarril Esp</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1><img src="../images/logo-ferrocarril-esp.png" alt="Logo Ferrocarril Esp" class="logo-img"></h1>
            </div>
            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                    <li class="dropdown">
                        <a href="../lineas/index.php">Líneas ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="../lineas/ancho-iberico.html">Ancho ibérico</a></li>
                            <li><a href="../lineas/ancho-metrico.html">Ancho métrico</a></li>
                            <li><a href="../lineas/ancho-internacional.html">Ancho internacional</a></li>
                            <li><a href="../lineas/tipos-lineas.html">Distintos tipos de líneas</a></li>
                            <li><a href="../lineas/lineas-cerradas.html">Líneas Cerradas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../proyectos/index.php">Proyectos ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="../proyectos/proyectos-cancelados.html">Proyectos cancelados</a></li>
                            <li><a href="../proyectos/proyectos-actuales.html">Proyectos actuales</a></li>
                            <li><a href="../proyectos/proyectos-en-marcha.html">Proyectos en marcha</a></li>
                            <li><a href="../proyectos/proyectos-estudio.html">Proyectos en estudio</a></li>
                        </ul>
                    </li>
                    <li><a href="../curiosidades.html">Curiosidades</a></li>
                    <li><a href="../compra-billetes.html">Compra de Billetes</a></li>
                    <li><a href="../ciudades/index.php">Desarrollo ciudades</a></li>
                    <li><a href="../estaciones/index.php">Estaciones de tren</a></li>
                </ul>
            </nav>
            
            <!-- Barra de búsqueda -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar en el blog..." class="search-input">
                <div id="searchResults" class="search-results"></div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <div class="content-wrapper">
                <!-- Left Content -->
                <div class="content-left">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="../index.php">Inicio</a> > <span>Información</span>
                    </div>

                    <!-- Page Header -->
                    <section class="section">
                        <h1>📚 Información Técnica del Ferrocarril</h1>
                        <p class="section-intro">Descubre información detallada sobre líneas ferroviarias, características técnicas, datos históricos y especificaciones del sistema ferroviario español. Aquí encontrarás contenido educativo y técnico sobre el mundo del ferrocarril.</p>
                    </section>

                    <!-- Información Container -->
                    <div class="latest-posts">
                        <h2>Información Disponible</h2>
                        <div id="info-container">
                            <!-- La información se cargará dinámicamente aquí -->
                            <div class="no-content">
                                <h3>📚 Próximamente</h3>
                                <p>La información técnica aparecerá aquí cuando esté disponible. Utiliza la plantilla de información para crear contenido.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Plantilla de referencia -->
                    <div class="template-reference">
                        <h2>📋 Plantilla de Información</h2>
                        <div class="info-box">
                            <h3>¿Cómo crear una entrada de información?</h3>
                            <p>Utiliza la plantilla de información para crear contenido técnico estructurado:</p>
                            <ul>
                                <li><strong>Título:</strong> Nombre específico del tema</li>
                                <li><strong>Descripción:</strong> Resumen del contenido técnico</li>
                                <li><strong>Imagen:</strong> Diagrama, foto técnica o mapa</li>
                                <li><strong>Contenido:</strong> Información detallada y técnica</li>
                                <li><strong>Fecha:</strong> Fecha de actualización</li>
                                <li><strong>Categorías:</strong> Clasificación técnica</li>
                            </ul>
                            <p><a href="plantilla-informacion.html" class="btn btn-primary">Ver Plantilla de Información</a></p>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar">
                    <!-- Información del autor -->
                    <div class="author-info">
                        <h3>Sobre Mí</h3>
                        <div class="author-photo">
                            <img src="../images/autor-foto.jpg" alt="Foto del autor" id="authorPhoto">
                        </div>
                        <h4 id="authorName">Tu Nombre</h4>
                        <p id="authorBio">Especialista técnico en ferrocarriles españoles. Compartiendo conocimiento técnico y datos del sector.</p>
                    </div>

                    <!-- Categorías de información -->
                    <div class="info-categories">
                        <h3>📚 Categorías de Información</h3>
                        <ul>
                            <li><a href="#ancho-iberico">Ancho Ibérico</a></li>
                            <li><a href="#ancho-metrico">Ancho Métrico</a></li>
                            <li><a href="#ancho-internacional">Ancho Internacional</a></li>
                            <li><a href="#lineas-cerradas">Líneas Cerradas</a></li>
                            <li><a href="#proyectos-cancelados">Proyectos Cancelados</a></li>
                            <li><a href="#proyectos-actuales">Proyectos Actuales</a></li>
                            <li><a href="#proyectos-en-marcha">Proyectos en Marcha</a></li>
                            <li><a href="#proyectos-estudio">Proyectos en Estudio</a></li>
                        </ul>
                    </div>

                    <!-- Enlaces rápidos -->
                    <div class="quick-links">
                        <h3>Enlaces Rápidos</h3>
                        <ul>
                            <li><a href="../curiosidades.html">Curiosidades</a></li>
                            <li><a href="../compra-billetes.html">Compra de Billetes</a></li>
                            <li><a href="../proyectos/index.php">Proyectos</a></li>
                            <li><a href="../lineas/index.php">Líneas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Blog Ferrocarril Esp</h4>
                    <p>Tu fuente de información sobre el ferrocarril español. Noticias, proyectos, curiosidades y mucho más.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Enlaces Útiles</h4>
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="index.php">Información</a></li>
                        <li><a href="../proyectos/index.php">Proyectos</a></li>
                        <li><a href="../lineas/index.php">Líneas</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Blog Ferrocarril Esp. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="../config.js"></script>
    <script src="../script.js"></script>
</body>
</html>
