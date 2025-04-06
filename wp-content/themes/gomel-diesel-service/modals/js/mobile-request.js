document.addEventListener('DOMContentLoaded', function () {
    // Кнопки для открытия мобильного модального окна
    const openMobileModalBtns = document.querySelectorAll('.request-button');
    
    // Кнопка для закрытия мобильного модального окна
    const closeMobileModalBtn = document.querySelector('.mobile-modal-close');
    
    // Само мобильное модальное окно
    const mobileModalWindow = document.querySelector('.mobile-modal-window');

    // Скрытая форма Contact Form 7
    const hiddenCf7Form = document.getElementById('hiddenCf7Form');

    // Открытие мобильного модального окна при клике на любую кнопку с классом request-button
    openMobileModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            mobileModalWindow.style.display = 'flex'; // Показать мобильное модальное окно
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

                    // Показываем страницу "Спасибо" для мобильной версии
                    mobileModalWindow.style.display = 'none';
                    window.location.href = '/mobile-thank-you.html';
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