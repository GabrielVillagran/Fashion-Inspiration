document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('[data-submit-lock]');

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.submitted === 'true') {
                event.preventDefault();
                return;
            }

            form.dataset.submitted = 'true';

            const button = form.querySelector('[data-loading-button]');

            if (button) {
                button.disabled = true;
                button.classList.add('is-loading');
                button.textContent = button.dataset.loadingText || 'Processing...';
            }
        });
    });
});