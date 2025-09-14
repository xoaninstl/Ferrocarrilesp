<aside class="sidebar">
    <div class="author-info">
        <h3>Sobre Mí</h3>
        <div class="author-photo">
            <?php
            $author_id = get_the_author_meta('ID');
            $avatar = get_avatar_url($author_id, ['size' => 160]);
            ?>
            <img src="<?php echo esc_url($avatar); ?>" alt="Foto del autor" id="authorPhoto">
        </div>
        <h4 id="authorName"><?php the_author(); ?></h4>
        <p id="authorBio"><?php echo esc_html(get_the_author_meta('description')); ?></p>
        
        <div class="social-links">
            <h5>Redes Sociales</h5>
            <div class="social-icons">
                <a href="#" id="twitterLink" class="social-icon">Twitter</a>
                <a href="#" id="instagramLink" class="social-icon">Instagram</a>
                <a href="#" id="youtubeLink" class="social-icon">YouTube</a>
            </div>
        </div>
    </div>

    <div class="quick-links">
        <h3>Enlaces Rápidos</h3>
        <?php
        wp_nav_menu([
            'theme_location' => 'sidebar',
            'container'      => false,
            'fallback_cb'    => false,
            'depth'          => 1, // Muestra solo el nivel principal
        ]);
        ?>
    </div>
    
    <div class="railway-calendar">
        </div>
    
    <div class="advanced-filter">
        <h3>🔍 Filtro Avanzado</h3>
        <p class="filter-description">Selecciona categorías para afinar tu búsqueda en esta sección.</p>
        
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(get_category_link(get_queried_object_id())); ?>">
            
            <?php
            $groups = [
                'Histórico' => ['ancho_iberico', 'ancho_metrico', 'ancho_internacional', 'lineas_cerradas', 'proyectos_cancelados', 'proyectos_actuales', 'proyectos_en_marcha', 'proyectos_estudio'],
                'Noticias'  => ['noticias', 'metro', 'tram', 'ave', 'cercanias', 'apertura_linea', 'inicio_obras', 'fin_obras', 'evento_especial', 'mantenimiento', 'aniversario', 'cambio_horarios'],
                'Ciudades'  => ['sevilla', 'madrid', 'barcelona', 'valencia', 'bilbao', 'a_coruna'],
            ];
            
            // Mantener los filtros seleccionados marcados después de enviar el formulario
            $checked_cats = isset($_GET['filter_categories']) ? $_GET['filter_categories'] : [];
            ?>

            <?php foreach ($groups as $group_name => $categories) : ?>
                <div class="filter-section">
                    <div class="section-header" onclick="toggleCategorySection('<?php echo sanitize_title($group_name); ?>')">
                        <h4><?php echo esc_html($group_name); ?></h4>
                        <span class="toggle-icon">▼</span>
                    </div>
                    <div class="section-content" id="<?php echo sanitize_title($group_name); ?>-section">
                        <?php foreach ($categories as $cat_slug) : 
                            $category = get_category_by_slug($cat_slug);
                            if ($category) : ?>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="<?php echo esc_attr($cat_slug); ?>" name="filter_categories[]" value="<?php echo esc_attr($cat_slug); ?>" <?php checked(in_array($cat_slug, $checked_cats)); ?>>
                                    <label for="<?php echo esc_attr($cat_slug); ?>"><?php echo esc_html($category->name); ?></label>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="filter-controls">
                <button type="submit" class="btn-filter">Aplicar Filtros</button>
                <a href="<?php echo esc_url(get_category_link(get_queried_object_id())); ?>" class="btn-clear">Limpiar Filtros</a>
            </div>
        </form>
    </div>
</aside>