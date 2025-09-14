<?php
// Cargar estilos y scripts
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', [], null);
    // WordPress automatically loads style.css, which now contains all theme CSS
    // wp_enqueue_style('ferroblog-base', get_stylesheet_directory_uri() . '/assets/css/base.css', [], '1.0'); // Removed
    wp_enqueue_script('ferroblog-script', get_stylesheet_directory_uri() . '/script.js', [], '1.0', true);
});

// Soporte para imagen destacada en entradas
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 180,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    register_nav_menus([
        'primary' => __('Menú principal', 'ferroblog'),
        'footer'  => __('Menú pie', 'ferroblog'),
    ]);
});

// Crear categorías base al activar el tema
add_action('after_switch_theme', function () {
    $categories = [
        // Noticias
        'metro', 'tram', 'ave', 'cercanias', 'apertura_linea', 'inicio_obras', 'fin_obras', 'evento_especial', 'mantenimiento', 'aniversario',
        // Histórico / líneas
        'ancho_iberico', 'ancho_metrico', 'ancho_internacional', 'lineas_cerradas', 'proyectos_cancelados', 'proyectos_actuales', 'proyectos_en_marcha', 'proyectos_estudio',
        // Ciudades principales de España
        'sevilla', 'madrid', 'barcelona', 'valencia', 'bilbao', 'a_coruna',
        'zaragoza', 'malaga', 'murcia', 'palma', 'las_palmas', 'granada',
        'alicante', 'cordoba', 'valladolid', 'vigo', 'gijon', 'hospitalet',
        'vitoria', 'coruna', 'elche', 'santa_cruz', 'oviedo', 'santander',
        'pamplona', 'castellon', 'almeria', 'burgos', 'salamanca', 'alcorcon',
        'getafe', 'jerez', 'san_sebastian', 'leganes', 'cartagena', 'badalona',
        'leon', 'cadiz', 'tarragona', 'mataro', 'santa_coloma', 'jaen',
        'ourense', 'reus', 'torrelavega', 'el_puerto', 'lugo', 'ceuta',
        'melilla', 'guadalajara', 'pontevedra', 'ferrol', 'aviles', 'gandia'
    ];
    foreach ($categories as $slug) {
        if (!term_exists($slug, 'category')) {
            wp_insert_term(ucwords(str_replace('_', ' ', $slug)), 'category', ['slug' => $slug]);
        }
    }
});


