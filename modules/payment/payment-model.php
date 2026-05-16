<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Payment_Model')) {

  class Kaddora_Payment_Model
  {

    public $id;
    public $tenant_id;
    public $amount;
    public $status;
    public $paid_at;

    public function __construct($data = array())
    {
      $this->id = intval($data['id'] ?? 0);
      $this->tenant_id = intval($data['tenant_id'] ?? 0);
      $this->amount = floatval($data['amount'] ?? 0);
      $this->status = sanitize_text_field($data['status'] ?? 'pending');
      $this->paid_at = $data['paid_at'] ?? current_time('mysql');
    }
  }
}
