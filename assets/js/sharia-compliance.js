(function () {
  'use strict';

  var viewer = document.getElementById('scViewer');

  if (viewer && typeof viewer.showModal === 'function') {
    var lastFocus = null;
    var pages = viewer.querySelector('.sc-viewer__pages');
    var closeButton = viewer.querySelector('.sc-viewer__close');

    document.querySelectorAll('.js-cert-open').forEach(function (link) {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        lastFocus = link;
        viewer.showModal();
        document.documentElement.classList.add('sc-lock');
        if (pages) pages.scrollTop = 0;
      });
    });

    if (closeButton) {
      closeButton.addEventListener('click', function () {
        viewer.close();
      });
    }

    viewer.addEventListener('click', function (event) {
      if (event.target === viewer) viewer.close();
    });

    viewer.addEventListener('close', function () {
      document.documentElement.classList.remove('sc-lock');
      if (lastFocus) lastFocus.focus();
    });

    if (window.location.hash === '#view-certificate') {
      viewer.showModal();
      document.documentElement.classList.add('sc-lock');
    }
  }

  document.querySelectorAll('.sc-copy').forEach(function (button) {
    var label = button.querySelector('.sc-copy__label');
    var status = button.parentNode.querySelector('.sc-copy__status');
    var originalLabel = button.getAttribute('data-copy-label') || (label ? label.textContent : '');
    var copiedLabel = button.getAttribute('data-copied-label') || originalLabel;
    var copiedStatus = button.getAttribute('data-copied-status') || copiedLabel;

    function showCopiedState() {
      if (label) label.textContent = copiedLabel;
      button.classList.add('is-copied');
      if (status) status.textContent = copiedStatus;

      window.setTimeout(function () {
        if (label) label.textContent = originalLabel;
        button.classList.remove('is-copied');
        if (status) status.textContent = '';
      }, 2000);
    }

    function fallbackCopy(text) {
      var textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.setAttribute('readonly', '');
      textarea.style.position = 'fixed';
      textarea.style.opacity = '0';
      document.body.appendChild(textarea);
      textarea.select();

      try {
        document.execCommand('copy');
        showCopiedState();
      } catch (error) {
        // Leave the control unchanged when copying is unavailable.
      }

      document.body.removeChild(textarea);
    }

    button.addEventListener('click', function () {
      var text = button.getAttribute('data-copy') || '';

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(showCopiedState, function () {
          fallbackCopy(text);
        });
      } else {
        fallbackCopy(text);
      }
    });
  });
})();
