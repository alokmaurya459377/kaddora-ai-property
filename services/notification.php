<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Notification_Service')) {

  class Kaddora_Notification_Service
  {
    /**
     * Constructor
     */
    public function __construct()
    {
      if (!class_exists('Kaddora_Email')) {
        require_once KADDORA_PROPERTY_PATH . 'integrations/email.php';
      }

      if (!class_exists('Kaddora_WhatsApp')) {
        require_once KADDORA_PROPERTY_PATH . 'integrations/whatsapp.php';
      }
    }

    /**
     * Send Email
     */
    public function send_email(
      $to,
      $subject,
      $message
    ) {
      return Kaddora_Email::send(
        $to,
        $subject,
        $message
      );
    }

    /**
     * Send WhatsApp
     */
    public function send_whatsapp(
      $phone,
      $message
    ) {
      return Kaddora_WhatsApp::send(
        $phone,
        $message
      );
    }

    /**
     * Send Multi Channel
     */
    public function send_multi_channel(
      $tenant,
      $subject,
      $message
    ) {
      $sent = array(
        'email' => false,
        'whatsapp' => false,
      );

      /**
       * Email
       */
      if (!empty($tenant['email'])) {

        $sent['email'] = $this->send_email(
          $tenant['email'],
          $subject,
          $message
        );
      }

      /**
       * WhatsApp
       */
      if (!empty($tenant['phone'])) {

        $sent['whatsapp'] = $this->send_whatsapp(
          $tenant['phone'],
          wp_strip_all_tags($message)
        );
      }

      return $sent;
    }
  }
}
