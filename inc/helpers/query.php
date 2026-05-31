<?php

/* ========================================
   GET ACHIEVEMENTS
======================================== */

function webjti_get_achievements($args = []) {

  $default_args = [
    'post_type'      => 'achievement',
    'posts_per_page' => 6,
    'post_status'    => 'publish'
  ];

  $query_args =
    wp_parse_args(
      $args,
      $default_args
    );

  return new WP_Query(
    $query_args
  );

}

/* ========================================
   GET LECTURERS
======================================== */

// function webjti_get_lecturers($args = []) {

//   $default_args = [
//     'post_type'      => 'lecturer',
//     'posts_per_page' => -1,
//     'post_status'    => 'publish'
//   ];

//   $query_args =
//     wp_parse_args(
//       $args,
//       $default_args
//     );

//   return new WP_Query(
//     $query_args
//   );

// }

/* ========================================
   GET HERO SLIDES
======================================== */

function webjti_get_hero_slides() {
  $post_types = [
    'information',
  ];

  $posts_per_page = 4;

  $query_args = [
    'post_type' => $post_types,
    'posts_per_page' => $posts_per_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
  ];

  $query_args =
    apply_filters(
      'webjti_hero_query_args',
      $query_args
    );

  $query = new WP_Query($query_args);

  $slides = [];

  while ($query->have_posts()) {

    $query->the_post();

    $post_type =
      get_post_type();

    $post_type_obj =
      get_post_type_object($post_type);

    $category_value =
      function_exists('get_field')
        ? get_field('category')
        : '';

    $category_map = [
      'news' => 'Berita',
      'announcement' => 'Pengumuman',
      'event' => 'Agenda',
    ];

    $category_label = $category_map[$category_value] ?? 'Berita';

    $slides[] = [

      'id' =>
        get_the_ID(),

      'title' =>
        get_the_title(),

      'permalink' =>
        get_permalink(),

      'category' =>
        $category_label,

      'image' =>
        has_post_thumbnail()
          ? get_the_post_thumbnail_url(
              get_the_ID(),
              'full'
            )
          : get_template_directory_uri()
              . '/assets/images/placeholders/hero-placeholder.jpg',

      'date' =>
        date_i18n('j F Y', get_post_time('U')),

    ];

  }

  wp_reset_postdata();

  if (count($slides) < $posts_per_page) {

    $remaining =
      $posts_per_page - count($slides);

    $exclude_ids =
      wp_list_pluck($slides, 'id');

    $default_query =
      new WP_Query([
        'post_type' => $post_types,
        'posts_per_page' => $remaining,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'meta_key' => 'featured_news',
        'meta_value' => 1,
        'post__not_in' => $exclude_ids,
      ]);

    while ($default_query->have_posts()) {

      $default_query->the_post();

      $post_type =
        get_post_type();

      $post_type_obj =
        get_post_type_object($post_type);

      $category_value =
        function_exists('get_field')
          ? get_field('category')
          : '';

      $category_map = [
        'news' => 'Berita',
        'announcement' => 'Pengumuman',
        'event' => 'Agenda',
      ];

      $category_label = $category_map[$category_value] ?? 'Berita';

      $slides[] = [

        'id' =>
          get_the_ID(),

        'title' =>
          get_the_title(),

        'permalink' =>
          get_permalink(),

        'category' =>
          $category_label,

        'image' =>
          has_post_thumbnail()
            ? get_the_post_thumbnail_url(
                get_the_ID(),
                'full'
              )
            : get_template_directory_uri()
                . '/assets/images/placeholders/hero-placeholder.jpg',

        'date' =>
          date_i18n('j F Y', get_post_time('U')),

      ];

    }

    wp_reset_postdata();

  }

  if (count($slides) < $posts_per_page && !get_theme_mod('jti_disable_default_posts')) {

    $remaining =
      $posts_per_page - count($slides);

    $default_slides = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.png',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.png',
        'date'      => date_i18n('j F Y'),
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.png',
        'date'      => date_i18n('j F Y'),
      ],
    ];

    $default_to_add =
      array_slice(
        $default_slides,
        0,
        $remaining
      );

    $slides =
      array_merge(
        $slides,
        $default_to_add
      );

  }

  return $slides;

}

/* ========================================
   GET INFORMATION POSTS
======================================== */

function webjti_get_information_posts() {

  $spotlight_query =
    new WP_Query([

      'post_type' => [
        'information',
      ],

      'posts_per_page' => 1,

      'meta_query' => [
        [
          'key'   => 'featured_news',
          'value' => '1',
        ],
      ],

      'orderby' => 'date',

      'order' => 'DESC',

      'post_status' =>
        'publish',

    ]);

  $spotlight = null;
  $spotlight_id = 0;

  if ($spotlight_query->have_posts()) {

    $spotlight_query->the_post();

    $spotlight =
      webjti_format_news_post();

    $spotlight_id =
      get_the_ID();

  }

  wp_reset_postdata();

  $list_query =
    new WP_Query([

      'post_type' => [
        'information',
      ],

      'posts_per_page' =>
        $spotlight ? 4 : 5,

      'post__not_in' =>
        $spotlight_id
          ? [$spotlight_id]
          : [],

      'orderby' => 'date',

      'order' => 'DESC',

      'post_status' =>
        'publish',

    ]);

  $list_posts = [];

  while ($list_query->have_posts()) {

    $list_query->the_post();

    if (!$spotlight) {

      $spotlight =
        webjti_format_news_post();

      $spotlight_id =
        get_the_ID();

    }

    else {

      $list_posts[] =
        webjti_format_news_post();

    }

  }

  wp_reset_postdata();

  wp_reset_postdata();

  // Combine spotlight and list posts
  $all_posts = [];
  if ($spotlight) {
    $all_posts[] = $spotlight;
  }
  foreach ($list_posts as $p) {
    $all_posts[] = $p;
  }

  // Pad with defaults if less than 5
  if (count($all_posts) < 5 && !get_theme_mod('jti_disable_default_posts')) {
    $remaining = 5 - count($all_posts);
    $default_slides = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '5 min',
        'excerpt'   => 'Selamat datang di website resmi Jurusan Teknologi Informasi Politeknik Negeri Malang.'
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.png',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '3 min',
        'excerpt'   => 'Informasi mengenai pelaksanaan registrasi ulang mahasiswa untuk semester ganjil mendatang.'
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '6 min',
        'excerpt'   => 'Jurusan Teknologi Informasi menyelenggarakan workshop kurikulum bersama para pakar industri.'
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.png',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '4 min',
        'excerpt'   => 'Telah dibuka penerimaan mahasiswa baru jalur kelas kerja sama industri untuk tahun ajaran ini.'
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.png',
        'date'      => date_i18n('j F Y'),
        'reading_time' => '7 min',
        'excerpt'   => 'Prestasi membanggakan kembali diraih oleh JTI di tingkat nasional sebagai jurusan berkinerja terbaik.'
      ],
    ];

    $default_to_add = array_slice($default_slides, 0, $remaining);
    
    // Ensure we don't add duplicates if hero slides used the exact same default posts
    // We append them to all_posts
    $all_posts = array_merge($all_posts, $default_to_add);
  }

  // Re-assign spotlight and posts
  $spotlight = !empty($all_posts) ? $all_posts[0] : null;
  $list_posts = count($all_posts) > 1 ? array_slice($all_posts, 1) : [];

  return [

    'spotlight' =>
      $spotlight,

    'posts' =>
      $list_posts,

  ];

}

/* ========================================
   GET STUDY PROGRAMS
======================================== */

function webjti_get_study_programs($limit = 6) {

  $query =
    new WP_Query([

      'post_type' =>
        'study_program',

      'posts_per_page' =>
        $limit,

      'orderby' =>
        'menu_order',

      'order' =>
        'ASC',

      'post_status' =>
        'publish',

    ]);

  if (!$query->have_posts()) {
    return [
      [
        'id'            => 0,
        'title'         => __('D-IV Teknik Informatika', 'webjti'),
        'description'   => __('Menghasilkan lulusan yang kompeten dalam rekayasa perangkat lunak, kecerdasan buatan, keamanan siber, dan pemrograman mobile/web.', 'webjti'),
        'permalink'     => '#',
        'badge'         => '',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-code',
      ],
      [
        'id'            => 0,
        'title'         => __('D-IV Sistem Informasi Bisnis', 'webjti'),
        'description'   => __('Mengintegrasikan teknologi informasi dengan manajemen bisnis untuk merancang sistem cerdas yang efisien dan mendukung keputusan strategis.', 'webjti'),
        'permalink'     => '#',
        'badge'         => '',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-database',
      ],
      [
        'id'            => 0,
        'title'         => __('D-III Manajemen Informatika', 'webjti'),
        'description'   => __('Menghasilkan tenaga ahli madya yang kompeten di bidang pengembangan aplikasi web, mobile, basis data, dan jaringan komputer.', 'webjti'),
        'permalink'     => '#',
        'badge'         => 'PSDKU Kediri',
        'icon_url'      => '',
        'fallback_icon' => 'ph ph-desktop',
      ]
    ];
  }

  $programs = [];

  $fallback_icons = [

    'ph ph-code',

    'ph ph-database',

    'ph ph-desktop',

    'ph ph-cpu',

    'ph ph-devices',

    'ph ph-terminal-window',

  ];

  $icon_counter = 0;

  while ($query->have_posts()) {

    $query->the_post();

    $post_id = get_the_ID();

    $icon_field =
      function_exists('get_field')
        ? get_field('program_icon')
        : '';

    $description = get_the_excerpt();

    if (!$description) {

      $description = wp_trim_words(get_the_content(), 20, '...');

    }

    if (!$description) {

      $description =
        __('Deskripsi program studi belum tersedia.', 'webjti');

    }

    // Get Campus Label Taxonomy Branch Badge
    $badge = '';
    $terms = get_the_terms($post_id, 'campus_label');
    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        if (strpos($term->name, 'Kampus Utama') === false) {
          $badge = $term->name;
          break;
        }
      }
    }

    $icon_url = '';

    if (
      is_array($icon_field) &&
      isset($icon_field['url'])
    ) {

      $icon_url =
        $icon_field['url'];

    }

    elseif (
      is_string($icon_field) &&
      filter_var(
        $icon_field,
        FILTER_VALIDATE_URL
      )
    ) {

      $icon_url =
        $icon_field;

    }

    elseif (
      is_numeric($icon_field)
    ) {

      $icon_url =
        wp_get_attachment_url(
          $icon_field
        );

    }

    $programs[] = [

      'id' =>
        $post_id,

      'title' =>
        get_the_title(),

      'description' =>
        $description,

      'permalink' =>
        get_permalink(),

      'badge' =>
        $badge,

      'icon_url' =>
        $icon_url,

      'fallback_icon' =>
        !$icon_url
          ? $fallback_icons[
              $icon_counter % count($fallback_icons)
            ]
          : '',

    ];

    $icon_counter++;

  }

  wp_reset_postdata();

  return $programs;

}

/* ========================================
   GET HISTORY TIMELINE
======================================== */

function webjti_get_history_timeline() {

  $query =
    new WP_Query([

      'post_type' =>
        'history_timeline',

      'posts_per_page' =>
        -1,

      'post_status' =>
        'publish',

    ]);

  if (!$query->have_posts()) {
    $query =
      new WP_Query([

        'post_type' =>
          'timeline_sejarah',

        'posts_per_page' =>
          -1,

        'post_status' =>
          'publish',

      ]);
  }

  $default_items = [
    [
      'year' => '2005',
      'title' => 'Titik Awal',
      'content' => 'D3 Manajemen Informatika berdiri dengan SK Nomor 2001/D/T/2005 di bawah Jurusan Teknik Elektro, diawali 92 mahasiswa, 6 dosen tetap, 1 teknisi, dan 1 tenaga administrasi.',
      'icon_url' => '',
      'icon_class' => 'ph-rocket-launch'
    ],
    [
      'year' => '2010',
      'title' => 'Ekspansi ke Sarjana Terapan',
      'content' => 'Polinema mendirikan Program Studi D4 Teknik Informatika sesuai kebutuhan masyarakat dan industri. Awalnya 49 mahasiswa. Lima tahun kemudian, jumlahnya melonjak menjadi 553 mahasiswa.',
      'icon_url' => '',
      'icon_class' => 'ph-graduation-cap'
    ],
    [
      'year' => '2015',
      'title' => 'Jurusan Mandiri',
      'content' => 'Berdasarkan SK Direktur Nomor 53, Jurusan Teknologi Informasi resmi berdiri sebagai jurusan tersendiri yang menaungi Prodi D3 MI dan D4 TI, total 1.289 mahasiswa (409 D3 MI dan 880 D4 TI).',
      'icon_url' => '',
      'icon_class' => 'ph-chart-polar'
    ],
    [
      'year' => '2019',
      'title' => 'Ekspansi PSDKU',
      'content' => 'JTI memperluas jangkauan dengan three PSDKU: D3 Manajemen Informatika Kediri, D3 Manajemen Informatika Pamekasan, dan D3 Teknologi Informasi Lumajang.',
      'icon_url' => '',
      'icon_class' => 'ph-globe'
    ],
    [
      'year' => '2020',
      'title' => 'Era Program Baru',
      'content' => 'Sesuai kebutuhan industri dan arahan Kemendikbudristek, D3 Manajemen Informatika di kampus utama diubah D4 Sistem Informasi Bisnis. Ditambah 2 program baru: D2 Pengembangan Piranti Lunak Situs dan S2 Magister Terapan Rekayasa Teknologi Informasi.',
      'icon_url' => '',
      'icon_class' => 'ph-star'
    ]
  ];

  if (!$query->have_posts()) {
    return $default_items;
  }

  $items = [];
  $fallback_icons = [
    'ph-rocket-launch',
    'ph-graduation-cap',
    'ph-chart-polar',
    'ph-globe',
    'ph-star'
  ];
  $index = 0;

  while ($query->have_posts()) {

    $query->the_post();
    $post_id = get_the_ID();

    // 1. Retrieve Year (tahun)
    $year =
      function_exists('get_field')
        ? get_field('tahun', $post_id)
        : get_post_meta($post_id, 'tahun', true);

    if (!$year) {
      $year = get_post_meta($post_id, '_timeline_year', true);
    }
    if (!$year) {
      $year = '-';
    }

    // 2. Retrieve Title (timeline_title)
    $title =
      function_exists('get_field')
        ? get_field('timeline_title', $post_id)
        : get_post_meta($post_id, 'timeline_title', true);

    if (!$title) {
      $title = get_the_title($post_id);
    }

    // 3. Retrieve Description (description)
    $description =
      function_exists('get_field')
        ? get_field('description', $post_id)
        : get_post_meta($post_id, 'description', true);

    if (!$description) {
      $description = get_the_content(null, false, $post_id);
    }

    // 4. Retrieve Icon (timeline_ikon)
    $ikon =
      function_exists('get_field')
        ? get_field('timeline_ikon', $post_id)
        : get_post_meta($post_id, 'timeline_ikon', true);

    if (!$ikon) {
      $ikon = get_post_meta($post_id, 'ikon', true);
    }
    if (!$ikon) {
      $ikon = get_post_meta($post_id, '_timeline_icon', true);
    }

    $icon_url = '';
    $icon_class = '';

    if (!empty($ikon)) {
      if (is_array($ikon)) {
        $icon_url = isset($ikon['url']) ? $ikon['url'] : '';
      } elseif (is_numeric($ikon)) {
        $icon_url = wp_get_attachment_image_url($ikon, 'full');
      } elseif (filter_var($ikon, FILTER_VALIDATE_URL)) {
        $icon_url = $ikon;
      } else {
        // String class name
        $icon_class = $ikon;
      }
    }

    // Assign fallback icon class dynamically if none is set
    if (empty($icon_url) && empty($icon_class)) {
      $year_clean = (int) $year;
      if ($year_clean === 2005) {
        $icon_class = 'ph-rocket-launch';
      } elseif ($year_clean === 2010) {
        $icon_class = 'ph-graduation-cap';
      } elseif ($year_clean === 2015) {
        $icon_class = 'ph-chart-polar';
      } elseif ($year_clean === 2019) {
        $icon_class = 'ph-globe';
      } elseif ($year_clean === 2020) {
        $icon_class = 'ph-star';
      } else {
        $icon_class = $fallback_icons[$index % count($fallback_icons)];
      }
    }

    $items[] = [
      'title' => $title,
      'content' => apply_filters('the_content', $description),
      'year' => $year,
      'icon_url' => $icon_url,
      'icon_class' => $icon_class,
    ];

    $index++;

  }

  wp_reset_postdata();

  // Sort chronologically ascending
  usort($items, function($a, $b) {
    $year_a = (int) $a['year'];
    $year_b = (int) $b['year'];
    if ($year_a === $year_b) {
      return 0;
    }
    return ($year_a < $year_b) ? -1 : 1;
  });

  return $items;

}

/* ========================================
   GET LECTURERS
======================================== */

function webjti_get_term_names($post_id, $taxonomy) {

  $terms =
    get_the_terms(
      $post_id,
      $taxonomy
    );

  if (empty($terms) || is_wp_error($terms)) {
    return [];
  }

  return array_values(
    array_filter(
      wp_list_pluck(
        $terms,
        'name'
      )
    )
  );

}

/**
 * Smart Lecturer Placeholder Photo Resolver
 * Maps specific fallback lecturer names to their high-fidelity placeholder assets in the theme
 */
function webjti_get_lecturer_placeholder_photo($name, $fallback_index = null) {
  $theme_uri = get_template_directory_uri();
  
  if (stripos($name, 'Devi') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu devi.png';
  }
  if (stripos($name, 'Yoga') !== false) {
    return $theme_uri . '/assets/images/placeholders/pak yoga.png';
  }
  if (stripos($name, 'Hendra') !== false) {
    return $theme_uri . '/assets/images/placeholders/pak hendra.png';
  }
  if (stripos($name, 'Ana') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu ana.png';
  }
  if (stripos($name, 'Mungki') !== false) {
    return $theme_uri . '/assets/images/placeholders/bu mungki.png';
  }
  
  // If we have a fallback index, choose a gender-appropriate placeholder from the 5 existing photos!
  if ($fallback_index !== null) {
    // Cast to int in case it's a string ID
    $index_num = (int)$fallback_index;
    
    $is_female = false;
    $female_keywords = ['Siti', 'Fitri', 'Vitri', 'Yuliana', 'Riza', 'Dewi', 'Hasana', 'Hidayah', 'Dewi', 'S.Si.'];
    foreach ($female_keywords as $kw) {
      if (stripos($name, $kw) !== false) {
        $is_female = true;
        break;
      }
    }
    
    $female_photos = [
      $theme_uri . '/assets/images/placeholders/bu devi.png',
      $theme_uri . '/assets/images/placeholders/bu mungki.png',
      $theme_uri . '/assets/images/placeholders/bu ana.png',
    ];
    
    $male_photos = [
      $theme_uri . '/assets/images/placeholders/pak yoga.png',
      $theme_uri . '/assets/images/placeholders/pak hendra.png',
    ];
    
    if ($is_female) {
      return $female_photos[$index_num % count($female_photos)];
    } else {
      return $male_photos[$index_num % count($male_photos)];
    }
  }
  
  return $theme_uri . '/assets/images/placeholders/default-avatar.png';
}

function webjti_get_lecturers($args = []) {

  $default_args = [

    'post_type' => 'lecturer',

    'posts_per_page' =>
      10,

    'post_status' =>
      'publish',

  ];

  $query_args =
    wp_parse_args(
      $args,
      $default_args
    );

  $query =
    new WP_Query($query_args);

  if (!$query->have_posts()) {
    $campuses = [
      'Kampus Utama'     => ['D-IV Teknik Informatika', 'D-IV Sistem Informasi Bisnis'],
      'PSDKU Lumajang'   => ['D-III Teknologi Informasi'],
      'PSDKU Kediri'     => ['D-III Manajemen Informatika'],
      'PSDKU Pamekasan'  => ['D-III Manajemen Informatika']
    ];

    $lecturers = [];
    $skills_pool = [
      ['Decision Support System', 'Data Science', 'Machine Learning', 'Big Data Analytics'],
      ['Image Processing', 'Computer Vision', 'Artificial Intelligence', 'Pattern Recognition'],
      ['Business Intelligence', 'Enterprise Resource Planning', 'Database Systems', 'System Analysis'],
      ['E-Business', 'IT Governance', 'Project Management', 'Digital Marketing'],
      ['Web Programming', 'Mobile Application Development', 'UI/UX Design', 'Interaction Design'],
      ['Computer Networks', 'Cloud Computing', 'Internet of Things', 'Network Security'],
      ['Database Management', 'Object-Oriented Programming', 'Software Engineering'],
      ['Algorithm Design', 'Data Structure', 'Embedded Systems', 'Microcontroller']
    ];

    $names = [
      'Kampus Utama' => [
        'Yoga Pristyanto, S.Kom., M.Eng.',
        'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.',
        'Devi Yuniarto, S.Kom., M.T.',
        'Hendra Pradibta, S.E., M.Sc.',
        'Usman Nurhasan, S.Kom., M.T.'
      ],
      'PSDKU Lumajang' => [
        'M. Ali Fikri, S.Kom., M.Kom.',
        'Riza Agustina, S.ST., M.T.',
        'Agus Herwanto, S.T., M.Cs.',
        'Indra Kharisma, S.Kom., M.T.',
        'Ana Anggraini, S.Si., M.Si.'
      ],
      'PSDKU Kediri' => [
        'Yuliana Rachmawati, S.Kom., M.T.',
        'Didik Dwi Prasetya, S.T., M.T.',
        'Bambang Hariadi, S.Kom., M.T.',
        'Fitri Rahmawati, S.ST., M.Eng.',
        'Mungki Puspitasari, S.Kom., M.Kom.'
      ],
      'PSDKU Pamekasan' => [
        'Achmad Budi Setiawan, S.T., M.Cs.',
        'Siti Nurul Hasana, S.ST., M.T.',
        'Faisal Muttaqin, S.Kom., M.Kom.',
        'Ahmad Faruq, S.T., M.Eng.',
        'Nurul Hidayah, S.Kom., M.T.'
      ]
    ];

    $nip_base = 198002060000000000;
    $nidn_base = 10000000;
    $card_index = 1;

    foreach ($campuses as $campus => $prodis) {
      for ($i = 0; $i < 5; $i++) {
        $prodi = $prodis[$i % count($prodis)];
        $name = $names[$campus][$i];
        $skills = $skills_pool[($card_index - 1) % count($skills_pool)];

        $lecturers[] = [
          'id'               => 'default-' . $card_index,
          'name'             => $name,
          'title'            => 'Dosen ' . $prodi,
          'study_program'    => $prodi,
          'nip'              => (string)($nip_base + $card_index * 123456789),
          'nidn'             => '00' . ($nidn_base + $card_index * 987),
          'laboratory'       => 'Lab Rekayasa Perangkat Lunak ' . ($card_index),
          'campus_location'  => $campus,
          'skills'           => $skills,
          'photo'            => webjti_get_lecturer_placeholder_photo($name, $card_index),
          'permalink'        => home_url('/?default_lecturer=default-' . $card_index),
        ];
        $card_index++;
      }
    }
    return $lecturers;
  }

  $lecturers = [];

  while ($query->have_posts()) {

    $query->the_post();

    /*
    ========================================
    PHOTO
    ========================================
    */

    $photo =
      get_the_post_thumbnail_url(
        get_the_ID(),
        'medium'
      );

    $default_photo = webjti_get_lecturer_placeholder_photo(get_the_title(), get_the_ID());

    /*
    ========================================
    SKILLS
    ========================================
    */

    $skills =
      webjti_get_term_names(
        get_the_ID(),
        'expertise'
      );

    if (empty($skills)) {

      $skills =
        get_field(
          'bidang_keahlian'
        );

    }

    if (empty($skills)) {

      $skills = [];

    }

    elseif (!is_array($skills)) {

      $skills =
        explode(',', $skills);

    }

    $skills =
      array_map(
        'trim',
        $skills
      );

    /*
    ========================================
    DATA
    ========================================
    */

    $laboratory_terms =
      webjti_get_term_names(
        get_the_ID(),
        'laboratory'
      );

    $campus_terms =
      webjti_get_term_names(
        get_the_ID(),
        'campus_location'
      );

    $lecturers[] = [

      'id' =>
        get_the_ID(),

      'name' =>
        get_the_title(),

      'title' =>
        get_the_excerpt(),

      'nip' =>
        get_field('nip') ?: '-',

      'nidn' =>
        get_field('nidn') ?: '-',

      'laboratory' =>
        !empty($laboratory_terms)
          ? implode(', ', $laboratory_terms)
          : (get_field('laboratorium') ?: '-'),

      'campus_location' =>
        !empty($campus_terms)
          ? implode(', ', $campus_terms)
          : (get_field('campus_location') ?: ''),

      'skills' =>
        $skills,

      'skills_display' =>
        array_slice(
          $skills,
          0,
          2
        ),

      'remaining_skills' =>
        max(
          count($skills) - 2,
          0
        ),

      'photo' =>
        $photo ?: $default_photo,

      'permalink' =>
        get_permalink(),

    ];

  }

  wp_reset_postdata();

  return $lecturers;

}

/**
 * Get Staff Members (Tenaga Kependidikan)
 * Handles dynamic CPT queries and supports 20 high-fidelity gender-appropriate fallback cards.
 */
function webjti_get_staff($args = []) {
  $default_args = [
    'post_type' => 'staff',
    'posts_per_page' => -1,
    'post_status' => 'publish',
  ];

  $query_args = wp_parse_args($args, $default_args);
  $query = new WP_Query($query_args);

  if (!$query->have_posts()) {
    $departments = [
      'Akademik'             => 'Akademik D4 Teknik Informatika',
      'PLP'                  => 'Pranata Laboratorium Pendidikan (PLP)',
      'Administrasi Jurusan' => 'Administrasi Jurusan / Akademik',
      'Administrasi BMN'     => 'Administrasi Barang Milik Negara (BMN)',
      'Teknisi Jurusan'      => 'Teknisi Jurusan'
    ];

    $names = [
      'Akademik' => [
        'Ana Agustina, S.M.',
        'Hendra Wijaya, A.Md.',
        'Devi Kartika, S.E.',
        'Yoga Pratama, S.ST.'
      ],
      'PLP' => [
        'Mungki Widiastuti, A.Md.',
        'Budi Santoso, S.ST.',
        'Siti Aminah, A.Md.',
        'Achmad Fauzi, S.T.'
      ],
      'Administrasi Jurusan' => [
        'Riza Agustina, S.AP.',
        'Didik Hermawan, A.Md.',
        'Fitri Rahmawati, S.AP.',
        'Bambang Wijaya, S.E.'
      ],
      'Administrasi BMN' => [
        'Yuliana Rachmawati, S.E.',
        'Agus Setiawan, A.Md.',
        'Dewi Anggraini, S.E.',
        'Faisal Muttaqin, S.E.'
      ],
      'Teknisi Jurusan' => [
        'Ahmad Faruq, A.Md.T.',
        'Siti Nurul Hasana, A.Md.T.',
        'Fikri Hermawan, A.Md.T.',
        'Nurul Hidayah, A.Md.T.'
      ]
    ];

    $nip_base = 199002062019031000;
    $staff_list = [];
    $card_index = 1;

    foreach ($names as $dept_key => $dept_names) {
      $position = $departments[$dept_key];
      foreach ($dept_names as $name) {
        $staff_list[] = [
          'id'               => 'default-staff-' . $card_index,
          'name'             => $name,
          'position'         => $position,
          'nip'              => (string)($nip_base + $card_index * 987654),
          'photo'            => webjti_get_lecturer_placeholder_photo($name, $card_index),
          'department'       => $dept_key,
        ];
        $card_index++;
      }
    }
    return $staff_list;
  }

  $staff_list = [];
  while ($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();

    $photo = get_the_post_thumbnail_url($post_id, 'medium');

    $dept_terms = webjti_get_term_names($post_id, 'staff_department');
    $department = !empty($dept_terms) ? $dept_terms[0] : '';

    $position = get_the_excerpt($post_id);
    if (empty($position)) {
      $position = get_field('jabatan', $post_id) ?: '-';
    }

    if (empty($department)) {
      if (stripos($position, 'PLP') !== false || stripos($position, 'Pranata') !== false) {
        $department = 'PLP';
      } elseif (stripos($position, 'Akademik') !== false) {
        $department = 'Akademik';
      } elseif (stripos($position, 'BMN') !== false || stripos($position, 'Barang Milik') !== false) {
        $department = 'Administrasi BMN';
      } elseif (stripos($position, 'Teknisi') !== false) {
        $department = 'Teknisi Jurusan';
      } elseif (stripos($position, 'Administrasi Jurusan') !== false) {
        $department = 'Administrasi Jurusan';
      } else {
        $department = 'Administrasi Jurusan';
      }
    }

    $staff_list[] = [
      'id'               => $post_id,
      'name'             => get_the_title($post_id),
      'position'         => $position,
      'nip'              => get_field('nip', $post_id) ?: '-',
      'photo'            => $photo ?: webjti_get_lecturer_placeholder_photo(get_the_title($post_id), $post_id),
      'department'       => $department,
    ];
  }
  wp_reset_postdata();

  return $staff_list;
}


/**
 * Query Helpers
 *
 * @package WebJTI_Theme
 */

/* ========================================
   SINGLE LECTURER
======================================== */

function webjti_get_single_lecturer($post_id = null) {

  $post_id =
    $post_id ?: get_the_ID();

  if (!$post_id) {
    return null;
  }

  /*
  ========================================
  PHOTO
  ========================================
  */

  $acf_photo =
    get_field(
      'foto',
      $post_id
    );

  $photo = '';

  if (is_array($acf_photo)) {

    $photo =
      $acf_photo['url'] ?? '';

  }

  elseif (is_string($acf_photo)) {

    $photo =
      $acf_photo;

  }

  if (!$photo) {

    $photo =
      get_the_post_thumbnail_url(
        $post_id,
        'large'
      );

  }

  if (!$photo) {
    $photo = webjti_get_lecturer_placeholder_photo(get_the_title($post_id), $post_id);
  }

  /*
  ========================================
  SKILLS
  ========================================
  */

  $skills =
    webjti_get_term_names(
      $post_id,
      'expertise'
    );

  if (empty($skills)) {

    $skills =
      get_field(
        'bidang_keahlian',
        $post_id
      );

  }

  if (empty($skills)) {

    $skills = [];

  }

  elseif (!is_array($skills)) {

    $skills =
      explode(',', $skills);

  }

  $skills =
    array_filter(
      array_map(
        'trim',
        $skills
      )
    );

  /*
  ========================================
  DATA
  ========================================
  */

  $laboratory_terms =
    webjti_get_term_names(
      $post_id,
      'laboratory'
    );

  $campus_terms =
    webjti_get_term_names(
      $post_id,
      'campus_location'
    );

  return [

    'id' =>
      $post_id,

    'name' =>
      get_the_title($post_id),

    'position' =>
      get_field(
        'jabatan',
        $post_id
      ),

    'study_program' =>
      get_field(
        'program_studi',
        $post_id
      ),

    'nip' =>
      get_field(
        'nip',
        $post_id
      ),

    'nidn' =>
      get_field(
        'nidn',
        $post_id
      ),

    'laboratory' =>
      !empty($laboratory_terms)
        ? implode(', ', $laboratory_terms)
        : get_field(
          'laboratorium',
          $post_id
        ),

    'campus_location' =>
      !empty($campus_terms)
        ? implode(', ', $campus_terms)
        : get_field(
          'campus_location',
          $post_id
        ),

    'office_address' =>
      get_field(
        'alamat_kantor',
        $post_id
      ),

    'website' =>
      get_field(
        'website',
        $post_id
      ),

    'linkedin' =>
      get_field(
        'linkedin',
        $post_id
      ),

    'google_scholar' =>
      get_field(
        'google_scholar',
        $post_id
      ),

    'sinta' =>
      get_field(
        'sinta',
        $post_id
      ),

    'email' =>
      get_field(
        'email',
        $post_id
      ),

    'skills' =>
      $skills,

    'photo' =>
      $photo,

    'permalink' =>
      get_permalink($post_id),

    'excerpt' =>
      get_the_excerpt($post_id),

    'content' =>
      apply_filters(
        'the_content',
        get_post_field(
          'post_content',
          $post_id
        )
      ),

  ];

}

/* ========================================
   LECTURER EDUCATION
======================================== */

function webjti_get_lecturer_education($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        'lecturer_education',

      'posts_per_page' =>
        -1,

      'meta_query' => [

        [
          'key' =>
            'lecturer',

          'value' =>
            $lecturer_id,

          'compare' =>
            '=',
        ]

      ],

      'orderby' =>
        'meta_value_num',

      'meta_key' =>
        'tahun_selesai',

      'order' =>
        'DESC',

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $educations = [];

  while ($query->have_posts()) {

    $query->the_post();

    $educations[] = [

      'degree' =>
        get_field('jenjang'),

      'institution' =>
        get_field('institusi'),

      'start_year' =>
        get_field('tahun_mulai'),

      'end_year' =>
        get_field('tahun_selesai'),

    ];

  }

  wp_reset_postdata();

  return $educations;

}

/* ========================================
   LECTURER CERTIFICATIONS
======================================== */

function webjti_get_lecturer_certifications($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        'lecturer_certification',

      'posts_per_page' =>
        -1,

      'meta_query' => [

        [
          'key' =>
            'lecturer',

          'value' =>
            $lecturer_id,

          'compare' =>
            '=',
        ]

      ],

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $certifications = [];

  while ($query->have_posts()) {

    $query->the_post();

    $certifications[] = [

      'title' =>
        get_field(
          'nama_sertifikasi'
        ),

      'institution' =>
        get_field(
          'lembaga'
        ),

      'start_year' =>
        get_field(
          'tahun_mulai'
        ),

      'end_year' =>
        get_field(
          'tahun_selesai'
        ),

    ];

  }

  wp_reset_postdata();

  return $certifications;

}

/* ========================================
   LECTURER COURSES
======================================== */

function webjti_get_lecturer_courses($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        'lecturer_course',

      'posts_per_page' =>
        -1,

      'meta_query' => [

        [
          'key' =>
            'lecturer',

          'value' =>
            $lecturer_id,

          'compare' =>
            '=',
        ]

      ],

    ]);

  if (!$query->have_posts()) {

    return [

      'odd' => [],
      'even' => [],

    ];

  }

  $odd = [];
  $even = [];

  while ($query->have_posts()) {

    $query->the_post();

    $course_names =
      get_field(
        'nama_mata_kuliah'
      );

    $semester =
      strtolower(
        get_field(
          'semester'
        )
      );

    $course_names =
      explode(
        ',',
        $course_names
      );

    foreach ($course_names as $course) {

      $course =
        trim($course);

      if (!$course) {
        continue;
      }

      if (
        strpos(
          $semester,
          'ganjil'
        ) !== false
      ) {

        $odd[] = $course;

      } else {

        $even[] = $course;

      }

    }

  }

  wp_reset_postdata();

  return [

    'odd' =>
      $odd,

    'even' =>
      $even,

  ];

}

/* ========================================
   LECTURER PUBLICATIONS
======================================== */

function webjti_get_lecturer_publications($lecturer_id = null) {

  $lecturer_id =
    $lecturer_id ?: get_the_ID();

  $query =
    new WP_Query([

      'post_type' =>
        'lecturer_publication',

      'posts_per_page' =>
        -1,

      'meta_query' => [

        [
          'key' =>
            'lecturer',

          'value' =>
            $lecturer_id,

          'compare' =>
            '=',
        ]

      ],

    ]);

  if (!$query->have_posts()) {
    return [];
  }

  $publications = [];

  while ($query->have_posts()) {

    $query->the_post();

    $publications[] = [

      'title' =>
        get_field(
          'judul_publikasi'
        ) ?: get_the_title(),

      'year' =>
        get_field(
          'tahun_publikasi'
        ) ?: 0,

      'citations' =>
        get_field(
          'jumlah_sitasi'
        ) ?: 0,

      'url' =>
        get_field(
          'link_publikasi'
        ) ?: '#',

    ];

  }

  wp_reset_postdata();

  return $publications;

}

/* ========================================
   LECTURER FALLBACK / MOCK DATA GENERATOR
======================================== */

function webjti_get_fallback_lecturer_data($default_id = 'default-1') {
  $lecturer = null;
  $educations = [];
  $certifications = [];
  $courses = [
    'odd' => [],
    'even' => []
  ];
  $publications = [];

  $prev_name = '';
  $prev_url = '';
  $next_name = '';
  $next_url = '';

  // Retrieve fallback lecturer details
  $all_lecturers = webjti_get_lecturers(['posts_per_page' => -1]);
  $current_idx = -1;
  foreach ($all_lecturers as $idx => $item) {
    if ($item['id'] === $default_id) {
      $lecturer = $item;
      $current_idx = $idx;
      break;
    }
  }

  if (!$lecturer && !empty($all_lecturers)) {
    $lecturer = $all_lecturers[0];
    $current_idx = 0;
    $default_id = $lecturer['id'];
  }

  if ($lecturer) {
    // Construct detailed mock profile fields
    $lecturer['position'] = $lecturer['title'] ?? 'Dosen';
    $lecturer['office_address'] = 'Ruang Dosen Jurusan Teknologi Informasi, Lantai 4 Gedung Sipil, POLINEMA';
    $lecturer['website'] = 'https://jti.polinema.ac.id';
    $lecturer['linkedin'] = 'https://linkedin.com';
    $lecturer['google_scholar'] = 'https://scholar.google.com';
    $lecturer['sinta'] = 'https://sinta.kemdikbud.go.id';
    $lecturer['email'] = strtolower(str_replace(' ', '', str_replace(',', '', explode('.', $lecturer['name'])[0]))) . '@polinema.ac.id';

    // 1. Education
    $educations = [
      [
        'degree' => 'S3 Doktor Teknik Informatika',
        'institution' => 'Shenyang Aerospace University',
        'start_year' => '2016',
        'end_year' => '2020',
      ],
      [
        'degree' => 'S2 Magister Engineering',
        'institution' => 'Institut Teknologi Bandung (ITB)',
        'start_year' => '2010',
        'end_year' => '2012',
      ],
      [
        'degree' => 'S1 Teknik Informatika',
        'institution' => 'Politeknik Negeri Malang (POLINEMA)',
        'start_year' => '2003',
        'end_year' => '2007',
      ]
    ];

    // 2. Certifications
    $certifications = [
      [
        'title' => 'Certified Big Data Professional (CBDP)',
        'institution' => 'IBM Corporation',
        'start_year' => '2022',
        'end_year' => '2025',
      ],
      [
        'title' => 'Oracle Certified Java Developer',
        'institution' => 'Oracle Corp.',
        'start_year' => '2019',
        'end_year' => '2022',
      ]
    ];

    // 3. Courses
    $courses = [
      'odd' => [
        'Pemrograman Web Lanjut',
        'Desain Antarmuka Pengguna (UI/UX)',
        'Kecerdasan Buatan (Artificial Intelligence)',
        'Analisis dan Desain Sistem'
      ],
      'even' => [
        'Sistem Pendukung Keputusan (DSS)',
        'Struktur Data & Algoritma',
        'Rekayasa Perangkat Lunak',
        'Metodologi Penelitian'
      ]
    ];

    // 4. Publications
    $publications = [
      [
        'title' => 'A Comprehensive Study on Decision Support System Algorithms for Student Academic Classification',
        'year' => 2023,
        'citations' => 38,
        'url' => 'https://scholar.google.com',
      ],
      [
        'title' => 'Implementation of Machine Learning and Predictive Analytics in Higher Education Risk Mitigation',
        'year' => 2022,
        'citations' => 29,
        'url' => 'https://scholar.google.com',
      ],
      [
        'title' => 'Design of Smart Learning Environments and Classroom Assistive Technologies based on IoT',
        'year' => 2021,
        'citations' => 17,
        'url' => 'https://scholar.google.com',
      ]
    ];

    // Dynamic cycling for Next & Prev fallback posts
    if ($current_idx !== -1 && !empty($all_lecturers)) {
      if ($current_idx > 0) {
        $prev_item = $all_lecturers[$current_idx - 1];
        $prev_name = $prev_item['name'];
        $prev_url = home_url('/?default_lecturer=' . $prev_item['id']);
      }
      if ($current_idx < count($all_lecturers) - 1) {
        $next_item = $all_lecturers[$current_idx + 1];
        $next_name = $next_item['name'];
        $next_url = home_url('/?default_lecturer=' . $next_item['id']);
      }
    }
  }

  return [
    'lecturer' => $lecturer,
    'educations' => $educations,
    'certifications' => $certifications,
    'courses' => $courses,
    'publications' => $publications,
    'prev_name' => $prev_name,
    'prev_url' => $prev_url,
    'next_name' => $next_name,
    'next_url' => $next_url,
  ];
}

/* ========================================
   PRESTASI (ACHIEVEMENT) HELPERS & FALLBACKS
======================================== */

/**
 * Helper to Get Ketua Tim Name from Anggota Prestasi
 */
function webjti_get_achievement_ketua($achievement_id) {
  $query = new WP_Query([
    'post_type'      => 'anggota_prestasi',
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'meta_query'     => [
      'relation' => 'AND',
      [
        'key'     => 'prestasi',
        'value'   => $achievement_id,
        'compare' => '=',
      ],
      [
        'key'     => 'role',
        'value'   => 'ketua',
        'compare' => '=',
      ]
    ]
  ]);

  if (!$query->have_posts()) {
    $query = new WP_Query([
      'post_type'      => 'anggota_prestasi',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
      'meta_query'     => [
        'relation' => 'AND',
        [
          'key'     => 'achievement',
          'value'   => $achievement_id,
          'compare' => '=',
        ],
        [
          'key'     => 'role',
          'value'   => 'ketua',
          'compare' => '=',
        ]
      ]
    ]);
  }

  $ketua_name = '-';
  if ($query->have_posts()) {
    $query->the_post();
    $ketua_name = get_field('member_name') ?: get_field('nama') ?: get_the_title();
  }
  wp_reset_postdata();

  return $ketua_name;
}

/**
 * Get Unique List of Achievement Years
 */
function webjti_get_achievement_years() {
  if (post_type_exists('prestasi')) {
    $all_prestasi_ids = get_posts([
      'post_type'      => 'prestasi',
      'post_status'    => 'publish',
      'posts_per_page' => -1,
      'fields'         => 'ids',
    ]);

    $tahun_list = [];
    foreach ($all_prestasi_ids as $post_id) {
      $tahun = get_field('achievement_year', $post_id) ?: get_field('tahun_prestasi', $post_id);
      if ($tahun) {
        $tahun_list[] = (string) $tahun;
      }
    }

    $tahun_list = array_unique($tahun_list);
    rsort($tahun_list);

    if (!empty($tahun_list)) {
      return $tahun_list;
    }
  }

  return ['2025', '2024', '2023'];
}

/**
 * Get Achievement Metrics (Total, Nasional, Internasional, PKM)
 */
function webjti_get_achievement_metrics() {
  if (post_type_exists('prestasi')) {
    $query = new WP_Query([
      'post_type'      => 'prestasi',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
    ]);

    if ($query->have_posts()) {
      $total = $query->post_count;
      $nasional = 0;
      $internasional = 0;
      $pkm = 0;

      while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        $level = get_field('level', $post_id) ?: get_field('tingkat', $post_id);
        $level = strtolower((string)$level);
        if ($level === 'nasional') {
          $nasional++;
        } elseif ($level === 'internasional') {
          $internasional++;
        }

        $is_pkm = get_field('is_pkm', $post_id);
        if ($is_pkm && ($is_pkm === '1' || $is_pkm === 1 || $is_pkm === true || strtolower((string)$is_pkm) === 'yes' || strtolower((string)$is_pkm) === 'true')) {
          $pkm++;
        }
      }
      wp_reset_postdata();

      return [
        'total'         => $total,
        'nasional'      => $nasional,
        'internasional' => $internasional,
        'pkm'           => $pkm,
      ];
    }
  }

  // Calculate from mock dataset fallback
  $result = webjti_get_achievements_list([], 1, 9999);
  $rows = $result['rows'];

  $total = count($rows);
  $nasional = 0;
  $internasional = 0;
  $pkm = 0;

  foreach ($rows as $r) {
    $tingkat = '';
    if (isset($r['tingkat_raw'])) {
      $tingkat = strtolower($r['tingkat_raw']);
    } elseif (isset($r['tingkat_class'])) {
      $tingkat = str_replace('tingkat-', '', $r['tingkat_class']);
    } else {
      $tingkat = strtolower($r['tingkat']);
    }

    if ($tingkat === 'nasional') {
      $nasional++;
    } elseif ($tingkat === 'internasional') {
      $internasional++;
    }

    if (!empty($r['is_pkm'])) {
      $pkm++;
    }
  }

  return [
    'total'         => $total,
    'nasional'      => $nasional,
    'internasional' => $internasional,
    'pkm'           => $pkm,
  ];
}

/**
 * Unified Helper to Get Achievements (DB or Fallback)
 */
function webjti_get_achievements_list($filters = [], $paged = 1, $posts_per_page = 10) {
  $has_posts = false;
  if (post_type_exists('prestasi')) {
    $count_query = new WP_Query([
      'post_type'      => 'prestasi',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
    ]);
    if ($count_query->have_posts()) {
      $has_posts = true;
    }
    wp_reset_postdata();
  }

  $f_prodi   = !empty($filters['prodi']) ? sanitize_text_field($filters['prodi']) : '';
  $f_tahun   = !empty($filters['tahun']) ? sanitize_text_field($filters['tahun']) : '';
  $f_juara   = !empty($filters['juara']) ? sanitize_text_field($filters['juara']) : '';
  $f_tingkat = !empty($filters['tingkat']) ? sanitize_text_field($filters['tingkat']) : '';
  $f_search  = !empty($filters['q']) ? sanitize_text_field($filters['q']) : (!empty($filters['s']) ? sanitize_text_field($filters['s']) : '');

  $prodi_labels = [
    'd2_ppls'                         => 'D2 Pengembangan Piranti Lunak Situs',
    'd3_mi_kediri'                    => 'D3 Manajemen Informatika (Kediri)',
    'd3_mi_lumajang'                  => 'D3 Manajemen Informatika (Lumajang)',
    'd4_teknik_informatika'           => 'D4 Teknik Informatika',
    'd4_sistem_informasi_bisnis'      => 'D4 Sistem Informasi Bisnis',
    's2_rekayasa_teknologi_informasi' => 'S2 Rekayasa Teknologi Informasi',
  ];

  $juara_labels = [
    'juara_1'   => 'Juara 1',
    'juara_2'   => 'Juara 2',
    'juara_3'   => 'Juara 3',
    'harapan_1' => 'Harapan 1',
    'harapan_2' => 'Harapan 2',
    'finalis'   => 'Finalis',
  ];

  $tingkat_labels = [
    'internasional' => 'Internasional',
    'nasional'      => 'Nasional',
    'regional'      => 'Regional',
    'lokal'         => 'Lokal',
  ];

  if ($has_posts) {
    // Database Query
    $meta_query = ['relation' => 'AND'];

    if (!empty($f_prodi)) {
      $meta_query[] = [
        'key'     => 'program_studi',
        'value'   => $f_prodi,
        'compare' => '=',
      ];
    }
    if (!empty($f_tahun)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'achievement_year',
          'value'   => $f_tahun,
          'compare' => '=',
        ],
        [
          'key'     => 'tahun_prestasi',
          'value'   => $f_tahun,
          'compare' => '=',
        ]
      ];
    }
    if (!empty($f_juara)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'rank',
          'value'   => $f_juara,
          'compare' => '=',
        ],
        [
          'key'     => 'juara',
          'value'   => $f_juara,
          'compare' => '=',
        ]
      ];
    }
    if (!empty($f_tingkat)) {
      $meta_query[] = [
        'relation' => 'OR',
        [
          'key'     => 'level',
          'value'   => $f_tingkat,
          'compare' => '=',
        ],
        [
          'key'     => 'tingkat',
          'value'   => $f_tingkat,
          'compare' => '=',
        ]
      ];
    }

    $args = [
      'post_type'      => 'prestasi',
      'posts_per_page' => $posts_per_page,
      'paged'          => $paged,
      'post_status'    => 'publish',
    ];

    if (count($meta_query) > 1) {
      $args['meta_query'] = $meta_query;
    }
    if (!empty($f_search)) {
      $args['s'] = $f_search;
    }

    $query = new WP_Query($args);
    $rows = [];

    while ($query->have_posts()) {
      $query->the_post();

      $post_id     = get_the_ID();
      $prodi_val   = get_field('program_studi') ?: get_field('prodi') ?: '-';
      $prodi_lbl   = isset($prodi_labels[$prodi_val]) ? $prodi_labels[$prodi_val] : $prodi_val;
      $ketua_val   = webjti_get_achievement_ketua($post_id);
      $judul_val   = get_field('judul_kompetisi') ?: get_the_title();
      $tahun_val   = get_field('achievement_year') ?: get_field('tahun_prestasi') ?: '-';
      $juara_val   = get_field('rank') ?: get_field('juara') ?: '-';
      $juara_lbl   = isset($juara_labels[$juara_val]) ? $juara_labels[$juara_val] : $juara_val;
      $juara_cls   = str_replace('_', '-', $juara_val);
      $tingkat_val = get_field('level') ?: get_field('tingkat') ?: '-';
      $tingkat_lbl = isset($tingkat_labels[$tingkat_val]) ? $tingkat_labels[$tingkat_val] : $tingkat_val;
      $tingkat_cls = 'tingkat-' . $tingkat_val;
      $is_pkm      = get_field('is_pkm') ? true : false;

      $rows[] = [
        'prodi'         => $prodi_lbl,
        'ketua'         => $ketua_val,
        'judul'         => $judul_val,
        'tahun'         => $tahun_val,
        'juara'         => $juara_lbl,
        'juara_class'   => $juara_cls,
        'tingkat'       => $tingkat_lbl,
        'tingkat_class' => $tingkat_cls,
        'url'           => get_permalink(),
        'is_pkm'        => $is_pkm,
      ];
    }
    wp_reset_postdata();

    return [
      'rows'      => $rows,
      'max_pages' => $query->max_num_pages,
      'is_mock'   => false,
    ];
  }

  // Generate mock fallback achievements
  $mock_data = [
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Evan Carlisle',
      'judul'       => 'InnovateTech Challenge 2024: Pioneering the Future of Technology and Innovation',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Liam Thornton',
      'judul'       => 'The Ultimate Coding Challenge: Test Your Skills and Push Your Limits',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Jasper Quinn',
      'judul'       => 'Innovators Hackathon: A Creative Challenge to Transform Ideas into Reality',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Nina Caldwell',
      'judul'       => 'Annual Creative Writing Contest for Aspiring Authors',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Owen Mercer',
      'judul'       => 'Innovative Tech Startup Pitch Competition',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Zara Whitman',
      'judul'       => 'Exciting Photography Showdown and Exhibition',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Maya Ellison',
      'judul'       => 'Worldwide Creative Sprint Contest: A Global Event Showcasing Innovative Ideas and Rapid Prototyping',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Maya Ellison',
      'judul'       => 'Global Innovation Design Sprint Event: An International Gathering to Accelerate Creative Solutions and Design Thinking',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_kediri',
      'prodi'       => 'D3 Manajemen Informatika (Kediri)',
      'ketua'       => 'Leo Vance',
      'judul'       => 'East Java Web Development Competency Cup',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_lumajang',
      'prodi'       => 'D3 Manajemen Informatika (Lumajang)',
      'ketua'       => 'Sophia Rivers',
      'judul'       => 'Lumajang Smart City Hackathon & Digital Transformation',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd2_ppls',
      'prodi'       => 'D2 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Marcus Brody',
      'judul'       => 'Polinema Internal UI/UX Competition and Creative Showcase',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'lokal',
      'tingkat'     => 'Lokal',
      'tingkat_class' => 'tingkat-lokal',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 's2_rekayasa_teknologi_informasi',
      'prodi'       => 'S2 Rekayasa Teknologi Informasi',
      'ketua'       => 'Elena Rostova',
      'judul'       => 'International Conference on Applied IT: Best Paper and Presentation Award',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Lucas Thorne',
      'judul'       => 'National Cyber Security Capture The Flag Competition',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_sistem_informasi_bisnis',
      'prodi'       => 'D4 Sistem Informasi Bisnis',
      'ketua'       => 'Chloe Vance',
      'judul'       => 'Business Plan Competition at Universitas Brawijaya',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Ethan Hunt',
      'judul'       => 'Indonesian Robot Contest: Autonomous Division Championship',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd3_mi_kediri',
      'prodi'       => 'D3 Manajemen Informatika (Kediri)',
      'ketua'       => 'Natasha Romanoff',
      'judul'       => 'National Mobile App Innovation Showcase',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'nasional',
      'tingkat'     => 'Nasional',
      'tingkat_class' => 'tingkat-nasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 's2_rekayasa_teknologi_informasi',
      'prodi'       => 'S2 Rekayasa Teknologi Informasi',
      'ketua'       => 'Bruce Banner',
      'judul'       => 'IEEE Big Data Analytics Challenge: Predictive Modeling Category',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => false,
    ],
    [
      'prodi_raw'   => 'd4_teknik_informatika',
      'prodi'       => 'D4 Teknik Informatika',
      'ketua'       => 'Tony Stark',
      'judul'       => 'Global AI Hackathon: Generative Agents Division Grand Prize',
      'tahun'       => '2025',
      'juara_raw'   => 'juara_1',
      'juara'       => 'Juara 1',
      'juara_class' => 'juara-1',
      'tingkat_raw' => 'internasional',
      'tingkat'     => 'Internasional',
      'tingkat_class' => 'tingkat-internasional',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd2_ppls',
      'prodi'       => 'D2 Pengembangan Piranti Lunak Situs',
      'ketua'       => 'Steve Rogers',
      'judul'       => 'Polinema Web Design Competition: Modern Web Showcase',
      'tahun'       => '2023',
      'juara_raw'   => 'juara_2',
      'juara'       => 'Juara 2',
      'juara_class' => 'juara-2',
      'tingkat_raw' => 'lokal',
      'tingkat'     => 'Lokal',
      'tingkat_class' => 'tingkat-lokal',
      'url'         => '#',
      'is_pkm'      => true,
    ],
    [
      'prodi_raw'   => 'd3_mi_lumajang',
      'prodi'       => 'D3 Manajemen Informatika (Lumajang)',
      'ketua'       => 'Peter Parker',
      'judul'       => 'Jember Game Development Expo: Indie Game Showcase',
      'tahun'       => '2024',
      'juara_raw'   => 'juara_3',
      'juara'       => 'Juara 3',
      'juara_class' => 'juara-3',
      'tingkat_raw' => 'regional',
      'tingkat'     => 'Regional',
      'tingkat_class' => 'tingkat-regional',
      'url'         => '#',
      'is_pkm'      => false,
    ]
  ];

  // Dynamically set fallback URLs default-1 to default-N matching the exact row index
  foreach ($mock_data as $i => &$item) {
    $mock_index = $i + 1;
    $item['url'] = home_url('/?default_achievement=default-' . $mock_index);
  }
  unset($item);

  // Perform in-memory PHP filtering
  $filtered = [];
  foreach ($mock_data as $item) {
    if (!empty($f_prodi) && $item['prodi_raw'] !== $f_prodi) {
      continue;
    }
    if (!empty($f_tahun) && $item['tahun'] !== $f_tahun) {
      continue;
    }
    if (!empty($f_juara) && $item['juara_raw'] !== $f_juara) {
      continue;
    }
    if (!empty($f_tingkat) && $item['tingkat_raw'] !== $f_tingkat) {
      continue;
    }

    if (!empty($f_search)) {
      $match = false;
      if (stripos($item['judul'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['ketua'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['tahun'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['prodi'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['juara'], $f_search) !== false) {
        $match = true;
      }
      if (stripos($item['tingkat'], $f_search) !== false) {
        $match = true;
      }
      if (!$match) {
        continue;
      }
    }

    $filtered[] = $item;
  }

  // In-memory pagination
  $total_count = count($filtered);
  $max_pages = ceil($total_count / $posts_per_page);
  $max_pages = $max_pages > 0 ? $max_pages : 1;

  $start_index = ($paged - 1) * $posts_per_page;
  $paginated_rows = array_slice($filtered, $start_index, $posts_per_page);

  return [
    'rows'      => $paginated_rows,
    'max_pages' => $max_pages,
    'is_mock'   => true,
  ];
}

function webjti_get_achievement_badges($post_id = null, $achievement = null) {
  $juara_labels = [
    'juara_1'   => 'Juara 1',
    'juara_2'   => 'Juara 2',
    'juara_3'   => 'Juara 3',
    'harapan_1' => 'Harapan 1',
    'harapan_2' => 'Harapan 2',
    'finalis'   => 'Finalis',
  ];

  $tingkat_labels = [
    'internasional' => 'Internasional',
    'nasional'      => 'Nasional',
    'regional'      => 'Regional',
    'lokal'         => 'Lokal',
  ];

  if ($achievement) {
    $tahun_val = $achievement['tahun_prestasi'] ?? '-';
    $juara_val = $achievement['juara'] ?? '-';
    $tingkat_val = $achievement['tingkat'] ?? '-';
  } else {
    $post_id = $post_id ?: get_the_ID();
    $tahun_val = get_field('achievement_year', $post_id) ?: get_field('tahun_prestasi', $post_id) ?: '-';
    $juara_val = get_field('rank', $post_id) ?: get_field('juara', $post_id) ?: '-';
    $tingkat_val = get_field('level', $post_id) ?: get_field('tingkat', $post_id) ?: '-';
  }

  $juara_lbl = $juara_labels[$juara_val] ?? $juara_val;
  $juara_cls = $juara_val === '-' ? '' : str_replace('_', '-', $juara_val);

  $tingkat_lbl = $tingkat_labels[$tingkat_val] ?? $tingkat_val;
  $tingkat_cls = $tingkat_val === '-' ? '' : 'tingkat-' . $tingkat_val;

  return [
    'tahun'         => $tahun_val,
    'juara'         => $juara_lbl,
    'juara_class'   => $juara_cls,
    'tingkat'       => $tingkat_lbl,
    'tingkat_class' => $tingkat_cls,
  ];
}

/* ========================================
   GET FILTERED INFORMATION (NEWS, ANNOUNCEMENT, EVENT)
======================================== */

function webjti_get_filtered_information($type = 'all', $search = '', $paged = 1, $posts_per_page = 6) {
  $type = strtolower($type);
  $search = trim($search);
  
  $meta_query = [];
  if ($type !== 'all' && $type !== 'semua' && !empty($type)) {
    $category_map = [
      'berita' => 'news',
      'pengumuman' => 'announcement',
      'agenda' => 'event'
    ];
    $acf_value = $category_map[$type] ?? $type;
    $meta_query[] = [
      'key' => 'category',
      'value' => $acf_value,
      'compare' => '='
    ];
  }
  
  $args = [
    'post_type' => 'information',
    'posts_per_page' => -1, // Query all to handle fallback combination in memory
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
  ];
  
  if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
  }
  
  if (!empty($search)) {
    $args['s'] = $search;
  }
  
  $query = new WP_Query($args);
  $real_posts = [];
  
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $real_posts[] = webjti_format_news_post();
    }
    wp_reset_postdata();
  }
  
  // Decide whether to merge with defaults/fallbacks
  $show_defaults = !get_theme_mod('jti_disable_default_posts');
  $all_posts = $real_posts;
  
  if ($show_defaults) {
    // 12 Premium high-fidelity default posts
    $default_posts = [
      [
        'id'        => 'default-1',
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'permalink' => home_url('/?default_info=default-1'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => '20 Mei 2026',
        'reading_time' => '5 min',
        'excerpt'   => 'Selamat datang di website resmi Jurusan Teknologi Informasi Politeknik Negeri Malang.'
      ],
      [
        'id'        => 'default-2',
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'permalink' => home_url('/?default_info=default-2'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.png',
        'date'      => '19 Mei 2026',
        'reading_time' => '3 min',
        'excerpt'   => 'Informasi mengenai pelaksanaan registrasi ulang mahasiswa untuk semester ganjil mendatang.'
      ],
      [
        'id'        => 'default-3',
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'permalink' => home_url('/?default_info=default-3'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => '18 Mei 2026',
        'reading_time' => '6 min',
        'excerpt'   => 'Jurusan Teknologi Informasi menyelenggarakan workshop kurikulum bersama para pakar industri.'
      ],
      [
        'id'        => 'default-4',
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'permalink' => home_url('/?default_info=default-4'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.png',
        'date'      => '17 Mei 2026',
        'reading_time' => '4 min',
        'excerpt'   => 'Telah dibuka penerimaan mahasiswa baru jalur kelas kerja sama industri untuk tahun ajaran ini.'
      ],
      [
        'id'        => 'default-5',
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'permalink' => home_url('/?default_info=default-5'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.png',
        'date'      => '16 Mei 2026',
        'reading_time' => '7 min',
        'excerpt'   => 'Prestasi membanggakan kembali diraih oleh JTI di tingkat nasional sebagai jurusan berkinerja terbaik.'
      ],
      [
        'id'        => 'default-6',
        'title'     => 'PLAY IT 2026 Secara Resmi Dibuka dengan Antusiasme yang Luar Biasa',
        'permalink' => home_url('/?default_info=default-6'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Event tahunan PLAY IT 2026 resmi dibuka dengan berbagai rangkaian kegiatan menarik seperti hackathon dan seminar.'
      ],
      [
        'id'        => 'default-7',
        'title'     => 'JTI Memperkenalkan Program Inovasi Lingkungan Baru',
        'permalink' => home_url('/?default_info=default-7'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'JTI meluncurkan inisiatif kampus hijau terbaru untuk mengurangi emisi karbon di seluruh gedung perkuliahan.'
      ],
      [
        'id'        => 'default-8',
        'title'     => 'Mahasiswa JTI Gelar Pengabdian Masyarakat di Desa',
        'permalink' => home_url('/?default_info=default-8'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Program kerja bakti mahasiswa JTI membantu pembangunan infrastruktur digital di desa-desa terpencil.'
      ],
      [
        'id'        => 'default-9',
        'title'     => 'Dosen JTI Publikasikan Penelitian di Jurnal Internasional',
        'permalink' => home_url('/?default_info=default-9'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Penelitian inovatif dosen JTI mengenai integrasi AI dan IoT diakui di kancah ilmiah internasional.'
      ],
      [
        'id'        => 'default-10',
        'title'     => 'Mahasiswa JTI Adakan Workshop Teknologi untuk Pelajar Kota',
        'permalink' => home_url('/?default_info=default-10'),
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Workshop coding gratis diselenggarakan untuk pelajar SMA guna mengenalkan dasar-dasar pemrograman.'
      ],
      [
        'id'        => 'default-11',
        'title'     => 'PLAY IT 2026 Resmi Dibuka dengan Antusiasme Tinggi',
        'permalink' => home_url('/?default_info=default-11'),
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => '15 April 2026',
        'reading_time' => '8 min',
        'excerpt'   => 'Ratusan peserta dari seluruh Indonesia berkumpul untuk bersaing di ajang hackathon PLAY IT 2026.'
      ],
      [
        'id'        => 'default-12',
        'title'     => 'JTI Menyelenggarakan Hackathon Tingkat Nasional',
        'permalink' => home_url('/?default_info=default-12'),
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => '14 April 2026',
        'reading_time' => '9 min',
        'excerpt'   => 'Kompetisi hackathon bergengsi dengan total hadiah puluhan juta rupiah resmi dibuka untuk mahasiswa aktif.'
      ],
    ];
    
    // Filter defaults in PHP memory
    $filtered_defaults = [];
    foreach ($default_posts as $dp) {
      // Check category match
      if ($type !== 'all' && $type !== 'semua' && !empty($type)) {
        if (strtolower($dp['category']) !== strtolower($type)) {
          continue;
        }
      }
      
      // Check search match
      if (!empty($search)) {
        $match = false;
        if (stripos($dp['title'], $search) !== false) {
          $match = true;
        }
        if (stripos($dp['excerpt'], $search) !== false) {
          $match = true;
        }
        if (!$match) {
          continue;
        }
      }
      
      $filtered_defaults[] = $dp;
    }
    
    // Combine real posts and default posts (avoiding duplicates if title is identical)
    $real_titles = array_map('strtolower', array_column($real_posts, 'title'));
    foreach ($filtered_defaults as $fd) {
      if (!in_array(strtolower($fd['title']), $real_titles)) {
        $all_posts[] = $fd;
      }
    }
  }
  
  // Paginate the combined posts
  $total_count = count($all_posts);
  $max_pages = ceil($total_count / $posts_per_page);
  $max_pages = $max_pages > 0 ? $max_pages : 1;
  
  $start_index = ($paged - 1) * $posts_per_page;
  $paginated_posts = array_slice($all_posts, $start_index, $posts_per_page);
  
  return [
    'posts' => $paginated_posts,
    'max_pages' => $max_pages,
    'total_posts' => $total_count,
  ];
}

/* ========================================
   GET FALLBACK ACHIEVEMENT DATA
   ======================================== */
function webjti_get_fallback_achievement_data($default_id = 'default-1') {
  $mock_items = [
    1 => ['ketua' => 'Evan Carlisle', 'judul' => 'InnovateTech Challenge 2024: Pioneering the Future of Technology and Innovation', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'D4 Pengembangan Piranti Lunak Situs', 'is_pkm' => false],
    2 => ['ketua' => 'Liam Thornton', 'judul' => 'The Ultimate Coding Challenge: Test Your Skills and Push Your Limits', 'tahun' => '2025', 'juara' => 'juara_2', 'tingkat' => 'internasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    3 => ['ketua' => 'Jasper Quinn', 'judul' => 'Innovators Hackathon: A Creative Challenge to Transform Ideas into Reality', 'tahun' => '2023', 'juara' => 'juara_3', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    4 => ['ketua' => 'Nina Caldwell', 'judul' => 'Annual Creative Writing Contest for Aspiring Authors', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => true],
    5 => ['ketua' => 'Owen Mercer', 'judul' => 'Innovative Tech Startup Pitch Competition', 'tahun' => '2024', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    6 => ['ketua' => 'Zara Whitman', 'judul' => 'Exciting Photography Showdown and Exhibition', 'tahun' => '2025', 'juara' => 'juara_2', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => true],
    7 => ['ketua' => 'Maya Ellison', 'judul' => 'Worldwide Creative Sprint Contest: A Global Event Showcasing Innovative Ideas and Rapid Prototyping', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    8 => ['ketua' => 'Maya Ellison', 'judul' => 'Global Innovation Design Sprint Event: An International Gathering to Accelerate Creative Solutions and Design Thinking', 'tahun' => '2025', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    9 => ['ketua' => 'Leo Vance', 'judul' => 'East Java Web Development Competency Cup', 'tahun' => '2024', 'juara' => 'juara_2', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Kediri)', 'is_pkm' => false],
    10 => ['ketua' => 'Sophia Rivers', 'judul' => 'Lumajang Smart City Hackathon & Digital Transformation', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Lumajang)', 'is_pkm' => false],
    11 => ['ketua' => 'Marcus Brody', 'judul' => 'Polinema Internal UI/UX Competition and Creative Showcase', 'tahun' => '2023', 'juara' => 'juara_3', 'tingkat' => 'lokal', 'prodi' => 'D2 Pengembangan Piranti Lunak Situs', 'is_pkm' => false],
    12 => ['ketua' => 'Elena Rostova', 'judul' => 'International Conference on Applied IT: Best Paper and Presentation Award', 'tahun' => '2025', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'S2 Rekayasa Teknologi Informasi', 'is_pkm' => false],
    13 => ['ketua' => 'Lucas Thorne', 'judul' => 'National Cyber Security Capture The Flag Competition', 'tahun' => '2024', 'juara' => 'juara_2', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    14 => ['ketua' => 'Chloe Vance', 'judul' => 'Business Plan Competition at Universitas Brawijaya', 'tahun' => '2023', 'juara' => 'juara_1', 'tingkat' => 'regional', 'prodi' => 'D4 Sistem Informasi Bisnis', 'is_pkm' => false],
    15 => ['ketua' => 'Ethan Hunt', 'judul' => 'Indonesian Robot Contest: Autonomous Division Championship', 'tahun' => '2025', 'juara' => 'juara_3', 'tingkat' => 'nasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => false],
    16 => ['ketua' => 'Natasha Romanoff', 'judul' => 'National Mobile App Innovation Showcase', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'nasional', 'prodi' => 'D3 Manajemen Informatika (Kediri)', 'is_pkm' => false],
    17 => ['ketua' => 'Bruce Banner', 'judul' => 'IEEE Big Data Analytics Challenge: Predictive Modeling Category', 'tahun' => '2024', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'S2 Rekayasa Teknologi Informasi', 'is_pkm' => false],
    18 => ['ketua' => 'Tony Stark', 'judul' => 'Global AI Hackathon: Generative Agents Division Grand Prize', 'tahun' => '2025', 'juara' => 'juara_1', 'tingkat' => 'internasional', 'prodi' => 'D4 Teknik Informatika', 'is_pkm' => true],
    19 => ['ketua' => 'Steve Rogers', 'judul' => 'Polinema Web Design Competition: Modern Web Showcase', 'tahun' => '2023', 'juara' => 'juara_2', 'tingkat' => 'lokal', 'prodi' => 'D2 Pengembangan Piranti Lunak Situs', 'is_pkm' => true],
    20 => ['ketua' => 'Peter Parker', 'judul' => 'Jember Game Development Expo: Indie Game Showcase', 'tahun' => '2024', 'juara' => 'juara_3', 'tingkat' => 'regional', 'prodi' => 'D3 Manajemen Informatika (Lumajang)', 'is_pkm' => false],
  ];

  $index = 1;
  if (preg_match('/default-(\d+)/', $default_id, $matches)) {
    $index = intval($matches[1]);
  }
  if (!isset($mock_items[$index])) {
    $index = 1;
  }
  $item = $mock_items[$index];

  $cover_image_index = (($index - 1) % 5) + 1;
  $gallery = [
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . $cover_image_index . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index) % 5) + 1) . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index + 1) % 5) + 1) . '.png'],
    ['url' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . ((($cover_image_index + 2) % 5) + 1) . '.png']
  ];

  $fallback = [
    'id' => 'default-' . $index,
    'judul_kompetisi' => $item['judul'],
    'juara' => $item['juara'],
    'tingkat' => $item['tingkat'],
    'tanggal' => '20 Mei ' . $item['tahun'],
    'tahun_prestasi' => $item['tahun'],
    'penyelenggara' => 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',
    'lokasi' => 'Politeknik Negeri Malang',
    'bidang' => $item['is_pkm'] ? 'Program Kreativitas Mahasiswa (PKM)' : 'Rekayasa Perangkat Lunak & IT',
    'jumlah_peserta' => '150+ Tim Seluruh Indonesia',
    'deskripsi' => 'Prestasi membanggakan kembali dipersembahkan oleh mahasiswa Jurusan Teknologi Informasi Politeknik Negeri Malang. Dalam ajang bergengsi ' . $item['judul'] . ', tim berhasil bersaing ketat dengan ratusan universitas terkemuka lainnya dan dinobatkan sebagai penerima penghargaan juara. Solusi inovatif yang ditawarkan berhasil menarik perhatian dewan juri.',
    'gallery' => $gallery,
  ];

  // Cycle the placeholders based on index to make them look realistic
  $pembimbing_photo = ($index % 2 === 0) ? 'pak yoga.png' : 'bu mungki.png';
  $pembimbing_name  = ($index % 2 === 0) ? 'Hariyady, S.Kom., M.T.' : 'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.';
  
  $ketua_photo = ($index % 2 === 0) ? 'bu devi.png' : 'pak hendra.png';
  
  $anggota_1_photo = ($index % 2 === 0) ? 'bu ana.png' : 'bu devi.png';
  $anggota_1_name  = ($index % 2 === 0) ? 'Sarah Connor' : 'Nina Caldwell';
  
  $anggota_2_photo = ($index % 2 === 0) ? 'bu mungki.png' : 'bu ana.png';
  $anggota_2_name  = ($index % 2 === 0) ? 'Chloe Vance' : 'Zara Whitman';

  $members = [
    // 1. Dosen Pembimbing (Top row left/right)
    [
      'name' => $pembimbing_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $pembimbing_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'pembimbing',
      'role_label' => 'Dosen Pembimbing',
      'identifier' => 'NIP: 198001012005011' . str_pad($index, 3, '0', STR_PAD_LEFT)
    ],
    // 2. Ketua Tim (Top row left/right)
    [
      'name' => $item['ketua'],
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $ketua_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'ketua',
      'role_label' => 'Ketua Tim',
      'identifier' => 'NIM: 2141720' . str_pad($index, 3, '0', STR_PAD_LEFT)
    ],
    // 3. Anggota Tim 1 (Bottom row)
    [
      'name' => $anggota_1_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $anggota_1_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'anggota_1',
      'role_label' => 'Anggota Tim',
      'identifier' => 'NIM: 2141762025'
    ],
    // 4. Anggota Tim 2 (Bottom row)
    [
      'name' => $anggota_2_name,
      'photo' => get_template_directory_uri() . '/assets/images/placeholders/' . $anggota_2_photo,
      'linkedin' => 'https://linkedin.com/',
      'role' => 'anggota_2',
      'role_label' => 'Anggota Tim',
      'identifier' => 'NIM: 2141762026'
    ]
  ];

  $related = [];
  $next_1 = ($index % 20) + 1;
  $next_2 = (($index + 1) % 20) + 1;

  foreach ([$next_1, $next_2] as $idx) {
    if (isset($mock_items[$idx])) {
      $r_item = $mock_items[$idx];
      $related[] = [
        'id' => 'default-' . $idx,
        'url' => home_url('/?default_achievement=default-' . $idx),
        'title' => $r_item['judul'],
        'excerpt' => 'Prestasi tingkat ' . ucfirst($r_item['tingkat']) . ' yang diraih oleh tim yang diketuai oleh ' . $r_item['ketua'] . ' pada tahun ' . $r_item['tahun'] . '.',
        'date' => '20 Mei ' . $r_item['tahun'],
        'image' => get_template_directory_uri() . '/assets/images/placeholders/Hero Section ' . (($idx % 5) + 1) . '.png'
      ];
    }
  }

  return [
    'achievement' => $fallback,
    'members' => $members,
    'gallery' => $gallery,
    'related' => $related
  ];
}

/* ========================================
   GET FALLBACK INFORMATION DATA
   ======================================== */
function webjti_get_fallback_information_data($default_id = 'default-1') {
  $defaults = [
      'default-1' => [
        'title'     => 'Selamat Datang di Jurusan Teknologi Informasi POLINEMA',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 1.png',
        'date'      => '20 Mei 2026',
        'reading_time' => '5',
        'content'   => '
            <p class="lead">Selamat datang di website resmi Jurusan Teknologi Informasi (JTI) Politeknik Negeri Malang. Sebagai salah satu pilar utama pendidikan vokasi teknologi di Indonesia, JTI berkomitmen untuk mencetak lulusan yang tidak hanya unggul secara akademis, namun juga memiliki kesiapan kerja yang matang dalam menghadapi gelombang transformasi digital global saat ini.</p>
            
            <h2>Visi & Misi Pengembangan</h2>
            <p>JTI POLINEMA memegang teguh komitmen untuk menjadi pusat pendidikan vokasi di bidang teknologi informasi yang diakui secara nasional maupun internasional. Kami mengintegrasikan kurikulum berbasis kompetensi yang dirancang selaras dengan kebutuhan nyata dunia usaha dan dunia industri (DUDI).</p>
            
            <blockquote>
                "Inovasi tiada henti adalah kunci utama kami. Di JTI, mahasiswa dibimbing untuk tidak sekadar menjadi pengguna teknologi, melainkan kreator dan inovator yang mampu memberikan solusi nyata atas kompleksitas permasalahan industri."
                <cite>— Kepala Jurusan Teknologi Informasi POLINEMA</cite>
            </blockquote>
            
            <h2>Program Studi Unggulan Kami</h2>
            <p>Untuk menunjang akselerasi karier mahasiswa di sektor teknologi, kami menyelenggarakan beberapa program studi sarjana terapan (D4) yang telah terakreditasi sangat baik, di antaranya:</p>
            <ul>
                <li><strong>D4 Teknik Informatika:</strong> Berfokus pada pengembangan rekayasa perangkat lunak skala enterprise, kecerdasan buatan (AI), keamanan siber, dan komputasi awan (Cloud Computing).</li>
                <li><strong>D4 Sistem Informasi Bisnis:</strong> Memadukan keahlian analitis teknologi informasi dengan strategi manajemen bisnis modern untuk menghasilkan analis sistem dan technopreneur andal.</li>
                <li><strong>D2 Fast Track (Jalur Cepat):</strong> Program akselerasi yang dirancang khusus bersinergi erat dengan Sekolah Menengah Kejuruan (SMK) mitra untuk menghasilkan asisten desainer perangkat lunak dalam waktu singkat.</li>
            </ul>

            <h2>Fasilitas Laboratorium Modern</h2>
            <p>Proses pembelajaran praktis didukung penuh oleh keberadaan belasan laboratorium komputer berspesifikasi tinggi yang disesuaikan dengan fokus keahlian masing-masing bidang minat:</p>
            <ol>
                <li><strong>Laboratorium Database & Enterprise:</strong> Tempat eksplorasi administrasi basis data skala besar dan arsitektur enterprise.</li>
                <li><strong>Laboratorium Jaringan & Keamanan Siber:</strong> Difasilitasi perangkat Cisco premium untuk pembelajaran routing, switching, dan pertahanan siber.</li>
                <li><strong>Laboratorium Game & Mobile Apps:</strong> Laboratorium khusus pengembangan game multi-platform dan aplikasi mobile native.</li>
            </ol>
            
            <p>Melalui sinergi erat kurikulum berkualitas, fasilitas mutakhir, serta dukungan dosen praktisi tersertifikasi internasional, JTI POLINEMA siap memandu langkah Anda menuju masa depan cemerlang di industri teknologi informasi dunia.</p>
        '
      ],
      'default-2' => [
        'title'     => 'Pengumuman Pelaksanaan Registrasi Ulang Semester Ganjil',
        'category'  => 'Pengumuman',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 2.png',
        'date'      => '19 Mei 2026',
        'reading_time' => '3',
        'content'   => '
            <p class="lead">Diberitahukan kepada seluruh mahasiswa aktif Jurusan Teknologi Informasi Politeknik Negeri Malang bahwa pelaksanaan proses administrasi dan daftar ulang akademik untuk Semester Ganjil Tahun Ajaran 2026/2027 akan segera dibuka. Proses ini wajib diselesaikan secara tertib sesuai lini masa yang ditetapkan.</p>
            
            <h2>Alur Proses Registrasi Ulang</h2>
            <p>Untuk mempermudah administrasi Anda, proses daftar ulang dibagi menjadi tiga tahapan utama yang terintegrasi secara daring (online):</p>
            <ol>
                <li><strong>Validasi Data Mahasiswa:</strong> Lakukan login pada Sistem Informasi Akademik (SIAKAD) POLINEMA dan pastikan seluruh data profil, alamat, serta riwayat akademis Anda sudah terbarui dengan benar.</li>
                <li><strong>Pembayaran Uang Kuliah Tunggal (UKT):</strong> Lakukan pembayaran tagihan semester ganjil melalui bank mitra resmi (Bank Mandiri, BRI, BNI, atau BTN) menggunakan nomor induk mahasiswa (NIM) sebagai kode pembayaran.</li>
                <li><strong>Unggah Bukti & Persetujuan KRS:</strong> Unggah bukti transfer pembayaran UKT ke sistem SIAKAD untuk membuka akses pengisian Kartu Rencana Studi (KRS). Segera hubungi Dosen Pembina Akademik (DPA) Anda untuk melakukan bimbingan rencana kelas dan menyetujui KRS Anda.</li>
            </ol>
            
            <blockquote>
                <strong>PENTING:</strong> Kelalaian atau keterlambatan dalam melakukan registrasi ulang tanpa pemberitahuan resmi dan dispensasi tertulis dari pihak jurusan dapat menyebabkan status akademik mahasiswa dinonaktifkan secara otomatis untuk semester berjalan.
            </blockquote>
            
            <h2>Dokumen Syarat Wajib</h2>
            <p>Pastikan Anda telah memindai (scan) beberapa berkas berikut untuk diunggah dalam format PDF dengan ukuran maksimal 1MB:</p>
            <ul>
                <li>Kartu Tanda Mahasiswa (KTM) aktif.</li>
                <li>Slip/Bukti Pembayaran UKT Semester Ganjil asli dari bank.</li>
                <li>Kartu Hasil Studi (KHS) Semester Genap sebelumnya yang telah ditandatangani DPA.</li>
            </ul>
            
            <p>Pertanyaan lebih lanjut mengenai kendala teknis pembayaran atau sistem SIAKAD dapat ditanyakan langsung ke loket Administrasi Jurusan JTI pada jam kerja operasional (Senin s.d. Jumat pukul 08.00 - 15.30 WIB).</p>
        '
      ],
      'default-3' => [
        'title'     => 'Workshop Pengembangan Kurikulum Berbasis Industri JTI',
        'category'  => 'Agenda',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 3.png',
        'date'      => '18 Mei 2026',
        'reading_time' => '6',
        'content'   => '
            <p class="lead">Dalam rangka meningkatkan relevansi lulusan dengan perkembangan industri digital yang sangat dinamis, Jurusan Teknologi Informasi menyelenggarakan Workshop Tahunan Revitalisasi Kurikulum. Agenda penting ini mempertemukan jajaran akademisi internal dengan belasan praktisi serta pimpinan teknologi (CTO) dari berbagai perusahaan terkemuka tanah air.</p>
            
            <h2>Tujuan Utama Sinkronisasi</h2>
            <p>Kegiatan ini difokuskan pada perancangan kurikulum berbasis <em>Project-Based Learning</em> (PBL). Model ini memungkinkan mahasiswa belajar memecahkan studi kasus riil yang dialami oleh mitra industri langsung di dalam ruang kelas dengan bimbingan dosen dan mentor industri terkait.</p>
            
            <blockquote>
                "Kesenjangan kompetensi (skill gap) antara dunia kampus dan industri harus terus ditekan. Kurikulum baru JTI ini dirancang sangat fleksibel, mengadopsi tren teknologi terkini seperti AI Engineering, Cloud DevOps, dan Data Analytics."
                <cite>— Direktur Teknologi (CTO) Perusahaan Teknologi Finansial Mitra JTI</cite>
            </blockquote>
            
            <h2>Topik Pembahasan Strategis</h2>
            <p>Terdapat tiga pilar utama yang dibahas secara intensif dalam sesi diskusi kelompok terpumpun (FGD) workshop kali ini:</p>
            <ul>
                <li><strong>Integrasi Kecerdasan Buatan (AI):</strong> Penyusunan silabus pemograman dasar dan lanjut yang mulai menyisipkan metodologi prompt engineering serta pemanfaatan LLM secara bijak dan etis.</li>
                <li><strong>Standarisasi Cloud Computing:</strong> Kesepakatan penyelarasan materi praktikum jaringan dengan sertifikasi global seperti AWS Academy dan Google Cloud Education.</li>
                <li><strong>Metodologi Agile & Scrum:</strong> Penerapan simulasi kerja tim Scrum pada tugas proyek akhir mahasiswa untuk membiasakan mereka dengan workflow kolaborasi industri modern.</li>
            </ul>
            
            <h2>Rangkaian Lini Masa Agenda</h2>
            <p>Workshop kurikulum ini berlangsung secara hibrida selama dua hari penuh:</p>
            <ol>
                <li><strong>Hari ke-1 (Sesi Panel Utama):</strong> Pemaparan tren serapan industri kerja oleh kementerian terkait dan presentasi masukan dari dewan penasihat industri JTI.</li>
                <li><strong>Hari ke-2 (FGD Paralel Program Studi):</strong> Pemecahan forum ke dalam masing-masing prodi untuk merevisi daftar mata kuliah, deskripsi silabus, dan instrumen penilaian proyek mahasiswa.</li>
            </ol>
            
            <p>Hasil dari revitalisasi kurikulum ini diharapkan dapat diimplementasikan sepenuhnya mulai tahun akademik ajaran baru semester ganjil mendatang demi melahirkan talenta digital yang siap berkontribusi langsung sejak hari pertama bekerja.</p>
        '
      ],
      'default-4' => [
        'title'     => 'Penerimaan Mahasiswa Baru Jalur Kerja Sama JTI',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 4.png',
        'date'      => '17 Mei 2026',
        'reading_time' => '4',
        'content'   => '
            <p class="lead">Kabar gembira bagi para calon mahasiswa baru! Jurusan Teknologi Informasi Politeknik Negeri Malang resmi membuka seleksi penerimaan mahasiswa baru jalur khusus kelas kerja sama industri. Program ini dirancang strategis untuk memberikan jaminan pengalaman kerja nyata dan kesempatan magang eksklusif di perusahaan raksasa multinasional.</p>
            
            <h2>Mengapa Memilih Kelas Kerja Sama?</h2>
            <p>Berbeda dengan kelas reguler pada umumnya, mahasiswa kelas kerja sama industri akan mendapatkan kurikulum khusus yang disusun bersama oleh tim JTI POLINEMA dan pimpinan tim engineering perusahaan mitra. Selain itu, mentor-mentor teknis dari industri akan terlibat langsung mengajar beberapa sesi kelas praktikum.</p>
            
            <blockquote>
                "Program kelas kerja sama ini adalah jalur ekspres berkarir di industri tech. Mahasiswa tidak hanya belajar teori, tetapi langsung magang berbayar dan berkesempatan direkrut langsung begitu lulus tanpa melalui proses seleksi umum yang panjang."
                <cite>— VP of Talent Acquisition Mitra Korporat JTI</cite>
            </blockquote>
            
            <h2>Mitra Perusahaan Unggulan</h2>
            <p>Pada periode penerimaan tahun ini, JTI membuka kelas khusus yang berkolaborasi erat dengan beberapa institusi terpercaya:</p>
            <ul>
                <li><strong>Korporasi Telekomunikasi Nasional:</strong> Berfokus pada keahlian infrastruktur jaringan seluler 5G, keamanan siber, dan IoT skala kota pintar.</li>
                <li><strong>Penyedia Layanan Cloud Global:</strong> Pembelajaran mendalam berstandar kurikulum internasional dengan spesialisasi arsitektur cloud server dan virtualisasi data.</li>
                <li><strong>Software House Multinasional:</strong> Berfokus pada akselerasi Full-stack Web Development dan rekayasa perangkat lunak kualitas produksi.</li>
            </ul>

            <h2>Syarat dan Alur Pendaftaran</h2>
            <p>Prosedur pendaftaran dapat dilakukan dengan mudah melalui portal seleksi PMB POLINEMA:</p>
            <ol>
                <li><strong>Pendaftaran Online:</strong> Isi formulir lengkap dan unggah nilai rapor semester 1 s.d 5 di situs resmi pendaftaran.</li>
                <li><strong>Ujian Tulis Berbasis Komputer:</strong> Mengikuti tes potensi akademik (TPA), logika pemograman dasar, dan tes kemampuan bahasa Inggris secara mandiri.</li>
                <li><strong>Wawancara User Industri:</strong> Calon mahasiswa yang lolos tes tulis akan diwawancarai langsung oleh perwakilan dari perusahaan mitra terkait kecocokan minat serta motivasi belajar.</li>
            </ol>
            
            <p>Segera daftarkan diri Anda dan raih kesempatan emas belajar langsung dari pakar industri terbaik serta bangun pondasi karier global Anda bersama kelas kerja sama JTI POLINEMA!</p>
        '
      ],
      'default-5' => [
        'title'     => 'JTI Meraih Penghargaan Jurusan Terbaik Tahun Ini',
        'category'  => 'Berita',
        'image'     => get_template_directory_uri() . '/assets/images/placeholders/Hero Section 5.png',
        'date'      => '16 Mei 2026',
        'reading_time' => '7',
        'content'   => '
            <p class="lead">Prestasi gemilang kembali ditorehkan oleh segenap civitas akademika Jurusan Teknologi Informasi POLINEMA. JTI secara resmi dinobatkan sebagai "Jurusan Kinerja Akademik Terbaik Tahun Ini" dalam malam penganugerahan Dies Natalis Politeknik Negeri Malang atas kontribusi luar biasa dalam riset terapan dan penyerapan lulusan industri tertinggi.</p>
            
            <h2>Kriteria Utama Penilaian</h2>
            <p>Penghargaan bergengsi ini diraih setelah melalui rangkaian penilaian ketat oleh dewan juri independen yang mengukur kinerja seluruh jurusan di lingkungan kampus. Terdapat beberapa parameter keunggulan mutlak yang berhasil dipenuhi oleh JTI:</p>
            
            <blockquote>
                "Penghargaan ini adalah buah manis dari kerja keras, dedikasi, serta kolaborasi harmonis seluruh dosen, staf kependidikan, serta mahasiswa JTI yang tiada henti berkreasi dan menembus batas prestasi di berbagai ajang nasional."
                <cite>— Sekretaris Jurusan Teknologi Informasi POLINEMA</cite>
            </blockquote>
            
            <h2>Pilar Keunggulan JTI</h2>
            <p>Beberapa poin emas yang melatarbelakangi penganugerahan penghargaan terbaik ini di antaranya:</p>
            <ul>
                <li><strong>Penyerapan Kerja Tercepat:</strong> Berdasarkan data pelacakan lulusan terbaru (tracer study), lebih dari 88% lulusan JTI berhasil mendapatkan pekerjaan layak di sektor teknologi dalam kurun waktu kurang dari 3 bulan pasca kelulusan.</li>
                <li><strong>Riset Terapan Berskala Nasional:</strong> Keberhasilan para dosen JTI memperoleh hibah penelitian kompetitif nasional untuk pengembangan sistem cerdas pertanian presisi dan e-government daerah.</li>
                <li><strong>Prestasi Mahasiswa Internasional:</strong> Kemenangan beruntun tim mahasiswa JTI dalam kompetisi inovasi perangkat lunak tingkat Asia Pasifik dan kompetisi siber nasional.</li>
            </ul>

            <h2>Komitmen Masa Depan</h2>
            <p>Piala penghargaan ini tidak membuat JTI berpuas diri. Justru pencapaian ini dipandang sebagai pemacu semangat untuk terus meningkatkan mutu tridharma perguruan tinggi:</p>
            <ol>
                <li><strong>Peningkatan Kualitas Jurnal:</strong> Menargetkan peningkatan publikasi riset terapan di jurnal bereputasi tinggi Scopus Q1 dan Q2.</li>
                <li><strong>Perluasan Kerja Sama Global:</strong> Menjajaki program gelar ganda (double degree) baru dengan universitas sains terapan terkemuka di Eropa dan Asia Timur.</li>
                <li><strong>Sertifikasi Mahasiswa Internasional:</strong> Memberikan fasilitas subsidi penuh bagi mahasiswa berprestasi untuk mengambil sertifikasi kompetensi industri global (RedHat, Oracle, AWS).</li>
            </ol>
            
            <p>Segenap jajaran pimpinan JTI mengucapkan terima kasih sebesar-besarnya kepada seluruh elemen pendukung, mitra industri, orang tua mahasiswa, serta alumni atas kepercayaan yang senantiasa diberikan demi bersama-sama mewujudkan JTI POLINEMA yang unggul dan mendunia.</p>
        '
      ],
  ];

  if (array_key_exists($default_id, $defaults)) {
    return $defaults[$default_id];
  }
  return $defaults['default-1'];
}