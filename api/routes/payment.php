
<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Payment_API')) {

  class Kaddora_Payment_API
  {
    public function init()
    {
      register_rest_route(
        'kaddora/v1',
        '/payments',
        array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array($this, 'get_payments'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );

      register_rest_route(
        'kaddora/v1',
        '/payments',
        array(
          'methods'  => WP_REST_Server::CREATABLE,
          'callback' => array($this, 'create_payment'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );
    }

    /**
     * Create Payment
     */
    public function create_payment($request)
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-service.php';

      $service = new Kaddora_Payment_Service();

      $data = array(
        'tenant_id' => intval($request->get_param('tenant_id') ?? 0),
        'amount'    => floatval($request->get_param('amount') ?? 0),
        'status'    => Kaddora_Validator::valid_status($request->get_param('status') ?? '', array('pending', 'paid'))
          ? sanitize_text_field($request->get_param('status'))
          : 'pending',
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
          'payment_id' => $id,
        ),
        __('Payment created successfully', 'kaddora-ai-property')
      );
    }

    /**
     * All Payments
     */
    public function get_payments()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-service.php';

      $service = new Kaddora_Payment_Service();

      return Kaddora_API_Response::success(
        $service->list(),
        __('Payments fetched successfully', 'kaddora-ai-property')
      );
    }
  }
}
