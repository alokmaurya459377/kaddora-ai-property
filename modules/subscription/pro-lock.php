<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('kaddora_is_pro')) {

  function kaddora_is_pro()
  {
    return get_option(
      'kaddora_pro_active',
      'no'
    ) === 'yes';
  }
}

if (!function_exists('kaddora_pro_badge')) {

  function kaddora_pro_badge()
  {
    if (kaddora_is_pro()) {
      return '';
    }

    return '<span class="kaddora-pro-badge">' . esc_html__('Pro', 'kaddora-ai-property') . '</span>';
  }
}
