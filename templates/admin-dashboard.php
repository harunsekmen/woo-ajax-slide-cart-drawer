<?php
defined('ABSPATH') || exit;
?>
<div class="wrap wascd-admin-wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e('AJAX Slide Cart Drawer Configuration', 'woo-ajax-slide-cart-drawer'); ?></h1>
    <p class="description">
        <?php esc_html_e('High-performance 12 KB slide-out cart drawer with dynamic AOV free-shipping progress calculation.', 'woo-ajax-slide-cart-drawer'); ?>
    </p>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 20px;">
        <div class="main-settings-column">
            <div class="postbox" style="padding: 24px; background: #fff; border: 1px solid #c3c4c7; border-radius: 4px;">
                <h2 style="font-size: 16px; margin-bottom: 16px;"><?php esc_html_e('Cart Drawer Behavior & AOV Booster', 'woo-ajax-slide-cart-drawer'); ?></h2>
                <form method="post" action="options.php">
                    <?php settings_fields('wascd_settings_group'); ?>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e('Free Shipping Goal ($)', 'woo-ajax-slide-cart-drawer'); ?></th>
                                <td>
                                    <input type="number" step="0.01" name="wascd_settings[free_shipping_goal]" value="75.00" style="width:100px;" />
                                    <p class="description"><?php esc_html_e('Calculates cart subtotal delta in real-time (e.g. Add $25.00 more for Free Shipping).', 'woo-ajax-slide-cart-drawer'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Auto-Open on Add to Cart', 'woo-ajax-slide-cart-drawer'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="wascd_settings[auto_open]" value="1" checked /> <?php esc_html_e('Slide drawer open automatically when an item is added to bag', 'woo-ajax-slide-cart-drawer'); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Inline Coupon Form', 'woo-ajax-slide-cart-drawer'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="wascd_settings[show_coupons]" value="1" checked /> <?php esc_html_e('Allow shoppers to apply discount codes inside the drawer without leaving the page', 'woo-ajax-slide-cart-drawer'); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Drawer Panel Width', 'woo-ajax-slide-cart-drawer'); ?></th>
                                <td>
                                    <select name="wascd_settings[drawer_width]">
                                        <option value="420px" selected>420px (Modern Wide)</option>
                                        <option value="380px">380px (Standard)</option>
                                        <option value="100vw">100% (Full Screen on Mobile)</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php submit_button(__('Save Cart Drawer Settings', 'woo-ajax-slide-cart-drawer')); ?>
                </form>
            </div>
        </div>

        <div class="sidebar-column">
            <div class="postbox" style="padding: 20px; background: #fff; border: 1px solid #c3c4c7; border-radius: 4px;">
                <h3 style="margin-top:0;"><?php esc_html_e('Performance Impact', 'woo-ajax-slide-cart-drawer'); ?></h3>
                <div style="background:#eff6ff;border-left:4px solid #2563eb;padding:12px 16px;border-radius:4px;margin-bottom:14px;">
                    <span style="font-size:24px;font-weight:700;color:#1d4ed8;display:block;">12 KB Gzipped</span>
                    <span style="font-size:12px;color:#4b5563;">Pure vanilla JS and CSS. Zero jQuery UI overhead.</span>
                </div>
                <p style="font-size:12px;color:#646970;line-height:1.5;">Maintains shoppers inside the product catalog, eliminating full cart page hops.</p>
            </div>
        </div>
    </div>
</div>
