<?php
/**
 * UTurnEdu1 Footer Template - High-Conversion Components & Dynamic Brand Settings
 *
 * @package UTurnEdu1
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings     = get_option('uturnedu_settings', []);
$phone1       = $settings['phone_primary'] ?? '01329272046';
$phone2       = $settings['phone_secondary'] ?? '01823345573';
$email        = $settings['email_primary'] ?? 'info@ilmaedubd.com';
$email_sec    = $settings['email_support'] ?? 'rawshan@ilmaedubd.com';
$address      = !empty($settings['address']) ? $settings['address'] : 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';
$fb           = $settings['facebook_url'] ?? 'https://www.facebook.com/ilmaeducationbd';
$whatsapp_url = uturnedu_whatsapp_url('Hello ILMA Education Consultancy, I would like to know more about study abroad opportunities.');
$insta        = $settings['instagram_url'] ?? 'https://www.instagram.com/ilmaeducation';
$site_title   = get_bloginfo('name');
$logo_dark    = !empty($settings['site_logo_transparent']) ? $settings['site_logo_transparent'] : get_template_directory_uri() . '/assets/images/ILMA-Education-logo-transparent.png';

// Popup Configuration (Textual, Image Only, Combined Image + Text)
$popup_enabled    = ($settings['popup_enabled'] ?? 'yes') === 'yes';
$popup_type       = $settings['popup_type'] ?? 'image_and_text'; // textual | image_only | image_and_text
$popup_delay      = (int) ($settings['popup_delay'] ?? 5);
$popup_frequency  = $settings['popup_frequency'] ?? 'session';
$popup_heading    = $settings['popup_heading'] ?? 'Start your study abroad journey with clear, practical guidance.';
$popup_subheading = $settings['popup_subheading'] ?? 'Meet certified counselors at our Mohammadpur office or get immediate profile assessment.';
$popup_cta_text   = $settings['popup_cta_text'] ?? 'Claim Free Consultation';
$popup_cta_action = $settings['popup_cta_action'] ?? 'modal';
$popup_cta_url    = $settings['popup_cta_url'] ?? home_url('/reserve-consultation/');
$popup_image_url  = !empty($settings['popup_image_url']) ? $settings['popup_image_url'] : get_template_directory_uri() . '/assets/images/scholarship-celebration.jpg';
?>

  <!-- ==========================================
       DYNAMIC LEAD POPUP SYSTEM (Image / Textual / Hybrid)
       ========================================== -->
  <?php if ($popup_enabled): ?>
    <div id="ilmaPopupOverlay"
         class="ilma-popup-overlay"
         data-delay="<?php echo esc_attr($popup_delay); ?>"
         data-frequency="<?php echo esc_attr($popup_frequency); ?>"
         data-id="popup_v2">

      <div class="ilma-popup-modal <?php echo esc_attr('popup-type-' . $popup_type); ?>">
        <button type="button" class="popup-close-btn" aria-label="Close popup">✕</button>

        <?php if ($popup_type === 'image_only'): ?>
          <!-- Image-Only Popup Layout -->
          <div class="popup-image-only-wrapper">
            <a href="<?php echo $popup_cta_action === 'modal' ? '#consultancy' : esc_url($popup_cta_url); ?>"
               class="<?php echo $popup_cta_action === 'modal' ? 'open-consultancy-modal popup-cta-btn' : ''; ?>"
               data-action="<?php echo esc_attr($popup_cta_action); ?>">
              <img src="<?php echo esc_url($popup_image_url); ?>" alt="<?php echo esc_attr($popup_heading); ?>" style="width: 100%; height: auto; display: block; border-radius: 16px;">
            </a>
          </div>

        <?php elseif ($popup_type === 'textual'): ?>
          <!-- Textual-Only Popup Layout -->
          <div class="popup-text-only-wrapper" style="padding: 2.5rem 2rem; text-align: center;">
            <div style="margin-bottom: 0.75rem;">
              <span class="section-badge section-badge-accent" style="font-size: 0.8rem; padding: 0.3rem 0.8rem;">
                ⚡ Special Study Abroad Offer
              </span>
            </div>

            <h3 style="font-size: 1.5rem; line-height: 1.3; margin-bottom: 0.85rem; color: var(--text-main); font-weight: 800;">
              <?php echo esc_html($popup_heading); ?>
            </h3>

            <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.75rem; max-width: 480px; margin-left: auto; margin-right: auto;">
              <?php echo esc_html($popup_subheading); ?>
            </p>

            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-bottom: 1.5rem;">
              <a href="<?php echo $popup_cta_action === 'modal' ? '#consultancy' : esc_url($popup_cta_url); ?>"
                 class="btn btn-accent popup-cta-btn <?php echo $popup_cta_action === 'modal' ? 'open-consultancy-modal' : ''; ?>"
                 data-action="<?php echo esc_attr($popup_cta_action); ?>"
                 style="font-weight: 700; padding: 0.85rem 2rem;">
                <?php echo esc_html($popup_cta_text); ?>
              </a>
              <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-outline" style="padding: 0.85rem 1.5rem;">
                Reserve Office Slot
              </a>
            </div>

            <p style="font-size: 0.78rem; color: var(--text-sub); margin: 0;">
              ✓ Free initial guidance • ✓ No hidden file-opening fees • ✓ Experienced counselors
            </p>
          </div>

        <?php else: ?>
          <!-- Combined Image + Text Hybrid Popup Layout -->
          <div class="popup-grid">
            <div class="popup-img-side">
              <img src="<?php echo esc_url($popup_image_url); ?>" alt="Scholarship & Free Consultancy Offer" loading="lazy">
            </div>

            <div class="popup-body">
              <div style="margin-bottom: 0.75rem;">
                <span class="section-badge section-badge-accent" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                  ⚡ Office Consultation Exclusive
                </span>
              </div>

              <h3 style="font-size: 1.35rem; line-height: 1.25; margin-bottom: 0.75rem; color: var(--text-main); font-weight: 800;">
                <?php echo esc_html($popup_heading); ?>
              </h3>

              <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.5rem;">
                <?php echo esc_html($popup_subheading); ?>
              </p>

              <a href="<?php echo $popup_cta_action === 'modal' ? '#consultancy' : esc_url($popup_cta_url); ?>"
                 class="btn btn-accent btn-block popup-cta-btn <?php echo $popup_cta_action === 'modal' ? 'open-consultancy-modal' : ''; ?>"
                 data-action="<?php echo esc_attr($popup_cta_action); ?>"
                 style="font-weight: 700;">
                <?php echo esc_html($popup_cta_text); ?>
              </a>

              <p style="font-size: 0.75rem; color: var(--text-sub); text-align: center; margin-top: 0.85rem;">
                Free initial guidance • No hidden file-opening fees • Visit our office
              </p>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  <?php endif; ?>

  <!-- ==========================================
       UNIVERSAL "GET FREE CONSULTANCY" MODAL
       ========================================== -->
  <div id="consultancyModalOverlay" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="consultancyModalTitle">
    <div class="modal-card">
      <button type="button" class="modal-close-trigger" aria-label="Close profile assessment modal">✕</button>

      <div class="modal-header">
        <span class="section-badge section-badge-primary" style="margin-bottom: 0.5rem;">Fast-Track Admission</span>
        <h3 id="consultancyModalTitle" style="font-size: 1.4rem; color: var(--text-main);">Request free profile assessment</h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.25rem;">
          Fill out your details below and our certified counselor will reach out within 2 hours.
        </p>
      </div>

      <form id="globalConsultancyForm" class="ajax-lead-form">
        <input type="hidden" name="source_page" value="<?php echo esc_attr(get_the_title()); ?>">

        <div class="form-group">
          <label class="form-label" for="modal-full-name">Full Name <span style="color: var(--danger);">*</span></label>
          <input id="modal-full-name" type="text" name="name" class="form-control" placeholder="e.g. Mahfuzur Rahman" autocomplete="name" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label" for="modal-phone">Phone Number <span style="color: var(--danger);">*</span></label>
            <input id="modal-phone" type="tel" name="phone" class="form-control" placeholder="017XXXXXXXX" autocomplete="tel" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="modal-email">Email Address</label>
            <input id="modal-email" type="email" name="email" class="form-control" placeholder="student@gmail.com" autocomplete="email">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label" for="modal-country">Preferred Country <span style="color: var(--danger);">*</span></label>
            <select id="modal-country" name="target_country" class="form-control" required>
              <option value="">Select Destination</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="New Zealand">New Zealand</option>
              <option value="Canada">Canada</option>
              <option value="Malaysia">Malaysia</option>
              <option value="South Korea">South Korea</option>
              <option value="Japan">Japan</option>
              <option value="Undecided">I am still deciding</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="modal-study-level">Desired Study Level</label>
            <select id="modal-study-level" name="study_level" class="form-control">
              <option value="Bachelor">Bachelor Degree</option>
              <option value="Master" selected>Master / Postgrad</option>
              <option value="Diploma">Diploma / Foundation</option>
              <option value="PhD">PhD / Doctorate</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="modal-english-status">English Test Status (IELTS / PTE / Duolingo / None)</label>
          <input id="modal-english-status" type="text" name="ielts_status" class="form-control" placeholder="e.g. IELTS 6.5 or Appearing next month">
        </div>

        <button type="submit" class="btn btn-accent btn-block" style="padding: 0.85rem; font-size: 1rem; margin-top: 0.5rem;">
          🚀 Submit Application for Evaluation
        </button>
      </form>
    </div>
  </div>

  <!-- ==========================================
       FOOTER (Brand & Navigation)
       ========================================== -->
  <footer class="site-footer footer-wrapper">
    <div class="container footer-grid">
      <!-- Col 1: Brand Info -->
      <div class="footer-col brand-col">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand-link" style="display: inline-flex; align-items: center; gap: 12px; margin-bottom: 1.25rem;">
          <div style="background: rgba(255, 255, 255, 0.05); padding: 6px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); display: inline-flex; align-items: center;">
            <img src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo esc_attr($site_title); ?>" style="height: 46px; width: auto; object-fit: contain;">
          </div>
          <div>
            <div style="color: #FFFFFF; font-weight: 800; font-size: 1.05rem; letter-spacing: -0.02em;">ILMA Education Consultancy</div>
            <div style="color: #94A3B8; font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">Study Abroad Guidance</div>
          </div>
        </a>

        <p class="footer-desc">
          Helping Bangladeshi students make informed international study decisions with clear counselling, application guidance and practical support from shortlist to departure.
        </p>

        <div class="social-links" style="margin-top: 1.25rem;">
          <a href="<?php echo esc_url($fb); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="Facebook">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
          <a href="<?php echo esc_url($insta); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="Instagram">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M6.5 2h11A4.5 4.5 0 0122 6.5v11a4.5 4.5 0 01-4.5 4.5h-11A4.5 4.5 0 012 17.5v-11A4.5 4.5 0 016.5 2z"/></svg>
          </a>
          <a href="<?php echo esc_url($whatsapp_url); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="Chat with Us">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2z"/></svg>
          </a>
        </div>
      </div>

      <!-- Col 2: Study Destinations -->
      <div class="footer-col">
        <h4 class="footer-col-title">Study Destinations</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/destinations/uk/')); ?>">Study in United Kingdom</a></li>
          <li><a href="<?php echo esc_url(home_url('/destinations/new-zealand/')); ?>">Study in New Zealand</a></li>
          <li><a href="<?php echo esc_url(home_url('/destinations/canada/')); ?>">Study in Canada</a></li>
          <li><a href="<?php echo esc_url(home_url('/destinations/malaysia/')); ?>">Study in Malaysia</a></li>
          <li><a href="<?php echo esc_url(home_url('/destinations/south-korea/')); ?>">Study in South Korea</a></li>
          <li><a href="<?php echo esc_url(home_url('/destinations/japan/')); ?>">Study in Japan</a></li>
        </ul>
      </div>

      <!-- Col 3: Quick Navigation -->
      <div class="footer-col">
        <h4 class="footer-col-title">Quick Links</h4>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/services/')); ?>">Our Services</a></li>
          <li><a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>">Book In-Person Appointment</a></li>
          <li><a href="<?php echo esc_url(home_url('/blogs/')); ?>">Study Abroad Blogs</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Office Address</a></li>
          <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Col 4: Office Address Contact -->
      <div class="footer-col">
        <h4 class="footer-col-title">Office Address</h4>
        <p class="footer-contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <span><?php echo esc_html($address); ?></span>
        </p>

        <p class="footer-contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          <span>
            <a href="tel:<?php echo esc_attr($phone1); ?>"><?php echo esc_html($phone1); ?></a>,
            <a href="tel:<?php echo esc_attr($phone2); ?>"><?php echo esc_html($phone2); ?></a>
          </span>
        </p>

        <p class="footer-contact-item">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          <span><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></span>
        </p>

        <div style="margin-top: 1.25rem;">
          <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-accent btn-sm btn-block">
            📅 Reserve Consultation Slot
          </a>
        </div>
      </div>
    </div>

    <!-- Bottom Attribution Bar (Clean text without logo image on frontend) -->
    <div class="footer-bottom">
      <div class="container footer-bottom-inner" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div class="copyright">
          © <?php echo date('Y'); ?> <strong>ILMA Education Consultancy</strong>. All Rights Reserved.
        </div>

        <div class="uturn-attribution" style="color: #94A3B8; font-size: 0.8rem;">
          Developed with precision by <a href="https://uturndigital.com" target="_blank" rel="noopener noreferrer" style="color: #38BDF8; font-weight: 600; text-decoration: none;">UTurn Digital Solutions</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Floating WhatsApp Action -->
  <a href="<?php echo esc_url($whatsapp_url); ?>"
     class="whatsapp-float-btn"
     target="_blank"
     rel="noopener"
     aria-label="Chat with Us">
    <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm5.72 14.15c-.24.67-1.39 1.25-1.92 1.3-.5.05-1.12.08-3.41-.85-2.73-1.11-4.48-3.9-4.62-4.08-.14-.19-1.11-1.48-1.11-2.82 0-1.35.7-2.01.95-2.28.24-.27.53-.34.71-.34.18 0 .36 0 .52.01.17.01.39-.06.61.47.23.55.77 1.88.84 2.02.07.14.12.31.02.5-.09.19-.14.31-.28.47-.14.16-.3.35-.43.47-.14.14-.29.29-.12.58.17.29.74 1.23 1.59 1.98 1.09.97 2.01 1.27 2.3 1.41.29.14.46.12.63-.07.17-.19.74-.86.94-1.15.2-.29.4-.24.67-.14.28.1.1.75 2.29 1.89 2.51.14.22.23.36.27.42.04.06.04.34-.2 1.01z"/></svg>
    <span class="whatsapp-float-label">Chat with Us</span>
  </a>

  </div><!-- /.site-boxed-container -->
<?php wp_footer(); ?>
</body>
</html>
