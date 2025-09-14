<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1><img src="<?php echo get_template_directory_uri(); ?>/images/logo-ferrocarril-esp.png" alt="Logo Ferrocarril Esp" class="logo-img"></h1>
            </div>
            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="<?php echo home_url('/#inicio'); ?>">Inicio</a></li>
                    <li class="dropdown">
                        <a href="<?php echo home_url('/lineas/'); ?>">Líneas ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo home_url('/lineas/ancho-iberico.html'); ?>">Ancho ibérico</a></li>
                            <li><a href="<?php echo home_url('/lineas/ancho-metrico.html'); ?>">Ancho métrico</a></li>
                            <li><a href="<?php echo home_url('/lineas/ancho-internacional.html'); ?>">Ancho internacional</a></li>
                            <li><a href="<?php echo home_url('/lineas/tipos-lineas.html'); ?>">Distintos tipos de líneas</a></li>
                            <li><a href="<?php echo home_url('/lineas/lineas-cerradas.html'); ?>">Líneas Cerradas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo home_url('/proyectos/'); ?>">Proyectos ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo home_url('/proyectos/proyectos-cancelados.html'); ?>">Proyectos cancelados</a></li>
                            <li><a href="<?php echo home_url('/proyectos/proyectos-actuales.html'); ?>">Proyectos actuales</a></li>
                            <li><a href="<?php echo home_url('/proyectos/proyectos-en-marcha.html'); ?>">Proyectos en marcha</a></li>
                            <li><a href="<?php echo home_url('/proyectos/proyectos-estudio.html'); ?>">Proyectos en estudio</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo home_url('/curiosidades.html'); ?>">Curiosidades</a></li>
                    <li><a href="<?php echo home_url('/noticias/'); ?>">Noticias</a></li>
                    <li><a href="<?php echo home_url('/ciudades/'); ?>">Desarrollo ciudades</a></li>
                    <li><a href="<?php echo home_url('/estaciones/'); ?>">Estaciones de tren</a></li>
                </ul>
            </nav>
            <!-- Barra de búsqueda -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar en el blog..." class="search-input">
                <div id="searchResults" class="search-results"></div>
            </div>

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