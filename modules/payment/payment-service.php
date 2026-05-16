<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Payment_Service')) {

  class Kaddora_Payment_Service
  {

    /**
     * Repository
     */
    private $repo;

    /**
     * Constructor
     */
    public function __construct()
    {
      $this->load_dependencies();
      $this->repo = new Kaddora_Payment_Repo();
    }

    /**
     * Load Dependencies
     */
    private function load_dependencies()
    {

      if (!class_exists('Kaddora_Validator')) {
        require_once KADDORA_PROPERTY_PATH . 'helpers/validator.php';
      }

      if (!class_exists('Kaddora_Payment_Repo')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-repo.php';
      }

      if (!class_exists('Kaddora_Payment_Model')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-model.php';
      }

      if (!class_exists('Kaddora_Reminder_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'services/reminder.php';
      }

      if (!class_exists('Kaddora_Tenant_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
      }
    }

    /**
     * Create Payment
     */
    public function create($data)
    {
      /**
       * Validate Tenant
       */
      if (!Kaddora_Validator::positive_number(
        $data['tenant_id'] ?? 0
      )) {
        return new WP_Error(
          'invalid_tenant',
          __('Valid tenant required', 'kaddora-ai-property')
        );
      }

      /**
       * Validate Amount
       */
      if (
        !Kaddora_Validator::positive_number(
          $data['amount'] ?? 0
        )
      ) {

        return new WP_Error(
          'invalid_amount',
          __('Valid payment amount required', 'kaddora-ai-property')
        );
      }

      /**
       * Create Model
       */
      if (!Kaddora_Validator::valid_status($data['status'] ?? '', array('pending', 'paid'))) {
        $data['status'] = 'pending';
      }

      $model = new Kaddora_Payment_Model($data);

      /**
       * Save Payment
       */
      $payment_id = $this->repo->insert((array) $model);

      if ($payment_id) {
        delete_transient('kaddora_dashboard_stats');
      }

      /**
       * Invoice Sync
       */
      if ($model->status === 'paid') {

        $this->mark_invoice_paid(
          $model->tenant_id,
          $model->amount
        );
      }

      /**
       * Send Success Email
       */
      $tenant_service = new Kaddora_Tenant_Service();

      $tenant = $tenant_service->get(
        $model->tenant_id
      );

      if ($tenant) {

        $reminder_service = new Kaddora_Reminder_Service();

        $reminder_service->payment_success(
          $tenant,
          $model->amount
        );
      }

      return $payment_id;
    }

    /**
     * List Payments
     */
    public function list()
    {
      return $this->repo->get_all();
    }

    /**
     * Mark Invoice Paid
     */
    private function mark_invoice_paid(
      $tenant_id,
      $amount
    ) {

      global $wpdb;

      $table = $wpdb->prefix . 'kaddora_invoices';

      /**
       * Latest Unpaid Invoice
       */
      $invoice = $wpdb->get_row(

        $wpdb->prepare(

          "SELECT * FROM {$table}
                     WHERE tenant_id = %d
                     AND status = 'unpaid'
                     ORDER BY id DESC
                     LIMIT 1",

          $tenant_id
        ),

        ARRAY_A
      );

      /**
       * Update Invoice Status
       */
      if (
        $invoice &&
        floatval($invoice['total']) <= floatval($amount)
      ) {
        $wpdb->update(
          $table,
          array(
            'status' => 'paid',
          ),
          array(
            'id' => $invoice['id'],
          ),
          array('%s'),
          array('%d')
        );

        delete_transient('kaddora_dashboard_stats');
      }
    }
  }
}
