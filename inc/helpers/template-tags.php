<?php

/* ========================================
   GET BREADCRUMB ITEMS
======================================== */

function webjti_get_breadcrumb_items() {

  $post_type =
    get_post_type();

  // Force CPT information routing for default fallback views (where get_post_type() resolves to 'page')
  if (isset($_GET['default_info']) && !empty($_GET['default_info'])) {
    $post_type = 'information';
  }

  if (isset($_GET['default_lecturer']) && !empty($_GET['default_lecturer'])) {
    $post_type = 'lecturer';
  }

  if (isset($_GET['default_achievement']) && !empty($_GET['default_achievement'])) {
    $post_type = 'achievement';
  }

  if ($post_type === 'information') {
    $category_value = function_exists('get_field') ? get_field('category') : '';
    if (!$category_value && isset($_GET['default_info'])) {
      $default_id = sanitize_text_field($_GET['default_info']);
      if ($default_id === 'default-2') {
        $category_value = 'announcement';
      } elseif ($default_id === 'default-3') {
        $category_value = 'event';
      } elseif ($default_id === 'default-4') {
        $category_value = 'news';
      } elseif ($default_id === 'default-5') {
        $category_value = 'news';
      } else {
        $category_value = 'news';
      }
    }
    $post_type = $category_value;
  }

  // Normalize post_type to match standard trail keys (handling lowercase/uppercase English & Indonesian keys)
  $post_type = strtolower($post_type);
  if (in_array($post_type, ['news', 'berita', 'information'], true)) {
    $post_type = 'news';
  } elseif (in_array($post_type, ['announcement', 'pengumuman'], true)) {
    $post_type = 'announcement';
  } elseif (in_array($post_type, ['event', 'agenda'], true)) {
    $post_type = 'event';
  }

  $prestasi_page =
    get_pages([
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'page-templates/page-prestasi.php',
      'number'     => 1,
    ]);

  $prestasi_url =
    !empty($prestasi_page)
      ? get_permalink($prestasi_page[0]->ID)
      : home_url('/student-affairs/achievement');

  $info_page =
    get_pages([
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'page-templates/page-informasi.php',
      'number'     => 1,
    ]);

  $info_url =
    !empty($info_page)
      ? get_permalink($info_page[0]->ID)
      : home_url('/information');

  $history_page =
    get_pages([
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'templates/pages/history-page.php',
      'number'     => 1,
    ]);

  $history_url =
    !empty($history_page)
      ? get_permalink($history_page[0]->ID)
      : home_url('/about-us/history');

  $lecturer_page =
    get_pages([
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'templates/pages/lecturer-page.php',
      'number'     => 1,
    ]);

  $lecturer_url =
    !empty($lecturer_page)
      ? get_permalink($lecturer_page[0]->ID)
      : home_url('/about-us/lecturer');

  $staff_page =
    get_pages([
      'meta_key'   => '_wp_page_template',
      'meta_value' => 'templates/pages/staff-page.php',
      'number'     => 1,
    ]);

  $staff_url =
    !empty($staff_page)
      ? get_permalink($staff_page[0]->ID)
      : home_url('/about-us/staff');

  $trails = [

    'achievement' => [
      [
        'label' => 'Kemahasiswaan',
        'url'   => $prestasi_url,
      ],
      [
        'label' => 'Prestasi',
        'url'   => $prestasi_url,
      ],
    ],

    'news' => [
      [
        'label' => 'Informasi',
        'url'   => $info_url,
      ],
      [
        'label' => 'Berita',
        'url'   => $info_url . '?info_type=berita',
      ],
    ],

    'announcement' => [
      [
        'label' => 'Informasi',
        'url'   => $info_url,
      ],
      [
        'label' => 'Pengumuman',
        'url'   => $info_url . '?info_type=pengumuman',
      ],
    ],

    'event' => [
      [
        'label' => 'Informasi',
        'url'   => $info_url,
      ],
      [
        'label' => 'Agenda',
        'url'   => $info_url . '?info_type=agenda',
      ],
    ],

    'lecturer' => [
      [
        'label' => 'Tentang Kami',
        'url'   => $history_url,
      ],
      [
        'label' => 'Tenaga Pengajar',
        'url'   => $lecturer_url,
      ],
    ],

    'dosen' => [
      [
        'label' => 'Tentang Kami',
        'url'   => $history_url,
      ],
      [
        'label' => 'Tenaga Pengajar',
        'url'   => $lecturer_url,
      ],
    ],

    'staff' => [
      [
        'label' => 'Tentang Kami',
        'url'   => $history_url,
      ],
      [
        'label' => 'Tenaga Kependidikan',
        'url'   => $staff_url,
      ],
    ],

    'kependidikan' => [
      [
        'label' => 'Tentang Kami',
        'url'   => $history_url,
      ],
      [
        'label' => 'Tenaga Kependidikan',
        'url'   => $staff_url,
      ],
    ],

  ];

  return [
    'trail'   => $trails[$post_type] ?? [],
    'current' => get_the_title(),
  ];

}

/* ========================================
   GET PAGE HEADER DATA
======================================== */

function webjti_get_page_header_data() {

  $page_id =
    get_queried_object_id();

  $display_title = '';

  if ( is_post_type_archive() ) {
    $post_type = get_query_var('post_type');
    if ( is_array($post_type) ) {
      $post_type = reset($post_type);
    }
    $post_type_obj = get_post_type_object($post_type);
    if (in_array($post_type, ['lecturer', 'dosen'], true)) {
      $display_title = __('Tenaga Pengajar', 'webjti');
    } elseif (in_array($post_type, ['kependidikan', 'staff'], true)) {
      $display_title = __('Tenaga Kependidikan', 'webjti');
    } elseif ($post_type_obj) {
      $display_title = $post_type_obj->labels->name;
    }
  } elseif ( is_home() && ! is_front_page() ) {
    $display_title = get_the_title( get_option( 'page_for_posts' ) );
  } elseif ( is_search() ) {
    $display_title = sprintf( __('Hasil Pencarian: &ldquo;%s&rdquo;', 'webjti'), get_search_query() );
  } else {
    $display_title = get_the_title($page_id);
  }

  $menu_tag = '';

  if ( is_search() ) {
    $menu_tag = __('Pencarian', 'webjti');
  }

  $request_uri =
    $_SERVER['REQUEST_URI'] ?? '';

  $current_slug =
    trim(
      parse_url(
        $request_uri,
        PHP_URL_PATH
      ),
      '/'
    );

  $is_in_section =
    function ($slugs) use ($current_slug) {

      foreach ((array) $slugs as $slug) {

        $slug = trim($slug, '/');

        if (
          $current_slug === $slug ||
          strpos(
            $current_slug,
            $slug . '/'
          ) === 0
        ) {
          return true;
        }

      }

      return false;

    };

  /* ========================================
     BACKGROUND IMAGE
  ======================================== */

  $bg_image_url =
    get_theme_mod(
      'jti_page_header_bg',
      ''
    );

  if (
    '' === $bg_image_url &&
    $page_id &&
    has_post_thumbnail($page_id)
  ) {

    $bg_image_url =
      get_the_post_thumbnail_url(
        $page_id,
        'full'
      );

  }

  if ('' === $bg_image_url) {

    $bg_image_url =
      get_template_directory_uri()
      . '/assets/images/placeholders/page-header.jpg';

  }

  /* ========================================
     SECTION DETECTION
  ======================================== */

  // Try dynamic menu parent tag detection first
  $dynamic_menu_tag = '';
  $menu_locations = get_nav_menu_locations();
  $menu_id = $menu_locations['main_menu'] ?? 0;
  if ($menu_id && $page_id) {
    $menu_items = wp_get_nav_menu_items($menu_id);
    if (!empty($menu_items)) {
      $current_item = null;
      foreach ($menu_items as $item) {
        if ((int)$item->object_id === (int)$page_id && $item->object === 'page') {
          $current_item = $item;
          break;
        }
      }
      if ($current_item) {
        $parent_id = $current_item->menu_item_parent;
        while ($parent_id) {
          $parent_item = null;
          foreach ($menu_items as $item) {
            if ((int)$item->ID === (int)$parent_id) {
              $parent_item = $item;
              break;
            }
          }
          if ($parent_item) {
            if ($parent_item->menu_item_parent) {
              $parent_id = $parent_item->menu_item_parent;
            } else {
              $dynamic_menu_tag = $parent_item->title;
              break;
            }
          } else {
            break;
          }
        }
        if (!$dynamic_menu_tag && !$current_item->menu_item_parent) {
          $dynamic_menu_tag = $current_item->title;
        }
      }
    }
  }

  if (!empty($dynamic_menu_tag)) {
    $menu_tag = $dynamic_menu_tag;
  } else {
    if (
      $is_in_section([
        'about-us',
        'tentang-kami',
        'sejarah',
        'history',
        'visi-misi-tujuan',
        'vision-mission',
        'struktur-organisasi',
        'organization-structure',
        'tenaga-pengajar',
        'lecturer',
        'tenaga-kependidikan',
        'staff',
      ])
    ) {

      $menu_tag =
        __('Tentang Kami', 'webjti');

    }

    elseif (
      $is_in_section([
        'akademik',
        'prodi',
        'study_program',
        'kelas-internasional',
      ])
    ) {

      $menu_tag =
        __('Akademik', 'webjti');

    }

    elseif (
      $is_in_section([
        'kemahasiswaan',
        'student-affairs',
        'prestasi',
        'achievement',
        'beasiswa',
      ])
    ) {

      $menu_tag =
        __('Kemahasiswaan', 'webjti');

    }

    elseif (
      $is_in_section([
        'informasi',
        'information',
      ])
    ) {

      $menu_tag =
        __('Informasi', 'webjti');

      if ($current_slug === 'informasi' || $current_slug === 'information') {

        $display_title =
          __('Berita, Pengumuman, dan Agenda', 'webjti');

      }

    }
  }

  /* ========================================
     FINAL FALLBACK
  ======================================== */

  if ('' === $menu_tag) {

    $ancestors =
      get_post_ancestors($page_id);

    if (!empty($ancestors)) {

      $top_ancestor_id =
        end($ancestors);

      $menu_tag =
        get_the_title(
          $top_ancestor_id
        );

    }

    else {

      $menu_tag =
        get_the_title($page_id);

    }

  }

  return [

    'menu_tag'     => $menu_tag,

    'display_title' => $display_title,

    'bg_image_url' => $bg_image_url,

  ];

}