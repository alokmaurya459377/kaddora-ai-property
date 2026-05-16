<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Tenant_Controller')) {

  class Kaddora_Tenant_Controller
  {
    /**
     * init
     */
    public function init()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-repo.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-model.php';

      add_action('admin_post_kaddora_save_tenant', array($this, 'save'));
      add_action('admin_post_kaddora_update_tenant', array($this, 'update'));
      add_action('admin_post_kaddora_delete_tenant', array($this, 'delete'));
    }

    public function save()
    {
      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_tenant_nonce')) {
        wp_die('Security check failed');
      }

      $service = new Kaddora_Tenant_Service();

      $data = array(
        'property_id' => intval($_POST['property_id'] ?? 0),
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'phone' => sanitize_text_field($_POST['phone'] ?? ''),
      );

      $service->create($data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-tenants'));
      exit;
    }

    /**
     * update
     */
    public function update()
    {
      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_tenant_nonce')) {
        wp_die('Security check failed');
      }

      $service = new Kaddora_Tenant_Service();

      $id = intval($_POST['id'] ?? 0);
      $data = array(
        'property_id' => intval($_POST['property_id'] ?? 0),
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'phone' => sanitize_text_field($_POST['phone'] ?? ''),
      );

      $service->update($id, $data);

      wp_safe_redirect(admin_url('admin.php?page=kaddora-tenants'));
      exit;
    }

    /**
     * delete
     */
    public function delete()
    {
      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'kaddora_delete_tenant')) {
        wp_die('Security check failed');
      }

      $service = new Kaddora_Tenant_Service();
      $service->delete(intval($_GET['id'] ?? 0));

      wp_safe_redirect(admin_url('admin.php?page=kaddora-tenants'));
      exit;
    }
  }
}
