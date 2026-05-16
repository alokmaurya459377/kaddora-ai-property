<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Frontend_Shortcodes')) {

  class Kaddora_Frontend_Shortcodes
  {
    public function init()
    {
      add_shortcode('kaddora_properties', array($this, 'properties'));
      add_shortcode('kaddora_tenant_dashboard', array($this, 'tenant_dashboard'));
    }

    /**
     * Property Listing
     */
    public function properties()
    {
      ob_start();

      require KADDORA_PROPERTY_PATH . 'frontend/templates/property-list.php';

      return ob_get_clean();
    }

    /**
     * Tenant Dashboard
     */
    public function tenant_dashboard()
    {
      ob_start();
      require KADDORA_PROPERTY_PATH . 'frontend/templates/tenant-dashboard.php';
      return ob_get_clean();
    }
  }
}
