<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Invoice_API')) {

  class Kaddora_Invoice_API
  {
    public function init()
    {
      register_rest_route(
        'kaddora/v1',
        '/invoices',
        array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array($this, 'get_invoices'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );

      register_rest_route(
        'kaddora/v1',
        '/invoices',
        array(
          'methods'  => WP_REST_Server::CREATABLE,
          'callback' => array($this, 'create_invoice'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );
    }

    /**
     * Create Invoice
     */
    public function create_invoice($request)
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-service.php';

      $service = new Kaddora_Invoice_Service();

      $data = array(
        'tenant_id' => intval($request->get_param('tenant_id') ?? 0),
        'total'     => floatval($request->get_param('total') ?? 0),
        'due_date'  => sanitize_text_field($request->get_param('due_date') ?? ''),
        'status'    => Kaddora_Validator::valid_status($request->get_param('status') ?? '', array('unpaid', 'paid'))
          ? sanitize_text_field($request->get_param('status'))
          : 'unpaid',
      );

      $id = $service->create($data);

      if (is_wp_error($id)) {
        return Kaddora_API_Response::error(
          $id->get_error_message(),
          400
        );
      }

      return Kaddora_API_Response::success(
        array(
          'invoice_id' => $id,
        ),
        __('Invoice created successfully', 'kaddora-ai-property')
      );
    }

    /**
     * All Invoices
     */
    public function get_invoices()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-service.php';

      $service = new Kaddora_Invoice_Service();

      return Kaddora_API_Response::success(
        $service->list(),
        __('Invoices fetched successfully', 'kaddora-ai-property')
      );
    }
  }
}
