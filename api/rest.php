<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_REST_API')) {

  class Kaddora_REST_API
  {

    public function init()
    {
      add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Register Route Files
     */
    public function register_routes()
    {
      require_once KADDORA_PROPERTY_PATH . 'api/routes/property.php';
      require_once KADDORA_PROPERTY_PATH . 'api/routes/tenant.php';
      require_once KADDORA_PROPERTY_PATH . 'api/routes/payment.php';
      require_once KADDORA_PROPERTY_PATH . 'api/routes/invoice.php';

      (new Kaddora_Property_API())->init();
      (new Kaddora_Tenant_API())->init();
      (new Kaddora_Payment_API())->init();
      (new Kaddora_Invoice_API())->init();
    }
  }
}
