<?php get_header(); ?>
    <div class="content-left">
        <section id="inicio" class="section">
            <h2>Blog Ferrocarril Esp</h2>
            <p>Blog enfocado a la historia del ferrocarril en España y las noticias del sector. Comparto contigo la fascinante evolución de nuestro sistema ferroviario, desde las primeras locomotoras de vapor hasta los trenes de alta velocidad del futuro. Descubre proyectos, curiosidades y todo lo que hace que el ferrocarril español sea único en el mundo.</p>
            
            <div class="secciones-overview">
                <h3>Secciones del Blog</h3>
                <div class="secciones-grid">
                    <div class="seccion-card">
                        <h4>🚆 Líneas</h4>
                        <ul>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('ancho_iberico')->term_id); ?>">Ancho ibérico</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('ancho_metrico')->term_id); ?>">Ancho métrico</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('ancho_internacional')->term_id); ?>">Ancho internacional</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('lineas_cerradas')->term_id); ?>">Líneas Cerradas</a></li>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>📋 Proyectos</h4>
                        <ul>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('proyectos_cancelados')->term_id); ?>">Proyectos cancelados</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('proyectos_actuales')->term_id); ?>">Proyectos actuales</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('proyectos_en_marcha')->term_id); ?>">Proyectos en marcha</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('proyectos_estudio')->term_id); ?>">Proyectos en estudio</a></li>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>🏙️ Desarrollo ciudades</h4>
                        <ul>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('sevilla')->term_id); ?>">Sevilla</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('madrid')->term_id); ?>">Madrid</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('barcelona')->term_id); ?>">Barcelona</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('valencia')->term_id); ?>">Valencia</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('bilbao')->term_id); ?>">Bilbao</a></li>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('a_coruna')->term_id); ?>">A Coruña</a></li>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>🚉 Estaciones de tren</h4>
                        <ul>
                            <li><a href="<?php echo get_category_link(get_category_by_slug('estaciones')->term_id); ?>">Mapa por provincias</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="latest-posts">
                <h3>Últimas Noticias</h3>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article class="post">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="post-meta">📅 <?php the_time('j \d\e F \d\e Y'); ?> — 👤 <?php the_author(); ?></div>
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } ?>
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

        <!-- Comments Section -->
        <section class="comments-section">
            <h3>Comentarios</h3>
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
        </section>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>

