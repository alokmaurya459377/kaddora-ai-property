<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Tenant_Repo')) {

  class Kaddora_Tenant_Repo
  {

    private $table;

    public function __construct()
    {
      global $wpdb;
      $this->table = $wpdb->prefix . 'kaddora_tenants';
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
          'property_id' => intval($data['property_id'] ?? 0),
          'name'        => $data['name'] ?? '',
          'email'       => $data['email'] ?? '',
          'phone'       => $data['phone'] ?? '',
        ),
        array('%d', '%s', '%s', '%s')
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

    /**
     * get
     */
    public function get($id)
    {
      global $wpdb;

      return $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$this->table} WHERE id = %d", $id),
        ARRAY_A
      );
    }

    /**
     * update
     */
    public function update($id, $data)
    {
      global $wpdb;

      unset($data['id']);

      return $wpdb->update(
        $this->table,
        array(
          'property_id' => intval($data['property_id'] ?? 0),
          'name'        => $data['name'] ?? '',
          'email'       => $data['email'] ?? '',
          'phone'       => $data['phone'] ?? '',
        ),
        array('id' => intval($id)),
        array('%d', '%s', '%s', '%s'),
        array('%d')
      );
    }

    /**
     * delete
     */
    public function delete($id)
    {
      global $wpdb;

      return $wpdb->delete(
        $this->table,
        array('id' => intval($id)),
        array('%d')
      );
    }
  }
}
