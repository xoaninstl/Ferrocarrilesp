<?php get_header(); ?>
    <div class="content-left">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="noticia-article">
            <header class="article-header">
                <h1 class="article-title"><?php the_title(); ?></h1>
                <div class="article-meta">
                    <span class="article-date">📅 <?php the_time('j \d\e F \d\e Y'); ?></span>
                    <span class="article-author">👤 <?php the_author(); ?></span>
                </div>
            </header>

            <div class="article-description">
                <?php if (has_excerpt()) : ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>

            <div class="article-image">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('large', ['class' => 'main-image']);
                } ?>
            </div>

            <div class="article-content">
                <?php the_content(); ?>
            </div>

            <div class="article-copyright">
                <p><strong>© <?php echo date('Y'); ?> Blog Ferrocarril Esp.</strong> Todos los derechos reservados.</p>
            </div>

            <div class="article-categories">
                <h3>Categorías:</h3>
                <div class="categories-list">
                    <?php the_category(' '); ?>
                </div>
            </div>

            <div class="author-box-container">
                <div class="author-box">
                    <h3>Sobre el autor</h3>
                    <?php echo ferrocarril_display_author_profile(get_the_author_meta('ID')); ?>
                </div>
            </div>
        </article>

        <section class="comments-section">
            <?php
            // Si los comentarios están abiertos o hay al menos un comentario, se carga la plantilla de comentarios.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </section>
        
        <?php endwhile; endif; ?>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>

