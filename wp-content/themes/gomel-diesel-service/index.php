<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Гомель-Дизель-Сервис
 */

get_header();
?>

<main>
    <!-- Первый экран -->
    <div class="container-1">
        <div class="image-overlay">
            <div class="content-center">
                <h1>Ремонт автотранспортных<br>средств, спецтехники,<br>сельхозтехники</h1>
                <p class="description">Ремонт дизельной топливной аппаратуры, стартеров, генераторов, двигателей, КПП,<br>компьютерная диагностика, услуги автоэлектрика, шлифовка коленчатых валов и ГБЦ</p>
                <button id="open-request-modal" class="request-button">Оставить заявку</button>
                <button id="open-mobile-request-modal" class="mobile-request-button">Оставить заявку</button>
            </div>
        </div>
    </div> <!-- Конец Первый экран -->
    
    <!-- Буллиты -->
    <div class="main-container">
        <div class="feature-container">
            <div class="image-container">
                <img src="/wp-content/themes/gomel-diesel-service/images/Frame.png" alt="Высокое качество" class="icon-image">
            </div>
            <p class="feature-description">Высокое<br>качество</p>
        </div>

        <div class="feature-container">
            <div class="image-container">
                <img src="/wp-content/themes/gomel-diesel-service/images/Frame (1).png" alt="Широкий ассортимент услуг" class="icon-image">
            </div>
            <p class="feature-description">Широкий ассортимент<br>услуг</p>
        </div>

        <div class="feature-container">
            <div class="image-container">
                <img src="/wp-content/themes/gomel-diesel-service/images/Frame (2).png" alt="Минимальные сроки" class="icon-image">
            </div>
            <p class="feature-description">Минимальные<br>сроки</p>
        </div>

        <div class="feature-container">
            <div class="image-container">
                <img src="/wp-content/themes/gomel-diesel-service/images/Frame (3).png" alt="Опыт работы" class="icon-image">
            </div>
            <p class="feature-description">Опыт<br>работы</p>
        </div>
    </div> <!-- Конец Буллиты -->
    
    <!-- Наши услуги -->
    <div class="services-container" id="uslugi">
    <h2 class="services-title">Наши услуги</h2>
        <div class="services-grid">
            <!-- Контейнер услуги #1 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image.png" alt="Ремонт ТНВД" class="service-image">
                <h3 class="service-title">Ремонт ТНВД</h3>
                <p class="service-description">Евро - 0, 1, 2, 3, 4 (в том числе ТНВД Bosch и их модификации)</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #2 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image (1).png" alt="Услуга 2" class="service-image">
                <h3 class="service-title">Ремонт форсунок</h3>
                <p class="service-description">Евро - 2, 3, 4, 5, ультразвуковая чистка бензиновых форсунок</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #3 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/i.png" alt="Услуга 3" class="service-image">
                <h3 class="service-title">Ремонт двигателей</h3>
                <p class="service-description">Грузовых автомобилей, сельхозтехники, спецтехники</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #4 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image (2).png" alt="Услуга 4" class="service-image">
                <h3 class="service-title">Ремонт КПП</h3>
                <p class="service-description">Грузовых автомобилей белорусского и российского производства</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #5 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/Frame 46.png" alt="Услуга 5" class="service-image">
                <h3 class="service-title">Ремонт стартеров и генераторов</h3>
                <p class="service-description">Производства стран СНГ, китайского производства</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #6 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image (3).png" alt="Услуга 6" class="service-image">
                <h3 class="service-title">Шлифовка коленчатых валов</h3>
                <p class="service-description">Шлифовка коленчатых валов</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #7 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/Remont-GBTS.png" alt="Услуга 7" class="service-image">
                <h3 class="service-title">Шлифовка и ремонт ГБЦ, проверка на герметичность</h3>
                <p class="service-description"></p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #8 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image (4).png" alt="Услуга 8" class="service-image">
                <h3 class="service-title">Компьютерная диагностика грузовых автомобилей</h3>
                <p class="service-description">Евро - 3, 4</p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
    
            <!-- Контейнер услуги #9 -->
            <div class="service-item">
                <img src="/wp-content/themes/gomel-diesel-service/images/image (5).png" alt="Услуга 9" class="service-image">
                <h3 class="service-title">Услуги автоэлектрика </h3>
                <p class="service-description">По ремонту грузовых автомобилей белорусского и российского производства </p>
                <button id="open-request-modal" class="request-button">Записаться на ремонт</button>
            </div>
        </div>
    </div> <!-- Наши услуги -->
    
    <!-- Блок формы -->
    <div class="contact-form-container" id="forms">
        <div class="form-overlay"></div>
        <form class="contact-form" action="#" method="POST" id="contactForm">
            <div class="contact-info-form">
                <h3>Звоните или оставьте заявку</h3>
                <div class="phone-numbers">
                    <div class="phone-number-item">
                        <img src="/wp-content/themes/gomel-diesel-service/images/Group.png" alt="Phone Icon" width="24" height="24" />
                        <p><strong>+375 29 611 37 53</strong></p>
                    </div>
                    <div class="phone-number-item">
                        <img src="/wp-content/themes/gomel-diesel-service/images/Group.png" alt="Phone Icon" width="24" height="24" />
                        <p><strong>+375 29 640 08 28</strong></p>
                    </div>
                </div>
                <div class="working-hours">
                    <p>Пн-пт 8:00–17:00<br>Обед 12:00–13:00<br>Сб, Вс — выходной</p>
                </div>
            </div>
            <!-- Поля ввода -->
            <div class="input-fields">
                <input type="text" name="user_name" placeholder="Ваше имя" required>
                <input type="tel" name="user_phone" placeholder="+375 __ ___ ___ ___" required>
                <button type="submit">Оставить заявку</button>
            </div>
            <!-- Согласие с политикой -->
            <div class="agreement">
                <input type="checkbox" id="privacy-agreement" name="privacy-agreement" required>
                <label for="privacy-agreement">
                    Соглашаюсь с <a href="#">Политикой обработки</a> персональных данных
                </label>
            </div>
        </form>
        
        <!-- Скрытая форма Contact Form 7 -->
        <div style="display: none;" id="hiddenCf7Form">
            [contact-form-7 id="5a087f4" title="Контактная форма 1"]
        </div>
        
    </div> <!-- Конец Блок формы -->
    
    <!-- О компании -->
    <div class="company-container" id="company">
        <h2 class="company-title">О компании</h2>
        <div class="content-container">
            <div class="text-container">
                <!-- Текст о компании -->
                <p>Частное сервисное унитарное предприятие «Гомель-Дизель-Сервис» предлагает широкий спектр услуг для поддержания вашей техники в отличном состоянии. Мы выполняем ремонт дизельной топливной аппаратуры (ТНВД, форсунок), стартеров, генераторов, двигателей и КПП, шлифовку коленчатых валов и ГБЦ.</p>
                <p>Кроме того, у нас вы можете воспользоваться услугами компьютерной диагностики для точного выявления неисправностей, а также услугами профессионального автоэлектрика. Наши опытные специалисты гарантируют высокое качество и надежность всех выполняемых работ.</p>
                <p>Будем рады видеть вас в числе наших заказчиков, надеемся на взаимовыгодное сотрудничество! Мы хотим быть успешными и понимаем, что наш успех – это, в первую очередь, успех наших клиентов.</p>
                <!-- Блок с информацией о годах -->
                <div class="info-block">
                    <div class="info-item">
                        <span class="number">>12</span>
                        <span class="label">лет на рынке услуг</span>
                    </div>
                    <div class="info-item">
                        <span class="number">>1000+</span>
                        <span class="label">довольных клиентов по всей области и близлежащих областях РФ</span>
                    </div>
                </div>
            </div>
            <div class="image-containers">
                <!-- Изображение -->
                <img src="/wp-content/themes/gomel-diesel-service/images/image (6).png" alt="Компания">
            </div>
        </div>
    </div> <!-- Конец О компании -->
    
    <!-- Мы ремонтируем -->
    <div class="custom-repair-container">
        <h2 class="custom-repair-title">Мы ремонтируем</h2>
        <div class="custom-repair-images">
            <!-- Первый ряд -->
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image 1.png" alt="Image 1"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (7).png" alt="Image 2"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (8).png" alt="Image 3"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (9).png" alt="Image 4"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (10).png" alt="Image 5"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (11).png" alt="Image 6"></div>
    
            <!-- Второй ряд -->
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (12).png" alt="Image 4"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (13).png" alt="Image 5"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (14).png" alt="Image 6"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (15).png" alt="Image 4"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (16).png" alt="Image 5"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (17).png" alt="Image 6"></div>
    
            <!-- Третий ряд -->
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (18).png" alt="Image 7"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (19).png" alt="Image 8"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (20).png" alt="Image 9"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (21).png" alt="Image 4"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (22).png" alt="Image 5"></div>
            <div class="custom-repair-image"><img src="/wp-content/themes/gomel-diesel-service/images/image (23).png" alt="Image 6"></div>
        </div>
    </div> <!-- Конец Мы ремонтируем -->

<!-- JavaScript to validate the checkbox -->
<script>
    document.getElementById('contactForm').addEventListener('submit', function (event) {
        const checkbox = document.getElementById('privacy-agreement');
        if (!checkbox.checked) {
            event.preventDefault(); // Prevent form submission
            alert('Пожалуйста, примите условия Политики обработки персональных данных.');
        }
    });
</script>
</main>
<?php get_footer(); ?>