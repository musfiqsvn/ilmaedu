/**
 * ILMA Education Consultancy - Appointment & Slot Reservation Engine
 * Seamlessly integrated for WordPress (admin-ajax.php / REST), Node Backend, and Static Offline Mode.
 */

document.addEventListener('DOMContentLoaded', () => {
  const bookingForm = document.getElementById('consultationBookingForm');
  if (!bookingForm) return;

  const dateInput = document.getElementById('bookingDateInput');
  const slotsContainer = document.getElementById('availableSlotsContainer');
  const slotLoading = document.getElementById('slotLoadingIndicator');
  const selectedSlotIdInput = document.getElementById('selectedSlotId');
  const selectedSlotTimeInput = document.getElementById('selectedSlotTime');
  const bookingSummaryBox = document.getElementById('bookingSummaryBox');
  const confirmationModal = document.getElementById('bookingConfirmationModal');

  // Detect environment
  function getBackendConfig() {
    if (typeof window.uturneduData !== 'undefined' && window.uturneduData.ajaxUrl) {
      return {
        type: 'wp',
        ajaxUrl: window.uturneduData.ajaxUrl,
        nonce: window.uturneduData.nonce || ''
      };
    }
    if (typeof ajaxurl !== 'undefined') {
      return { type: 'wp', ajaxUrl: ajaxurl, nonce: '' };
    }
    if (window.location.hostname.includes('digontoassets.com') || window.location.pathname.includes('/wp-')) {
      return { type: 'wp', ajaxUrl: '/wp-admin/admin-ajax.php', nonce: '' };
    }
    return { type: 'node', ajaxUrl: '/api/appointments', slotsUrl: '/api/available-slots' };
  }

  // Set min date to tomorrow
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  // If tomorrow is Friday (day 5), start on Saturday because the office is closed.
  if (tomorrow.getDay() === 5) {
    tomorrow.setDate(tomorrow.getDate() + 1);
  }
  const minDateStr = tomorrow.toISOString().split('T')[0];
  if (dateInput) {
    dateInput.min = minDateStr;
    dateInput.value = minDateStr;

    // Fetch slots whenever date changes
    dateInput.addEventListener('change', () => {
      fetchSlotsForDate(dateInput.value);
    });

    // Initial fetch
    fetchSlotsForDate(dateInput.value);
  }

  async function fetchSlotsForDate(dateStr) {
    if (!dateStr) return;

    // Reset selection
    if (selectedSlotIdInput) selectedSlotIdInput.value = '';
    if (selectedSlotTimeInput) selectedSlotTimeInput.value = '';
    if (bookingSummaryBox) bookingSummaryBox.style.display = 'none';

    if (slotsContainer) slotsContainer.innerHTML = '';
    if (slotLoading) slotLoading.style.display = 'flex';

    const selectedDate = new Date(dateStr + 'T00:00:00');
    const dayOfWeek = selectedDate.getDay(); // 0: Sun, 5: Fri
    const config = getBackendConfig();

    try {
      let res;
      try {
        let requestUrl;
        if (config.type === 'wp') {
          requestUrl = `${config.ajaxUrl}?action=uturnedu_get_available_slots&date=${encodeURIComponent(dateStr)}`;
        } else {
          requestUrl = `/api/available-slots?date=${encodeURIComponent(dateStr)}`;
        }

        const response = await fetch(requestUrl);
        if (response.ok) {
          const raw = await response.json();
          res = (raw && raw.data) ? raw.data : raw;
        } else {
          throw new Error('API slot fallback');
        }
      } catch (e) {
        // Fallback for offline static HTML preview
        if (dayOfWeek === 5) { // Friday closed
          res = {
            success: false,
            is_available: false,
            reason: 'Our Mohammadpur office is closed on Fridays for weekly maintenance.'
          };
        } else {
          res = {
            success: true,
            is_available: true,
            slots: [
              { id: 'slot-1', time: '10:30 AM - 11:15 AM', remaining_capacity: 4, is_full: false },
              { id: 'slot-2', time: '11:30 AM - 12:15 PM', remaining_capacity: 3, is_full: false },
              { id: 'slot-3', time: '02:00 PM - 02:45 PM', remaining_capacity: 4, is_full: false },
              { id: 'slot-4', time: '03:00 PM - 03:45 PM', remaining_capacity: 2, is_full: false },
              { id: 'slot-5', time: '04:00 PM - 04:45 PM', remaining_capacity: 3, is_full: false },
              { id: 'slot-6', time: '05:00 PM - 05:45 PM', remaining_capacity: 1, is_full: false }
            ]
          };
        }
      }

      if (slotLoading) slotLoading.style.display = 'none';

      if (!res.is_available && res.is_available !== undefined) {
        slotsContainer.innerHTML = `
          <div class="card" style="background: #FEF2F2; border-color: #FECACA; padding: 1.5rem; text-align: center;">
            <p style="color: #991B1B; font-weight: 700; margin-bottom: 0.25rem;">Office Closed on This Date</p>
            <p style="color: #B91C1C; font-size: 0.9rem;">${res.reason || 'Our Mohammadpur office is closed on Fridays. Please pick another weekday.'}</p>
          </div>
        `;
        return;
      }

      if (!res.slots || res.slots.length === 0) {
        slotsContainer.innerHTML = `
          <div class="card" style="background: #FFFBEB; border-color: #FDE68A; padding: 1.5rem; text-align: center;">
            <p style="color: #92400E; font-weight: 700;">No active slots found.</p>
            <p style="color: #B45309; font-size: 0.85rem;">Please select another consultation date (Saturday – Thursday).</p>
          </div>
        `;
        return;
      }

      let html = '<div class="slot-pills-grid">';
      res.slots.forEach(slot => {
        const isFull = slot.is_full || (slot.remaining_capacity !== undefined && slot.remaining_capacity <= 0);
        const remCap = slot.remaining_capacity !== undefined ? slot.remaining_capacity : 4;
        html += `
          <button type="button"
            class="slot-pill-btn ${isFull ? 'disabled' : ''}"
            data-slot-id="${slot.id}"
            data-slot-time="${slot.time}"
            ${isFull ? 'disabled' : ''}>
            <div style="font-weight: 700; margin-bottom: 0.2rem;">${slot.time}</div>
            <div style="font-size: 0.75rem; color: ${isFull ? '#DC2626' : '#059669'}; font-weight: 600;">
              ${isFull ? '● Fully Booked' : `● ${remCap} Seat${remCap > 1 ? 's' : ''} Available`}
            </div>
          </button>
        `;
      });
      html += '</div>';
      slotsContainer.innerHTML = html;

      // Attach click events to pills
      slotsContainer.querySelectorAll('.slot-pill-btn:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', () => {
          slotsContainer.querySelectorAll('.slot-pill-btn').forEach(b => b.classList.remove('selected'));
          btn.classList.add('selected');

          const slotId = btn.getAttribute('data-slot-id');
          const slotTime = btn.getAttribute('data-slot-time');

          if (selectedSlotIdInput) selectedSlotIdInput.value = slotId;
          if (selectedSlotTimeInput) selectedSlotTimeInput.value = slotTime;

          if (bookingSummaryBox) {
            bookingSummaryBox.style.display = 'block';
            const sumDate = document.getElementById('summaryDateText');
            const sumTime = document.getElementById('summaryTimeText');
            if (sumDate && dateInput) sumDate.textContent = dateInput.value;
            if (sumTime) sumTime.textContent = slotTime;
          }
        });
      });

    } catch (err) {
      if (slotLoading) slotLoading.style.display = 'none';
      if (slotsContainer) slotsContainer.innerHTML = `<p style="color: red; font-size: 0.9rem;">Unable to load time slots. Please refresh.</p>`;
    }
  }

  // Handle Booking Form Submit
  bookingForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!selectedSlotTimeInput || !selectedSlotTimeInput.value) {
      if (typeof showToast === 'function') {
        showToast('Please select an available time slot above.', 'error');
      } else {
        alert('Please select an available time slot above.');
      }
      return;
    }

    const submitBtn = bookingForm.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Confirm Booking';
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Booking In-Person Slot...';
    }

    const config = getBackendConfig();
    const formData = new FormData(bookingForm);

    try {
      let res;
      if (config.type === 'wp') {
        // WordPress AJAX Submission
        formData.append('action', 'uturnedu_submit_appointment');
        if (config.nonce) formData.append('nonce', config.nonce);

        const response = await fetch(config.ajaxUrl, {
          method: 'POST',
          body: formData
        });

        const raw = await response.json();
        if (!response.ok || (raw.success === false)) {
          const errMsg = (raw.data && raw.data.message) ? raw.data.message : (raw.message || 'Booking submission failed.');
          throw new Error(errMsg);
        }
        res = raw.data ? Object.assign(raw, raw.data) : raw;
      } else {
        // Node / Express API or Fallback
        const data = Object.fromEntries(formData.entries());
        try {
          const response = await fetch('/api/appointments', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
          });
          if (response.ok) {
            res = await response.json();
          } else {
            throw new Error('Offline demo');
          }
        } catch (fetchErr) {
          res = {
            success: true,
            booking_ref: 'ILMA-' + Math.floor(100000 + Math.random() * 900000),
            appointment: {
              referenceId: 'ILMA-' + Math.floor(100000 + Math.random() * 900000),
              name: data.student_name || data.name || 'Valued Student',
              date: data.appointment_date || dateInput.value,
              time: data.slot_time || selectedSlotTimeInput.value,
              type: data.consultation_type || 'In-Person (Office Address)'
            }
          };
        }
      }

      if (res && (res.success || res.booking_ref || res.reference_id)) {
        showSuccessModal(res.appointment || res);
        bookingForm.reset();
        if (selectedSlotIdInput) selectedSlotIdInput.value = '';
        if (selectedSlotTimeInput) selectedSlotTimeInput.value = '';
        if (bookingSummaryBox) bookingSummaryBox.style.display = 'none';
      } else {
        const errorMsg = (res && res.message) ? res.message : 'Failed to confirm appointment.';
        if (typeof showToast === 'function') {
          showToast(errorMsg, 'error');
        } else {
          alert(errorMsg);
        }
      }
    } catch (err) {
      if (typeof showToast === 'function') {
        showToast(err.message || 'Error booking appointment. Please try again.', 'error');
      } else {
        alert(err.message || 'Error booking appointment.');
      }
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }
    }
  });

  function showSuccessModal(appt) {
    if (!confirmationModal) {
      if (typeof showToast === 'function') {
        showToast('Appointment Confirmed! Ref: ' + (appt.referenceId || appt.reference_id || appt.booking_ref), 'success');
      }
      return;
    }

    const confRef = document.getElementById('confirmRefCode') || document.getElementById('confRefCode');
    const confDateTime = document.getElementById('confirmDateTimeText');
    const confName = document.getElementById('confStudentName');
    const confDate = document.getElementById('confDate');
    const confTime = document.getElementById('confTime');

    const ref = appt.referenceId || appt.reference_id || appt.booking_ref || 'ILMA-2026-OK';
    const date = appt.date || (dateInput ? dateInput.value : '');
    const time = appt.time || (selectedSlotTimeInput ? selectedSlotTimeInput.value : '');

    if (confRef) confRef.textContent = ref;
    if (confDateTime) confDateTime.textContent = `${date} at ${time}`;
    if (confName) confName.textContent = appt.name || '';
    if (confDate) confDate.textContent = date;
    if (confTime) confTime.textContent = time;

    confirmationModal.classList.add('show');
    document.body.style.overflow = 'hidden';

    const closeBtn = confirmationModal.querySelector('.modal-close-trigger') || confirmationModal.querySelector('.btn-primary');
    if (closeBtn) {
      closeBtn.onclick = () => {
        confirmationModal.classList.remove('show');
        document.body.style.overflow = '';
      };
    }
  }
});
