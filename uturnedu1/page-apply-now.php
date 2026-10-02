<?php
/**
 * Dedicated campaign landing page for direct Apply Now URLs.
 *
 * @package UTurnEdu1
 */
if (!defined('ABSPATH')) { exit; }
get_header();
$whatsapp = uturnedu_whatsapp_url('Hello ILMA Education Consultancy, I would like help with my application.');
$destinations = uturnedu_destination_catalog();
?>
<main class="apply-page" id="main-content">
  <section class="apply-hero" aria-labelledby="apply-page-title">
    <div class="container apply-hero-grid">
      <div class="apply-hero-copy">
        <span class="section-badge section-badge-accent">Start your next step</span>
        <h1 id="apply-page-title">Apply with a clearer plan.</h1>
        <p>Tell us a little about your study goals. One of our advisors will review your profile and help you understand suitable destinations, course routes and what to prepare next.</p>
        <ul class="apply-trust-list">
          <li><span aria-hidden="true">✓</span> Personalised destination guidance</li>
          <li><span aria-hidden="true">✓</span> Practical application and document support</li>
          <li><span aria-hidden="true">✓</span> No pressure, just a useful first conversation</li>
        </ul>
        <?php if ($whatsapp): ?><a class="apply-direct-link" href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">Chat with Us <span aria-hidden="true">↗</span></a><?php endif; ?>
      </div>
      <div class="apply-form-card">
        <div class="apply-form-heading"><span class="section-badge">Free profile review</span><h2>Share your details</h2><p>Required fields are marked with an asterisk.</p></div>
        <form class="ajax-lead-form apply-form" novalidate>
          <input type="hidden" name="source" value="Apply Now Landing Page">
          <input type="hidden" name="page_url" value="">
          <input type="hidden" name="utm_source" value=""><input type="hidden" name="utm_medium" value=""><input type="hidden" name="utm_campaign" value=""><input type="hidden" name="utm_term" value=""><input type="hidden" name="utm_content" value="">
          <div class="apply-honeypot" aria-hidden="true"><label>Website<input type="text" name="website_hp" tabindex="-1" autocomplete="off"></label></div>
          <div class="apply-form-field"><label for="apply-name">Full name <span aria-hidden="true">*</span></label><input id="apply-name" name="name" type="text" autocomplete="name" required placeholder="Your full name"></div>
          <div class="apply-form-row"><div class="apply-form-field"><label for="apply-phone">Mobile number <span aria-hidden="true">*</span></label><input id="apply-phone" name="phone" type="tel" autocomplete="tel" required placeholder="01XXXXXXXXX"></div><div class="apply-form-field"><label for="apply-email">Email address</label><input id="apply-email" name="email" type="email" autocomplete="email" placeholder="you@example.com"></div></div>
          <div class="apply-form-row"><div class="apply-form-field"><label for="apply-country">Preferred destination <span aria-hidden="true">*</span></label><select id="apply-country" name="target_country" required><option value="">Choose one</option><?php foreach ($destinations as $destination): ?><option value="<?php echo esc_attr($destination['title']); ?>">Study in <?php echo esc_html($destination['title']); ?></option><?php endforeach; ?><option value="Undecided">I am still deciding</option></select></div><div class="apply-form-field"><label for="apply-level">Study level</label><select id="apply-level" name="study_level"><option value="Bachelor">Bachelor / undergraduate</option><option value="Master" selected>Master / postgraduate</option><option value="Diploma">Diploma / foundation</option><option value="PhD">PhD / doctorate</option></select></div></div>
          <div class="apply-form-row"><div class="apply-form-field"><label for="apply-qualification">Latest qualification</label><input id="apply-qualification" name="qualification" type="text" placeholder="e.g. BBA, HSC, honours"></div><div class="apply-form-field"><label for="apply-ielts">English test status</label><input id="apply-ielts" name="ielts_score" type="text" placeholder="e.g. IELTS 6.5 / not yet taken"></div></div>
          <div class="apply-form-row"><div class="apply-form-field"><label for="apply-intake">Preferred intake</label><input id="apply-intake" name="target_intake" type="text" placeholder="e.g. September 2027"></div><div class="apply-form-field"><label for="apply-budget">Approximate budget</label><input id="apply-budget" name="budget" type="text" placeholder="Optional"></div></div>
          <div class="apply-form-field"><label for="apply-message">What would you like help with?</label><textarea id="apply-message" name="notes" rows="3" placeholder="Tell us about your course interest or question"></textarea></div>
          <label class="apply-consent"><input type="checkbox" name="consent" value="yes" required> <span>I agree that we may contact you about this enquiry.</span></label>
          <button type="submit" class="btn btn-accent btn-lg btn-block">Submit my application enquiry <span aria-hidden="true">↗</span></button>
          <p class="apply-privacy-note">Your details are used only to respond to this enquiry. Read our <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">privacy policy</a>.</p>
        </form>
      </div>
    </div>
  </section>
  <section class="apply-bottom-note"><div class="container"><p><strong>Not ready to apply?</strong> You can still send your questions and an advisor will help you find a comfortable next step.</p><a href="<?php echo esc_url(home_url('/')); ?>" class="text-link-button">Return to our homepage <span aria-hidden="true">→</span></a></div></section>
</main>
<?php get_footer(); ?>
