<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos - Blog Ferrocarril Esp</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1><a href="../index.php"><img src="../images/logo-ferrocarril-esp.png" alt="Logo Ferrocarril Esp" class="logo-img"></a></h1>
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
                        <a href="index.php">Proyectos ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="proyectos-cancelados.html">Proyectos cancelados</a></li>
                            <li><a href="proyectos-actuales.html">Proyectos actuales</a></li>
                            <li><a href="proyectos-en-marcha.html">Proyectos en marcha</a></li>
                            <li><a href="proyectos-estudio.html">Proyectos en estudio</a></li>
                        </ul>
                    </li>
                    <li><a href="../curiosidades.html">Curiosidades</a></li>
                    <li><a href="../compra-billetes.html">Compra de Billetes</a></li>
                    <li><a href="../ciudades/index.php">Desarrollo ciudades</a></li>
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
    <main class="main">
        <div class="container">
            <div class="content-wrapper">
                <!-- Left Content -->
                <div class="content-left">
                    <section class="section">
                        <h2>Proyectos Ferroviarios</h2>
                        <p>Descubre todos los proyectos ferroviarios en España, desde los que están en estudio hasta los que ya están en marcha o han sido cancelados.</p>
                        
                        <div class="proyectos-overview">
                            <div class="proyecto-card">
                                <h3>🚫 Proyectos Cancelados</h3>
                                <p>Proyectos que fueron planificados pero finalmente no se llevaron a cabo.</p>
                                <a href="proyectos-cancelados.html" class="btn-primary">Ver Proyectos Cancelados</a>
                            </div>
                            
                            <div class="proyecto-card">
                                <h3>📋 Proyectos Actuales</h3>
                                <p>Proyectos que están siendo ejecutados actualmente en el sistema ferroviario español.</p>
                                <a href="proyectos-actuales.html" class="btn-primary">Ver Proyectos Actuales</a>
                            </div>
                            
                            <div class="proyecto-card">
                                <h3>🚧 Proyectos en Marcha</h3>
                                <p>Proyectos que están en fase de construcción o implementación activa.</p>
                                <a href="proyectos-en-marcha.html" class="btn-primary">Ver Proyectos en Marcha</a>
                            </div>
                            
                            <div class="proyecto-card">
                                <h3>📚 Proyectos en Estudio</h3>
                                <p>Proyectos que están siendo analizados y evaluados para su posible implementación.</p>
                                <a href="proyectos-estudio.html" class="btn-primary">Ver Proyectos en Estudio</a>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar">
                    <div class="author-info">
                        <h3>Sobre Mí</h3>
                        <div class="author-photo">
                            <img src="../tu-foto.jpg" alt="Foto del autor" id="authorPhoto">
                            <div class="photo-placeholder" id="photoPlaceholder">
                                <span>📷</span>
                                <p>Tu foto aquí</p>
                            </div>
                        </div>
                        <h4 id="authorName">Tu Nombre</h4>
                        <p id="authorBio">Apasionado del ferrocarril español. Amante de la historia ferroviaria y las innovaciones del sector.</p>
                        
                        <div class="social-links">
                            <h5>Redes Sociales</h5>
                            <div class="social-icons">
                                <a href="#" id="twitterLink" class="social-icon">Twitter</a>
                                <a href="#" id="linkedinLink" class="social-icon">LinkedIn</a>
                                <a href="#" id="instagramLink" class="social-icon">Instagram</a>
                                <a href="#" id="youtubeLink" class="social-icon">YouTube</a>
                            </div>
                        </div>
                    </div>

                    <div class="quick-links">
                        <h3>Enlaces Rápidos</h3>
                        <ul>
                            <li><a href="../curiosidades.html">Curiosidades</a></li>
                            <li><a href="../compra-billetes.html">Compra de Billetes</a></li>
                            <li><a href="../index.php#faq">FAQ - Preguntas Frecuentes</a></li>
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
                    <h4>Política de Privacidad</h4>
                    <p>Este blog respeta tu privacidad. No recopilamos información personal sin tu consentimiento.</p>
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
