document.addEventListener('DOMContentLoaded', function () {
    // Кнопки для открытия модального окна
    const openModalBtns = document.querySelectorAll('.request-button');
    
    // Кнопка для закрытия модального окна
    const closeModalBtn = document.querySelector('.modal-close');
    
    // Само модальное окно
    const modalWindow = document.querySelector('.modal-window');

    // Модальное окно "Спасибо"
    const thankYouModalWindow = document.querySelector('.thank-you-modal');

    // Сообщение об ошибке
    const errorMessage = document.getElementById('error-message');

    // Открытие модального окна при клике на любую кнопку с классом request-button
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modalWindow.style.display = 'flex'; // Показать модальное окно
            errorMessage.textContent = ''; // Очистить сообщение об ошибке
        });
    });

    // Закрытие модального окна при клике на кнопку "X"
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modalWindow.style.display = 'none'; // Скрыть модальное окно
        });
    }

    // Закрытие модального окна при клике вне его области
    window.addEventListener('click', (event) => {
        if (event.target === modalWindow) {
            modalWindow.style.display = 'none';
        }
    });

    // Обработка отправки формы
    const form = document.querySelector('.modal-form');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Предотвращаем стандартное поведение формы

            // Получаем значения полей
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();

            // Регулярные выражения для валидации
            const namePattern = /^[а-яА-ЯёЁ\s]+$/; // Только кириллица и пробелы
            const phonePattern = /^\+375\s?\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/; // Формат +375 __ _______

            // Валидация имени
            if (!namePattern.test(name)) {
                errorMessage.textContent = 'Имя должно содержать только кириллические буквы и пробелы.';
                return;
            }

            // Валидация телефона
            if (!phonePattern.test(phone)) {
                errorMessage.textContent = 'Телефон должен быть в формате +375 __ _______.';
                return;
            }

            // Если все в порядке, отправляем форму (можно добавить AJAX-запрос)
            // Для теста просто скрываем форму и показываем окно "Спасибо"
            setTimeout(() => {
                modalWindow.style.display = 'none';
                thankYouModalWindow.style.display = 'flex';
            }, 3000);
        });
    }

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