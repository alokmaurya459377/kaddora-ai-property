<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('Kaddora_Formatter')) {

  class Kaddora_Formatter
  {

    /**
     * Currency
     */
    public static function currency($amount)
    {

      return '&#8377;' . number_format((float)$amount, 2);
    }

    /**
     * Status Badge
     */
    public static function status_badge($status)
    {

      $status = strtolower($status);

      if ($status === 'paid') {
        return '<span style="color:green;font-weight:bold;">Paid</span>';
      }

      if ($status === 'unpaid') {
        return '<span style="color:red;font-weight:bold;">Unpaid</span>';
      }

      if ($status === 'occupied') {
        return '<span style="color:green;">Occupied</span>';
      }

      if ($status === 'available') {
        return '<span style="color:#2271b1;">Available</span>';
      }

      return esc_html(ucfirst($status));
    }

    /**
     * Date format
     */
    public static function date($date)
    {

      if (empty($date)) {
        return '-';
      }

      $timestamp = strtotime($date);

      if (!$timestamp) {
        return '-';
      }

      return date_i18n(
        get_option('date_format'),
        $timestamp
      );
    }
  }
}
