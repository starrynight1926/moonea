<?php
require_once('./wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

$plugin_path = 'etsy-style-woo/etsy-style-woo.php';
$result = activate_plugin($plugin_path);

if (is_wp_error($result)) {
    echo "Error: " . $result->get_error_message() . "\n";
} else {
    echo "Plugin activated successfully.\n";
}
?>