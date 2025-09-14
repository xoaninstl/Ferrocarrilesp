<?php
/**
 * Functions.php para el tema Ferrocarril Esp
 * Mantiene la estructura estática del HTML original
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// ==================================================================================
// CONFIGURACIÓN BÁSICA DEL TEMA
// ==================================================================================

function ferrocarril_esp_setup() {
    // Soporte para títulos de página
    add_theme_support('title-tag');

    // Soporte para imágenes destacadas
    add_theme_support('post-thumbnails');

    // Soporte para menús
    add_theme_support('menus');

    // Soporte para feeds automáticos
    add_theme_support('automatic-feed-links');

    // Soporte para HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'ferrocarril_esp_setup');

// ==================================================================================
// MAPEO DE CATEGORÍAS HTML-WORDPRESS
// ==================================================================================

function get_category_mapping() {
    return array(
        // Categorías Históricas
        'ancho_iberico' => 'ancho-iberico',
        'ancho_metrico' => 'ancho-metrico',
        'ancho_internacional' => 'ancho-internacional',
        'lineas_cerradas' => 'lineas-cerradas',
        'proyectos_cancelados' => 'proyectos-cancelados',
        'proyectos_actuales' => 'proyectos-actuales',
        'proyectos_en_marcha' => 'proyectos-en-marcha',
        'proyectos_estudio' => 'proyectos-en-estudio',

        // Categorías de Noticias
        'noticias' => 'noticias',
        'metro' => 'metro',
        'tram' => 'tranvia',
        'ave' => 'ave',
        'cercanias' => 'cercanias',
        'apertura_linea' => 'apertura-linea',
        'inicio_obras' => 'inicio-obras',
        'fin_obras' => 'fin-obras',
        'evento_especial' => 'evento-especial',
        'mantenimiento' => 'mantenimiento',
        'aniversario' => 'aniversario',
        'cambio_horarios' => 'cambio-horarios',

        // Categorías de Ciudades
        'sevilla' => 'sevilla',
        'madrid' => 'madrid',
        'barcelona' => 'barcelona',
        'valencia' => 'valencia',
        'bilbao' => 'bilbao'
    );
}

// ==================================================================================
// FUNCIONES PARA OBTENER POSTS POR CATEGORÍAS
// ==================================================================================

function get_posts_by_html_category($html_category, $limit = 5) {
    $mapping = get_category_mapping();

    if (!isset($mapping[$html_category])) {
        return array();
    }

    $wp_category = $mapping[$html_category];

    $args = array(
        'category_name' => $wp_category,
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );

    return get_posts($args);
}

function get_latest_news($limit = 5) {
    $args = array(
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'post_type_ferrocarril',
                'value' => 'noticia',
                'compare' => '='
            )
        )
    );

    return get_posts($args);
}

// ==================================================================================
// BÚSQUEDA PERSONALIZADA
// ==================================================================================

function ferrocarril_esp_search_ajax() {
    check_ajax_referer('ferrocarril_search', 'nonce');

    $search_term = sanitize_text_field($_POST['search_term']);

    if (empty($search_term)) {
        wp_die();
    }

    // Buscar en posts
    $args = array(
        's' => $search_term,
        'posts_per_page' => 10,
        'post_status' => 'publish'
    );

    $posts = get_posts($args);
    $results = array();

    foreach ($posts as $post) {
        $categories = get_the_category($post->ID);
        $category_names = array();

        foreach ($categories as $category) {
            $category_names[] = $category->name;
        }

        $results[] = array(
            'title' => $post->post_title,
            'excerpt' => wp_trim_words($post->post_content, 20, '...'),
            'url' => get_permalink($post->ID),
            'date' => get_the_date('d/m/Y', $post->ID),
            'categories' => implode(', ', $category_names),
            'type' => 'post'
        );
    }

    // También buscar en páginas estáticas si es necesario
    $static_results = array(
        array(
            'title' => 'Líneas - Ancho Ibérico',
            'excerpt' => 'Información sobre las líneas de ancho ibérico en España',
            'url' => home_url('/lineas/ancho-iberico.html'),
            'type' => 'page'
        ),
        array(
            'title' => 'Proyectos Actuales',
            'excerpt' => 'Proyectos ferroviarios actualmente en desarrollo',
            'url' => home_url('/proyectos/proyectos-actuales.html'),
            'type' => 'page'
        )
        // Añadir más páginas estáticas según sea necesario
    );

    // Filtrar páginas estáticas que coincidan con la búsqueda
    foreach ($static_results as $static_result) {
        if (stripos($static_result['title'], $search_term) !== false ||
            stripos($static_result['excerpt'], $search_term) !== false) {
            $results[] = $static_result;
        }
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_ferrocarril_search', 'ferrocarril_esp_search_ajax');
add_action('wp_ajax_nopriv_ferrocarril_search', 'ferrocarril_esp_search_ajax');

// ==================================================================================
// ENQUEUE SCRIPTS Y STYLES
// ==================================================================================

function ferrocarril_esp_scripts() {
    // CSS principal
    wp_enqueue_style('ferrocarril-style', get_template_directory_uri() . '/styles.css', array(), '1.0.1');

    // CSS específico para WordPress
    wp_enqueue_style('ferrocarril-wp-style', get_template_directory_uri() . '/wp-style.css', array('ferrocarril-style'), '1.0.2');

    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap', array(), null);

    // JavaScript principal
    wp_enqueue_script('ferrocarril-script', get_template_directory_uri() . '/script.js', array('jquery'), '1.0.0', true);

    // JavaScript específico para WordPress (búsqueda mejorada)
    wp_enqueue_script('ferrocarril-wp-search', get_template_directory_uri() . '/wp-search.js', array('jquery', 'ferrocarril-script'), '1.0.0', true);

    // Configuración JavaScript
    wp_enqueue_script('ferrocarril-config', get_template_directory_uri() . '/config.js', array(), '1.0.0', true);

    // Variables para AJAX
    wp_localize_script('ferrocarril-wp-search', 'ferrocarril_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ferrocarril_search'),
        'home_url' => home_url()
    ));
}
add_action('wp_enqueue_scripts', 'ferrocarril_esp_scripts');

// ==================================================================================
// CAMPOS PERSONALIZADOS PARA POSTS
// ==================================================================================

function add_ferrocarril_meta_boxes() {
    add_meta_box(
        'ferrocarril_post_type',
        'Tipo de Contenido Ferrocarril',
        'ferrocarril_post_type_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_ferrocarril_meta_boxes');

function ferrocarril_post_type_callback($post) {
    wp_nonce_field('ferrocarril_post_type_nonce', 'ferrocarril_post_type_nonce');

    $value = get_post_meta($post->ID, 'post_type_ferrocarril', true);

    echo '<label for="post_type_ferrocarril">Tipo de contenido:</label>';
    echo '<select id="post_type_ferrocarril" name="post_type_ferrocarril">';
    echo '<option value="noticia"' . selected($value, 'noticia', false) . '>Noticia</option>';
    echo '<option value="historico"' . selected($value, 'historico', false) . '>Histórico</option>';
    echo '<option value="ciudad"' . selected($value, 'ciudad', false) . '>Ciudad</option>';
    echo '</select>';
}

function save_ferrocarril_post_type($post_id) {
    if (!isset($_POST['ferrocarril_post_type_nonce']) ||
        !wp_verify_nonce($_POST['ferrocarril_post_type_nonce'], 'ferrocarril_post_type_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['post_type_ferrocarril'])) {
        update_post_meta($post_id, 'post_type_ferrocarril', sanitize_text_field($_POST['post_type_ferrocarril']));
    }
}
add_action('save_post', 'save_ferrocarril_post_type');

// ==================================================================================
// FUNCIONES AUXILIARES
// ==================================================================================

function get_post_categories_as_html_format($post_id) {
    $categories = get_the_category($post_id);
    $mapping = array_flip(get_category_mapping());
    $html_categories = array();

    foreach ($categories as $category) {
        if (isset($mapping[$category->slug])) {
            $html_categories[] = $mapping[$category->slug];
        }
    }

    return $html_categories;
}

function format_post_for_display($post) {
    $categories = get_post_categories_as_html_format($post->ID);

    return array(
        'id' => $post->ID,
        'title' => $post->post_title,
        'excerpt' => wp_trim_words($post->post_content, 30, '...'),
        'date' => get_the_date('d/m/Y', $post->ID),
        'author' => get_the_author_meta('display_name', $post->post_author),
        'categories' => $categories,
        'permalink' => get_permalink($post->ID)
    );
}

// ==================================================================================
// CAMPOS PERSONALIZADOS PARA PERFIL DE USUARIO (REDES SOCIALES)
// ==================================================================================

function ferrocarril_user_profile_fields($user) {
    ?>
    <h3>Información de Redes Sociales</h3>
    <table class="form-table">
        <tr>
            <th><label for="twitter">Twitter</label></th>
            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" />
                <br /><span class="description">URL completa de tu perfil de Twitter (ej: https://twitter.com/usuario)</span>
            </td>
        </tr>
        <tr>
            <th><label for="facebook">Facebook</label></th>
            <td>
                <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" class="regular-text" />
                <br /><span class="description">URL completa de tu perfil de Facebook</span>
            </td>
        </tr>
        <tr>
            <th><label for="instagram">Instagram</label></th>
            <td>
                <input type="text" name="instagram" id="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>" class="regular-text" />
                <br /><span class="description">URL completa de tu perfil de Instagram</span>
            </td>
        </tr>
        <tr>
            <th><label for="linkedin">LinkedIn</label></th>
            <td>
                <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text" />
                <br /><span class="description">URL completa de tu perfil de LinkedIn</span>
            </td>
        </tr>
        <tr>
            <th><label for="youtube">YouTube</label></th>
            <td>
                <input type="text" name="youtube" id="youtube" value="<?php echo esc_attr(get_the_author_meta('youtube', $user->ID)); ?>" class="regular-text" />
                <br /><span class="description">URL completa de tu canal de YouTube</span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'ferrocarril_user_profile_fields');
add_action('edit_user_profile', 'ferrocarril_user_profile_fields');

function ferrocarril_save_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Verificar nonce para seguridad
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'update-user_' . $user_id)) {
        return false;
    }

    $social_fields = array('twitter', 'facebook', 'instagram', 'linkedin', 'youtube');

    foreach ($social_fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_user_meta($user_id, $field, $value);

            // Debug: registrar en log de WordPress (opcional)
            error_log("Guardando $field para usuario $user_id: $value");
        }
    }
}
add_action('personal_options_update', 'ferrocarril_save_user_profile_fields');
add_action('edit_user_profile_update', 'ferrocarril_save_user_profile_fields');

// Función temporal para debug - verificar valores guardados
function ferrocarril_debug_user_meta() {
    if (!current_user_can('manage_options')) {
        return 'No tienes permisos para ver esta información.';
    }

    $current_user_id = get_current_user_id();
    $social_fields = array('twitter', 'facebook', 'instagram', 'linkedin', 'youtube');

    $output = '<div style="background: #f1f1f1; padding: 15px; margin: 10px; border-radius: 5px;">';
    $output .= '<h4>Debug - Valores actuales de redes sociales (Usuario ID: ' . $current_user_id . '):</h4>';

    foreach ($social_fields as $field) {
        $value = get_user_meta($current_user_id, $field, true);
        $output .= '<p><strong>' . ucfirst($field) . ':</strong> ' . ($value ? esc_html($value) : '<em>vacío</em>') . '</p>';
    }

    $output .= '</div>';
    return $output;
}

// Shortcode para mostrar los valores (usar [debug_social] en cualquier página)
add_shortcode('debug_social', 'ferrocarril_debug_user_meta');

// Función para crear un post de ejemplo (usar una sola vez)
function crear_post_ejemplo() {
    // Solo crear si no existe ya
    $existing_post = get_posts(array(
        'title' => 'Ejemplo de Post con Perfil de Autor',
        'post_status' => 'any',
        'numberposts' => 1
    ));

    if (empty($existing_post)) {
        $post_data = array(
            'post_title' => 'Ejemplo de Post con Perfil de Autor',
            'post_content' => 'Este es un post de ejemplo para mostrar el perfil del autor con enlaces a redes sociales y Gravatar al final del artículo. El perfil aparece automáticamente en la sección "Sobre el autor".',
            'post_status' => 'publish',
            'post_author' => 1, // Usuario admin
            'post_category' => array(1) // Categoría por defecto
        );

        wp_insert_post($post_data);
    }
}

// Shortcode para crear el post de ejemplo (usar [crear_ejemplo] una vez)
add_shortcode('crear_ejemplo', function() {
    if (current_user_can('manage_options')) {
        crear_post_ejemplo();
        return '<p style="background: #d4edda; padding: 10px; border-radius: 5px;">✅ Post de ejemplo creado. <a href="' . home_url() . '">Ver en la página principal</a></p>';
    }
    return 'No tienes permisos para crear posts.';
});

// ==================================================================================
// FUNCIONES PARA GRAVATAR Y PERFIL DE AUTOR
// ==================================================================================

function ferrocarril_get_gravatar($user_id, $size = 70) {
    $user = get_userdata($user_id);
    if (!$user) return '';

    $email = $user->user_email;
    $default = get_template_directory_uri() . '/img/default-avatar.png';

    return get_avatar($email, $size, $default, $user->display_name, array('class' => 'author-avatar'));
}

function ferrocarril_get_user_social_links($user_id) {
    $social_networks = array(
        'twitter' => array('name' => 'Twitter', 'icon' => '🐦'),
        'facebook' => array('name' => 'Facebook', 'icon' => '📘'),
        'instagram' => array('name' => 'Instagram', 'icon' => '📷'),
        'linkedin' => array('name' => 'LinkedIn', 'icon' => '💼'),
        'youtube' => array('name' => 'YouTube', 'icon' => '📺')
    );

    $social_links = array();

    foreach ($social_networks as $network => $data) {
        $url = get_the_author_meta($network, $user_id);
        if (!empty($url)) {
            $social_links[$network] = array(
                'url' => esc_url($url),
                'name' => $data['name'],
                'icon' => $data['icon']
            );
        }
    }

    return $social_links;
}

function ferrocarril_display_author_profile($user_id, $show_bio = true, $show_social = true) {
    $user = get_userdata($user_id);
    if (!$user) return '';

    $output = '<div class="author-profile">';

    // Avatar
    $output .= '<div class="author-avatar-container">';
    $output .= ferrocarril_get_gravatar($user_id, 70);
    $output .= '</div>';

    // Información del autor
    $output .= '<div class="author-info">';
    $output .= '<h4 class="author-name">' . esc_html($user->display_name) . '</h4>';

    // Biografía
    if ($show_bio && !empty($user->description)) {
        $output .= '<p class="author-bio">' . wp_kses_post($user->description) . '</p>';
    }

    // Enlaces sociales
    if ($show_social) {
        $social_links = ferrocarril_get_user_social_links($user_id);
        if (!empty($social_links)) {
            $output .= '<div class="author-social-links">';
            foreach ($social_links as $network => $data) {
                $output .= '<a href="' . $data['url'] . '" target="_blank" rel="noopener noreferrer" title="' . $data['name'] . '">';
                $output .= $data['icon'] . ' ' . $data['name'];
                $output .= '</a> ';
            }
            $output .= '</div>';
        }
    }

    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

// ==================================================================================
// CREACIÓN AUTOMÁTICA DE CATEGORÍAS
// ==================================================================================

function create_ferrocarril_categories() {
    $categories = array(
        'ancho-iberico' => 'Ancho Ibérico',
        'ancho-metrico' => 'Ancho Métrico',
        'ancho-internacional' => 'Ancho Internacional',
        'lineas-cerradas' => 'Líneas Cerradas',
        'proyectos-cancelados' => 'Proyectos Cancelados',
        'proyectos-actuales' => 'Proyectos Actuales',
        'proyectos-en-marcha' => 'Proyectos en Marcha',
        'proyectos-en-estudio' => 'Proyectos en Estudio',
        'noticias' => 'Noticias',
        'metro' => 'Metro',
        'tranvia' => 'Tranvía',
        'ave' => 'AVE',
        'cercanias' => 'Cercanías',
        'apertura-linea' => 'Apertura de Línea',
        'inicio-obras' => 'Inicio de Obras',
        'fin-obras' => 'Fin de Obras',
        'evento-especial' => 'Evento Especial',
        'mantenimiento' => 'Mantenimiento',
        'aniversario' => 'Aniversario',
        'cambio-horarios' => 'Cambio de Horarios',
        'sevilla' => 'Sevilla',
        'madrid' => 'Madrid',
        'barcelona' => 'Barcelona',
        'valencia' => 'Valencia',
        'bilbao' => 'Bilbao'
    );

    foreach ($categories as $slug => $name) {
        if (!category_exists($name)) {
            wp_insert_category(array(
                'cat_name' => $name,
                'category_nicename' => $slug
            ));
        }
    }
}
add_action('after_switch_theme', 'create_ferrocarril_categories');

?>