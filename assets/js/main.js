/**
 * ALD Blog — Main JavaScript
 * Vanilla JS, zero dependencies, zero jQuery
 *
 * @package ALD_Blog
 * @version 1.0.0
 */
(function () {
    'use strict';

    // ============================================================
    // Mobile Navigation Toggle
    // ============================================================
    function initMobileNav() {
        const toggle = document.querySelector('.menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');

        if (!toggle || !mobileNav) return;

        toggle.addEventListener('click', function () {
            const isOpen = mobileNav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            // Trap focus when menu is open
            if (isOpen) {
                const firstLink = mobileNav.querySelector('a');
                if (firstLink) firstLink.focus();
            }
        });

        // Close menu on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mobileNav.classList.contains('is-open')) {
                mobileNav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileNav.contains(e.target) && !toggle.contains(e.target) && mobileNav.classList.contains('is-open')) {
                mobileNav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ============================================================
    // Smooth Scroll for Anchor Links
    // ============================================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Set focus for accessibility
                    target.setAttribute('tabindex', '-1');
                    target.focus({ preventScroll: true });
                }
            });
        });
    }

    // ============================================================
    // Intersection Observer — Lazy load elements as they enter viewport
    // ============================================================
    function initLazyLoad() {
        if (!('IntersectionObserver' in window)) return;

        const lazyElements = document.querySelectorAll('[data-lazy]');

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    // Load background image or content
                    const lazySrc = el.getAttribute('data-lazy');
                    if (lazySrc) {
                        if (el.tagName === 'IMG') {
                            el.src = lazySrc;
                        } else {
                            el.style.backgroundImage = 'url(' + lazySrc + ')';
                        }
                        el.removeAttribute('data-lazy');
                    }
                    observer.unobserve(el);
                }
            });
        }, {
            rootMargin: '200px 0px' // Start loading 200px before viewport
        });

        lazyElements.forEach(function (el) {
            observer.observe(el);
        });
    }

    // ============================================================
    // Back to Top Button
    // ============================================================
    function initBackToTop() {
        const button = document.createElement('button');
        button.className = 'back-to-top';
        button.setAttribute('aria-label', 'Back to top');
        button.innerHTML = '&uarr;';
        button.style.cssText = [
            'position:fixed',
            'bottom:2rem',
            'right:2rem',
            'width:44px',
            'height:44px',
            'border-radius:50%',
            'background:var(--color-primary)',
            'color:#fff',
            'border:none',
            'cursor:pointer',
            'font-size:1.25rem',
            'display:none',
            'align-items:center',
            'justify-content:center',
            'z-index:999',
            'box-shadow:var(--shadow-md)',
            'transition:opacity 0.3s, transform 0.3s',
            'opacity:0',
            'transform:translateY(10px)'
        ].join(';');

        document.body.appendChild(button);

        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    if (window.scrollY > 500) {
                        button.style.display = 'flex';
                        // Small delay to allow display:flex to apply before opacity transition
                        setTimeout(function () {
                            button.style.opacity = '1';
                            button.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        button.style.opacity = '0';
                        button.style.transform = 'translateY(10px)';
                        setTimeout(function () {
                            button.style.display = 'none';
                        }, 300);
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        button.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ============================================================
    // Table Wrapper — Make tables responsive
    // ============================================================
    function wrapTables() {
        const tables = document.querySelectorAll('.entry-content table');
        tables.forEach(function (table) {
            if (!table.parentElement.classList.contains('table-wrapper')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-wrapper';
                wrapper.style.overflowX = 'auto';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
    }

    // ============================================================
    // External Links — Add target="_blank" and rel="noopener"
    // ============================================================
    function initExternalLinks() {
        const links = document.querySelectorAll('a[href^="http"]');
        const currentHost = window.location.hostname;

        links.forEach(function (link) {
            if (link.hostname !== currentHost && !link.getAttribute('target')) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            }
        });
    }

    // ============================================================
    // Reading Progress Bar (for single posts)
    // ============================================================
    function initReadingProgress() {
        const article = document.querySelector('.entry-content');
        if (!article) return;

        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.setAttribute('role', 'progressbar');
        progressBar.setAttribute('aria-label', 'Reading progress');
        progressBar.setAttribute('aria-valuenow', '0');
        progressBar.setAttribute('aria-valuemin', '0');
        progressBar.setAttribute('aria-valuemax', '100');
        progressBar.style.cssText = [
            'position:fixed',
            'top:0',
            'left:0',
            'width:0%',
            'height:3px',
            'background:var(--color-primary-light)',
            'z-index:10000',
            'transition:width 0.1s linear'
        ].join(';');

        document.body.appendChild(progressBar);

        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    const articleTop = article.offsetTop;
                    const articleHeight = article.offsetHeight;
                    const windowHeight = window.innerHeight;
                    const scrollTop = window.scrollY;

                    const progress = Math.min(
                        Math.max(
                            ((scrollTop - articleTop) / (articleHeight - windowHeight)) * 100,
                            0
                        ),
                        100
                    );

                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', Math.round(progress));
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    // ============================================================
    // Initialize Everything
    // ============================================================
    function init() {
        initMobileNav();
        initSmoothScroll();
        initLazyLoad();
        initBackToTop();
        wrapTables();
        initExternalLinks();

        // Only on single posts
        if (document.body.classList.contains('single')) {
            initReadingProgress();
        }
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
