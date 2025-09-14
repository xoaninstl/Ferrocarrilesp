<?php get_header(); ?>
<div class="content-left">
    <section id="inicio" class="section">
        <h2>Blog Ferrocarril Esp</h2>
        <p>Blog enfocado a la historia del ferrocarril en España y las noticias del sector. Comparto contigo la fascinante evolución de nuestro sistema ferroviario, desde las primeras locomotoras de vapor hasta los trenes de alta velocidad del futuro. Descubre proyectos, curiosidades y todo lo que hace que el ferrocarril español sea único en el mundo.</p>

        <div class="secciones-overview">
            <h3>Secciones del Blog</h3>
            <div class="secciones-grid">
                <?php
                function display_seccion_card($title, $icon, $categories) {
                    echo '<div class="seccion-card">';
                    echo '<h4>' . esc_html($icon) . ' ' . esc_html($title) . '</h4>';
                    echo '<ul>';
                    foreach ($categories as $slug => $name) {
                        $category = get_category_by_slug($slug);
                        if ($category) {
                            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($name) . '</a></li>';
                        }
                    }
                    echo '</ul>';
                    echo '</div>';
                }

                display_seccion_card('Líneas', '🚆', [
                    'ancho_iberico' => 'Ancho ibérico', 'ancho_metrico' => 'Ancho métrico',
                    'ancho_internacional' => 'Ancho internacional', 'lineas_cerradas' => 'Líneas Cerradas',
                ]);

                display_seccion_card('Proyectos', '📋', [
                    'proyectos_cancelados' => 'Proyectos cancelados', 'proyectos_actuales' => 'Proyectos actuales',
                    'proyectos_en_marcha' => 'Proyectos en marcha', 'proyectos_estudio' => 'Proyectos en estudio',
                ]);

                display_seccion_card('Desarrollo ciudades', '🏙️', [
                    'sevilla' => 'Sevilla', 'madrid' => 'Madrid', 'barcelona' => 'Barcelona',
                    'valencia' => 'Valencia', 'bilbao' => 'Bilbao', 'a_coruna' => 'A Coruña',
                ]);
                
                $estaciones_cat = get_category_by_slug('noticias');
                if ($estaciones_cat) {
                    echo '<div class="seccion-card"><h4>🚉 Estaciones de tren</h4><ul>';
                    echo '<li><a href="' . esc_url(get_category_link($estaciones_cat->term_id)) . '">Mapa por provincias</a></li>';
                    echo '</ul></div>';
                }
                ?>
            </div>
        </div>

        <div class="latest-posts">
            <h3>Últimas Noticias</h3>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="post-meta">📅 <?php the_time('j \d\e F \d\e Y'); ?> — 👤 <?php the_author(); ?></div>
                    <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                </article>
            <?php endwhile; ?>
                <div class="navigation-links">
                    <div class="nav-previous"><?php next_posts_link('⬅ Noticias antiguas'); ?></div>
                    <div class="nav-next"><?php previous_posts_link('Noticias recientes ➡'); ?></div>
                </div>
            <?php else : ?>
                <p>No hay noticias disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>