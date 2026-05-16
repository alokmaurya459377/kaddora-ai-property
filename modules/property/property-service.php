<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_Service')) {

  class Kaddora_Property_Service
  {

    private $repo;

    public function __construct()
    {
      if (!class_exists('Kaddora_Validator')) {
        require_once KADDORA_PROPERTY_PATH . 'helpers/validator.php';
      }

      if (!class_exists('Kaddora_Property_Repo')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/property/property-repo.php';
      }

      if (!class_exists('Kaddora_Property_Model')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/property/property-model.php';
      }

      $this->repo = new Kaddora_Property_Repo();
    }

    /**
     * create
     */
    public function create($data)
    {

      if (!Kaddora_Validator::required($data['name'] ?? '')) {
        return new WP_Error('invalid_name', __('Property name is required', 'kaddora-ai-property'));
      }

      if (!Kaddora_Validator::valid_status($data['status'] ?? '', array('available', 'occupied'))) {
        $data['status'] = 'available';
      }

      $model = new Kaddora_Property_Model($data);

      $property_id = $this->repo->insert((array)$model);

      if ($property_id) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $property_id;
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
      if (!$id) return false;

      return $this->repo->get($id);
    }

    /**
     * delete
     */
    public function delete($id)
    {
      if (!$id) return false;

      $deleted = $this->repo->delete($id);

      if ($deleted) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $deleted;
    }

    /**
     * update
     */
    public function update($id, $data)
    {

      if (!$id) {
        return new WP_Error('invalid_id', __('Invalid property ID', 'kaddora-ai-property'));
      }

      if (!Kaddora_Validator::required($data['name'] ?? '')) {
        return new WP_Error('invalid_name', __('Property name required', 'kaddora-ai-property'));
      }

      if (!Kaddora_Validator::valid_status($data['status'] ?? '', array('available', 'occupied'))) {
        $data['status'] = 'available';
      }

      $model = new Kaddora_Property_Model($data);

      $updated = $this->repo->update($id, (array)$model);

      if ($updated !== false) {
        delete_transient('kaddora_dashboard_stats');
      }

      return $updated;
    }
  }
}
