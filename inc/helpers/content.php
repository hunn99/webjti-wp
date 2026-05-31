<?php

/* ========================================
   GET VIDEO SECTION DATA
======================================== */

function webjti_get_video_section_data() {

  $video_url = get_theme_mod('jti_video_url_text', 'https://youtu.be/aJYMCM1aEcA');
  if (empty(trim($video_url))) {
    $video_url = 'https://youtu.be/aJYMCM1aEcA';
  }

  $channel_url = get_theme_mod('jti_video_button_url', 'https://www.youtube.com/@jtipolinema367/featured');
  if (empty(trim($channel_url))) {
    $channel_url = 'https://www.youtube.com/@jtipolinema367/featured';
  }

  $video_id = 'aJYMCM1aEcA';
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
  if (isset($match[1])) {
    $video_id = $match[1];
  }

  // Auto-fallback protection if the saved URL resolved to the deleted/private/old video
  if ($video_id === 'hWqAqix5apI' || $video_id === '7lLigiVgJsE' || $video_id === '3zPFX4DuYt4' || $video_id === 'gT829Qn-8Yk') {
    $video_id = 'aJYMCM1aEcA';
  }

  return [

    'video_id' =>
      $video_id,

    'embed_url' =>
      'https://www.youtube.com/embed/'
      . $video_id
      . '?rel=0&modestbranding=1',

    'channel_url' =>
      $channel_url,

  ];

}

/* ========================================
   GET CAMPUS DATA
======================================== */

function webjti_get_campuses() {
  $campuses = [];
  
  $defaults = [
    [
      'title'   => 'JTI Kampus Utama',
      'address' => 'Jl. Soekarno Hatta No. 9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141',
      'email'   => 'humas@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Lumajang',
      'address' => 'Jl. Raya Klakah No. 123, Kec. Klakah, Kabupaten Lumajang, Jawa Timur 67356',
      'email'   => 'humas.lmj@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Kediri',
      'address' => 'Jl. Veteran No. 45, Mojoroto, Kec. Mojoroto, Kota Kediri, Jawa Timur 64112',
      'email'   => 'humas.kdr@jti.polinema.ac.id',
    ],
    [
      'title'   => 'JTI Kampus Pamekasan',
      'address' => 'Jl. Panglegur No. 8, Panglegur, Kec. Tlanakan, Kabupaten Pamekasan, Jawa Timur 69371',
      'email'   => 'humas.pmk@jti.polinema.ac.id',
    ],
  ];

  for ($i = 1; $i <= 4; $i++) {
    $default = $defaults[$i - 1];
    $title = get_theme_mod("jti_campus_{$i}_title", $default['title']);
    $address = get_theme_mod("jti_campus_{$i}_address", $default['address']);
    $email = get_theme_mod("jti_campus_{$i}_email", $default['email']);
    
    if (!empty(trim($title)) || !empty(trim($address))) {
      $campuses[] = [
        'title'   => empty(trim($title)) ? $default['title'] : $title,
        'address' => empty(trim($address)) ? $default['address'] : $address,
        'email'   => empty(trim($email)) ? $default['email'] : $email,
      ];
    }
  }

  return $campuses;
}

/* ========================================
   GET HISTORY WELCOME SECTION
======================================== */

function webjti_get_history_welcome_data() {
  $title = get_theme_mod('jti_history_welcome_title', 'Sambutan Ketua Jurusan Teknologi Informasi Polinema');
  if (empty(trim($title))) {
    $title = 'Sambutan Ketua Jurusan Teknologi Informasi Polinema';
  }

  $video_url = get_theme_mod('jti_history_welcome_video_url', 'https://youtu.be/aJYMCM1aEcA');
  if (empty(trim($video_url))) {
    $video_url = 'https://youtu.be/aJYMCM1aEcA';
  }

  $video_id = 'aJYMCM1aEcA';
  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
  if (isset($match[1])) {
    $video_id = $match[1];
  }

  if ($video_id === '3zPFX4DuYt4' || $video_id === 'gT829Qn-8Yk' || $video_id === 'hWqAqix5apI' || $video_id === '7lLigiVgJsE') {
    $video_id = 'aJYMCM1aEcA';
  }

  $name = get_theme_mod('jti_history_welcome_name', 'Mungki Astiningrum, ST., M.Kom.');
  if (empty(trim($name))) {
    $name = 'Mungki Astiningrum, ST., M.Kom.';
  }

  $image = get_theme_mod('jti_history_welcome_image', '');
  if (empty(trim($image))) {
    $image = get_template_directory_uri() . '/assets/images/placeholders/bu mungki.png';
  }

  $bg_image = get_theme_mod('jti_history_welcome_bg', '');

  return [
    'title'    => $title,
    'video_id' => $video_id,
    'name'     => $name,
    'image'    => $image,
    'bg_image' => $bg_image,
  ];
}