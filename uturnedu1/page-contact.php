<?php
/**
 * Template Name: Contact Us
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
$phone1   = $settings['phone_primary'] ?? '01329272046';
$phone2   = $settings['phone_secondary'] ?? '01823345573';
$email    = $settings['email_primary'] ?? 'info@ilmaedubd.com';
$email2   = $settings['email_support'] ?? 'rawshan@ilmaedubd.com';
$address  = $settings['address'] ?? 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';
$whatsapp = uturnedu_whatsapp_url('Hello ILMA Education Consultancy, I would like to speak with an advisor.');
?>

<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container text-center">
    <span class="section-badge section-badge-accent">Mohammadpur, Dhaka</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 1rem;">Contact ILMA Education Consultancy</h1>
    <p style="max-width: 720px; margin: 0 auto; font-size: 1.1rem;">
      Have questions about entry requirements, IELTS waivers, or visa processing? Visit our office or send us an inquiry directly.
    </p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns: 1.2fr 1.8fr; gap: 3.5rem;">

      <!-- Left Contact Details -->
      <div>
        <div class="card" style="margin-bottom: 1.5rem;">
          <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1.5rem;">
            <div class="service-icon-box" style="flex-shrink: 0; width: 44px; height: 44px;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <div>
              <h3 style="font-size: 1.15rem; margin-bottom: 0.35rem;">Office Address</h3>
              <p style="font-size: 0.95rem; line-height: 1.6; margin: 0;">
                <?php echo esc_html($address); ?>
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1.5rem;">
            <div class="service-icon-box" style="flex-shrink: 0; width: 44px; height: 44px;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <div>
              <h3 style="font-size: 1.15rem; margin-bottom: 0.35rem;">Direct Helplines</h3>
              <p style="font-size: 0.95rem; margin: 0;">
                <a href="tel:<?php echo esc_attr($phone1); ?>" style="color: var(--primary); font-weight: 700;"><?php echo esc_html($phone1); ?></a><br>
                <a href="tel:<?php echo esc_attr($phone2); ?>" style="color: var(--primary); font-weight: 700;"><?php echo esc_html($phone2); ?></a>
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1.5rem;">
            <div class="service-icon-box" style="flex-shrink: 0; width: 44px; height: 44px;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
            <div>
              <h3 style="font-size: 1.15rem; margin-bottom: 0.35rem;">Official Email</h3>
              <p style="font-size: 0.95rem; margin: 0;">
                <a href="mailto:<?php echo esc_attr($email); ?>" style="color: var(--primary);"><?php echo esc_html($email); ?></a><br>
                <a href="mailto:<?php echo esc_attr($email2); ?>" style="color: var(--primary);"><?php echo esc_html($email2); ?></a>
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 1rem; align-items: flex-start;">
            <div class="service-icon-box" style="flex-shrink: 0; width: 44px; height: 44px;">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div>
              <h3 style="font-size: 1.15rem; margin-bottom: 0.35rem;">Office Hours</h3>
              <p style="font-size: 0.95rem; margin: 0;">
                Saturday – Thursday: 10:00 AM – 6:30 PM<br>
                <span style="color: var(--accent-red); font-weight: 600;">Friday: Closed (Online inquiries active)</span>
              </p>
            </div>
          </div>
        </div>

        <a href="<?php echo esc_url(home_url('/reserve-consultation/')); ?>" class="btn btn-accent btn-block btn-lg" style="font-weight: 700;">
          Reserve In-Person Slot at Mohammadpur 📅
        </a>
        <?php if ($whatsapp): ?><a href="<?php echo esc_url($whatsapp); ?>" class="btn btn-whatsapp btn-block" target="_blank" rel="noopener" style="margin-top: 0.75rem;">Chat with Us ↗</a><?php endif; ?>
      </div>

      <!-- Right Contact Form -->
      <div>
        <div class="card" style="box-shadow: var(--shadow-lg);">
          <span class="section-badge">Send Us a Direct Message</span>
          <h2 style="font-size: 1.6rem; margin-top: 0.35rem; margin-bottom: 0.5rem;">We’re Here to Guide You</h2>
          <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.75rem;">
            Fill out the form below. A certified education advisor will review your message and reply promptly.
          </p>

          <form id="contactPageForm">
            <input type="hidden" name="source" value="Contact Us Page Form">

            <div class="grid grid-2 gap-4">
              <div class="form-group">
                <label class="form-label">Full Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Tanvir Ahmed" required>
              </div>

              <div class="form-group">
                <label class="form-label">Mobile Number <span class="req">*</span></label>
                <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
              </div>
            </div>

            <div class="grid grid-2 gap-4">
              <div class="form-group">
                <label class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="student@gmail.com" required>
              </div>

              <div class="form-group">
                <label class="form-label">Target Destination</label>
                <select name="target_country" class="form-control">
                  <option value="United Kingdom">United Kingdom</option>
                  <option value="New Zealand">New Zealand</option>
                  <option value="Canada">Canada</option>
                  <option value="Malaysia">Malaysia</option>
                  <option value="South Korea">South Korea</option>
                  <option value="Japan">Japan</option>
                  <option value="Undecided">Undecided</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Your Message or Academic Query <span class="req">*</span></label>
              <textarea name="notes" class="form-control" rows="5" placeholder="Tell us your current academic qualification, intended study level, and any specific questions..." required></textarea>
            </div>

            <div class="form-check">
              <input type="checkbox" id="contactConsent" required checked>
              <label for="contactConsent">
                I agree to ILMA Education Consultancy contacting me regarding study abroad guidance.
              </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg" style="font-weight: 700;">
              Send Message Now 🚀
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Map Embed Section -->
<section style="background: var(--surface-50); border-top: 1px solid var(--surface-200); padding: 3rem 0;">
  <div class="container">
    <div style="border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--surface-200);">
      <iframe
        src="https://maps.google.com/maps?q=CL+Tower+Bosila+Road+Mohammadpur+Dhaka&t=&z=15&ie=UTF8&iwloc=&output=embed"
        width="100%"
        height="360"
        style="border:0; display: block;"
        allowfullscreen=""
        loading="lazy"
        title="ILMA Education Consultancy Mohammadpur Location">
      </iframe>
    </div>
  </div>
</section>

<?php
get_footer();
