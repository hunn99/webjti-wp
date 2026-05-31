<?php
/**
 * Sidebar Navigation Component
 *
 * @package WebJTI_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/*
========================================
DETECT CURRENT SECTION
========================================
*/

$request_uri =
    $_SERVER['REQUEST_URI'] ?? '';

$uri_path =
    trim(
        parse_url($request_uri, PHP_URL_PATH),
        '/'
    );

$menu_location = '';

if (
    strpos($uri_path, 'about-us') === 0 ||
    strpos($uri_path, 'tentang-kami') === 0
) {

    $menu_location =
        'sidebar-about-us';

} elseif (
    strpos($uri_path, 'akademik') === 0
) {

    $menu_location =
        'sidebar-akademik';

} elseif (
    strpos($uri_path, 'student-affairs') === 0 ||
    strpos($uri_path, 'kemahasiswaan') === 0
) {

    $menu_location =
        'sidebar-student-affairs';

} elseif (
    strpos($uri_path, 'penelitian') === 0
) {

    $menu_location =
        'sidebar-penelitian';
}

/*
========================================
STOP IF NO SECTION
========================================
*/

if (!$menu_location) {
    return;
}

?>

<aside class="sidebar sidebar-submenu">

    <div class="sidebar-inner">

        <?php

        /*
        ========================================
        USE WP MENU IF EXISTS
        ========================================
        */

        if (
            has_nav_menu($menu_location)
        ) :

            wp_nav_menu([
                'theme_location' => $menu_location,
                'container'      => false,
                'menu_class'     => 'sidebar-menu-list',
            ]);

        else :

            /*
            ========================================
            FALLBACK MENU
            ========================================
            */

            get_template_part(
                'template-parts/components/sidebar/sidebar-fallback',
                null,
                [
                    'menu_location' => $menu_location,
                ]
            );

        endif;

        ?>

    </div>

</aside>