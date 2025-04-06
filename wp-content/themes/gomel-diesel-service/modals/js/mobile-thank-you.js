document.addEventListener('DOMContentLoaded', function () {
    // Кнопка закрытия мобильного модального окна "Спасибо"
    const closeMobileThankYouModalBtn = document.querySelector('.mobile-thank-you-modal-close');
    if (closeMobileThankYouModalBtn) {
        closeMobileThankYouModalBtn.addEventListener('click', () => {
            window.history.back(); // Возвращаемся на предыдущую страницу
        });
    }

    // Кнопка "Хорошо" в мобильном модальном окне "Спасибо"
    const mobileThankYouButton = document.querySelector('.mobile-thank-you-button');
    if (mobileThankYouButton) {
        mobileThankYouButton.addEventListener('click', () => {
            window.history.back(); // Возвращаемся на предыдущую страницу
        });
    }
});