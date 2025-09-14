<?php
/**
 * Archivo de diagnóstico para el tema Ferroblog
 * Este archivo te ayudará a identificar problemas
 */

// Activar solo si necesitas debug
if (defined('WP_DEBUG') && WP_DEBUG) {
    echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
    echo '<h3>🔍 Diagnóstico del Tema Ferroblog</h3>';
    
    // Verificar archivos del tema
    $theme_dir = get_stylesheet_directory();
    $css_file = $theme_dir . '/assets/css/base.css';
    $js_file = $theme_dir . '/assets/js/script.js';
    
    echo '<h4>📁 Archivos del Tema:</h4>';
    echo '<ul>';
    echo '<li>Directorio del tema: ' . $theme_dir . '</li>';
    echo '<li>CSS base: ' . (file_exists($css_file) ? '✅ Existe' : '❌ No existe') . '</li>';
    echo '<li>JavaScript: ' . (file_exists($js_file) ? '✅ Existe' : '❌ No existe') . '</li>';
    echo '</ul>';
    
    // Verificar estilos cargados
    echo '<h4>🎨 Estilos Cargados:</h4>';
    global $wp_styles;
    if (isset($wp_styles->registered['ferroblog-base'])) {
        echo '<p>✅ CSS base cargado: ' . $wp_styles->registered['ferroblog-base']->src . '</p>';
    } else {
        echo '<p>❌ CSS base NO cargado</p>';
    }
    
    // Verificar scripts cargados
    echo '<h4>📜 Scripts Cargados:</h4>';
    global $wp_scripts;
    if (isset($wp_scripts->registered['ferroblog-script'])) {
        echo '<p>✅ JavaScript cargado: ' . $wp_scripts->registered['ferroblog-script']->src . '</p>';
    } else {
        echo '<p>❌ JavaScript NO cargado</p>';
    }
    
    // Verificar menús
    echo '<h4>🍽️ Menús:</h4>';
    $menus = wp_get_nav_menus();
    if (!empty($menus)) {
        echo '<ul>';
        foreach ($menus as $menu) {
            echo '<li>' . $menu->name . ' (ID: ' . $menu->term_id . ')</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>❌ No hay menús creados</p>';
    }
    
    // Verificar categorías
    echo '<h4>📂 Categorías:</h4>';
    $categories = get_categories();
    echo '<p>Total de categorías: ' . count($categories) . '</p>';
    
    echo '</div>';
}
?>
