/* Initial theme application lives in _nav.php (inline script, runs before
   first paint to avoid a light-flash on load). This file only handles the
   toggle interaction + persistence. */
(function () {
    var btnSwitch = document.getElementById('switch');
    var logo = document.getElementById('sellbuy');

    if (!btnSwitch) return;

    btnSwitch.addEventListener('click', function () {
        var isDark = document.body.classList.toggle('dark');

        /* Explicit boolean keeps switch state in sync even if they drifted */
        btnSwitch.classList.toggle('active', isDark);

        if (logo) {
            logo.src = isDark ? '/images/logoblanco.png' : '/images/logonegro.png';
        }

        try {
            localStorage.setItem('sellbuy-theme', isDark ? 'dark' : 'light');
        } catch (e) {}
    });
})();
