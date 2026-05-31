<?php
/**
 * Breadcrumbs Component
 *
 * @package WebJTI_Theme
 */

$current_override = $args['current_override'] ?? '';

$breadcrumb = webjti_get_breadcrumb_items();
$trail = $breadcrumb['trail'];
$current_label = !empty($current_override) ? $current_override : $breadcrumb['current'];
?>

<nav class="jti-breadcrumb" aria-label="Breadcrumb">
  <div class="breadcrumb-inner">

    <?php 
    foreach ($trail as $crumb) : 
      // All trail links use the same clickable & hoverable class
      ?>
      <a href="<?php echo esc_url($crumb['url']); ?>" class="breadcrumb-item breadcrumb-submenu-active">
        <?php echo esc_html($crumb['label']); ?>
      </a>

      <i class="ph ph-caret-right breadcrumb-sep" aria-hidden="true"></i>

    <?php endforeach; ?>

    <span class="breadcrumb-item breadcrumb-active" aria-current="page">
      <?php echo esc_html($current_label); ?>
    </span>

  </div>
</nav>