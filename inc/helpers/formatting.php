<?php

/* ========================================
   FORMAT DATE
======================================== */

function webjti_format_date($date) {

  return date_i18n(
    'd F Y',
    strtotime($date)
  );

}

/* ========================================
   READING TIME
======================================== */

function webjti_reading_time($content) {

  $word_count =
    str_word_count(
      wp_strip_all_tags($content)
    );

  $minutes =
    ceil($word_count / 200);

  return $minutes . ' min read';

}

/* ========================================
   FORMAT NEWS POST
======================================== */

function webjti_format_news_post($post_id = null) {

  $post_id =
    $post_id ?: get_the_ID();

  $category_value = function_exists('get_field') ? get_field('category', $post_id) : '';
  $category_map = [
    'news'         => 'Berita',
    'announcement' => 'Pengumuman',
    'event'        => 'Agenda',
  ];
  $category_name = $category_map[$category_value] ?? 'Berita';

  $content =
    strip_tags(
      get_post_field(
        'post_content',
        $post_id
      )
    );

  $word_count =
    str_word_count($content);

  $reading_time =
    max(
      1,
      ceil($word_count / 200)
    );

  $excerpt =
    get_the_excerpt($post_id);

  if (!$excerpt) {

    $excerpt =
      wp_trim_words(
        $content,
        50,
        '...'
      );

  }

  return [

    'id' =>
      $post_id,

    'title' =>
      get_the_title($post_id),

    'excerpt' =>
      $excerpt,

    'permalink' =>
      get_permalink($post_id),

    'category' =>
      $category_name,

    'image' =>
      has_post_thumbnail($post_id)
        ? get_the_post_thumbnail_url(
            $post_id,
            'large'
          )
        : get_template_directory_uri()
            . '/assets/images/placeholders/news-placeholder.jpg',

    'date' =>
      date_i18n(
        'j F Y',
        get_post_time('U', false, $post_id)
      ),

    'reading_time' =>
      $reading_time . ' min',

  ];

}