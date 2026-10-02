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
$home_content = uturnedu_get_homepage_content();
$service_posts = get_posts(['post_type' => 'service', 'posts_per_page' => 8, 'post_status' => 'publish', 'orderby' => 'menu_order ID', 'order' => 'ASC']);
if ($service_posts) {
    $services = [];
    foreach ($service_posts as $service_post) {
        $description = get_the_excerpt($service_post->ID) ?: wp_trim_words(wp_strip_all_tags($service_post->post_content), 22);
        $process_lines = preg_split('/\r?\n/', (string) get_post_meta($service_post->ID, '_service_process', true), -1, PREG_SPLIT_NO_EMPTY);
        $services[] = [
            'title' => get_the_title($service_post->ID),
            'description' => $description ?: 'Practical guidance shaped around your study plans and next steps.',
            'bullets' => array_slice($process_lines ?: ['Clear next steps', 'Advisor support'], 0, 2),
        ];
    }
}
?>

<main>
  <!-- Full-width six-country banner carousel. Each slide keeps the primary CTA above the fold. -->
  <section class="hero-section home-hero-section country-hero-carousel" data-hero-carousel aria-label="Study destination banners">
    <div class="country-hero-track" data-hero-track>
      <?php foreach ($destinations as $index => $destination):
          $destination_post = uturnedu_get_destination_post($destination['slug']);
          $destination_url = $destination_post ? get_permalink($destination_post->ID) : home_url('/destinations/' . $destination['slug'] . '/');
          $heading_tag = $index === 0 ? 'h1' : 'h2';
          $destination_label = $destination_post ? get_the_title($destination_post->ID) : $destination['title'];
      ?>
        <article class="country-hero-slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide-index="<?php echo esc_attr($index); ?>" aria-hidden="<?php echo $index === 0 ? 'false' : 'true'; ?>">
          <img class="country-hero-image" src="<?php echo esc_url(uturnedu_get_destination_image($destination['code'])); ?>" alt="Study in <?php echo esc_attr($destination_label); ?>" width="1600" height="720" <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
          <div class="country-hero-overlay" aria-hidden="true"></div>
          <div class="container country-hero-container">
            <div class="country-hero-content">
              <div class="country-hero-kicker"><span><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span><i aria-hidden="true"></i> <?php echo esc_html($home_content['hero_kicker']); ?></div>
              <<?php echo $heading_tag; ?> class="country-hero-title"<?php echo $index === 0 ? ' id="home-hero-title"' : ''; ?>>Study in <?php echo esc_html($destination_label); ?></<?php echo $heading_tag; ?>>
              <?php $hero_summary = $destination_post ? get_the_excerpt($destination_post->ID) : $destination['summary']; ?>
              <p class="country-hero-copy"><?php echo esc_html($hero_summary ?: $destination['summary']); ?> Find a course and application route that fits your goals.</p>
              <div class="country-hero-actions">
                <button type="button" class="btn btn-accent btn-lg open-consultancy-modal" data-country="<?php echo esc_attr($destination_label); ?>" data-modal-title="Check your <?php echo esc_attr($destination_label); ?> eligibility"><?php echo esc_html($home_content['hero_cta']); ?> <span aria-hidden="true">↗</span></button>
                <a href="<?php echo esc_url($destination_url); ?>" class="btn btn-outline-white btn-lg"><?php echo esc_html($home_content['hero_secondary_cta']); ?> <span aria-hidden="true">→</span></a>
              </div>
              <div class="country-hero-trust"><span>Why this country</span><span>Universities</span><span>Apply with guidance</span></div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <button type="button" class="country-hero-control country-hero-prev" data-hero-prev aria-label="Previous study destination">‹</button>
    <button type="button" class="country-hero-control country-hero-next" data-hero-next aria-label="Next study destination">›</button>
    <div class="container country-hero-navigation">
      <div class="country-hero-dots" role="tablist" aria-label="Choose a study destination banner">
        <?php foreach ($destinations as $index => $destination): ?>
          <button type="button" class="country-hero-dot <?php echo $index === 0 ? 'is-active' : ''; ?>" data-hero-dot="<?php echo esc_attr($index); ?>" role="tab" aria-label="Show <?php echo esc_attr($destination['title']); ?> banner" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"><span><?php echo esc_html($destination['title']); ?></span></button>
        <?php endforeach; ?>
      </div>
      <span class="country-hero-autoplay">Changes every 5 seconds</span>
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
          <span class="section-badge section-badge-accent"><?php echo esc_html($home_content['destination_kicker']); ?></span>
          <h2 id="destinations-title" class="section-title"><?php echo esc_html($home_content['destination_title']); ?></h2>
        </div>
        <p class="section-subtitle"><?php echo esc_html($home_content['destination_intro']); ?></p>
      </div>

      <div class="destination-grid">
        <?php foreach ($destinations as $destination):
            $destination_post = uturnedu_get_destination_post($destination['slug']);
            $destination_url = $destination_post ? get_permalink($destination_post->ID) : home_url('/destinations/' . $destination['slug'] . '/');
            $destination_label = $destination_post ? get_the_title($destination_post->ID) : $destination['title'];
            $summary = $destination_post ? get_the_excerpt($destination_post->ID) : $destination['summary'];
            if (!$summary) {
                $summary = $destination['summary'];
            }
        ?>
          <article class="destination-card destination-card-premium">
            <a class="dest-img-wrap" href="<?php echo esc_url($destination_url); ?>" aria-label="Read the <?php echo esc_attr($destination_label); ?> study guide">
              <img src="<?php echo esc_url(uturnedu_get_destination_image($destination['code'])); ?>" alt="Study in <?php echo esc_attr($destination_label); ?>" loading="lazy" width="800" height="500">
              <span class="dest-country-pill"><img src="<?php echo esc_url(uturnedu_get_destination_flag($destination['code'])); ?>" alt="" width="20" height="14" aria-hidden="true"> <?php echo esc_html($destination_label); ?></span>
              <span class="dest-image-arrow" aria-hidden="true">↗</span>
            </a>
            <div class="dest-content">
              <h3 class="dest-title"><a href="<?php echo esc_url($destination_url); ?>">Study in <?php echo esc_html($destination_label); ?></a></h3>
              <p class="dest-desc"><?php echo esc_html(wp_trim_words(wp_strip_all_tags($summary), 18)); ?></p>
              <div class="dest-meta-chips">
                <span class="meta-chip"><span aria-hidden="true">◷</span> <?php echo esc_html(explode(',', $destination['intakes'])[0]); ?></span>
                <span class="meta-chip"><span aria-hidden="true">⌁</span> <?php echo esc_html($destination['tuition']); ?></span>
              </div>

              <div class="destination-journey" aria-label="Actions for <?php echo esc_attr($destination_label); ?>">
                <a href="<?php echo esc_url($destination_url . '#why-this-country'); ?>" class="journey-link"><span>Why this country</span><span aria-hidden="true">→</span></a>
                <a href="<?php echo esc_url($destination_url . '#universities'); ?>" class="journey-link"><span>Universities</span><span aria-hidden="true">→</span></a>
                <button type="button" class="journey-link journey-link-strong" data-country="<?php echo esc_attr($destination_label); ?>" data-modal-title="Check your <?php echo esc_attr($destination_label); ?> eligibility"><span>Check eligibility</span><span aria-hidden="true">↗</span></button>
                <button type="button" class="journey-link journey-link-primary" data-country="<?php echo esc_attr($destination_label); ?>" data-modal-title="Apply to <?php echo esc_attr($destination_label); ?>"><span>Apply now</span><span aria-hidden="true">↗</span></button>
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
          <span class="section-badge"><?php echo esc_html($home_content['why_kicker']); ?></span>
          <h2 id="why-ilma-title"><?php echo esc_html($home_content['why_title']); ?></h2>
        </div>
        <p><?php echo esc_html($home_content['why_intro']); ?></p>
      </div>

      <div class="why-ilma-grid">
        <?php for ($card = 1; $card <= 4; $card++): ?><article class="why-ilma-card"><span class="why-card-number"><?php echo esc_html(str_pad((string) $card, 2, '0', STR_PAD_LEFT)); ?></span><h3><?php echo esc_html($home_content['why_card_'.$card.'_title']); ?></h3><p><?php echo esc_html($home_content['why_card_'.$card.'_text']); ?></p></article><?php endfor; ?>
      </div>
    </div>
  </section>

  <?php if ($home_content['video_enabled'] === 'yes' && $home_content['video_url']): ?>
    <section class="section homepage-video-section section-bg-alt" aria-labelledby="homepage-video-title">
      <div class="container homepage-video-grid">
        <div><span class="section-badge section-badge-accent">Watch and learn</span><h2 id="homepage-video-title"><?php echo esc_html($home_content['video_title']); ?></h2><p><?php echo esc_html($home_content['video_text']); ?></p></div>
        <div><?php echo wp_kses_post(uturnedu_render_video_embed($home_content['video_url'], $home_content['video_poster'])); ?></div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Services reference-inspired information architecture, with original ILMA copy. -->
  <section id="services" class="section section-bg-alt services-section" aria-labelledby="services-title">
    <div class="container">
      <div class="section-title-wrap">
        <span class="section-badge section-badge-accent"><?php echo esc_html($home_content['services_kicker']); ?></span>
        <h2 id="services-title" class="section-title"><?php echo esc_html($home_content['services_title']); ?></h2>
        <p class="section-subtitle"><?php echo esc_html($home_content['services_intro']); ?></p>
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
        <div><span class="section-badge"><?php echo esc_html($home_content['process_kicker']); ?></span><h2 id="process-title"><?php echo esc_html($home_content['process_title']); ?></h2></div>
        <p><?php echo esc_html($home_content['process_intro']); ?></p>
      </div>
      <ol class="process-grid">
        <?php for ($step = 1; $step <= 4; $step++): ?><li class="process-step"><span class="process-step-number"><?php echo esc_html(str_pad((string) $step, 2, '0', STR_PAD_LEFT)); ?></span><h3><?php echo esc_html($home_content['process_'.$step.'_title']); ?></h3><p><?php echo esc_html($home_content['process_'.$step.'_text']); ?></p></li><?php endfor; ?>
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
        <div class="eligibility-copy"><span class="section-badge section-badge-dark"><?php echo esc_html($home_content['eligibility_kicker']); ?></span><h2 id="eligibility-title"><?php echo esc_html($home_content['eligibility_title']); ?></h2><p><?php echo esc_html($home_content['eligibility_text']); ?></p></div>
        <div class="eligibility-actions"><button type="button" class="btn btn-accent btn-lg open-consultancy-modal"><?php echo esc_html($home_content['eligibility_cta']); ?> <span aria-hidden="true">↗</span></button><?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="btn btn-whatsapp btn-lg" target="_blank" rel="noopener">Chat with Us <span aria-hidden="true">↗</span></a><?php endif; ?></div>
      </div>
    </div>
  </section>

  <section id="contact" class="section contact-home-section" aria-labelledby="contact-home-title">
    <div class="container contact-home-grid">
      <div><span class="section-badge"><?php echo esc_html($home_content['contact_kicker']); ?></span><h2 id="contact-home-title"><?php echo esc_html($home_content['contact_title']); ?></h2><p><?php echo esc_html($home_content['contact_text']); ?></p><div class="contact-home-actions"><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Contact us <span aria-hidden="true">→</span></a><?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="contact-whatsapp-link" target="_blank" rel="noopener"><span class="whatsapp-dot" aria-hidden="true">◔</span> Chat with Us</a><?php endif; ?></div></div>
      <div class="contact-home-details"><div><span class="contact-detail-label">Visit</span><p><?php echo esc_html($address); ?></p></div><div><span class="contact-detail-label">Call</span><p><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></p></div><div><span class="contact-detail-label">Email</span><p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p></div></div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
