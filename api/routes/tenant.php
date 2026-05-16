<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Tenant_API')) {

  class Kaddora_Tenant_API
  {
    public function init()
    {
      register_rest_route(
        'kaddora/v1',
        '/tenants',
        array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array($this, 'get_tenants'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );
    }

    /**
     * All Tenants
     */
    public function get_tenants()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';

      $service = new Kaddora_Tenant_Service();

      $tenants = $service->list();

      return Kaddora_API_Response::success(
        $tenants,
        __('Tenants fetched successfully', 'kaddora-ai-property')
      );
    }
  }
}
