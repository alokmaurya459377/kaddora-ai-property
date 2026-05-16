<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Admin_Menu')) {

  class Kaddora_Admin_Menu
  {
    /**
     * init
     */
    public function init()
    {
      add_action('admin_menu', array($this, 'register_menu'));
    }

    /**
     * register_menu
     */
    public function register_menu()
    {
      add_menu_page(
        __('Kaddora Property', 'kaddora-ai-property'),
        __('Kaddora Property', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-dashboard',
        array($this, 'dashboard_page'),
        'dashicons-building',
        26
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Properties', 'kaddora-ai-property'),
        __('Properties', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-properties',
        array($this, 'properties_page')
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Tenants', 'kaddora-ai-property'),
        __('Tenants', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-tenants',
        array($this, 'tenants_page')
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Payments', 'kaddora-ai-property'),
        __('Payments', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-payments',
        array($this, 'payments_page')
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Invoices', 'kaddora-ai-property'),
        __('Invoices', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-invoices',
        array($this, 'invoices_page')
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Analytics', 'kaddora-ai-property'),
        __('Analytics', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-analytics',
        array($this, 'analytics_page')
      );

      add_submenu_page(
        'kaddora-dashboard',
        __('Settings', 'kaddora-ai-property'),
        __('Settings', 'kaddora-ai-property'),
        'manage_options',
        'kaddora-settings',
        array($this, 'settings_page')
      );
    }

    /**
     * analytics_page
     */
    public function analytics_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/analytics.php';
    }

    /**
     * settings_page
     */
    public function settings_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/settings.php';
    }

    /**
     * invoices_page
     */
    public function invoices_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/invoices.php';
    }

    /**
     * payments_page
     */
    public function payments_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/payments.php';
    }

    /**
     * tenants_page
     */
    public function tenants_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/tenants.php';
    }

    /**
     * dashboard_page
     */
    public function dashboard_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/dashboard.php';
    }

    /**
     * properties_page
     */
    public function properties_page()
    {
      require_once KADDORA_PROPERTY_PATH . 'admin/pages/properties.php';
    }
  }
}
