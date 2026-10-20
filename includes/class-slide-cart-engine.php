<?php
defined('ABSPATH') || exit;

/**
 * High-Performance AJAX Slide Cart Drawer Engine
 *
 * @package WooAjaxSlideCartDrawer
 * @author  Harun Sekmen <sekmenwp@gmail.com>
 */
final class Woo_Slide_Cart_Engine {
    const VERSION = '1.0.0';
    private static ?self $instance = null;
    private float $free_shipping_threshold = 75.00;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('wp_footer', [$this, 'render_drawer_markup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'update_fragments']);
        add_action('wp_ajax_wascd_apply_coupon', [$this, 'ajax_apply_coupon']);
        add_action('wp_ajax_nopriv_wascd_apply_coupon', [$this, 'ajax_apply_coupon']);
    }

    public function calculate_shipping_progress(float $subtotal): array {
        $goal = $this->free_shipping_threshold;
        if ($subtotal >= $goal) {
            return [
                'percentage' => 100,
                'message'    => esc_html__('🎉 You unlocked Free Shipping!', 'woo-ajax-slide-cart-drawer')
            ];
        }
        $diff = $goal - $subtotal;
        $pct = round(($subtotal / $goal) * 100);
        return [
            'percentage' => max(0, min(100, (int)$pct)),
            'message'    => sprintf(esc_html__('Add %s more for Free Shipping!', 'woo-ajax-slide-cart-drawer'), wc_price($diff))
        ];
    }

    public function render_drawer_markup(): void {
        if (function_exists('is_checkout') && is_checkout()) return;

        $subtotal = 0.00;
        if (function_exists('WC') && WC()->cart) {
            $subtotal = (float) WC()->cart->get_subtotal();
        }
        $progress = $this->calculate_shipping_progress($subtotal);

        echo '<div id="wascd-cart-overlay" class="wascd-overlay" style="display:none;"></div>';
        echo '<div id="wascd-cart-drawer" class="wascd-drawer" aria-hidden="true">';
        echo '<div class="wascd-drawer__header">';
        echo '<h3>' . esc_html__('Shopping Bag', 'woo-ajax-slide-cart-drawer') . '</h3>';
        echo '<button type="button" class="wascd-close" aria-label="Close cart">&times;</button>';
        echo '</div>';
        echo '<div class="wascd-drawer__progress">';
        echo '<div class="wascd-progress-bar"><div class="wascd-progress-fill" style="width: ' . esc_attr($progress['percentage']) . '%;"></div></div>';
        echo '<p class="wascd-shipping-text">' . esc_html($progress['message']) . '</p>';
        echo '</div>';
        echo '<div class="wascd-drawer__body" id="wascd-cart-items-container">';
        echo '<p class="wascd-empty">' . esc_html__('Your shopping bag is currently empty.', 'woo-ajax-slide-cart-drawer') . '</p>';
        echo '</div>';
        echo '<div class="wascd-drawer__footer">';
        echo '<div class="wascd-subtotal"><span>' . esc_html__('Subtotal', 'woo-ajax-slide-cart-drawer') . '</span><strong class="wascd-subtotal-amount">' . wc_price($subtotal) . '</strong></div>';
        echo '<a href="' . esc_url(function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '/checkout') . '" class="wascd-checkout-btn">' . esc_html__('Checkout Now', 'woo-ajax-slide-cart-drawer') . '</a>';
        echo '</div>';
        echo '</div>';
    }

    public function update_fragments(array $fragments): array {
        $count = function_exists('WC') && WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
        $fragments['span.wascd-cart-counter'] = '<span class="wascd-cart-counter">' . esc_html($count) . '</span>';
        return $fragments;
    }

    public function ajax_apply_coupon(): void {
        check_ajax_referer('wascd_nonce', 'nonce');
        $coupon = sanitize_text_field(wp_unslash($_POST['coupon_code'] ?? ''));
        if (empty($coupon)) {
            wp_send_json_error(['message' => 'Empty coupon']);
        }
        wp_send_json_success(['applied' => true, 'coupon' => $coupon]);
    }

    public function enqueue_assets(): void {
        wp_enqueue_style('wascd-style', plugins_url('assets/css/cart-drawer.css', dirname(__FILE__)), [], self::VERSION);
        wp_enqueue_script('wascd-script', plugins_url('assets/js/cart-drawer.js', dirname(__FILE__)), ['jquery'], self::VERSION, true);
        wp_localize_script('wascd-script', 'WASCD_Settings', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('wascd_nonce')
        ]);
    }
}
