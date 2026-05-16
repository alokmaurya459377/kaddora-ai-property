<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';
}

if (!class_exists('Kaddora_Formatter')) {
  require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
}

$service = new Kaddora_Property_Service();

$properties = $service->list();
?>

<div class="kaddora-property-list">
  <h2><?php _e('Available Properties', 'kaddora-ai-property'); ?></h2>

  <?php if (!empty($properties)) : ?>

    <table>

      <thead>
        <tr>
          <th><?php _e('Name', 'kaddora-ai-property'); ?></th>
          <th><?php _e('Rent', 'kaddora-ai-property'); ?></th>
          <th><?php _e('Status', 'kaddora-ai-property'); ?></th>
        </tr>
      </thead>

      <tbody>

        <?php foreach ($properties as $property) : ?>

          <tr>

            <td>
              <?php echo esc_html($property['name']); ?>
            </td>

            <td>
              <?php echo wp_kses_post(
                Kaddora_Formatter::currency($property['rent'])
              ); ?>
            </td>

            <td>
              <?php echo wp_kses_post(
                Kaddora_Formatter::status_badge($property['status'])
              ); ?>
            </td>

          </tr>

        <?php endforeach; ?>

      </tbody>

    </table>

  <?php else : ?>

    <p>
      <?php _e('No properties found.', 'kaddora-ai-property'); ?>
    </p>

  <?php endif; ?>

</div>
