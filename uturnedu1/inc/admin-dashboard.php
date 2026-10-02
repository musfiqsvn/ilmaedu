<?php
/**
 * UTurnEdu1 SaaS Admin Dashboard Engine & Management Suite
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Admin Menu Pages
 */
function uturnedu_register_admin_menu() {
    add_menu_page(
        __('UTurnEdu Engine', 'uturnedu1'),
        __('UTurnEdu Suite', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard',
        'uturnedu_render_dashboard_page',
        'dashicons-superhero-alt',
        3
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Overview & Stats', 'uturnedu1'),
        __('📊 Overview', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Leads CRM', 'uturnedu1'),
        __('📥 Leads CRM', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-leads',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('In-Person Bookings', 'uturnedu1'),
        __('📅 Bookings & Office Visits', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-appointments',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Consultation Slots', 'uturnedu1'),
        __('⏰ Slots Manager', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-slots',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Popup Campaigns', 'uturnedu1'),
        __('🎯 Popup Builder (Image & Text)', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-popup',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Marketing Ad Spaces', 'uturnedu1'),
        __('📢 Ad Banner Spaces', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-ads',
        'uturnedu_render_dashboard_page'
    );

    add_submenu_page(
        'uturnedu_dashboard',
        __('Agency, Office & Logo Settings', 'uturnedu1'),
        __('⚙️ Agency & Logo Settings', 'uturnedu1'),
        'manage_options',
        'uturnedu_dashboard#tab-settings',
        'uturnedu_render_dashboard_page'
    );
}
add_action('admin_menu', 'uturnedu_register_admin_menu');

/**
 * Handle Settings Form Submission
 */
function uturnedu_handle_settings_save() {
    if (!isset($_POST['uturnedu_save_settings_nonce']) || !wp_verify_nonce($_POST['uturnedu_save_settings_nonce'], 'uturnedu_save_settings_action')) {
        return;
    }
    if (!current_user_can('manage_options')) {
        return;
    }

    $existing = get_option('uturnedu_settings', []);

    $settings = [
        // Branding & Logos
        'site_tagline'            => sanitize_text_field($_POST['site_tagline'] ?? ''),
        'site_logo_primary'       => esc_url_raw($_POST['site_logo_primary'] ?? ''),
        'site_logo_transparent'   => esc_url_raw($_POST['site_logo_transparent'] ?? ''),
        'site_logo_dashboard'     => esc_url_raw($_POST['site_logo_dashboard'] ?? ''),
        'site_favicon'            => esc_url_raw($_POST['site_favicon'] ?? ''),

        // Office Location & Contacts (Editable at any time)
        'address'                 => sanitize_text_field($_POST['address'] ?? 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh'),
        'office_area'             => sanitize_text_field($_POST['office_area'] ?? 'Mohammadpur, Dhaka'),
        'office_hours'            => sanitize_text_field($_POST['office_hours'] ?? 'Saturday – Thursday: 10:00 AM – 6:30 PM (Friday Closed)'),
        'phone_primary'           => sanitize_text_field($_POST['phone_primary'] ?? ''),
        'phone_secondary'         => sanitize_text_field($_POST['phone_secondary'] ?? ''),
        'phone_hotline'           => sanitize_text_field($_POST['phone_hotline'] ?? ''),
        'email_primary'           => sanitize_email($_POST['email_primary'] ?? ''),
        'email_support'           => sanitize_email($_POST['email_support'] ?? ''),
        'whatsapp_number'         => sanitize_text_field($_POST['whatsapp_number'] ?? ''),

        // Stats & Badges
        'stat_universities'       => sanitize_text_field($_POST['stat_universities'] ?? '100+'),
        'stat_free_consult'       => sanitize_text_field($_POST['stat_free_consult'] ?? '100%'),
        'stat_successful_apps'    => sanitize_text_field($_POST['stat_successful_apps'] ?? '367+'),
        'stat_counselors'         => sanitize_text_field($_POST['stat_counselors'] ?? '09+'),

        // Social Accounts
        'facebook_url'            => esc_url_raw($_POST['facebook_url'] ?? ''),
        'instagram_url'           => esc_url_raw($_POST['instagram_url'] ?? ''),
        'youtube_url'             => esc_url_raw($_POST['youtube_url'] ?? ''),

        // Popup Builder (Textual / Image Only / Hybrid)
        'popup_enabled'           => sanitize_text_field($_POST['popup_enabled'] ?? 'yes'),
        'popup_type'              => sanitize_text_field($_POST['popup_type'] ?? 'image_and_text'), // textual | image_only | image_and_text
        'popup_image_url'         => esc_url_raw($_POST['popup_image_url'] ?? ''),
        'popup_delay'             => (int) ($_POST['popup_delay'] ?? 5),
        'popup_heading'           => sanitize_text_field($_POST['popup_heading'] ?? ''),
        'popup_subheading'        => sanitize_textarea_field($_POST['popup_subheading'] ?? ''),
        'popup_cta_text'          => sanitize_text_field($_POST['popup_cta_text'] ?? 'Claim Free Consultation'),
        'popup_cta_action'        => sanitize_text_field($_POST['popup_cta_action'] ?? 'modal'),
        'popup_cta_url'           => esc_url_raw($_POST['popup_cta_url'] ?? ''),
        'popup_frequency'         => sanitize_text_field($_POST['popup_frequency'] ?? 'session'),
    ];

    update_option('uturnedu_settings', array_merge($existing, $settings));

    // Handle Quick Starter Re-sync
    if (isset($_POST['reinstall_starter_content'])) {
        uturnedu_run_auto_installer(true);
        wp_redirect(admin_url('admin.php?page=uturnedu_dashboard&reinstalled=1'));
        exit;
    }

    wp_redirect(admin_url('admin.php?page=uturnedu_dashboard&updated=1'));
    exit;
}
add_action('admin_init', 'uturnedu_handle_settings_save');

/**
 * Main Render Dashboard Function
 */
function uturnedu_render_dashboard_page() {
    $settings = get_option('uturnedu_settings', []);

    // Default Assets
    $default_logo_primary   = get_template_directory_uri() . '/assets/images/ILMA-Education-Final1-1024x911.png';
    $default_logo_trans     = get_template_directory_uri() . '/assets/images/ILMA-Education-logo-transparent.png';
    $default_uturn_logo     = get_template_directory_uri() . '/assets/images/uturn-official-logo-transparent.png';
    $default_uturn_white    = get_template_directory_uri() . '/assets/images/uturn-official-logo-transparent.png';

    $logo_primary = !empty($settings['site_logo_primary']) ? $settings['site_logo_primary'] : $default_logo_primary;
    $logo_trans   = !empty($settings['site_logo_transparent']) ? $settings['site_logo_transparent'] : $default_logo_trans;
    $address      = !empty($settings['address']) ? $settings['address'] : 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';

    // Quick Counts
    $leads_count = wp_count_posts('lead')->publish ?? 0;
    $appts_count = wp_count_posts('appointment')->publish ?? 0;
    $slots_count = wp_count_posts('consult_slot')->publish ?? 0;
    $dest_count  = wp_count_posts('destination')->publish ?? 0;
    $serv_count  = wp_count_posts('service')->publish ?? 0;
    $ads_count   = wp_count_posts('ad_banner')->publish ?? 0;

    $recent_leads = get_posts([
        'post_type'      => 'lead',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);

    $recent_appts = get_posts([
        'post_type'      => 'appointment',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);

    $slots = get_posts([
        'post_type'      => 'consult_slot',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC'
    ]);

    $ads = get_posts([
        'post_type'      => 'ad_banner',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ]);
    ?>
    <div class="wrap uturnedu-dashboard-wrap">
        <?php if (isset($_GET['updated'])): ?>
            <div class="uturnedu-alert uturnedu-alert-success">
                <span>✓</span> <strong>Settings saved successfully!</strong> All front-end templates, headers, footers, popups, and office details have been updated sitewide.
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['reinstalled'])): ?>
            <div class="uturnedu-alert uturnedu-alert-info">
                <span>🔄</span> <strong>Starter Content Re-synchronized!</strong> Default study destinations, services, and appointment slots are active.
            </div>
        <?php endif; ?>

        <!-- Modern SaaS Dashboard Header with UTurn Branding -->
        <div class="uturnedu-dash-header">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="uturnedu-logo-badge">
                    <img src="<?php echo esc_url($default_uturn_white); ?>" alt="UTurn Digital Solutions" style="height: 38px; width: auto;">
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h1 class="uturnedu-dash-title">UTurnEdu Management Suite</h1>
                        <span class="uturnedu-pill uturnedu-pill-accent">Enterprise v2.0</span>
                    </div>
                    <p class="uturnedu-dash-sub">
                        📍 Primary Agency: <strong>ILMA Education Consultancy</strong> &nbsp;•&nbsp; 🏢 Office: <strong><?php echo esc_html($settings['office_area'] ?? 'Mohammadpur, Dhaka'); ?></strong> &nbsp;•&nbsp; Powered by <strong>UTurn Digital Solutions</strong>
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="uturnedu-btn uturnedu-btn-light">
                    🌐 View Live Website &rarr;
                </a>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="uturnedu-nav-tabs">
            <button type="button" class="uturnedu-tab-btn active" data-tab="tab-overview">📊 Overview & Metrics</button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-leads">📥 Leads CRM <span class="uturnedu-counter"><?php echo esc_html($leads_count); ?></span></button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-appointments">📅 Office Visits & Bookings <span class="uturnedu-counter"><?php echo esc_html($appts_count); ?></span></button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-slots">⏰ Slot Capacity Manager</button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-popup">🎯 Popup Builder (Image & Text)</button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-ads">📢 Marketing Ad Banners</button>
            <button type="button" class="uturnedu-tab-btn" data-tab="tab-settings">⚙️ Agency, Office & Logo Settings</button>
        </div>

        <!-- ==========================================
             1. TAB: OVERVIEW
             ========================================== -->
        <div id="tab-overview" class="uturnedu-tab-pane active">
            <div class="uturnedu-grid-4">
                <div class="uturnedu-card uturnedu-stat-card">
                    <div class="uturnedu-stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563EB;">📥</div>
                    <div class="uturnedu-stat-num"><?php echo esc_html($leads_count); ?></div>
                    <div class="uturnedu-stat-label">Total Student Inquiries</div>
                    <div class="uturnedu-stat-meta" style="color: #059669;">+100% Free Counseling Requests</div>
                </div>

                <div class="uturnedu-card uturnedu-stat-card">
                    <div class="uturnedu-stat-icon" style="background: rgba(220, 38, 38, 0.1); color: #DC2626;">📅</div>
                    <div class="uturnedu-stat-num" style="color: #DC2626;"><?php echo esc_html($appts_count); ?></div>
                    <div class="uturnedu-stat-label">Office Appointments</div>
                    <div class="uturnedu-stat-meta">In-Person at Mohammadpur Office</div>
                </div>

                <div class="uturnedu-card uturnedu-stat-card">
                    <div class="uturnedu-stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">🌍</div>
                    <div class="uturnedu-stat-num" style="color: #059669;"><?php echo esc_html($dest_count); ?></div>
                    <div class="uturnedu-stat-label">Destinations Active</div>
                    <div class="uturnedu-stat-meta">UK, USA, Canada, Australia, MY, NZ</div>
                </div>

                <div class="uturnedu-card uturnedu-stat-card">
                    <div class="uturnedu-stat-icon" style="background: rgba(217, 119, 6, 0.1); color: #D97706;">🎯</div>
                    <div class="uturnedu-stat-num" style="color: #D97706;"><?php echo ($settings['popup_enabled'] ?? 'yes') === 'yes' ? 'Active' : 'Off'; ?></div>
                    <div class="uturnedu-stat-label">Popup Campaign Mode</div>
                    <div class="uturnedu-stat-meta"><?php echo ucfirst(str_replace('_', ' ', $settings['popup_type'] ?? 'Image & Text')); ?></div>
                </div>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="uturnedu-card" style="margin-top: 24px;">
                <h3 style="margin: 0 0 16px 0; font-size: 16px; font-weight: 700;">🚀 Quick Management Controls</h3>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button type="button" class="uturnedu-btn uturnedu-btn-primary" onclick="document.querySelector('[data-tab=\'tab-leads\']').click();">
                        📥 View All Leads CRM
                    </button>
                    <button type="button" class="uturnedu-btn uturnedu-btn-outline" onclick="document.querySelector('[data-tab=\'tab-appointments\']').click();">
                        📅 Check Office Bookings
                    </button>
                    <button type="button" class="uturnedu-btn uturnedu-btn-outline" onclick="document.querySelector('[data-tab=\'tab-popup\']').click();">
                        🎯 Configure Popup (Image/Text)
                    </button>
                    <button type="button" class="uturnedu-btn uturnedu-btn-outline" onclick="document.querySelector('[data-tab=\'tab-settings\']').click();">
                        🏢 Update Office Address & Logos
                    </button>
                </div>
            </div>
        </div>

        <!-- ==========================================
             2. TAB: LEADS CRM
             ========================================== -->
        <div id="tab-leads" class="uturnedu-tab-pane">
            <div class="uturnedu-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                    <div>
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">Student Leads CRM</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">Live direct inquiries submitted from website modals and contact forms.</p>
                    </div>
                </div>

                <div class="uturnedu-table-responsive">
                    <table class="uturnedu-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Phone & WhatsApp</th>
                                <th>Email</th>
                                <th>Target Country</th>
                                <th>Level</th>
                                <th>IELTS / Score</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_leads)): ?>
                                <?php foreach ($recent_leads as $lead):
                                    $phone   = get_post_meta($lead->ID, '_lead_phone', true);
                                    $email   = get_post_meta($lead->ID, '_lead_email', true);
                                    $country = get_post_meta($lead->ID, '_lead_country', true);
                                    $level   = get_post_meta($lead->ID, '_lead_level', true) ?: get_post_meta($lead->ID, '_lead_study_level', true);
                                    $ielts   = get_post_meta($lead->ID, '_lead_ielts', true);
                                    $status  = get_post_meta($lead->ID, '_lead_status', true) ?: 'New';
                                    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
                                ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($lead->post_title); ?></strong></td>
                                        <td>
                                            <a href="tel:<?php echo esc_attr($phone); ?>" style="font-weight:600; color:#2563EB;"><?php echo esc_html($phone); ?></a>
                                            <?php if ($clean_phone): ?>
                                                <a href="https://wa.me/<?php echo esc_attr($clean_phone); ?>" target="_blank" style="margin-left:4px; text-decoration:none;" title="Chat on WhatsApp">💬</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email ?: '—'); ?></a></td>
                                        <td><span class="uturnedu-badge uturnedu-badge-blue"><?php echo esc_html($country ?: 'General'); ?></span></td>
                                        <td><?php echo esc_html($level ?: 'Master'); ?></td>
                                        <td><code><?php echo esc_html($ielts ?: 'Not specified'); ?></code></td>
                                        <td style="font-size:12px; color:#64748B;"><?php echo get_the_date('M j, Y', $lead->ID); ?></td>
                                        <td>
                                            <span class="uturnedu-badge <?php echo $status === 'Converted' ? 'uturnedu-badge-confirmed' : ($status === 'Contacted' ? 'uturnedu-badge-blue' : 'uturnedu-badge-pending'); ?>">
                                                <?php echo esc_html($status); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8" style="text-align:center; padding:30px;">No leads recorded yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==========================================
             3. TAB: APPOINTMENTS CRM
             ========================================== -->
        <div id="tab-appointments" class="uturnedu-tab-pane">
            <div class="uturnedu-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                    <div>
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">Office Visit & Consultation Reservations</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">Scheduled 1-on-1 counselor appointments at the Mohammadpur Office.</p>
                    </div>
                </div>

                <div class="uturnedu-table-responsive">
                    <table class="uturnedu-table">
                        <thead>
                            <tr>
                                <th>Booking Ref</th>
                                <th>Student Name</th>
                                <th>Phone</th>
                                <th>Reserved Date</th>
                                <th>Slot Time</th>
                                <th>Meeting Type</th>
                                <th>Country Interest</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_appts)): ?>
                                <?php foreach ($recent_appts as $appt):
                                    $ref   = get_post_meta($appt->ID, '_appt_ref', true);
                                    $phone = get_post_meta($appt->ID, '_appt_phone', true);
                                    $date  = get_post_meta($appt->ID, '_appt_date', true);
                                    $time  = get_post_meta($appt->ID, '_appt_slot_time', true) ?: get_post_meta($appt->ID, '_appt_time', true);
                                    $type  = get_post_meta($appt->ID, '_appt_type', true) ?: 'In-Person (Office)';
                                    $dest  = get_post_meta($appt->ID, '_appt_destination', true) ?: get_post_meta($appt->ID, '_appt_country', true);
                                    $status= get_post_meta($appt->ID, '_appt_status', true) ?: 'Confirmed';
                                ?>
                                    <tr>
                                        <td><code style="font-weight:700; color:#0F172A;"><?php echo esc_html($ref ?: 'ILMA-'.substr(md5($appt->ID), 0, 6)); ?></code></td>
                                        <td><strong><?php echo esc_html($appt->post_title); ?></strong></td>
                                        <td><a href="tel:<?php echo esc_attr($phone); ?>" style="color:#2563EB; font-weight:600;"><?php echo esc_html($phone); ?></a></td>
                                        <td><strong><?php echo esc_html($date); ?></strong></td>
                                        <td><span class="uturnedu-badge uturnedu-badge-blue"><?php echo esc_html($time); ?></span></td>
                                        <td style="font-size:12px;"><?php echo esc_html($type); ?></td>
                                        <td><?php echo esc_html($dest ?: 'Any'); ?></td>
                                        <td>
                                            <span class="uturnedu-badge <?php echo $status === 'Confirmed' ? 'uturnedu-badge-confirmed' : ($status === 'Completed' ? 'uturnedu-badge-blue' : 'uturnedu-badge-cancelled'); ?>">
                                                <?php echo esc_html($status); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8" style="text-align:center; padding:30px;">No appointments reserved yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==========================================
             4. TAB: SLOTS CAPACITY
             ========================================== -->
        <div id="tab-slots" class="uturnedu-tab-pane">
            <div class="uturnedu-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div>
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">In-Person Consultation Time Slots</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">Manage student seat capacities and office timing windows (Saturday – Thursday).</p>
                    </div>
                    <div>
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=consult_slot')); ?>" class="uturnedu-btn uturnedu-btn-primary">
                            + Add New Time Slot
                        </a>
                    </div>
                </div>

                <div class="uturnedu-table-responsive">
                    <table class="uturnedu-table">
                        <thead>
                            <tr>
                                <th>Slot Name / Timing</th>
                                <th>Max Capacity</th>
                                <th>Total Booked</th>
                                <th>Available Seats</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($slots)): ?>
                                <?php foreach ($slots as $slot):
                                    $cap    = (int) (get_post_meta($slot->ID, '_slot_capacity', true) ?: 4);
                                    $booked = (int) (get_post_meta($slot->ID, '_slot_booked_count', true) ?: 0);
                                    $active = get_post_meta($slot->ID, '_slot_active', true) !== 'no';
                                    $avail  = max(0, $cap - $booked);
                                ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($slot->post_title); ?></strong></td>
                                        <td><?php echo esc_html($cap); ?> Students</td>
                                        <td><?php echo esc_html($booked); ?> Booked</td>
                                        <td>
                                            <strong style="color: <?php echo $avail > 0 ? '#059669' : '#DC2626'; ?>;">
                                                <?php echo $avail > 0 ? $avail . ' Seats Left' : 'Fully Booked'; ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="uturnedu-badge <?php echo $active ? 'uturnedu-badge-confirmed' : 'uturnedu-badge-cancelled'; ?>">
                                                <?php echo $active ? 'Active' : 'Disabled'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo esc_url(get_edit_post_link($slot->ID)); ?>" class="uturnedu-btn uturnedu-btn-outline uturnedu-btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center; padding:30px;">No slots configured.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==========================================
             5. TAB: POPUP BUILDER (IMAGE & TEXTUAL)
             ========================================== -->
        <div id="tab-popup" class="uturnedu-tab-pane">
            <div class="uturnedu-card" style="max-width:840px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;">
                    <div>
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">🎯 5-Second Lead Popup Campaign Builder</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">Choose between full image banner popups, high-converting textual popups, or split hybrid layouts.</p>
                    </div>
                </div>

                <form method="post" action="">
                    <?php wp_nonce_field('uturnedu_save_settings_action', 'uturnedu_save_settings_nonce'); ?>

                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Popup Status</label>
                        <select name="popup_enabled" class="uturnedu-select">
                            <option value="yes" <?php selected($settings['popup_enabled'] ?? 'yes', 'yes'); ?>>✅ Enabled (Active on Frontend)</option>
                            <option value="no" <?php selected($settings['popup_enabled'] ?? 'yes', 'no'); ?>>❌ Disabled (Temporarily Hidden)</option>
                        </select>
                    </div>

                    <!-- POPUP TYPE SELECTOR -->
                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Popup Format / Layout</label>
                        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 6px;">
                            <label style="border: 2px solid <?php echo ($settings['popup_type'] ?? 'image_and_text') === 'image_and_text' ? '#2563EB' : '#E2E8F0'; ?>; padding: 14px; border-radius: 10px; cursor: pointer; background: #FFF;">
                                <input type="radio" name="popup_type" value="image_and_text" <?php checked($settings['popup_type'] ?? 'image_and_text', 'image_and_text'); ?>>
                                <div style="font-weight: 700; margin-top: 4px;">🖼️ + 📝 Combined Hybrid</div>
                                <div style="font-size: 11px; color: #64748B;">Left image flyer + right text & CTA button.</div>
                            </label>

                            <label style="border: 2px solid <?php echo ($settings['popup_type'] ?? '') === 'image_only' ? '#2563EB' : '#E2E8F0'; ?>; padding: 14px; border-radius: 10px; cursor: pointer; background: #FFF;">
                                <input type="radio" name="popup_type" value="image_only" <?php checked($settings['popup_type'] ?? '', 'image_only'); ?>>
                                <div style="font-weight: 700; margin-top: 4px;">🖼️ Image Banner Only</div>
                                <div style="font-size: 11px; color: #64748B;">Clickable promo flyer banner image.</div>
                            </label>

                            <label style="border: 2px solid <?php echo ($settings['popup_type'] ?? '') === 'textual' ? '#2563EB' : '#E2E8F0'; ?>; padding: 14px; border-radius: 10px; cursor: pointer; background: #FFF;">
                                <input type="radio" name="popup_type" value="textual" <?php checked($settings['popup_type'] ?? '', 'textual'); ?>>
                                <div style="font-weight: 700; margin-top: 4px;">📝 Textual Modal Only</div>
                                <div style="font-size: 11px; color: #64748B;">High-converting text headline & buttons.</div>
                            </label>
                        </div>
                    </div>

                    <!-- Popup Image URL -->
                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Popup Banner Image URL</label>
                        <input type="text" name="popup_image_url" class="uturnedu-input" placeholder="e.g. <?php echo esc_url(get_template_directory_uri() . '/assets/images/scholarship-celebration.jpg'); ?>" value="<?php echo esc_attr($settings['popup_image_url'] ?? get_template_directory_uri() . '/assets/images/scholarship-celebration.jpg'); ?>">
                        <span class="uturnedu-help">Image used for Image-Only and Combined Image+Text popups.</span>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Delay Before Popup Shows (Seconds)</label>
                            <input type="number" name="popup_delay" class="uturnedu-input" min="1" max="60" value="<?php echo esc_attr($settings['popup_delay'] ?? 5); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Display Frequency</label>
                            <select name="popup_frequency" class="uturnedu-select">
                                <option value="session" <?php selected($settings['popup_frequency'] ?? 'session', 'session'); ?>>Once Per Browser Session</option>
                                <option value="day" <?php selected($settings['popup_frequency'] ?? 'session', 'day'); ?>>Once Per Day (24 Hours)</option>
                                <option value="always" <?php selected($settings['popup_frequency'] ?? 'session', 'always'); ?>>Always Show (Testing Mode)</option>
                            </select>
                        </div>
                    </div>

                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Popup Headline / Title</label>
                        <input type="text" name="popup_heading" class="uturnedu-input" value="<?php echo esc_attr($settings['popup_heading'] ?? 'Start Your Study Abroad Journey with 100% Free Guidance!'); ?>">
                    </div>

                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Popup Subtitle / Body Copy</label>
                        <textarea name="popup_subheading" class="uturnedu-textarea" rows="3"><?php echo esc_textarea($settings['popup_subheading'] ?? 'Meet certified counselors at our Mohammadpur office or get immediate profile assessment.'); ?></textarea>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">CTA Button Label</label>
                            <input type="text" name="popup_cta_text" class="uturnedu-input" value="<?php echo esc_attr($settings['popup_cta_text'] ?? 'Claim Free Consultation'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">CTA Action Type</label>
                            <select name="popup_cta_action" class="uturnedu-select">
                                <option value="modal" <?php selected($settings['popup_cta_action'] ?? 'modal', 'modal'); ?>>Open Free Profile Assessment Modal</option>
                                <option value="link" <?php selected($settings['popup_cta_action'] ?? 'modal', 'link'); ?>>Redirect to Custom URL (Below)</option>
                            </select>
                        </div>
                    </div>

                    <div class="uturnedu-form-group">
                        <label class="uturnedu-label">Custom Target URL (If Action is Redirect)</label>
                        <input type="url" name="popup_cta_url" class="uturnedu-input" placeholder="https://example.com/special-offer" value="<?php echo esc_url($settings['popup_cta_url'] ?? home_url('/reserve-consultation/')); ?>">
                    </div>

                    <button type="submit" class="uturnedu-btn uturnedu-btn-primary" style="padding:12px 28px; margin-top:10px;">
                        💾 Save Popup Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- ==========================================
             6. TAB: MARKETING AD SPACES
             ========================================== -->
        <div id="tab-ads" class="uturnedu-tab-pane">
            <div class="uturnedu-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div>
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">Marketing Banners & Ad Spaces</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">Manage placement banners, destination sidebars, and real-time click tracking.</p>
                    </div>
                    <div>
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=ad_banner')); ?>" class="uturnedu-btn uturnedu-btn-primary">
                            + Add New Ad Banner
                        </a>
                    </div>
                </div>

                <div class="uturnedu-table-responsive">
                    <table class="uturnedu-table">
                        <thead>
                            <tr>
                                <th>Banner Title</th>
                                <th>Placement Position</th>
                                <th>Target Link</th>
                                <th>Total Clicks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ads)): ?>
                                <?php foreach ($ads as $ad):
                                    $place = get_post_meta($ad->ID, '_ad_placement', true) ?: 'home_middle';
                                    $link = get_post_meta($ad->ID, '_ad_target_url', true);
                                    $clicks = (int) get_post_meta($ad->ID, '_ad_clicks', true);
                                    $act = get_post_meta($ad->ID, '_ad_active', true) !== 'no';
                                ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($ad->post_title); ?></strong></td>
                                        <td><code style="font-weight:600;"><?php echo esc_html($place); ?></code></td>
                                        <td><a href="<?php echo esc_url($link); ?>" target="_blank" style="font-size:12px;"><?php echo esc_html($link ?: 'Self'); ?></a></td>
                                        <td><strong><?php echo esc_html($clicks); ?> Clicks</strong></td>
                                        <td>
                                            <span class="uturnedu-badge <?php echo $act ? 'uturnedu-badge-confirmed' : 'uturnedu-badge-cancelled'; ?>">
                                                <?php echo $act ? 'Active' : 'Paused'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo esc_url(get_edit_post_link($ad->ID)); ?>" class="uturnedu-btn uturnedu-btn-outline uturnedu-btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center; padding:30px;">No ad spaces created.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==========================================
             7. TAB: AGENCY, OFFICE & LOGO SETTINGS
             ========================================== -->
        <div id="tab-settings" class="uturnedu-tab-pane">
            <form method="post" action="">
                <?php wp_nonce_field('uturnedu_save_settings_action', 'uturnedu_save_settings_nonce'); ?>

                <!-- Logo & Brand Customization Card -->
                <div class="uturnedu-card" style="margin-bottom:24px;">
                    <h2 style="margin:0 0 6px 0; font-size:18px; font-weight:700;">🎨 Brand Logos & Visual Identity</h2>
                    <p style="margin:0 0 20px 0; font-size:13px; color:#64748B;">Upload or update header, footer, favicon, and dashboard branding assets.</p>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Header Primary Logo URL</label>
                            <input type="text" name="site_logo_primary" class="uturnedu-input" value="<?php echo esc_attr($settings['site_logo_primary'] ?? $default_logo_primary); ?>">
                            <span class="uturnedu-help">Main logo displayed on white / light headers.</span>
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Dark / Transparent Footer Logo URL</label>
                            <input type="text" name="site_logo_transparent" class="uturnedu-input" value="<?php echo esc_attr($settings['site_logo_transparent'] ?? $default_logo_trans); ?>">
                            <span class="uturnedu-help">Transparent logo used on dark footers and custom login screen.</span>
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Dashboard / Engine Logo URL</label>
                            <input type="text" name="site_logo_dashboard" class="uturnedu-input" value="<?php echo esc_attr($settings['site_logo_dashboard'] ?? $default_uturn_logo); ?>">
                            <span class="uturnedu-help">Logo used for UTurnEdu backend suite and attribution.</span>
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Official Tagline</label>
                            <input type="text" name="site_tagline" class="uturnedu-input" value="<?php echo esc_attr($settings['site_tagline'] ?? 'Study Abroad, See the World, Build Career!'); ?>">
                        </div>
                    </div>
                </div>

                <!-- Office Location (Mohammadpur / Dynamic) & Contacts -->
                <div class="uturnedu-card" style="margin-bottom:24px;">
                    <div style="border-left: 4px solid #2563EB; padding-left: 12px; margin-bottom: 16px;">
                        <h2 style="margin:0 0 4px 0; font-size:18px; font-weight:700;">🏢 Office Location & Helplines</h2>
                        <p style="margin:0; font-size:13px; color:#64748B;">
                            Current physical address is configured to <strong>Mohammadpur, Dhaka</strong>. Update anytime below to reflect immediately across all pages, footers, and booking calendars.
                        </p>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div class="uturnedu-form-group" style="grid-column: span 2;">
                            <label class="uturnedu-label">Full Office Address <span style="color:#DC2626;">*</span></label>
                            <input type="text" name="address" class="uturnedu-input" value="<?php echo esc_attr($address); ?>" required>
                            <span class="uturnedu-help">Displayed in Header topbar, Footer contact column, Contact Us page, and Google Schema.</span>
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Office Area / City</label>
                            <input type="text" name="office_area" class="uturnedu-input" value="<?php echo esc_attr($settings['office_area'] ?? 'Mohammadpur, Dhaka'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Office Working Hours</label>
                            <input type="text" name="office_hours" class="uturnedu-input" value="<?php echo esc_attr($settings['office_hours'] ?? 'Saturday – Thursday: 10:00 AM – 6:30 PM (Friday Closed)'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Primary Telephone / Mobile</label>
                            <input type="text" name="phone_primary" class="uturnedu-input" value="<?php echo esc_attr($settings['phone_primary'] ?? '01329272046'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Secondary Mobile Helpline</label>
                            <input type="text" name="phone_secondary" class="uturnedu-input" value="<?php echo esc_attr($settings['phone_secondary'] ?? '01823345573'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">WhatsApp Hotline (with Country Code)</label>
                            <input type="text" name="whatsapp_number" class="uturnedu-input" value="<?php echo esc_attr($settings['whatsapp_number'] ?? '+8801329272046'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Primary Official Email</label>
                            <input type="email" name="email_primary" class="uturnedu-input" value="<?php echo esc_attr($settings['email_primary'] ?? 'info@ilmaedubd.com'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Support / Senior Counselor Email</label>
                            <input type="email" name="email_support" class="uturnedu-input" value="<?php echo esc_attr($settings['email_support'] ?? 'rawshan@ilmaedubd.com'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Facebook Official Page</label>
                            <input type="url" name="facebook_url" class="uturnedu-input" value="<?php echo esc_url($settings['facebook_url'] ?? 'https://www.facebook.com/ilmaeducationbd'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">Instagram Profile</label>
                            <input type="url" name="instagram_url" class="uturnedu-input" value="<?php echo esc_url($settings['instagram_url'] ?? 'https://www.instagram.com/ilmaeducation'); ?>">
                        </div>

                        <div class="uturnedu-form-group">
                            <label class="uturnedu-label">YouTube Channel</label>
                            <input type="url" name="youtube_url" class="uturnedu-input" value="<?php echo esc_url($settings['youtube_url'] ?? 'https://www.youtube.com/@ilmaeducation'); ?>">
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:16px; align-items:center;">
                    <button type="submit" class="uturnedu-btn uturnedu-btn-primary" style="padding:14px 32px; font-size:15px; font-weight:700;">
                        💾 Save All Settings Sitewide
                    </button>
                    <button type="submit" name="reinstall_starter_content" value="1" class="uturnedu-btn uturnedu-btn-outline" onclick="return confirm('Re-sync all starter content and destinations?');">
                        🔄 Re-sync Starter Data
                    </button>
                </div>
            </form>
        </div>

    </div>
    <?php
}
