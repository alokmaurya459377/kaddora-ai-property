<?php

if (!defined('ABSPATH')) exit;

require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-service.php';
require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';

if (!class_exists('Kaddora_Formatter')) {
  require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
}

$paymentService = new Kaddora_Payment_Service();
$tenantService  = new Kaddora_Tenant_Service();

$payments = $paymentService->list();
$tenants  = $tenantService->list();

/**
 * Tenant Map
 */
$tenant_map = array();
foreach ($tenants as $t) {
  $tenant_map[$t['id']] = $t['name'];
}
?>

<div id="kaddora-payments-page" class="wrap kaddora-admin-page kaddora-crud-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Rent Collection', 'kaddora-ai-property'); ?></span>
      <h1><?php _e('Payments', 'kaddora-ai-property'); ?></h1>
    </div>
  </div>

  <div class="kaddora-admin-grid">
    <section class="kaddora-panel kaddora-form-panel">

      <!-- FORM -->
      <h2><?php _e('Add Payment', 'kaddora-ai-property'); ?></h2>

      <form class="kaddora-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

        <?php wp_nonce_field('kaddora_payment_nonce'); ?>

        <input type="hidden" name="action" value="kaddora_save_payment">

        <table class="form-table kaddora-form-table">

          <tr>
            <th><?php _e('Tenant', 'kaddora-ai-property'); ?></th>
            <td>
              <select name="tenant_id" required>
                <option value="">Select Tenant</option>

                <?php foreach ($tenants as $t) : ?>
                  <option value="<?php echo esc_attr($t['id']); ?>">
                    <?php echo esc_html($t['name']); ?>
                  </option>
                <?php endforeach; ?>

              </select>
            </td>
          </tr>

          <tr>
            <th><?php _e('Amount', 'kaddora-ai-property'); ?></th>
            <td><input type="number" name="amount" required></td>
          </tr>

          <tr>
            <th><?php _e('Status', 'kaddora-ai-property'); ?></th>
            <td>
              <select name="status">
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
              </select>
            </td>
          </tr>

        </table>

        <p class="kaddora-form-actions">
          <button class="button button-primary kaddora-button-primary">
            <?php _e('Save Payment', 'kaddora-ai-property'); ?>
          </button>
        </p>

      </form>

    </section>

    <section class="kaddora-panel kaddora-list-panel">

      <!-- LIST -->
      <h2><?php _e('All Payments', 'kaddora-ai-property'); ?></h2>

      <table class="widefat fixed striped kaddora-table">

        <thead>
          <tr>
            <th>ID</th>
            <th>Tenant</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>

        <tbody>

          <?php if (!empty($payments)) : ?>

            <?php foreach ($payments as $p) : ?>

              <tr>
                <td><?php echo esc_html($p['id']); ?></td>
                <td><?php echo esc_html($tenant_map[$p['tenant_id']] ?? '-'); ?></td>
                <td><?php echo wp_kses_post(Kaddora_Formatter::currency($p['amount'])); ?></td>
                <td><?php echo wp_kses_post(Kaddora_Formatter::status_badge($p['status'])); ?></td>
                <td><?php echo esc_html(Kaddora_Formatter::date($p['paid_at'])); ?></td>
              </tr>

            <?php endforeach; ?>

          <?php else : ?>

            <tr>
              <td class="kaddora-empty-state" colspan="5">No payments found</td>
            </tr>

          <?php endif; ?>

        </tbody>

      </table>

    </section>
  </div>

</div>