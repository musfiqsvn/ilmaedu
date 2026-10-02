/**
 * ILMA Education Consultancy admin dashboard interactions.
 */
document.addEventListener('DOMContentLoaded', function () {
  const tabBtns = document.querySelectorAll('.uturnedu-tab-btn');
  const tabPanes = document.querySelectorAll('.uturnedu-tab-pane');

  function activateTab(tabId, updateHash) {
    tabBtns.forEach((btn) => btn.classList.toggle('active', btn.dataset.tab === tabId));
    tabPanes.forEach((pane) => pane.classList.toggle('active', pane.id === tabId));
    if (updateHash && window.history && window.history.replaceState) {
      window.history.replaceState(null, '', `${window.location.pathname}${window.location.search}#${tabId}`);
    }
  }

  tabBtns.forEach((btn) => btn.addEventListener('click', () => activateTab(btn.dataset.tab, true)));
  const queryTab = new URLSearchParams(window.location.search).get('tab');
  const initialTab = window.location.hash.replace('#', '') || (queryTab ? `tab-${queryTab}` : 'tab-overview');
  activateTab(document.getElementById(initialTab) ? initialTab : 'tab-overview', false);

  const adminData = window.uturneduAdminData || {};
  const ajaxUrl = window.ajaxurl || adminData.ajaxUrl || '/wp-admin/admin-ajax.php';

  async function saveLead(row, trigger) {
    const leadId = trigger.dataset.leadId || row.dataset.leadRow;
    const status = row.querySelector('.uturnedu-crm-status')?.value || 'New';
    const payload = new URLSearchParams({
      action: 'uturnedu_admin_update_lead_details',
      nonce: adminData.nonce || '',
      lead_id: leadId,
      status,
      follow_up_date: row.querySelector('[data-lead-field="follow_up_date"]')?.value || '',
      owner: row.querySelector('[data-lead-field="owner"]')?.value || '',
      notes: row.querySelector('[data-lead-field="notes"]')?.value || ''
    });
    const state = row.querySelector('.uturnedu-crm-save-state');
    if (state) state.textContent = 'Saving…';
    trigger.disabled = true;
    try {
      const response = await fetch(ajaxUrl, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }, body: payload });
      const result = await response.json();
      if (!result.success) throw new Error(result.data?.message || 'Could not save');
      if (state) { state.textContent = 'Saved'; setTimeout(() => { state.textContent = ''; }, 1800); }
    } catch (error) {
      if (state) state.textContent = error.message;
    } finally {
      trigger.disabled = false;
    }
  }

  document.querySelectorAll('.uturnedu-save-lead').forEach((button) => {
    button.addEventListener('click', () => saveLead(button.closest('[data-lead-row]'), button));
  });
  document.querySelectorAll('.uturnedu-crm-status').forEach((select) => {
    select.addEventListener('change', () => saveLead(select.closest('[data-lead-row]'), select));
  });

  // WordPress Media Library picker used by logos, popup media, homepage video posters,
  // destination images and ad banners. Every picker writes back to its paired URL field.
  document.querySelectorAll('.uturnedu-media-button').forEach((button) => {
    button.addEventListener('click', (event) => {
      event.preventDefault();
      if (!window.wp || !window.wp.media) {
        window.alert('The WordPress Media Library is not available on this screen.');
        return;
      }
      const target = document.getElementById(button.dataset.mediaTarget);
      if (!target) return;
      const frame = window.wp.media({
        title: button.dataset.mediaTitle || 'Choose an image',
        button: { text: 'Use this image' },
        multiple: false,
        library: { type: 'image' }
      });
      frame.on('select', () => {
        const attachment = frame.state().get('selection').first().toJSON();
        target.value = attachment.url || '';
        target.dispatchEvent(new Event('change', { bubbles: true }));
        target.focus();
      });
      frame.open();
    });
  });

  // Add a small preview and clear affordance beside every media URL field.
  document.querySelectorAll('.uturnedu-media-row').forEach((row) => {
    const target = row.querySelector('input[type="url"]');
    if (!target) return;
    const clear = document.createElement('button');
    clear.type = 'button';
    clear.className = 'uturnedu-media-clear';
    clear.textContent = 'Clear';
    clear.setAttribute('aria-label', 'Clear selected image');
    const preview = document.createElement('img');
    preview.className = 'uturnedu-media-preview';
    preview.alt = '';
    preview.loading = 'lazy';
    row.append(clear, preview);
    const renderMediaState = () => {
      const value = target.value.trim();
      preview.src = value;
      preview.hidden = !value;
      clear.hidden = !value;
    };
    clear.addEventListener('click', () => {
      target.value = '';
      target.dispatchEvent(new Event('change', { bubbles: true }));
      target.focus();
      renderMediaState();
    });
    target.addEventListener('input', renderMediaState);
    target.addEventListener('change', renderMediaState);
    renderMediaState();
  });

  // Quick filters in Content Studio keep the library calm on sites with many items.
  document.querySelectorAll('[data-content-filter]').forEach((filterButton) => {
    filterButton.addEventListener('click', () => {
      const filter = filterButton.dataset.contentFilter;
      const isAlreadySelected = filterButton.classList.contains('is-selected');
      document.querySelectorAll('[data-content-library]').forEach((library) => {
        library.hidden = !isAlreadySelected && library.dataset.contentLibrary !== filter;
      });
      document.querySelectorAll('[data-content-filter]').forEach((button) => {
        button.classList.toggle('is-selected', !isAlreadySelected && button === filterButton);
      });
    });
  });
});
