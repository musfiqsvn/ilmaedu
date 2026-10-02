<?php
/**
 * UTurnEdu1 WordPress Theme Functions and Definitions
 *
 * @package UTurnEdu1
 * @author UTurn Digital Solutions
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define Theme Constants
define('UTURNEDU_VERSION', '2.2.0');
define('UTURNEDU_DIR', get_template_directory());
define('UTURNEDU_URI', get_template_directory_uri());

// 1. Theme Setup & Enqueues
require_once UTURNEDU_DIR . '/inc/setup.php';

// 2. Custom Post Types & Taxonomies
require_once UTURNEDU_DIR . '/inc/custom-post-types.php';

// 3. Shared destination and conversion content catalogs
require_once UTURNEDU_DIR . '/inc/content-data.php';

// 4. Custom Meta Boxes
require_once UTURNEDU_DIR . '/inc/meta-boxes.php';

// 5. Zero-Configuration Auto-Installer
require_once UTURNEDU_DIR . '/inc/auto-install.php';

// 5. AJAX Endpoints & Data Handlers
require_once UTURNEDU_DIR . '/inc/ajax-handlers.php';

// 6. SaaS Admin Dashboard Suite
require_once UTURNEDU_DIR . '/inc/admin-dashboard.php';

/**
 * Helper: Retrieve Theme Setting
 */
function uturnedu_get_setting($key, $default = '') {
    $settings = get_option('uturnedu_settings', []);
    return $settings[$key] ?? $default;
}

/**
 * Helper: Render Ad Placement
 */
function uturnedu_render_ad($placement = 'home_middle') {
    $ads = get_posts([
        'post_type'      => 'ad_banner',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => [
            ['key' => '_ad_placement', 'value' => $placement],
            ['key' => '_ad_active', 'value' => 'yes'],
        ]
    ]);

    if (!empty($ads)) {
        $ad = $ads[0];
        $url = get_post_meta($ad->ID, '_ad_target_url', true) ?: home_url('/reserve-consultation/');
        $img = get_post_meta($ad->ID, '_ad_image_url', true);

        if ($placement === 'header_top') {
            ?>
            <div class="top-flash-banner">
                <a href="<?php echo esc_url($url); ?>" class="track-ad-click" data-ad-id="<?php echo esc_attr($ad->ID); ?>">
                    <strong>🔥 Special Notice:</strong> <?php echo esc_html($ad->post_title); ?> — <span style="text-decoration:underline;">Book 1-on-1 Profile Assessment &rarr;</span>
                </a>
            </div>
            <?php
        } else {
            ?>
            <div class="ad-banner-wrapper placement-<?php echo esc_attr($placement); ?>">
                <a href="<?php echo esc_url($url); ?>" class="track-ad-click" data-ad-id="<?php echo esc_attr($ad->ID); ?>">
                    <?php if ($img): ?>
                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($ad->post_title); ?>" class="ad-banner-img">
                    <?php else: ?>
                        <div class="ad-banner-placeholder">
                            <h3><?php echo esc_html($ad->post_title); ?></h3>
                            <p>Click here to learn more and reserve your consultation</p>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <?php
        }
    }
}
