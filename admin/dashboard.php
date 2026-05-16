
<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Report_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'services/report.php';
}

if (!class_exists('Kaddora_Formatter')) {
  require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
}

$report = new Kaddora_Report_Service();

$total_properties = $report->total_properties();
$total_tenants    = $report->total_tenants();
$total_revenue    = $report->total_revenue();
$pending_invoices = $report->pending_invoices();
$occupancy_rate   = $report->occupancy_rate();
?>

<div id="kaddora-dashboard-page" class="wrap kaddora-admin-page kaddora-dashboard-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Overview', 'kaddora-ai-property'); ?></span>
      <h1><?php _e('Kaddora Dashboard', 'kaddora-ai-property'); ?></h1>
    </div>
  </div>

  <div class="kaddora-stat-grid">

    <div class="kaddora-stat-card">
      <h2><?php _e('Properties', 'kaddora-ai-property'); ?></h2>
      <p>
        <?php echo esc_html($total_properties); ?>
      </p>
    </div>

    <div class="kaddora-stat-card">
      <h2><?php _e('Tenants', 'kaddora-ai-property'); ?></h2>
      <p>
        <?php echo esc_html($total_tenants); ?>
      </p>
    </div>

    <div class="kaddora-stat-card">
      <h2><?php _e('Revenue', 'kaddora-ai-property'); ?></h2>
      <p>
        <?php echo wp_kses_post(Kaddora_Formatter::currency($total_revenue)); ?>
      </p>
    </div>

    <div class="kaddora-stat-card kaddora-stat-card-warning">
      <h2><?php _e('Pending Invoices', 'kaddora-ai-property'); ?></h2>
      <p>
        <?php echo esc_html($pending_invoices); ?>
      </p>
    </div>

    <div class="kaddora-stat-card kaddora-stat-card-success">
      <h2><?php _e('Occupancy Rate', 'kaddora-ai-property'); ?></h2>
      <p>
        <?php echo esc_html($occupancy_rate); ?>%
      </p>
    </div>

  </div>

</div>
