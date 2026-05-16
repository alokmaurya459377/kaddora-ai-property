<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('Kaddora_DB_Schema')) {

  class Kaddora_DB_Schema
  {

    /**
     * get_tables
     */
    public static function get_tables()
    {

      global $wpdb;

      $charset_collate = $wpdb->get_charset_collate();

      return array(
        "CREATE TABLE {$wpdb->prefix}kaddora_properties (
          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
          name VARCHAR(255) NOT NULL,
          address TEXT,
          rent DECIMAL(10,2),
          status VARCHAR(50),
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          KEY status (status),
          PRIMARY KEY (id)
        ) $charset_collate;",

        "CREATE TABLE {$wpdb->prefix}kaddora_tenants (
          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
          property_id BIGINT UNSIGNED,
          name VARCHAR(255),
          email VARCHAR(255),
          phone VARCHAR(50),
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          KEY property_id (property_id),
          KEY email (email),
          PRIMARY KEY (id)
        ) $charset_collate;",

        "CREATE TABLE {$wpdb->prefix}kaddora_payments (
          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
          tenant_id BIGINT UNSIGNED,
          amount DECIMAL(10,2),
          status VARCHAR(50),
          paid_at DATETIME,
          KEY tenant_id (tenant_id),
          KEY status (status),
          PRIMARY KEY (id)
        ) $charset_collate;",

        "CREATE TABLE {$wpdb->prefix}kaddora_invoices (
          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
          tenant_id BIGINT UNSIGNED,
          total DECIMAL(10,2),
          due_date DATE,
          status VARCHAR(50),
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          KEY tenant_id (tenant_id),
          KEY status (status),
          KEY due_date (due_date),
          PRIMARY KEY (id)
        ) $charset_collate;"
      );
    }
  }
}
