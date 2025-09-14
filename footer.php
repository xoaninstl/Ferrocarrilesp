            </div>
        </div>
    </main>
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
                <p>&copy; <?php echo date('Y'); ?> Blog Ferrocarril Esp. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script>
    <?php
    $events = [];
    $args = [
        'post_type' => 'ferroblog_event',
        'posts_per_page' => -1,
    ];
    $event_query = new WP_Query($args);
    if ($event_query->have_posts()) {
        while ($event_query->have_posts()) {
            $event_query->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            if ($event_date) {
                $events[] = [
                    'title' => get_the_title(),
                    'date'  => $event_date,
                    'description' => get_the_excerpt(),
                ];
            }
        }
    }
    wp_reset_postdata();
    ?>
    const ferroblog_events = <?php echo json_encode($events); ?>;
    </script>
    
    <?php wp_footer(); ?>
</body>
</html>

