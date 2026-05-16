<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Reminder_Service')) {

  class Kaddora_Reminder_Service
  {
    /**
     * send_due_reminders
     */
    public function send_due_reminders()
    {
      global $wpdb;

      $table = $wpdb->prefix . 'kaddora_invoices';

      $invoices = $wpdb->get_results(
        "SELECT * FROM {$table}
         WHERE status = 'unpaid'",
        ARRAY_A
      );

      if (empty($invoices)) {
        return 0;
      }

      if (!class_exists('Kaddora_Notification_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'services/notification.php';
      }

      if (!class_exists('Kaddora_AI_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/ai/ai-service.php';
      }

      if (!class_exists('Kaddora_Tenant_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
      }

      $tenant_service = new Kaddora_Tenant_Service();
      $notification_service = new Kaddora_Notification_Service();
      $ai_service = new Kaddora_AI_Service();
      $sent_count = 0;

      foreach ($invoices as $invoice) {

        $tenant = $tenant_service->get($invoice['tenant_id']);

        if (!$tenant) {
          continue;
        }

        /**
         * AI Message
         */
        $message = $ai_service->generate_rent_reminder(
          $tenant['name'],
          $invoice['total']
        );

        /**
         * Subject
         */
        $subject = __(
          'Rent Payment Reminder',
          'kaddora-ai-property'
        );

        /**
         * Multi Channel Send
         */
        $result = $notification_service->send_multi_channel(
          $tenant,
          $subject,
          nl2br($message)
        );

        if (!empty($result['email']) || !empty($result['whatsapp'])) {
          $sent_count++;
        }
      }

      return $sent_count;
    }

    /**
     * payment_success
     */
    public function payment_success($tenant, $amount)
    {
      if (empty($tenant)) {
        return;
      }

      if (!class_exists('Kaddora_Notification_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'services/notification.php';
      }

      if (!class_exists('Kaddora_AI_Service')) {
        require_once KADDORA_PROPERTY_PATH . 'modules/ai/ai-service.php';
      }

      $ai_service = new Kaddora_AI_Service();
      $notification_service = new Kaddora_Notification_Service();

      /**
       * AI Message
       */
      $message = $ai_service->generate_payment_success(
        $tenant['name'],
        $amount
      );

      /**
       * Subject
       */
      $subject = __(
        'Payment Received',
        'kaddora-ai-property'
      );

      /**
       * Send Notification
       */
      return $notification_service->send_multi_channel(
        $tenant,
        $subject,
        nl2br($message)
      );
    }
  }
}
