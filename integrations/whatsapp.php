<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_WhatsApp')) {

  class Kaddora_WhatsApp
  {

    /**
     * Send WhatsApp Message
     */
    public static function send(
      $phone,
      $message
    ) {

      /**
       * Future API Integration
       * Twilio / Meta / Gupshup
       */

      if (empty($phone) || empty($message)) {
        return false;
      }

      /**
       * TEMP LOG
       */
      error_log(
        '[Kaddora WhatsApp] To: '
          . $phone .
          ' | Message: ' .
          wp_strip_all_tags($message)
      );

      return true;
    }
  }
}
