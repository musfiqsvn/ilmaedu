<?php
/**
 * UTurnEdu1 Zero-Configuration Auto-Installer
 *
 * Automatically provisions all pages, menus, custom post types starter content,
 * homepage configuration, consultation slots, and options on theme activation.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

function uturnedu_run_auto_installer($force = false) {
    $current_version = get_option('uturnedu_setup_version');
    $target_version  = '2.2.0';

    if (!$force && $current_version === $target_version) {
        return;
    }

    // 1. Create Core Pages
    $pages = [
        'home' => [
            'title'     => 'Home',
            'slug'      => 'home',
            'template'  => 'front-page.php',
            'content'   => 'Welcome to ILMA Education Consultancy - Study Abroad, See the World, Build Career!'
        ],
        'about' => [
            'title'     => 'About Us',
            'slug'      => 'about',
            'template'  => 'page-about.php',
            'content'   => 'ILMA Education Consultancy has been empowering students since 2013 from Mohammadpur, Dhaka.'
        ],
        'destinations' => [
            'title'     => 'Study Destinations',
            'slug'      => 'destinations',
            'template'  => 'page-destinations.php',
            'content'   => 'Explore study destinations in the United Kingdom, New Zealand, Canada, Malaysia, South Korea and Japan.'
        ],
        'services' => [
            'title'     => 'Our Services',
            'slug'      => 'services',
            'template'  => 'page-services.php',
            'content'   => 'Practical education consultancy guidance tailored to your academic goals.'
        ],
        'reserve-consultation' => [
            'title'     => 'Reserve In-Person Consultation',
            'slug'      => 'reserve-consultation',
            'template'  => 'page-reserve-consultation.php',
            'content'   => 'Book your 1-on-1 personalized profile evaluation with senior certified counselors at our office.'
        ],
        'blogs' => [
            'title'     => 'Blog & News',
            'slug'      => 'blogs',
            'template'  => 'index.php',
            'content'   => 'Latest study abroad guides, visa updates, university admission tips, and student stories.'
        ],
        'contact' => [
            'title'     => 'Contact Us',
            'slug'      => 'contact',
            'template'  => 'page-contact.php',
            'content'   => 'Get in touch with ILMA Education Consultancy in Mohammadpur, Dhaka.'
        ],
        'apply-now' => [
            'title'     => 'Apply Now',
            'slug'      => 'apply-now',
            'template'  => 'page-apply-now.php',
            'content'   => 'Start your study abroad application conversation with ILMA Education Consultancy.'
        ],
        'privacy-policy' => [
            'title'     => 'Privacy Policy',
            'slug'      => 'privacy-policy',
            'template'  => 'page-legal.php',
            'content'   => 'At ILMA Education Consultancy, accessible from ilmaedubd.com, your privacy is one of our main priorities.'
        ],
        'terms-conditions' => [
            'title'     => 'Terms & Conditions',
            'slug'      => 'terms-conditions',
            'template'  => 'page-legal.php',
            'content'   => 'These Terms & Conditions outline the rules and regulations for the use of ILMA Education Consultancy\'s Website.'
        ],
        'cookie-policy' => [
            'title'     => 'Cookie Policy',
            'slug'      => 'cookie-policy',
            'template'  => 'page-legal.php',
            'content'   => 'This Cookie Policy explains how ILMA Education Consultancy uses cookies and similar technologies.'
        ],
        'disclaimer' => [
            'title'     => 'Disclaimer',
            'slug'      => 'disclaimer',
            'template'  => 'page-legal.php',
            'content'   => 'The information provided by ILMA Education Consultancy on ilmaedubd.com is for general informational purposes only.'
        ],
        'refund-policy' => [
            'title'     => 'Refund Policy',
            'slug'      => 'refund-policy',
            'template'  => 'page-legal.php',
            'content'   => 'ILMA Education Consultancy provides clear guidance and transparent information about third-party university fees.'
        ],
    ];

    $created_page_ids = [];

    foreach ($pages as $key => $page_info) {
        $existing = get_page_by_path($page_info['slug']);
        if (!$existing) {
            $page_id = wp_insert_post([
                'post_title'    => $page_info['title'],
                'post_name'     => $page_info['slug'],
                'post_content'  => $page_info['content'],
                'post_status'   => 'publish',
                'post_type'     => 'page',
            ]);
            if ($page_id && !is_wp_error($page_id)) {
                if (!empty($page_info['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $page_info['template']);
                }
                $created_page_ids[$key] = $page_id;
            }
        } else {
            $created_page_ids[$key] = $existing->ID;
            if (!empty($page_info['template'])) {
                update_post_meta($existing->ID, '_wp_page_template', $page_info['template']);
            }
        }
    }

    // Set Reading Settings (Static front page & posts page)
    if (!empty($created_page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_page_ids['home']);
    }
    if (!empty($created_page_ids['blogs'])) {
        update_option('page_for_posts', $created_page_ids['blogs']);
    }

    // 2. Setup Menus
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        if (!is_wp_error($menu_id)) {
            // Add items
            $nav_items = [
                ['title' => 'Study Destinations', 'url' => home_url('/destinations/')],
                ['title' => 'Why select us', 'url' => home_url('/#why-ilma')],
                ['title' => 'About', 'url' => home_url('/about/')],
                ['title' => 'Services', 'url' => home_url('/services/')],
                ['title' => 'Contact Us', 'url' => home_url('/contact/')],
            ];

            foreach ($nav_items as $item) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'   => $item['title'],
                    'menu-item-url'     => $item['url'],
                    'menu-item-status'  => 'publish',
                    'menu-item-type'    => 'custom',
                ]);
            }

            // Assign to location
            $locations = get_theme_mod('nav_menu_locations');
            $locations['primary-menu'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }

    // 3. Populate the shared six-destination catalog.
    // Existing USA/Australia starter records are migrated to the requested
    // South Korea/Japan destinations so an already-installed theme is not
    // left with a different set of countries.
    $legacy_destination_slugs = [
        'south-korea' => 'usa',
        'japan'       => 'australia',
    ];

    foreach (uturnedu_destination_catalog() as $dest) {
        $existing = get_page_by_path($dest['slug'], OBJECT, 'destination');
        if (!$existing && isset($legacy_destination_slugs[$dest['slug']])) {
            $existing = get_page_by_path($legacy_destination_slugs[$dest['slug']], OBJECT, 'destination');
        }

        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $dest['title'],
                'post_name'    => $dest['slug'],
                'post_content' => $dest['content'],
                'post_excerpt' => $dest['summary'],
                'post_status'  => 'publish',
                'post_type'    => 'destination',
                'menu_order'   => array_search($dest['slug'], array_column(uturnedu_destination_catalog(), 'slug'), true),
            ]);
        } else {
            $post_id = $existing->ID;
            // Only rename the two starter records being migrated. Other
            // existing destination copy remains editable by the site owner.
            if (isset($legacy_destination_slugs[$dest['slug']]) && $existing->post_name !== $dest['slug']) {
                wp_update_post([
                    'ID'           => $post_id,
                    'post_title'   => $dest['title'],
                    'post_name'    => $dest['slug'],
                    'post_content' => $dest['content'],
                    'post_excerpt' => $dest['summary'],
                    'menu_order'   => array_search($dest['slug'], array_column(uturnedu_destination_catalog(), 'slug'), true),
                ]);
            }
        }

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_dest_flag', $dest['flag']);
            update_post_meta($post_id, '_dest_code', $dest['code']);
            update_post_meta($post_id, '_dest_tuition', $dest['tuition']);
            update_post_meta($post_id, '_dest_living_cost', $dest['living']);
            update_post_meta($post_id, '_dest_intakes', $dest['intakes']);
            update_post_meta($post_id, '_dest_work_rights', $dest['work_rights']);
            update_post_meta($post_id, '_dest_psw', $dest['psw']);
            update_post_meta($post_id, '_dest_ielts', $dest['ielts']);
            update_post_meta($post_id, '_dest_universities', implode(', ', $dest['universities']));
        }
    }

    // 4. Populate Starter Services
    $services_data = [
        [
            'title'   => 'Student Visa Application Guidance',
            'slug'    => 'student-visa-application-guidance',
            'icon'    => '✈️',
            'badge'   => 'High Success Rate',
            'process' => "1. Financial Assessment & Document Verification\n2. SOP & Cover Letter Formulation\n3. Biometrics & Embassy Interview Mock Prep\n4. Visa Submission & Tracking",
            'content' => "Navigating international visa requirements can be complex. ILMA Education Consultancy provides step-by-step guidance, rigorous financial documentation checks, mock interview training, and genuine SOP reviews and careful document preparation.",
        ],
        [
            'title'   => 'University & Course Selection',
            'slug'    => 'university-course-selection',
            'icon'    => '🎓',
            'badge'   => 'Free initial guidance',
            'process' => "1. Academic & Budget Profile Analysis\n2. Country & Course Shortlisting\n3. Intake Timeline Planning\n4. Application Submission to Multiple Partner Unis",
            'content' => "Our advisors help you compare courses and universities across the United Kingdom, New Zealand, Canada, Malaysia, South Korea and Japan so your shortlist reflects your academic background and future goals.",
        ],
        [
            'title'   => 'Scholarship & Financial Aid Assistance',
            'slug'    => 'scholarship-assistance',
            'icon'    => '💰',
            'badge'   => 'Max Funding',
            'process' => "1. Scholarship Criteria Matching\n2. Essay & Portfolio Review\n3. Direct Faculty Application Guidance\n4. Award Letter Confirmation",
            'content' => "We identify and assist students in applying for generous merit-based scholarships, early bird fee waivers, international student bursaries, and graduate assistantships.",
        ],
        [
            'title'   => 'Career Counseling & Profile Evaluation',
            'slug'    => 'career-counseling',
            'icon'    => '🧭',
            'badge'   => '1-on-1 Mentorship',
            'process' => "1. In-depth 1-on-1 Consultation Session\n2. Skillset & Passion Mapping\n3. Global Employment Trends Review\n4. Personalized Academic Roadmap",
            'content' => "Our senior counselors evaluate your academic transcripts, English proficiency, career aspirations, and financial plan to craft a transparent, step-by-step higher study pathway.",
        ],
        [
            'title'   => 'SOP, Resume & Documentation Support',
            'slug'    => 'sop-documentation-support',
            'icon'    => '📄',
            'badge'   => 'Zero Plagiarism',
            'process' => "1. Questionnaire & Background Gathering\n2. Structure & Narrative Crafting\n3. Professional Proofreading\n4. Final Customized SOP Ready for Submission",
            'content' => "A compelling Statement of Purpose (SOP) and well-structured CV are critical for admissions and visa grants. We assist in shaping your authentic personal story into an impactful application.",
        ],
        [
            'title'   => 'Pre-Departure Briefing & Accommodation',
            'slug'    => 'pre-departure-briefing',
            'icon'    => '🌍',
            'badge'   => 'Complete Care',
            'process' => "1. Flight Booking & Baggage Rules Briefing\n2. On-Campus vs Off-Campus Housing Booking\n3. SIM Card & Bank Account Setup Advice\n4. Port of Entry Immigration Guidelines",
            'content' => "Our support extends right until you settle comfortably in your destination country. We organize comprehensive pre-departure sessions covering travel tips, accommodation arrangements, and foreign banking advice.",
        ],
    ];

    foreach ($services_data as $srv) {
        $existing = get_page_by_path($srv['slug'], OBJECT, 'service');
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $srv['title'],
                'post_name'    => $srv['slug'],
                'post_content' => $srv['content'],
                'post_status'  => 'publish',
                'post_type'    => 'service',
            ]);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_service_icon', $srv['icon']);
                update_post_meta($post_id, '_service_badge', $srv['badge']);
                update_post_meta($post_id, '_service_process', $srv['process']);
            }
        }
    }

    // 5. Populate Starter Testimonials
    $testimonials_data = [
        [
            'title'      => 'Tanvir Ahmed',
            'country'    => 'Canada',
            'university' => 'University of Windsor',
            'program'    => 'Master of Applied Computing',
            'rating'     => '5',
            'content'    => 'ILMA Education Consultancy made my Canadian student visa journey completely seamless! From admission to visa approval, Rawshan Sir and the team guided me with immense patience and professionalism.',
        ],
        [
            'title'      => 'Nusrat Jahan',
            'country'    => 'United Kingdom',
            'university' => 'University of Greenwich',
            'program'    => 'MSc Data Science & AI',
            'rating'     => '5',
            'content'    => 'I received my UK CAS letter and Visa in record time! Their Mohammadpur office counselors are exceptionally knowledgeable and gave me honest advice at zero consultancy cost.',
        ],
        [
            'title'      => 'Shakil Mahmud',
            'country'    => 'Japan',
            'university' => 'Waseda University',
            'program'    => 'Business and Technology pathway',
            'rating'     => '5',
            'content'    => 'The ILMA Education Consultancy team helped me compare my options, organise my documents and understand the steps for applying to Japan. The process felt clear and personal.',
        ],
        [
            'title'      => 'Farhana Rahman',
            'country'    => 'South Korea',
            'university' => 'Hanyang University',
            'program'    => 'Technology and engineering pathway',
            'rating'     => '5',
            'content'    => 'ILMA Education Consultancy helped me understand the requirements for a South Korea application and prepare my documents in a much more organised way. I always knew what to do next.',
        ],
    ];

    foreach ($testimonials_data as $testi) {
        $existing = get_page_by_path(sanitize_title($testi['title']), OBJECT, 'testimonial');
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $testi['title'],
                'post_name'    => sanitize_title($testi['title']),
                'post_content' => $testi['content'],
                'post_status'  => 'publish',
                'post_type'    => 'testimonial',
            ]);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_testi_country', $testi['country']);
                update_post_meta($post_id, '_testi_university', $testi['university']);
                update_post_meta($post_id, '_testi_program', $testi['program']);
                update_post_meta($post_id, '_testi_rating', $testi['rating']);
            }
        }
    }

    // 6. Populate Starter Counselors
    $counselors_data = [
        [
            'title'     => 'Rawshan Ara',
            'role'      => 'Senior Principal Counselor & Founder',
            'exp'       => '11+ Years Experience',
            'countries' => 'Canada, UK, South Korea',
            'email'     => 'rawshan@ilmaedubd.com',
            'phone'     => '+880 1823-345573',
        ],
        [
            'title'     => 'Md. Zahid Hassan',
            'role'      => 'UK & Asia-Pacific Specialist',
            'exp'       => '8+ Years Experience',
            'countries' => 'UK, South Korea, Japan, New Zealand',
            'email'     => 'zahid@ilmaedubd.com',
            'phone'     => '+880 1329-272046',
        ],
        [
            'title'     => 'Sadia Afrin',
            'role'      => 'North America & Scholarship Advisor',
            'exp'       => '6+ Years Experience',
            'countries' => 'South Korea, Canada',
            'email'     => 'sadia@ilmaedubd.com',
            'phone'     => '+880 1848-638406',
        ],
        [
            'title'     => 'Kazi Arman',
            'role'      => 'Asian Hubs & Fast-Track Specialist',
            'exp'       => '5+ Years Experience',
            'countries' => 'Malaysia, Europe',
            'email'     => 'arman@ilmaedubd.com',
            'phone'     => '+880 1329-272046',
        ],
    ];

    foreach ($counselors_data as $coun) {
        $existing = get_page_by_path(sanitize_title($coun['title']), OBJECT, 'counselor');
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_title'   => $coun['title'],
                'post_name'    => sanitize_title($coun['title']),
                'post_status'  => 'publish',
                'post_type'    => 'counselor',
            ]);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_counselor_role', $coun['role']);
                update_post_meta($post_id, '_counselor_exp', $coun['exp']);
                update_post_meta($post_id, '_counselor_countries', $coun['countries']);
                update_post_meta($post_id, '_counselor_email', $coun['email']);
                update_post_meta($post_id, '_counselor_phone', $coun['phone']);
            }
        }
    }

    // 7. Populate Starter Consultation Slots (Monday - Saturday intervals)
    $slots_data = [
        ['start' => '10:00 AM', 'end' => '11:30 AM', 'cap' => 4, 'counselor' => 'Senior Canada Counselor'],
        ['start' => '11:30 AM', 'end' => '01:00 PM', 'cap' => 4, 'counselor' => 'Senior UK Counselor'],
        ['start' => '02:00 PM', 'end' => '03:30 PM', 'cap' => 4, 'counselor' => 'South Korea & Japan Specialist'],
        ['start' => '03:30 PM', 'end' => '05:00 PM', 'cap' => 4, 'counselor' => 'Asia-Pacific Specialist'],
        ['start' => '05:00 PM', 'end' => '06:30 PM', 'cap' => 3, 'counselor' => 'Senior Admission Director'],
    ];

    $existing_slots = get_posts(['post_type' => 'consult_slot', 'numberposts' => 1]);
    if (empty($existing_slots)) {
        foreach ($slots_data as $s) {
            $slot_title = "Slot: {$s['start']} - {$s['end']} ({$s['counselor']})";
            $post_id = wp_insert_post([
                'post_title'  => $slot_title,
                'post_status' => 'publish',
                'post_type'   => 'consult_slot',
            ]);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_slot_start_time', $s['start']);
                update_post_meta($post_id, '_slot_end_time', $s['end']);
                update_post_meta($post_id, '_slot_capacity', $s['cap']);
                update_post_meta($post_id, '_slot_counselor_name', $s['counselor']);
                update_post_meta($post_id, '_slot_active', 'yes');
            }
        }
    }

    // 8. Populate Starter Blog Posts
    $blogs_data = [
        [
            'title'   => 'Best University in UK for Bangladeshi Students: Complete 2026 Guide',
            'slug'    => 'best-university-in-uk-2026',
            'content' => "Choosing the right university in the United Kingdom is a life-changing decision for students from Bangladesh. In this comprehensive guide, we cover ranking factors, affordable tuition fees, MOI waivers, and the 2-Year Graduate Route post-study work visa.\n\n### Top Factors to Consider:\n1. Location & Living Costs: London vs Regional cities like Portsmouth, Coventry, and Newcastle.\n2. Admission Requirements: Many UK universities accept Medium of Instruction (MOI) certificates from accredited Bangladeshi universities.\n3. Career Prospects: Look for universities with strong employability rates and internship modules.",
        ],
        [
            'title'   => 'How to Prepare for Higher Study Abroad: 7 Step Roadmap',
            'slug'    => 'how-to-prepare-for-higher-study-abroad',
            'content' => "Starting your study abroad journey early gives you the best chance of scoring top scholarships and getting your visa on time. Follow this 7-step proven roadmap formulated by ILMA Education Consultancy counselors.\n\n### The 7 Steps:\n1. Transcript & Certificate Preparation\n2. IELTS / PTE / Duolingo Preparation\n3. Country & University Matching\n4. Recommendation Letters & SOP Drafting\n5. Financial Planning & Bank Statement Readiness\n6. Application Submission across Multiple Intakes\n7. Visa File Processing & Mock Interviews",
        ],
        [
            'title'   => 'Get Tuition-Free & High Scholarship Opportunities in Canada',
            'slug'    => 'tuition-free-scholarships-canada',
            'content' => "While studying in Canada requires investment, hundreds of merit-based scholarships, research assistantships (RA), and university entrance grants can significantly lower your expenses.\n\n### Key Canadian Scholarships:\n- University of Toronto Lester B. Pearson International Scholarship\n- University of Windsor International Entrance Awards\n- Memorial University Graduate Fellowships\n- Ontario Graduate Scholarship (OGS)",
        ],
    ];

    foreach ($blogs_data as $b) {
        $existing = get_page_by_path($b['slug'], OBJECT, 'post');
        if (!$existing) {
            wp_insert_post([
                'post_title'   => $b['title'],
                'post_name'    => $b['slug'],
                'post_content' => $b['content'],
                'post_status'  => 'publish',
                'post_type'    => 'post',
            ]);
        }
    }

    // 9. Populate Starter Ad Banners
    $existing_ads = get_posts(['post_type' => 'ad_banner', 'numberposts' => 1]);
    if (empty($existing_ads)) {
        $starter_ads = [
            [
                'title'     => 'September 2026 Major Intake Promo Banner',
                'placement' => 'home_middle',
                'url'       => home_url('/reserve-consultation/'),
                'image'     => get_template_directory_uri() . '/assets/images/hero-students-2026.jpg',
            ],
        ];
        foreach ($starter_ads as $ad) {
            $post_id = wp_insert_post([
                'post_title'  => $ad['title'],
                'post_status' => 'publish',
                'post_type'   => 'ad_banner',
            ]);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_ad_placement', $ad['placement']);
                update_post_meta($post_id, '_ad_target_url', $ad['url']);
                update_post_meta($post_id, '_ad_image_url', $ad['image']);
                update_post_meta($post_id, '_ad_active', 'yes');
                update_post_meta($post_id, '_ad_clicks', 0);
            }
        }
    }

    // 10. Populate Default UTurnEdu Theme Settings
    $default_settings = [
        'site_tagline'          => 'Study Abroad, See the World, Build Career!',
        'address'               => 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh',
        'office_area'           => 'Mohammadpur, Dhaka',
        'office_hours'          => 'Saturday – Thursday: 10:00 AM – 6:30 PM (Friday Closed)',
        'site_logo_transparent' => get_template_directory_uri() . '/assets/images/ILMA-Education-logo-transparent.png',
        'popup_type'            => 'image_and_text',
        'popup_image_url'       => get_template_directory_uri() . '/assets/images/scholarship-celebration.jpg',
        'phone_primary'         => '01329272046',
        'phone_secondary'       => '01823345573',
        'phone_hotline'         => '+880 1848-638406',
        'email_primary'         => 'info@ilmaedubd.com',
        'email_support'         => 'rawshan@ilmaedubd.com',
        'form_notification_email' => 'info@ilmaedubd.com',
        'form_auto_reply_enabled' => 'no',
        'form_success_message'  => 'Thank you. Our team will review your details and contact you shortly.',
        'footer_description'   => 'Helping Bangladeshi students make informed international study decisions with clear counselling, application guidance and practical support from shortlist to departure.',
        'footer_copyright'     => 'All Rights Reserved.',
        'about_hero_title'    => 'About ILMA Education Consultancy',
        'about_hero_intro'    => 'Practical, ethical and student-first guidance for your study abroad journey.',
        'contact_hero_title'  => 'Contact ILMA Education Consultancy',
        'contact_hero_intro'  => 'Have questions about entry requirements, study destinations or your next application step?',
        'apply_hero_title'    => 'Start your study abroad application',
        'apply_hero_intro'    => 'Share your profile and our advisors will help you understand suitable destinations and next steps.',
        'reserve_hero_title'  => 'Reserve In-Person Consultation',
        'reserve_hero_intro'  => 'Schedule a dedicated 1-on-1 counselling session at our Mohammadpur office.',
        'services_hero_title' => 'Our Services',
        'services_hero_intro' => 'Explore practical support for each important decision in your application journey.',
        'stat_universities'     => '',
        'stat_free_consult'     => '',
        'stat_successful_apps'  => '',
        'stat_counselors'       => '',
        'facebook_url'          => 'https://www.facebook.com/ilmaeducationbd',
        'instagram_url'         => 'https://www.instagram.com/ilmaeducation',
        'youtube_url'           => 'https://www.youtube.com/@ilmaeducation',
        'whatsapp_number'       => '+8801848638406',
        'popup_enabled'         => 'yes',
        'popup_delay'           => '5',
        'popup_heading'         => 'Start your study abroad journey with clear, practical guidance.',
        'popup_subheading'      => 'Meet our counselors at the office or request a practical profile review.',
        'popup_cta_text'        => 'Book Free Consultation',
        'popup_cta_action'      => 'modal',
        'popup_frequency'       => 'session',
    ];

    update_option('uturnedu_settings', $default_settings);
    update_option('uturnedu_setup_version', $target_version);
    update_option('uturnedu_installed', 1);
}

/** Apply safe copy polish to an already-created primary menu without overwriting user-managed content. */
function uturnedu_migrate_public_copy_polish() {
    if (get_option('uturnedu_copy_polish_version') === '1.0.0') {
        return;
    }
    $menu = wp_get_nav_menu_object('Primary Menu');
    if ($menu) {
        foreach ((array) wp_get_nav_menu_items($menu->term_id) as $item) {
            if ($item->title === 'Why Select ILMA' || $item->title === 'Why select ILMA') {
                wp_update_nav_menu_item($menu->term_id, $item->ID, ['menu-item-title' => 'Why select us']);
            }
        }
    }
    $settings = get_option('uturnedu_settings', []);
    $settings = is_array($settings) ? $settings : [];
    $safe_defaults = [
        'popup_heading' => ['Start Your Study Abroad Journey with 100% Free Guidance!', 'Start your study abroad journey with clear, practical guidance.'],
        'stat_universities' => ['100+', ''],
        'stat_free_consult' => ['100%', ''],
        'stat_successful_apps' => ['367+', ''],
        'stat_counselors' => ['09+', ''],
    ];
    foreach ($safe_defaults as $key => $values) {
        if (($settings[$key] ?? '') === $values[0]) {
            $settings[$key] = $values[1];
        }
    }
    update_option('uturnedu_settings', $settings);
    $homepage = get_option('uturnedu_homepage_content', []);
    $homepage_copy = [
        'why_kicker' => ['Why select ILMA', 'Why select us'],
        'services_kicker' => ['How ILMA helps', 'How we help'],
        'contact_kicker' => ['Contact ILMA', 'Contact us'],
        'video_title' => ['See how ILMA helps students move forward', 'See how we help students move forward'],
    ];
    foreach ($homepage_copy as $key => $values) {
        if (($homepage[$key] ?? '') === $values[0]) {
            $homepage[$key] = $values[1];
        }
    }
    if (is_array($homepage) && $homepage) {
        update_option('uturnedu_homepage_content', $homepage);
    }
    update_option('uturnedu_copy_polish_version', '1.0.0');
}
add_action('admin_init', 'uturnedu_migrate_public_copy_polish', 20);

// Hook on theme activation
add_action('after_switch_theme', 'uturnedu_run_auto_installer');

// Check on admin init if setup is required
add_action('admin_init', function() {
    if (get_option('uturnedu_setup_version') !== '2.2.0') {
        uturnedu_run_auto_installer();
    }
});
