document.addEventListener('DOMContentLoaded', function () {
    // Открытие/закрытие мобильного меню
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

    menuToggle.addEventListener('click', function () {
        mobileMenuOverlay.classList.toggle('active');
        this.classList.toggle('open');
    });

    // Закрытие меню при клике вне области
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.mobile-menu-container') && !event.target.closest('.menu-toggle')) {
            if (mobileMenuOverlay.classList.contains('active')) {
                mobileMenuOverlay.classList.remove('active');
                menuToggle.classList.remove('open');
            }
        }
    });
});

// Открытие/закрытие контактного меню
function toggleContactMenu() {
    const contactOverlay = document.getElementById('contactOverlay');
    contactOverlay.classList.toggle('active');
}

// Закрытие контактного меню при клике вне области
document.addEventListener('click', function (event) {
    const contactOverlay = document.getElementById('contactOverlay');
    if (!event.target.closest('.contact-container') && !event.target.closest('.phone-toggle')) {
        if (contactOverlay.classList.contains('active')) {
            contactOverlay.classList.remove('active');
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Кнопка для открытия модального окна
    const openModalBtn = document.getElementById('open-request-modal');
    
    // Кнопка для закрытия модального окна
    const closeModalBtn = document.querySelector('.modal-close');
    
    // Само модальное окно
    const modalWindow = document.querySelector('.modal-window');
    // Модальное окно "Спасибо"
    const thankYouModalWindow = document.querySelector('.thank-you-modal');
    // Скрытая форма Contact Form 7
    const hiddenCf7Form = document.getElementById('hiddenCf7Form');
    // Ваша кастомная форма
    const customForm = document.getElementById('contactForm');

    // Открытие модального окна при клике на кнопку
    if (openModalBtn) {
        openModalBtn.addEventListener('click', () => {
            modalWindow.style.display = 'flex'; // Показать модальное окно
        });
    }

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

    // Обработка отправки вашей кастомной формы
    if (customForm && hiddenCf7Form) {
        customForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Предотвращаем стандартную отправку формы

            try {
                // Получаем данные из вашей формы
                const formData = {
                    your_name: customForm.querySelector('input[name="user_name"]').value.trim(),
                    your_phone: customForm.querySelector('input[name="user_phone"]').value.trim()
                };

                // Проверяем обязательные поля
                if (!formData.your_name || !formData.your_phone) {
                    alert('Заполните все обязательные поля!');
                    return;
                }

                // Находим скрытую форму Contact Form 7
                const cf7Form = hiddenCf7Form.querySelector('form');
                if (cf7Form) {
                    // Заполняем поля скрытой формы
                    cf7Form.querySelector('input[name="your-name"]').value = formData.your_name;
                    cf7Form.querySelector('input[name="your-phone"]').value = formData.your_phone;

                    // Эмулируем отправку скрытой формы
                    cf7Form.dispatchEvent(new Event('submit'));

                    // Показываем модальное окно "Спасибо"
                    modalWindow.style.display = 'none';
                    thankYouModalWindow.style.display = 'flex';

                    // Очищаем форму после успешной отправки
                    customForm.reset();
                } else {
                    console.error('Скрытая форма Contact Form 7 не найдена.');
                    alert('Произошла ошибка при отправке формы.');
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при отправке формы.');
            }
        });
    }

    // Функция для закрытия модального окна "Спасибо"
    function closeThankYouModal() {
        thankYouModalWindow.style.display = 'none';
    }
});