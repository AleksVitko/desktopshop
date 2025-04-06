document.addEventListener('DOMContentLoaded', function () {
    // Мобильное модальное окно "Спасибо"
    const mobileThankYouModalWindow = document.querySelector('.mobile-thank-you-modal');

    // Кнопка закрытия мобильного модального окна "Спасибо"
    const closeMobileThankYouModalBtn = document.querySelector('.mobile-thank-you-modal-close');
    if (closeMobileThankYouModalBtn) {
        closeMobileThankYouModalBtn.addEventListener('click', () => {
            mobileThankYouModalWindow.style.display = 'none';
        });
    }

    // Кнопка "Хорошо" в мобильном модальном окне "Спасибо"
    const mobileThankYouButton = document.querySelector('.mobile-thank-you-button');
    if (mobileThankYouButton) {
        mobileThankYouButton.addEventListener('click', () => {
            mobileThankYouModalWindow.style.display = 'none';
        });
    }

    // Закрытие мобильного модального окна "Спасибо" при клике вне его области
    window.addEventListener('click', (event) => {
        if (event.target === mobileThankYouModalWindow) {
            mobileThankYouModalWindow.style.display = 'none';
        }
    });
});