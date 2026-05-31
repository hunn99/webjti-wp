<?php
/**
 * Lecturer Education Section
 *
 * @package WebJTI_Theme
 */

$education_list = $args['education'] ?? [];

if (empty($education_list)) {
  $current_lecturer_id = get_the_ID();
  $education_query = new WP_Query([
    'post_type' => 'lecturer_education',
    'posts_per_page' => -1,
    'meta_query' => [
      [
        'key' => 'lecturer',
        'value' => $current_lecturer_id,
        'compare' => '=',
      ]
    ],
    'orderby' => 'meta_value_num',
    'meta_key' => 'tahun_selesai',
    'order' => 'DESC',
  ]);

  if ($education_query->have_posts()) {
    while ($education_query->have_posts()) {
      $education_query->the_post();
      $education_list[] = [
        'degree' => get_field('jenjang'),
        'institution' => get_field('institusi'),
        'start_year' => get_field('tahun_mulai'),
        'end_year' => get_field('tahun_selesai'),
      ];
    }
    wp_reset_postdata();
  }
}

if (empty($education_list)) {
  return;
}

ob_start();

?>

<div class="lecturer-education slider-wrapper">

  <div class="lecturer-education__slider slider-container">

    <div class="lecturer-education__track slider-track">

      <?php foreach ($education_list as $education) : ?>

        <div class="slider-item">

          <?php
          get_template_part(
            'template-parts/cards/education-card',
            null,
            [
              'education' => $education,
            ]
          );
          ?>

        </div>

      <?php endforeach; ?>

    </div>

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
      'Pendidikan',

    'icon' =>
      'ph-graduation-cap',

    'content' =>
      $content,

  ]
);