<?php
/**
 * The template for displaying comments
 */

// Si la entrada está protegida por contraseña, no mostrar comentarios
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number == 1) {
                echo '1 Comentario';
            } else {
                echo $comments_number . ' Comentarios';
            }
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback'   => 'ferroblog_comment_callback',
            ));
            ?>
        </ol>

        <?php
        // Navegación de comentarios
        the_comments_navigation(array(
            'prev_text' => '← Comentarios anteriores',
            'next_text' => 'Comentarios siguientes →',
        ));
        ?>

    <?php endif; ?>

    <?php
    // Si los comentarios están cerrados pero hay comentarios, mostrar mensaje
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
        <p class="no-comments">Los comentarios están cerrados.</p>
    <?php endif; ?>

    <?php
    // Formulario de comentarios
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $comment_form_args = array(
        'title_reply'          => 'Deja un comentario',
        'title_reply_to'       => 'Deja una respuesta a %s',
        'cancel_reply_link'    => 'Cancelar respuesta',
        'label_submit'         => 'Publicar Comentario',
        'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Escribe tu comentario aquí..."></textarea></div>',
        'must_log_in'          => '<p class="must-log-in">Debes <a href="' . wp_login_url(apply_filters('the_permalink', get_permalink())) . '">iniciar sesión</a> para publicar un comentario.</p>',
        'logged_in_as'         => '<p class="logged-in-as">Conectado como <a href="' . admin_url('profile.php') . '">' . $user_identity . '</a>. <a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink())) . '" title="Cerrar sesión">Cerrar sesión</a></p>',
        'comment_notes_before' => '<p class="comment-notes">Tu dirección de correo electrónico no será publicada. Los campos obligatorios están marcados con <span class="required">*</span></p>',
        'comment_notes_after'  => '',
        'fields'               => array(
            'author' => '<div class="form-row"><div class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' placeholder="Tu nombre' . ($req ? ' *' : '') . '" /></div>',
            'email'  => '<div class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' placeholder="Tu correo electrónico' . ($req ? ' *' : '') . '" /></div></div>',
            'url'    => '<div class="comment-form-url"><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" placeholder="Tu sitio web (opcional)" /></div>',
        ),
        'class_form'           => 'comment-form',
        'class_submit'         => 'btn-comment',
    );

    comment_form($comment_form_args);
    ?>
</div>

<?php
// Función personalizada para mostrar comentarios
function ferroblog_comment_callback($comment, $args, $depth) {
    $tag = ($args['style'] === 'div') ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? 'parent' : '', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                    if ($args['avatar_size'] != 0) {
                        echo get_avatar($comment, $args['avatar_size']);
                    }
                    ?>
                    <div class="comment-metadata">
                        <cite class="fn"><?php comment_author_link($comment); ?></cite>
                        <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php
                                printf(
                                    esc_html__('%1$s a las %2$s', 'ferroblog'),
                                    get_comment_date('', $comment),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                        <?php edit_comment_link(esc_html__('Editar', 'ferroblog'), '<span class="edit-link">', '</span>'); ?>
                    </div>
                </div>

                <?php if ('0' == $comment->comment_approved) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e('Tu comentario está esperando moderación.', 'ferroblog'); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php
            comment_reply_link(array_merge($args, array(
                'add_below' => 'div-comment',
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
                'before'    => '<div class="reply">',
                'after'     => '</div>',
            )));
            ?>
        </article>
    <?php
}
?>
