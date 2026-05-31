<?php

/* ========================================
   SAFE ACF FIELD
======================================== */

function webjti_field(
  $field_name,
  $post_id = false,
  $default = ''
) {

  if (!function_exists('get_field')) {
    return $default;
  }

  $value =
    get_field(
      $field_name,
      $post_id
    );

    return $value ?: $default;

}