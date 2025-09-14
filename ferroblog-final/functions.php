<?php
// Cargar estilos y scripts
add_action('wp_enqueue_scripts', function () {
    // Cargar Google Fonts
    wp_enqueue_style('google-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', [], null);
    
    // Cargar la hoja de estilos principal (style.css) correctamente
    wp_enqueue_style('ferroblog-style', get_stylesheet_uri());
    
    // Cargar el script principal (script.js)
    wp_enqueue_script('ferroblog-script', get_template_directory_uri() . '/script.js', [], '1.0', true);
});

// Soportes del tema
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
        'sidebar' => __('Menú de la barra lateral', 'ferroblog'), // Menú para enlaces rápidos
        'footer'  => __('Menú pie', 'ferroblog'),
    ]);
});

// Crear categorías base al activar el tema
add_action('after_switch_theme', function () {
    $categories = [
        'metro', 'tram', 'ave', 'cercanias', 'apertura_linea', 'inicio_obras', 'fin_obras', 'evento_especial', 'mantenimiento', 'aniversario',
        'ancho_iberico', 'ancho_metrico', 'ancho_internacional', 'lineas_cerradas', 'proyectos_cancelados', 'proyectos_actuales', 'proyectos_en_marcha', 'proyectos_estudio',
        'sevilla', 'madrid', 'barcelona', 'valencia', 'bilbao', 'a_coruna'
        // Puedes añadir más si lo necesitas
    ];
    foreach ($categories as $slug) {
        if (!term_exists($slug, 'category')) {
            wp_insert_term(ucwords(str_replace('_', ' ', $slug)), 'category', ['slug' => $slug]);
        }
    }
});

/**
 * Modifica la consulta principal de WordPress para aplicar los filtros de categoría del sidebar.
 * Se activa antes de que se ejecute la consulta principal en páginas de archivo (como categorías).
 */
function ferroblog_filter_posts($query) {
    // Solo actuar en la consulta principal del frontend y en páginas de archivo/categoría
    if ( !is_admin() && $query->is_main_query() && ( is_category() || is_archive() ) ) {
        
        // Comprobar si se han enviado filtros desde el formulario
        if (isset($_GET['filter_categories']) && is_array($_GET['filter_categories'])) {
            
            $selected_categories = array_map('sanitize_text_field', $_GET['filter_categories']);

            // 'tax_query' permite consultas complejas basadas en taxonomías (como las categorías)
            $tax_query = [
                'relation' => 'AND', // Exigir que una entrada pertenezca a TODAS las categorías seleccionadas
            ];

            // Añadir cada categoría seleccionada a la consulta
            foreach ($selected_categories as $category_slug) {
                $tax_query[] = [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ];
            }
            
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'ferroblog_filter_posts');
?>
