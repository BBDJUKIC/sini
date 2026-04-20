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
  const closeLanguageModal = () => {

    languageModal.hidden = true;
    languageModal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('language-modal-open');
  };

  const openLanguageModal = () => {
    languageModal.hidden = false;
    languageModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('language-modal-open');

    if (!languageGrid.querySelector('.language-modal__option')) {
      buildLanguageGrid();
    }

    if (closeButton) {
      closeButton.focus();
    }
  };

  const getSourceRoots = () => {
    const roots = [];
    const liveLanguage = document.querySelector('.mobile-nav__language');

    if (liveLanguage) {
      roots.push(liveLanguage);
    }

    roots.push(languageSource);
    return roots;
  };

  const collectLinkItems = (root) => {
    return Array.from(root.querySelectorAll('a.nturl[data-gt-lang], a[data-gt-lang]'))
      .map((link) => {
        const label = (link.textContent || '').trim().replace(/\s+/g, ' ');
        const code = ((link.getAttribute('data-gt-lang') || '').trim() || '').toLowerCase();
        const flagNode = link.querySelector('img');
        const flag = flagNode
          ? (flagNode.getAttribute('src') || flagNode.getAttribute('data-gt-lazy-src') || '').trim()
          : '';

        if (!label || !code) {
          return null;
        }

        return {
          label,
          code,
          flag,
          link,
          type: 'link',
        };
      })
      .filter(Boolean);
  };

  const collectSelectItems = (root) => {
    const selectNode = root.querySelector('select.goog-te-combo, select');
    if (!selectNode) {
      return [];
    }

    return Array.from(selectNode.options)
      .filter((option) => option.value && !option.disabled)
      .map((option) => ({
        label: (option.textContent || '').trim(),
        code: (option.value || '').trim().toLowerCase(),
        value: option.value,
        select: selectNode,
        type: 'select',
      }))
      .filter((item) => item.label && item.code);
  };

  const uniqueByCode = (items) => {
    const seenCodes = new Set();
    return items.filter((item) => {
      const code = item.code || '';
      if (!code || seenCodes.has(code)) {
        return false;
      }

      seenCodes.add(code);
      return true;
    });
  };

  const getLanguageItems = () => {
    const roots = getSourceRoots();
    let items = [];

    roots.forEach((root) => {
      items = items.concat(collectLinkItems(root));
    });

    items = uniqueByCode(items);

    if (!items.length) {
      roots.forEach((root) => {
        items = items.concat(collectSelectItems(root));
      });
      items = uniqueByCode(items);
    }

    if (items.length > 1) {
      items.sort((a, b) => {
        if (a.code === 'en') {
          return -1;
        }
        if (b.code === 'en') {
          return 1;
        }
        return 0;
      });
    }

    return items;
  };

  const triggerLanguageChange = (item) => {
    const languageCode = (item.code || '').toLowerCase();

    const liveSelect = document.querySelector('.mobile-nav__language select.goog-te-combo, .gtranslate_wrapper select.goog-te-combo, select.goog-te-combo');
    if (liveSelect && languageCode) {
      const hasOption = Array.from(liveSelect.options).some((option) => (option.value || '').toLowerCase() === languageCode);
      if (hasOption) {
        liveSelect.value = languageCode;
        liveSelect.dispatchEvent(new Event('change', { bubbles: true }));
      }
    }

    if (item.type === 'select' && item.select && item.value) {
      item.select.value = item.value;
      item.select.dispatchEvent(new Event('change', { bubbles: true }));
      return;
    }

    const liveLink = Array.from(
      document.querySelectorAll('.mobile-nav__language a.nturl[data-gt-lang], .gtranslate_wrapper a.nturl[data-gt-lang]')
    ).find((node) => ((node.getAttribute('data-gt-lang') || '').trim().toLowerCase() === languageCode));

    if (liveLink) {
      liveLink.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));
      return;
    }

    if (item.link) {
      item.link.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));

      const href = item.link.getAttribute('href');
      if (href && href !== '#' && !href.startsWith('javascript:')) {
        window.location.href = href;
      }
    }
  };

  const getCurrentLanguageCode = () => {
    const liveSelect = document.querySelector('.mobile-nav__language select.goog-te-combo, .gtranslate_wrapper select.goog-te-combo, select.goog-te-combo');
    if (liveSelect && liveSelect.value) {
      return (liveSelect.value || '').trim().toLowerCase();
    }

    const currentLink = document.querySelector('.mobile-nav__language a.nturl.gt_current[data-gt-lang], .gtranslate_wrapper a.nturl.gt_current[data-gt-lang]');
    if (currentLink) {
      return ((currentLink.getAttribute('data-gt-lang') || '').trim() || '').toLowerCase();
    }

    return 'en';
  };

  const syncModalCurrentLanguage = (languageCode) => {
    const normalizedCode = (languageCode || '').trim().toLowerCase();
    const options = Array.from(languageGrid.querySelectorAll('.language-modal__option'));

    options.forEach((button) => {
      const buttonCode = (button.getAttribute('data-gt-lang') || '').trim().toLowerCase();
      const isCurrent = normalizedCode !== '' && buttonCode === normalizedCode;

      button.classList.toggle('language-modal__option--current', isCurrent);
      button.setAttribute('aria-pressed', isCurrent ? 'true' : 'false');
    });
  };

  const bindDropdownSync = () => {
    const root = document.querySelector('.mobile-nav__language') || document;
    const liveSelect = root.querySelector('select.goog-te-combo');

    if (liveSelect && !liveSelect.dataset.modalSyncBound) {
      liveSelect.addEventListener('change', function () {
        syncModalCurrentLanguage(liveSelect.value);
      });
      liveSelect.dataset.modalSyncBound = '1';
    }

    Array.from(root.querySelectorAll('a.nturl[data-gt-lang]')).forEach((link) => {
      if (link.dataset.modalSyncBound) {
        return;
      }

      link.addEventListener('click', function () {
        syncModalCurrentLanguage(link.getAttribute('data-gt-lang') || '');
      });
      link.dataset.modalSyncBound = '1';
    });
  };

  const buildLanguageGrid = () => {
    const languageItems = getLanguageItems();
    if (!languageItems.length) {
      return false;
    }

    languageGrid.innerHTML = '';

    languageItems.forEach((item) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'language-modal__option';

      if (item.flag) {
        const flagImage = document.createElement('img');
        flagImage.className = 'language-modal__option-flag';
        flagImage.src = item.flag;
        flagImage.alt = '';
        flagImage.width = 20;
        flagImage.height = 20;
        flagImage.loading = 'lazy';
        button.appendChild(flagImage);
      }

      const labelNode = document.createElement('span');
      labelNode.className = 'language-modal__option-label';
      labelNode.textContent = item.label;
      button.appendChild(labelNode);
      button.setAttribute('data-gt-lang', item.code || '');
      button.setAttribute('aria-pressed', 'false');

      if (item.code === 'en') {
        button.classList.add('language-modal__option--main');
      }

      button.addEventListener('click', function () {
        closeLanguageModal();
        triggerLanguageChange(item);
      });

      languageGrid.appendChild(button);
    });

    syncModalCurrentLanguage(getCurrentLanguageCode());

    return true;
  };

  if (closeButton) {
    closeButton.addEventListener('click', function () {
      closeLanguageModal();
    });
  }

  if (continueButton) {
    continueButton.addEventListener('click', function () {
      closeLanguageModal();
    });
  }

  languageModal.addEventListener('click', function (event) {
    if (event.target === languageModal || event.target.classList.contains('language-modal__overlay')) {
      closeLanguageModal();
    }
  });

  if (dialogNode) {
    dialogNode.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !languageModal.hidden) {
      closeLanguageModal();
    }
  });

  let modalOpenScheduled = false;

  const scheduleModalOpen = function () {
    if (modalOpenScheduled) {
      return;
    }

    modalOpenScheduled = true;
    window.setTimeout(openLanguageModal, 1000);
  };

  const initModalWhenLanguagesReady = () => buildLanguageGrid();

  const startLanguageWatcher = () => {
    if (initModalWhenLanguagesReady()) {
      bindDropdownSync();
      scheduleModalOpen();
      return;
    }

    const observer = new MutationObserver(function () {
      if (initModalWhenLanguagesReady()) {
        bindDropdownSync();
        observer.disconnect();
      }
    });

    getSourceRoots().forEach((root) => {
      observer.observe(root, { childList: true, subtree: true, attributes: true });
    });

    let retries = 0;
    const pollTimer = window.setInterval(function () {
      retries += 1;

      if (initModalWhenLanguagesReady() || retries >= 20) {
        bindDropdownSync();
        window.clearInterval(pollTimer);
        observer.disconnect();
      }
    }, 250);

    scheduleModalOpen();
  };

  if (document.readyState === 'complete') {
    startLanguageWatcher();
  } else {
    window.addEventListener('load', startLanguageWatcher, { once: true });
  }
})();
