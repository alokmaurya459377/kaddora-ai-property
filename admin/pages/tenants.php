<?php

if (!defined('ABSPATH')) exit;

/**
 * Load Services
 */
if (!class_exists('Kaddora_Tenant_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-service.php';
}

if (!class_exists('Kaddora_Property_Service')) {
  require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';
}

$tenantService   = new Kaddora_Tenant_Service();
$propertyService = new Kaddora_Property_Service();

$tenants    = $tenantService->list();
$properties = $propertyService->list();

/**
 * Property Map (ID → Name)
 */
$property_map = array();
if (!empty($properties)) {
  foreach ($properties as $property) {
    $property_map[$property['id']] = $property['name'];
  }
}

/**
 * Edit Mode
 */
$edit_tenant = null;
if (isset($_GET['edit'])) {
  $edit_tenant = $tenantService->get(intval($_GET['edit']));
}

/**
 * Dynamic Form
 */
$form_action = $edit_tenant ? 'kaddora_update_tenant' : 'kaddora_save_tenant';
$button_text = $edit_tenant ? __('Update Tenant', 'kaddora-ai-property') : __('Save Tenant', 'kaddora-ai-property');
?>

<div id="kaddora-tenants-page" class="wrap kaddora-admin-page kaddora-crud-page">

  <div class="kaddora-admin-header">
    <div>
      <span class="kaddora-eyebrow"><?php esc_html_e('Management', 'kaddora-ai-property'); ?></span>
      <h1><?php _e('Tenants', 'kaddora-ai-property'); ?></h1>
    </div>
  </div>

  <div class="kaddora-admin-grid">
    <section class="kaddora-panel kaddora-form-panel">

      <!-- FORM -->
      <h2><?php _e('Add / Edit Tenant', 'kaddora-ai-property'); ?></h2>

      <form class="kaddora-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

        <?php wp_nonce_field('kaddora_tenant_nonce'); ?>

        <input type="hidden" name="action" value="<?php echo esc_attr($form_action); ?>">
        <input type="hidden" name="id" value="<?php echo esc_attr($edit_tenant['id'] ?? ''); ?>">

        <table class="form-table kaddora-form-table">

      <tr>
        <th><?php _e('Name', 'kaddora-ai-property'); ?></th>
        <td>
          <input type="text" name="name" required
            value="<?php echo esc_attr($edit_tenant['name'] ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <th><?php _e('Email', 'kaddora-ai-property'); ?></th>
        <td>
          <input type="email" name="email"
            value="<?php echo esc_attr($edit_tenant['email'] ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <th><?php _e('Phone', 'kaddora-ai-property'); ?></th>
        <td>
          <input type="text" name="phone"
            value="<?php echo esc_attr($edit_tenant['phone'] ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <th><?php _e('Property', 'kaddora-ai-property'); ?></th>
        <td>
          <select name="property_id" required>

            <option value=""><?php _e('Select Property', 'kaddora-ai-property'); ?></option>

            <?php if (!empty($properties)) : ?>
              <?php foreach ($properties as $property) : ?>
                <option value="<?php echo esc_attr($property['id']); ?>"
                  <?php selected($edit_tenant['property_id'] ?? '', $property['id']); ?>>
                  <?php echo esc_html($property['name']); ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>

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
      <h2><?php _e('All Tenants', 'kaddora-ai-property'); ?></h2>

      <table class="widefat fixed striped kaddora-table">

    <thead>
      <tr>
        <th><?php _e('ID', 'kaddora-ai-property'); ?></th>
        <th><?php _e('Name', 'kaddora-ai-property'); ?></th>
        <th><?php _e('Email', 'kaddora-ai-property'); ?></th>
        <th><?php _e('Phone', 'kaddora-ai-property'); ?></th>
        <th><?php _e('Property', 'kaddora-ai-property'); ?></th>
        <th><?php _e('Actions', 'kaddora-ai-property'); ?></th>
      </tr>
    </thead>

    <tbody>

      <?php if (!empty($tenants)) : ?>

        <?php foreach ($tenants as $tenant) : ?>

          <tr>
            <td><?php echo esc_html($tenant['id']); ?></td>
            <td><?php echo esc_html($tenant['name']); ?></td>
            <td><?php echo esc_html($tenant['email']); ?></td>
            <td><?php echo esc_html($tenant['phone']); ?></td>

            <!-- PROPERTY NAME -->
            <td class="kaddora-row-actions">
              <?php
              $pid = $tenant['property_id'];
              echo isset($property_map[$pid])
                ? esc_html($property_map[$pid])
                : '-';
              ?>
            </td>

            <!-- ACTIONS -->
            <td>
              <a href="<?php echo esc_url(
                          admin_url('admin.php?page=kaddora-tenants&edit=' . intval($tenant['id']))
                        ); ?>">
                <?php _e('Edit', 'kaddora-ai-property'); ?>
              </a>

              |

              <a href="<?php echo esc_url(
                          wp_nonce_url(
                            admin_url('admin-post.php?action=kaddora_delete_tenant&id=' . intval($tenant['id'])),
                            'kaddora_delete_tenant'
                          )
                        ); ?>"
                onclick="return confirm('<?php echo esc_js(__('Delete this tenant?', 'kaddora-ai-property')); ?>');">
                <?php _e('Delete', 'kaddora-ai-property'); ?>
              </a>
            </td>

          </tr>

        <?php endforeach; ?>

      <?php else : ?>

        <tr>
          <td class="kaddora-empty-state" colspan="6">
            <?php _e('No tenants found', 'kaddora-ai-property'); ?>
          </td>
        </tr>

      <?php endif; ?>

    </tbody>

      </table>

    </section>
  </div>

</div>
