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
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title"><?php bloginfo('name'); ?></a>
                    <?php } ?>
                </h1>
            </div>
            <nav class="nav">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-menu',
                    'fallback_cb'    => false,
                ]);
                ?>
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

