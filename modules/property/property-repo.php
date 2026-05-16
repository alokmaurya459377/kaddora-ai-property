<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_Repo')) {

  class Kaddora_Property_Repo
  {
    private $table;

    public function __construct()
    {
      global $wpdb;
      $this->table = $wpdb->prefix . 'kaddora_properties';
    }

    /**
     * insert
     */
    public function insert($data)
    {

      global $wpdb;

      $inserted = $wpdb->insert(
        $this->table,
        array(
          'name'    => $data['name'],
          'address' => $data['address'],
          'rent'    => $data['rent'],
          'status'  => $data['status'],
        ),
        array('%s', '%s', '%f', '%s')
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

    /**
     * update
     */
    public function update($id, $data)
    {

      global $wpdb;

      return $wpdb->update(
        $this->table,
        array(
          'name'    => $data['name'],
          'address' => $data['address'],
          'rent'    => $data['rent'],
          'status'  => $data['status'],
        ),
        array('id' => intval($id)),
        array('%s', '%s', '%f', '%s'),
        array('%d')
      );
    }
  }
}
