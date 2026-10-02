<?php
/**
 * Destination archive landing page.
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
$destinations = uturnedu_destination_catalog();
?>

<main>
  <section class="archive-intro-section section-bg-alt" aria-labelledby="destinations-archive-title"><div class="container"><span class="section-badge section-badge-accent">Study destinations</span><h1 id="destinations-archive-title">Find the place that fits your next chapter.</h1><p>Explore six destinations with clear information about why students consider them, universities to explore and the next step toward eligibility.</p></div></section>
  <section class="section" aria-label="Study destination guides"><div class="container"><div class="destination-grid archive-destination-grid">
    <?php foreach ($destinations as $destination):
        $destination_post = uturnedu_get_destination_post($destination['slug']);
        if (!$destination_post) { continue; }
        $url = get_permalink($destination_post->ID);
    ?>
      <article class="destination-card destination-card-premium">
        <a class="dest-img-wrap" href="<?php echo esc_url($url); ?>"><img src="<?php echo esc_url(uturnedu_get_destination_image($destination['code'])); ?>" alt="Study in <?php echo esc_attr($destination['title']); ?>" loading="lazy" width="800" height="500"><span class="dest-country-pill"><img src="<?php echo esc_url(uturnedu_get_destination_flag($destination['code'])); ?>" alt="" width="20" height="14" aria-hidden="true"> <?php echo esc_html($destination['title']); ?></span><span class="dest-image-arrow" aria-hidden="true">↗</span></a>
        <div class="dest-content"><h2 class="dest-title"><a href="<?php echo esc_url($url); ?>">Study in <?php echo esc_html($destination['title']); ?></a></h2><p class="dest-desc"><?php echo esc_html($destination['summary']); ?></p><div class="destination-journey"><a href="<?php echo esc_url($url . '#why-this-country'); ?>" class="journey-link">Why this country <span aria-hidden="true">→</span></a><a href="<?php echo esc_url($url . '#universities'); ?>" class="journey-link">Universities <span aria-hidden="true">→</span></a><button type="button" class="journey-link journey-link-strong open-consultancy-modal" data-country="<?php echo esc_attr($destination['title']); ?>">Check eligibility <span aria-hidden="true">↗</span></button><button type="button" class="journey-link journey-link-primary open-consultancy-modal" data-country="<?php echo esc_attr($destination['title']); ?>">Apply now <span aria-hidden="true">↗</span></button></div></div>
      </article>
    <?php endforeach; ?>
  </div></div></section>
  <section class="section section-bg-alt"><div class="container archive-destination-cta"><span class="section-badge">Need a second opinion?</span><h2>Start with your profile, not a guess.</h2><p>Our advisors can help you compare the destinations in a way that reflects your course, documents and budget.</p><button type="button" class="btn btn-accent btn-lg open-consultancy-modal">Check your eligibility <span aria-hidden="true">↗</span></button></div></section>
</main>

<?php get_footer(); ?>
