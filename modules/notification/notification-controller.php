<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Notification_Controller')) {

  class Kaddora_Notification_Controller
  {
    /**
     * init
     */
    public function init()
    {
      add_action(
        'admin_post_kaddora_send_due_reminders',
        array($this, 'send_due_reminders')
      );
    }

    /**
     * Send Reminders
     */
    public function send_due_reminders()
    {

      if (!current_user_can('manage_options')) {
        wp_die('Permission denied');
      }

      if (
        !isset($_POST['_wpnonce']) ||
        !wp_verify_nonce($_POST['_wpnonce'], 'kaddora_send_reminders')
      ) {
        wp_die('Security check failed');
      }

      $reminder = new Kaddora_Reminder_Service();

      $sent = $reminder->send_due_reminders();

      wp_safe_redirect(
        add_query_arg(
          array(
            'kaddora_notice' => 'reminders',
            'count' => intval($sent),
          ),
          admin_url('admin.php?page=kaddora-invoices')
        )
      );

      exit;
    }
  }
}
