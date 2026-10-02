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
});
