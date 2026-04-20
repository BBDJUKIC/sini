(function () {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.getElementById('mobile-navigation');
  const labels = window.oneTeamA11y || {
    openNavigationLabel: 'Open navigation',
    closeNavigationLabel: 'Close navigation',
  };

  if (toggle && nav) {
    const navLinks = () =>
      nav.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');

    const closeMenu = () => {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', labels.openNavigationLabel);
      nav.hidden = true;
      document.body.classList.remove('menu-open');
    };

    const openMenu = () => {
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', labels.closeNavigationLabel);
      nav.hidden = false;
      document.body.classList.add('menu-open');
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
        toggle.setAttribute('aria-label', labels.openNavigationLabel);
        document.body.classList.remove('menu-open');
      } else if (!isOpen()) {
        nav.hidden = true;
        document.body.classList.remove('menu-open');
      }
    };

    if (typeof mediaQuery.addEventListener === 'function') {
      mediaQuery.addEventListener('change', syncMenuState);
    } else {
      mediaQuery.addListener(syncMenuState);
    }

    syncMenuState();
  }

  const languageModal = document.getElementById('home-language-modal');
  const languageGrid = document.getElementById('home-language-modal-grid');
  const languageSource = document.getElementById('language-modal-source');

  if (!languageModal || !languageGrid || !languageSource) {
    return;
  }

  const closeButton = languageModal.querySelector('.language-modal__close');
  const continueButton = document.getElementById('home-language-modal-continue');
  const dialogNode = languageModal.querySelector('.language-modal__dialog');
  const storageKey = 'oneTeamLanguageModalSeen';

  const rememberModalSeen = () => {
    try {
      window.sessionStorage.setItem(storageKey, '1');
    } catch (error) {
      // Ignore storage access issues silently.
    }
  };

  const hasSeenModal = () => {
    try {
      return window.sessionStorage.getItem(storageKey) === '1';
    } catch (error) {
      return false;
    }
  };

  const closeLanguageModal = (remember = true) => {
    if (remember) {
      rememberModalSeen();
    }

    languageModal.hidden = true;
    languageModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('language-modal-open');
  };

  const openLanguageModal = () => {
    languageModal.hidden = false;
    languageModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('language-modal-open');

    const firstOption = languageGrid.querySelector('.language-modal__option');
    if (firstOption) {
      firstOption.focus();
    }
  };

  const linkNodes = Array.from(
    languageSource.querySelectorAll('a.nturl, a[data-gt-lang], .gtranslate_wrapper a, .gt_float_switcher a, a[href], a[onclick]')
  ).filter((link) => {
    const label = (link.textContent || '').trim();
    return label !== '';
  });

  let languageItems = linkNodes.map((link) => ({
    label: (link.textContent || '').trim(),
    link,
    type: 'link',
  }));

  if (!languageItems.length) {
    const selectNode = languageSource.querySelector('select');
    if (selectNode) {
      languageItems = Array.from(selectNode.options)
        .filter((option) => option.value && !option.disabled)
        .map((option) => ({
          label: (option.textContent || '').trim(),
          value: option.value,
          select: selectNode,
          type: 'select',
        }));
    }
  }

  if (!languageItems.length) {
    return;
  }

  languageItems.forEach((item) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'language-modal__option';
    button.textContent = item.label;

    button.addEventListener('click', function () {
      closeLanguageModal(true);

      if (item.type === 'select' && item.select && item.value) {
        item.select.value = item.value;
        item.select.dispatchEvent(new Event('change', { bubbles: true }));
        return;
      }

      if (!item.link) {
        return;
      }

      item.link.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));

      const href = item.link.getAttribute('href');
      if (href && href !== '#' && !href.startsWith('javascript:')) {
        window.location.href = href;
      }
    });

    languageGrid.appendChild(button);
  });

  if (closeButton) {
    closeButton.addEventListener('click', function () {
      closeLanguageModal(true);
    });
  }

  if (continueButton) {
    continueButton.addEventListener('click', function () {
      closeLanguageModal(true);
    });
  }

  languageModal.addEventListener('click', function (event) {
    if (event.target === languageModal || event.target.classList.contains('language-modal__overlay')) {
      closeLanguageModal(true);
    }
  });

  if (dialogNode) {
    dialogNode.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !languageModal.hidden) {
      closeLanguageModal(true);
    }
  });

  if (!hasSeenModal()) {
    window.addEventListener('load', function () {
      window.setTimeout(openLanguageModal, 1000);
    });
  }
})();
