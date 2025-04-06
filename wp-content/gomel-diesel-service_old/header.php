<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container">
        <!-- Логотип -->
        <div class="logo-container">
            <div class="logo">
                <?php if (function_exists('the_custom_logo')) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="path/to/logo.png" alt="Логотип">
                <?php endif; ?>
            </div>
            <div class="site-title">
                <span>Гомель-</span><br>
                <span>Дизель-</span><br>
                <span>Сервис</span>
            </div>
        </div>

        <!-- Меню (для десктопной версии) -->
        <div class="menu-container">
            <nav class="main-menu desktop-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'menu',
                    'container'      => false,
                    'items_wrap'     => '<ul class="menu">%3$s</ul>',
                    'link_before'    => '<span>',
                    'link_after'     => '</span>',
                ));
                ?>
            </nav>
        </div>

        <!-- Контактная информация -->
        <div class="contact-info">
            <!-- Адрес и почта -->
            <div class="contact-block">
                <!-- Адрес -->
                <div class="address">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    <p>246010, г.Гомель,<br>ул.Могилевская, 45</p>
                </div>
                <!-- Почта -->
                <div class="email">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <a href="mailto:al2009ra@yandex.ru" class="email-link">al2009ra@yandex.ru</a>
                </div>
            </div>
            <!-- Телефоны -->
            <div class="phone-container">
                <a href="tel:+375296113753">+375 29 611 37 53</a>
                <a href="tel:+375296400828">+375 29 640 08 28</a>
            </div>
        </div>

        <!-- Кнопки меню и телефона для мобильной версии -->
        <div class="menu-phone-container">
            <!-- Кнопка меню -->
            <div class="menu-toggle-container">
                <div class="menu-toggle" id="menuToggle">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
            </div>
            <!-- Контейнер для кнопки телефона -->
            <div class="phone-toggle-container">
                <div class="phone-toggle" onclick="toggleContactMenu()">
                    <img src="/wp-content/themes/gomel-diesel-service/images/mingcute_phone-line.png" alt="Телефон">
                </div>
            </div>
        </div>

        <!-- Контейнер контактов для мобильной версии -->
        <div class="contact-overlay" id="contactOverlay">
            <div class="contact-container">
                <div class="contact-list">
                    <!-- Телефоны -->
                    <p><a href="tel:+375296113753">+375 29 611 37 53</a></p>
                    <p><a href="tel:+375296400828">+375 29 640 08 28</a></p>
                    <!-- Адрес -->
                    <div class="contact-item">
                        <span class="icon-location" style="width: 26px; height: 26px; display: inline-block;"></span>
                        <span>246010, г. Гомель,<br>ул. Могилевская, 45</span>
                    </div>
                    <!-- Почта -->
                    <div class="contact-item">
                        <span class="icon-email" style="width: 26px; height: 26px; display: inline-block;"></span>
                        <span><a href="mailto:al2009ra@yandex.ru">al2009ra@yandex.ru</a></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Контейнер меню для мобильной версии -->
        <div class="mobile-menu-overlay" id="mobileMenuOverlay">
            <div class="mobile-menu-container">
                <nav class="mobile-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'menu',
                        'container'      => false,
                        'items_wrap'     => '<ul class="%1$s">%3$s</ul>',
                        'link_before'    => '',
                        'link_after'     => '',
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>
