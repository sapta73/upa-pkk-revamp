/**
 * UPA PKK UBB — Scroll Animation Engine
 * Pure vanilla JS. No libraries. IntersectionObserver + requestAnimationFrame.
 * Inspired by Apple, Linear, Stripe quality of interactions.
 */

const EASE = 'cubic-bezier(0.4, 0, 0.2, 1)';
const DURATION = 700;

// ─── prefers-reduced-motion ──────────────────────────────────
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)');
const REDUCED = prefersReduced.matches;

// ─── Utility ─────────────────────────────────────────────────
function isMobile() {
  return window.innerWidth < 768;
}

function observeElement(el, { threshold = 0.15, rootMargin = '0px 0px -60px 0px', onEnter, onLeave } = {}) {
  if (!el) return;
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        onEnter?.(entry);
        if (el.dataset.revealOnce !== 'false') obs.unobserve(el);
      } else {
        onLeave?.(entry);
      }
    });
  }, { threshold, rootMargin });
  obs.observe(el);
  return obs;
}

// ─── Progress Bar ────────────────────────────────────────────
function initProgressBar() {
  const bar = document.getElementById('scroll-progress');
  if (!bar) return;
  const update = () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;
    bar.style.transform = `scaleX(${progress})`;
  };
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update, { passive: true });
  update();
}

// ─── Section Reveal (IntersectionObserver) ──────────────────
function initSectionReveal() {
  if (REDUCED) return;
  document.querySelectorAll('[data-reveal]').forEach(el => {
    const dir = el.dataset.reveal || 'up';
    const distance = el.dataset.revealDistance || (isMobile() ? 24 : 40);
    const delay = parseInt(el.dataset.revealDelay) || 0;
    const duration = parseInt(el.dataset.revealDuration) || DURATION;

    let transformStart = '';
    if (dir === 'up') transformStart = `translateY(${distance}px)`;
    else if (dir === 'down') transformStart = `translateY(-${distance}px)`;
    else if (dir === 'left') transformStart = `translateX(-${distance}px)`;
    else if (dir === 'right') transformStart = `translateX(${distance}px)`;
    else if (dir === 'scale') transformStart = 'scale(0.92)';

    el.style.opacity = '0';
    el.style.transform = transformStart;
    el.style.transition = `opacity ${duration}ms ${EASE} ${delay}ms, transform ${duration}ms ${EASE} ${delay}ms`;
    el.style.willChange = 'opacity, transform';

    observeElement(el, {
      threshold: 0.1,
      rootMargin: '0px 0px -40px 0px',
      onEnter: () => {
        el.style.opacity = '1';
        el.style.transform = 'translate(0, 0) scale(1)';
        setTimeout(() => { el.style.willChange = 'auto'; }, duration + delay + 100);
      }
    });
  });
}

// ─── Stagger Children ────────────────────────────────────────
function initStagger() {
  if (REDUCED) return;
  document.querySelectorAll('[data-stagger]').forEach(parent => {
    const baseDelay = parseInt(parent.dataset.staggerDelay) || 80;
    const children = parent.children;
    if (!children.length) return;

    // Hide all children initially
    Array.from(children).forEach((child, i) => {
      const dir = child.dataset.reveal || 'up';
      const distance = parseInt(child.dataset.revealDistance) || (isMobile() ? 20 : 30);
      const delay = i * baseDelay;
      const duration = parseInt(child.dataset.revealDuration) || 600;

      let transformStart = '';
      if (dir === 'up') transformStart = `translateY(${distance}px)`;
      else if (dir === 'left') transformStart = `translateX(-${distance}px)`;
      else if (dir === 'right') transformStart = `translateX(${distance}px)`;

      child.style.opacity = '0';
      child.style.transform = transformStart;
      child.style.transition = `opacity ${duration}ms ${EASE} ${delay}ms, transform ${duration}ms ${EASE} ${delay}ms`;
      child.style.willChange = 'opacity, transform';
    });

    observeElement(parent, {
      threshold: 0.1,
      rootMargin: '0px 0px -40px 0px',
      onEnter: () => {
        Array.from(children).forEach(child => {
          child.style.opacity = '1';
          child.style.transform = 'translate(0, 0)';
        });
      }
    });
  });
}

// ─── Count-Up Animation ──────────────────────────────────────
function initCountUp() {
  document.querySelectorAll('[data-count-up]').forEach(el => {
    const target = parseInt(el.dataset.countUp) || 0;
    const suffix = el.dataset.countSuffix || '';
    const duration = parseInt(el.dataset.countDuration) || 2000;

    observeElement(el, {
      threshold: 0.5,
      onEnter: () => {
        animateCount(el, target, suffix, duration);
      }
    });
  });
}

function animateCount(el, target, suffix, duration) {
  const start = 0;
  const startTime = performance.now();
  const update = (now) => {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / duration, 1);
    // Ease out cubic
    const eased = 1 - Math.pow(1 - progress, 3);
    const current = Math.round(start + (target - start) * eased);
    el.textContent = current.toLocaleString() + suffix;
    if (progress < 1) requestAnimationFrame(update);
  };
  requestAnimationFrame(update);
}

// ─── Smooth Parallax ─────────────────────────────────────────
function initParallax() {
  if (REDUCED || isMobile()) return;
  const els = document.querySelectorAll('[data-parallax]');
  if (!els.length) return;

  const update = () => {
    const sy = window.scrollY;
    els.forEach(el => {
      const speed = parseFloat(el.dataset.parallax) || 0.15;
      const rect = el.getBoundingClientRect();
      // Only apply when element is near viewport
      if (rect.top < window.innerHeight + 200 && rect.bottom > -200) {
        const offset = (rect.top - window.innerHeight * 0.5) * speed;
        el.style.transform = `translateY(${Math.round(offset)}px)`;
      }
    });
  };

  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(() => { update(); ticking = false; });
      ticking = true;
    }
  }, { passive: true });
  update();
}

// ─── Navbar Section Highlight ────────────────────────────────
function initSectionSpy() {
  const navLinks = document.querySelectorAll('.nav-link');
  const sections = document.querySelectorAll('[data-section]');
  if (!sections.length || !navLinks.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.dataset.section;
        navLinks.forEach(link => {
          link.classList.remove('nav-link-active');
          if (link.getAttribute('href') === `/#${id}` || link.dataset.sectionTarget === id) {
            link.classList.add('nav-link-active');
          }
        });
      }
    });
  }, { threshold: 0.3, rootMargin: '0px 0px -30% 0px' });

  sections.forEach(s => observer.observe(s));
}

// ─── Ripple Effect ───────────────────────────────────────────
function initRipple() {
  document.querySelectorAll('[data-ripple]').forEach(el => {
    el.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const size = Math.max(rect.width, rect.height) * 1.2;

      const ripple = document.createElement('span');
      ripple.style.cssText = `
                position: absolute;
                top: ${y - size / 2}px;
                left: ${x - size / 2}px;
                width: ${size}px;
                height: ${size}px;
                border-radius: 50%;
                background: rgba(255,255,255,0.25);
                transform: scale(0);
                animation: rippleAnim 0.5s ease-out forwards;
                pointer-events: none;
            `;
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });
}

// ─── Footer Link Stagger ─────────────────────────────────────
function initFooterReveal() {
  if (REDUCED) return;
  const footer = document.querySelector('[data-footer]');
  if (!footer) return;

  observeElement(footer, {
    threshold: 0.1,
    onEnter: () => {
      footer.style.opacity = '1';
      footer.style.transform = 'translateY(0)';
    }
  });
}

// ─── Hero On-Load Entrance ───────────────────────────────────
function initHeroEntrance() {
  if (REDUCED) return;
  const hero = document.querySelector('[data-hero]');
  if (!hero) return;

  // Hero image scale-down effect
  const heroImg = hero.querySelector('img');
  if (heroImg) {
    heroImg.style.transform = 'scale(1.08)';
    heroImg.style.transition = `transform 1.2s ${EASE}`;
    requestAnimationFrame(() => {
      heroImg.style.transform = 'scale(1)';
    });
  }
}

// ─── Init ────────────────────────────────────────────────────
export function initScrollAnimations() {
  // Add ripple animation keyframe if not exists
  if (!document.getElementById('ripple-style')) {
    const style = document.createElement('style');
    style.id = 'ripple-style';
    style.textContent = `
            @keyframes rippleAnim {
                0% { transform: scale(0); opacity: 0.5; }
                100% { transform: scale(2.5); opacity: 0; }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            .float-slow {
                animation: float 4s ease-in-out infinite;
            }
            @keyframes countUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
    document.head.appendChild(style);
  }

  initProgressBar();
  initHeroEntrance();

  // Small delay for sections below the fold to reduce layout shift
  requestAnimationFrame(() => {
    initSectionReveal();
    initStagger();
    initCountUp();
    initParallax();
    initSectionSpy();
    initRipple();
    initFooterReveal();
  });
}
