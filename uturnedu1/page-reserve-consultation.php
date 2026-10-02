<?php
/**
 * Template Name: Reserve Consultation
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
$address  = $settings['address'] ?? 'CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh';
?>

<section class="section section-bg-alt" style="padding: 4rem 0 3rem 0;">
  <div class="container text-center">
    <span class="section-badge section-badge-accent">📍 Office Address</span>
    <h1 style="margin-top: 0.5rem; margin-bottom: 1rem;">Reserve In-Person Consultation</h1>
    <p style="max-width: 720px; margin: 0 auto; font-size: 1.1rem;">
      Schedule a dedicated 1-on-1 counseling session with our senior admission and visa advisors at CL Tower, 772/1A, Bosila Road, Mohammadpur, Dhaka - 1207, Bangladesh Zero waiting time guaranteed.
    </p>
  </div>
</section>

<!-- Blocked Dates JSON Holder -->
<div id="blockedDatesData" style="display: none;">[]</div>

<section class="section">
  <div class="container">
    <div class="grid" style="grid-template-columns: 1.8fr 1.2fr; gap: 3.5rem;">

      <!-- Interactive Booking Wizard -->
      <div>
        <div class="booking-wizard-card">

          <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.6rem; margin-bottom: 0.35rem;">Choose Date &amp; Available Time Slot</h2>
            <p style="font-size: 0.9rem; color: var(--text-muted);">
              Select your preferred appointment date to view real-time counselor availability.
            </p>
          </div>

          <form id="consultationBookingForm">
            <!-- Anti-Spam Honeypot -->
            <input type="text" name="website_hp" style="display: none;" tabindex="-1" autocomplete="off">
            <input type="hidden" id="selectedSlotId" name="slot_id" value="">
            <input type="hidden" id="selectedSlotTime" name="slot_time" value="">

            <!-- Step 1: Study Preference & Type -->
            <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--surface-200);">
              <div class="grid grid-2 gap-4">
                <div class="form-group">
                  <label class="form-label">Preferred Study Destination</label>
                  <select name="target_country" class="form-control">
                    <option value="United Kingdom">Study in United Kingdom</option>
                    <option value="New Zealand">Study in New Zealand</option>
                    <option value="Canada">Study in Canada</option>
                    <option value="Malaysia">Study in Malaysia</option>
                    <option value="South Korea">Study in South Korea</option>
                    <option value="Japan">Study in Japan</option>
                    <option value="Multiple Destinations">Multiple Destinations</option>
                  </select>
                </div>

                <div class="form-group">
                  <label class="form-label">Consultation Mode</label>
                  <select name="consultation_type" class="form-control">
                    <option value="In-Person (Office Address)">🏢 In-Person (Office Address)</option>
                    <option value="Virtual Video Call">💻 Virtual Video Call (Zoom/Google Meet)</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Step 2: Date Picker & Live Slots -->
            <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--surface-200);">
              <div class="form-group">
                <label class="form-label">Select Consultation Date <span class="req">*</span></label>
                <input type="date" id="bookingDateInput" name="appointment_date" class="form-control" required style="font-weight: 700; color: var(--primary);">
                <small style="color: var(--text-sub); display: block; margin-top: 0.35rem;">
                  Office Hours: Saturday – Thursday: 10:00 AM – 6:30 PM (Fridays Closed)
                </small>
              </div>

              <div style="margin-top: 1.25rem;">
                <label class="form-label">Available Time Slots for Selected Date <span class="req">*</span></label>

                <div id="slotLoadingIndicator" style="display: none; align-items: center; gap: 0.5rem; color: var(--primary); font-size: 0.9rem; margin-top: 0.5rem;">
                  <span>Checking slot availability...</span>
                </div>

                <div id="availableSlotsContainer">
                  <!-- Loaded via /assets/js/booking.js -->
                </div>
              </div>

              <!-- Selected Slot Summary Banner -->
              <div id="bookingSummaryBox" style="display: none; background: #ECFDF5; border: 1.5px solid #10B981; border-radius: var(--radius-md); padding: 1rem; margin-top: 1.25rem;">
                <div style="font-weight: 700; color: #065F46; font-size: 0.95rem;">
                  ✓ Selected Slot: <span id="summaryDateText"></span> at <span id="summaryTimeText"></span>
                </div>
              </div>
            </div>

            <!-- Step 3: Student Details -->
            <div style="margin-bottom: 2rem;">
              <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Student Information</h3>

              <div class="grid grid-2 gap-4">
                <div class="form-group">
                  <label class="form-label">Full Name <span class="req">*</span></label>
                  <input type="text" name="student_name" class="form-control" placeholder="e.g. Shakil Chowdhury" required>
                </div>

                <div class="form-group">
                  <label class="form-label">Mobile Number <span class="req">*</span></label>
                  <input type="tel" name="student_phone" class="form-control" placeholder="01XXXXXXXXX" required>
                </div>
              </div>

              <div class="grid grid-2 gap-4">
                <div class="form-group">
                  <label class="form-label">Email Address <span class="req">*</span></label>
                  <input type="email" name="student_email" class="form-control" placeholder="name@email.com" required>
                </div>

                <div class="form-group">
                  <label class="form-label">Current Academic Level</label>
                  <select name="education_level" class="form-control">
                    <option value="Bachelor Completed">Bachelor Completed</option>
                    <option value="HSC / A-Levels">HSC / A-Levels</option>
                    <option value="Bachelor Running">Bachelor Running</option>
                    <option value="Masters Completed">Masters Completed</option>
                    <option value="Diploma">Diploma</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Notes or Special Requirements (Optional)</label>
                <textarea name="notes" class="form-control" placeholder="Tell us if you have IELTS/PTE scores, target major, or bring parents along..."></textarea>
              </div>

              <div class="form-check">
                <input type="checkbox" id="bookingConsent" required checked>
                <label for="bookingConsent">
                  I confirm that I will arrive at CL Tower, 772/1A, Bosila Road, Mohammadpur 10 minutes prior to my selected time slot.
                </label>
              </div>
            </div>

            <button type="submit" id="submitBookingBtn" class="btn btn-accent btn-block btn-lg" style="font-weight: 700;">
              Confirm In-Person Appointment Now 📅
            </button>
          </form>

        </div>
      </div>

      <!-- Right Office Map & Information -->
      <div>
        <div class="card" style="margin-bottom: 2rem;">
          <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">📍 Location & Directions</h3>
          <p style="font-size: 0.95rem; margin-bottom: 1.25rem;">
            <strong>ILMA Education Consultancy</strong><br>
            <?php echo esc_html($address); ?>
          </p>

          <div style="background: var(--surface-50); border: 1px solid var(--surface-200); border-radius: var(--radius-md); padding: 1rem; margin-bottom: 1.5rem;">
            <div style="font-size: 0.85rem; font-weight: 700; color: var(--primary); margin-bottom: 0.25rem;">Direct Helplines:</div>
            <div style="font-size: 0.95rem; font-weight: 700;">
              <a href="tel:<?php echo esc_attr($phone1); ?>" style="color: inherit;"><?php echo esc_html($phone1); ?></a> /
              <a href="tel:<?php echo esc_attr($phone2); ?>" style="color: inherit;"><?php echo esc_html($phone2); ?></a>
            </div>
          </div>

          <div style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--surface-200);">
            <iframe
              src="https://maps.google.com/maps?q=CL+Tower+Bosila+Road+Mohammadpur+Dhaka&t=&z=15&ie=UTF8&iwloc=&output=embed"
              width="100%"
              height="260"
              style="border:0; display: block;"
              allowfullscreen=""
              loading="lazy">
            </iframe>
          </div>
        </div>

        <div class="card" style="background: var(--primary-deep); color: #fff; border: none;">
          <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 0.75rem;">📋 What to Bring to Your Session:</h3>
          <ul style="list-style: none; font-size: 0.875rem; color: #CBD5E1; line-height: 1.8;">
            <li>✓ Academic Certificates &amp; Transcripts (SSC, HSC, Bachelor)</li>
            <li>✓ IELTS / PTE / English Test Scorecard (if available)</li>
            <li>✓ Passport Information Page (Copy or Original)</li>
            <li>✓ Updated CV / Resume &amp; List of Target Subjects</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Appointment Confirmation Modal -->
<div id="bookingConfirmationModal" class="modal-overlay">
  <div class="modal-box text-center">
    <div style="width: 64px; height: 64px; border-radius: 50%; background: #ECFDF5; color: #059669; font-size: 2rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-weight: 800;">
      ✓
    </div>

    <span class="section-badge section-badge-accent">Appointment Confirmed</span>
    <h3 style="font-size: 1.6rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">We Look Forward to Meeting You!</h3>

    <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 1.5rem;">
      Your in-person consultation slot has been reserved. A confirmation SMS and counselor briefing has been scheduled.
    </p>

    <div style="background: var(--surface-50); border: 1.5px dashed var(--primary); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem; text-align: left;">
      <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
        <span style="color: var(--text-sub); font-size: 0.85rem;">Booking Reference:</span>
        <strong id="confirmRefCode" style="color: var(--primary); font-family: monospace; font-size: 1.1rem;">ILMA-REF</strong>
      </div>
      <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
        <span style="color: var(--text-sub); font-size: 0.85rem;">Date &amp; Time:</span>
        <strong id="confirmDateTimeText" style="color: var(--text-main);">Aug 28, 2026</strong>
      </div>
      <div style="display: flex; justify-content: space-between;">
        <span style="color: var(--text-sub); font-size: 0.85rem;">Location:</span>
        <strong style="color: var(--text-main);">CL Tower, 772/1A, Bosila Road, Mohammadpur</strong>
      </div>
    </div>

    <button type="button" class="btn btn-primary btn-block" onclick="window.location.href='/'">
      Return to Homepage
    </button>
  </div>
</div>

<?php
get_footer();
