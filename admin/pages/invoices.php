<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Load Dependencies
 */
if (!class_exists('Kaddora_Invoice_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-service.php';
}

if (!class_exists('Kaddora_Tenant_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
}

if (!class_exists('Kaddora_Formatter')) {
  require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
}

$invoice_service = new Kaddora_Invoice_Service();
$tenant_service  = new Kaddora_Tenant_Service();

/**
 * Fetch Data
 */
$invoices = $invoice_service->list();
$tenants  = $tenant_service->list();

/**
 * Tenant Map
 */
$tenant_map = array();

if (!empty($tenants)) {
  foreach ($tenants as $tenant) {
    $tenant_map[$tenant['id']] = $tenant['name'];
  }
}
?>

<div id="kaddora-invoices-page" class="wrap kaddora-admin-page kaddora-invoices-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Billing', 'kaddora-ai-property'); ?></span>
      <h1>
        <?php esc_html_e('Invoices', 'kaddora-ai-property'); ?>
      </h1>
    </div>
  </div>

  <?php if (!empty($_GET['kaddora_notice'])) : ?>
    <?php
    $notice_type = sanitize_key($_GET['kaddora_notice']);
    $notice_count = intval($_GET['count'] ?? 0);
    ?>

    <?php if ($notice_type === 'generated') : ?>
      <div class="notice notice-success is-dismissible">
        <p>
          <?php
          printf(
            esc_html__('%d monthly invoice(s) generated.', 'kaddora-ai-property'),
            $notice_count
          );
          ?>
        </p>
      </div>
    <?php endif; ?>

    <?php if ($notice_type === 'reminders') : ?>
      <div class="notice notice-success is-dismissible">
        <p>
          <?php
          printf(
            esc_html__('%d tenant reminder(s) sent.', 'kaddora-ai-property'),
            $notice_count
          );
          ?>
        </p>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="kaddora-panel kaddora-toolbar-panel">

    <!-- GENERATE -->
    <form class="kaddora-inline-form" method="post"
      action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

      <?php wp_nonce_field('kaddora_generate_invoice_nonce'); ?>

      <input type="hidden"
        name="action"
        value="kaddora_generate_invoice">

      <button type="submit"
        class="button button-secondary kaddora-button-secondary">

        <?php esc_html_e(
          'Generate Monthly Invoices',
          'kaddora-ai-property'
        ); ?>

      </button>

    </form>

    <!-- REMINDERS -->
    <form class="kaddora-inline-form" method="post"
      action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
      >

      <?php wp_nonce_field('kaddora_send_reminders'); ?>

      <input type="hidden"
        name="action"
        value="kaddora_send_due_reminders">

      <button type="submit"
        class="button button-primary kaddora-button-primary">

        <?php esc_html_e(
          'Send Due Reminders',
          'kaddora-ai-property'
        ); ?>

      </button>

    </form>

  </div>

  <!-- TABLE -->
  <section class="kaddora-panel kaddora-list-panel">

  <table class="widefat fixed striped kaddora-table">

    <thead>
      <tr>
        <th>
          <?php esc_html_e('ID', 'kaddora-ai-property'); ?>
        </th>

        <th>
          <?php esc_html_e('Tenant', 'kaddora-ai-property'); ?>
        </th>

        <th>
          <?php esc_html_e('Total', 'kaddora-ai-property'); ?>
        </th>

        <th>
          <?php esc_html_e('Due Date', 'kaddora-ai-property'); ?>
        </th>

        <th>
          <?php esc_html_e('Status', 'kaddora-ai-property'); ?>
        </th>
      </tr>
    </thead>

    <tbody>
      <?php if (!empty($invoices)) : ?>
        <?php foreach ($invoices as $invoice) : ?>
          <tr>

            <td>
              <?php echo esc_html($invoice['id']); ?>
            </td>

            <td>
              <?php
              echo esc_html(
                $tenant_map[$invoice['tenant_id']] ?? '-'
              );
              ?>
            </td>

            <td>
              <?php
              echo wp_kses_post(
                Kaddora_Formatter::currency(
                  $invoice['total']
                )
              );
              ?>
            </td>

            <td>
              <?php
              echo esc_html(
                Kaddora_Formatter::date(
                  $invoice['due_date']
                )
              );
              ?>
            </td>

            <td>
              <?php
              echo wp_kses_post(
                Kaddora_Formatter::status_badge(
                  $invoice['status']
                )
              );
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td class="kaddora-empty-state" colspan="5">
            <?php esc_html_e(
              'No invoices found.',
              'kaddora-ai-property'
            ); ?>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>

  </table>

  </section>

</div>
