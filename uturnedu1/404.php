<?php
/**
 * 404 Not Found Template - Exact 1:1 Match
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="section section-bg-alt" style="padding: 6rem 0; min-height: 60vh; display: flex; align-items: center;">
  <div class="container text-center" style="max-width: 600px;">
    <div style="font-size: 5rem; font-weight: 800; color: var(--primary); line-height: 1; margin-bottom: 1rem;">
      404
    </div>

    <span class="section-badge section-badge-accent">Page Not Found</span>

    <h1 style="font-size: 2rem; margin-top: 0.5rem; margin-bottom: 1rem;">
      Oops! That Page Can't Be Found
    </h1>

    <p style="font-size: 1rem; color: var(--text-muted); margin-bottom: 2rem;">
      The page you are looking for might have been moved, renamed, or is temporarily unavailable.
    </p>

    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
        Return to Homepage ➔
      </a>
      <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-outline btn-lg">
        Reserve Consultation
      </a>
    </div>
  </div>
</section>

<?php
get_footer();
