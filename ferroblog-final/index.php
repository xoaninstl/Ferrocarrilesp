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
                            <?php $cat = get_category_by_slug('ancho_iberico'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Ancho ibérico</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('ancho_metrico'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Ancho métrico</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('ancho_internacional'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Ancho internacional</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('lineas_cerradas'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Líneas Cerradas</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>📋 Proyectos</h4>
                        <ul>
                            <?php $cat = get_category_by_slug('proyectos_cancelados'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Proyectos cancelados</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('proyectos_actuales'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Proyectos actuales</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('proyectos_en_marcha'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Proyectos en marcha</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('proyectos_estudio'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Proyectos en estudio</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>🏙️ Desarrollo ciudades</h4>
                        <ul>
                            <?php $cat = get_category_by_slug('sevilla'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Sevilla</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('madrid'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Madrid</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('barcelona'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Barcelona</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('valencia'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Valencia</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('bilbao'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Bilbao</a></li>
                            <?php endif; ?>
                            <?php $cat = get_category_by_slug('a_coruna'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">A Coruña</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="seccion-card">
                        <h4>🚉 Estaciones de tren</h4>
                        <ul>
                            <?php $cat = get_category_by_slug('estaciones'); if ($cat) : ?>
                                <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">Mapa por provincias</a></li>
                            <?php endif; ?>
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
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>

