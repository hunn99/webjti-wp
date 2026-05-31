<?php
/**
 * AJAX Handlers
 *
 * @package WebJTI_Theme
 */

/* =========================================================
   INFORMATION FILTER AJAX
========================================================= */

add_action(
    'wp_ajax_webjti_filter_information',
    'webjti_filter_information'
);

add_action(
    'wp_ajax_nopriv_webjti_filter_information',
    'webjti_filter_information'
);

function webjti_filter_information()
{
    $type = sanitize_text_field(
        $_POST['type'] ?? 'berita'
    );

    $search = sanitize_text_field(
        $_POST['search'] ?? ''
    );

    $paged = intval(
        $_POST['paged'] ?? 1
    );

    $query = new WP_Query([
        'post_type'      => $type === 'semua'
            ? ['berita', 'pengumuman', 'agenda']
            : $type,
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => $paged,
        's'              => $search,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    ob_start();

    if ($query->have_posts()) :

        while ($query->have_posts()) :
            $query->the_post();

            get_template_part(
                'template-parts/components/cards/information-card'
            );

        endwhile;

    else :

        echo '
        <div class="empty-state">
            Tidak ada informasi ditemukan.
        </div>';

    endif;

    wp_reset_postdata();

    wp_send_json_success([
        'html' => ob_get_clean(),
        'max_pages' => $query->max_num_pages,
    ]);
}