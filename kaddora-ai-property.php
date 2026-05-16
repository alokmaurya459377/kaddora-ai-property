<?php

/**
 * Plugin Name: Kaddora AI Property & Rental Management
 * Plugin URI: https://kaddora.com/
 * Description: A powerful AI-driven property and rental management SaaS plugin for WordPress. Easily manage properties, tenants, rent payments, automated reminders, and analytics — all in one scalable system.
 * Version: 1.0.0
 * Author: KaddoraTech
 * Author URI: https://kaddora.com/
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: kaddora-ai-property
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Define constants
 */
if (!defined('KADDORA_PROPERTY_VERSION')) {
  define('KADDORA_PROPERTY_VERSION', '1.0.0');
}

if (!defined('KADDORA_PROPERTY_PATH')) {
  define('KADDORA_PROPERTY_PATH', plugin_dir_path(__FILE__));
}

if (!defined('KADDORA_PROPERTY_URL')) {
  define('KADDORA_PROPERTY_URL', plugin_dir_url(__FILE__));
}

/**
 * Load Core Files (ONLY required entry files)
 */
require_once KADDORA_PROPERTY_PATH . 'core/init.php';

/**
 * Run Plugin
 */
if (!function_exists('kaddora_property_run')) {

  function kaddora_property_run()
  {

    if (class_exists('Kaddora_Init')) {

      $plugin = new Kaddora_Init();

      if (method_exists($plugin, 'run')) {
        $plugin->run();
      }
    }
  }
}

kaddora_property_run();
