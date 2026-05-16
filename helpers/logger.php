<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('kaddora_log')) {

  function kaddora_log($message)
  {
    if (defined('WP_DEBUG') && WP_DEBUG) {

      error_log(
        '[Kaddora] ' . print_r($message, true)
      );
    }
  }
}
