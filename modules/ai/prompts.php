<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_AI_Prompts')) {

  class Kaddora_AI_Prompts
  {

    /**
     * Rent Reminder Prompt
     */
    public static function rent_reminder()
    {

      return "
                Write a professional rent reminder message.
                Keep it polite and concise.
            ";
    }

    /**
     * Payment Success Prompt
     */
    public static function payment_success()
    {

      return "
                Write a friendly payment success message
                for a tenant.
            ";
    }
  }
}
