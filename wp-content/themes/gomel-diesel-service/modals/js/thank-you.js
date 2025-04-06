document.addEventListener('DOMContentLoaded', function () {
    // Кнопка закрытия модального окна "Спасибо"
    const closeThankYouModalBtn = document.querySelector('.thank-you-modal-close');
    if (closeThankYouModalBtn) {
        closeThankYouModalBtn.addEventListener('click', () => {
            window.history.back(); // Возвращаемся на предыдущую страницу
        });
    }

    // Кнопка "Хорошо" в модальном окне "Спасибо"
    const thankYouButton = document.querySelector('.thank-you-button');
    if (thankYouButton) {
        thankYouButton.addEventListener('click', () => {
            window.history.back(); // Возвращаемся на предыдущую страницу
        });
    }
});