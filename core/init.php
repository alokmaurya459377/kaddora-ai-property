<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Init')) {

  class Kaddora_Init
  {
    protected $loader;
    protected $container;
    protected $property_controller;

    public function __construct()
    {
      $this->load_dependencies();
      $this->define_hooks();
    }

    /**
     * Load only required core files
     */
    private function load_dependencies()
    {

      require_once KADDORA_PROPERTY_PATH . 'core/loader.php';
      require_once KADDORA_PROPERTY_PATH . 'core/activator.php';
      require_once KADDORA_PROPERTY_PATH . 'core/deactivator.php';
      require_once KADDORA_PROPERTY_PATH . 'core/container.php';

      require_once KADDORA_PROPERTY_PATH . 'helpers/common.php';
      require_once KADDORA_PROPERTY_PATH . 'helpers/validator.php';
      require_once KADDORA_PROPERTY_PATH . 'helpers/formatter.php';
      require_once KADDORA_PROPERTY_PATH . 'helpers/api-response.php';
      require_once KADDORA_PROPERTY_PATH . 'helpers/api-auth.php';
      require_once KADDORA_PROPERTY_PATH . 'helpers/logger.php';

      require_once KADDORA_PROPERTY_PATH . 'services/report.php';
      require_once KADDORA_PROPERTY_PATH . 'services/reminder.php';

      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-controller.php';

      require_once KADDORA_PROPERTY_PATH . 'admin/menu.php';

      require_once KADDORA_PROPERTY_PATH . 'modules/tenant/tenant-controller.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/payment/payment-controller.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/invoice/invoice-controller.php';

      require_once KADDORA_PROPERTY_PATH . 'frontend/shortcodes.php';

      require_once KADDORA_PROPERTY_PATH . 'api/rest.php';

      require_once KADDORA_PROPERTY_PATH . 'integrations/email.php';

      require_once KADDORA_PROPERTY_PATH . 'modules/notification/notification-controller.php';

      require_once KADDORA_PROPERTY_PATH . 'modules/ai/prompts.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/ai/ai-service.php';

      require_once KADDORA_PROPERTY_PATH . 'integrations/whatsapp.php';
      require_once KADDORA_PROPERTY_PATH . 'services/notification.php';

      require_once KADDORA_PROPERTY_PATH . 'modules/subscription/pro-lock.php';
      require_once KADDORA_PROPERTY_PATH . 'modules/subscription/subscription-service.php';

      (new Kaddora_Notification_Controller())->init();

      (new Kaddora_REST_API())->init();

      (new Kaddora_Frontend_Shortcodes())->init();

      (new Kaddora_Invoice_Controller())->init();

      (new Kaddora_Payment_Controller())->init();

      (new Kaddora_Tenant_Controller())->init();

      (new Kaddora_Admin_Menu())->init();

      add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
      add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));

      $this->loader = new Kaddora_Loader();
      $this->container = new Kaddora_Container();

      ($this->property_controller = new Kaddora_Property_Controller())->init();
    }

    /**
     * Enqueue Admin Assets
     */
    public function enqueue_admin_assets($hook)
    {
      if (strpos($hook, 'kaddora') === false) {
        return;
      }

      wp_enqueue_style(
        'kaddora-admin',
        KADDORA_PROPERTY_URL . 'admin/assets/css/admin.css',
        array(),
        KADDORA_PROPERTY_VERSION
      );

      wp_enqueue_script(
        'kaddora-admin',
        KADDORA_PROPERTY_URL . 'admin/assets/js/admin.js',
        array('jquery'),
        KADDORA_PROPERTY_VERSION,
        true
      );
    }

    /**
     * Enqueue Frontend Assets
     */
    public function enqueue_frontend_assets()
    {
      wp_enqueue_style(
        'kaddora-frontend',
        KADDORA_PROPERTY_URL . 'frontend/assets/css/frontend.css',
        array(),
        KADDORA_PROPERTY_VERSION
      );
    }

    /**
     * Register hooks
     */
    private function define_hooks()
    {

      if (class_exists('Kaddora_Activator')) {
        register_activation_hook(
          KADDORA_PROPERTY_PATH . 'kaddora-ai-property.php',
          array('Kaddora_Activator', 'activate')
        );
      }

      if (class_exists('Kaddora_Deactivator')) {
        register_deactivation_hook(
          KADDORA_PROPERTY_PATH . 'kaddora-ai-property.php',
          array('Kaddora_Deactivator', 'deactivate')
        );
      }
    }

    /**
     * Run loader
     */
    public function run()
    {

      if ($this->loader && method_exists($this->loader, 'run')) {
        $this->loader->run();
      }
    }
  }
}
