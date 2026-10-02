<?php
/**
 * Blogs Archive Template - Exact 1:1 Match
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
    <span class="section-badge">Knowledge Hub</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 1rem;">Study Abroad Articles &amp; Guides</h1>
    <p style="max-width: 720px; margin: 0 auto; font-size: 1.1rem;">
      Authentic insights, visa application guides, tuition analysis, and preparation strategies crafted by ILMA Education Consultancy experts.
    </p>
  </div>
</section>

<!-- Blog Grid -->
<section class="section">
  <div class="container">
    <div class="grid grid-3 gap-8">
      <?php
      if (have_posts()):
          while (have_posts()): the_post();
      ?>
          <div class="blog-card">
            <div class="blog-img-wrap">
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/uk2.jpeg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
              <span class="blog-cat-badge">Study Guide</span>
            </div>

            <div class="blog-content">
              <div class="blog-meta-row">
                <span>5 Min Read</span>
                <span>•</span>
                <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
              </div>

              <h3 class="blog-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>

              <p class="blog-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
              </p>

              <div style="margin-top: auto;">
                <a href="<?php the_permalink(); ?>" style="color: var(--primary); font-weight: 700; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                  <span>Read Article</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
              </div>
            </div>
          </div>
      <?php
          endwhile;
      else:
      ?>
          <p>No articles found.</p>
      <?php endif; ?>
    </div>

    <div style="margin-top: 3rem; text-align: center;">
      <?php the_posts_pagination(['prev_text' => '← Previous', 'next_text' => 'Next →']); ?>
    </div>
  </div>
</section>

<?php
get_footer();
