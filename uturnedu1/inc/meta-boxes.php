<?php
/**
 * UTurnEdu1 Custom Meta Boxes
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register all metaboxes
 */
function uturnedu_add_custom_meta_boxes() {
    // Destination Meta
    add_meta_box(
        'uturnedu_destination_details',
        __('Destination Specifications & Fast Facts', 'uturnedu1'),
        'uturnedu_render_destination_metabox',
        'destination',
        'normal',
        'high'
    );

    // Service Meta
    add_meta_box(
        'uturnedu_service_details',
        __('Service Features & Process', 'uturnedu1'),
        'uturnedu_render_service_metabox',
        'service',
        'normal',
        'high'
    );

    // Testimonial Meta
    add_meta_box(
        'uturnedu_testimonial_details',
        __('Student Testimonial Details', 'uturnedu1'),
        'uturnedu_render_testimonial_metabox',
        'testimonial',
        'normal',
        'high'
    );

    // Counselor Meta
    add_meta_box(
        'uturnedu_counselor_details',
        __('Counselor Credentials & Contact', 'uturnedu1'),
        'uturnedu_render_counselor_metabox',
        'counselor',
        'normal',
        'high'
    );

    // Lead Meta
    add_meta_box(
        'uturnedu_lead_details',
        __('Lead Inquiry Information', 'uturnedu1'),
        'uturnedu_render_lead_metabox',
        'lead',
        'normal',
        'high'
    );

    // Appointment Meta
    add_meta_box(
        'uturnedu_appointment_details',
        __('Appointment Booking Details', 'uturnedu1'),
        'uturnedu_render_appointment_metabox',
        'appointment',
        'normal',
        'high'
    );

    // Slot Meta
    add_meta_box(
        'uturnedu_slot_details',
        __('Consultation Slot Configuration', 'uturnedu1'),
        'uturnedu_render_slot_metabox',
        'consult_slot',
        'normal',
        'high'
    );

    // Ad Banner Meta
    add_meta_box(
        'uturnedu_ad_details',
        __('Ad Banner Placement & Links', 'uturnedu1'),
        'uturnedu_render_ad_metabox',
        'ad_banner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'uturnedu_add_custom_meta_boxes');

// Destination Meta Renderer
function uturnedu_render_destination_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $flag = get_post_meta($post->ID, '_dest_flag', true);
    $image_url = get_post_meta($post->ID, '_dest_image_url', true);
    $country_code = get_post_meta($post->ID, '_dest_code', true);
    $capital = get_post_meta($post->ID, '_dest_capital', true);
    $currency = get_post_meta($post->ID, '_dest_currency', true);
    $avg_tuition = get_post_meta($post->ID, '_dest_tuition', true);
    $living_cost = get_post_meta($post->ID, '_dest_living_cost', true);
    $intakes = get_post_meta($post->ID, '_dest_intakes', true);
    $work_rights = get_post_meta($post->ID, '_dest_work_rights', true);
    $psw = get_post_meta($post->ID, '_dest_psw', true);
    $ielts_req = get_post_meta($post->ID, '_dest_ielts', true);
    $visa_rate = get_post_meta($post->ID, '_dest_visa_rate', true);
    $universities = get_post_meta($post->ID, '_dest_universities', true);
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:10px 0;">
        <p>
            <label><strong>Flag Emoji / Code:</strong></label><br>
            <input type="text" name="_dest_flag" value="<?php echo esc_attr($flag); ?>" class="widefat" placeholder="e.g. 🇨🇦 or ca">
        </p>
        <p>
            <label><strong>Homepage order:</strong></label><br>
            <input type="number" min="0" name="_uturnedu_menu_order" value="<?php echo esc_attr($post->menu_order); ?>" class="widefat">
            <small>Lower numbers appear first in destination cards.</small>
        </p>
        <p style="grid-column:1 / -1;">
            <label><strong>Managed Destination Image:</strong></label><br>
            <div class="uturnedu-media-row"><input type="url" id="uturnedu-dest-image-<?php echo esc_attr($post->ID); ?>" name="_dest_image_url" value="<?php echo esc_url($image_url); ?>" class="widefat" placeholder="Choose a Media Library image, or leave blank for the theme image."><button type="button" class="button uturnedu-media-button" data-media-target="uturnedu-dest-image-<?php echo esc_attr($post->ID); ?>">Choose image</button></div>
            <small>Used by homepage cards and the six-country hero. Choose a replacement without leaving the destination editor.</small>
        </p>
        <p>
            <label><strong>Country ISO Code:</strong></label><br>
            <input type="text" name="_dest_code" value="<?php echo esc_attr($country_code); ?>" class="widefat" placeholder="e.g. CA, US, UK, AU">
        </p>
        <p>
            <label><strong>Capital City:</strong></label><br>
            <input type="text" name="_dest_capital" value="<?php echo esc_attr($capital); ?>" class="widefat" placeholder="e.g. Ottawa">
        </p>
        <p>
            <label><strong>Currency:</strong></label><br>
            <input type="text" name="_dest_currency" value="<?php echo esc_attr($currency); ?>" class="widefat" placeholder="e.g. CAD ($)">
        </p>
        <p>
            <label><strong>Average Annual Tuition:</strong></label><br>
            <input type="text" name="_dest_tuition" value="<?php echo esc_attr($avg_tuition); ?>" class="widefat" placeholder="e.g. $15,000 - $35,000 / year">
        </p>
        <p>
            <label><strong>Estimated Living Cost:</strong></label><br>
            <input type="text" name="_dest_living_cost" value="<?php echo esc_attr($living_cost); ?>" class="widefat" placeholder="e.g. $10,000 - $15,000 / year">
        </p>
        <p>
            <label><strong>Primary Intakes:</strong></label><br>
            <input type="text" name="_dest_intakes" value="<?php echo esc_attr($intakes); ?>" class="widefat" placeholder="e.g. Fall (Sep), Winter (Jan), Summer (May)">
        </p>
        <p>
            <label><strong>Part-time Work Rights:</strong></label><br>
            <input type="text" name="_dest_work_rights" value="<?php echo esc_attr($work_rights); ?>" class="widefat" placeholder="e.g. 20 hrs/week during study, full-time during breaks">
        </p>
        <p>
            <label><strong>Post-Study Work (PSW):</strong></label><br>
            <input type="text" name="_dest_psw" value="<?php echo esc_attr($psw); ?>" class="widefat" placeholder="e.g. Up to 3 Years PGWP">
        </p>
        <p>
            <label><strong>Standard IELTS/Language Requirement:</strong></label><br>
            <input type="text" name="_dest_ielts" value="<?php echo esc_attr($ielts_req); ?>" class="widefat" placeholder="e.g. Overall 6.0 - 6.5 (MOI options available)">
        </p>
        <p>
            <label><strong>Visa Success Rate:</strong></label><br>
            <input type="text" name="_dest_visa_rate" value="<?php echo esc_attr($visa_rate); ?>" class="widefat" placeholder="e.g. 98%">
        </p>
    </div>
    <p>
        <label><strong>Top Partner Universities (comma-separated):</strong></label><br>
        <textarea name="_dest_universities" class="widefat" rows="3"><?php echo esc_textarea($universities); ?></textarea>
    </p>
    <?php
}

// Service Meta Renderer
function uturnedu_render_service_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $icon = get_post_meta($post->ID, '_service_icon', true);
    $badge = get_post_meta($post->ID, '_service_badge', true);
    $process = get_post_meta($post->ID, '_service_process', true);
    ?>
    <p>
        <label><strong>Homepage order:</strong></label><br>
        <input type="number" min="0" name="_uturnedu_menu_order" value="<?php echo esc_attr($post->menu_order); ?>" class="widefat">
        <small>Lower numbers appear first in service cards.</small>
    </p>
    <p>
        <label><strong>Service Icon (Dashicon / SVG name / Emoji):</strong></label><br>
        <input type="text" name="_service_icon" value="<?php echo esc_attr($icon); ?>" class="widefat" placeholder="e.g. 🎓, 📄, ✈️, 🏛️">
    </p>
    <p>
        <label><strong>Service Tag / Badge:</strong></label><br>
        <input type="text" name="_service_badge" value="<?php echo esc_attr($badge); ?>" class="widefat" placeholder="e.g. Free initial guidance, Most Popular, Step-by-Step">
    </p>
    <p>
        <label><strong>Process Steps (One per line):</strong></label><br>
        <textarea name="_service_process" class="widefat" rows="4" placeholder="1. Initial Profile Evaluation&#10;2. University & Course Shortlisting&#10;3. Application Submission&#10;4. Offer Letter & Visa Guidance"><?php echo esc_textarea($process); ?></textarea>
    </p>
    <?php
}

// Testimonial Meta Renderer
function uturnedu_render_testimonial_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $student_country = get_post_meta($post->ID, '_testi_country', true);
    $university = get_post_meta($post->ID, '_testi_university', true);
    $program = get_post_meta($post->ID, '_testi_program', true);
    $rating = get_post_meta($post->ID, '_testi_rating', true) ?: '5';
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Destination Country:</strong></label><br>
            <input type="text" name="_testi_country" value="<?php echo esc_attr($student_country); ?>" class="widefat" placeholder="e.g. Canada">
        </p>
        <p>
            <label><strong>Admitted University:</strong></label><br>
            <input type="text" name="_testi_university" value="<?php echo esc_attr($university); ?>" class="widefat" placeholder="e.g. University of Windsor">
        </p>
        <p>
            <label><strong>Enrolled Program / Degree:</strong></label><br>
            <input type="text" name="_testi_program" value="<?php echo esc_attr($program); ?>" class="widefat" placeholder="e.g. M.Eng in Electrical Engineering">
        </p>
        <p>
            <label><strong>Rating (1 to 5 Stars):</strong></label><br>
            <select name="_testi_rating" class="widefat">
                <option value="5" <?php selected($rating, '5'); ?>>5 Stars (★★★★★)</option>
                <option value="4" <?php selected($rating, '4'); ?>>4 Stars (★★★★☆)</option>
                <option value="3" <?php selected($rating, '3'); ?>>3 Stars (★★★☆☆)</option>
            </select>
        </p>
    </div>
    <?php
}

// Counselor Meta Renderer
function uturnedu_render_counselor_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $designation = get_post_meta($post->ID, '_counselor_role', true);
    $experience = get_post_meta($post->ID, '_counselor_exp', true);
    $countries = get_post_meta($post->ID, '_counselor_countries', true);
    $email = get_post_meta($post->ID, '_counselor_email', true);
    $phone = get_post_meta($post->ID, '_counselor_phone', true);
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Role / Designation:</strong></label><br>
            <input type="text" name="_counselor_role" value="<?php echo esc_attr($designation); ?>" class="widefat" placeholder="e.g. Senior UK & Canada Counselor">
        </p>
        <p>
            <label><strong>Experience:</strong></label><br>
            <input type="text" name="_counselor_exp" value="<?php echo esc_attr($experience); ?>" class="widefat" placeholder="e.g. 7+ Years">
        </p>
        <p>
            <label><strong>Specialized Countries:</strong></label><br>
            <input type="text" name="_counselor_countries" value="<?php echo esc_attr($countries); ?>" class="widefat" placeholder="e.g. United Kingdom, Canada, Japan">
        </p>
        <p>
            <label><strong>Email:</strong></label><br>
            <input type="email" name="_counselor_email" value="<?php echo esc_attr($email); ?>" class="widefat" placeholder="counselor@ilmaedubd.com">
        </p>
        <p>
            <label><strong>Phone:</strong></label><br>
            <input type="text" name="_counselor_phone" value="<?php echo esc_attr($phone); ?>" class="widefat" placeholder="+880 1329-272046">
        </p>
    </div>
    <?php
}

// Lead Meta Renderer
function uturnedu_render_lead_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $phone = get_post_meta($post->ID, '_lead_phone', true);
    $email = get_post_meta($post->ID, '_lead_email', true);
    $country = get_post_meta($post->ID, '_lead_country', true);
    $qualification = get_post_meta($post->ID, '_lead_qualification', true);
    $target_intake = get_post_meta($post->ID, '_lead_target_intake', true);
    $study_level = get_post_meta($post->ID, '_lead_study_level', true);
    $ielts = get_post_meta($post->ID, '_lead_ielts', true);
    $budget = get_post_meta($post->ID, '_lead_budget', true);
    $source = get_post_meta($post->ID, '_lead_source', true);
    $status = get_post_meta($post->ID, '_lead_status', true) ?: 'New';
    $status = ['new' => 'New', 'contacted' => 'Contacted', 'interested' => 'Qualified', 'qualified' => 'Qualified', 'follow-up' => 'Follow-up', 'applied' => 'Applied', 'converted' => 'Converted', 'closed' => 'Closed'][$status] ?? $status;
    $notes = get_post_meta($post->ID, '_lead_notes', true);
    $follow_up_date = get_post_meta($post->ID, '_lead_follow_up_date', true);
    $follow_up_note = get_post_meta($post->ID, '_lead_follow_up_note', true);
    $owner = get_post_meta($post->ID, '_lead_owner', true);
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Phone Number:</strong></label><br>
            <input type="text" name="_lead_phone" value="<?php echo esc_attr($phone); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Email Address:</strong></label><br>
            <input type="email" name="_lead_email" value="<?php echo esc_attr($email); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Target Country:</strong></label><br>
            <input type="text" name="_lead_country" value="<?php echo esc_attr($country); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Current Qualification:</strong></label><br>
            <input type="text" name="_lead_qualification" value="<?php echo esc_attr($qualification); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Target Intake:</strong></label><br>
            <input type="text" name="_lead_target_intake" value="<?php echo esc_attr($target_intake); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Target Study Level:</strong></label><br>
            <input type="text" name="_lead_study_level" value="<?php echo esc_attr($study_level); ?>" class="widefat">
        </p>
        <p><label><strong>English Test / IELTS:</strong></label><br><input type="text" name="_lead_ielts" value="<?php echo esc_attr($ielts); ?>" class="widefat"></p>
        <p><label><strong>Approximate Budget:</strong></label><br><input type="text" name="_lead_budget" value="<?php echo esc_attr($budget); ?>" class="widefat"></p>
        <p>
            <label><strong>Inquiry Source:</strong></label><br>
            <input type="text" name="_lead_source" value="<?php echo esc_attr($source); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Lead Status:</strong></label><br>
            <select name="_lead_status" class="widefat">
                <option value="New" <?php selected($status, 'New'); ?>>New Inquiry</option>
                <option value="Contacted" <?php selected($status, 'Contacted'); ?>>Contacted</option>
                <option value="Qualified" <?php selected($status, 'Qualified'); ?>>Qualified / In-Progress</option>
                <option value="Applied" <?php selected($status, 'Applied'); ?>>Applied</option>
                <option value="Converted" <?php selected($status, 'Converted'); ?>>Converted</option>
                <option value="Closed" <?php selected($status, 'Closed'); ?>>Closed / Unqualified</option>
            </select>
        </p>
    </div>
    <p>
        <label><strong>Counselor Internal Notes:</strong></label><br>
        <textarea name="_lead_notes" class="widefat" rows="3"><?php echo esc_textarea($notes); ?></textarea>
    </p>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
        <p><label><strong>Next Follow-up Date:</strong></label><br><input type="date" name="_lead_follow_up_date" value="<?php echo esc_attr($follow_up_date); ?>" class="widefat"></p>
        <p><label><strong>Follow-up Note:</strong></label><br><input type="text" name="_lead_follow_up_note" value="<?php echo esc_attr($follow_up_note); ?>" class="widefat"></p>
        <p><label><strong>Owner / Counselor:</strong></label><br><input type="text" name="_lead_owner" value="<?php echo esc_attr($owner); ?>" class="widefat"></p>
    </div>
    <?php
}

// Appointment Meta Renderer
function uturnedu_render_appointment_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $ref = get_post_meta($post->ID, '_appt_ref', true);
    $phone = get_post_meta($post->ID, '_appt_phone', true);
    $email = get_post_meta($post->ID, '_appt_email', true);
    $country = get_post_meta($post->ID, '_appt_country', true);
    $date = get_post_meta($post->ID, '_appt_date', true);
    $time = get_post_meta($post->ID, '_appt_time', true);
    $counselor = get_post_meta($post->ID, '_appt_counselor', true);
    $status = get_post_meta($post->ID, '_appt_status', true) ?: 'Confirmed';
    $status = ['confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'no-show' => 'No-show'][$status] ?? $status;
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Booking Reference:</strong></label><br>
            <input type="text" name="_appt_ref" value="<?php echo esc_attr($ref); ?>" class="widefat" readonly>
        </p>
        <p>
            <label><strong>Appointment Date:</strong></label><br>
            <input type="date" name="_appt_date" value="<?php echo esc_attr($date); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Time Slot:</strong></label><br>
            <input type="text" name="_appt_time" value="<?php echo esc_attr($time); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Assigned Counselor:</strong></label><br>
            <input type="text" name="_appt_counselor" value="<?php echo esc_attr($counselor); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Applicant Phone:</strong></label><br>
            <input type="text" name="_appt_phone" value="<?php echo esc_attr($phone); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Applicant Email:</strong></label><br>
            <input type="email" name="_appt_email" value="<?php echo esc_attr($email); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Target Country:</strong></label><br>
            <input type="text" name="_appt_country" value="<?php echo esc_attr($country); ?>" class="widefat">
        </p>
        <p>
            <label><strong>Appointment Status:</strong></label><br>
            <select name="_appt_status" class="widefat">
                <option value="Confirmed" <?php selected($status, 'Confirmed'); ?>>Confirmed</option>
                <option value="Completed" <?php selected($status, 'Completed'); ?>>Completed</option>
                <option value="Cancelled" <?php selected($status, 'Cancelled'); ?>>Cancelled</option>
                <option value="No-show" <?php selected($status, 'No-show'); ?>>No-Show</option>
            </select>
        </p>
    </div>
    <?php
}

// Slot Meta Renderer
function uturnedu_render_slot_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $start_time = get_post_meta($post->ID, '_slot_start_time', true);
    $end_time = get_post_meta($post->ID, '_slot_end_time', true);
    $capacity = get_post_meta($post->ID, '_slot_capacity', true) ?: 3;
    $counselor_name = get_post_meta($post->ID, '_slot_counselor_name', true);
    $is_active = get_post_meta($post->ID, '_slot_active', true);
    if ($is_active === '') $is_active = 'yes';
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Start Time:</strong></label><br>
            <input type="text" name="_slot_start_time" value="<?php echo esc_attr($start_time); ?>" class="widefat" placeholder="e.g. 10:00 AM">
        </p>
        <p>
            <label><strong>End Time:</strong></label><br>
            <input type="text" name="_slot_end_time" value="<?php echo esc_attr($end_time); ?>" class="widefat" placeholder="e.g. 11:30 AM">
        </p>
        <p>
            <label><strong>Seat Capacity Per Day:</strong></label><br>
            <input type="number" name="_slot_capacity" value="<?php echo esc_attr($capacity); ?>" class="widefat" min="1" max="20">
        </p>
        <p>
            <label><strong>Assigned Counselor:</strong></label><br>
            <input type="text" name="_slot_counselor_name" value="<?php echo esc_attr($counselor_name); ?>" class="widefat" placeholder="e.g. Senior Counselor">
        </p>
        <p>
            <label><strong>Active Slot:</strong></label><br>
            <select name="_slot_active" class="widefat">
                <option value="yes" <?php selected($is_active, 'yes'); ?>>Active (Accepting Bookings)</option>
                <option value="no" <?php selected($is_active, 'no'); ?>>Inactive (Disabled)</option>
            </select>
        </p>
    </div>
    <?php
}

// Ad Banner Meta Renderer
function uturnedu_render_ad_metabox($post) {
    wp_nonce_field('uturnedu_save_meta', 'uturnedu_meta_nonce');
    $placement = get_post_meta($post->ID, '_ad_placement', true) ?: 'home_middle';
    $target_url = get_post_meta($post->ID, '_ad_target_url', true);
    $image_url = get_post_meta($post->ID, '_ad_image_url', true);
    $clicks = get_post_meta($post->ID, '_ad_clicks', true) ?: 0;
    $is_active = get_post_meta($post->ID, '_ad_active', true);
    if ($is_active === '') $is_active = 'yes';
    ?>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <p>
            <label><strong>Placement Position:</strong></label><br>
            <select name="_ad_placement" class="widefat">
                <option value="home_middle" <?php selected($placement, 'home_middle'); ?>>Homepage Mid-Banner</option>
                <option value="sidebar" <?php selected($placement, 'sidebar'); ?>>Sidebar Ad Space</option>
                <option value="footer_top" <?php selected($placement, 'footer_top'); ?>>Pre-Footer Promotional Banner</option>
            </select>
        </p>
        <p>
            <label><strong>Status:</strong></label><br>
            <select name="_ad_active" class="widefat">
                <option value="yes" <?php selected($is_active, 'yes'); ?>>Active</option>
                <option value="no" <?php selected($is_active, 'no'); ?>>Paused / Inactive</option>
            </select>
        </p>
        <p>
            <label><strong>Target Link URL:</strong></label><br>
            <input type="text" name="_ad_target_url" value="<?php echo esc_url($target_url); ?>" class="widefat" placeholder="https://...">
        </p>
        <p>
            <label><strong>Banner Image:</strong></label><br>
            <div class="uturnedu-media-row"><input type="url" id="uturnedu-ad-image-<?php echo esc_attr($post->ID); ?>" name="_ad_image_url" value="<?php echo esc_url($image_url); ?>" class="widefat" placeholder="Choose an image from the Media Library"><button type="button" class="button uturnedu-media-button" data-media-target="uturnedu-ad-image-<?php echo esc_attr($post->ID); ?>">Choose image</button></div>
        </p>
        <p>
            <label><strong>Total Recorded Clicks:</strong></label><br>
            <input type="number" name="_ad_clicks" value="<?php echo esc_attr($clicks); ?>" class="widefat" readonly>
        </p>
    </div>
    <?php
}

/**
 * Save custom meta boxes
 */
function uturnedu_save_custom_meta($post_id) {
    if (!isset($_POST['uturnedu_meta_nonce']) || !wp_verify_nonce($_POST['uturnedu_meta_nonce'], 'uturnedu_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['_uturnedu_menu_order']) && in_array(get_post_type($post_id), ['destination', 'service'], true)) {
        remove_action('save_post', 'uturnedu_save_custom_meta');
        wp_update_post([
            'ID'         => $post_id,
            'menu_order' => absint($_POST['_uturnedu_menu_order']),
        ]);
        add_action('save_post', 'uturnedu_save_custom_meta');
    }

    $fields = [
        '_dest_flag', '_dest_image_url', '_dest_code', '_dest_capital', '_dest_currency', '_dest_tuition',
        '_dest_living_cost', '_dest_intakes', '_dest_work_rights', '_dest_psw',
        '_dest_ielts', '_dest_visa_rate', '_dest_universities',
        '_service_icon', '_service_badge', '_service_process',
        '_testi_country', '_testi_university', '_testi_program', '_testi_rating',
        '_counselor_role', '_counselor_exp', '_counselor_countries', '_counselor_email', '_counselor_phone',
        '_lead_phone', '_lead_email', '_lead_ielts', '_lead_budget', '_lead_country', '_lead_qualification', '_lead_target_intake', '_lead_study_level', '_lead_source', '_lead_status', '_lead_notes', '_lead_follow_up_date', '_lead_follow_up_note', '_lead_owner',
        '_appt_ref', '_appt_date', '_appt_time', '_appt_slot_id', '_appt_slot_time', '_appt_counselor', '_appt_phone', '_appt_email', '_appt_country', '_appt_destination', '_appt_type', '_appt_study_level', '_appt_education_level', '_appt_ielts_score', '_appt_notes', '_appt_created_at', '_appt_status',
        '_slot_start_time', '_slot_end_time', '_slot_capacity', '_slot_counselor_name', '_slot_active',
        '_ad_placement', '_ad_target_url', '_ad_image_url', '_ad_active'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'uturnedu_save_custom_meta');
