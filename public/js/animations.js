/**
 * Skensa Auto Service — FULL ANIMATION ENGINE
 * Taruh file ini di: public/js/animations.js
 * Lalu tambahkan di layouts/app.blade.php sebelum </body>:
 * <script src="{{ asset('js/animations.js') }}"></script>
 */

'use strict';

/* =========================================================
   1. SCROLL REVEAL — semua elemen masuk dengan animasi
   ========================================================= */
function initScrollReveal() {
 const targets = document.querySelectorAll(
    '.mod-card, .feature-card, .hf-item, .inv-stat, ' +
    '.heritage-text, .invoice-row-left, ' +
    '.invoice-row-right, .modules-header, .page-hero-content'
  );

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        // stagger delay berdasarkan index dalam parent
        const siblings = entry.target.parentElement
          ? [...entry.target.parentElement.children].indexOf(entry.target)
          : 0;
        const delay = siblings * 80;
        setTimeout(() => {
          entry.target.classList.add('cvx-visible');
        }, delay);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });

  targets.forEach(el => {
    el.classList.add('cvx-hidden');
    observer.observe(el);
  });
}

/* =========================================================
   2. NAVBAR — shrink & hide/show on scroll
   ========================================================= */
function initNavbar() {
  const nav = document.querySelector('.navbar');
  if (!nav) return;

  let lastY = 0;
  let ticking = false;

  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(() => {
        const y = window.scrollY;
        if (y > 80) {
          nav.classList.add('navbar--scrolled');
        } else {
          nav.classList.remove('navbar--scrolled');
        }
        // hide on scroll down, show on scroll up
        if (y > lastY + 5 && y > 200) {
          nav.classList.add('navbar--hidden');
        } else if (y < lastY - 5) {
          nav.classList.remove('navbar--hidden');
        }
        lastY = y;
        ticking = false;
      });
      ticking = true;
    }
  });
}

/* =========================================================
   3. HERO — parallax teks & counter animasi
   ========================================================= */
function initHeroParallax() {
  const heroLeft = document.querySelector('.hero-left');
  if (!heroLeft) return;

  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    heroLeft.style.transform = `translateY(${y * 0.18}px)`;
    heroLeft.style.opacity = Math.max(0, 1 - y / 500);
  }, { passive: true });
}

/* =========================================================
   4. STAT COUNTER — angka count-up saat muncul
   ========================================================= */
function initCounters() {
  const counters = document.querySelectorAll('.modules-stat-num, .inv-stat-val');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const raw = el.textContent.trim();

      // Parse angka, bisa "99.8%", "Instan", "100%", "Aman"
      const match = raw.match(/([\d.]+)/);
      if (!match) return;

      const target = parseFloat(match[1]);
      const suffix = raw.replace(match[1], '');
      const isFloat = match[1].includes('.');
      const duration = 1800;
      const start = performance.now();

      function tick(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = eased * target;
        el.textContent = (isFloat ? current.toFixed(1) : Math.floor(current)) + suffix;
        if (progress < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
      observer.unobserve(el);
    });
  }, { threshold: 0.5 });

  counters.forEach(el => observer.observe(el));
}

/* =========================================================
   5. CARD TILT — efek 3D tilt saat hover
   ========================================================= */
function initCardTilt() {
  const cards = document.querySelectorAll('.mod-card, .feature-card, .qs-card');

  cards.forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const cx = rect.width / 2;
      const cy = rect.height / 2;
      const rotY = ((x - cx) / cx) * 6;
      const rotX = -((y - cy) / cy) * 6;
      card.style.transform =
        `perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateZ(8px)`;
      card.style.boxShadow =
        `${-rotY * 2}px ${rotX * 2}px 40px rgba(232,101,10,0.15)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });
}

/* =========================================================
   6. BUTTON — ripple effect saat diklik
   ========================================================= */
function initRipple() {
  const btns = document.querySelectorAll(
    '.hbtn, .btn-nav, .qs-btn, .btn-primary, .mod-link'
  );

  btns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const ripple = document.createElement('span');
      ripple.className = 'cvx-ripple';
      ripple.style.left = x + 'px';
      ripple.style.top  = y + 'px';
      btn.appendChild(ripple);

      ripple.addEventListener('animationend', () => ripple.remove());
    });
  });
}

/* =========================================================
   7. INVOICE PREVIEW — pulsing shimmer
   ========================================================= */
function initInvoiceShimmer() {
  const inv = document.querySelector('.inv-preview');
  if (!inv) return;

  const lines = inv.querySelectorAll('.inv-line');
  let idx = 0;
  setInterval(() => {
    lines.forEach(l => l.classList.remove('inv-line--active'));
    lines[idx % lines.length].classList.add('inv-line--active');
    idx++;
  }, 800);
}

/* =========================================================
   8. HERITAGE BADGE — spin terus sedikit + glow
   ========================================================= */
function initHeritageBadge() {
  const badge = document.querySelector('.heritage-badge');
  if (!badge) return;

  let angle = 0;
  function spin() {
    angle += 0.3;
    badge.style.transform = `rotate(${angle}deg)`;
    requestAnimationFrame(spin);
  }
  // hanya spin border, bukan konten
  badge.style.position = 'relative';
  requestAnimationFrame(spin);
}

/* =========================================================
   9. NAV LINKS — underline slide animation
   ========================================================= */
function initNavHover() {
  const links = document.querySelectorAll('.nav-links a:not(.active)');
  links.forEach(link => {
    link.addEventListener('mouseenter', () => {
      link.style.transition = 'color 0.2s, letter-spacing 0.2s';
      link.style.letterSpacing = '0.12em';
    });
    link.addEventListener('mouseleave', () => {
      link.style.letterSpacing = '0.08em';
    });
  });
}

/* =========================================================
   11. PAGE TRANSITION — fade in saat halaman load
   ========================================================= */
function initPageTransition() {
  document.body.classList.add('cvx-page-enter');
  window.addEventListener('load', () => {
    setTimeout(() => document.body.classList.add('cvx-page-ready'), 50);
  });

  // Fade out sebelum navigasi
  document.querySelectorAll('a[href]:not([target="_blank"])').forEach(a => {
    a.addEventListener('click', e => {
      const href = a.getAttribute('href');
      if (!href || href.startsWith('#') || href.startsWith('javascript')) return;
      e.preventDefault();
      document.body.classList.add('cvx-page-exit');
      setTimeout(() => { window.location.href = href; }, 350);
    });
  });
}

/* =========================================================
   12. HERO TYPING EFFECT — teks hero diketik satu-satu
   ========================================================= */
function initHeroTyping() {
  const accent = document.querySelector('.hero-accent');
  if (!accent) return;

  const words = ['Pintar', 'Presisi', 'Digital', 'Modern'];
  let wIdx = 0;
  let cIdx = 0;
  let deleting = false;

  function type() {
    const word = words[wIdx];
    if (!deleting) {
      accent.textContent = word.slice(0, ++cIdx);
      if (cIdx === word.length) {
        deleting = true;
        setTimeout(type, 1800);
        return;
      }
      setTimeout(type, 100);
    } else {
      accent.textContent = word.slice(0, --cIdx);
      if (cIdx === 0) {
        deleting = false;
        wIdx = (wIdx + 1) % words.length;
        setTimeout(type, 300);
        return;
      }
      setTimeout(type, 55);
    }
  }
  // mulai setelah 1 detik
  setTimeout(type, 1000);
}

/* =========================================================
   13. MOD-BAR — animated progress bar
   ========================================================= */
function initModBar() {
  const bars = document.querySelectorAll('.mod-bar');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('mod-bar--active');
      }
    });
  }, { threshold: 0.5 });
  bars.forEach(b => observer.observe(b));
}

/* =========================================================
   14. QUICK SCHEDULE CARD — shake validasi form
   ========================================================= */
function initFormShake() {
  const form = document.querySelector('.qs-card form');
  if (!form) return;

  form.addEventListener('submit', e => {
    const inputs = form.querySelectorAll('input, select');
    let empty = false;
    inputs.forEach(inp => {
      if (!inp.value) {
        inp.classList.add('cvx-shake');
        inp.addEventListener('animationend', () => inp.classList.remove('cvx-shake'), { once: true });
        empty = true;
      }
    });
    if (empty) e.preventDefault();
  });
}

/* =========================================================
   15. FLOATING PARTICLES — hero section
   ========================================================= */
function initParticles() {
  const hero = document.querySelector('.hero-section');
  if (!hero) return;

  for (let i = 0; i < 18; i++) {
    const p = document.createElement('span');
    p.className = 'cvx-particle';
    p.style.cssText = `
      left: ${Math.random() * 100}%;
      top: ${Math.random() * 100}%;
      width: ${Math.random() * 3 + 1}px;
      height: ${Math.random() * 3 + 1}px;
      animation-delay: ${Math.random() * 5}s;
      animation-duration: ${Math.random() * 8 + 6}s;
    `;
    hero.appendChild(p);
  }
}

/* =========================================================
   INIT SEMUA
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  initScrollReveal();
  initNavbar();
  initHeroParallax();
  initCounters();
  initCardTilt();
  initRipple();
  initInvoiceShimmer();
  initNavHover();
  initCursorGlow();
  initPageTransition();
  initHeroTyping();
  initModBar();
  initFormShake();
  initParticles();
});