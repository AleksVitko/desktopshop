document.addEventListener('DOMContentLoaded', function () {
    // Кнопки для открытия мобильного модального окна
    const openMobileModalBtns = document.querySelectorAll('.request-button');
    
    // Кнопка для закрытия мобильного модального окна
    const closeMobileModalBtn = document.querySelector('.mobile-modal-close');
    
    // Само мобильное модальное окно
    const mobileModalWindow = document.querySelector('.mobile-modal-window');

    // Мобильное модальное окно "Спасибо"
    const mobileThankYouModalWindow = document.querySelector('.mobile-thank-you-modal');

    // Сообщение об ошибке
    const mobileErrorMessage = document.getElementById('mobile-error-message');

    // Открытие мобильного модального окна при клике на любую кнопку с классом request-button
    openMobileModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            mobileModalWindow.style.display = 'flex'; // Показать мобильное модальное окно
            mobileErrorMessage.textContent = ''; // Очистить сообщение об ошибке
        });
    });

    // Закрытие мобильного модального окна при клике на кнопку "X"
    if (closeMobileModalBtn) {
        closeMobileModalBtn.addEventListener('click', () => {
            mobileModalWindow.style.display = 'none'; // Скрыть мобильное модальное окно
        });
    }

    // Закрытие мобильного модального окна при клике вне его области
    window.addEventListener('click', (event) => {
        if (event.target === mobileModalWindow) {
            mobileModalWindow.style.display = 'none';
        }
    });

    // Обработка отправки формы
    const form = document.querySelector('.mobile-modal-form');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Предотвращаем стандартное поведение формы

            // Получаем значения полей
            const name = document.getElementById('mobile-name').value.trim();
            const phone = document.getElementById('mobile-phone').value.trim();

            // Регулярные выражения для валидации
            const namePattern = /^[а-яА-ЯёЁ\s]+$/; // Только кириллица и пробелы
            const phonePattern = /^\+375\s?\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/; // Формат +375 __ _______

            // Валидация имени
            if (!namePattern.test(name)) {
                mobileErrorMessage.textContent = 'Имя должно содержать только кириллические буквы и пробелы.';
                return;
            }

            // Валидация телефона
            if (!phonePattern.test(phone)) {
                mobileErrorMessage.textContent = 'Телефон должен быть в формате +375 __ _______.';
                return;
            }

            // Если все в порядке, отправляем форму (можно добавить AJAX-запрос)
            // Для теста просто скрываем форму и показываем окно "Спасибо"
            setTimeout(() => {
                mobileModalWindow.style.display = 'none';
                mobileThankYouModalWindow.style.display = 'flex';
            }, 3000);
        });
    }

    // Закрытие мобильного модального окна "Спасибо" при клике на кнопку закрытия
    const closeMobileThankYouModalBtn = document.querySelector('.mobile-thank-you-modal-close');
    if (closeMobileThankYouModalBtn) {
        closeMobileThankYouModalBtn.addEventListener('click', () => {
            mobileThankYouModalWindow.style.display = 'none';
        });
    }

    // Закрытие мобильного модального окна "Спасибо" при клике на кнопку "Хорошо"
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