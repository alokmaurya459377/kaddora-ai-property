<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_Controller')) {

  class Kaddora_Property_Controller
  {

    private $service;

    public function init()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-repo.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-model.php';

      $this->service = new Kaddora_Property_Service();

      add_action('admin_post_kaddora_save_property', array($this, 'save_property'));

      add_action('admin_post_kaddora_update_property', array($this, 'update_property'));
      add_action('admin_post_kaddora_delete_property', array($this, 'delete_property'));
    }

    /**
     * delete_property
     */
    public function delete_property()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'kaddora_delete_property')) {
        wp_die('Security failed');
      }

      $id = intval($_GET['id'] ?? 0);

      $this->service->delete($id);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-properties'));
      exit;
    }

    /**
     * update_property
     */
    public function update_property()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_property_nonce')) {
        wp_die('Security failed');
      }

      $id = intval($_POST['id'] ?? 0);

      $data = array(
        'name'    => sanitize_text_field($_POST['name'] ?? ''),
        'address' => sanitize_textarea_field($_POST['address'] ?? ''),
        'rent'    => floatval($_POST['rent'] ?? 0),
        'status'  => Kaddora_Validator::valid_status($_POST['status'] ?? '', array('available', 'occupied'))
          ? sanitize_text_field($_POST['status'])
          : 'available',
      );

      $this->service->update($id, $data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-properties'));
      exit;
    }

    /**
     * save_property
     */
    public function save_property()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_property_nonce')) {
        wp_die('Security check failed');
      }

      $data = array(
        'name'    => sanitize_text_field($_POST['name'] ?? ''),
        'address' => sanitize_textarea_field($_POST['address'] ?? ''),
        'rent'    => floatval($_POST['rent'] ?? 0),
        'status'  => Kaddora_Validator::valid_status($_POST['status'] ?? '', array('available', 'occupied'))
          ? sanitize_text_field($_POST['status'])
          : 'available',
      );

      $result = $this->service->create($data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-properties'));
      exit;
    }
  }
}
