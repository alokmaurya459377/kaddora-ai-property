<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Invoice_Controller')) {

  class Kaddora_Invoice_Controller
  {
    /**
     * init
     */
    public function init()
    {

      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-service.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-repo.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-model.php';

      add_action('admin_post_kaddora_save_invoice', array($this, 'save'));
      add_action('admin_post_kaddora_generate_invoice', array($this, 'generate'));
    }

    /**
     * save
     */
    public function save()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_invoice_nonce')) {
        wp_die('Security failed');
      }

      $service = new Kaddora_Invoice_Service();

      $data = array(
        'tenant_id' => intval($_POST['tenant_id'] ?? 0),
        'total'     => floatval($_POST['total'] ?? 0),
        'due_date'  => sanitize_text_field($_POST['due_date'] ?? ''),
        'status'    => Kaddora_Validator::valid_status($_POST['status'] ?? '', array('unpaid', 'paid'))
          ? sanitize_text_field($_POST['status'])
          : 'unpaid',
      );

      $service->create($data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-invoices'));
      exit;
    }

    /**
     * generate
     */
    public function generate()
    {
      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_generate_invoice_nonce')) {
        wp_die('Security failed');
      }

      $service = new Kaddora_Invoice_Service();
      $generated = $service->generate_monthly();

      wp_safe_redirect(
        add_query_arg(
          array(
            'kaddora_notice' => 'generated',
            'count' => intval($generated),
          ),
          admin_url('admin.php?page=kaddora-invoices')
        )
      );
      exit;
    }
  }
}
