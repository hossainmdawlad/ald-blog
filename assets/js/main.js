/**
 * Main JS — Mobile Menu, Search, Category Filter, Bookmark, Font Size
 */
(function() {
    'use strict';

    // === Mobile Menu Toggle ===
    var menuToggle = document.getElementById('menuToggle');
    var mobileMenu = document.getElementById('mobileMenu');
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            var isOpen = mobileMenu.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    // === Search ===
    var searchBtn = document.getElementById('searchBtn');
    var searchBar = document.getElementById('searchBar');
    var searchInput = searchBar ? searchBar.querySelector('input') : null;
    var searchResults = document.getElementById('searchResults');

    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', function() {
            searchBar.classList.toggle('active');
            if (searchBar.classList.contains('active') && searchInput) {
                searchInput.focus();
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchBar.contains(e.target) && !searchBtn.contains(e.target)) {
                searchBar.classList.remove('active');
            }
        });

        if (searchInput && searchResults) {
            var searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                var query = this.value.trim();
                if (query.length < 2) {
                    searchResults.innerHTML = '';
                    searchResults.style.display = 'none';
                    return;
                }
                searchTimeout = setTimeout(function() {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', aldBlog.ajaxUrl + '?action=ald_blog_search&q=' + encodeURIComponent(query) + '&nonce=' + aldBlog.nonce, true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);
                            if (data.length > 0) {
                                var html = '<ul class="search-results-list">';
                                data.forEach(function(item) {
                                    html += '<li class="search-result-item">';
                                    html += '<a href="' + item.url + '" class="search-result-link">';
                                    if (item.img) {
                                        html += '<span class="search-result-thumb"><img src="' + item.img + '" alt=""></span>';
                                    }
                                    html += '<span class="search-result-info">';
                                    html += '<span class="search-result-title">' + item.title + '</span>';
                                    html += '</span>';
                                    html += '</a></li>';
                                });
                                html += '</ul>';
                                html += '<a href="' + aldBlog.themeUrl + '/?s=' + encodeURIComponent(query) + '" class="search-results-view-all">' + 'View All Results →' + '</a>';
                                searchResults.innerHTML = html;
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML = '<div class="search-results-empty"><p>No results found for "<strong>' + query + '</strong>"</p></div>';
                                searchResults.style.display = 'block';
                            }
                        }
                    };
                    xhr.send();
                }, 300);
            });
        }
    }

    // === Category Filter ===
    var catLinks = document.querySelectorAll('.cat-link');
    catLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var category = this.getAttribute('data-category');
            if (category === 'all') {
                window.location.href = aldBlog.themeUrl + '/';
            } else {
                window.location.href = aldBlog.themeUrl + '/category/' + category + '/';
            }
        });
    });

    // === Bookmark ===
    var bookmarkBtn = document.getElementById('bookmarkBtn');
    if (bookmarkBtn) {
        var postId = '';
        var postEl = document.querySelector('.single-article');
        if (postEl) postId = postEl.id.replace('post-', '');
        var bookmarks = JSON.parse(localStorage.getItem('aldBlogBookmarks') || '[]');

        function updateBookmarkBtn() {
            if (bookmarks.includes(postId)) {
                bookmarkBtn.classList.add('bookmarked');
                bookmarkBtn.querySelector('.heart-icon').textContent = '❤️';
            } else {
                bookmarkBtn.classList.remove('bookmarked');
                bookmarkBtn.querySelector('.heart-icon').textContent = '♡';
            }
        }
        updateBookmarkBtn();

        bookmarkBtn.addEventListener('click', function() {
            var idx = bookmarks.indexOf(postId);
            if (idx > -1) {
                bookmarks.splice(idx, 1);
            } else {
                bookmarks.push(postId);
            }
            localStorage.setItem('aldBlogBookmarks', JSON.stringify(bookmarks));
            updateBookmarkBtn();
        });
    }

    // === Font Size ===
    var fontSizeSelect = document.getElementById('fontSizeSelect');
    var singleContent = document.getElementById('singleContent');
    if (fontSizeSelect && singleContent) {
        fontSizeSelect.addEventListener('change', function() {
            singleContent.classList.remove('font-sm', 'font-base', 'font-lg', 'font-xl');
            singleContent.classList.add('font-' + this.value);
        });
    }

    // === Notification Toast ===
    window.aldBlogNotify = function(msg) {
        var toast = document.createElement('div');
        toast.className = 'notification-toast';
        toast.innerHTML = '<span>🔔</span><span>' + msg + '</span>';
        document.body.appendChild(toast);
        setTimeout(function() { toast.classList.add('show'); }, 10);
        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    };

})();
