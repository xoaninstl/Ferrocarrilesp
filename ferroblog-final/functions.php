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

// Función para crear categorías base
function ferroblog_create_categories() {
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
}

// Crear categorías base al activar el tema
add_action('after_switch_theme', 'ferroblog_create_categories');

// También crear categorías en init para asegurar que se creen
add_action('init', function() {
    // Solo crear si no hay categorías personalizadas
    $categories_count = wp_count_terms('category', ['hide_empty' => false]);
    if ($categories_count < 10) { // Si hay menos de 10 categorías, crear las nuestras
        ferroblog_create_categories();
    }
});

// Función para crear menús automáticamente
function ferroblog_create_menus() {
    // Crear menú principal si no existe
    $main_menu = wp_get_nav_menu_object('Menú Principal Ferroblog');
    if (!$main_menu) {
        $main_menu_id = wp_create_nav_menu('Menú Principal Ferroblog');
        
        // Agregar páginas principales al menú
        $menu_items = [
            ['title' => 'Inicio', 'url' => home_url('/')],
            ['title' => 'Líneas', 'url' => get_category_link(get_category_by_slug('ancho_iberico')->term_id)],
            ['title' => 'Proyectos', 'url' => get_category_link(get_category_by_slug('proyectos_actuales')->term_id)],
            ['title' => 'Ciudades', 'url' => get_category_link(get_category_by_slug('sevilla')->term_id)],
            ['title' => 'Noticias', 'url' => get_category_link(get_category_by_slug('metro')->term_id)],
        ];
        
        foreach ($menu_items as $item) {
            wp_update_nav_menu_item($main_menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'],
                'menu-item-status' => 'publish'
            ]);
        }
        
        // Asignar menú a la ubicación 'primary'
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $main_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    // Crear menú del sidebar si no existe
    $sidebar_menu = wp_get_nav_menu_object('Enlaces Rápidos Ferroblog');
    if (!$sidebar_menu) {
        $sidebar_menu_id = wp_create_nav_menu('Enlaces Rápidos Ferroblog');
        
        // Agregar enlaces rápidos al menú del sidebar
        $sidebar_items = [
            ['title' => '🚆 Líneas', 'url' => get_category_link(get_category_by_slug('ancho_iberico')->term_id)],
            ['title' => '📋 Proyectos', 'url' => get_category_link(get_category_by_slug('proyectos_actuales')->term_id)],
            ['title' => '🏙️ Ciudades', 'url' => get_category_link(get_category_by_slug('sevilla')->term_id)],
            ['title' => '🚉 Estaciones', 'url' => get_category_link(get_category_by_slug('estaciones')->term_id)],
            ['title' => '📰 Noticias', 'url' => get_category_link(get_category_by_slug('metro')->term_id)],
        ];
        
        foreach ($sidebar_items as $item) {
            wp_update_nav_menu_item($sidebar_menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'],
                'menu-item-status' => 'publish'
            ]);
        }
        
        // Asignar menú a la ubicación 'sidebar'
        $locations = get_theme_mod('nav_menu_locations');
        $locations['sidebar'] = $sidebar_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

// Crear menús al activar el tema
add_action('after_switch_theme', 'ferroblog_create_menus');

// También crear menús en init si no existen
add_action('init', function() {
    $locations = get_theme_mod('nav_menu_locations');
    if (empty($locations['primary']) || empty($locations['sidebar'])) {
        ferroblog_create_menus();
    }
    
    // Configurar página de inicio si no está configurada correctamente
    if (get_option('show_on_front') !== 'posts') {
        ferroblog_setup_homepage();
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

// Función para configurar la página de inicio automáticamente
function ferroblog_setup_homepage() {
    // Configurar para mostrar las últimas entradas en la página de inicio
    update_option('show_on_front', 'posts');
    update_option('page_on_front', 0);
    update_option('page_for_posts', 0);
}

// Función para forzar la creación de categorías y menús (útil para debugging)
function ferroblog_force_setup() {
    if (isset($_GET['setup_ferroblog']) && $_GET['setup_ferroblog'] === 'force') {
        ferroblog_create_categories();
        ferroblog_create_menus();
        ferroblog_setup_homepage();
        wp_redirect(admin_url('edit-tags.php?taxonomy=category&message=setup_complete'));
        exit;
    }
}
add_action('init', 'ferroblog_force_setup');

// Configurar página de inicio al activar el tema
add_action('after_switch_theme', 'ferroblog_setup_homepage');
?>
