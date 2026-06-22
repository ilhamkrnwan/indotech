/**
 * Indotech Custom Theme — Main JS
 */
(function () {
  'use strict';

  // ── Sticky Header ───────────────────────────────────────
  const header = document.getElementById('site-header');
  if (header) {
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
      const scroll = window.scrollY;
      header.classList.toggle('scrolled', scroll > 20);
      lastScroll = scroll;
    }, { passive: true });
  }

  // ── Mobile Menu ─────────────────────────────────────────
  const toggle = document.getElementById('menu-toggle');
  const nav    = document.getElementById('primary-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      toggle.classList.toggle('active', open);
      toggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on link click
    nav.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        nav.classList.remove('open');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!header.contains(e.target) && nav.classList.contains('open')) {
        nav.classList.remove('open');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  // ── Scroll Reveal ───────────────────────────────────────
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach(el => io.observe(el));
  }

  // ── Auto Reveal on sections ─────────────────────────────
  const sections = document.querySelectorAll(
    '.stat-item, .brand-card, .service-card, .testimonial-card, .blog-card, .why-item, .why-card'
  );

  if (sections.length && 'IntersectionObserver' in window) {
    sections.forEach(el => el.classList.add('reveal'));

    const sectionIO = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          sectionIO.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });

    sections.forEach(el => sectionIO.observe(el));
  }

  // ── Active Nav Link on Scroll ───────────────────────────
  const navLinks = document.querySelectorAll('.nav-menu a');
  const sectionTargets = document.querySelectorAll('section[id]');

  if (navLinks.length && sectionTargets.length) {
    const navIO = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute('id');
          navLinks.forEach(link => {
            link.parentElement.classList.toggle(
              'current-menu-item',
              link.getAttribute('href') === `#${id}` || link.getAttribute('href')?.endsWith(`/${id}`)
            );
          });
        }
      });
    }, { threshold: 0.5 });

    sectionTargets.forEach(s => navIO.observe(s));
  }

  // ── Smooth scroll for anchor links ─────────────────────
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-h')) || 72;
        window.scrollTo({
          top: target.getBoundingClientRect().top + window.scrollY - offset,
          behavior: 'smooth',
        });
      }
    });
  });

})();
