<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>
                    <?php if (function_exists('the_custom_logo') && has_custom_logo()) {
                        the_custom_logo();
                    } else { ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                            <?php 
                            // Intentar cargar el logo desde la carpeta images
                            $logo_path = get_stylesheet_directory_uri() . '/../images/logo-ferrocarril-esp.png';
                            if (file_exists(get_stylesheet_directory() . '/../images/logo-ferrocarril-esp.png')) {
                                echo '<img src="' . esc_url($logo_path) . '" alt="Logo Ferrocarril Esp" class="logo-img">';
                            } else {
                                echo esc_html(get_bloginfo('name'));
                            }
                            ?>
                        </a>
                    <?php } ?>
                </h1>
            </div>
            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
                    <li class="dropdown">
                        <a href="<?php echo esc_url(home_url('/lineas/')); ?>">Líneas ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo esc_url(home_url('/lineas/ancho-iberico/')); ?>">Ancho ibérico</a></li>
                            <li><a href="<?php echo esc_url(home_url('/lineas/ancho-metrico/')); ?>">Ancho métrico</a></li>
                            <li><a href="<?php echo esc_url(home_url('/lineas/ancho-internacional/')); ?>">Ancho internacional</a></li>
                            <li><a href="<?php echo esc_url(home_url('/lineas/tipos-lineas/')); ?>">Distintos tipos de líneas</a></li>
                            <li><a href="<?php echo esc_url(home_url('/lineas/lineas-cerradas/')); ?>">Líneas Cerradas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo esc_url(home_url('/proyectos/')); ?>">Proyectos ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo esc_url(home_url('/proyectos/proyectos-cancelados/')); ?>">Proyectos cancelados</a></li>
                            <li><a href="<?php echo esc_url(home_url('/proyectos/proyectos-actuales/')); ?>">Proyectos actuales</a></li>
                            <li><a href="<?php echo esc_url(home_url('/proyectos/proyectos-en-marcha/')); ?>">Proyectos en marcha</a></li>
                            <li><a href="<?php echo esc_url(home_url('/proyectos/proyectos-estudio/')); ?>">Proyectos en estudio</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/curiosidades/')); ?>">Curiosidades</a></li>
                    <li><a href="<?php echo esc_url(home_url('/noticias/')); ?>">Noticias</a></li>
                    <li><a href="<?php echo esc_url(home_url('/ciudades/')); ?>">Desarrollo ciudades</a></li>
                    <li><a href="<?php echo esc_url(home_url('/estaciones/')); ?>">Estaciones de tren</a></li>
                </ul>
            </nav>
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
    <main class="main">
        <div class="container">
            <div class="content-wrapper">

