<?php

/* ========================================
   FEATURED NEWS — SINGLE SELECTION
   Otomatis menonaktifkan featured_news
   di post lain saat satu post disimpan
   dengan featured_news = 1 (true)
======================================== */

add_action('acf/save_post', function($post_id) {

  // Hanya berlaku untuk post type 'information'
  if (get_post_type($post_id) !== 'information') {
    return;
  }

  // Cek apakah post ini di-set sebagai featured
  $is_featured = get_field('featured_news', $post_id);

  if (!$is_featured) {
    return;
  }

  // Cari semua post information lain yang juga featured
  $others = new WP_Query([
    'post_type'      => 'information',
    'posts_per_page' => -1,
    'post_status'    => 'any',
    'post__not_in'   => [$post_id],
    'meta_query'     => [
      [
        'key'   => 'featured_news',
        'value' => '1',
      ],
    ],
  ]);

  if ($others->have_posts()) {
    while ($others->have_posts()) {
      $others->the_post();
      // Nonaktifkan featured_news di post lain
      update_field('featured_news', false, get_the_ID());
    }
    wp_reset_postdata();
  }

}, 20);

/* ========================================
   DEFAULT INFO INTERCEPTOR & SMART SEARCH REDIRECT
   Mengalihkan pencarian dengan 1 hasil langsung ke halaman terkait,
   serta mengadopsi rute fallback simulasi kustom.
======================================== */

add_action('template_redirect', function() {

  // Smart Search Redirect
  if ( is_search() ) {
    global $wp_query;
    if ( isset( $wp_query->posts ) && count( $wp_query->posts ) === 1 ) {
      $single_post = $wp_query->posts[0];
      wp_safe_redirect( get_permalink( $single_post->ID ) );
      exit;
    }
  }

  if (isset($_GET['default_info']) && !empty($_GET['default_info'])) {
    include get_template_directory() . '/templates/singles/single-information.php';
    exit;
  }

  if (isset($_GET['default_lecturer']) && !empty($_GET['default_lecturer'])) {
    include get_template_directory() . '/templates/singles/single-lecturer.php';
    exit;
  }

  if (isset($_GET['default_achievement']) && !empty($_GET['default_achievement'])) {
    include get_template_directory() . '/templates/singles/single-achievement.php';
    exit;
  }

});

/* ========================================
   INCLUDE CUSTOM POST TYPES IN SEARCH QUERY
   Memastikan kueri pencarian utama menggeledah data CPT kustom
======================================== */
add_action( 'pre_get_posts', function( $query ) {
  if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
    // Only search in these specific post types
    $query->set( 'post_type', [ 'post', 'page', 'information', 'lecturer', 'staff', 'achievement' ] );
  }
});

/* ========================================
   AJAX FILTER INFORMASI
======================================== */

add_action('wp_ajax_jti_filter_informasi', 'jti_ajax_filter_informasi');
add_action('wp_ajax_nopriv_jti_filter_informasi', 'jti_ajax_filter_informasi');

function jti_ajax_filter_informasi() {
  $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'all';
  $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
  $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
  
  $posts_per_page = 6;
  $data = webjti_get_filtered_information($type, $search, $paged, $posts_per_page);
  
  ob_start();
  if (!empty($data['posts'])) {
    foreach ($data['posts'] as $item) {
      $info = [
        'url'          => $item['permalink'] ?? $item['url'] ?? '',
        'image'        => $item['image'] ?? '',
        'title'        => $item['title'] ?? '',
        'category'     => $item['category'] ?? $item['tag'] ?? '',
        'date'         => $item['date'] ?? '',
        'reading_time' => $item['reading_time'] ?? '',
        'excerpt'      => $item['excerpt'] ?? '',
      ];
      get_template_part(
        'template-parts/cards/information-card',
        null,
        [
          'info' => $info,
        ]
      );
    }
  } else {
    ?>
    <div class="information-no-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 24px; width: 100%;">
      <i class="ph ph-newspaper" style="font-size: 64px; color: var(--neutral-04); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;"></i>
      <h3 style="color: var(--neutral-09); margin-bottom: 8px; font-weight: 500; font-size: 20px;">Tidak Ada Informasi</h3>
      <p style="color: var(--neutral-06); font-size: 16px;">Maaf, tidak ada berita, pengumuman, atau agenda yang sesuai dengan kriteria filter atau pencarian Anda.</p>
    </div>
    <?php
  }
  $content_html = ob_get_clean();
  
  $pagination_html = '';
  if ($data['max_pages'] > 1) {
    $pagination_links = paginate_links([
      'total'     => $data['max_pages'],
      'current'   => $paged,
      'prev_next' => true,
      'prev_text' => '<i class="ph ph-arrow-left"></i> Sebelumnya',
      'next_text' => 'Selanjutnya <i class="ph ph-arrow-right"></i>',
      'type'      => 'plain',
    ]);
    if ($pagination_links) {
      $pagination_html = '<div class="pagination-container">' . $pagination_links . '</div>';
    }
  }
  
  wp_send_json_success([
    'content'    => $content_html,
    'pagination' => $pagination_html,
  ]);
}

/* ========================================
   SINGLE TEMPLATE ROUTING FILTER
   Automatically routes templates in templates/singles/
======================================== */
add_filter('single_template', function($template) {
  global $post;
  if ($post) {
    $post_type = $post->post_type;
    $custom_template = get_template_directory() . '/templates/singles/single-' . $post_type . '.php';
    if (file_exists($custom_template)) {
      return $custom_template;
    }
    // Fallback for prestasi CPT mapped to single-achievement.php
    if ($post_type === 'achievement') {
      $achievement_template = get_template_directory() . '/templates/singles/single-achievement.php';
      if (file_exists($achievement_template)) {
        return $achievement_template;
      }
    }
  }
  return $template;
});


