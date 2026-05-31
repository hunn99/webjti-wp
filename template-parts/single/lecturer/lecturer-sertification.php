<?php
/**
 * Lecturer Certifications Section
 *
 * @package WebJTI_Theme
 */

$certification_list = $args['certifications'] ?? [];

if (empty($certification_list)) {
  $current_lecturer_id = get_the_ID();
  $certification_query = new WP_Query([
    'post_type' => 'lecturer_certification',
    'posts_per_page' => -1,
    'meta_query' => [
      [
        'key' => 'lecturer',
        'value' => $current_lecturer_id,
        'compare' => '=',
      ]
    ],
  ]);

  if ($certification_query->have_posts()) {
    while ($certification_query->have_posts()) {
      $certification_query->the_post();
      $certification_list[] = [
        'title' => get_field('nama_sertifikasi'),
        'institution' => get_field('lembaga'),
        'start_year' => get_field('tahun_mulai'),
        'end_year' => get_field('tahun_selesai'),
      ];
    }
    wp_reset_postdata();
  }
}

if (empty($certification_list)) {
  return;
}

ob_start();

?>

<div class="lecturer-certifications">

  <div class="lecturer-certifications__grid">

    <?php foreach ($certification_list as $certification) : ?>

      <?php
      get_template_part(
        'template-parts/cards/certification-card',
        null,
        [
          'certification' => $certification,
        ]
      );
      ?>

    <?php endforeach; ?>

  </div>

</div>

<?php

$content =
  ob_get_clean();

get_template_part(
  'template-parts/components/content-block',
  null,
  [

    'title' =>
      'Sertifikasi',

    'icon' =>
      'ph-certificate',

    'content' =>
      $content,

  ]
);