document.addEventListener('DOMContentLoaded', function () {
    // Кнопки для открытия модального окна
    const openModalBtns = document.querySelectorAll('.request-button');
    
    // Кнопка для закрытия модального окна
    const closeModalBtn = document.querySelector('.modal-close');
    
    // Само модальное окно
    const modalWindow = document.querySelector('.modal-window');

    // Скрытая форма Contact Form 7
    const hiddenCf7Form = document.getElementById('hiddenCf7Form');

    // Открытие модального окна при клике на любую кнопку с классом request-button
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modalWindow.style.display = 'flex'; // Показать модальное окно
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

            try {
                // Получаем значения полей
                const name = form.querySelector('input[name="user_name"]').value.trim();
                const phone = form.querySelector('input[name="user_phone"]').value.trim();

                // Регулярные выражения для валидации
                const namePattern = /^[а-яА-ЯёЁ\s]+$/; // Только кириллица и пробелы
                const phonePattern = /^\+375\s?\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/; // Формат +375 __ _______

                // Валидация имени
                if (!namePattern.test(name)) {
                    alert('Имя должно содержать только кириллические буквы и пробелы.');
                    return;
                }

                // Валидация телефона
                if (!phonePattern.test(phone)) {
                    alert('Телефон должен быть в формате +375 __ _______.');
                    return;
                }

                // Находим скрытую форму Contact Form 7
                const cf7Form = hiddenCf7Form.querySelector('form');
                if (cf7Form) {
                    // Заполняем поля скрытой формы
                    cf7Form.querySelector('input[name="your-name"]').value = name;
                    cf7Form.querySelector('input[name="your-phone"]').value = phone;

                    // Эмулируем отправку скрытой формы
                    cf7Form.dispatchEvent(new Event('submit'));

                    // Показываем модальное окно "Спасибо"
                    modalWindow.style.display = 'none';

                    // Загружаем страницу "Спасибо" для десктопной версии
                    window.location.href = '/thank-you.html';
                } else {
                    alert('Произошла ошибка при отправке формы.');
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при отправке формы.');
            }
        });
    }
});