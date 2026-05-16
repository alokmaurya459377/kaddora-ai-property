
<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Report_Service')) {

  class Kaddora_Report_Service
  {
    /**
     * Dashboard Stats
     */
    public function dashboard_stats()
    {
      $cache_key = 'kaddora_dashboard_stats';

      $data = get_transient($cache_key);

      if ($data === false) {
        $data = $this->calculate_stats();

        set_transient(
          $cache_key,
          $data,
          HOUR_IN_SECONDS
        );
      }

      return $data;
    }

    /**
     * calculate_stats
     */
    private function calculate_stats()
    {
      global $wpdb;

      $total_properties = (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->prefix}kaddora_properties"
      );

      $occupied = (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM {$wpdb->prefix}kaddora_properties
         WHERE status = 'occupied'"
      );

      return array(
        'total_properties' => $total_properties,
        'total_tenants' => (int) $wpdb->get_var(
          "SELECT COUNT(*) FROM {$wpdb->prefix}kaddora_tenants"
        ),
        'total_revenue' => (float) $wpdb->get_var(
          "SELECT SUM(amount) FROM {$wpdb->prefix}kaddora_payments
           WHERE status = 'paid'"
        ),
        'pending_invoices' => (int) $wpdb->get_var(
          "SELECT COUNT(*) FROM {$wpdb->prefix}kaddora_invoices
           WHERE status = 'unpaid'"
        ),
        'occupancy_rate' => $total_properties === 0
          ? 0
          : round(($occupied / $total_properties) * 100, 2),
      );
    }

    /**
     * total_properties
     */
    public function total_properties()
    {
      $stats = $this->dashboard_stats();

      return (int) $stats['total_properties'];
    }

    /**
     * total_tenants
     */
    public function total_tenants()
    {
      $stats = $this->dashboard_stats();

      return (int) $stats['total_tenants'];
    }

    /**
     * total_revenue
     */
    public function total_revenue()
    {
      $stats = $this->dashboard_stats();

      return (float) $stats['total_revenue'];
    }

    /**
     * pending_invoices
     */
    public function pending_invoices()
    {
      $stats = $this->dashboard_stats();

      return (int) $stats['pending_invoices'];
    }

    /**
     * occupancy_rate
     */
    public function occupancy_rate()
    {
      $stats = $this->dashboard_stats();

      return (float) $stats['occupancy_rate'];
    }
  }
}
