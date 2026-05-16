<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Invoice_Model')) {

  class Kaddora_Invoice_Model
  {

    public $id;
    public $tenant_id;
    public $total;
    public $due_date;
    public $status;
    public $created_at;

    public function __construct($data = array())
    {

      $this->id         = intval($data['id'] ?? 0);
      $this->tenant_id  = intval($data['tenant_id'] ?? 0);
      $this->total      = floatval($data['total'] ?? 0);
      $this->due_date   = sanitize_text_field($data['due_date'] ?? '');
      $this->status     = sanitize_text_field($data['status'] ?? 'unpaid');
      $this->created_at = $data['created_at'] ?? current_time('mysql');
    }
  }
}
