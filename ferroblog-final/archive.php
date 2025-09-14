<?php get_header(); ?>
    <div class="content-left">
        <section class="section">
            <h2><?php the_archive_title(); ?></h2>
            <?php if (get_the_archive_description()) : ?>
                <p class="section-intro"><?php the_archive_description(); ?></p>
            <?php endif; ?>
        </section>
        <div class="latest-posts">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="post-meta">📅 <?php the_time('j \d\e F \d\e Y'); ?> — 👤 <?php the_author(); ?></div>
                    <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                </article>
            <?php endwhile; else: ?>
                <div class="no-content"><h3>No hay contenido disponible.</h3></div>
            <?php endif; ?>
            <div class="navigation-links">
                <div class="nav-previous"><?php next_posts_link('⬅ Anteriores'); ?></div>
                <div class="nav-next"><?php previous_posts_link('Más recientes ➡'); ?></div>
            </div>
        </div>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>


