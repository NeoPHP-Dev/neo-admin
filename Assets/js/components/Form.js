window.Form = {

    init() {
        this.togglePassword();
    },

    togglePassword() {
        document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const wrap = btn.closest('[data-password-wrap]');
                const input = wrap.querySelector('input');
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    }

};

document.addEventListener('DOMContentLoaded', () => window.Form.init());