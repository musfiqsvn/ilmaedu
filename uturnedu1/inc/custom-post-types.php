<?php
/**
 * UTurnEdu1 Custom Post Types and Taxonomies
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

function uturnedu_register_custom_post_types() {
    // 1. Destination CPT
    register_post_type('destination', [
        'labels' => [
            'name'               => __('Study Destinations', 'uturnedu1'),
            'singular_name'      => __('Destination', 'uturnedu1'),
            'add_new'            => __('Add New Destination', 'uturnedu1'),
            'add_new_item'       => __('Add New Destination', 'uturnedu1'),
            'edit_item'          => __('Edit Destination', 'uturnedu1'),
            'all_items'          => __('All Destinations', 'uturnedu1'),
            'menu_name'          => __('Destinations', 'uturnedu1'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'destinations'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-location-alt',
        'show_in_rest'       => true,
    ]);

    // Destination Region Taxonomy
    register_taxonomy('destination_region', ['destination'], [
        'hierarchical'      => true,
        'labels'            => [
            'name'          => __('Regions', 'uturnedu1'),
            'singular_name' => __('Region', 'uturnedu1'),
        ],
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'destination-region'],
    ]);

    // 2. Service CPT
    register_post_type('service', [
        'labels' => [
            'name'               => __('Services', 'uturnedu1'),
            'singular_name'      => __('Service', 'uturnedu1'),
            'add_new'            => __('Add New Service', 'uturnedu1'),
            'add_new_item'       => __('Add New Service', 'uturnedu1'),
            'edit_item'          => __('Edit Service', 'uturnedu1'),
            'all_items'          => __('All Services', 'uturnedu1'),
            'menu_name'          => __('Services', 'uturnedu1'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'services'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'          => 'dashicons-awards',
        'show_in_rest'       => true,
    ]);

    // 3. Testimonial CPT
    register_post_type('testimonial', [
        'labels' => [
            'name'               => __('Testimonials', 'uturnedu1'),
            'singular_name'      => __('Testimonial', 'uturnedu1'),
            'add_new'            => __('Add Testimonial', 'uturnedu1'),
            'add_new_item'       => __('Add New Testimonial', 'uturnedu1'),
            'edit_item'          => __('Edit Testimonial', 'uturnedu1'),
            'all_items'          => __('All Testimonials', 'uturnedu1'),
        ],
        'public'             => true,
        'has_archive'        => false,
        'supports'           => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon'          => 'dashicons-format-quote',
        'show_in_rest'       => true,
    ]);

    // 4. Counselor CPT
    register_post_type('counselor', [
        'labels' => [
            'name'               => __('Counselors & Team', 'uturnedu1'),
            'singular_name'      => __('Counselor', 'uturnedu1'),
            'add_new'            => __('Add Counselor', 'uturnedu1'),
            'add_new_item'       => __('Add New Counselor', 'uturnedu1'),
            'edit_item'          => __('Edit Counselor', 'uturnedu1'),
            'all_items'          => __('All Counselors', 'uturnedu1'),
        ],
        'public'             => true,
        'has_archive'        => false,
        'supports'           => ['title', 'thumbnail', 'custom-fields'],
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
    ]);

    // 5. Leads CRM CPT (Managed in dashboard & native)
    register_post_type('lead', [
        'labels' => [
            'name'               => __('Leads CRM', 'uturnedu1'),
            'singular_name'      => __('Lead', 'uturnedu1'),
            'add_new'            => __('Add Lead', 'uturnedu1'),
            'add_new_item'       => __('Add New Lead', 'uturnedu1'),
            'edit_item'          => __('Edit Lead', 'uturnedu1'),
            'all_items'          => __('All Leads', 'uturnedu1'),
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'uturnedu_dashboard',
        'supports'           => ['title', 'custom-fields'],
        'menu_icon'          => 'dashicons-id-alt',
        'show_in_rest'       => false,
    ]);

    // 6. Appointments CRM CPT
    register_post_type('appointment', [
        'labels' => [
            'name'               => __('Appointments', 'uturnedu1'),
            'singular_name'      => __('Appointment', 'uturnedu1'),
            'add_new'            => __('Add Appointment', 'uturnedu1'),
            'add_new_item'       => __('Add New Appointment', 'uturnedu1'),
            'edit_item'          => __('Edit Appointment', 'uturnedu1'),
            'all_items'          => __('All Appointments', 'uturnedu1'),
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'uturnedu_dashboard',
        'supports'           => ['title', 'custom-fields'],
        'menu_icon'          => 'dashicons-calendar-alt',
        'show_in_rest'       => false,
    ]);

    // 7. Consultation Slots CPT
    register_post_type('consult_slot', [
        'labels' => [
            'name'               => __('Consultation Slots', 'uturnedu1'),
            'singular_name'      => __('Slot', 'uturnedu1'),
            'add_new'            => __('Add Slot', 'uturnedu1'),
            'all_items'          => __('All Slots', 'uturnedu1'),
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'uturnedu_dashboard',
        'supports'           => ['title', 'custom-fields'],
        'menu_icon'          => 'dashicons-clock',
        'show_in_rest'       => false,
    ]);

    // 8. Ad Banner CPT
    register_post_type('ad_banner', [
        'labels' => [
            'name'               => __('Ad Spaces', 'uturnedu1'),
            'singular_name'      => __('Ad Banner', 'uturnedu1'),
            'add_new'            => __('Add Ad Banner', 'uturnedu1'),
            'all_items'          => __('All Ad Banners', 'uturnedu1'),
        ],
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'uturnedu_dashboard',
        'supports'           => ['title', 'custom-fields'],
        'menu_icon'          => 'dashicons-megaphone',
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'uturnedu_register_custom_post_types');
