<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_Container')) {

  class Kaddora_Container
  {

    private $services = array();

    /**
     * Register service
     */
    public function set($key, $callback)
    {

      if (!isset($this->services[$key])) {
        $this->services[$key] = $callback;
      }
    }

    /**
     * Get service
     */
    public function get($key)
    {

      if (isset($this->services[$key])) {

        // Lazy load
        if (is_callable($this->services[$key])) {
          $this->services[$key] = call_user_func($this->services[$key]);
        }

        return $this->services[$key];
      }

      return null;
    }

    /**
     * Check exists
     */
    public function has($key)
    {
      return isset($this->services[$key]);
    }
  }
}
