<?php

$slides =
  webjti_get_hero_slides();

if (empty($slides)) {
  return;
}

$hero_aria_label = 'Informasi Terbaru';
$hero_category_label = 'Kategori';
$hero_button_label = 'Lihat Detail';
$hero_strip_label = 'Pilih Slide';

?>

<section
  class="hero-section"
  id="hero-section"
  aria-label="<?php echo esc_attr($hero_aria_label); ?>"
>

  <?php foreach ($slides as $index => $slide) :

    $is_active =
      $index === 0;

  ?>

    <article
      class="hero-slide<?php echo $is_active ? ' is-active' : ''; ?>"
      data-slide="<?php echo esc_attr($index + 1); ?>"
      aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
      style="
        background-image:
        url('<?php echo esc_url($slide['image']); ?>')
      "
    >

      <div
        class="hero-slide__overlay"
        aria-hidden="true"
      ></div>

      <div class="hero-slide__content">

        <div class="hero-slide__meta">

          <div
            class="badge badge--hero"
            aria-label="<?php echo esc_attr($hero_category_label); ?>"
          >
            <?php
            echo esc_html(
              strtoupper(
                $slide['category']
              )
              );
              ?>

            

          </div>

          <h2 class="section-title section-title--hero">

            <?php
            echo esc_html($slide['title']);
            ?>

          </h2>

        </div>

        <a
          href="<?php echo esc_url($slide['permalink']); ?>"
          class="btn"
          aria-label="<?php echo esc_attr(
            sprintf(
              __('%1$s: %2$s', 'webjti'),
              $hero_button_label,
              $slide['title']
            )
          ); ?>"
        >

          <?php
          echo esc_html($hero_button_label);
          ?>

          <i class="ph ph-arrow-up-right"></i>

        </a>

      </div>

    </article>

  <?php endforeach; ?>

  <div
    class="hero-strip"
    id="hero-strip"
    aria-label="<?php echo esc_attr($hero_strip_label); ?>"
  >

    <?php foreach ($slides as $index => $slide) :

      $is_active =
        $index === 0;

    ?>

      <button
        class="hero-thumb<?php echo $is_active ? ' is-active' : ''; ?>"
        data-target="<?php echo esc_attr($index + 1); ?>"
        aria-label="<?php echo esc_attr(
          sprintf(
            __('Tampilkan: %s', 'webjti'),
            $slide['title']
          )
        ); ?>"
        aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>"
        type="button"
      >

        <img
          src="<?php echo esc_url($slide['image']); ?>"
          alt=""
          class="hero-thumb__img"
          loading="lazy"
        >

        <div
          class="hero-thumb__progress-track"
          aria-hidden="true"
        >

          <div class="hero-thumb__progress-fill"></div>

        </div>

      </button>

    <?php endforeach; ?>

  </div>

</section>