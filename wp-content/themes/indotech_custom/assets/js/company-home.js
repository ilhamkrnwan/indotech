/**
 * Interactive behaviors for Indotech Company Profile Homepage.
 */
(function () {
  'use strict';

  // 1. Hero Process Stage Tabs (01-04)
  const stage = document.querySelector('[data-hero-stage]');
  if (stage) {
    const tabs = Array.from(stage.querySelectorAll('[role="tab"]'));
    const card = document.getElementById('ch-stage-card');
    const cardTitle = document.getElementById('ch-stage-card-title');
    const cardCta = document.getElementById('ch-stage-card-cta');
    const cardLink = document.getElementById('ch-stage-card-link');

    function activateStage(tab) {
      tabs.forEach((btn) => {
        const selected = btn === tab;
        btn.classList.toggle('is-active', selected);
        btn.setAttribute('aria-selected', String(selected));
      });
      if (card && tab.id) card.setAttribute('aria-labelledby', tab.id);
      if (cardTitle) cardTitle.textContent = tab.dataset.stageTitle || '';
      if (cardCta) cardCta.textContent = tab.dataset.stageCta || '';
      if (cardLink && tab.dataset.stageUrl) cardLink.href = tab.dataset.stageUrl;
    }

    tabs.forEach((tab, idx) => {
      tab.addEventListener('click', () => activateStage(tab));
      tab.addEventListener('keydown', (e) => {
        let nextIdx = -1;
        if (e.key === 'ArrowRight') nextIdx = (idx + 1) % tabs.length;
        if (e.key === 'ArrowLeft') nextIdx = (idx - 1 + tabs.length) % tabs.length;
        if (nextIdx >= 0) {
          e.preventDefault();
          activateStage(tabs[nextIdx]);
          tabs[nextIdx].focus();
        }
      });
    });
  }

  // 2. About Capability Thumbnails
  const capBtns = Array.from(document.querySelectorAll('.ch-cap-thumb'));
  const capLabel = document.getElementById('ch-cap-label');
  const capNote = document.getElementById('ch-cap-note');
  if (capBtns.length) {
    capBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        capBtns.forEach((b) => {
          const active = b === btn;
          b.classList.toggle('is-active', active);
          b.setAttribute('aria-pressed', String(active));
        });
        if (capLabel) capLabel.textContent = btn.dataset.capLabel || '';
        if (capNote) capNote.textContent = btn.dataset.capNote || '';
      });
    });
  }

  // 3. Shared Modal Helpers
  let activeModal = null;
  let lastTrigger = null;

  function closeModal(modal) {
    if (!modal) return;
    modal.hidden = true;
    document.body.style.overflow = '';
    const embedMount = modal.querySelector('#ch-video-embed-mount');
    if (embedMount) embedMount.innerHTML = '';
    if (lastTrigger && typeof lastTrigger.focus === 'function') {
      lastTrigger.focus();
    }
    activeModal = null;
    lastTrigger = null;
  }

  function openModal(modal, triggerEl) {
    if (!modal) return;
    lastTrigger = triggerEl || document.activeElement;
    activeModal = modal;
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    const closeBtn = modal.querySelector('[data-modal-close].ch-modal-close') || modal.querySelector('button, a');
    if (closeBtn) closeBtn.focus();
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && activeModal) {
      closeModal(activeModal);
    }
  });

  document.querySelectorAll('.ch-modal').forEach((modal) => {
    modal.querySelectorAll('[data-modal-close]').forEach((closer) => {
      closer.addEventListener('click', () => closeModal(modal));
    });
  });

  // 4. Video Profile Lightbox & Storyboard Tabs
  const videoModal = document.getElementById('ch-video-modal');
  const videoOpenBtn = document.querySelector('[data-video-open]');
  if (videoModal && videoOpenBtn) {
    videoOpenBtn.addEventListener('click', () => {
      const type = videoModal.dataset.videoType || 'none';
      const src = videoModal.dataset.videoSrc || '';
      const mount = document.getElementById('ch-video-embed-mount');
      if (mount && src) {
        if (type === 'iframe') {
          const iframe = document.createElement('iframe');
          iframe.src = src;
          iframe.title = 'Video Profil PT Indotech Berkah Abadi';
          iframe.allow = 'autoplay; fullscreen; picture-in-picture';
          iframe.allowFullscreen = true;
          mount.replaceChildren(iframe);
        } else if (type === 'video') {
          const video = document.createElement('video');
          video.src = src;
          video.controls = true;
          video.autoplay = true;
          video.playsInline = true;
          mount.replaceChildren(video);
        }
      }
      openModal(videoModal, videoOpenBtn);
    });

    const sbSteps = Array.from(videoModal.querySelectorAll('[data-storyboard-step]'));
    sbSteps.forEach((step) => {
      step.addEventListener('click', () => {
        sbSteps.forEach((s) => {
          const active = s === step;
          s.classList.toggle('is-active', active);
          s.setAttribute('aria-selected', String(active));
        });
      });
    });
  }

  // 5. Dark Solutions Highlight Switcher
  const solCards = Array.from(document.querySelectorAll('[data-solution-card]'));
  const solPrev = document.querySelector('[data-solution-prev]');
  const solNext = document.querySelector('[data-solution-next]');
  if (solCards.length) {
    let solIdx = 0;
    const renderSol = (next) => {
      solIdx = (next + solCards.length) % solCards.length;
      solCards.forEach((card, i) => card.classList.toggle('is-highlighted', i === solIdx));
    };
    if (solPrev) solPrev.addEventListener('click', () => renderSol(solIdx - 1));
    if (solNext) solNext.addEventListener('click', () => renderSol(solIdx + 1));
  }

  // 6. Customer Stories 3-Card Asymmetric Carousel & Modal
  const storiesStage = document.querySelector('[data-stories-stage]');
  const storyModal = document.getElementById('ch-story-modal');
  if (storiesStage && storiesStage.dataset.stories) {
    let stories = [];
    try {
      stories = JSON.parse(storiesStage.dataset.stories);
    } catch (_) {
      stories = [];
    }

    if (stories.length >= 3) {
      let leadIdx = 0;
      const slots = Array.from(storiesStage.querySelectorAll('[data-story-slot]'));
      const prevBtn = document.querySelector('[data-story-prev]');
      const nextBtn = document.querySelector('[data-story-next]');

      const renderStories = () => {
        slots.forEach((card, slotPos) => {
          const data = stories[(leadIdx + slotPos) % stories.length];
          const img = card.querySelector('.ch-story-img');
          const name = card.querySelector('.ch-story-name');
          const role = card.querySelector('.ch-story-role');
          if (img) {
            img.src = data.image;
            img.alt = data.alt;
          }
          if (name) name.textContent = data.name;
          if (role) role.textContent = data.role;

          const openBtn = card.querySelector('[data-story-open]');
          if (openBtn) openBtn.setAttribute('aria-label', 'Baca cerita lengkap ' + data.name);
          const promBtn = card.querySelector('[data-story-promote]');
          if (promBtn) promBtn.setAttribute('aria-label', 'Tampilkan kisah ' + data.name);
        });
      };

      if (prevBtn) prevBtn.addEventListener('click', () => {
        leadIdx = (leadIdx - 1 + stories.length) % stories.length;
        renderStories();
      });
      if (nextBtn) nextBtn.addEventListener('click', () => {
        leadIdx = (leadIdx + 1) % stories.length;
        renderStories();
      });

      slots.forEach((card) => {
        const promote = card.querySelector('[data-story-promote]');
        if (promote) {
          promote.addEventListener('click', () => {
            const offset = parseInt(promote.dataset.storyPromote || '1', 10);
            leadIdx = (leadIdx + offset) % stories.length;
            renderStories();
          });
        }
        const openTrigger = card.querySelector('[data-story-open]');
        if (openTrigger && storyModal) {
          openTrigger.addEventListener('click', () => {
            const current = stories[leadIdx];
            const mName = storyModal.querySelector('[data-story-modal-name]');
            const mRole = storyModal.querySelector('[data-story-modal-role]');
            const mQuote = storyModal.querySelector('[data-story-modal-quote]');
            const mImg = storyModal.querySelector('[data-story-modal-img]');
            if (mName) mName.textContent = current.name;
            if (mRole) mRole.textContent = current.role;
            if (mQuote) mQuote.textContent = '“' + current.quote + '”';
            if (mImg) {
              mImg.src = current.image;
              mImg.alt = current.alt;
            }
            openModal(storyModal, openTrigger);
          });
        }
      });
    }
  }

  // 7. Footer Quick WhatsApp B2B Form
  const waForm = document.getElementById('ch-footer-wa-form');
  if (waForm) {
    const input = document.getElementById('ch-footer-topic');
    const status = document.getElementById('ch-footer-form-msg');
    waForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const val = (input ? input.value : '').trim();
      if (!val) {
        if (status) status.textContent = 'Silakan tulis kebutuhan B2B atau nama usaha Anda terlebih dahulu.';
        if (input) input.focus();
        return;
      }
      const waNumber = waForm.dataset.waNumber || '6287885590088';
      const msg = encodeURIComponent('Halo Indotech, saya ingin berkonsultasi mengenai: ' + val);
      if (status) status.textContent = 'Membuka WhatsApp tim B2B Indotech...';
      window.open('https://wa.me/' + waNumber + '?text=' + msg, '_blank', 'noopener');
    });
  }
})();
