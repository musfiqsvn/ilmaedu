<?php
/**
 * Single Blog Template - Exact 1:1 Match
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Article Header -->
<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container" style="max-width: 860px;">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
      <a href="<?php echo esc_url(home_url('/blogs/')); ?>" style="color: var(--primary); font-size: 0.85rem; font-weight: 700;">← All Articles</a>
      <span style="color: var(--text-sub);">/</span>
      <span class="section-badge section-badge-accent" style="margin-bottom: 0;">Study Guide</span>
    </div>

    <h1 style="font-size: clamp(2rem, 3.5vw, 2.85rem); line-height: 1.25; margin-bottom: 1.25rem;">
      <?php the_title(); ?>
    </h1>

    <div style="display: flex; align-items: center; gap: 1.5rem; color: var(--text-muted); font-size: 0.9rem; flex-wrap: wrap;">
      <div>👤 Published by ILMA Education Consultancy Counselors</div>
      <div>•</div>
      <div>📅 <?php echo esc_html(get_the_date('F j, Y')); ?></div>
    </div>
  </div>
</section>

<!-- Main Article Body -->
<section class="section">
  <div class="container" style="max-width: 860px;">
    <div class="blog-rich-content">
      <?php the_content(); ?>
    </div>

    <!-- Article Author & Mohammadpur Box -->
    <div style="background: var(--surface-50); border: 1px solid var(--surface-200); border-radius: var(--radius-lg); padding: 2rem; margin-top: 3.5rem;">
      <div style="display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ILMA-Education-logo-rgb.png'); ?>" alt="ILMA Education Consultancy" style="width: 70px; height: 65px; object-fit: contain;">
        <div style="flex: 1; min-width: 240px;">
          <h3 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Guidance by ILMA Education Consultancy</h3>
          <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
            Serving Bangladeshi students with 100% free international admission and visa counseling since 2013 at CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh
          </p>
        </div>
        <div>
          <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-accent btn-sm">
            Book In-Person Session
          </a>
        </div>
      </div>
    </div>

    <div style="margin-top: 3rem; text-align: center;">
      <a href="<?php echo esc_url(home_url('/blogs/')); ?>" class="btn btn-outline">
        ← Back to All Articles
      </a>
    </div>
  </div>
</section>

<?php
get_footer();
