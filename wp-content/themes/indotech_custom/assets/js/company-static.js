/**
 * Indotech Static Templates — Shared Interactions, Quick WhatsApp Footer & GSAP Smooth Choreography
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

  function revealAllFallback() {
    document.querySelectorAll('.indotech-static-page .reveal').forEach((el) => {
      el.classList.add('visible');
    });
  }

  function initSmoothScrollAndChoreography() {
    revealAllFallback();
    if (!hasGSAP) return;

    if (hasScrollTrigger && hasScrollTo) {
      window.gsap.registerPlugin(window.ScrollTrigger, window.ScrollToPlugin);
    } else if (hasScrollTrigger) {
      window.gsap.registerPlugin(window.ScrollTrigger);
    } else if (hasScrollTo) {
      window.gsap.registerPlugin(window.ScrollToPlugin);
    }

    const header = document.getElementById('site-header');
    document.querySelectorAll('.indotech-static-page a[href*="#"]').forEach((anchor) => {
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
        const offset = (header ? header.offsetHeight : 72) + 20;

        if (hasScrollTo && !prefersReduced()) {
          window.gsap.to(window, {
            duration: 0.8,
            scrollTo: { y: target, offsetY: offset, autoKill: true },
            ease: 'power3.inOut',
          });
        } else {
          target.scrollIntoView({ behavior: 'auto', block: 'start' });
        }
      });
    });

    if (!hasScrollTrigger) return;
    window.ScrollTrigger.config({ limitCallbacks: true });

    const mm = window.gsap.matchMedia();
    const scopeEl = document.getElementById('main-content') || document.body;

    mm.add('(prefers-reduced-motion: no-preference)', () => {
      const ctx = window.gsap.context(() => {
        window.gsap.from('.inner-page-hero-inner > *, .page-hero > .container > *, .ch-404-card', {
          y: 18,
          opacity: 0,
          duration: 0.56,
          stagger: 0.06,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
        });

        const cardGroups = [
          '.values-grid .value-card',
          '.applications-grid .premium-app-card',
          '.services-grid .service-card',
          '.partner-steps .partner-step',
          '.contact-cards-grid .contact-info-card',
          '.about-cert-grid .cert-card',
          '#blog-posts-grid .blog-card',
          '.visi-misi-grid .visi-card',
        ];

        cardGroups.forEach((selector) => {
          const nodes = scopeEl.querySelectorAll(selector);
          if (!nodes.length) return;
          window.gsap.from(nodes, {
            y: 18,
            opacity: 0,
            duration: 0.48,
            stagger: 0.06,
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
  initSmoothScrollAndChoreography();
})();
