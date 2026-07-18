window.LiveSearch = {
    init() {
        document.querySelectorAll('[live-search]').forEach((input) => {
            const key = input.getAttribute('live-search');
            if (!key) return;

            const items = Array.from(document.querySelectorAll(`[${key}]`));

            input.addEventListener('input', () => {
                const query = input.value.trim().toLowerCase();

                items.forEach((item) => {
                    const text = item.textContent.trim().toLowerCase();
                    item.hidden = !text.includes(query);
                });
            });
        });
    }
};

document.addEventListener('DOMContentLoaded', () => window.LiveSearch.init());