/**
 * Dark Mode Toggle
 */
(function() {
    'use strict';

    var btn = document.getElementById('darkModeBtn');
    if (!btn) return;

    // Check saved preference
    if (localStorage.getItem('aldBlogDarkMode') === 'dark') {
        document.body.classList.add('dark');
    }

    btn.addEventListener('click', function() {
        document.body.classList.toggle('dark');
        localStorage.setItem('aldBlogDarkMode', document.body.classList.contains('dark') ? 'dark' : 'light');
    });
})();
