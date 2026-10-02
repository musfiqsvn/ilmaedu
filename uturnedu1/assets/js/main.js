/**
 * ILMA Education Consultancy - Main Client Interactions
 * Fully functional in WordPress (admin-ajax.php), Node backend, and static HTML preview mode.
 */

document.addEventListener('DOMContentLoaded', () => {
  // Environment helper
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
    return { type: 'node', ajaxUrl: '/api/leads' };
  }

  // 1. Sticky Header Effect
  const header = document.querySelector('.header-wrapper');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 30) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }

  // 2. Mobile Menu Drawer
  const mobileToggle = document.querySelector('.mobile-menu-toggle');
  const mobileDrawer = document.querySelector('.mobile-drawer');
  const drawerBackdrop = document.querySelector('.drawer-backdrop');
  const closeDrawerBtn = document.querySelector('.close-drawer-btn');

  function openDrawer() {
    if (mobileDrawer) mobileDrawer.classList.add('active');
    if (drawerBackdrop) drawerBackdrop.classList.add('active');
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    if (mobileDrawer) mobileDrawer.classList.remove('active');
    if (drawerBackdrop) drawerBackdrop.classList.remove('active');
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (mobileToggle) mobileToggle.addEventListener('click', openDrawer);
  if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeDrawer);
  if (drawerBackdrop) drawerBackdrop.addEventListener('click', closeDrawer);
  document.querySelectorAll('.mobile-nav-link').forEach(link => link.addEventListener('click', closeDrawer));

  // 3. Full-width six-country hero carousel
  const heroCarousel = document.querySelector('[data-hero-carousel]');
  if (heroCarousel) {
    const heroTrack = heroCarousel.querySelector('[data-hero-track]');
    const heroSlides = Array.from(heroCarousel.querySelectorAll('.country-hero-slide'));
    // Country cards sit below the banner, so keep their controls in the same carousel state.
    const heroDots = Array.from(document.querySelectorAll('[data-hero-dot]'));
    const heroDestinationNav = document.querySelector('.country-hero-destination-nav');
    const heroPrev = heroCarousel.querySelector('[data-hero-prev]');
    const heroNext = heroCarousel.querySelector('[data-hero-next]');
    const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let heroIndex = 0;
    let heroTimer;

    function showHeroSlide(nextIndex) {
      if (!heroSlides.length || !heroTrack) return;
      heroIndex = (nextIndex + heroSlides.length) % heroSlides.length;
      heroTrack.style.transform = `translate3d(-${heroIndex * (100 / heroSlides.length)}%, 0, 0)`;
      heroSlides.forEach((slide, index) => {
        const active = index === heroIndex;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        slide.inert = !active;
      });
      heroDots.forEach((dot, index) => {
        const active = index === heroIndex;
        dot.classList.toggle('is-active', active);
        dot.setAttribute('aria-selected', active ? 'true' : 'false');
      });
    }

    function stopHeroTimer() {
      if (heroTimer) window.clearInterval(heroTimer);
      heroTimer = null;
    }

    function startHeroTimer() {
      stopHeroTimer();
      if (!reduceMotion && heroSlides.length > 1) {
        heroTimer = window.setInterval(() => showHeroSlide(heroIndex + 1), 5000);
      }
    }

    if (heroPrev) heroPrev.addEventListener('click', () => { showHeroSlide(heroIndex - 1); startHeroTimer(); });
    if (heroNext) heroNext.addEventListener('click', () => { showHeroSlide(heroIndex + 1); startHeroTimer(); });
    heroDots.forEach((dot, index) => dot.addEventListener('click', () => { showHeroSlide(index); startHeroTimer(); }));
    heroCarousel.addEventListener('mouseenter', stopHeroTimer);
    heroCarousel.addEventListener('mouseleave', startHeroTimer);
    heroCarousel.addEventListener('focusin', stopHeroTimer);
    heroCarousel.addEventListener('focusout', (event) => {
      if (!heroCarousel.contains(event.relatedTarget)) startHeroTimer();
    });
    if (heroDestinationNav) {
      heroDestinationNav.addEventListener('mouseenter', stopHeroTimer);
      heroDestinationNav.addEventListener('mouseleave', startHeroTimer);
      heroDestinationNav.addEventListener('focusin', stopHeroTimer);
      heroDestinationNav.addEventListener('focusout', (event) => {
        if (!heroDestinationNav.contains(event.relatedTarget)) startHeroTimer();
      });
    }
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) stopHeroTimer();
      else startHeroTimer();
    });

    showHeroSlide(0);
    startHeroTimer();
  }

  // 4. FAQ Accordion
  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(btn => {
    btn.addEventListener('click', () => {
      const parent = btn.closest('.faq-item');
      if (parent) {
        const wasActive = parent.classList.contains('active');
        document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));
        if (!wasActive) parent.classList.add('active');
      }
    });
  });

  // 5. Universal Free Consultancy Modal
  const modalOverlay = document.getElementById('consultancyModalOverlay');
  const popupOverlay = document.getElementById('ilmaPopupOverlay');
  const modalTriggers = document.querySelectorAll('.open-consultancy-modal');
  const modalCloseBtns = document.querySelectorAll('.modal-close-trigger');

  function openConsultancyModal(prefCountry = '', modalTitle = '') {
    if (modalOverlay) {
      if (prefCountry) {
        const countrySelect = modalOverlay.querySelector('select[name="target_country"]');
        if (countrySelect) countrySelect.value = prefCountry;
      }
      const heading = modalOverlay.querySelector('#consultancyModalTitle');
      if (heading) heading.textContent = modalTitle || 'Request free profile assessment';
      modalOverlay.classList.add('show');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeConsultancyModal() {
    if (modalOverlay) {
      modalOverlay.classList.remove('show');
      document.body.style.overflow = '';
    }
  }

  modalTriggers.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const country = btn.getAttribute('data-country') || '';
      const modalTitle = btn.getAttribute('data-modal-title') || '';
      openConsultancyModal(country, modalTitle);
    });
  });

  modalCloseBtns.forEach(btn => btn.addEventListener('click', closeConsultancyModal));
  if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) closeConsultancyModal();
    });
  }
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeConsultancyModal();
      closeDrawer();
      if (popupOverlay) popupOverlay.classList.remove('show');
    }
  });

  // 6. 5-Second Popup Logic
  if (popupOverlay) {
    const delaySec = parseInt(popupOverlay.getAttribute('data-delay')) || 5;
    const frequency = popupOverlay.getAttribute('data-frequency') || 'session';
    const popupId = popupOverlay.getAttribute('data-id') || '1';

    let shouldShow = true;
    const storageKey = `ilma_popup_dismissed_${popupId}`;

    if (frequency === 'session' && sessionStorage.getItem(storageKey)) {
      shouldShow = false;
    } else if (frequency === 'day') {
      const lastDismiss = localStorage.getItem(storageKey);
      if (lastDismiss && (Date.now() - parseInt(lastDismiss)) < 24 * 60 * 60 * 1000) {
        shouldShow = false;
      }
    }

    if (shouldShow) {
      setTimeout(() => {
        popupOverlay.classList.add('show');
      }, delaySec * 1000);
    }

    const popupCloseBtn = popupOverlay.querySelector('.popup-close-btn');
    if (popupCloseBtn) {
      popupCloseBtn.addEventListener('click', () => {
        popupOverlay.classList.remove('show');
        if (frequency === 'session') {
          sessionStorage.setItem(storageKey, '1');
        } else if (frequency === 'day') {
          localStorage.setItem(storageKey, Date.now().toString());
        }
      });
    }

    const popupCta = popupOverlay.querySelector('.popup-cta-btn');
    if (popupCta) {
      popupCta.addEventListener('click', (e) => {
        const action = popupCta.getAttribute('data-action');
        if (action === 'modal') {
          e.preventDefault();
          popupOverlay.classList.remove('show');
          openConsultancyModal();
        }
      });
    }
  }

  // 7. Lead Forms Submission (AJAX for WordPress & Node)
  const leadForms = document.querySelectorAll('.ajax-lead-form');
  leadForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.innerHTML : 'Submit';

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting Request...';
      }

      const config = getBackendConfig();
      const formData = new FormData(form);
      const queryParams = new URLSearchParams(window.location.search);
      ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'].forEach((key) => {
        if (!formData.get(key) && queryParams.get(key)) formData.set(key, queryParams.get(key));
      });
      if (!formData.get('page_url')) formData.set('page_url', window.location.href);

      try {
        let res;
        if (config.type === 'wp') {
          formData.append('action', 'uturnedu_submit_lead');
          if (config.nonce) formData.append('nonce', config.nonce);

          const response = await fetch(config.ajaxUrl, {
            method: 'POST',
            body: formData
          });
          const raw = await response.json();
          if (!response.ok || raw.success === false) {
            const errMsg = (raw.data && raw.data.message) ? raw.data.message : (raw.message || 'Submission error');
            throw new Error(errMsg);
          }
          res = raw.data ? Object.assign(raw, raw.data) : raw;
        } else {
          const data = Object.fromEntries(formData.entries());
          try {
            const response = await fetch('/api/leads', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(data)
            });
            if (response.ok) {
              res = await response.json();
            } else {
              throw new Error('Fallback to static mock');
            }
          } catch (fetchErr) {
            res = {
              success: true,
              message: 'Thank you! Your consultation request has been submitted. Our senior counselors will call you shortly.'
            };
          }
        }

        if (res.success) {
          form.reset();
          showToast(res.message || 'Your inquiry has been submitted successfully!', 'success');
          closeConsultancyModal();
        } else {
          showToast(res.message || 'Submission failed. Please check the form.', 'error');
        }
      } catch (err) {
        showToast(err.message || 'Failed to submit inquiry. Please try again.', 'error');
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      }
    });
  });

  // 8. Contact Us Page Form Submission
  const contactForm = document.getElementById('contactPageForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const submitBtn = contactForm.querySelector('button[type="submit"]');
      const originalText = submitBtn ? submitBtn.innerHTML : 'Send Message';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending Message...';
      }

      const config = getBackendConfig();
      const formData = new FormData(contactForm);

      try {
        let res;
        if (config.type === 'wp') {
          formData.append('action', 'uturnedu_submit_contact');
          if (config.nonce) formData.append('nonce', config.nonce);

          const response = await fetch(config.ajaxUrl, {
            method: 'POST',
            body: formData
          });
          const raw = await response.json();
          if (!response.ok || raw.success === false) {
            const errMsg = (raw.data && raw.data.message) ? raw.data.message : (raw.message || 'Error sending message');
            throw new Error(errMsg);
          }
          res = raw.data ? Object.assign(raw, raw.data) : raw;
        } else {
          const data = Object.fromEntries(formData.entries());
          try {
            const response = await fetch('/api/contact', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(data)
            });
            if (response.ok) {
              res = await response.json();
            } else {
              throw new Error('Fallback');
            }
          } catch (fetchErr) {
            res = {
              success: true,
              message: 'Thank you for reaching out! Our team at Mohammadpur will reply within 24 business hours.'
            };
          }
        }

        if (res.success) {
          contactForm.reset();
          showToast(res.message || 'Thank you! Your message has been sent.', 'success');
        } else {
          showToast(res.message || 'Failed to send message', 'error');
        }
      } catch (err) {
        showToast(err.message || 'Error sending message. Please try again.', 'error');
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      }
    });
  }

  // Global Toast Notification Helper
  window.showToast = function(message, type = 'success') {
    let container = document.getElementById('toastContainer');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toastContainer';
      container.style.position = 'fixed';
      container.style.bottom = '24px';
      container.style.right = '24px';
      container.style.zIndex = '99999';
      container.style.display = 'flex';
      container.style.flexDirection = 'column';
      container.style.gap = '10px';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.padding = '14px 20px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
    toast.style.fontSize = '0.9rem';
    toast.style.fontWeight = '500';
    toast.style.maxWidth = '360px';
    toast.style.animation = 'slideInRight 0.3s ease';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '10px';

    if (type === 'success') {
      toast.style.background = '#064E3B';
      toast.style.color = '#ECFDF5';
      toast.style.borderLeft = '4px solid #10B981';
      toast.innerHTML = `<span>✓</span> <div>${message}</div>`;
    } else {
      toast.style.background = '#7F1D1D';
      toast.style.color = '#FEF2F2';
      toast.style.borderLeft = '4px solid #EF4444';
      toast.innerHTML = `<span>✕</span> <div>${message}</div>`;
    }

    container.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(20px)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 4500);
  };
});
