<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_DB_Migrations')) {

  class Kaddora_DB_Migrations
  {

    /**
     * run
     */
    public static function run()
    {

      $installed_version = get_option('kaddora_property_db_version');

      if ($installed_version !== KADDORA_PROPERTY_VERSION) {

        self::migrate();

        update_option('kaddora_property_db_version', KADDORA_PROPERTY_VERSION);
      }
    }

    /**
     * migrate
     */
    private static function migrate()
    {

      require_once ABSPATH . 'wp-admin/includes/upgrade.php';
      require_once KADDORA_PROPERTY_PATH . 'database/schema.php';

      $tables = Kaddora_DB_Schema::get_tables();

      if (!empty($tables)) {
        foreach ($tables as $sql) {
          dbDelta($sql);
        }
      }
    }
  }
}
