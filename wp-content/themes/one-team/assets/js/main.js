(function () {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.getElementById('mobile-navigation');

  if (!toggle || !nav) {
    return;
  }

  const navLinks = () =>
    nav.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');

  const closeMenu = () => {
    toggle.setAttribute('aria-expanded', 'false');
    nav.hidden = true;
  };

  const openMenu = () => {
    toggle.setAttribute('aria-expanded', 'true');
    nav.hidden = false;
  };

  const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

  toggle.addEventListener('click', function () {
    if (isOpen()) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  toggle.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowDown' && !isOpen()) {
      event.preventDefault();
      openMenu();
      const first = navLinks()[0];
      if (first) {
        first.focus();
      }
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && isOpen()) {
      closeMenu();
      toggle.focus();
    }
  });

  nav.addEventListener('keydown', function (event) {
    if (event.key !== 'Tab' || !isOpen()) {
      return;
    }

    const focusable = Array.from(navLinks());
    if (!focusable.length) {
      return;
    }

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });

  nav.addEventListener('click', function (event) {
    const link = event.target.closest('a');
    if (!link || window.matchMedia('(min-width: 56rem)').matches) {
      return;
    }
    closeMenu();
  });

  const mediaQuery = window.matchMedia('(min-width: 56rem)');
  const syncMenuState = function () {
    if (mediaQuery.matches) {
      nav.hidden = false;
      toggle.setAttribute('aria-expanded', 'false');
    } else if (!isOpen()) {
      nav.hidden = true;
    }
  };

  if (typeof mediaQuery.addEventListener === 'function') {
    mediaQuery.addEventListener('change', syncMenuState);
  } else {
    mediaQuery.addListener(syncMenuState);
  }

  syncMenuState();
})();
