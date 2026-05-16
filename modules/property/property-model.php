<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_Model')) {

  class Kaddora_Property_Model
  {

    public $id;
    public $name;
    public $address;
    public $rent;
    public $status;

    public function __construct($data = array())
    {
      if (!empty($data)) {
        $this->map($data);
      }
    }

    /**
     * map
     */
    public function map($data)
    {
      $this->id = isset($data['id']) ? intval($data['id']) : 0;
      $this->name = isset($data['name']) ? sanitize_text_field($data['name']) : '';
      $this->address = isset($data['address']) ? sanitize_textarea_field($data['address']) : '';
      $this->rent = isset($data['rent']) ? floatval($data['rent']) : 0;
      $this->status = isset($data['status']) ? sanitize_text_field($data['status']) : 'available';
    }
  }
}
