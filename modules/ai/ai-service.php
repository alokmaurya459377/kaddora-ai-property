<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_AI_Service')) {

  class Kaddora_AI_Service
  {

    /**
     * Constructor
     */
    public function __construct()
    {
      if (!class_exists('Kaddora_AI_Prompts')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/ai/prompts.php';
      }

      if (!class_exists('Kaddora_Formatter')) {
        require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
      }
    }

    /**
     * Generate Reminder Message
     */
    public function generate_rent_reminder(
      $tenant_name,
      $amount
    ) {

      $prompt = Kaddora_AI_Prompts::rent_reminder();

      return sprintf(
        __(
          'Hello %1$s, your rent payment of %2$s is pending. Please pay before due date.',
          'kaddora-ai-property'
        ),
        esc_html($tenant_name),
        esc_html(
          Kaddora_Formatter::currency($amount)
        )
      );
    }

    /**
     * Generate Payment Success
     */
    public function generate_payment_success(
      $tenant_name,
      $amount
    ) {

      return sprintf(
        __(
          'Hello %1$s, we received your payment of %2$s successfully.',
          'kaddora-ai-property'
        ),
        esc_html($tenant_name),
        esc_html(
          Kaddora_Formatter::currency($amount)
        )
      );
    }
  }
}
