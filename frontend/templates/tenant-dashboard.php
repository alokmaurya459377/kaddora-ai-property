<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!is_user_logged_in()) {

  echo '<p>';
  esc_html_e('Please login to access dashboard.', 'kaddora-ai-property');
  echo '</p>';

  return;
}

$current_user = wp_get_current_user();

?>

<div class="kaddora-tenant-dashboard">

  <h2>
    <?php _e('Tenant Dashboard', 'kaddora-ai-property'); ?>
  </h2>

  <p>
    <?php _e('Welcome,', 'kaddora-ai-property'); ?>
    <strong>
      <?php echo esc_html($current_user->display_name); ?>
    </strong>
  </p>

  <hr>

  <h3>
    <?php _e('Quick Info', 'kaddora-ai-property'); ?>
  </h3>

  <ul>
    <li>
      <?php _e('View invoices', 'kaddora-ai-property'); ?>
    </li>

    <li>
      <?php _e('Track rent payments', 'kaddora-ai-property'); ?>
    </li>

    <li>
      <?php _e('Manage rental details', 'kaddora-ai-property'); ?>
    </li>
  </ul>

</div>