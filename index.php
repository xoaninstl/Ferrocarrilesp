<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1><img src="<?php echo get_template_directory_uri(); ?>/images/logo-ferrocarril-esp.png" alt="Logo Ferrocarril Esp" class="logo-img"></h1>
            </div>
            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="#inicio">Inicio</a></li>
                    <li class="dropdown">
                        <a href="<?php echo home_url('/lineas/'); ?>">Líneas ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo get_category_link(get_cat_ID('Ancho ibérico')); ?>">Ancho ibérico</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Ancho métrico')); ?>">Ancho métrico</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Ancho internacional')); ?>">Ancho internacional</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Tipos de líneas')); ?>">Distintos tipos de líneas</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Líneas cerradas')); ?>">Líneas Cerradas</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="<?php echo home_url('/proyectos/'); ?>">Proyectos ▼</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos cancelados')); ?>">Proyectos cancelados</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos actuales')); ?>">Proyectos actuales</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos en marcha')); ?>">Proyectos en marcha</a></li>
                            <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos en estudio')); ?>">Proyectos en estudio</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo get_category_link(get_cat_ID('Curiosidades')); ?>">Curiosidades</a></li>
                    <li><a href="<?php echo home_url('/noticias/'); ?>">Noticias</a></li>
                    <li><a href="<?php echo home_url('/ciudades/'); ?>">Desarrollo ciudades</a></li>
                    <li><a href="<?php echo home_url('/estaciones/'); ?>">Estaciones de tren</a></li>
                </ul>
            </nav>
            <!-- Barra de búsqueda -->
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

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <div class="content-wrapper">
                <!-- Left Content -->
                <div class="content-left">
                    <section id="inicio" class="section">
                        <h2><?php bloginfo('name'); ?></h2>
                        <p><?php bloginfo('description'); ?></p>

                        <div class="secciones-overview">
                            <h3>Secciones del Blog</h3>
                            <div class="secciones-grid">
                                <div class="seccion-card">
                                    <h4>🚆 Líneas</h4>
                                    <ul>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Ancho ibérico')); ?>">Ancho ibérico</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Ancho métrico')); ?>">Ancho métrico</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Ancho internacional')); ?>">Ancho internacional</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Tipos de líneas')); ?>">Distintos tipos de líneas</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Líneas cerradas')); ?>">Líneas Cerradas</a></li>
                                    </ul>
                                </div>

                                <div class="seccion-card">
                                    <h4>📋 Proyectos</h4>
                                    <ul>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos cancelados')); ?>">Proyectos cancelados</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos actuales')); ?>">Proyectos actuales</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos en marcha')); ?>">Proyectos en marcha</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Proyectos en estudio')); ?>">Proyectos en estudio</a></li>
                                    </ul>
                                </div>

                                <div class="seccion-card">
                                    <h4>🏙️ Desarrollo ciudades</h4>
                                    <ul>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Bilbao')); ?>">Bilbao</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Sevilla')); ?>">Sevilla</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('A Coruña')); ?>">A Coruña</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Valencia')); ?>">Valencia</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Madrid')); ?>">Madrid</a></li>
                                        <li><a href="<?php echo get_category_link(get_cat_ID('Barcelona')); ?>">Barcelona</a></li>
                                        <li class="more-cities" style="display: none;">
                                            <!-- Aquí se mostrarían otras ciudades cuando se expanda -->
                                        </li>
                                        <li style="border: none !important; border-bottom: none !important; list-style: none;"><a href="#" onclick="toggleMoreCities(); return false;" style="color: #888 !important; font-size: 0.9em; text-decoration: none; border: none !important; padding: 0 !important; display: inline !important;">Ver más ciudades...</a></li>
                                    </ul>
                                </div>

                                <div class="seccion-card">
                                    <h4>🚉 Estaciones de tren</h4>
                                    <ul>
                                        <li><a href="<?php echo home_url('/estaciones/mapa-provincias.html'); ?>">Mapa por provincias</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="latest-posts">
                            <h3>Últimas Noticias</h3>
                            <div id="news-container">
                                <?php
                                // Obtener las últimas noticias desde WordPress
                                $latest_news = get_latest_news(5);

                                if (!empty($latest_news)) {
                                    foreach ($latest_news as $news_post) {
                                        $formatted_post = format_post_for_display($news_post);
                                        ?>
                                        <div class="post">
                                            <h4><a href="<?php echo $formatted_post['permalink']; ?>"><?php echo esc_html($formatted_post['title']); ?></a></h4>
                                            <div class="post-meta">
                                                <span>📅 <?php echo esc_html($formatted_post['date']); ?></span> |
                                                <span>👤 <?php echo esc_html($formatted_post['author']); ?></span>
                                            </div>
                                            <p><?php echo esc_html($formatted_post['excerpt']); ?></p>
                                            <?php if (!empty($formatted_post['categories'])) : ?>
                                                <div class="post-categories">
                                                    <?php foreach ($formatted_post['categories'] as $category) : ?>
                                                        <span class="post-category"><?php echo esc_html($category); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<p>No hay noticias disponibles en este momento.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </section>

                    <!-- Comments Section -->
                    <section class="comments-section">
                        <h3>Comentarios</h3>
                        <?php
                        // Sistema de comentarios de WordPress
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        } else {
                            // Fallback al sistema original
                            ?>
                            <div class="comment-form">
                                <div class="form-row">
                                    <input type="text" id="commentName" placeholder="Tu nombre" class="comment-input">
                                    <input type="email" id="commentEmail" placeholder="Tu correo electrónico" class="comment-input">
                                </div>
                                <textarea id="commentText" placeholder="Escribe tu comentario aquí..."></textarea>
                                <button onclick="addComment()" class="btn-comment">Publicar Comentario</button>
                            </div>
                            <div id="commentsList" class="comments-list">
                                <!-- Comments will be loaded here -->
                            </div>
                            <?php
                        }
                        ?>
                    </section>
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar">
                    <div class="author-info">
                        <h3>Sobre Mí</h3>
                        <div class="author-photo">
                            <?php
                            $author_id = 1; // ID del autor principal
                            $author_image = get_avatar($author_id, 80);
                            if ($author_image) {
                                echo $author_image;
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/tu-foto.jpg" alt="Foto del autor" id="authorPhoto">';
                            }
                            ?>
                        </div>
                        <h4 id="authorName"><?php echo get_the_author_meta('display_name', $author_id); ?></h4>
                        <p id="authorBio"><?php echo get_the_author_meta('description', $author_id) ?: 'Apasionado del ferrocarril español. Amante de la historia ferroviaria y las innovaciones del sector. Compartiendo conocimiento y curiosidades sobre el mundo del tren.'; ?></p>

                        <div class="social-links">
                            <h5>Redes Sociales</h5>
                            <div class="social-icons">
                                <?php
                                $social_links = ferrocarril_get_user_social_links($author_id);
                                if (!empty($social_links)) {
                                    foreach ($social_links as $network => $data) {
                                        echo '<a href="' . esc_url($data['url']) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="' . esc_attr($data['name']) . '">';
                                        echo $data['icon'] . ' ' . esc_html($data['name']);
                                        echo '</a>';
                                    }
                                } else {
                                    echo '<p style="color: #666; font-style: italic; font-size: 0.9rem;">Configura tus redes sociales en tu perfil de usuario.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="quick-links">
                        <h3>Enlaces Rápidos</h3>
                        <ul>
                            <li><a href="#curiosidades">Curiosidades</a></li>
                            <li><a href="#compra-billetes">Compra de Billetes</a></li>
                            <li><a href="#faq">FAQ - Preguntas Frecuentes</a></li>
                        </ul>
                    </div>

                    <!-- Calendario Ferroviario -->
                    <div class="railway-calendar">
                        <div class="calendar-content-wrapper">
                            <h3>Calendario Ferroviario</h3>
                            <div class="calendar-container">
                                <div class="calendar-header">
                                    <button id="prevMonth" class="calendar-nav">&lt;</button>
                                    <span id="currentMonth">Agosto 2025</span>
                                    <button id="nextMonth" class="calendar-nav">&gt;</button>
                                </div>
                                <div class="calendar-grid" id="calendarGrid">
                                    <!-- Los días se generan dinámicamente -->
                                </div>
                            </div>

                            <!-- Leyenda de Colores del Calendario -->
                            <div class="calendar-legend">
                                <h4>Leyenda de Eventos</h4>
                                <div class="legend-items">
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #e8f5e8; color: #2e7d32;">A</span>
                                        <span>Apertura de Línea</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #fff3e0; color: #f57c00;">I</span>
                                        <span>Inicio de Obras</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #e3f2fd; color: #1976d2;">F</span>
                                        <span>Fin de Obras</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #fce4ec; color: #c2185b;">E</span>
                                        <span>Evento Especial</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #f3e5f5; color: #7b1fa2;">M</span>
                                        <span>Mantenimiento</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color" style="background-color: #e0f2f1; color: #00695c;">A</span>
                                        <span>Aniversario</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sistema de Filtrado Avanzado por Categorías -->
                    <div class="advanced-filter">
                        <h3>🔍 Filtro Avanzado</h3>
                        <p class="filter-description">Selecciona múltiples categorías para encontrar contenido específico</p>

                        <!-- Sección Histórico -->
                        <div class="filter-section">
                            <div class="section-header" onclick="toggleCategorySection('historico')">
                                <h4>📚 Histórico</h4>
                                <span class="toggle-icon">▼</span>
                            </div>
                            <div class="section-content" id="historico-section">
                                <div class="category-checkbox">
                                    <input type="checkbox" id="ancho_iberico" value="ancho_iberico" onchange="updateCategoryFilter()">
                                    <label for="ancho_iberico">Ancho Ibérico</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="ancho_metrico" value="ancho_metrico" onchange="updateCategoryFilter()">
                                    <label for="ancho_metrico">Ancho Métrico</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="ancho_internacional" value="ancho_internacional" onchange="updateCategoryFilter()">
                                    <label for="ancho_internacional">Ancho Internacional</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="lineas_cerradas" value="lineas_cerradas" onchange="updateCategoryFilter()">
                                    <label for="lineas_cerradas">Líneas Cerradas</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="proyectos_cancelados" value="proyectos_cancelados" onchange="updateCategoryFilter()">
                                    <label for="proyectos_cancelados">Proyectos Cancelados</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="proyectos_actuales" value="proyectos_actuales" onchange="updateCategoryFilter()">
                                    <label for="proyectos_actuales">Proyectos Actuales</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="proyectos_en_marcha" value="proyectos_en_marcha" onchange="updateCategoryFilter()">
                                    <label for="proyectos_en_marcha">Proyectos en Marcha</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="proyectos_estudio" value="proyectos_estudio" onchange="updateCategoryFilter()">
                                    <label for="proyectos_estudio">Proyectos en Estudio</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Noticias -->
                        <div class="filter-section">
                            <div class="section-header" onclick="toggleCategorySection('noticias')">
                                <h4>📰 Noticias</h4>
                                <span class="toggle-icon">▼</span>
                            </div>
                            <div class="section-content" id="noticias-section">
                                <div class="category-checkbox">
                                    <input type="checkbox" id="noticias" value="noticias" onchange="updateCategoryFilter()">
                                    <label for="noticias">Noticias</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="metro" value="metro" onchange="updateCategoryFilter()">
                                    <label for="metro">Metro</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="tram" value="tram" onchange="updateCategoryFilter()">
                                    <label for="tram">Tranvía</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="ave" value="ave" onchange="updateCategoryFilter()">
                                    <label for="ave">AVE</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="cercanias" value="cercanias" onchange="updateCategoryFilter()">
                                    <label for="cercanias">Cercanías</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="apertura_linea" value="apertura_linea" onchange="updateCategoryFilter()">
                                    <label for="apertura_linea">Apertura de Línea</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="inicio_obras" value="inicio_obras" onchange="updateCategoryFilter()">
                                    <label for="inicio_obras">Inicio de Obras</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="fin_obras" value="fin_obras" onchange="updateCategoryFilter()">
                                    <label for="fin_obras">Fin de Obras</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="evento_especial" value="evento_especial" onchange="updateCategoryFilter()">
                                    <label for="evento_especial">Evento Especial</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="mantenimiento" value="mantenimiento" onchange="updateCategoryFilter()">
                                    <label for="mantenimiento">Mantenimiento</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="aniversario" value="aniversario" onchange="updateCategoryFilter()">
                                    <label for="aniversario">Aniversario</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="cambio_horarios" value="cambio_horarios" onchange="updateCategoryFilter()">
                                    <label for="cambio_horarios">Cambio de Horarios</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Ciudades -->
                        <div class="filter-section">
                            <div class="section-header" onclick="toggleCategorySection('ciudades')">
                                <h4>🏙️ Ciudades</h4>
                                <span class="toggle-icon">▼</span>
                            </div>
                            <div class="section-content" id="ciudades-section">
                                <div class="category-checkbox">
                                    <input type="checkbox" id="bilbao" value="bilbao" onchange="updateCategoryFilter()">
                                    <label for="bilbao">Bilbao</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="sevilla" value="sevilla" onchange="updateCategoryFilter()">
                                    <label for="sevilla">Sevilla</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="a_coruna" value="a_coruna" onchange="updateCategoryFilter()">
                                    <label for="a_coruna">A Coruña</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="valencia" value="valencia" onchange="updateCategoryFilter()">
                                    <label for="valencia">Valencia</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="madrid" value="madrid" onchange="updateCategoryFilter()">
                                    <label for="madrid">Madrid</label>
                                </div>
                                <div class="category-checkbox">
                                    <input type="checkbox" id="barcelona" value="barcelona" onchange="updateCategoryFilter()">
                                    <label for="barcelona">Barcelona</label>
                                </div>
                                <div class="more-cities-filter" style="display: none;"></div>
                                <div style="margin-top: 10px; text-align: center;">
                                    <a href="#" onclick="toggleMoreCitiesFilter(); return false;" style="color: #888; font-size: 0.9em; text-decoration: none; cursor: pointer;">Ver más ciudades...</a>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de control -->
                        <div class="filter-controls">
                            <button class="btn-filter" onclick="applyCategoryFilter()" disabled>
                                Selecciona categorías
                            </button>
                            <button class="btn-clear" onclick="clearCategoryFilters()">
                                Limpiar Filtros
                            </button>
                        </div>

                        <!-- Resultados del filtrado -->
                        <div id="filterResults" class="filter-results" style="display: none;">
                            <h4>Resultados del Filtrado</h4>
                            <div id="filteredContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>FAQ - Preguntas Frecuentes</h4>
                    <div class="faq-list">
                        <div class="faq-item">
                            <h5>¿Qué es el ancho ibérico?</h5>
                            <p>El ancho ibérico es la medida estándar de las vías ferroviarias en España y Portugal, diferente al ancho internacional.</p>
                        </div>
                        <div class="faq-item">
                            <h5>¿Cuándo se inauguró el primer ferrocarril en España?</h5>
                            <p>El primer ferrocarril en España se inauguró en 1848, conectando Barcelona con Mataró.</p>
                        </div>
                        <div class="faq-item">
                            <h5>¿Qué velocidad alcanzan los trenes AVE?</h5>
                            <p>Los trenes AVE pueden alcanzar velocidades de hasta 310 km/h en servicio comercial.</p>
                        </div>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Política de Privacidad</h4>
                    <p>Este blog respeta tu privacidad. No recopilamos información personal sin tu consentimiento. Los comentarios se almacenan localmente en tu navegador.</p>
                    <p>Para más información, contacta con nosotros.</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>