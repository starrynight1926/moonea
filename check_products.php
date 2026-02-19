<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');
$products = wc_get_products(['limit' => 5]);
echo "Product count: " . count($products) . "\n";
foreach ($products as $product) {
    echo "Product: " . $product->get_name() . " (ID: " . $product->get_id() . ")\n";
}
?>