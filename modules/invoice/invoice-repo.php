<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Invoice_Repo')) {

  class Kaddora_Invoice_Repo
  {

    private $table;

    public function __construct()
    {
      global $wpdb;
      $this->table = $wpdb->prefix . 'kaddora_invoices';
    }

    /**
     * insert
     */
    public function insert($data)
    {
      global $wpdb;

      unset($data['id']);

      $inserted = $wpdb->insert(
        $this->table,
        array(
          'tenant_id'   => intval($data['tenant_id'] ?? 0),
          'total'       => floatval($data['total'] ?? 0),
          'due_date'    => $data['due_date'] ?? '',
          'status'      => $data['status'] ?? 'unpaid',
          'created_at'  => $data['created_at'] ?? current_time('mysql'),
        ),
        array('%d', '%f', '%s', '%s', '%s')
      );

      return $inserted ? $wpdb->insert_id : false;
    }

    /**
     * get_all
     */
    public function get_all()
    {
      global $wpdb;
      return $wpdb->get_results("SELECT * FROM {$this->table} ORDER BY id DESC", ARRAY_A);
    }
  }
}
