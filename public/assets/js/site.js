(() => {
  'use strict';
  document.documentElement.classList.add('js');

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const formErrorSummary = document.querySelector('[data-form-error-summary]');
  if (formErrorSummary) formErrorSummary.focus();
  const toggle = document.querySelector('[data-nav-toggle]');
  const nav = document.querySelector('[data-nav]');

  function closeNavigation() {
    if (!toggle || !nav) return;
    toggle.setAttribute('aria-expanded', 'false');
    toggle.querySelector('.sr-only').textContent = 'Open menu';
    nav.classList.remove('is-open');
    document.body.classList.remove('nav-open');
    document.querySelectorAll('.submenu-toggle').forEach(button => button.setAttribute('aria-expanded', 'false'));
  }

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      toggle.querySelector('.sr-only').textContent = open ? 'Open menu' : 'Close menu';
      nav.classList.toggle('is-open', !open);
      document.body.classList.toggle('nav-open', !open);
    });
    nav.addEventListener('click', event => {
      if (event.target.closest('a') && window.innerWidth <= 860) closeNavigation();
    });
  }

  const submenuToggles = [...document.querySelectorAll('.submenu-toggle')];
  submenuToggles.forEach(button => {
    button.addEventListener('click', event => {
      event.stopPropagation();
      const willOpen = button.getAttribute('aria-expanded') !== 'true';
      submenuToggles.forEach(other => other.setAttribute('aria-expanded', 'false'));
      button.setAttribute('aria-expanded', String(willOpen));
    });
  });

  document.addEventListener('click', event => {
    if (!event.target.closest('.has-menu')) submenuToggles.forEach(button => button.setAttribute('aria-expanded', 'false'));
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      submenuToggles.forEach(button => button.setAttribute('aria-expanded', 'false'));
      if (nav?.classList.contains('is-open')) { closeNavigation(); toggle.focus(); }
    }
  });

  const reveals = [...document.querySelectorAll('.reveal')];
  if (reducedMotion || !('IntersectionObserver' in window)) {
    reveals.forEach(item => item.classList.add('is-visible'));
  } else {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    reveals.forEach(item => observer.observe(item));
  }

  document.querySelectorAll('img').forEach(img => img.addEventListener('error', () => {
    if (!img.src.endsWith('/assets/images/missing-media.svg')) {
      img.src = '/assets/images/missing-media.svg';
      img.dataset.missing = 'true';
    }
  }, { once: true }));

  const gallery = document.querySelector('[data-gallery]');
  const filterButtons = [...document.querySelectorAll('[data-filter]')];
  if (gallery && filterButtons.length) {
    filterButtons.forEach(button => button.addEventListener('click', () => {
      const category = button.dataset.filter;
      filterButtons.forEach(item => {
        const active = item === button;
        item.classList.toggle('is-active', active);
        item.setAttribute('aria-pressed', String(active));
      });
      gallery.querySelectorAll('[data-category]').forEach(item => {
        item.hidden = category !== 'all' && item.dataset.category !== category;
      });
    }));
  }

  const dialog = document.querySelector('[data-lightbox]');
  const dataElement = document.getElementById('gallery-data');
  if (dialog && dataElement) {
    const items = JSON.parse(dataElement.textContent);
    const image = dialog.querySelector('[data-lightbox-image]');
    const video = dialog.querySelector('[data-lightbox-video]');
    const title = dialog.querySelector('[data-lightbox-title]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    const close = dialog.querySelector('[data-lightbox-close]');
    const previous = dialog.querySelector('[data-lightbox-prev]');
    const next = dialog.querySelector('[data-lightbox-next]');
    let current = 0;
    let trigger = null;

    const show = index => {
      current = (index + items.length) % items.length;
      const isVideo = items[current].type === 'video' && items[current].video;
      video.hidden = !isVideo;
      image.hidden = Boolean(isVideo);
      video.src = isVideo ? items[current].video : '';
      image.src = isVideo ? '' : items[current].src;
      image.alt = isVideo ? '' : items[current].alt;
      title.textContent = items[current].title;
      caption.textContent = items[current].caption;
    };
    document.querySelectorAll('[data-lightbox-index]').forEach(button => button.addEventListener('click', () => {
      trigger = button;
      show(Number(button.dataset.lightboxIndex));
      dialog.showModal();
      close.focus();
    }));
    close.addEventListener('click', () => dialog.close());
    previous.addEventListener('click', () => show(current - 1));
    next.addEventListener('click', () => show(current + 1));
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
    dialog.addEventListener('close', () => { video.src = ''; trigger?.focus(); });
    dialog.addEventListener('keydown', event => {
      if (event.key === 'ArrowLeft') { event.preventDefault(); show(current - 1); }
      if (event.key === 'ArrowRight') { event.preventDefault(); show(current + 1); }
      if (event.key === 'Escape') dialog.close();
      if (event.key === 'Tab') {
        const focusable = [...dialog.querySelectorAll('button:not([disabled])')];
        const first = focusable[0], last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
      }
    });
  }

  window.addEventListener('resize', () => { if (window.innerWidth > 860) closeNavigation(); });
})();
