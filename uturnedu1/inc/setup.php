<?php
/**
 * UTurnEdu1 Theme Setup, Asset Enqueues & Custom Branded Login Page
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function uturnedu_setup() {
    load_theme_textdomain('uturnedu1', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 630, true);
    add_image_size('uturnedu-card', 600, 400, true);
    add_image_size('uturnedu-destination', 800, 500, true);
    add_image_size('uturnedu-square', 400, 400, true);

    register_nav_menus([
        'primary-menu'         => __('Primary Navigation Menu', 'uturnedu1'),
        'footer-destinations'  => __('Footer Destinations Menu', 'uturnedu1'),
        'footer-services'      => __('Footer Services Menu', 'uturnedu1'),
        'footer-legal'         => __('Footer Legal Menu', 'uturnedu1'),
    ]);

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 260,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'uturnedu_setup');

/**
 * Enqueue frontend scripts and styles with Plus Jakarta Sans
 */
function uturnedu_enqueue_scripts() {
    wp_enqueue_style('uturnedu-google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap', [], null);
    wp_enqueue_style('uturnedu-main', get_template_directory_uri() . '/assets/css/main.css', [], UTURNEDU_VERSION);
    if (is_page('apply-now')) {
        wp_enqueue_style('uturnedu-apply', get_template_directory_uri() . '/assets/css/apply.css', ['uturnedu-main'], UTURNEDU_VERSION);
    }
    wp_enqueue_style('uturnedu-style', get_stylesheet_uri(), ['uturnedu-main'], UTURNEDU_VERSION);

    wp_enqueue_script('uturnedu-main-js', get_template_directory_uri() . '/assets/js/main.js', [], UTURNEDU_VERSION, true);

    if (is_page_template('page-reserve-consultation.php') || is_page('reserve-consultation')) {
        wp_enqueue_script('uturnedu-booking-js', get_template_directory_uri() . '/assets/js/booking.js', ['uturnedu-main-js'], UTURNEDU_VERSION, true);
    }

    wp_localize_script('uturnedu-main-js', 'uturneduData', [
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('uturnedu_frontend_nonce'),
        'siteUrl'   => home_url('/'),
        'themeUrl'  => get_template_directory_uri(),
    ]);
}
add_action('wp_enqueue_scripts', 'uturnedu_enqueue_scripts');

/**
 * Enqueue admin scripts and styles for SaaS Dashboard
 */
function uturnedu_admin_enqueue_scripts($hook) {
    if (strpos($hook, 'uturnedu') !== false || strpos($hook, 'uturnedu_dashboard') !== false) {
        wp_enqueue_style('uturnedu-google-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', [], null);
        wp_enqueue_style('uturnedu-admin-css', get_template_directory_uri() . '/assets/css/admin.css', [], '2.2.0');
        wp_enqueue_script('uturnedu-admin-js', get_template_directory_uri() . '/assets/js/admin.js', ['jquery'], '2.2.1', true);
        wp_localize_script('uturnedu-admin-js', 'uturneduAdminData', [
            'nonce' => wp_create_nonce('uturnedu_admin_nonce'),
        ]);
    }
}
add_action('admin_enqueue_scripts', 'uturnedu_admin_enqueue_scripts');

/**
 * Custom Branded WordPress Login Screen with UTurn Attribution
 */
function uturnedu_custom_login_styles() {
    $settings      = get_option('uturnedu_settings', []);
    $logo_url      = !empty($settings['site_logo_transparent']) ? $settings['site_logo_transparent'] : get_template_directory_uri() . '/assets/images/ILMA-Education-logo-transparent.png';
    $uturn_logo    = get_template_directory_uri() . '/assets/images/uturn-logo.svg';
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style type="text/css">
        body.login {
            background: linear-gradient(135deg, #0B132B 0%, #1C2541 50%, #1E3A8A 100%) !important;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px 0;
            box-sizing: border-box;
            position: relative;
            overflow-x: hidden;
        }
        body.login::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
            top: -100px;
            left: -100px;
            pointer-events: none;
        }
        body.login::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.12) 0%, rgba(6, 182, 212, 0) 70%);
            bottom: -150px;
            right: -150px;
            pointer-events: none;
        }
        #login {
            width: 420px !important;
            max-width: calc(100vw - 32px) !important;
            box-sizing: border-box !important;
            padding: 40px 30px !important;
            margin: auto !important;
            position: relative;
            z-index: 10;
        }
        #login h1 a {
            background-image: url('<?php echo esc_url($logo_url); ?>') !important;
            background-size: contain !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-color: transparent !important;
            display: block !important;
            width: 100% !important;
            height: 80px !important;
            margin-bottom: 24px !important;
            text-indent: -9999px !important;
            overflow: hidden !important;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2));
        }
        .login form,
        .login #login_error,
        .login .message,
        .login .success {
            box-sizing: border-box !important;
            width: 100% !important;
        }
        .login form {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) !important;
            padding: 32px 28px !important;
        }
        .login #login_error,
        .login .message,
        .login .success {
            border-radius: 10px !important;
            margin: 0 0 16px !important;
            padding: 12px 14px !important;
        }
        .login label {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-bottom: 6px !important;
        }
        .login input[type="text"],
        .login input[type="email"],
        .login input[type="password"] {
            box-sizing: border-box !important;
            width: 100% !important;
            min-height: 44px !important;
            border: 1.5px solid #CBD5E1 !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
            background: #F8FAFC !important;
            box-shadow: none !important;
            transition: all 0.2s ease !important;
        }
        .login input[type="text"]:focus,
        .login input[type="email"]:focus,
        .login input[type="password"]:focus {
            border-color: #2563EB !important;
            background: #FFFFFF !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
        .login .button.button-primary {
            box-sizing: border-box !important;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            padding: 10px 20px !important;
            min-height: 44px !important;
            height: auto !important;
            width: 100% !important;
            margin-top: 15px !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4) !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }
        .login .button.button-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5) !important;
        }
        .login #nav, .login #backtoblog {
            text-align: center !important;
            padding: 12px 0 0 0 !important;
        }
        .login #nav a, .login #backtoblog a {
            color: #94A3B8 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            transition: color 0.2s !important;
        }
        .login #nav a:hover, .login #backtoblog a:hover {
            color: #FFFFFF !important;
        }
        .uturn-login-badge {
            margin-top: 30px;
            text-align: center;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 20px;
            border-radius: 12px;
        }
        .uturn-login-badge a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            color: #E2E8F0;
            font-size: 12px;
            font-weight: 600;
        }
        .uturn-login-badge a:hover {
            color: #38BDF8;
        }
        .uturn-login-badge span.sub {
            display: block;
            font-size: 11px;
            color: #94A3B8;
            margin-top: 2px;
        }
        @media (max-width: 480px) {
            body.login { padding: 12px 0 !important; }
            #login { padding: 24px 16px !important; max-width: calc(100vw - 16px) !important; }
            .login form { padding: 24px 18px !important; }
            #login h1 a { height: 64px !important; margin-bottom: 16px !important; }
            .uturn-login-badge { margin-top: 20px; padding: 10px 12px; }
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'uturnedu_custom_login_styles');

function uturnedu_login_logo_url() {
    return home_url('/');
}
add_filter('login_headerurl', 'uturnedu_login_logo_url');

function uturnedu_login_logo_title() {
    return get_bloginfo('name') . ' - ILMA Education Consultancy';
}
add_filter('login_headertext', 'uturnedu_login_logo_title');

function uturnedu_login_footer_credit() {
    $uturn_logo = get_template_directory_uri() . '/assets/images/uturn-logo-white.svg';
    ?>
    <div class="uturn-login-badge">
        <a href="https://uturndigital.com" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo esc_url($uturn_logo); ?>" alt="UTurn Digital Solutions" style="height: 18px; width: auto; vertical-align: middle;">
        </a>
        <span class="sub">Powered by <strong>UTurn Digital Solutions</strong> • High Performance Education Platform</span>
    </div>
    <?php
}
add_action('login_footer', 'uturnedu_login_footer_credit');

function uturnedu_custom_excerpt_length($length) {
    return 24;
}
add_filter('excerpt_length', 'uturnedu_custom_excerpt_length', 999);

function uturnedu_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'uturnedu_excerpt_more');
