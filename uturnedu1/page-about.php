<?php
/**
 * Template Name: About Us Page
 *
 * 100% exact match with original design
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$settings = get_option('uturnedu_settings', []);
?>

<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container text-center">
    <span class="section-badge">About Us Education Consultancy</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 1rem;">Expand Your Journey to Global Insight</h1>
    <p style="max-width: 700px; margin: 0 auto; font-size: 1.1rem;">
      Helping ambitious Bangladeshi students explore university opportunities across the United Kingdom, New Zealand, Canada, Malaysia, South Korea, and Japan.
    </p>
  </div>
</section>

<!-- Company Overview & Story -->
<section class="section">
  <div class="container">
    <div class="grid grid-2 gap-10 items-center">
      <div>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/counseling-session.jpg'); ?>" alt="ILMA Education Counselors" style="border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); width: 100%;">
      </div>

      <div>
        <span class="section-badge section-badge-accent">Our Journey Since 2013</span>
        <h2 style="margin-bottom: 1.25rem;">Authentic, Dependable &amp; Resourceful Guidance</h2>

        <p style="font-size: 1.05rem; line-height: 1.7; color: var(--text-main); font-weight: 500; margin-bottom: 1.25rem;">
          ILMA Education Consultancy helps students explore higher education abroad through practical, student-focused guidance. Our destination support currently covers the United Kingdom, New Zealand, Canada, Malaysia, South Korea, and Japan.
        </p>

        <p style="margin-bottom: 1.25rem;">
          The experienced team at ILMA Education Consultancy provides authentic, dependable, and resourceful guidance to students aspiring to study abroad. The well-trained counselors of ILMA Education Consultancy are dedicated to supporting students with comprehensive services whenever needed. Additionally, they receive ongoing training from industry experts to ensure their knowledge remains current and relevant.
        </p>

        <p style="margin-bottom: 1.5rem;">
          To inspiring intellectual adventure, ILMA Education Consultancy is also committed to providing top-quality marketing services to our partner education recruitment organizations. Our primary goal is to serve as a bridge between students and overseas educational institutions, ensuring that each student finds the best academic destination to match their goals and aspirations.
        </p>

        <div class="grid grid-2 gap-4">
          <div style="background: var(--surface-50); border: 1px solid var(--surface-200); padding: 1.25rem; border-radius: var(--radius-md);">
            <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary);">100+</div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Global Universities</div>
          </div>
          <div style="background: var(--surface-50); border: 1px solid var(--surface-200); padding: 1.25rem; border-radius: var(--radius-md);">
            <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent-red);">100% Free</div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Service Free Counseling</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="section section-bg-alt">
  <div class="container">
    <div class="grid grid-3 gap-8">
      <div class="card">
        <div class="service-icon-box" style="background: var(--primary-light); color: var(--primary);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem;">Our Mission</h3>
        <p style="font-size: 0.925rem;">
          Our mission is to place students into leading universities that are the right fit for them. We empower students with accurate, transparent, and timely information to build global careers.
        </p>
      </div>

      <div class="card">
        <div class="service-icon-box" style="background: var(--accent-red-light); color: var(--accent-red);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem;">Our Vision</h3>
        <p style="font-size: 0.925rem;">
          To become Bangladesh’s most trusted international education consultancy, recognized for ethical student recruitment, zero false promises, and exceptional visa success rates.
        </p>
      </div>

      <div class="card">
        <div class="service-icon-box" style="background: var(--accent-emerald-light); color: var(--accent-emerald);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.75rem;">Our Core Values</h3>
        <p style="font-size: 0.925rem;">
          Integrity, 100% transparency in admission costs, student-first advocacy, continuous counselor professional development, and long-term mentorship.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Counselor Team & Office -->
<section class="section">
  <div class="container">
    <div class="section-title-wrap">
      <span class="section-badge">Expert Leadership</span>
      <h2 class="section-title">Dedicated Counselors at Your Service</h2>
      <p class="section-subtitle">
        Our certified counseling team brings over a decade of hands-on expertise in international admissions and immigration guidelines.
      </p>
    </div>

    <div class="grid grid-3 gap-8">
      <div class="card text-center">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/WhatsApp-Image-2025-09-21-at-12.00.19-PM-819x1024.jpeg'); ?>" alt="ILMA Counselor" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; margin: 0 auto 1.25rem auto; border: 4px solid var(--primary-light);">
        <h3 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Senior Admission Director</h3>
        <div style="font-size: 0.85rem; color: var(--primary); font-weight: 700; margin-bottom: 0.75rem;">UK &amp; Canada Specialist</div>
        <p style="font-size: 0.875rem; color: var(--text-muted);">
          10+ years specializing in Russell Group university admissions, CAS processing, and Canadian DLI acceptance letters.
        </p>
      </div>

      <div class="card text-center">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/counseling-session.jpg'); ?>" alt="ILMA Counselor" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; margin: 0 auto 1.25rem auto; border: 4px solid var(--primary-light);">
        <h3 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Visa &amp; Interview Strategist</h3>
        <div style="font-size: 0.85rem; color: var(--accent-red); font-weight: 700; margin-bottom: 0.75rem;">South Korea &amp; Japan guidance</div>
        <p style="font-size: 0.875rem; color: var(--text-muted);">
          Practical support for comparing English-taught routes, documentation and application timelines across Asia-Pacific destinations.
        </p>
      </div>

      <div class="card text-center">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-students-2026.jpg'); ?>" alt="ILMA Counselor" style="width: 140px; height: 140px; border-radius: 50%; object-fit: cover; margin: 0 auto 1.25rem auto; border: 4px solid var(--primary-light);">
        <h3 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Scholarship &amp; Asian Hub Lead</h3>
        <div style="font-size: 0.85rem; color: var(--accent-emerald); font-weight: 700; margin-bottom: 0.75rem;">Malaysia &amp; New Zealand</div>
        <p style="font-size: 0.875rem; color: var(--text-muted);">
          Specialist in EMGS eVAL processing, UK twinning transfer programs, and New Zealand institution placements.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Call to action -->
<section class="section section-bg-alt">
  <div class="container text-center">
    <div class="section-title-wrap">
      <span class="section-badge section-badge-accent">Visit Our Office</span>
      <h2 class="section-title">Experience 1-on-1 Guidance at Mohammadpur Office</h2>
      <p class="section-subtitle">
        <?php echo esc_html($settings['address'] ?? 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh'); ?>
      </p>
      <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-primary btn-lg">
          Reserve In-Person Slot
        </a>
        <button type="button" class="btn btn-accent btn-lg open-consultancy-modal">
          Get Free Consultancy
        </button>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
