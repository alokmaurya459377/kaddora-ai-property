<?php

if (!defined('ABSPATH')) exit;

if (!function_exists('kaddora_array_get')) {

  function kaddora_array_get($array, $key, $default = '')
  {

    return isset($array[$key]) ? $array[$key] : $default;
  }
}

if (!function_exists('kaddora_is_post_request')) {

  function kaddora_is_post_request()
  {

    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
  }
}

if (!function_exists('kaddora_clean')) {

  function kaddora_clean($value)
  {

    if (is_array($value)) {
      return array_map('kaddora_clean', $value);
    }

    return sanitize_text_field($value);
  }
}
