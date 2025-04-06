document.addEventListener('DOMContentLoaded', function () {
    // Модальное окно "Спасибо"
    const thankYouModalWindow = document.querySelector('.thank-you-modal');

    // Закрытие модального окна "Спасибо" при клике на кнопку закрытия
    const closeThankYouModalBtn = document.querySelector('.thank-you-modal-close');
    if (closeThankYouModalBtn) {
        closeThankYouModalBtn.addEventListener('click', () => {
            thankYouModalWindow.style.display = 'none';
        });
    }

    // Закрытие модального окна "Спасибо" при клике на кнопку "Хорошо"
    const thankYouButton = document.querySelector('.thank-you-button');
    if (thankYouButton) {
        thankYouButton.addEventListener('click', () => {
            thankYouModalWindow.style.display = 'none';
        });
    }

    // Закрытие модального окна "Спасибо" при клике вне его области
    window.addEventListener('click', (event) => {
        if (event.target === thankYouModalWindow) {
            thankYouModalWindow.style.display = 'none';
        }
    });
});