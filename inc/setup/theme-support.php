<?php

/* ========================================
   THEME SUPPORT
======================================== */

function webjti_theme_support() {

  add_theme_support('title-tag');

  add_theme_support('post-thumbnails');

  add_theme_support('html5', [
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ]);

  add_theme_support('custom-logo');

  add_theme_support('customize-selective-refresh-widgets');

}

add_action(
  'after_setup_theme',
  'webjti_theme_support'
);

// Hide Admin Bar on the front-end
add_filter('show_admin_bar', '__return_false');

function webjti_register_custom_page_templates($post_templates, $wp_theme, $post, $post_type) {
    if ($post_type === 'page') {
        $post_templates['templates/pages/history-page.php'] = 'Sejarah Kami';
        $post_templates['templates/pages/vision-mission-page.php'] = 'Visi Misi Tujuan';
        $post_templates['templates/pages/organizational-page.php'] = 'Struktur Organisasi';
        $post_templates['templates/pages/lecturer-page.php'] = 'Tenaga Pengajar';
        $post_templates['templates/pages/staff-page.php'] = 'Tenaga Kependidikan';
        $post_templates['templates/pages/information-page.php'] = 'Informasi';
        $post_templates['templates/pages/achievement-page.php'] = 'Prestasi';
    }
    return $post_templates;
}
add_filter('theme_page_templates', 'webjti_register_custom_page_templates', 10, 4);

/**
 * Disable archives for Lecturer and Kependidikan custom post types to resolve slug conflicts with static Pages.
 */
function webjti_disable_cpt_archives($args, $post_type) {
    if (in_array($post_type, ['lecturer', 'kependidikan'], true)) {
        $args['has_archive'] = false;
    }
    return $args;
}
add_filter('register_post_type_args', 'webjti_disable_cpt_archives', 99, 2);