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
    return [
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
            'content'      => "The United Kingdom combines respected universities, diverse campus communities and a wide choice of taught and research-led courses. ILMA helps students compare entry requirements, tuition, location and available intakes before they apply.\n\n### Why consider the United Kingdom?\n- Globally recognised degrees across many disciplines\n- A strong range of one-year postgraduate courses\n- Cities and campuses with different budgets and lifestyles\n- Course-specific guidance on English language and visa requirements",
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
            'content'      => "New Zealand offers a calm, supportive setting for students who value practical learning and quality of life. ILMA can help you compare programmes, city costs and entry requirements across its universities.\n\n### Why consider New Zealand?\n- Practical teaching with strong links to real-world skills\n- A welcoming, student-focused environment\n- Clear planning around February and July intakes\n- A good fit for students seeking a balanced campus experience",
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
            'content'      => "Canada gives students access to a diverse academic landscape, from research universities to career-focused colleges. ILMA helps you review programme requirements, budget and intake timing before selecting a pathway.\n\n### Why consider Canada?\n- Diverse communities and a broad programme choice\n- Applied and research-led study options\n- Support to compare major cities with more affordable regions\n- A structured application journey from shortlist to submission",
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
            'content'      => "Malaysia offers an international study experience in a cost-conscious, well-connected part of Asia. Students can explore local universities, international branch campuses and transfer pathways with ILMA's guidance.\n\n### Why consider Malaysia?\n- Often more accessible tuition and living costs\n- International curricula and branch campus options\n- A multicultural environment close to home\n- Flexible intakes across many programmes",
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
            'content'      => "South Korea combines a strong research culture with energetic, highly connected cities. It can suit students interested in technology, business, design and other globally relevant fields. ILMA helps you compare English-taught programmes, requirements and realistic budgets.\n\n### Why consider South Korea?\n- Well-established universities and research communities\n- Strong technology, business and creative industries\n- A distinctive international student experience\n- Programme-specific support for English-taught applications",
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
    $number = preg_replace('/[^0-9]/', '', uturnedu_get_setting('whatsapp_number', '+8801329272046'));
    if (!$number) {
        return '';
    }

    $url = 'https://wa.me/' . $number;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }

    return $url;
}
