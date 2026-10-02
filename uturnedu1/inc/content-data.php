<?php
/**
 * ILMA content catalogs and presentation helpers.
 *
 * Keeping destination content in one place makes it simple for the team to add
 * another country without copying a template or duplicating card markup.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * The six destinations featured in the current ILMA conversion journey.
 *
 * Images are local, replaceable theme assets. University names are presented as
 * examples to explore, not as a claim of partnership or admission guarantee.
 */
function uturnedu_destination_catalog() {
    $catalog = [
        [
            'title'        => 'United Kingdom',
            'slug'         => 'uk',
            'code'         => 'UK',
            'flag'         => '🇬🇧',
            'image'        => 'uk2.jpeg',
            'flag_image'   => 'united-kingdom-1.png',
            'summary'      => 'A globally respected study destination with a wide choice of undergraduate and postgraduate routes.',
            'why'          => [
                'Globally recognised qualifications across a broad range of subjects.',
                'A strong choice for focused postgraduate study and research.',
                'Clear application planning around September and January intakes.',
            ],
            'universities' => [
                'University of Greenwich',
                'University of Hertfordshire',
                'Coventry University',
                'University of Portsmouth',
            ],
            'tuition'      => '£11,000–£22,000 / year',
            'living'       => '£9,000–£12,000 / year',
            'intakes'      => 'September, January and selected May intakes',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Graduate Route options may apply',
            'ielts'        => 'Usually 6.0–6.5, depending on course',
            'content'      => "The United Kingdom combines respected universities, diverse campus communities and a wide choice of taught and research-led courses. Our team helps students compare entry requirements, tuition, location and available intakes before they apply.\n\n### Why consider the United Kingdom?\n- Globally recognised degrees across many disciplines\n- A strong range of one-year postgraduate courses\n- Cities and campuses with different budgets and lifestyles\n- Course-specific guidance on English language and visa requirements",
        ],
        [
            'title'        => 'New Zealand',
            'slug'         => 'new-zealand',
            'code'         => 'NZ',
            'flag'         => '🇳🇿',
            'image'        => 'new.jpeg',
            'flag_image'   => 'new-zealand.png',
            'summary'      => 'A welcoming destination known for practical learning, student wellbeing and a balanced lifestyle.',
            'why'          => [
                'Practical, career-focused teaching in a supportive environment.',
                'A welcoming culture with a strong focus on student wellbeing.',
                'Opportunities to compare city and regional study settings.',
            ],
            'universities' => [
                'University of Auckland',
                'University of Otago',
                'Massey University',
                'Auckland University of Technology',
            ],
            'tuition'      => 'NZD $18,000–$32,000 / year',
            'living'       => 'NZD $11,000–$15,000 / year',
            'intakes'      => 'February and July, with selected additional intakes',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Post-study options depend on qualification and policy',
            'ielts'        => 'Usually 6.0–6.5, depending on course',
            'content'      => "New Zealand offers a calm, supportive setting for students who value practical learning and quality of life. Our team can help you compare programmes, city costs and entry requirements across its universities.\n\n### Why consider New Zealand?\n- Practical teaching with strong links to real-world skills\n- A welcoming, student-focused environment\n- Clear planning around February and July intakes\n- A good fit for students seeking a balanced campus experience",
        ],
        [
            'title'        => 'Canada',
            'slug'         => 'canada',
            'code'         => 'CA',
            'flag'         => '🇨🇦',
            'image'        => 'canada-1024x683.jpeg',
            'flag_image'   => 'canada.png',
            'summary'      => 'A diverse study environment with respected institutions and a broad range of academic pathways.',
            'why'          => [
                'A multicultural campus experience across major and regional cities.',
                'Strong options in applied, professional and research-led programmes.',
                'Support to compare tuition, living costs and programme fit.',
            ],
            'universities' => [
                'University of Toronto',
                'University of Windsor',
                'Memorial University of Newfoundland',
                'Humber College',
            ],
            'tuition'      => 'CAD $16,000–$35,000 / year',
            'living'       => 'CAD $10,000–$14,000 / year',
            'intakes'      => 'September, January and selected May intakes',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Post-graduation options depend on programme and policy',
            'ielts'        => 'Usually 6.0–6.5, depending on course',
            'content'      => "Canada gives students access to a diverse academic landscape, from research universities to career-focused colleges. Our team helps you review programme requirements, budget and intake timing before selecting a pathway.\n\n### Why consider Canada?\n- Diverse communities and a broad programme choice\n- Applied and research-led study options\n- Support to compare major cities with more affordable regions\n- A structured application journey from shortlist to submission",
        ],
        [
            'title'        => 'Malaysia',
            'slug'         => 'malaysia',
            'code'         => 'MY',
            'flag'         => '🇲🇾',
            'image'        => 'malay-2.jpeg',
            'flag_image'   => 'malaysia.png',
            'summary'      => 'An accessible Asian study destination with international campuses and a wide range of programmes.',
            'why'          => [
                'Competitive tuition and living costs for many programmes.',
                'International branch campuses and transfer pathways to explore.',
                'A familiar, multicultural setting with strong regional connections.',
            ],
            'universities' => [
                "Taylor's University",
                'Sunway University',
                'Asia Pacific University',
                'UCSI University',
            ],
            'tuition'      => 'USD $3,500–$9,000 / year',
            'living'       => 'USD $3,000–$5,000 / year',
            'intakes'      => 'January, May and September, depending on course',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Transfer and international campus routes vary by programme',
            'ielts'        => 'Usually 5.5–6.0, depending on course',
            'content'      => "Malaysia offers an international study experience in a cost-conscious, well-connected part of Asia. Students can explore local universities, international branch campuses and transfer pathways with our guidance.\n\n### Why consider Malaysia?\n- Often more accessible tuition and living costs\n- International curricula and branch campus options\n- A multicultural environment close to home\n- Flexible intakes across many programmes",
        ],
        [
            'title'        => 'South Korea',
            'slug'         => 'south-korea',
            'code'         => 'KR',
            'flag'         => '🇰🇷',
            'image'        => 'south-korea-study.jpg',
            'flag_image'   => 'flag.png',
            'summary'      => 'A technology-forward destination with respected universities, vibrant cities and growing English-taught options.',
            'why'          => [
                'Strong academic and research culture in technology and business.',
                'Modern cities with a distinctive, globally connected student life.',
                'A growing selection of English-taught courses to compare.',
            ],
            'universities' => [
                'Seoul National University',
                'Yonsei University',
                'Korea University',
                'Hanyang University',
            ],
            'tuition'      => 'KRW 4,000,000–10,000,000 / year',
            'living'       => 'Varies by city and lifestyle',
            'intakes'      => 'March and September, depending on institution',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Post-study pathways depend on qualification and policy',
            'ielts'        => 'English-taught course requirements vary',
            'content'      => "South Korea combines a strong research culture with energetic, highly connected cities. It can suit students interested in technology, business, design and other globally relevant fields. Our team helps you compare English-taught programmes, requirements and realistic budgets.\n\n### Why consider South Korea?\n- Well-established universities and research communities\n- Strong technology, business and creative industries\n- A distinctive international student experience\n- Programme-specific support for English-taught applications",
        ],
        [
            'title'        => 'Japan',
            'slug'         => 'japan',
            'code'         => 'JP',
            'flag'         => '🇯🇵',
            'image'        => 'japan-study.jpg',
            'flag_image'   => 'flag.png',
            'summary'      => 'A high-quality study destination blending respected academics, innovation and a rich cultural experience.',
            'why'          => [
                'A strong academic tradition with particular depth in innovation and engineering.',
                'Safe, well-connected cities with a rich cultural experience.',
                'English-taught and Japanese-taught routes to explore by subject.',
            ],
            'universities' => [
                'The University of Tokyo',
                'Kyoto University',
                'Osaka University',
                'Waseda University',
            ],
            'tuition'      => 'Varies by institution and programme',
            'living'       => 'Varies by city and lifestyle',
            'intakes'      => 'April and October, depending on institution',
            'work_rights'  => 'Subject to current student visa rules',
            'psw'          => 'Post-study pathways depend on qualification and policy',
            'ielts'        => 'English-taught course requirements vary',
            'content'      => "Japan offers a distinctive mix of respected academics, innovation and cultural depth. Students can explore English-taught and Japanese-taught routes across technology, business, design and the sciences with careful course matching.\n\n### Why consider Japan?\n- Strong academic and research tradition\n- Innovation-led programmes across many disciplines\n- Safe, well-connected cities and campuses\n- A chance to build international experience in a unique setting",
        ],
    ];

    // Published destination posts become the single source of truth for the public
    // country carousel and cards. The static catalog remains a safe fallback for a
    // fresh install before the starter content has been created.
    $managed_posts = get_posts([
        'post_type'      => 'destination',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ]);
    if (empty($managed_posts)) {
        return get_option('uturnedu_installed', 0) ? [] : $catalog;
    }

    $managed_catalog = [];
    foreach ($managed_posts as $post) {
        $slug = $post->post_name;
        $base = null;
        foreach ($catalog as $catalog_item) {
            if ($catalog_item['slug'] === $slug || strtoupper($catalog_item['code']) === strtoupper(get_post_meta($post->ID, '_dest_code', true))) {
                $base = $catalog_item;
                break;
            }
        }
        $base = $base ?: [
            'title' => get_the_title($post->ID), 'slug' => $slug,
            'code' => strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $slug), 0, 2)),
            'flag' => '🌍', 'image' => 'hero-students-2026.jpg', 'flag_image' => 'flag.png',
            'summary' => '', 'hero_heading' => '', 'hero_description' => '', 'cta_label' => '', 'cta_url' => '', 'why' => [], 'universities' => [], 'tuition' => '', 'living' => '',
            'intakes' => '', 'work_rights' => '', 'psw' => '', 'ielts' => '', 'content' => '',
        ];
        $code = get_post_meta($post->ID, '_dest_code', true) ?: $base['code'];
        $universities = get_post_meta($post->ID, '_dest_universities', true);
        $summary = get_the_excerpt($post->ID);
        $managed_catalog[] = array_merge($base, [
            'title'        => get_the_title($post->ID),
            'slug'         => $slug,
            'code'         => strtoupper($code),
            'flag'         => get_post_meta($post->ID, '_dest_flag', true) ?: $base['flag'],
            'summary'      => $summary ?: wp_trim_words(wp_strip_all_tags($post->post_content), 28),
            'hero_heading' => get_post_meta($post->ID, '_dest_hero_heading', true) ?: 'Study in ' . get_the_title($post->ID),
            'hero_description' => get_post_meta($post->ID, '_dest_hero_description', true) ?: ($summary ?: wp_trim_words(wp_strip_all_tags($post->post_content), 28)),
            'cta_label'   => get_post_meta($post->ID, '_dest_cta_label', true) ?: 'Explore destination',
            'cta_url'     => get_post_meta($post->ID, '_dest_cta_url', true) ?: get_permalink($post->ID),
            'why'          => $base['why'],
            'universities' => $universities ? array_values(array_filter(array_map('trim', explode(',', $universities)))) : $base['universities'],
            'tuition'      => get_post_meta($post->ID, '_dest_tuition', true) ?: $base['tuition'],
            'living'       => get_post_meta($post->ID, '_dest_living_cost', true) ?: $base['living'],
            'intakes'      => get_post_meta($post->ID, '_dest_intakes', true) ?: $base['intakes'],
            'work_rights'  => get_post_meta($post->ID, '_dest_work_rights', true) ?: $base['work_rights'],
            'psw'          => get_post_meta($post->ID, '_dest_psw', true) ?: $base['psw'],
            'ielts'        => get_post_meta($post->ID, '_dest_ielts', true) ?: $base['ielts'],
            'content'      => $post->post_content ?: $base['content'],
        ]);
    }

    return $managed_catalog;
}

/** Resolve a destination post and keep legacy USA/Australia starter URLs useful. */
function uturnedu_get_destination_post($slug) {
    $slug = sanitize_title($slug);
    $post = get_page_by_path($slug, OBJECT, 'destination');
    if (!$post) {
        $legacy_slug = ['south-korea' => 'usa', 'japan' => 'australia'][$slug] ?? '';
        if ($legacy_slug) {
            $post = get_page_by_path($legacy_slug, OBJECT, 'destination');
        }
    }

    return $post;
}

/**
 * Original ILMA service cards used by the homepage information architecture.
 * The service CPTs remain available for detailed, editable service pages.
 */
function uturnedu_service_catalog() {
    return [
        [
            'title'       => 'University admission guidance',
            'description' => 'Turn a broad idea into a focused shortlist and an organised application plan.',
            'bullets'     => ['Course and intake planning', 'Application timeline mapping'],
        ],
        [
            'title'       => 'Course and university selection',
            'description' => 'Compare academic fit, entry requirements, location and budget before you commit.',
            'bullets'     => ['Profile-led shortlisting', 'Side-by-side destination advice'],
        ],
        [
            'title'       => 'Eligibility assessment',
            'description' => 'Understand what your academic history and English profile mean for the routes you are considering.',
            'bullets'     => ['Document checklist', 'Language requirement review'],
        ],
        [
            'title'       => 'Application processing',
            'description' => 'Prepare a clear, accurate application with practical support at each submission stage.',
            'bullets'     => ['Application review', 'SOP and document guidance'],
        ],
        [
            'title'       => 'Visa guidance',
            'description' => 'Get organised around the evidence, timelines and preparation needed for your visa journey.',
            'bullets'     => ['Document preparation', 'Interview and credibility practice'],
        ],
        [
            'title'       => 'Scholarship guidance',
            'description' => 'Identify funding routes that match your profile and learn how to present a strong application.',
            'bullets'     => ['Funding opportunity review', 'Application planning'],
        ],
        [
            'title'       => 'Pre-departure and student support',
            'description' => 'Prepare for the practical realities of moving, travelling and settling into your new destination.',
            'bullets'     => ['Pre-departure briefing', 'Accommodation and arrival guidance'],
        ],
        [
            'title'       => 'Career and post-study guidance',
            'description' => 'Keep your course choice connected to the skills and direction you want to build next.',
            'bullets'     => ['Career-focused conversations', 'Post-study planning context'],
        ],
    ];
}

/** Return editable homepage copy, with sensible fallbacks for a fresh install. */
function uturnedu_get_homepage_content() {
    $defaults = [
        'hero_kicker'          => 'International study guidance, made clear',
        'hero_cta'             => 'Check your eligibility',
        'hero_secondary_cta'   => 'Explore destination',
        'destination_kicker'   => 'Start with a destination',
        'destination_title'    => 'Where could your next chapter take you?',
        'destination_intro'    => 'Compare the places that fit your ambitions, budget and preferred way of learning. Each guide takes you from first questions to a practical application conversation.',
        'why_kicker'           => 'Why select us',
        'why_title'            => 'A more considered way to plan your study abroad journey.',
        'why_intro'            => 'Good guidance is not about sending every student to the same place. It is about listening carefully, setting realistic options and helping you make an informed decision.',
        'why_card_1_title'     => 'Personalised counselling', 'why_card_1_text' => 'Discuss your academic background, interests and preferred learning environment before shortlisting options.',
        'why_card_2_title'     => 'Thoughtful university selection', 'why_card_2_text' => 'Compare course fit, entry requirements, location and budget instead of choosing on rankings alone.',
        'why_card_3_title'     => 'Eligibility clarity', 'why_card_3_text' => 'Understand the documents, language requirements and timelines you need for a confident next step.',
        'why_card_4_title'     => 'Support that stays practical', 'why_card_4_text' => 'From application preparation to visa and pre-departure guidance, know who to ask and what happens next.',
        'services_kicker'      => 'How we help',
        'services_title'       => 'Support for every important decision',
        'services_intro'       => 'Move forward with a clear plan, from your first course conversation to the day you prepare to leave.',
        'process_kicker'       => 'A clear process',
        'process_title'        => 'From first question to application',
        'process_intro'        => 'Every student starts in a different place. Our process gives you a useful next step without making the journey feel complicated.',
        'process_1_title'      => 'Tell us your plan', 'process_1_text' => 'Share your subject interests, study level and preferred destinations.',
        'process_2_title'      => 'Review your fit', 'process_2_text' => 'We discuss eligibility, documents, budget and realistic course options.',
        'process_3_title'      => 'Prepare your application', 'process_3_text' => 'Build a focused shortlist and organise the information each institution needs.',
        'process_4_title'      => 'Move forward with support', 'process_4_text' => 'Continue with visa, scholarship and pre-departure guidance when relevant.',
        'eligibility_kicker'   => 'Your next step',
        'eligibility_title'   => 'Not sure where you are eligible to apply?',
        'eligibility_text'    => 'Share a few details and one of our advisors can help you understand suitable destinations, course routes and the documents to prepare.',
        'eligibility_cta'     => 'Check your eligibility',
        'contact_kicker'      => 'Contact us',
        'contact_title'       => 'Let’s make your next step clearer.',
        'contact_text'        => 'Tell us what you are considering. We can help you start with a destination, a course question or an eligibility check.',
        'video_enabled'       => 'no',
        'video_url'           => '',
        'video_poster'        => '',
        'video_title'         => 'See how we help students move forward',
        'video_text'          => 'Add an introduction video, office tour or student guidance video from the dashboard when you are ready.',
    ];

    $saved = get_option('uturnedu_homepage_content', []);
    return array_merge($defaults, is_array($saved) ? $saved : []);
}

/** Safely render an optional YouTube/Vimeo embed or local MP4 from the builder. */
function uturnedu_render_video_embed($url, $poster = '') {
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }

    $extension = strtolower(pathinfo((string) wp_parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
    if (in_array($extension, ['mp4', 'webm', 'ogg'], true)) {
        return '<video class="ilma-video-player" controls preload="metadata"' . ($poster ? ' poster="' . esc_url($poster) . '"' : '') . '><source src="' . esc_url($url) . '" type="video/' . esc_attr($extension) . '">' . esc_html__('Your browser does not support the video tag.', 'uturnedu1') . '</video>';
    }

    $embed = wp_oembed_get($url, ['width' => 1000, 'height' => 560]);
    return $embed ? '<div class="ilma-video-embed">' . $embed . '</div>' : '';
}

/** Return a catalog entry by slug or title code. */
function uturnedu_get_destination_data($key) {
    $key = sanitize_title($key);
    // Keep older starter links useful while the 2.0 installer migrates records.
    $key = ['usa' => 'south-korea', 'australia' => 'japan', 'us' => 'south-korea', 'au' => 'japan'][$key] ?? $key;
    foreach (uturnedu_destination_catalog() as $destination) {
        if ($destination['slug'] === $key || sanitize_title($destination['code']) === $key) {
            return $destination;
        }
    }

    return null;
}

/** Resolve a local destination image for cards and detail pages. */
function uturnedu_get_destination_image($code) {
    $destination = uturnedu_get_destination_data($code);
    $post = $destination ? uturnedu_get_destination_post($destination['slug']) : null;
    $managed_image = $post ? get_post_meta($post->ID, '_dest_image_url', true) : '';
    if ($managed_image) {
        return esc_url($managed_image);
    }
    $featured_image = $post ? get_the_post_thumbnail_url($post->ID, 'full') : '';
    if ($featured_image) {
        return esc_url($featured_image);
    }
    $filename = $destination['image'] ?? 'hero-students-2026.jpg';
    return get_template_directory_uri() . '/assets/images/' . $filename;
}

/** Resolve a local destination flag. Some destinations use the neutral flag asset. */
function uturnedu_get_destination_flag($code) {
    $destination = uturnedu_get_destination_data($code);
    $filename = $destination['flag_image'] ?? 'flag.png';
    return get_template_directory_uri() . '/assets/images/' . $filename;
}

/** Return the configured WhatsApp link without duplicating the number in templates. */
function uturnedu_whatsapp_url($message = '') {
    $number = preg_replace('/[^0-9]/', '', uturnedu_get_setting('whatsapp_number', '+8801848638406'));
    if (!$number) {
        return '';
    }

    $url = 'https://wa.me/' . $number;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }

    return $url;
}
