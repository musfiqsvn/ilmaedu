<?php
/**
 * Reusable single destination landing page.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$catalog = uturnedu_get_destination_data(get_post_field('post_name', get_the_ID()));
if (!$catalog) {
    $catalog = uturnedu_get_destination_data(get_post_meta(get_the_ID(), '_dest_code', true));
}
$catalog = $catalog ?: uturnedu_destination_catalog()[0];

$title        = $catalog['title'] ?? get_the_title();
$code         = get_post_meta(get_the_ID(), '_dest_code', true) ?: $catalog['code'];
$tuition      = get_post_meta(get_the_ID(), '_dest_tuition', true) ?: $catalog['tuition'];
$living       = get_post_meta(get_the_ID(), '_dest_living_cost', true) ?: $catalog['living'];
$intakes      = get_post_meta(get_the_ID(), '_dest_intakes', true) ?: $catalog['intakes'];
$work_rights  = get_post_meta(get_the_ID(), '_dest_work_rights', true) ?: $catalog['work_rights'];
$psw          = get_post_meta(get_the_ID(), '_dest_psw', true) ?: $catalog['psw'];
$ielts        = get_post_meta(get_the_ID(), '_dest_ielts', true) ?: $catalog['ielts'];
$universities = get_post_meta(get_the_ID(), '_dest_universities', true);
$universities = $universities ? array_filter(array_map('trim', explode(',', $universities))) : $catalog['universities'];
$whatsapp     = uturnedu_whatsapp_url('Hello ILMA Education, I would like to discuss studying in ' . $title . '.');
?>

<main>
  <section class="hero-section destination-detail-hero" aria-labelledby="destination-title">
    <div class="container">
      <div class="breadcrumb-light"><a href="<?php echo esc_url(home_url('/destinations/')); ?>">Study Destinations</a><span aria-hidden="true">/</span><span><?php echo esc_html($title); ?></span></div>
      <div class="destination-detail-grid">
        <div>
          <span class="hero-tag"><img src="<?php echo esc_url(uturnedu_get_destination_flag($code)); ?>" alt="" width="20" height="14" aria-hidden="true"> Official destination guide</span>
          <h1 id="destination-title" class="hero-title">Study in <?php echo esc_html($title); ?></h1>
          <p class="hero-desc"><?php echo esc_html($catalog['summary']); ?> We help you turn interest into a realistic application plan.</p>
          <div class="hero-ctas"><button type="button" class="btn btn-accent btn-lg open-consultancy-modal" data-country="<?php echo esc_attr($title); ?>">Check your eligibility <span aria-hidden="true">↗</span></button><a href="#universities" class="btn btn-outline-white btn-lg">View universities</a></div>
        </div>
        <div class="destination-detail-image"><img src="<?php echo esc_url(uturnedu_get_destination_image($code)); ?>" alt="Study in <?php echo esc_attr($title); ?>" width="800" height="500" fetchpriority="high"></div>
      </div>
    </div>
  </section>

  <section class="destination-facts" aria-label="<?php echo esc_attr($title); ?> study facts">
    <div class="container destination-facts-grid">
      <div><span>Tuition guide</span><strong><?php echo esc_html($tuition); ?></strong></div>
      <div><span>Living costs</span><strong><?php echo esc_html($living); ?></strong></div>
      <div><span>Typical intakes</span><strong><?php echo esc_html($intakes); ?></strong></div>
      <div><span>English benchmark</span><strong><?php echo esc_html($ielts); ?></strong></div>
    </div>
  </section>

  <section class="section destination-guide-section" aria-labelledby="why-this-country">
    <div class="container destination-guide-grid">
      <div>
        <span class="section-badge">01 · Understand the destination</span>
        <h2 id="why-this-country">Why consider <?php echo esc_html($title); ?>?</h2>
        <div class="destination-copy"><?php the_content(); ?></div>
        <ul class="destination-benefits">
          <?php foreach ($catalog['why'] as $reason): ?><li><span aria-hidden="true">✓</span><?php echo esc_html($reason); ?></li><?php endforeach; ?>
        </ul>
      </div>
      <aside class="destination-side-note"><span class="side-note-kicker">A useful comparison</span><h3>Fit matters more than a familiar name.</h3><p>We help you compare course content, entry requirements, location and budget before you make a decision.</p><a href="#eligibility" class="text-link-button">Check your profile <span aria-hidden="true">→</span></a></aside>
    </div>
  </section>

  <section id="universities" class="section section-bg-alt destination-universities-section" aria-labelledby="universities-title">
    <div class="container">
      <div class="section-title-wrap align-left"><span class="section-badge section-badge-accent">02 · Explore institutions</span><h2 id="universities-title">Universities to explore in <?php echo esc_html($title); ?></h2><p class="section-subtitle">These examples help you begin a conversation. Final recommendations depend on your academic profile, chosen course and current entry requirements.</p></div>
      <div class="universities-list">
        <?php foreach ($universities as $index => $university): ?><div class="university-item"><span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span><strong><?php echo esc_html($university); ?></strong></div><?php endforeach; ?>
      </div>
      <div class="destination-inline-cta"><p>Want help narrowing the list?</p><button type="button" class="btn btn-primary open-consultancy-modal" data-country="<?php echo esc_attr($title); ?>">Talk through your options <span aria-hidden="true">→</span></button></div>
    </div>
  </section>

  <section id="eligibility" class="section destination-eligibility-section" aria-labelledby="eligibility-title">
    <div class="container destination-eligibility-grid">
      <div><span class="section-badge section-badge-accent">03 · Check your fit</span><h2 id="eligibility-title">Could <?php echo esc_html($title); ?> be right for you?</h2><p>Share your details for a first conversation about study level, course interests, English profile and application timing.</p><div class="eligibility-mini-list"><span>Academic background</span><span>Course and intake</span><span>Budget and documents</span></div></div>
      <div class="destination-form-card">
        <h3>Start an eligibility check</h3><p>It only takes a few details to begin.</p>
        <form class="ajax-lead-form"><input type="hidden" name="source" value="Destination Eligibility: <?php echo esc_attr($title); ?>"><input type="hidden" name="target_country" value="<?php echo esc_attr($title); ?>">
          <div class="form-group"><label class="form-label" for="destination-name">Full name <span class="req">*</span></label><input id="destination-name" type="text" name="name" class="form-control" autocomplete="name" required></div>
          <div class="form-group"><label class="form-label" for="destination-phone">Phone number <span class="req">*</span></label><input id="destination-phone" type="tel" name="phone" class="form-control" autocomplete="tel" required></div>
          <div class="form-group"><label class="form-label" for="destination-email">Email address</label><input id="destination-email" type="email" name="email" class="form-control" autocomplete="email"></div>
          <button type="submit" class="btn btn-accent btn-block">Check my eligibility <span aria-hidden="true">↗</span></button>
        </form>
      </div>
    </div>
  </section>

  <section id="apply" class="section destination-apply-section" aria-labelledby="apply-title"><div class="container"><div class="destination-apply-panel"><div><span class="section-badge section-badge-dark">04 · Apply now</span><h2 id="apply-title">Ready to discuss <?php echo esc_html($title); ?>?</h2><p>When you are ready, ILMA can help you turn your shortlist into a clear application conversation.</p></div><div class="destination-apply-actions"><button type="button" class="btn btn-accent btn-lg open-consultancy-modal" data-country="<?php echo esc_attr($title); ?>">Apply now <span aria-hidden="true">↗</span></button><?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="btn btn-whatsapp btn-lg" target="_blank" rel="noopener">Chat with Us <span aria-hidden="true">↗</span></a><?php endif; ?></div></div></div></section>
</main>

<?php get_footer(); ?>
