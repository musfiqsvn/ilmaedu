/**
 * UTurnEdu1 SaaS Admin Dashboard Client Scripts
 */

document.addEventListener('DOMContentLoaded', function () {
  // Tab Switching
  const tabBtns = document.querySelectorAll('.uturnedu-tab-btn');
  const tabPanes = document.querySelectorAll('.uturnedu-tab-pane');

  function activateTab(tabId) {
    tabBtns.forEach(btn => btn.classList.remove('active'));
    tabPanes.forEach(pane => pane.classList.remove('active'));

    const activeBtn = document.querySelector(`.uturnedu-tab-btn[data-tab="${tabId}"]`);
    const activePane = document.getElementById(tabId);

    if (activeBtn) activeBtn.classList.add('active');
    if (activePane) activePane.classList.add('active');

    // Update URL hash
    window.location.hash = tabId;
  }

  tabBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const tabId = this.getAttribute('data-tab');
      activateTab(tabId);
    });
  });

  // Check URL Hash on Load
  if (window.location.hash) {
    const hash = window.location.hash.replace('#', '');
    if (document.getElementById(hash)) {
      activateTab(hash);
    }
  }
});
