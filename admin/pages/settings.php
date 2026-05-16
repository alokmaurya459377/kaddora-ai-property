
<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Subscription_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/subscription/subscription-service.php';
}

$subscription = new Kaddora_Subscription_Service();
$current_plan = $subscription->current_plan();
?>

<div id="kaddora-settings-page" class="wrap kaddora-admin-page kaddora-settings-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Configuration', 'kaddora-ai-property'); ?></span>
      <h1><?php esc_html_e('Kaddora Settings', 'kaddora-ai-property'); ?></h1>
    </div>
  </div>

  <section class="kaddora-panel kaddora-settings-panel">

  <table class="form-table kaddora-form-table">

    <tr>
      <th scope="row">
        <?php esc_html_e('Current Plan', 'kaddora-ai-property'); ?>
      </th>
      <td>
        <strong>
          <span class="kaddora-plan-pill">
            <?php echo esc_html(strtoupper($current_plan)); ?>
          </span>
        </strong>
      </td>
    </tr>

    <tr>
      <th scope="row">
        <?php esc_html_e('License Ready', 'kaddora-ai-property'); ?>
      </th>
      <td>
        <?php esc_html_e('This plugin is prepared for future Gumroad, Freemius, or custom license integration.', 'kaddora-ai-property'); ?>
      </td>
    </tr>

  </table>

  </section>

</div>
