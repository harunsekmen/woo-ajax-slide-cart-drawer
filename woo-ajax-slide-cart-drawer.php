<?php
/**
 * Plugin Name:       WooCommerce Ultra-Light AJAX Slide Cart Drawer
 * Plugin URI:        https://github.com/harunsekmen/woo-ajax-slide-cart-drawer
 * Description:       12 KB modular slide drawer with instant AJAX quantity updates, inline coupon inputs, and cross-sell recommendations.
 * Version:           1.0.0
 * Author:            Harun Sekmen
 * Author URI:        https://github.com/harunsekmen
 * License:           GPL-3.0
 * Requires at least: 6.2
 * Requires PHP:      8.1
 * WC requires at least: 8.0
 * Text Domain:       woo-ajax-slide-cart-drawer
 */

defined('ABSPATH') || exit;

// Declare WooCommerce High-Performance Order Storage (HPOS) compatibility
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

// Display admin notice if WooCommerce is inactive
add_action('admin_notices', function () {
    if (!class_exists('WooCommerce')) {
        echo '<div class="notice notice-error is-dismissible"><p><strong>' .
             esc_html__('WooCommerce Ultra-Light AJAX Slide Cart Drawer', 'woo-ajax-slide-cart-drawer') .
             '</strong> ' .
             esc_html__('requires WooCommerce to be installed and active.', 'woo-ajax-slide-cart-drawer') .
             '</p></div>';
    }
});

// Include includes
foreach (glob(__DIR__ . '/includes/*.php') as $inc_file) {
    require_once $inc_file;
}

// Initialize plugin after plugins are loaded and WooCommerce is verified
add_action('plugins_loaded', function () {
    if (!class_exists('WooCommerce')) {
        return;
    }
        if (class_exists('') && method_exists('', 'instance')) { call_user_func(['', 'instance']); }
        if (class_exists('WooAjaxSlideCartDrawer_Admin') && method_exists('WooAjaxSlideCartDrawer_Admin', 'instance')) { call_user_func(['WooAjaxSlideCartDrawer_Admin', 'instance']); }
        if (class_exists('Woo_Slide_Cart_Engine') && method_exists('Woo_Slide_Cart_Engine', 'instance')) { call_user_func(['Woo_Slide_Cart_Engine', 'instance']); }

}, 20);
