<?php
/**
 * Plugin Name: Etsy Style WooCommerce
 * Description: Redesign WooCommerce Product Grid and Single Product Page to match Etsy style.
 * Version: 1.0.0
 * Author: Antigravity
 */

if (!defined('ABSPATH')) {
    exit;
}

class Etsy_Style_Woo
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);

        // Product Grid Hooks (Blocksy)
        add_action('blocksy:woocommerce:product-card:title:after', [$this, 'grid_seller_name'], 5);
        add_action('blocksy:woocommerce:product-card:price:after', [$this, 'grid_extra_info'], 10);

        // Single Product Hooks (Blocksy)
        add_action('blocksy:woocommerce:product-single:title:before', [$this, 'single_seller_info'], 5);
        add_action('blocksy:woocommerce:product-single:price:after', [$this, 'single_tax_notice'], 10);
    }

    public function enqueue_styles()
    {
        wp_enqueue_style('etsy-style-woo', plugin_dir_url(__FILE__) . 'style.css', [], '1.0.0');
    }

    /**
     * Display seller name (author) in product grid
     */
    public function grid_seller_name()
    {
        global $product;
        $author_id = get_post_field('post_author', $product->get_id());
        $author_name = get_the_author_meta('display_name', $author_id) ?: 'Etsy Seller';
        echo '<div class="etsy-grid-seller">' . esc_html($author_name) . '</div>';
    }

    /**
     * Display sales count and notices in product grid
     */
    public function grid_extra_info()
    {
        global $product;
        $sales = get_post_meta($product->get_id(), 'total_sales', true);
        $notice = get_post_meta($product->get_id(), '_etsy_notice', true);

        echo '<div class="etsy-grid-meta">';
        if (!empty($notice)) {
            echo '<div class="etsy-notice">' . esc_html($notice) . '</div>';
        }
        if ($sales) {
            echo '<div class="etsy-sales">(' . number_format($sales) . ' bought)</div>';
        }
        echo '</div>';
    }

    /**
     * Display seller info and ratings above product title on single page
     */
    public function single_seller_info()
    {
        global $product;
        $author_id = get_post_field('post_author', $product->get_id());
        $author_name = get_the_author_meta('display_name', $author_id) ?: 'Etsy Seller';
        $sales = get_post_meta($product->get_id(), 'total_sales', true);

        echo '<div class="etsy-single-top-meta">';
        echo '<span class="etsy-seller">' . esc_html($author_name) . '</span>';
        if ($sales) {
            echo '<span class="etsy-sales-dot">•</span>';
            echo '<span class="etsy-sales-count">' . number_format($sales) . ' sales</span>';
        }
        echo '</div>';
    }

    /**
     * Display "Local taxes included" notice below price on single page
     */
    public function single_tax_notice()
    {
        echo '<div class="etsy-tax-notice">Local taxes included (where applicable)</div>';
    }
}

new Etsy_Style_Woo();
