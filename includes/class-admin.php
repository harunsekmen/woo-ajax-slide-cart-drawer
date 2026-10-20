<?php
defined('ABSPATH') || exit;

/**
 * WordPress Admin Settings & Telemetry Dashboard
 *
 * @package WooAjaxSlideCartDrawer
 * @author  Harun Sekmen <sekmenwp@gmail.com>
 */
final class WooAjaxSlideCartDrawer_Admin {
    const OPTION_KEY = 'wascd_settings';
    private static ?self $instance = null;

    public static function instance(): self {
        return self::$instance ??= new self();
    }

    private function __construct() {
        add_action('admin_menu', [$this, 'register_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_menu_page(): void {
        add_submenu_page(
            'woocommerce',
            esc_html__('AJAX Slide Cart Drawer Configuration', 'woo-ajax-slide-cart-drawer'),
            esc_html__('Cart Drawer', 'woo-ajax-slide-cart-drawer'),
            'manage_woocommerce',
            'woo-ajax-slide-cart-drawer-dashboard',
            [$this, 'render_dashboard_view']
        );
    }

    public function register_settings(): void {
        register_setting('wascd_settings_group', self::OPTION_KEY, [
            'type'              => 'array',
            'sanitize_callback' => [$this, 'sanitize_settings'],
            'default'           => ['free_shipping_goal' => 75.0, 'drawer_width' => '400px', 'show_coupons' => 1]
        ]);
    }

    public function sanitize_settings($input): array {
        $output = [];
        if (is_array($input)) {
            foreach ($input as $key => $val) {
                $output[sanitize_key($key)] = is_numeric($val) ? (float)$val : sanitize_text_field($val);
            }
        }
        return $output;
    }

    public function render_dashboard_view(): void {
        if (!current_user_can('manage_woocommerce')) {
            return;
        }
        $settings = get_option(self::OPTION_KEY, ['free_shipping_goal' => 75.0, 'drawer_width' => '400px', 'show_coupons' => 1]);
        require_once dirname(__DIR__) . '/templates/admin-dashboard.php';
    }
}

add_action('plugins_loaded', ['WooAjaxSlideCartDrawer_Admin', 'instance']);
