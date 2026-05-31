<?php
/**
 * Register Theme Menus
 *
 * @package WebJTI_Theme
 */

function webjti_register_menus()
{
    register_nav_menus([

        'main_menu' => __(
            'Main Menu',
            'webjti-theme'
        ),

        'sidebar_menu' => __(
            'Sidebar Menu',
            'webjti-theme'
        ),

        'footer_menu' => __(
            'Footer Menu',
            'webjti-theme'
        ),

        'footer_programs' => __(
            'Footer - Program Studi',
            'webjti-theme'
        ),

        'footer_academic' => __(
            'Footer - Akademik',
            'webjti-theme'
        ),

        'footer_research' => __(
            'Footer - Penelitian',
            'webjti-theme'
        ),

        'mobile_menu' => __(
            'Mobile Menu',
            'webjti-theme'
        ),

        'sidebar-about-us' =>
            __('Sidebar Tentang Kami', 'webjti-theme'),

        'sidebar-akademik' =>
            __('Sidebar Akademik', 'webjti-theme'),

        'sidebar-student-affairs' =>
            __('Sidebar Kemahasiswaan', 'webjti-theme'),

        'sidebar-penelitian' =>
            __('Sidebar Penelitian', 'webjti-theme'),

    ]);
}

add_action(
    'after_setup_theme',
    'webjti_register_menus'
);