<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Email')) {

  class Kaddora_Email
  {
    /**
     * Send Email
     */
    public static function send($to, $subject, $message)
    {

      $headers = array(
        'Content-Type: text/html; charset=UTF-8'
      );

      return wp_mail(
        $to,
        $subject,
        $message,
        $headers
      );
    }
  }
}
