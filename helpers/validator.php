<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Validator')) {

  class Kaddora_Validator
  {

    /**
     * Required field
     */
    public static function required($value)
    {
      return !empty(trim($value));
    }

    /**
     * Email validation
     */
    public static function email($email)
    {
      return is_email($email);
    }

    /**
     * Positive number
     */
    public static function positive_number($number)
    {
      return is_numeric($number) && $number > 0;
    }

    /**
     * Status whitelist
     */
    public static function valid_status($status, $allowed = array())
    {

      if (empty($allowed)) {
        return false;
      }

      return in_array($status, $allowed, true);
    }
  }
}
