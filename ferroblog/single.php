<?php get_header(); ?>
    <div class="content-left">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="posted-on">
                            📅 <?php the_time('j \d\e F \d\e Y'); ?>
                        </span>
                        <span class="byline">
                            👤 Por <?php the_author(); ?>
                        </span>
                        <?php if (has_category()) : ?>
                            <span class="cat-links">
                                🏷️ <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">Páginas: ',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer">
                    <?php if (has_tag()) : ?>
                        <div class="tag-links">
                            <strong>Etiquetas:</strong> <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>

            <!-- Comments Section -->
            <section class="comments-section">
                <h3>Comentarios</h3>
                <?php
                // Si los comentarios están abiertos o tenemos comentarios, mostrar la sección
                if (comments_open() || get_comments_number()) :
                    comments_template();
                else :
                    echo '<p>Los comentarios están cerrados para esta entrada.</p>';
                endif;
                ?>
            </section>

        <?php endwhile; ?>
        <?php else : ?>
            <p>No se encontró la entrada solicitada.</p>
        <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>