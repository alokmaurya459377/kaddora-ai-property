<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Tenant_Service')) {

  class Kaddora_Tenant_Service
  {

    private $repo;

    public function __construct()
    {
      if (!class_exists('Kaddora_Validator')) {
        require_once KADDORA_PROPERTY_PATH . 'helpers/validator.php';
      }

      if (!class_exists('Kaddora_Tenant_Repo')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-repo.php';
      }

      if (!class_exists('Kaddora_Tenant_Model')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-model.php';
      }

      $this->repo = new Kaddora_Tenant_Repo();
    }

    /**
     * create
     */
    public function create($data)
    {
      if (!Kaddora_Validator::required($data['name'] ?? '')) {
        return new WP_Error('invalid_name', __('Tenant name is required', 'kaddora-ai-property'));
      }

      $model = new Kaddora_Tenant_Model($data);

      $tenant_id = $this->repo->insert((array)$model);

      if ($tenant_id) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $tenant_id;
    }

    /**
     * list
     */
    public function list()
    {
      return $this->repo->get_all();
    }

    /**
     * get
     */
    public function get($id)
    {
      if (!$id) {
        return false;
      }

      return $this->repo->get($id);
    }

    /**
     * update
     */
    public function update($id, $data)
    {
      if (!$id) {
        return new WP_Error('invalid_id', __('Invalid tenant ID', 'kaddora-ai-property'));
      }

      if (!Kaddora_Validator::required($data['name'] ?? '')) {
        return new WP_Error(
          'invalid_name',
          __('Tenant name is required', 'kaddora-ai-property')
        );
      }

      $model = new Kaddora_Tenant_Model($data);

      $updated = $this->repo->update($id, (array) $model);

      if ($updated !== false) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $updated;
    }

    /**
     * delete
     */
    public function delete($id)
    {
      if (!$id) {
        return false;
      }

      $deleted = $this->repo->delete($id);

      if ($deleted) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $deleted;
    }
  }
}
