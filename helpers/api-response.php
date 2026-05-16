<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_API_Response')) {

  class Kaddora_API_Response
  {
    /**
     * Success 
     */
    public static function success($data = array(), $message = '')
    {
      return rest_ensure_response(
        array(
          'success' => true,
          'message' => $message,
          'data'    => $data,
        )
      );
    }

    /**
     * Error Response
     */
    public static function error($message = '', $status = 400)
    {
      return new WP_Error(
        'kaddora_api_error',
        $message,
        array('status' => $status)
      );
    }
  }
}
