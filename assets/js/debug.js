/* Gamer Central Theme - Debug Logging */
(function() {
    console.log('%c🎮 Gamer Central Theme loaded', 'color: #60a5fa; font-weight: 700; font-size: 16px;');
    console.log('Version: 3.2');
    console.log('Site URL: ' + window.location.origin);

    // Debug WPForms if present
    if (typeof wpforms !== 'undefined') {
        console.log('WPForms detected:', wpforms);
    }

    // Log form submissions for debugging
    document.addEventListener('submit', function(e) {
        if (e.target.closest('.wpforms-form')) {
            console.log('📝 WPForms submission detected:', e.target);
        }
    }, true);

    // Log clicks on submit buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.wpforms-submit') || e.target.closest('button[type="submit"]')) {
            console.log('🖱️ Submit button clicked:', e.target);
        }
    });
})();
