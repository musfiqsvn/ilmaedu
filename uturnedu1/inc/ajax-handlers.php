<?php
/**
 * UTurnEdu1 AJAX Handlers, REST API & Data Endpoints
 *
 * Fully integrated for WordPress CRM, Bookings, Slots, Leads, and Offline Fallbacks.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Submit Lead AJAX Handler (Frontend Modal & Forms)
 */
function uturnedu_ajax_submit_lead() {
    // Anti-spam Honeypot Check
    if (!empty($_POST['website_hp'])) {
        wp_send_json_success(['message' => 'Inquiry received.']);
    }

    $name          = sanitize_text_field($_POST['name'] ?? $_POST['student_name'] ?? '');
    $phone         = sanitize_text_field($_POST['phone'] ?? $_POST['student_phone'] ?? '');
    $email         = sanitize_email($_POST['email'] ?? $_POST['student_email'] ?? '');
    $country       = sanitize_text_field($_POST['target_country'] ?? $_POST['country'] ?? 'General');
    $qualification = sanitize_text_field($_POST['qualification'] ?? $_POST['education_level'] ?? $_POST['study_level'] ?? '');
    $study_level   = sanitize_text_field($_POST['study_level'] ?? $_POST['education_level'] ?? 'Undergraduate');
    $ielts_score   = sanitize_text_field($_POST['ielts_score'] ?? $_POST['ielts'] ?? '');
    $target_intake = sanitize_text_field($_POST['target_intake'] ?? $_POST['intake'] ?? '');
    $notes         = sanitize_textarea_field($_POST['notes'] ?? '');
    $source        = sanitize_text_field($_POST['source'] ?? 'Website Inquiry Modal');

    if (empty($name) || empty($phone)) {
        wp_send_json_error(['message' => __('Please provide at least your Full Name and Mobile Number.', 'uturnedu1')]);
    }

    $lead_title = $name . ' (' . ($phone ? $phone : 'No Phone') . ') - ' . ($country ? $country : 'General');
    $post_id = wp_insert_post([
        'post_title'   => $lead_title,
        'post_type'    => 'lead',
        'post_status'  => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => __('Failed to submit inquiry. Please try again.', 'uturnedu1')]);
    }

    update_post_meta($post_id, '_lead_name', $name);
    update_post_meta($post_id, '_lead_phone', $phone);
    update_post_meta($post_id, '_lead_email', $email);
    update_post_meta($post_id, '_lead_country', $country);
    update_post_meta($post_id, '_lead_level', $study_level ?: $qualification);
    update_post_meta($post_id, '_lead_qualification', $qualification);
    update_post_meta($post_id, '_lead_study_level', $study_level);
    update_post_meta($post_id, '_lead_ielts', $ielts_score);
    update_post_meta($post_id, '_lead_target_intake', $target_intake);
    update_post_meta($post_id, '_lead_source', $source);
    update_post_meta($post_id, '_lead_notes', $notes);
    update_post_meta($post_id, '_lead_status', 'New');
    update_post_meta($post_id, '_lead_submitted_at', current_time('mysql'));

    wp_send_json_success([
        'message' => __('Thank you! Your inquiry has been received. Our counselor will contact you shortly.', 'uturnedu1'),
        'lead_id' => $post_id,
    ]);
}
add_action('wp_ajax_uturnedu_submit_lead', 'uturnedu_ajax_submit_lead');
add_action('wp_ajax_nopriv_uturnedu_submit_lead', 'uturnedu_ajax_submit_lead');

/**
 * 2. Submit Contact Page Form AJAX Handler
 */
function uturnedu_ajax_submit_contact() {
    if (!empty($_POST['website_hp'])) {
        wp_send_json_success(['message' => 'Message received.']);
    }

    $name    = sanitize_text_field($_POST['name'] ?? $_POST['student_name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? $_POST['student_email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? $_POST['student_phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? 'Website Contact Form');
    $message = sanitize_textarea_field($_POST['message'] ?? $_POST['notes'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => __('Please fill all required fields.', 'uturnedu1')]);
    }

    $lead_title = 'Contact: ' . $name . ' (' . ($phone ?: $email) . ')';
    $post_id = wp_insert_post([
        'post_title'   => $lead_title,
        'post_type'    => 'lead',
        'post_status'  => 'publish',
    ]);

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, '_lead_name', $name);
        update_post_meta($post_id, '_lead_phone', $phone);
        update_post_meta($post_id, '_lead_email', $email);
        update_post_meta($lead_id, '_lead_country', 'General Inquiry');
        update_post_meta($post_id, '_lead_source', 'Contact Form: ' . $subject);
        update_post_meta($post_id, '_lead_notes', $message);
        update_post_meta($post_id, '_lead_status', 'New');
        update_post_meta($post_id, '_lead_submitted_at', current_time('mysql'));
    }

    wp_send_json_success([
        'message' => __('Thank you for contacting ILMA Education. We will reply to your message promptly.', 'uturnedu1')
    ]);
}
add_action('wp_ajax_uturnedu_submit_contact', 'uturnedu_ajax_submit_contact');
add_action('wp_ajax_nopriv_uturnedu_submit_contact', 'uturnedu_ajax_submit_contact');

/**
 * 3. Fetch Available Consultation Slots
 */
function uturnedu_ajax_get_available_slots() {
    $date = sanitize_text_field($_GET['date'] ?? date('Y-m-d'));

    $slot_posts = get_posts([
        'post_type'      => 'consult_slot',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order ID',
        'order'          => 'ASC'
    ]);

    $slots = [];

    if (empty($slot_posts)) {
        // Default standard operational consultation intervals
        $default_slots = [
            ['id' => 'slot-1', 'time' => '10:30 AM - 11:15 AM', 'cap' => 4, 'counselor' => 'Senior Canada Counselor'],
            ['id' => 'slot-2', 'time' => '11:30 AM - 12:15 PM', 'cap' => 4, 'counselor' => 'Senior UK Counselor'],
            ['id' => 'slot-3', 'time' => '02:00 PM - 02:45 PM', 'cap' => 4, 'counselor' => 'South Korea & Japan Specialist'],
            ['id' => 'slot-4', 'time' => '03:00 PM - 03:45 PM', 'cap' => 4, 'counselor' => 'Asia-Pacific Specialist'],
            ['id' => 'slot-5', 'time' => '04:00 PM - 04:45 PM', 'cap' => 4, 'counselor' => 'Senior Admission Director'],
            ['id' => 'slot-6', 'time' => '05:00 PM - 05:45 PM', 'cap' => 3, 'counselor' => 'General Counselor'],
        ];

        foreach ($default_slots as $ds) {
            $booked_count = count(get_posts([
                'post_type'      => 'appointment',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    ['key' => '_appt_date', 'value' => $date],
                    ['key' => '_appt_time', 'value' => $ds['time']],
                    ['key' => '_appt_status', 'value' => 'Cancelled', 'compare' => '!=']
                ]
            ]));

            $rem = max(0, $ds['cap'] - $booked_count);
            $slots[] = [
                'id'                 => $ds['id'],
                'time'               => $ds['time'],
                'capacity'           => $ds['cap'],
                'booked_count'       => $booked_count,
                'remaining_capacity' => $rem,
                'is_full'            => ($rem <= 0),
                'counselor_name'     => $ds['counselor'],
            ];
        }
    } else {
        foreach ($slot_posts as $slot) {
            $active = get_post_meta($slot->ID, '_slot_active', true);
            if ($active === 'no') continue;

            $start_time     = get_post_meta($slot->ID, '_slot_start_time', true) ?: '10:00 AM';
            $end_time       = get_post_meta($slot->ID, '_slot_end_time', true) ?: '11:30 AM';
            $time_str       = "{$start_time} - {$end_time}";
            $capacity       = (int) (get_post_meta($slot->ID, '_slot_capacity', true) ?: 4);
            $counselor_name = get_post_meta($slot->ID, '_slot_counselor_name', true) ?: 'Senior Counselor';

            $booked_count = count(get_posts([
                'post_type'      => 'appointment',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => [
                    ['key' => '_appt_date', 'value' => $date],
                    ['key' => '_appt_time', 'value' => $time_str],
                    ['key' => '_appt_status', 'value' => 'Cancelled', 'compare' => '!=']
                ]
            ]));

            $rem = max(0, $capacity - $booked_count);
            $slots[] = [
                'id'                 => $slot->ID,
                'time'               => $time_str,
                'start_time'         => $start_time,
                'end_time'           => $end_time,
                'capacity'           => $capacity,
                'booked_count'       => $booked_count,
                'remaining_capacity' => $rem,
                'is_full'            => ($rem <= 0),
                'counselor_name'     => $counselor_name,
            ];
        }
    }

    $timestamp = strtotime($date);
    $day_of_week = date('w', $timestamp);
    $is_friday = ($day_of_week == 5);

    wp_send_json_success([
        'date'         => $date,
        'is_available' => !$is_friday,
        'reason'       => $is_friday ? 'Our Mohammadpur office is closed on Fridays for weekly maintenance.' : '',
        'slots'        => $slots
    ]);
}
add_action('wp_ajax_uturnedu_get_available_slots', 'uturnedu_ajax_get_available_slots');
add_action('wp_ajax_nopriv_uturnedu_get_available_slots', 'uturnedu_ajax_get_available_slots');

/**
 * 4. Submit Appointment Reservation
 */
function uturnedu_ajax_submit_appointment() {
    if (!empty($_POST['website_hp'])) {
        wp_send_json_success([
            'message'      => 'Appointment confirmed',
            'booking_ref'  => 'ILMA-REF-OK',
            'reference_id' => 'ILMA-REF-OK',
        ]);
    }

    $name        = sanitize_text_field($_POST['student_name'] ?? $_POST['name'] ?? $_POST['book_name'] ?? '');
    $phone       = sanitize_text_field($_POST['student_phone'] ?? $_POST['phone'] ?? $_POST['book_phone'] ?? '');
    $email       = sanitize_email($_POST['student_email'] ?? $_POST['email'] ?? $_POST['book_email'] ?? '');
    $country     = sanitize_text_field($_POST['target_country'] ?? $_POST['book_country'] ?? $_POST['country'] ?? 'General');
    $date        = sanitize_text_field($_POST['appointment_date'] ?? $_POST['date'] ?? '');
    $slot_time   = sanitize_text_field($_POST['slot_time'] ?? '');
    $slot_id     = sanitize_text_field($_POST['slot_id'] ?? '');
    $type        = sanitize_text_field($_POST['consultation_type'] ?? $_POST['appointment_type'] ?? 'In-Person (Office Address)');
    $study_level = sanitize_text_field($_POST['education_level'] ?? $_POST['book_study_level'] ?? $_POST['study_level'] ?? 'Bachelor');
    $ielts_score = sanitize_text_field($_POST['ielts_score'] ?? $_POST['book_ielts_score'] ?? '');
    $notes       = sanitize_textarea_field($_POST['notes'] ?? $_POST['book_notes'] ?? '');

    if (empty($name) || empty($phone) || empty($date) || empty($slot_time)) {
        wp_send_json_error(['message' => __('Please fill all mandatory fields (Name, Phone, Date, and Time Slot).', 'uturnedu1')]);
    }

    $booking_ref = 'ILMA-' . date('Ymd') . '-' . strtoupper(wp_generate_password(4, false, false));

    // 1. Create Appointment Post
    $post_id = wp_insert_post([
        'post_title'  => "{$name} - {$date} ({$slot_time})",
        'post_type'   => 'appointment',
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => __('Could not complete booking. Please try again.', 'uturnedu1')]);
    }

    update_post_meta($post_id, '_appt_ref', $booking_ref);
    update_post_meta($post_id, '_appt_name', $name);
    update_post_meta($post_id, '_appt_phone', $phone);
    update_post_meta($post_id, '_appt_email', $email);
    update_post_meta($post_id, '_appt_country', $country);
    update_post_meta($post_id, '_appt_destination', $country);
    update_post_meta($post_id, '_appt_date', $date);
    update_post_meta($post_id, '_appt_time', $slot_time);
    update_post_meta($post_id, '_appt_slot_time', $slot_time);
    update_post_meta($post_id, '_appt_slot_id', $slot_id);
    update_post_meta($post_id, '_appt_type', $type);
    update_post_meta($post_id, '_appt_study_level', $study_level);
    update_post_meta($post_id, '_appt_education_level', $study_level);
    update_post_meta($post_id, '_appt_ielts_score', $ielts_score);
    update_post_meta($post_id, '_appt_notes', $notes);
    update_post_meta($post_id, '_appt_status', 'Confirmed');
    update_post_meta($post_id, '_appt_created_at', current_time('mysql'));

    // 2. Also Record as Lead in CRM
    $lead_id = wp_insert_post([
        'post_title'  => "{$name} ({$phone}) - In-Person Consultation",
        'post_type'   => 'lead',
        'post_status' => 'publish',
    ]);
    if (!is_wp_error($lead_id)) {
        update_post_meta($lead_id, '_lead_name', $name);
        update_post_meta($lead_id, '_lead_phone', $phone);
        update_post_meta($lead_id, '_lead_email', $email);
        update_post_meta($lead_id, '_lead_country', $country);
        update_post_meta($lead_id, '_lead_level', $study_level);
        update_post_meta($lead_id, '_lead_study_level', $study_level);
        update_post_meta($lead_id, '_lead_source', 'Appointment Booking (' . $booking_ref . ')');
        update_post_meta($lead_id, '_lead_notes', "Date: {$date}, Slot: {$slot_time}. Notes: {$notes}");
        update_post_meta($lead_id, '_lead_status', 'New');
        update_post_meta($lead_id, '_lead_submitted_at', current_time('mysql'));
    }

    wp_send_json_success([
        'message'      => __('Appointment successfully confirmed!', 'uturnedu1'),
        'booking_ref'  => $booking_ref,
        'reference_id' => $booking_ref,
        'appointment'  => [
            'referenceId'  => $booking_ref,
            'reference_id' => $booking_ref,
            'name'         => $name,
            'date'         => $date,
            'time'         => $slot_time,
            'type'         => $type,
        ]
    ]);
}
add_action('wp_ajax_uturnedu_submit_appointment', 'uturnedu_ajax_submit_appointment');
add_action('wp_ajax_nopriv_uturnedu_submit_appointment', 'uturnedu_ajax_submit_appointment');

/**
 * 5. Track Ad Clicks
 */
function uturnedu_ajax_track_ad_click() {
    $ad_id = (int) ($_POST['ad_id'] ?? 0);
    if ($ad_id) {
        $clicks = (int) get_post_meta($ad_id, '_ad_clicks', true);
        update_post_meta($ad_id, '_ad_clicks', $clicks + 1);
        wp_send_json_success();
    }
    wp_send_json_error();
}
add_action('wp_ajax_uturnedu_track_ad_click', 'uturnedu_ajax_track_ad_click');
add_action('wp_ajax_nopriv_uturnedu_track_ad_click', 'uturnedu_ajax_track_ad_click');

/**
 * 6. Admin Update Lead Status AJAX
 */
function uturnedu_ajax_admin_update_lead_status() {
    check_ajax_referer('uturnedu_admin_nonce', 'nonce');
    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => 'Unauthorized']);
    }
    $lead_id = (int) ($_POST['lead_id'] ?? 0);
    $status  = sanitize_text_field($_POST['status'] ?? 'New');
    if ($lead_id) {
        update_post_meta($lead_id, '_lead_status', $status);
        wp_send_json_success();
    }
    wp_send_json_error();
}
add_action('wp_ajax_uturnedu_admin_update_lead_status', 'uturnedu_ajax_admin_update_lead_status');

/**
 * 7. Admin Update Appointment Status AJAX
 */
function uturnedu_ajax_admin_update_appointment_status() {
    check_ajax_referer('uturnedu_admin_nonce', 'nonce');
    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => 'Unauthorized']);
    }
    $appt_id = (int) ($_POST['appointment_id'] ?? 0);
    $status  = sanitize_text_field($_POST['status'] ?? 'Confirmed');
    if ($appt_id) {
        update_post_meta($appt_id, '_appt_status', $status);
        wp_send_json_success();
    }
    wp_send_json_error();
}
add_action('wp_ajax_uturnedu_admin_update_appointment_status', 'uturnedu_ajax_admin_update_appointment_status');

/**
 * 8. Register Native WordPress REST API Endpoints for Modern Applications
 */
function uturnedu_register_rest_routes() {
    register_rest_route('uturnedu/v1', '/available-slots', [
        'methods'             => 'GET',
        'callback'            => function($request) {
            $date = sanitize_text_field($request->get_param('date') ?: date('Y-m-d'));
            $_GET['date'] = $date;
            ob_start();
            uturnedu_ajax_get_available_slots();
            $output = ob_get_clean();
            return rest_ensure_response(json_decode($output, true));
        },
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('uturnedu/v1', '/appointments', [
        'methods'             => 'POST',
        'callback'            => function($request) {
            $params = $request->get_params();
            foreach ($params as $k => $v) {
                $_POST[$k] = $v;
            }
            ob_start();
            uturnedu_ajax_submit_appointment();
            $output = ob_get_clean();
            return rest_ensure_response(json_decode($output, true));
        },
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('uturnedu/v1', '/leads', [
        'methods'             => 'POST',
        'callback'            => function($request) {
            $params = $request->get_params();
            foreach ($params as $k => $v) {
                $_POST[$k] = $v;
            }
            ob_start();
            uturnedu_ajax_submit_lead();
            $output = ob_get_clean();
            return rest_ensure_response(json_decode($output, true));
        },
        'permission_callback' => '__return_true',
    ]);
}
add_action('rest_api_init', 'uturnedu_register_rest_routes');
