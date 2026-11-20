/**
 * Indotech Static Templates — Manufy Interactions, Video Modal, Legal Progress & GSAP Choreography
 */
(function () {
  'use strict';

  const hasGSAP = typeof window.gsap !== 'undefined';
  const hasScrollTrigger = typeof window.ScrollTrigger !== 'undefined';
  const hasScrollTo = typeof window.ScrollToPlugin !== 'undefined';
  const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
  const prefersReduced = () => reducedMotionQuery.matches;

  function initFooterWaForm() {
    const waForm = document.getElementById('ch-footer-wa-form');
    if (!waForm) return;

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

  function initStaticVideoModal() {
    const modal = document.getElementById('ch-video-modal');
    const triggers = document.querySelectorAll('[data-video-open]');
    if (!modal || !triggers.length) return;

    let lastTrigger = null;
    const sbSteps = Array.from(modal.querySelectorAll('[data-storyboard-step]'));

    const activateChapter = (index) => {
      if (!sbSteps.length) return;
      const target = sbSteps[index] || sbSteps[0];
      sbSteps.forEach((step) => {
        const active = step === target;
        step.classList.toggle('is-active', active);
        step.setAttribute('aria-selected', String(active));
      });
    };

    const closeModal = () => {
      modal.hidden = true;
      document.body.style.overflow = '';
      const mount = document.getElementById('ch-video-embed-mount');
      if (mount) mount.innerHTML = '';
      if (lastTrigger && typeof lastTrigger.focus === 'function') {
        lastTrigger.focus();
      }
      lastTrigger = null;
    };

    const openModal = (triggerEl) => {
      lastTrigger = triggerEl;
      const type = modal.dataset.videoType || 'none';
      const src = modal.dataset.videoSrc || '';
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
      } else {
        activateChapter(0);
      }

      modal.hidden = false;
      document.body.style.overflow = 'hidden';

      if (hasGSAP && !prefersReduced()) {
        const dialog = modal.querySelector('.ch-modal-dialog');
        if (dialog) {
          window.gsap.fromTo(
            dialog,
            { y: 18, scale: 0.97, opacity: 0 },
            { y: 0, scale: 1, opacity: 1, duration: 0.34, ease: 'expo.out', clearProps: 'transform,opacity' }
          );
        }
      }

      const closeBtn = modal.querySelector('[data-modal-close].ch-modal-close') || modal.querySelector('button, a');
      if (closeBtn) closeBtn.focus();
    };

    triggers.forEach((btn) => btn.addEventListener('click', () => openModal(btn)));
    modal.querySelectorAll('[data-modal-close]').forEach((el) => el.addEventListener('click', closeModal));
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modal.hidden) closeModal();
    });
    sbSteps.forEach((step, idx) => step.addEventListener('click', () => activateChapter(idx)));
  }

  function initFormPreselectors(scrollToTarget) {
    const partnerSelect = document.getElementById('partner-type');
    const partnerButtons = document.querySelectorAll('[data-select-partner]');
    if (partnerSelect && partnerButtons.length) {
      partnerButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
          const val = btn.getAttribute('data-select-partner') || '';
          partnerSelect.value = val;
          document.querySelectorAll('.cs-scheme-card').forEach((card) => {
            card.classList.toggle('is-selected', card.contains(btn));
          });
          const formWrap = document.getElementById('form-kemitraan');
          if (formWrap) scrollToTarget(formWrap);
          const nameInput = document.getElementById('partner-name');
          if (nameInput) nameInput.focus({ preventScroll: true });
        });
      });
    }

    const subjectSelect = document.getElementById('kontak-subject');
    const subjectChips = document.querySelectorAll('[data-select-subject]');
    if (subjectSelect && subjectChips.length) {
      subjectChips.forEach((chip) => {
        chip.addEventListener('click', () => {
          const val = chip.getAttribute('data-select-subject') || '';
          subjectSelect.value = val;
          subjectChips.forEach((c) => c.classList.toggle('is-active', c === chip));
          const nameInput = document.getElementById('kontak-name');
          if (nameInput) nameInput.focus({ preventScroll: true });
        });
      });
      subjectSelect.addEventListener('change', () => {
        subjectChips.forEach((c) => c.classList.toggle('is-active', c.getAttribute('data-select-subject') === subjectSelect.value));
      });
    }
  }

  function initLegalToc() {
    const article = document.getElementById('legal-article');
    const tocLinks = Array.from(document.querySelectorAll('.cs-toc-link'));
    const progressBar = document.querySelector('[data-legal-progress]');
    if (!article || (!tocLinks.length && !progressBar)) return;

    const headings = Array.from(article.querySelectorAll('h2, h3')).filter((h) => h.id);

    const onScroll = () => {
      if (progressBar) {
        const rect = article.getBoundingClientRect();
        const total = Math.max(1, article.offsetHeight - window.innerHeight * 0.4);
        const passed = Math.min(total, Math.max(0, -rect.top + 140));
        const pct = Math.min(100, Math.round((passed / total) * 100));
        progressBar.style.width = pct + '%';
      }

      if (tocLinks.length && headings.length) {
        const scrollY = window.scrollY + 150;
        let current = headings[0];
        for (const heading of headings) {
          if (heading.offsetTop <= scrollY) current = heading;
        }
        const activeId = current ? current.id : '';
        tocLinks.forEach((link) => {
          const targetId = (link.getAttribute('href') || '').replace('#', '');
          link.classList.toggle('active', targetId === activeId);
        });
      }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  function revealAllFallback() {
    document.querySelectorAll('.indotech-static-page .reveal').forEach((el) => {
      el.classList.add('visible');
    });
  }

  function initSmoothScrollAndChoreography() {
    revealAllFallback();

    const header = document.getElementById('site-header');
    const scrollToTarget = (target) => {
      if (!target) return;
      const offset = (header ? header.offsetHeight : 72) + 20;
      if (hasGSAP && hasScrollTo && !prefersReduced()) {
        window.gsap.to(window, {
          duration: 0.78,
          scrollTo: { y: target, offsetY: offset, autoKill: true },
          ease: 'power3.inOut',
        });
      } else {
        target.scrollIntoView({ behavior: prefersReduced() ? 'auto' : 'smooth', block: 'start' });
      }
    };

    initFormPreselectors(scrollToTarget);

    if (!hasGSAP) return;
    if (hasScrollTrigger && hasScrollTo) {
      window.gsap.registerPlugin(window.ScrollTrigger, window.ScrollToPlugin);
    } else if (hasScrollTrigger) {
      window.gsap.registerPlugin(window.ScrollTrigger);
    } else if (hasScrollTo) {
      window.gsap.registerPlugin(window.ScrollToPlugin);
    }

    document.querySelectorAll('.cs-main a[href*="#"]').forEach((anchor) => {
      anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href') || '';
        const hashIdx = href.indexOf('#');
        if (hashIdx === -1) return;
        const hash = href.slice(hashIdx + 1);
        if (!hash) return;

        let samePage = href.startsWith('#');
        if (!samePage) {
          try {
            const url = new URL(href, window.location.href);
            samePage = url.origin === window.location.origin && url.pathname.replace(/\/+$/, '') === window.location.pathname.replace(/\/+$/, '');
          } catch (_) {
            samePage = false;
          }
        }
        if (!samePage) return;

        const target = document.getElementById(hash);
        if (!target) return;

        e.preventDefault();
        scrollToTarget(target);
      });
    });

    if (!hasScrollTrigger) return;
    window.ScrollTrigger.config({ limitCallbacks: true });

    const mm = window.gsap.matchMedia();
    const scopeEl = document.getElementById('main-content') || document.body;

    mm.add('(prefers-reduced-motion: no-preference)', () => {
      const ctx = window.gsap.context(() => {
        window.gsap.from('.cs-hero-copy, .cs-hero-title-group, .cs-404-main, .cs-404-directory', {
          y: 18,
          opacity: 0,
          duration: 0.56,
          stagger: 0.06,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
        });

        const groups = [
          '.cs-ledger-list .cs-ledger-row',
          '.cs-cert-columns .cs-cert-item',
          '.cs-hairline-matrix .cs-hairline-cell',
          '.cs-editorial-grid .cs-item',
          '.cs-usp-ledger .cs-usp-cell',
          '.cs-app-grid .cs-app-card',
          '.cs-dark-cols-3 .cs-dark-col',
          '.cs-process-rail .cs-process-step',
          '.cs-scheme-grid .cs-scheme-card',
          '.cs-contact-ledger .cs-ledger-cell',
          '#blog-posts-grid .blog-card',
        ];

        groups.forEach((selector) => {
          const nodes = scopeEl.querySelectorAll(selector);
          if (!nodes.length) return;
          window.gsap.from(nodes, {
            y: 18,
            opacity: 0,
            duration: 0.48,
            stagger: 0.055,
            ease: 'power2.out',
            clearProps: 'transform,opacity',
            scrollTrigger: {
              trigger: nodes[0].parentElement || nodes[0],
              start: 'top 88%',
              once: true,
            },
          });
        });

        if (scopeEl.querySelector('.ch-orbital-cta')) {
          window.gsap.to('.ch-orbit-ring--inner', {
            rotation: 18,
            ease: 'none',
            scrollTrigger: {
              trigger: '.ch-orbital-cta',
              start: 'top bottom',
              end: 'bottom top',
              scrub: 0.9,
            },
          });
          window.gsap.to('.ch-orbit-ring--outer', {
            rotation: -14,
            ease: 'none',
            scrollTrigger: {
              trigger: '.ch-orbital-cta',
              start: 'top bottom',
              end: 'bottom top',
              scrub: 0.9,
            },
          });
        }
      }, scopeEl);

      return () => ctx.revert();
    });

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(() => window.ScrollTrigger.refresh());
    }
    window.addEventListener('load', () => window.ScrollTrigger.refresh(), { once: true });
  }

  initFooterWaForm();
  initStaticVideoModal();
  initLegalToc();
  initSmoothScrollAndChoreography();
})();
