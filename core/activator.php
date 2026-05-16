<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Activator')) {

  class Kaddora_Activator
  {
    /**
     * activate
     */
    public static function activate()
    {
      require_once KADDORA_PROPERTY_PATH . 'database/migrations.php';

      Kaddora_DB_Migrations::run();

      add_option('kaddora_property_version', KADDORA_PROPERTY_VERSION);
    }
  }
}
