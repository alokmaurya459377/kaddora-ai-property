<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_API_Auth')) {

  class Kaddora_API_Auth
  {

    /**
     * Admin Access
     */
    public static function admin_only()
    {
      return current_user_can('manage_options');
    }

    /**
     * Logged In Users
     */
    public static function logged_in()
    {
      return is_user_logged_in();
    }
  }
}
