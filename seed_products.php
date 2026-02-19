<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

if (!class_exists('WooCommerce')) {
    echo "WooCommerce not active.\n";
    exit;
}

$user_id = get_current_user_id() ?: 1;

$product_data = [
    [
        'name' => 'Set of 5 Rustic Kitchen Prints',
        'price' => '384494',
        'sales' => 1250,
        'rating' => 5.0,
        'reviews' => 3100,
        'downloadable' => 'yes',
        'notice' => 'Digital Download'
    ],
    [
        'name' => 'Large plate flat black brown ceramic',
        'price' => '2025316',
        'sales' => 450,
        'rating' => 5.0,
        'reviews' => 399,
        'downloadable' => 'no',
        'notice' => 'Only 1 left - order soon'
    ],
    [
        'name' => 'FORÊT Rustic Angled Live Edge',
        'price' => '974729',
        'sales' => 890,
        'rating' => 4.8,
        'reviews' => 1900,
        'downloadable' => 'no',
        'notice' => ''
    ],
    [
        'name' => 'Southwest Farm Landscape Print',
        'price' => '137025',
        'sales' => 5600,
        'rating' => 4.9,
        'reviews' => 3600,
        'downloadable' => 'yes',
        'notice' => 'Digital Download'
    ],
    [
        'name' => 'Vintage Gold Frame Art',
        'price' => '500000',
        'sales' => 120,
        'rating' => 4.5,
        'reviews' => 45,
        'downloadable' => 'no',
        'notice' => 'On sale'
    ]
];

foreach ($product_data as $data) {
    $product = new WC_Product_Simple();
    $product->set_name($data['name']);
    $product->set_regular_price($data['price']);
    $product->set_status('publish');
    $product->set_downloadable($data['downloadable'] === 'yes');
    $product->save();

    $product_id = $product->get_id();
    update_post_meta($product_id, 'total_sales', $data['sales']);
    update_post_meta($product_id, '_wc_average_rating', $data['rating']);
    update_post_meta($product_id, '_wc_review_count', $data['reviews']);

    if ($data['notice']) {
        update_post_meta($product_id, '_etsy_notice', $data['notice']);
    }

    echo "Created product: " . $data['name'] . " (ID: $product_id)\n";
}
?>