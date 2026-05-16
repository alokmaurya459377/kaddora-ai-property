<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Load Service
 */
if (!class_exists('Kaddora_Property_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';
}

if (!class_exists('Kaddora_Formatter')) {
  require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
}

$service = new Kaddora_Property_Service();
$properties = $service->list();

/**
 * Edit Mode
 */
$edit_property = null;

if (isset($_GET['edit'])) {
  $edit_property = $service->get(intval($_GET['edit']));
}

/**
 * Form Action
 */
$form_action = $edit_property ? 'kaddora_update_property' : 'kaddora_save_property';
$button_text = $edit_property ? __('Update Property', 'kaddora-ai-property') : __('Save Property', 'kaddora-ai-property');
?>

<div id="kaddora-properties-page" class="wrap kaddora-admin-page kaddora-crud-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Management', 'kaddora-ai-property'); ?></span>
      <h1><?php _e('Properties', 'kaddora-ai-property'); ?></h1>
    </div>
  </div>

  <div class="kaddora-admin-grid">
    <section class="kaddora-panel kaddora-form-panel">

      <!-- FORM -->
      <h2><?php _e('Add / Edit Property', 'kaddora-ai-property'); ?></h2>

      <form class="kaddora-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

        <?php wp_nonce_field('kaddora_property_nonce'); ?>

        <input type="hidden" name="action" value="<?php echo esc_attr($form_action); ?>">
        <input type="hidden" name="id" value="<?php echo esc_attr($edit_property['id'] ?? ''); ?>">

        <table class="form-table kaddora-form-table">

          <tr>
            <th><?php _e('Name', 'kaddora-ai-property'); ?></th>
            <td>
              <input type="text" name="name" required
                value="<?php echo esc_attr($edit_property['name'] ?? ''); ?>">
            </td>
          </tr>

          <tr>
            <th><?php _e('Address', 'kaddora-ai-property'); ?></th>
            <td>
              <textarea name="address"><?php echo esc_textarea($edit_property['address'] ?? ''); ?></textarea>
            </td>
          </tr>

          <tr>
            <th><?php _e('Rent', 'kaddora-ai-property'); ?></th>
            <td>
              <input type="number" name="rent"
                value="<?php echo esc_attr($edit_property['rent'] ?? ''); ?>">
            </td>
          </tr>

          <tr>
            <th><?php _e('Status', 'kaddora-ai-property'); ?></th>
            <td>
              <select name="status">
                <option value="available" <?php selected($edit_property['status'] ?? '', 'available'); ?>>
                  <?php _e('Available', 'kaddora-ai-property'); ?>
                </option>
                <option value="occupied" <?php selected($edit_property['status'] ?? '', 'occupied'); ?>>
                  <?php _e('Occupied', 'kaddora-ai-property'); ?>
                </option>
              </select>
            </td>
          </tr>

        </table>

        <p class="kaddora-form-actions">
          <button class="button button-primary kaddora-button-primary">
            <?php echo esc_html($button_text); ?>
          </button>
        </p>

      </form>

    </section>

    <section class="kaddora-panel kaddora-list-panel">

      <!-- LIST -->
      <h2><?php _e('All Properties', 'kaddora-ai-property'); ?></h2>

      <table class="widefat fixed striped kaddora-table">

        <thead>
          <tr>
            <th><?php _e('ID', 'kaddora-ai-property'); ?></th>
            <th><?php _e('Name', 'kaddora-ai-property'); ?></th>
            <th><?php _e('Rent', 'kaddora-ai-property'); ?></th>
            <th><?php _e('Status', 'kaddora-ai-property'); ?></th>
            <th><?php _e('Actions', 'kaddora-ai-property'); ?></th>
          </tr>
        </thead>

        <tbody>

      <?php if (!empty($properties)) : ?>

        <?php foreach ($properties as $property) : ?>

          <tr>
            <td><?php echo esc_html($property['id']); ?></td>
            <td><?php echo esc_html($property['name']); ?></td>
            <td><?php echo wp_kses_post(Kaddora_Formatter::currency($property['rent'])); ?></td>
            <td><?php echo wp_kses_post(Kaddora_Formatter::status_badge($property['status'])); ?></td>

            <td class="kaddora-row-actions">
              <!-- EDIT -->
              <a href="<?php echo esc_url(
                          admin_url('admin.php?page=kaddora-properties&edit=' . intval($property['id']))
                        ); ?>">
                <?php _e('Edit', 'kaddora-ai-property'); ?>
              </a>

              |

              <!-- DELETE -->
              <a href="<?php echo esc_url(
                          wp_nonce_url(
                            admin_url('admin-post.php?action=kaddora_delete_property&id=' . intval($property['id'])),
                            'kaddora_delete_property'
                          )
                        ); ?>"
                onclick="return confirm('<?php echo esc_js(__('Delete this property?', 'kaddora-ai-property')); ?>');">
                <?php _e('Delete', 'kaddora-ai-property'); ?>
              </a>
            </td>

          </tr>

        <?php endforeach; ?>

      <?php else : ?>

        <tr>
          <td class="kaddora-empty-state" colspan="5">
            <?php _e('No properties found', 'kaddora-ai-property'); ?>
          </td>
        </tr>

      <?php endif; ?>

        </tbody>

      </table>

    </section>
  </div>

</div>
