<?php
/**
 * The template for displaying the footer.
 *
 * @package YourThemeName
 */

?>
<footer class="footer" id="contakt">
    <!-- Левый контейнер -->
<div class="container-left">
    <div class="contact-infos">
        <h2>Контакты</h2>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/mingcute_phone-line.png" alt="Телефон">
            <p>+375 29 611 37 53</p>
        </div>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/mingcute_phone-line.png" alt="Телефон">
            <p>+375 29 640 08 28</p>
        </div>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/material-symbols_location-on-outline-rounded.png" alt="Адрес">
            <p>246010, г. Гомель, ул. Могилевская, 45</p>
        </div>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/material-symbols_location-on-outline-rounded.png" alt="Адрес">
            <p>г. Гомель, ул. Могилевская, 19 Г, к. 3 (по навигатору)</p>
        </div>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/mingcute_time-line.png" alt="Время работы">
            <p>8:00–17:00<br>обед 12:00–13:00<br>Сб, Вс — выходной</p>
        </div>
        <div class="contact-item">
            <img class="icon" src="/wp-content/themes/gomel-diesel-service/images/material-symbols_mail-outline.png" alt="Почта">
            <p>al2009ra@yandex.ru</p>
        </div>
    </div>
</div>

    <!-- Правый контейнер -->
    <div class="container-right">
        <img src="/wp-content/themes/gomel-diesel-service/images/image24.png" alt="Photo" class="photo">
    </div>

    <!-- Линия -->
    <div class="line"></div>

    <!-- Нижний контейнер -->
    <div class="bottom-container">
        <p>©2024 Частное сервисное унитарное предприятие «Гомель-Дизель-Сервис»</p>
        <p><a href="#">Политика обработки персональных данных</a></p>
        <p>Создание сайта: <a href="https://artcly.by" target="_blank">ArtCly.by</a></p>
    </div>
    <?php dynamic_sidebar('footer-widgets'); ?>
</footer>

<!-- Десктопная форма "Заявка" -->
<?php include get_template_directory() . '/modals/request.html'; ?>

<!-- Десктопное сообщение "Спасибо" -->
<?php include get_template_directory() . '/modals/thank-you.html'; ?>

<!-- Мобильная форма "Заявка" -->
<?php include get_template_directory() . '/modals/mobile-request.html'; ?>

<!-- Мобильное сообщение "Спасибо" -->
<?php include get_template_directory() . '/modals/mobile-thank-you.html'; ?>

<?php wp_footer(); ?>
</body>
</html>