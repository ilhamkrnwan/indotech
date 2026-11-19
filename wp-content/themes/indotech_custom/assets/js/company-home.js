/**
 * Interactive behaviors, liquid transitions & GSAP scroll choreography
 * for Indotech Company Profile Homepage.
 */
(function () {
  'use strict';

  const hasGSAP = typeof window.gsap !== 'undefined';
  const hasScrollTrigger = hasGSAP && typeof window.ScrollTrigger !== 'undefined';
  const hasFlip = hasGSAP && typeof window.Flip !== 'undefined';
  const hasScrollTo = hasGSAP && typeof window.ScrollToPlugin !== 'undefined';

  if (hasGSAP) {
    const plugins = [];
    if (hasScrollTrigger) plugins.push(window.ScrollTrigger);
    if (hasFlip) plugins.push(window.Flip);
    if (hasScrollTo) plugins.push(window.ScrollToPlugin);
    if (plugins.length) window.gsap.registerPlugin.apply(window.gsap, plugins);
  }

  const reducedMotionMQ = window.matchMedia('(prefers-reduced-motion: reduce)');
  const prefersReduced = () => reducedMotionMQ.matches;

  let activeChapterIdx = 0;

  // 1. Hero 4-Slide Liquid Carousel (01-04)
  function initHeroCarousel() {
    const stage = document.querySelector('[data-hero-stage]');
    if (!stage) return;

    const tabs = Array.from(stage.querySelectorAll('[role="tab"]'));
    const slides = Array.from(stage.querySelectorAll('[data-hero-slide]'));
    const card = document.getElementById('ch-stage-card');
    const cardTitle = document.getElementById('ch-stage-card-title');
    const cardCta = document.getElementById('ch-stage-card-cta');
    const cardLink = document.getElementById('ch-stage-card-link');

    if (!tabs.length || !slides.length) return;

    let currentIdx = Math.max(0, tabs.findIndex((t) => t.classList.contains('is-active')));
    let autoplayTween = null;
    let isPaused = false;
    const AUTOPLAY_SEC = 6.5;

    function resetProgressBars() {
      tabs.forEach((t) => {
        const bar = t.querySelector('.ch-tab-progress');
        if (bar && hasGSAP) {
          window.gsap.killTweensOf(bar);
          window.gsap.set(bar, { scaleX: 0 });
        }
      });
    }

    function startAutoplay() {
      if (autoplayTween) {
        autoplayTween.kill();
        autoplayTween = null;
      }
      resetProgressBars();
      if (!hasGSAP || prefersReduced() || isPaused || document.hidden) return;

      const activeBar = tabs[currentIdx] && tabs[currentIdx].querySelector('.ch-tab-progress');
      if (activeBar) {
        autoplayTween = window.gsap.fromTo(
          activeBar,
          { scaleX: 0 },
          {
            scaleX: 1,
            duration: AUTOPLAY_SEC,
            ease: 'none',
            onComplete: () => goToSlide((currentIdx + 1) % tabs.length, 1, false),
          }
        );
      }
    }

    function goToSlide(nextIdx, direction, byUser) {
      const targetIdx = (nextIdx + tabs.length) % tabs.length;
      if (targetIdx === currentIdx) return;

      const prevIdx = currentIdx;
      const dir = direction !== undefined ? direction : (targetIdx > prevIdx ? 1 : -1);
      currentIdx = targetIdx;

      const nextTab = tabs[targetIdx];
      const flipState = hasFlip && !prefersReduced() ? window.Flip.getState(tabs) : null;

      tabs.forEach((btn) => {
        const selected = btn === nextTab;
        btn.classList.toggle('is-active', selected);
        btn.setAttribute('aria-selected', String(selected));
      });

      if (flipState) {
        window.Flip.from(flipState, {
          duration: 0.5,
          ease: 'expo.out',
          nested: true,
        });
      }

      if (card && nextTab.id) card.setAttribute('aria-labelledby', nextTab.id);

      const updateCardContent = () => {
        if (cardTitle) cardTitle.textContent = nextTab.dataset.stageTitle || '';
        if (cardCta) cardCta.textContent = nextTab.dataset.stageCta || '';
        if (cardLink && nextTab.dataset.stageUrl) cardLink.href = nextTab.dataset.stageUrl;
      };

      const incoming = slides[targetIdx];
      const outgoing = slides[prevIdx];
      const incomingImg = incoming ? incoming.querySelector('img') : null;
      const outgoingImg = outgoing ? outgoing.querySelector('img') : null;

      if (hasGSAP && incoming && outgoing) {
        window.gsap.killTweensOf([incoming, outgoing, incomingImg, outgoingImg, cardTitle, cardLink]);

        slides.forEach((s, idx) => {
          if (idx !== targetIdx && idx !== prevIdx) {
            s.classList.remove('is-active');
            window.gsap.set(s, { visibility: 'hidden', zIndex: 1, clearProps: 'clipPath,transform,opacity' });
          }
        });

        outgoing.classList.remove('is-active');
        incoming.classList.add('is-active');

        if (prefersReduced()) {
          window.gsap.set(outgoing, { zIndex: 1, visibility: 'visible', opacity: 1 });
          window.gsap.set(incoming, { zIndex: 2, visibility: 'visible', opacity: 0, clearProps: 'clipPath,transform' });
          window.gsap.to(incoming, {
            opacity: 1,
            duration: 0.2,
            ease: 'power1.out',
            onComplete: () => {
              window.gsap.set(outgoing, { visibility: 'hidden', clearProps: 'opacity,zIndex' });
              window.gsap.set(incoming, { clearProps: 'opacity,zIndex' });
            },
          });
          updateCardContent();
        } else {
          const originX = dir >= 0 ? '100% 50%' : '0% 50%';
          window.gsap.set(outgoing, { zIndex: 1, visibility: 'visible', xPercent: 0, opacity: 1 });
          window.gsap.set(incoming, {
            zIndex: 2,
            visibility: 'visible',
            clipPath: `ellipse(0% 118% at ${originX})`,
            opacity: 1,
          });
          if (incomingImg) window.gsap.set(incomingImg, { scale: 1.09, xPercent: dir * 3 });

          window.gsap.to(incoming, {
            clipPath: 'ellipse(160% 160% at 50% 50%)',
            duration: 0.92,
            ease: 'expo.inOut',
            onComplete: () => {
              window.gsap.set(outgoing, { visibility: 'hidden', clearProps: 'transform,opacity,zIndex' });
              window.gsap.set(incoming, { clearProps: 'clipPath,zIndex' });
            },
          });

          if (incomingImg) {
            window.gsap.to(incomingImg, {
              scale: 1,
              xPercent: 0,
              duration: 0.96,
              ease: 'expo.out',
              clearProps: 'transform',
            });
          }

          window.gsap.to(outgoing, {
            xPercent: -3.5 * dir,
            duration: 0.92,
            ease: 'power3.inOut',
          });
          if (outgoingImg) {
            window.gsap.to(outgoingImg, {
              scale: 1.03,
              duration: 0.92,
              ease: 'power3.inOut',
              clearProps: 'transform',
            });
          }

          updateCardContent();
          if (cardTitle && cardLink) {
            window.gsap.fromTo(
              [cardTitle, cardLink],
              { y: 12, autoAlpha: 0 },
              { y: 0, autoAlpha: 1, duration: 0.44, stagger: 0.05, ease: 'power3.out', clearProps: 'transform,opacity' }
            );
          }
        }
      } else {
        slides.forEach((s, idx) => s.classList.toggle('is-active', idx === targetIdx));
        updateCardContent();
      }

      if (byUser) startAutoplay();
      else startAutoplay();
    }

    tabs.forEach((tab, idx) => {
      tab.addEventListener('click', () => goToSlide(idx, idx >= currentIdx ? 1 : -1, true));
      tab.addEventListener('keydown', (e) => {
        let nextIdx = -1;
        let dir = 1;
        if (e.key === 'ArrowRight') {
          nextIdx = (idx + 1) % tabs.length;
          dir = 1;
        } else if (e.key === 'ArrowLeft') {
          nextIdx = (idx - 1 + tabs.length) % tabs.length;
          dir = -1;
        }
        if (nextIdx >= 0) {
          e.preventDefault();
          goToSlide(nextIdx, dir, true);
          tabs[nextIdx].focus();
        }
      });
    });

    // Horizontal swipe on Hero stage
    let pStartX = 0;
    let pStartY = 0;
    let pTracking = false;

    const clearPointer = () => {
      pTracking = false;
    };

    stage.addEventListener('pointerdown', (e) => {
      if (e.target.closest('button, a')) return;
      pStartX = e.clientX;
      pStartY = e.clientY;
      pTracking = true;
    });

    stage.addEventListener('pointerup', (e) => {
      if (!pTracking) return;
      const dx = e.clientX - pStartX;
      const dy = e.clientY - pStartY;
      clearPointer();
      if (Math.abs(dx) > 42 && Math.abs(dx) > Math.abs(dy) * 1.2) {
        goToSlide(dx < 0 ? currentIdx + 1 : currentIdx - 1, dx < 0 ? 1 : -1, true);
      }
    });

    stage.addEventListener('pointercancel', clearPointer);
    stage.addEventListener('lostpointercapture', clearPointer);

    stage.addEventListener('mouseenter', () => {
      isPaused = true;
      if (autoplayTween) autoplayTween.pause();
    });
    stage.addEventListener('mouseleave', () => {
      isPaused = false;
      if (autoplayTween && !prefersReduced()) autoplayTween.resume();
    });
    stage.addEventListener('focusin', () => {
      isPaused = true;
      if (autoplayTween) autoplayTween.pause();
    });
    stage.addEventListener('focusout', (e) => {
      if (!stage.contains(e.relatedTarget)) {
        isPaused = false;
        if (autoplayTween && !prefersReduced()) autoplayTween.resume();
      }
    });
    document.addEventListener('visibilitychange', () => {
      if (!autoplayTween) return;
      if (document.hidden) autoplayTween.pause();
      else if (!isPaused && !prefersReduced()) autoplayTween.resume();
    });

    startAutoplay();
  }

  // 2. About Capability Thumbnails Synced with Video Poster (Liquid Vertical Wave)
  function initAboutSection() {
    const capBtns = Array.from(document.querySelectorAll('.ch-cap-thumb'));
    const posterSlides = Array.from(document.querySelectorAll('[data-about-slide]'));
    const capLabel = document.getElementById('ch-cap-label');
    const capNote = document.getElementById('ch-cap-note');
    const posterLabel = document.getElementById('ch-poster-label');
    const posterDuration = document.getElementById('ch-poster-duration');

    if (!capBtns.length) return;

    let currentCap = Math.max(0, capBtns.findIndex((b) => b.classList.contains('is-active')));

    capBtns.forEach((btn, idx) => {
      btn.addEventListener('click', () => {
        if (idx === currentCap) return;
        const prevCap = currentCap;
        currentCap = idx;
        activeChapterIdx = idx;

        capBtns.forEach((b) => {
          const active = b === btn;
          b.classList.toggle('is-active', active);
          b.setAttribute('aria-pressed', String(active));
        });

        const nextLabel = btn.dataset.capLabel || '';
        const nextNote = btn.dataset.capNote || '';
        const nextDuration = btn.dataset.capDuration || '';

        if (capLabel) capLabel.textContent = nextLabel;
        if (capNote) capNote.textContent = nextNote;
        if (posterLabel) posterLabel.textContent = nextLabel;
        if (posterDuration && nextDuration) posterDuration.textContent = nextDuration;

        const incoming = posterSlides[idx];
        const outgoing = posterSlides[prevCap];
        const incomingImg = incoming ? incoming.querySelector('img') : null;

        if (hasGSAP && incoming && outgoing) {
          window.gsap.killTweensOf([incoming, outgoing, incomingImg, capLabel, capNote, posterLabel]);

          posterSlides.forEach((s, sIdx) => {
            if (sIdx !== idx && sIdx !== prevCap) {
              s.classList.remove('is-active');
              window.gsap.set(s, { visibility: 'hidden', zIndex: 1, clearProps: 'clipPath,transform,opacity' });
            }
          });

          outgoing.classList.remove('is-active');
          incoming.classList.add('is-active');

          if (prefersReduced()) {
            window.gsap.set(outgoing, { zIndex: 1, visibility: 'visible', opacity: 1 });
            window.gsap.set(incoming, { zIndex: 2, visibility: 'visible', opacity: 0, clearProps: 'clipPath,transform' });
            window.gsap.to(incoming, {
              opacity: 1,
              duration: 0.2,
              onComplete: () => {
                window.gsap.set(outgoing, { visibility: 'hidden', clearProps: 'opacity,zIndex' });
                window.gsap.set(incoming, { clearProps: 'opacity,zIndex' });
              },
            });
          } else {
            window.gsap.set(outgoing, { zIndex: 1, visibility: 'visible', opacity: 1 });
            window.gsap.set(incoming, {
              zIndex: 2,
              visibility: 'visible',
              clipPath: 'ellipse(135% 0% at 50% 0%)',
              opacity: 1,
            });
            if (incomingImg) window.gsap.set(incomingImg, { scale: 1.08 });

            window.gsap.to(incoming, {
              clipPath: 'ellipse(165% 165% at 50% 50%)',
              duration: 0.82,
              ease: 'expo.inOut',
              onComplete: () => {
                window.gsap.set(outgoing, { visibility: 'hidden', clearProps: 'opacity,zIndex' });
                window.gsap.set(incoming, { clearProps: 'clipPath,zIndex' });
              },
            });
            if (incomingImg) {
              window.gsap.to(incomingImg, {
                scale: 1,
                duration: 0.86,
                ease: 'expo.out',
                clearProps: 'transform',
              });
            }

            const textTargets = [capLabel, capNote, posterLabel].filter(Boolean);
            window.gsap.fromTo(
              textTargets,
              { y: 8, autoAlpha: 0 },
              { y: 0, autoAlpha: 1, duration: 0.42, stagger: 0.04, ease: 'power3.out', clearProps: 'transform,opacity' }
            );
          }
        } else if (posterSlides.length) {
          posterSlides.forEach((s, sIdx) => s.classList.toggle('is-active', sIdx === idx));
        }
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

    if (hasGSAP && !prefersReduced()) {
      const dialog = modal.querySelector('.ch-modal-dialog');
      if (dialog) {
        window.gsap.fromTo(
          dialog,
          { y: 20, scale: 0.97, autoAlpha: 0 },
          { y: 0, scale: 1, autoAlpha: 1, duration: 0.36, ease: 'expo.out', clearProps: 'transform,opacity' }
        );
      }
    }

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
  function initVideoModal() {
    const videoModal = document.getElementById('ch-video-modal');
    const videoOpenBtn = document.querySelector('[data-video-open]');
    if (!videoModal || !videoOpenBtn) return;

    const sbSteps = Array.from(videoModal.querySelectorAll('[data-storyboard-step]'));

    const activateChapter = (chapterIndex) => {
      if (!sbSteps.length) return;
      const target = sbSteps[chapterIndex] || sbSteps[0];
      sbSteps.forEach((s) => {
        const active = s === target;
        s.classList.toggle('is-active', active);
        s.setAttribute('aria-selected', String(active));
      });
    };

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
      } else {
        activateChapter(activeChapterIdx);
      }
      openModal(videoModal, videoOpenBtn);
    });

    sbSteps.forEach((step, idx) => {
      step.addEventListener('click', () => activateChapter(idx));
    });
  }

  // 5. Dark Solutions Highlight Switcher
  function initSolutionsSwitcher() {
    const solCards = Array.from(document.querySelectorAll('[data-solution-card]'));
    const solPrev = document.querySelector('[data-solution-prev]');
    const solNext = document.querySelector('[data-solution-next]');
    if (!solCards.length) return;

    let solIdx = 0;
    const renderSol = (next) => {
      solIdx = (next + solCards.length) % solCards.length;
      solCards.forEach((card, i) => card.classList.toggle('is-highlighted', i === solIdx));
    };
    if (solPrev) solPrev.addEventListener('click', () => renderSol(solIdx - 1));
    if (solNext) solNext.addEventListener('click', () => renderSol(solIdx + 1));
  }

  // 6. Customer Stories 3-Card Liquid Right-to-Left FLIP Carousel & Modal
  function initStoriesCarousel() {
    const stage = document.querySelector('[data-stories-stage]');
    const storyModal = document.getElementById('ch-story-modal');
    if (!stage) return;

    const cards = Array.from(stage.querySelectorAll('[data-story-card]'));
    if (cards.length < 3) return;

    const prevBtn = document.querySelector('[data-story-prev]');
    const nextBtn = document.querySelector('[data-story-next]');
    const total = cards.length;
    let leadIdx = 0;
    let isAnimating = false;

    function openStoryModal(card, triggerEl) {
      if (!storyModal || !card) return;
      const mName = storyModal.querySelector('[data-story-modal-name]');
      const mRole = storyModal.querySelector('[data-story-modal-role]');
      const mQuote = storyModal.querySelector('[data-story-modal-quote]');
      const mImg = storyModal.querySelector('[data-story-modal-img]');
      if (mName) mName.textContent = card.dataset.storyName || '';
      if (mRole) mRole.textContent = card.dataset.storyRole || '';
      if (mQuote) mQuote.textContent = '“' + (card.dataset.storyQuote || '') + '”';
      if (mImg) {
        mImg.src = card.dataset.storyImg || '';
        mImg.alt = card.dataset.storyAlt || '';
      }
      openModal(storyModal, triggerEl);
    }

    function rotateStories(nextLead, dir) {
      const targetLead = ((nextLead % total) + total) % total;
      if (targetLead === leadIdx || isAnimating) return;

      const flipState = hasFlip && !prefersReduced()
        ? window.Flip.getState(cards, { props: 'borderRadius' })
        : null;

      leadIdx = targetLead;
      const slot1 = (leadIdx + 1) % total;
      const slot2 = (leadIdx + 2) % total;

      const orderedCards = [cards[leadIdx], cards[slot1], cards[slot2]];
      cards.forEach((c, idx) => {
        if (idx !== leadIdx && idx !== slot1 && idx !== slot2) {
          orderedCards.push(c);
        }
      });

      orderedCards.forEach((card, orderPos) => {
        stage.appendChild(card);
        const isLead = orderPos === 0;
        const isSecondary = orderPos === 1 || orderPos === 2;
        card.classList.toggle('is-featured', isLead);
        card.classList.toggle('is-secondary', isSecondary);
        card.classList.toggle('is-hidden-slot', !isLead && !isSecondary);

        const openBtn = card.querySelector('[data-story-open]');
        const selectBtn = card.querySelector('[data-story-promote]');
        if (openBtn) openBtn.hidden = !isLead;
        if (selectBtn) selectBtn.hidden = !isSecondary;
      });

      const featuredCard = cards[leadIdx];

      if (flipState) {
        isAnimating = true;
        window.Flip.from(flipState, {
          duration: 0.78,
          ease: 'expo.inOut',
          nested: true,
          prune: true,
          onEnter: (els) =>
            window.gsap.fromTo(
              els,
              { autoAlpha: 0, x: dir * 56, scale: 0.94 },
              {
                autoAlpha: 1,
                x: 0,
                scale: 1,
                duration: 0.68,
                ease: 'expo.out',
                clearProps: 'transform,opacity',
              }
            ),
          onComplete: () => {
            isAnimating = false;
          },
        });

        const featuredImg = featuredCard.querySelector('.ch-story-img');
        const featuredOverlay = featuredCard.querySelector('.ch-story-overlay');
        if (featuredImg) {
          window.gsap.fromTo(
            featuredImg,
            { scale: 1.09, filter: 'grayscale(100%) contrast(1.06)' },
            {
              scale: 1,
              filter: 'grayscale(0%) contrast(1)',
              duration: 0.85,
              ease: 'expo.out',
              clearProps: 'transform,filter',
            }
          );
        }
        if (featuredOverlay) {
          window.gsap.fromTo(
            featuredOverlay,
            { y: 14, autoAlpha: 0 },
            {
              y: 0,
              autoAlpha: 1,
              duration: 0.48,
              delay: 0.14,
              ease: 'power3.out',
              clearProps: 'transform,opacity',
            }
          );
        }
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', () => rotateStories(leadIdx - 1, -1));
    }
    if (nextBtn) {
      nextBtn.addEventListener('click', () => rotateStories(leadIdx + 1, 1));
    }

    cards.forEach((card, cardIdx) => {
      const promoteBtn = card.querySelector('[data-story-promote]');
      const openBtn = card.querySelector('[data-story-open]');
      if (promoteBtn) {
        promoteBtn.addEventListener('click', () => rotateStories(cardIdx, 1));
      }
      if (openBtn) {
        openBtn.addEventListener('click', () => openStoryModal(card, openBtn));
      }
    });

    // Horizontal pointer swipe on Kisah Mitra stage
    let sStartX = 0;
    let sStartY = 0;
    let sTracking = false;

    const resetSwipe = () => {
      sTracking = false;
    };

    stage.addEventListener('pointerdown', (e) => {
      if (e.target.closest('.ch-story-open')) return;
      sStartX = e.clientX;
      sStartY = e.clientY;
      sTracking = true;
    });

    stage.addEventListener('pointerup', (e) => {
      if (!sTracking) return;
      const dx = e.clientX - sStartX;
      const dy = e.clientY - sStartY;
      resetSwipe();
      if (Math.abs(dx) > 42 && Math.abs(dx) > Math.abs(dy) * 1.2) {
        rotateStories(dx < 0 ? leadIdx + 1 : leadIdx - 1, dx < 0 ? 1 : -1);
      }
    });

    stage.addEventListener('pointercancel', resetSwipe);
    stage.addEventListener('lostpointercapture', resetSwipe);
  }

  // 7. Footer Quick WhatsApp B2B Form
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

  // 8. GSAP Smooth Anchor Scroll & ScrollTrigger Choreography
  function initSmoothScrollAndChoreography() {
    if (!hasGSAP) return;

    // Smooth anchor scrolling across homepage links
    const header = document.getElementById('site-header');
    document.querySelectorAll('.indotech-company-home a[href*="#"]').forEach((anchor) => {
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
        const offset = (header ? header.offsetHeight : 72) + 16;

        if (hasScrollTo && !prefersReduced()) {
          window.gsap.to(window, {
            duration: 0.85,
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
    const scopeEl = document.querySelector('.ch-main') || document.body;

    mm.add('(prefers-reduced-motion: no-preference)', () => {
      const ctx = window.gsap.context(() => {
        // Hero crisp arrival (never hides stage media LCP)
        window.gsap.from('.ch-hero-h1 .ch-h1-primary, .ch-hero-h1 .ch-h1-secondary, .ch-tilt-badge', {
          y: 22,
          opacity: 0,
          duration: 0.68,
          stagger: 0.08,
          ease: 'expo.out',
          clearProps: 'transform,opacity',
        });

        window.gsap.from('.ch-hero-copy, .ch-hero-aside, .ch-stage-card', {
          y: 18,
          opacity: 0,
          duration: 0.62,
          stagger: 0.08,
          delay: 0.12,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
        });

        // Subtle continuous scrub parallax on Hero slides
        window.gsap.to('.ch-hero-slides', {
          yPercent: 6,
          ease: 'none',
          scrollTrigger: {
            trigger: '.ch-hero-stage',
            start: 'top top',
            end: 'bottom top',
            scrub: 0.7,
          },
        });

        // Section 2: Tentang Kami & overlapping poster parallax
        window.gsap.from('#ch-about-title, .ch-cap-thumb, .ch-cap-caption', {
          y: 22,
          opacity: 0,
          duration: 0.6,
          stagger: 0.06,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
          scrollTrigger: {
            trigger: '.ch-about',
            start: 'top 86%',
            once: true,
          },
        });

        if (window.innerWidth > 960) {
          window.gsap.fromTo(
            '.ch-about-media-wrap',
            { y: 18 },
            {
              y: -18,
              ease: 'none',
              scrollTrigger: {
                trigger: '.ch-about-grid',
                start: 'top 85%',
                end: 'bottom 20%',
                scrub: 0.85,
              },
            }
          );
        }

        // KPI smooth numerical count-up
        document.querySelectorAll('[data-kpi-target]').forEach((el) => {
          const raw = el.dataset.kpiTarget || '';
          const numeric = parseInt(raw.replace(/\./g, ''), 10);
          if (!Number.isFinite(numeric)) return;
          const accentEl = el.querySelector('span');
          const accentText = accentEl ? accentEl.textContent : '';
          const usesDots = raw.includes('.');
          const counter = { val: 0 };

          window.gsap.to(counter, {
            val: numeric,
            duration: 1.15,
            ease: 'power2.out',
            scrollTrigger: {
              trigger: el,
              start: 'top 90%',
              once: true,
            },
            onUpdate: () => {
              const rounded = Math.round(counter.val);
              const formatted = usesDots ? rounded.toLocaleString('id-ID') : String(rounded);
              if (accentEl) {
                el.firstChild.nodeValue = formatted;
                if (el.firstChild !== accentEl && el.childNodes.length === 1) {
                  el.textContent = formatted;
                }
              } else {
                el.textContent = formatted;
              }
            },
            onComplete: () => {
              if (accentEl) {
                el.textContent = raw;
                const span = document.createElement('span');
                span.textContent = accentText;
                el.appendChild(span);
              } else {
                el.textContent = raw;
              }
            },
          });
        });

        // Section 3A: Dark Solutions block & cards
        window.gsap.from('.ch-solutions-dark', {
          y: 26,
          scale: 0.985,
          duration: 0.68,
          ease: 'power3.out',
          clearProps: 'transform',
          scrollTrigger: {
            trigger: '.ch-solutions-band',
            start: 'top 88%',
            once: true,
          },
        });

        window.gsap.from('.ch-solution-card', {
          y: 20,
          opacity: 0,
          duration: 0.56,
          stagger: 0.08,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
          scrollTrigger: {
            trigger: '.ch-solutions-grid',
            start: 'top 86%',
            once: true,
          },
        });

        // Section 3B: 7 Brands staggered rows
        window.gsap.from('.ch-brand-row', {
          y: 16,
          opacity: 0,
          duration: 0.48,
          stagger: 0.045,
          ease: 'power2.out',
          clearProps: 'transform,opacity',
          scrollTrigger: {
            trigger: '.ch-brand-grid',
            start: 'top 88%',
            once: true,
          },
        });

        // Section 4: Kisah Mitra stage entrance
        window.gsap.from('.ch-stories-head, .ch-stories-stage', {
          y: 24,
          opacity: 0,
          duration: 0.64,
          stagger: 0.1,
          ease: 'power3.out',
          clearProps: 'transform,opacity',
          scrollTrigger: {
            trigger: '.ch-stories',
            start: 'top 86%',
            once: true,
          },
        });

        // Section 5: Insights & FAQ
        window.gsap.from('.ch-article-item, .ch-faq-item', {
          y: 14,
          opacity: 0,
          duration: 0.46,
          stagger: 0.045,
          ease: 'power2.out',
          clearProps: 'transform,opacity',
          scrollTrigger: {
            trigger: '.ch-insights',
            start: 'top 88%',
            once: true,
          },
        });

        // Section 6: Orbital CTA subtle scrub rotation & counter-parallax
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

        if (window.innerWidth > 960) {
          window.gsap.fromTo(
            '.ch-orbital-photo--tr',
            { y: 20 },
            {
              y: -22,
              ease: 'none',
              scrollTrigger: {
                trigger: '.ch-orbital-cta',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.9,
              },
            }
          );

          window.gsap.fromTo(
            '.ch-orbital-photo--bl',
            { y: -16 },
            {
              y: 24,
              ease: 'none',
              scrollTrigger: {
                trigger: '.ch-orbital-cta',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.9,
              },
            }
          );
        }
      }, scopeEl);

      return () => ctx.revert();
    });

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(() => window.ScrollTrigger.refresh());
    }
    window.addEventListener('load', () => window.ScrollTrigger.refresh(), { once: true });
  }

  initHeroCarousel();
  initAboutSection();
  initVideoModal();
  initSolutionsSwitcher();
  initStoriesCarousel();
  initFooterWaForm();
  initSmoothScrollAndChoreography();
})();
