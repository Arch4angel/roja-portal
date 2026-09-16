(() => {
  'use strict';
  const breakingLabel = document.body.dataset.rpBreakingLabel;
  document.querySelectorAll('.roja-breaking').forEach(list => {
    list.tabIndex = 0;
    list.setAttribute('role', 'region');
    if (breakingLabel) {
      list.setAttribute('aria-label', breakingLabel);
    }
  });
  const button = document.querySelector('.rp-menu-toggle');
  const nav = document.getElementById('rp-navigation');
  const overlay = document.querySelector('.rp-nav-overlay');
  if (!button || !nav || !overlay) return;
  const closeButton = nav.querySelector('.rp-menu-close');
  const mobileSearch = nav.querySelector('.rp-mobile-search');
  const search = document.querySelector('.rp-tools .rp-search');
  const anchor = document.createComment('ROJA desktop search position');
  if (search) search.before(anchor);
  const mobile = window.matchMedia('(max-width: 780px)');
  let opened = false;
  let previousOverflow = '';
  const focusable = () => [...nav.querySelectorAll('a[href],button,input,select,textarea,[tabindex]')]
    .filter(el => !el.disabled && el.tabIndex >= 0 && el.getClientRects().length && getComputedStyle(el).visibility !== 'hidden');
  const close = (restoreFocus = true) => {
    if (!opened) return;
    opened = false;
    nav.classList.remove('is-open');
    overlay.hidden = true;
    button.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = previousOverflow;
    if (restoreFocus) button.focus();
  };
  const open = () => {
    if (!mobile.matches || opened) return;
    opened = true;
    previousOverflow = document.body.style.overflow;
    nav.classList.add('is-open');
    overlay.hidden = false;
    button.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    (focusable()[0] || closeButton)?.focus();
  };
  const sync = () => {
    const active = document.activeElement;
    close(false);
    if (search && mobileSearch) {
      if (mobile.matches) mobileSearch.appendChild(search);
      else anchor.after(search);
    }
    if (mobile.matches && nav.contains(active)) button.focus();
    if (!mobile.matches && active === closeButton) nav.querySelector('a[href]')?.focus();
  };
  button.addEventListener('click', () => opened ? close() : open());
  closeButton?.addEventListener('click', () => close());
  overlay.addEventListener('click', () => close());
  nav.addEventListener('click', e => { if (e.target.closest('a[href]') && mobile.matches) close(); });
  document.addEventListener('keydown', e => {
    if (!opened) return;
    if (e.key === 'Escape') { e.preventDefault(); close(); }
    if (e.key === 'Tab') {
      const items = focusable();
      if (!items.length) return;
      const first = items[0], last = items[items.length - 1];
      if (e.shiftKey && (document.activeElement === first || !nav.contains(document.activeElement))) {
        e.preventDefault(); last.focus();
      } else if (!e.shiftKey && (document.activeElement === last || !nav.contains(document.activeElement))) {
        e.preventDefault(); first.focus();
      }
    }
  });
  mobile.addEventListener('change', sync);
  sync();
})();
