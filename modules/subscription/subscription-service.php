<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Subscription_Service')) {

  class Kaddora_Subscription_Service
  {
    /**
     * Constructor
     */
    public function __construct()
    {
      if (!function_exists('kaddora_is_pro')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/subscription/pro-lock.php';
      }
    }

    /**
     * Current Plan
     */
    public function current_plan()
    {
      return kaddora_is_pro() ? 'pro' : 'free';
    }

    /**
     * Feature Access
     */
    public function can_use($feature)
    {
      $free_features = array(
        'properties',
        'tenants',
        'payments',
        'invoices',
        'email_notifications',
      );

      if (in_array($feature, $free_features, true)) {
        return true;
      }

      return kaddora_is_pro();
    }

    /**
     * Pro Message
     */
    public function pro_message()
    {
      return __(
        'This feature is available in Kaddora Pro.',
        'kaddora-ai-property'
      );
    }
  }
}
