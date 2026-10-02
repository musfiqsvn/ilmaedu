<?php
/**
 * Single Service Template - Exact 1:1 Match
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$process = get_post_meta(get_the_ID(), '_service_process', true);
$steps   = $process ? explode("\n", $process) : [];
?>

<section class="hero-section" style="padding: 4rem 0 4.5rem 0;">
  <div class="container">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
      <a href="<?php echo esc_url(home_url('/services/')); ?>" style="color: #FEF08A; font-size: 0.85rem; font-weight: 600;">← All Services</a>
      <span style="color: rgba(255, 255, 255, 0.4);">/</span>
      <span style="color: #fff; font-size: 0.85rem;"><?php the_title(); ?></span>
    </div>

    <div class="grid grid-2 gap-8 items-center">
      <div>
        <span class="section-badge section-badge-accent" style="margin-bottom: 1rem;">
          Free initial guidance
        </span>

        <h1 class="hero-title" style="font-size: clamp(2.2rem, 3.8vw, 3.2rem);">
          <?php the_title(); ?>
        </h1>

        <p class="hero-desc" style="margin-bottom: 1.75rem;">
          Personalized, step-by-step guidance provided by certified study abroad counselors at our Mohammadpur, Dhaka office.
        </p>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
          <button type="button" class="btn btn-accent btn-lg open-consultancy-modal">
            <span>Request This Free Service</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </button>
          <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-outline-white btn-lg">
            <span>Book In-Person Session</span>
          </a>
        </div>
      </div>

      <div>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/counseling-session.jpg'); ?>" alt="<?php the_title_attribute(); ?>" style="border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); width: 100%; border: 2px solid rgba(255,255,255,0.15);">
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 3.5rem;">
      <div>
        <div class="dest-rich-content">
          <?php the_content(); ?>
        </div>

        <?php if (!empty($steps)): ?>
          <div style="margin-top: 3rem;">
            <h3 style="font-size: 1.5rem; margin-bottom: 1.25rem;">Key Steps in This Service</h3>
            <div class="grid gap-4">
              <?php foreach ($steps as $idx => $st): ?>
                <?php if (trim($st)): ?>
                  <div style="background: var(--surface-50); border: 1px solid var(--surface-200); border-radius: var(--radius-md); padding: 1.25rem; display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0;">
                      <?php echo esc_html($idx + 1); ?>
                    </div>
                    <div style="font-weight: 600; color: var(--text-main); font-size: 1rem; margin-top: 0.25rem;">
                      <?php echo esc_html(trim($st)); ?>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sticky Sidebar -->
      <div>
        <div style="position: sticky; top: 100px; background: var(--surface-0); border: 1px solid var(--surface-200); border-radius: var(--radius-lg); padding: 2rem; box-shadow: var(--shadow-md);">
          <span class="section-badge section-badge-accent" style="margin-bottom: 0.75rem;">Free initial guidance</span>
          <h3 style="font-size: 1.35rem; margin-bottom: 0.5rem;">Get Help with <?php the_title(); ?></h3>
          <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">
            Fill in your details and our senior counselor will reach out to you within 24 hours.
          </p>

          <form class="ajax-lead-form">
            <input type="hidden" name="source" value="Service Page: <?php the_title_attribute(); ?>">

            <div class="form-group">
              <label class="form-label">Full Name <span class="req">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="e.g. Shakil Chowdhury" required>
            </div>

            <div class="form-group">
              <label class="form-label">Mobile Number <span class="req">*</span></label>
              <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
            </div>

            <div class="form-group">
              <label class="form-label">Email Address <span class="req">*</span></label>
              <input type="email" name="email" class="form-control" placeholder="student@gmail.com" required>
            </div>

            <div class="form-group">
              <label class="form-label">Preferred Study Country</label>
              <select name="target_country" class="form-control">
                <option value="United Kingdom">United Kingdom</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Canada">Canada</option>
                <option value="Malaysia">Malaysia</option>
                <option value="South Korea">South Korea</option>
                <option value="Japan">Japan</option>
              </select>
            </div>

            <button type="submit" class="btn btn-accent btn-block" style="font-weight: 700; padding: 0.85rem;">
              Request Free Assistance ➔
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
