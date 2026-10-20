<?php
/**
 * Plugin Name:       WooCommerce Ultra-Light AJAX Slide Cart Drawer
 * Plugin URI:        https://github.com/harunsekmen/woo-ajax-slide-cart-drawer
 * Description:       12 KB modular slide drawer with instant AJAX quantity updates, inline coupon inputs, and free-shipping progress meter.
 * Version:           1.0.0
 * Author:            Harun Sekmen
 * Author URI:        https://github.com/harunsekmen
 * License:           GPL-3.0
 * Requires at least: 6.2
 * Requires PHP:      8.1
 * WC requires at least: 8.0
 */

defined('ABSPATH') || exit;

add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

require_once __DIR__ . '/includes/class-slide-cart-engine.php';

add_action('plugins_loaded', ['Woo_Slide_Cart_Engine', 'instance']);
