<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

// Clean options
delete_option('kaddora_property_version');
delete_option('kaddora_property_db_version');
delete_option('kaddora_pro_active');

// Clean transients
delete_transient('kaddora_dashboard_stats');
