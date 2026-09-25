/**
 * Shared toast notifications on top of SweetAlert2 (v11).
 * Helpers are attached to `window` so the file can be included twice without
 * redeclaration errors, and each helper degrades to window.alert when the
 * SweetAlert2 CDN is blocked.
 */
(function (global) {
    'use strict';

    function fire(type, message) {
        var text = String(message);

        if (typeof Swal !== 'undefined' && typeof Swal.fire === 'function') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: type,
                title: text,
                allowOutsideClick: true
            });
            return;
        }

        global.alert('[' + type.toUpperCase() + '] ' + text);
    }

    global.notifySuccess = function (message) { fire('success', message); };
    global.notifyError = function (message) { fire('error', message); };
    global.notifyWarning = function (message) { fire('warning', message); };
    global.notifyInfo = function (message) { fire('info', message); };
})(window);
