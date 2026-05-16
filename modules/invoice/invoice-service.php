<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Invoice_Service')) {

  class Kaddora_Invoice_Service
  {

    private $repo;

    public function __construct()
    {
      if (!class_exists('Kaddora_Validator')) {
        require_once KADDORA_PROPERTY_PATH . 'helpers/validator.php';
      }

      if (!class_exists('Kaddora_Invoice_Repo')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-repo.php';
      }

      if (!class_exists('Kaddora_Invoice_Model')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-model.php';
      }

      $this->repo = new Kaddora_Invoice_Repo();
    }

    /**
     * create
     */
    public function create($data)
    {

      if (!Kaddora_Validator::positive_number($data['tenant_id'] ?? 0)) {
        return new WP_Error(
          'invalid_tenant',
          __('Valid tenant required', 'kaddora-ai-property')
        );
      }

      if (!Kaddora_Validator::positive_number($data['total'] ?? 0)) {
        return new WP_Error(
          'invalid_total',
          __('Invoice amount required', 'kaddora-ai-property')
        );
      }

      if (!Kaddora_Validator::valid_status($data['status'] ?? '', array('unpaid', 'paid'))) {
        $data['status'] = 'unpaid';
      }

      $model = new Kaddora_Invoice_Model($data);

      $invoice_id = $this->repo->insert((array)$model);

      if ($invoice_id) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $invoice_id;
    }

    /**
     * list
     */
    public function list()
    {
      return $this->repo->get_all();
    }

    /**
     * AUTO GENERATE 
     */
    public function generate_monthly()
    {

      if (!class_exists('Kaddora_Tenant_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
      }

      if (!class_exists('Kaddora_Property_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';
      }

      $tenantService   = new Kaddora_Tenant_Service();
      $propertyService = new Kaddora_Property_Service();

      $tenants = $tenantService->list();

      if (empty($tenants)) {
        return 0;
      }

      $generated = 0;

      foreach ($tenants as $tenant) {

        $property = $propertyService->get($tenant['property_id']);

        if (!$property) {
          continue;
        }

        $rent = floatval($property['rent']);

        if ($rent <= 0) {
          continue;
        }

        if ($this->invoice_exists($tenant['id'])) {
          continue;
        }

        $data = array(
          'tenant_id' => $tenant['id'],
          'total'     => $rent,
          'due_date'  => date('Y-m-10'),
          'status'    => 'unpaid',
        );

        $invoice_id = $this->create($data);

        if (!is_wp_error($invoice_id) && $invoice_id) {
          $generated++;
        }
      }

      return $generated;
    }

    /**
     * invoice_exists
     */
    private function invoice_exists($tenant_id)
    {
      global $wpdb;

      $table = $wpdb->prefix . 'kaddora_invoices';
      $month = date('Y-m');

      $result = $wpdb->get_var(
        $wpdb->prepare(
          "SELECT COUNT(*) FROM $table
           WHERE tenant_id = %d
           AND DATE_FORMAT(created_at, '%%Y-%%m') = %s",
          $tenant_id,
          $month
        )
      );

      return $result > 0;
    }
  }
}
