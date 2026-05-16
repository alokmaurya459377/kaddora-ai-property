<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Property_API')) {

  class Kaddora_Property_API
  {
    public function init()
    {
      register_rest_route(
        'kaddora/v1',
        '/properties',
        array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array($this, 'get_properties'),
          'permission_callback' => array('Kaddora_API_Auth', 'logged_in'),
        )
      );

      register_rest_route(
        'kaddora/v1',
        '/properties/(?P<id>\d+)',
        array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array($this, 'get_property'),
          'permission_callback' => array('Kaddora_API_Auth', 'logged_in'),
        )
      );

      register_rest_route(
        'kaddora/v1',
        '/properties',
        array(
          'methods'  => WP_REST_Server::CREATABLE,
          'callback' => array($this, 'create_property'),
          'permission_callback' => array('Kaddora_API_Auth', 'admin_only'),
        )
      );
    }

    /**
     * create_property
     */
    public function create_property($request)
    {

      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';

      $service = new Kaddora_Property_Service();

      $data = array(
        'name' => sanitize_text_field($request->get_param('name') ?? ''),
        'address' => sanitize_textarea_field($request->get_param('address') ?? ''),
        'rent' => floatval($request->get_param('rent') ?? 0),
        'status' => Kaddora_Validator::valid_status($request->get_param('status') ?? '', array('available', 'occupied'))
          ? sanitize_text_field($request->get_param('status'))
          : 'available',
      );

      /**
       * Validation
       */
      if (!Kaddora_Validator::required($data['name'])) {

        return Kaddora_API_Response::error(
          __('Property name required', 'kaddora-ai-property'),
          422
        );
      }

      $id = $service->create($data);

      if (is_wp_error($id)) {

        return Kaddora_API_Response::error(
          $id->get_error_message(),
          400
        );
      }

      return Kaddora_API_Response::success(
        array(
          'property_id' => $id,
        ),
        __('Property created successfully', 'kaddora-ai-property')
      );
    }

    /**
     * All Properties
     */
    public function get_properties()
    {
      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';

      $service = new Kaddora_Property_Service();

      $properties = $service->list();

      return Kaddora_API_Response::success(
        $properties,
        __('Properties fetched successfully', 'kaddora-ai-property')
      );
    }

    /**
     * Single Property
     */
    public function get_property($request)
    {

      require_once KADDORA_PROPERTY_PATH . 'modules/property/property-service.php';

      $service = new Kaddora_Property_Service();

      $id = intval($request['id']);

      $property = $service->get($id);

      if (!$property) {

        return new WP_Error(
          'not_found',
          __('Property not found', 'kaddora-ai-property'),
          array('status' => 404)
        );
      }

      return rest_ensure_response($property);
    }
  }
}
