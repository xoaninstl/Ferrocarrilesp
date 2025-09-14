<?php
/**
 * Template Name: Plantilla de Noticias
 *
 * Esta es la plantilla para mostrar una página con un diseño específico para noticias.
 * Basada en la plantilla-noticia.html original.
 */

get_header(); ?>

<div class="content-left">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a> > 
        <a href="<?php echo esc_url(get_permalink()); ?>">Noticias</a> > 
        <span><?php the_title(); ?></span>
    </div>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="noticia-article">
            <!-- Título -->
            <header class="article-header">
                <h1 class="article-title"><?php the_title(); ?></h1>
                <div class="article-meta">
                    <span class="article-date">📅 <?php echo get_the_date('j \d\e F \d\e Y'); ?></span>
                    <span class="article-author">👤 Por <?php the_author(); ?></span>
                </div>
            </header>

            <!-- Descripción corta -->
            <?php if (get_the_excerpt()) : ?>
                <div class="article-description">
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                </div>
            <?php endif; ?>

            <!-- Imagen principal -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="article-image">
                    <?php the_post_thumbnail('large', ['class' => 'main-image', 'alt' => get_the_title()]); ?>
                    <?php if (get_the_post_thumbnail_caption()) : ?>
                        <p class="image-caption"><?php echo esc_html(get_the_post_thumbnail_caption()); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Contenido principal -->
            <div class="article-content">
                <?php the_content(); ?>
            </div>

            <!-- Información adicional -->
            <div class="article-info">
                <div class="article-tags">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                        echo '<h4>Etiquetas:</h4>';
                        echo '<div class="tags-list">';
                        foreach ($tags as $tag) {
                            echo '<span class="tag">' . esc_html($tag->name) . '</span>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                
                <div class="article-categories">
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                        echo '<h4>Categorías:</h4>';
                        echo '<div class="categories-list">';
                        foreach ($categories as $category) {
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Copyright -->
            <div class="article-copyright">
                <p><strong>© <?php echo date('Y'); ?> Blog Ferrocarril Esp.</strong> Todos los derechos reservados.</p>
            </div>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
