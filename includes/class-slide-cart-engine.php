<?php
defined('ABSPATH') || exit;

final class Woo_Slide_Cart_Engine {
    const VERSION = '1.0.0';
    private static ?self $instance = null;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('wp_footer', [$this, 'render_drawer_markup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'add_drawer_fragments']);
    }

    public function render_drawer_markup(): void {
        if (function_exists('is_checkout') && is_checkout()) {
            return;
        }

        echo '<div id="wascd-cart-overlay" class="wascd-overlay" style="display:none;"></div>';
        echo '<div id="wascd-cart-drawer" class="wascd-drawer" aria-hidden="true">';
        echo '<div class="wascd-drawer__header"><h3>' . esc_html__('Shopping Cart', 'woo-ajax-slide-cart-drawer') . '</h3><button type="button" class="wascd-close">&times;</button></div>';
        echo '<div class="wascd-drawer__progress"><div class="wascd-progress-bar"><div class="wascd-progress-fill" style="width: 75%;"></div></div><p class="wascd-shipping-text">' . esc_html__('Add items for Free Shipping!', 'woo-ajax-slide-cart-drawer') . '</p></div>';
        echo '<div class="wascd-drawer__body" id="wascd-cart-items-container"><p class="wascd-empty">' . esc_html__('Your cart is empty.', 'woo-ajax-slide-cart-drawer') . '</p></div>';
        echo '<div class="wascd-drawer__footer"><div class="wascd-subtotal"><span>' . esc_html__('Subtotal', 'woo-ajax-slide-cart-drawer') . '</span><strong class="wascd-subtotal-amount">$0.00</strong></div><a href="/checkout" class="wascd-checkout-btn">' . esc_html__('Proceed to Checkout', 'woo-ajax-slide-cart-drawer') . '</a></div>';
        echo '</div>';
    }

    public function add_drawer_fragments(array $fragments): array {
        $fragments['span.wascd-cart-counter'] = '<span class="wascd-cart-counter">1</span>';
        return $fragments;
    }

    public function enqueue_assets(): void {
        wp_enqueue_style('wascd-style', plugins_url('assets/css/cart-drawer.css', dirname(__FILE__)), [], self::VERSION);
        wp_enqueue_script('wascd-script', plugins_url('assets/js/cart-drawer.js', dirname(__FILE__)), ['jquery'], self::VERSION, true);
    }
}
