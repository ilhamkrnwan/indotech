/**
 * Depocleanique Custom — main.js
 * Interaksi UI: mobile menu, scroll-to-top, sticky header, FAQ accordion.
 */

document.addEventListener("DOMContentLoaded", function () {
  /* ─── Mobile Menu ─────────────────────────────────── */
  const menuToggle = document.getElementById("mobile-menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");
  const iconHamburger = document.getElementById("icon-hamburger");
  const iconClose = document.getElementById("icon-close");

  function openMobileMenu() {
    if (!menuToggle || !mobileMenu) {
      return;
    }

    mobileMenu.classList.remove("hidden");
    mobileMenu.classList.add("is-open");
    menuToggle.setAttribute("aria-expanded", "true");

    if (iconHamburger) {
      iconHamburger.classList.add("hidden");
    }

    if (iconClose) {
      iconClose.classList.remove("hidden");
    }
  }

  function closeMobileMenu() {
    if (!menuToggle || !mobileMenu) {
      return;
    }

    mobileMenu.classList.add("hidden");
    mobileMenu.classList.remove("is-open");
    menuToggle.setAttribute("aria-expanded", "false");

    if (iconHamburger) {
      iconHamburger.classList.remove("hidden");
    }

    if (iconClose) {
      iconClose.classList.add("hidden");
    }
  }

  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener("click", function () {
      const isOpen = !mobileMenu.classList.contains("hidden");
      isOpen ? closeMobileMenu() : openMobileMenu();
    });

    // Tutup menu saat link diklik
    mobileMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", closeMobileMenu);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeMobileMenu();
      }
    });

    document.addEventListener("click", function (event) {
      const isOpen = !mobileMenu.classList.contains("hidden");
      const clickInsideHeader = siteHeader && siteHeader.contains(event.target);

      if (isOpen && !clickInsideHeader) {
        closeMobileMenu();
      }
    });
  }

  /* ─── Sticky Header Shadow ────────────────────────── */
  const siteHeader = document.getElementById("site-header");

  if (siteHeader) {
    window.addEventListener(
      "scroll",
      function () {
        if (window.scrollY > 10) {
          siteHeader.classList.add("scrolled");
        } else {
          siteHeader.classList.remove("scrolled");
        }
      },
      { passive: true },
    );
  }

  /* ─── Scroll to Top ───────────────────────────────── */
  const scrollTopBtn = document.getElementById("scroll-top");

  if (scrollTopBtn) {
    window.addEventListener(
      "scroll",
      function () {
        if (window.scrollY > 350) {
          scrollTopBtn.classList.add("is-visible");
        } else {
          scrollTopBtn.classList.remove("is-visible");
        }
      },
      { passive: true },
    );

    scrollTopBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ─── FAQ Accordion ───────────────────────────────── */
  const faqItems = document.querySelectorAll(".dc-faq-item");

  function setFaqOpen(item, shouldOpen) {
    const trigger = item.querySelector(".dc-faq-trigger");
    const panel = item.querySelector(".dc-faq-panel");
    const icon = item.querySelector(".dc-faq-icon");

    if (!trigger || !panel || !icon) {
      return;
    }

    panel.classList.toggle("is-open", shouldOpen);
    icon.classList.toggle("is-open", shouldOpen);
    trigger.setAttribute("aria-expanded", shouldOpen ? "true" : "false");
    panel.setAttribute("aria-hidden", shouldOpen ? "false" : "true");
  }

  faqItems.forEach(function (item) {
    const trigger = item.querySelector(".dc-faq-trigger");

    if (!trigger) {
      return;
    }

    trigger.addEventListener("click", function () {
      const isOpen = trigger.getAttribute("aria-expanded") === "true";

      faqItems.forEach(function (otherItem) {
        setFaqOpen(otherItem, false);
      });

      setFaqOpen(item, !isOpen);
    });
  });

  /* ─── Smooth scroll untuk anchor link ────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener("click", function (e) {
      const targetId = anchor.getAttribute("href").slice(1);
      const target = document.getElementById(targetId);
      if (target) {
        e.preventDefault();
        const headerH = siteHeader ? siteHeader.offsetHeight : 64;
        const top =
          target.getBoundingClientRect().top + window.scrollY - headerH - 8;
        window.scrollTo({ top: top, behavior: "smooth" });
        closeMobileMenu();
      }
    });
  });
});
