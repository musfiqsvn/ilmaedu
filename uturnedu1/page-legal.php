<?php
/**
 * Template Name: Legal Document Template - Exact 1:1 Match
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container text-center" style="max-width: 800px;">
    <span class="section-badge">Official Policy</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 0.5rem;"><?php the_title(); ?></h1>
    <p style="font-size: 0.95rem; color: var(--text-muted); margin: 0;">
      Last Updated: <?php echo esc_html(get_the_modified_date('F j, Y')); ?> • ILMA Education Consultancy
    </p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width: 840px;">
    <div class="card" style="padding: 2.5rem; box-shadow: var(--shadow-sm); border: 1px solid var(--surface-200);">
      <div class="dest-rich-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
