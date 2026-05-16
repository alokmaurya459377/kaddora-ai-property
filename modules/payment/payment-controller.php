<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Payment_Controller')) {

  class Kaddora_Payment_Controller
  {
    /**
     * init
     */
    public function init()
    {

      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-service.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-repo.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-model.php';

      add_action('admin_post_kaddora_save_payment', array($this, 'save'));
    }

    /**
     * save
     */
    public function save()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_payment_nonce')) {
        wp_die('Security check failed');
      }

      $service = new Kaddora_Payment_Service();

      $data = array(
        'tenant_id' => intval($_POST['tenant_id'] ?? 0),
        'amount'    => floatval($_POST['amount'] ?? 0),
        'status'    => Kaddora_Validator::valid_status($_POST['status'] ?? '', array('pending', 'paid'))
          ? sanitize_text_field($_POST['status'])
          : 'pending',
      );

      $service->create($data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-payments'));
      exit;
    }
  }
}
