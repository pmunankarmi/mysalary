    // -- Mobile menu toggle ---------------------------------------------------
    (function () {
      var burger = document.getElementById('msBurger');
      var nav = document.getElementById('msNav');
      if (!burger || !nav) return;

      function setMenu(open) {
        nav.classList.toggle('is-open', open);
        burger.classList.toggle('is-open', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        burger.setAttribute('aria-label', open ? burger.getAttribute('data-close-label') : burger.getAttribute('data-open-label'));
      }

      burger.addEventListener('click', function () {
        setMenu(!nav.classList.contains('is-open'));
      });
      nav.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () { setMenu(false); });
      });
      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
          setMenu(false);
          burger.focus();
        }
      });
    })();

    // -- Hero state rotation --------------------------------------------------
    (function () {
      const states = document.querySelectorAll('.ms-hero__state');
      const supports = document.querySelectorAll('.ms-hero__support');
    
      if (!states.length) return;
    
      let idx = 0;
      const total = states.length;
      let interval;
    
      function setActive(index) {
        states.forEach((el, i) => {
          el.classList.toggle('is-active', i === index);
        });
    
        // Only sync supports if same length
        if (supports.length === total) {
          supports.forEach((el, i) => {
            el.classList.toggle('is-active', i === index);
          });
        }
      }
    
      function tick() {
        idx = (idx + 1) % total;
        setActive(idx);
      }
    
      function start() {
        if (!interval) {
          interval = setInterval(tick, 5000);
        }
      }
    
      function stop() {
        clearInterval(interval);
        interval = null;
      }
    
      // Initial state
      setActive(idx);
    
      // Respect reduced motion
      if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        start();
      }
    
      // Pause when tab is hidden
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          stop();
        } else {
          start();
        }
      });
    
      // Optional: pause on hover
      const hero = document.querySelector('.ms-hero');
      if (hero) {
        hero.addEventListener('mouseenter', stop);
        hero.addEventListener('mouseleave', start);
      }
    })();

    // -- Reveal-on-scroll using IntersectionObserver --------------------------
    (function () {
      var els = document.querySelectorAll('.ms-reveal');
      if (!('IntersectionObserver' in window) || !els.length) {
        els.forEach(function (el) { el.classList.add('is-visible'); });
        return;
      }
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      els.forEach(function (el) { io.observe(el); });
    })();
    
    // -- Header shadow on scroll ---------------------------------------------
    (function () {
      var header = document.querySelector('.ms-header');
      if (!header) return;
      window.addEventListener('scroll', function () {
        header.style.boxShadow = window.scrollY > 8
          ? '0 4px 18px rgba(23, 14, 63, 0.06)'
          : 'none';
      }, { passive: true });
    })();
    
