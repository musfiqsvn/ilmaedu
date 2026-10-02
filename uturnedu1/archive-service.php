<?php
/**
 * Archive Template for Services - Exact 1:1 Match
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container text-center">
    <span class="section-badge">Comprehensive Support</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 1rem;">Our Educational Consultancy Services</h1>
    <p style="max-width: 720px; margin: 0 auto; font-size: 1.1rem;">
      ILMA Education Consultancy provides 100% free guidance from initial career counseling to flight orientation. Discover how our certified mentors support your journey.
    </p>
  </div>
</section>

<!-- Services Grid -->
<section class="section">
  <div class="container">
    <div class="grid grid-3 gap-8">
      <?php
      if (have_posts()):
          while (have_posts()): the_post();
              $process = get_post_meta(get_the_ID(), '_service_process', true);
              $steps = $process ? explode("\n", $process) : [];
      ?>
          <div class="service-card">
            <div class="service-icon-box">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
            </div>

            <h3 class="service-title"><?php the_title(); ?></h3>
            <p class="service-desc"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></p>

            <?php if (!empty($steps)): ?>
              <ul class="service-bullets">
                <?php foreach (array_slice($steps, 0, 3) as $st): ?>
                  <?php if (trim($st)): ?>
                    <li>
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                      <span><?php echo esc_html(trim($st)); ?></span>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <div style="margin-top: auto;">
              <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block btn-sm">
                <span>View Full Details →</span>
              </a>
            </div>
          </div>
      <?php
          endwhile;
      endif;
      ?>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="section section-bg-alt">
  <div class="container text-center">
    <div class="section-title-wrap">
      <span class="section-badge section-badge-accent">100% Free Service</span>
      <h2 class="section-title">Need Guidance with Your University Application?</h2>
      <p class="section-subtitle">
        Talk with our certified education counselors for an immediate profile audit.
      </p>
      <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
        <button type="button" class="btn btn-accent btn-lg open-consultancy-modal">
          Get Free Consultancy
        </button>
        <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-primary btn-lg">
          Reserve In-Person Slot
        </a>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
