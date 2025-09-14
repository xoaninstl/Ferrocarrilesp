<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
    <?php
    $events = [];
    $args = [
        'post_type' => 'ferroblog_event',
        'posts_per_page' => -1,
    ];
    $event_query = new WP_Query($args);
    if ($event_query->have_posts()) {
        while ($event_query->have_posts()) {
            $event_query->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            if ($event_date) {
                $events[] = [
                    'title' => get_the_title(),
                    'date'  => $event_date,
                    'description' => get_the_excerpt(),
                ];
            }
        }
    }
    wp_reset_postdata();
    ?>
    const ferroblog_events = <?php echo json_encode($events); ?>;
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="header">
        <div class="container">
            <div class="logo">
                <?php if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else { ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title"><?php bloginfo('name'); ?></a>
                <?php } ?>
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

