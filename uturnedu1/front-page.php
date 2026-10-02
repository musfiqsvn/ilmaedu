<?php
/**
 * ILMA Education Consultancy homepage.
 *
 * The page follows a simple conversion journey: choose a destination, understand
 * the route, check eligibility, then speak with an advisor.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$settings = get_option('uturnedu_settings', []);
$address  = $settings['address'] ?? 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';
$phone    = $settings['phone_primary'] ?? '01329272046';
$email    = $settings['email_primary'] ?? 'info@ilmaedubd.com';
$whatsapp = uturnedu_whatsapp_url('Hello ILMA Education, I would like help choosing a study destination.');
$destinations = uturnedu_destination_catalog();
$services = uturnedu_service_catalog();
?>

<main>
  <!-- Compact hero: the image supports the message instead of taking over the page. -->
  <section class="hero-section home-hero-section" aria-labelledby="home-hero-title">
    <div class="hero-glow-1" aria-hidden="true"></div>
    <div class="hero-glow-2" aria-hidden="true"></div>
    <div class="container">
      <div class="home-hero-grid">
        <div class="home-hero-copy">
          <span class="hero-tag"><span aria-hidden="true">✦</span> International study guidance, made clear</span>
          <h1 id="home-hero-title" class="hero-title">Choose your next <span class="hero-title-accent">study destination</span> with confidence.</h1>
          <p class="hero-desc">Personalised counselling for students planning university study in the United Kingdom, New Zealand, Canada, Malaysia, South Korea or Japan.</p>

          <div class="hero-ctas">
            <button type="button" class="btn btn-accent btn-lg open-consultancy-modal" data-modal-title="Check your eligibility">
              <span>Check your eligibility</span>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
            <a href="#destinations" class="btn btn-outline-white btn-lg">
              <span>Explore destinations</span>
            </a>
          </div>

          <div class="hero-destination-line" aria-label="Study destinations available through ILMA">
            <span class="hero-destination-label">Explore</span>
            <?php foreach ($destinations as $index => $destination): ?>
              <span><?php echo esc_html($destination['title']); ?></span><?php if ($index < count($destinations) - 1): ?><span aria-hidden="true">•</span><?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="home-hero-visual" aria-label="Students preparing for international study">
          <div class="hero-visual-image-wrap">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-students-2026.jpg'); ?>" alt="Students preparing for university study abroad" width="900" height="600" fetchpriority="high">
            <div class="hero-visual-caption">
              <span class="hero-caption-icon" aria-hidden="true">✓</span>
              <span><strong>A clearer route to your next step</strong><small>Guidance from shortlist to departure</small></span>
            </div>
          </div>
          <div class="hero-route-card">
            <span class="route-card-kicker">Your journey, simplified</span>
            <div class="route-steps" aria-label="ILMA student journey">
              <span><b>01</b> Explore</span><span><b>02</b> Assess</span><span><b>03</b> Apply</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="trust-strip" aria-label="ILMA support principles">
    <div class="container trust-strip-grid">
      <div><span class="trust-strip-icon" aria-hidden="true">◎</span><span><strong>Student-first advice</strong><small>Recommendations built around your goals</small></span></div>
      <div><span class="trust-strip-icon" aria-hidden="true">↗</span><span><strong>Clear next steps</strong><small>Understand requirements before you apply</small></span></div>
      <div><span class="trust-strip-icon" aria-hidden="true">◌</span><span><strong>Human support</strong><small>Speak with a real education advisor</small></span></div>
    </div>
  </section>

  <!-- Primary conversion section: destination cards are deliberately early in the page. -->
  <section id="destinations" class="section section-bg-alt destination-section" aria-labelledby="destinations-title">
    <div class="container">
      <div class="section-title-wrap align-left destination-section-heading">
        <div>
          <span class="section-badge section-badge-accent">Start with a destination</span>
          <h2 id="destinations-title" class="section-title">Where could your next chapter take you?</h2>
        </div>
        <p class="section-subtitle">Compare the places that fit your ambitions, budget and preferred way of learning. Each guide takes you from first questions to a practical application conversation.</p>
      </div>

      <div class="destination-grid">
        <?php foreach ($destinations as $destination):
            $destination_post = uturnedu_get_destination_post($destination['slug']);
            $destination_url = $destination_post ? get_permalink($destination_post->ID) : home_url('/destinations/' . $destination['slug'] . '/');
            $summary = $destination_post ? get_the_excerpt($destination_post->ID) : $destination['summary'];
            if (!$summary) {
                $summary = $destination['summary'];
            }
        ?>
          <article class="destination-card destination-card-premium">
            <a class="dest-img-wrap" href="<?php echo esc_url($destination_url); ?>" aria-label="Read the <?php echo esc_attr($destination['title']); ?> study guide">
              <img src="<?php echo esc_url(uturnedu_get_destination_image($destination['code'])); ?>" alt="Study in <?php echo esc_attr($destination['title']); ?>" loading="lazy" width="800" height="500">
              <span class="dest-country-pill"><img src="<?php echo esc_url(uturnedu_get_destination_flag($destination['code'])); ?>" alt="" width="20" height="14" aria-hidden="true"> <?php echo esc_html($destination['title']); ?></span>
              <span class="dest-image-arrow" aria-hidden="true">↗</span>
            </a>
            <div class="dest-content">
              <h3 class="dest-title"><a href="<?php echo esc_url($destination_url); ?>">Study in <?php echo esc_html($destination['title']); ?></a></h3>
              <p class="dest-desc"><?php echo esc_html(wp_trim_words(wp_strip_all_tags($summary), 18)); ?></p>
              <div class="dest-meta-chips">
                <span class="meta-chip"><span aria-hidden="true">◷</span> <?php echo esc_html(explode(',', $destination['intakes'])[0]); ?></span>
                <span class="meta-chip"><span aria-hidden="true">⌁</span> <?php echo esc_html($destination['tuition']); ?></span>
              </div>

              <div class="destination-journey" aria-label="Actions for <?php echo esc_attr($destination['title']); ?>">
                <a href="<?php echo esc_url($destination_url . '#why-this-country'); ?>" class="journey-link"><span>Why this country</span><span aria-hidden="true">→</span></a>
                <a href="<?php echo esc_url($destination_url . '#universities'); ?>" class="journey-link"><span>Universities</span><span aria-hidden="true">→</span></a>
                <button type="button" class="journey-link journey-link-strong" data-country="<?php echo esc_attr($destination['title']); ?>" data-modal-title="Check your <?php echo esc_attr($destination['title']); ?> eligibility"><span>Check eligibility</span><span aria-hidden="true">↗</span></button>
                <button type="button" class="journey-link journey-link-primary" data-country="<?php echo esc_attr($destination['title']); ?>" data-modal-title="Apply to <?php echo esc_attr($destination['title']); ?>"><span>Apply now</span><span aria-hidden="true">↗</span></button>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="section-foot-cta">
        <p>Not sure which destination fits your profile?</p>
        <button type="button" class="text-link-button open-consultancy-modal">Speak with an ILMA advisor <span aria-hidden="true">→</span></button>
      </div>
    </div>
  </section>

  <!-- Dedicated value proposition section. -->
  <section id="why-ilma" class="section why-ilma-section" aria-labelledby="why-ilma-title">
    <div class="container">
      <div class="split-section-heading">
        <div>
          <span class="section-badge">Why select ILMA</span>
          <h2 id="why-ilma-title">A more considered way to plan your study abroad journey.</h2>
        </div>
        <p>Good guidance is not about sending every student to the same place. It is about listening carefully, setting realistic options and helping you make an informed decision.</p>
      </div>

      <div class="why-ilma-grid">
        <article class="why-ilma-card"><span class="why-card-number">01</span><h3>Personalised counselling</h3><p>Discuss your academic background, interests and preferred learning environment before shortlisting options.</p></article>
        <article class="why-ilma-card"><span class="why-card-number">02</span><h3>Thoughtful university selection</h3><p>Compare course fit, entry requirements, location and budget instead of choosing on rankings alone.</p></article>
        <article class="why-ilma-card"><span class="why-card-number">03</span><h3>Eligibility clarity</h3><p>Understand the documents, language requirements and timelines you need for a confident next step.</p></article>
        <article class="why-ilma-card"><span class="why-card-number">04</span><h3>Support that stays practical</h3><p>From application preparation to visa and pre-departure guidance, know who to ask and what happens next.</p></article>
      </div>
    </div>
  </section>

  <!-- Services reference-inspired information architecture, with original ILMA copy. -->
  <section id="services" class="section section-bg-alt services-section" aria-labelledby="services-title">
    <div class="container">
      <div class="section-title-wrap">
        <span class="section-badge section-badge-accent">How ILMA helps</span>
        <h2 id="services-title" class="section-title">Support for every important decision</h2>
        <p class="section-subtitle">Move forward with a clear plan, from your first course conversation to the day you prepare to leave.</p>
      </div>

      <div class="services-grid services-grid-home">
        <?php foreach ($services as $index => $service): ?>
          <article class="service-card service-card-premium">
            <div class="service-card-top"><span class="service-index"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span><span class="service-mark" aria-hidden="true">↗</span></div>
            <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
            <p class="service-desc"><?php echo esc_html($service['description']); ?></p>
            <ul class="service-bullets">
              <?php foreach ($service['bullets'] as $bullet): ?>
                <li><span class="bullet-check" aria-hidden="true">✓</span><span><?php echo esc_html($bullet); ?></span></li>
              <?php endforeach; ?>
            </ul>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="center-cta-row"><a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn btn-outline btn-lg">Explore all ILMA services <span aria-hidden="true">→</span></a></div>
    </div>
  </section>

  <!-- A short, scannable process keeps the path to application visible. -->
  <section id="process" class="section process-section" aria-labelledby="process-title">
    <div class="container">
      <div class="split-section-heading">
        <div><span class="section-badge">A clear process</span><h2 id="process-title">From first question to application</h2></div>
        <p>Every student starts in a different place. Our process gives you a useful next step without making the journey feel complicated.</p>
      </div>
      <ol class="process-grid">
        <li class="process-step"><span class="process-step-number">01</span><h3>Tell us your plan</h3><p>Share your subject interests, study level and preferred destinations.</p></li>
        <li class="process-step"><span class="process-step-number">02</span><h3>Review your fit</h3><p>We discuss eligibility, documents, budget and realistic course options.</p></li>
        <li class="process-step"><span class="process-step-number">03</span><h3>Prepare your application</h3><p>Build a focused shortlist and organise the information each institution needs.</p></li>
        <li class="process-step"><span class="process-step-number">04</span><h3>Move forward with support</h3><p>Continue with visa, scholarship and pre-departure guidance when relevant.</p></li>
      </ol>
    </div>
  </section>

  <?php
  $testi_query = new WP_Query([
      'post_type'      => 'testimonial',
      'posts_per_page' => 3,
      'post_status'    => 'publish',
      'no_found_rows'  => true,
  ]);
  if ($testi_query->have_posts()):
  ?>
    <section class="section student-perspectives-section section-bg-alt" aria-labelledby="perspectives-title">
      <div class="container">
        <div class="section-title-wrap"><span class="section-badge section-badge-accent">Student perspectives</span><h2 id="perspectives-title" class="section-title">Support should feel personal</h2><p class="section-subtitle">A few words from students whose stories are already part of the ILMA journey.</p></div>
        <div class="student-perspectives-grid">
          <?php while ($testi_query->have_posts()): $testi_query->the_post(); ?>
            <article class="perspective-card"><div class="stars-row" aria-label="5 out of 5 stars">★★★★★</div><p class="perspective-quote">“<?php echo esc_html(wp_trim_words(get_the_content(), 30)); ?>”</p><div class="perspective-name"><?php the_title(); ?></div><div class="perspective-meta"><?php echo esc_html(get_post_meta(get_the_ID(), '_testi_program', true)); ?> · <?php echo esc_html(get_post_meta(get_the_ID(), '_testi_country', true)); ?></div></article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Strong but calm final conversion area. -->
  <section id="eligibility" class="section eligibility-section" aria-labelledby="eligibility-title">
    <div class="container">
      <div class="eligibility-panel">
        <div class="eligibility-copy"><span class="section-badge section-badge-dark">Your next step</span><h2 id="eligibility-title">Not sure where you are eligible to apply?</h2><p>Share a few details and an ILMA advisor can help you understand suitable destinations, course routes and the documents to prepare.</p></div>
        <div class="eligibility-actions"><button type="button" class="btn btn-accent btn-lg open-consultancy-modal">Check your eligibility <span aria-hidden="true">↗</span></button><?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="btn btn-whatsapp btn-lg" target="_blank" rel="noopener">Chat on WhatsApp <span aria-hidden="true">↗</span></a><?php endif; ?></div>
      </div>
    </div>
  </section>

  <section id="contact" class="section contact-home-section" aria-labelledby="contact-home-title">
    <div class="container contact-home-grid">
      <div><span class="section-badge">Contact ILMA</span><h2 id="contact-home-title">Let’s make your next step clearer.</h2><p>Tell us what you are considering. We can help you start with a destination, a course question or an eligibility check.</p><div class="contact-home-actions"><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Contact us <span aria-hidden="true">→</span></a><?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="contact-whatsapp-link" target="_blank" rel="noopener"><span class="whatsapp-dot" aria-hidden="true">◔</span> Message us on WhatsApp</a><?php endif; ?></div></div>
      <div class="contact-home-details"><div><span class="contact-detail-label">Visit</span><p><?php echo esc_html($address); ?></p></div><div><span class="contact-detail-label">Call</span><p><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></p></div><div><span class="contact-detail-label">Email</span><p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p></div></div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
