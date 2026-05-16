<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Tenant_Model')) {

  class Kaddora_Tenant_Model
  {

    public $id;
    public $property_id;
    public $name;
    public $email;
    public $phone;

    public function __construct($data = array())
    {
      $this->id = intval($data['id'] ?? 0);
      $this->property_id = intval($data['property_id'] ?? 0);
      $this->name = sanitize_text_field($data['name'] ?? '');
      $this->email = sanitize_email($data['email'] ?? '');
      $this->phone = sanitize_text_field($data['phone'] ?? '');
    }
  }
}
