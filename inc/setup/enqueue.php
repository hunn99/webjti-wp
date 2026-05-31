<?php

/* ========================================
   ENQUEUE STYLES & SCRIPTS
======================================== */

function webjti_enqueue_assets() {

  /* ========================================
     CSS
  ======================================== */

  wp_enqueue_style(
    'webjti-app',
    get_template_directory_uri()
      . '/assets/css/app.css',
    [],
    filemtime(
      get_template_directory()
      . '/assets/css/app.css'
    )
  );

  /* ========================================
     JS - CORE
  ======================================== */

  wp_enqueue_script(
    'webjti-main',
    get_template_directory_uri()
      . '/assets/js/core/main.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/main.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-navigation',
    get_template_directory_uri()
      . '/assets/js/core/navigation.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/navigation.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-api',
    get_template_directory_uri()
      . '/assets/js/core/api.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/core/api.js'
    ),
    true
  );

  /* ========================================
     JS - COMPONENTS
  ======================================== */

  wp_enqueue_script(
    'webjti-slider',
    get_template_directory_uri()
      . '/assets/js/components/slider.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/slider.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-tabs',
    get_template_directory_uri()
      . '/assets/js/components/tabs.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/tabs.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-video-modal',
    get_template_directory_uri()
      . '/assets/js/components/video-modal.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/video-modal.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-gallery-lightbox',
    get_template_directory_uri()
      . '/assets/js/components/gallery-lightbox.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/gallery-lightbox.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-lecturer-card',
    get_template_directory_uri()
      . '/assets/js/components/lecturer-card.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/lecturer-card.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-staff-card',
    get_template_directory_uri()
      . '/assets/js/components/staff-card.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/components/staff-card.js'
    ),
    true
  );

  /* ========================================
     JS - SECTIONS
  ======================================== */

  wp_enqueue_script(
    'webjti-hero-slider',
    get_template_directory_uri()
      . '/assets/js/sections/hero-slider.js',
    [],
    filemtime(
      get_template_directory()
      . '/assets/js/sections/hero-slider.js'
    ),
    true
  );

  wp_enqueue_script(
    'webjti-information',
    get_template_directory_uri()
      . '/assets/js/sections/information.js',
    ['webjti-main'],
    filemtime(
      get_template_directory()
      . '/assets/js/sections/information.js'
    ),
    true
  );

  wp_localize_script(
    'webjti-information',
    'jti_ajax',
    [
      'ajax_url' => admin_url('admin-ajax.php'),
    ]
  );


  wp_enqueue_style(
    'phosphor-regular',
    'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css',
    [],
    '2.1.1'
  );

  wp_enqueue_style(
    'phosphor-fill',
    'https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css',
    [],
    '2.1.1'
  );

  if ( is_singular('lecturer') || isset($_GET['default_lecturer']) ) {
    wp_enqueue_style(
      'jti-lecturer-detail',
      get_template_directory_uri() . '/assets/css/lecturer-detail.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/lecturer-detail.css')
    );
  }

  if ( is_singular('prestasi') || isset($_GET['default_achievement']) ) {
    wp_enqueue_style(
      'jti-achievement-detail',
      get_template_directory_uri() . '/assets/css/sections/achievement-detail.css',
      ['webjti-app'],
      filemtime(get_template_directory() . '/assets/css/sections/achievement-detail.css')
    );
  }

}

add_action(
  'wp_enqueue_scripts',
  'webjti_enqueue_assets'
);

function webjti_enqueue_fonts() {

    wp_enqueue_style(
        'webjti-google-fonts',
        'https://fonts.googleapis.com/css2?family=Chivo+Mono:wght@100..900&display=swap',
        [],
        null
    );

}

add_action('wp_enqueue_scripts', 'webjti_enqueue_fonts');