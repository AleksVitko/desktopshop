<?php
/**
 * Файл functions.php для темы WordPress
 */

// 1. Подключение стилей и скриптов
function gomel_diesel_service_enqueue_styles() {
    // Подключение основного CSS файла
    wp_enqueue_style('gomel-diesel-service-style', get_stylesheet_uri(), [], '1.0');
    
    // Подключение Google Fonts (если требуется)
    wp_enqueue_style('gomel-diesel-service-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', [], null);
    
    // Подключение мобильных стилей только для мобильных устройств
    if (wp_is_mobile()) {
        wp_enqueue_style('gomel-diesel-service-mobile', get_template_directory_uri() . '/css/mobile.css', [], '1.0');
        // Мобильные модальные окна
        wp_enqueue_style('gomel-diesel-service-mobile-request-modal-style', get_template_directory_uri() . '/modals/styles/mobile-request.css', [], '1.0');
        wp_enqueue_style('gomel-diesel-service-mobile-thank-you-modal-style', get_template_directory_uri() . '/modals/styles/mobile-thank-you.css', [], '1.0');
    } else {
        // Десктопные модальные окна
        wp_enqueue_style('gomel-diesel-service-desktop-request-modal-style', get_template_directory_uri() . '/modals/styles/request.css', [], '1.0');
        wp_enqueue_style('gomel-diesel-service-desktop-thank-you-modal-style', get_template_directory_uri() . '/modals/styles/thank-you.css', [], '1.0');
    }
}
add_action('wp_enqueue_scripts', 'gomel_diesel_service_enqueue_styles');

function gomel_diesel_service_enqueue_scripts() {
    // Явное подключение jQuery
    wp_enqueue_script('jquery');
    
    // Подключение основного JavaScript файла
    wp_enqueue_script('gomel-diesel-service-main', get_template_directory_uri() . '/js/main.js', ['jquery'], '1.0', true);
    
    // Подключение мобильных скриптов только для мобильных устройств
    if (wp_is_mobile()) {
        wp_enqueue_script('gomel-diesel-service-mobile-request-modal', get_template_directory_uri() . '/modals/js/mobile-request.js', ['jquery'], '1.0', true);
        wp_enqueue_script('gomel-diesel-service-mobile-thank-you-modal', get_template_directory_uri() . '/modals/js/mobile-thank-you.js', ['jquery'], '1.0', true);
    } else {
        // Десктопные скрипты
        wp_enqueue_script('gomel-diesel-service-desktop-request-modal', get_template_directory_uri() . '/modals/js/request.js', ['jquery'], '1.0', true);
        wp_enqueue_script('gomel-diesel-service-desktop-thank-you-modal', get_template_directory_uri() . '/modals/js/thank-you.js', ['jquery'], '1.0', true);
    }
    
    // Перемещение всех скриптов в footer, кроме критичных
    function move_scripts_to_footer($tag, $handle) {
        // Исключаем скрипты, которые не должны быть в footer
        $exclude_handles = ['jquery-core', 'jquery-migrate', 'hoverintent-js', 'admin-bar-js'];
        if (!in_array($handle, $exclude_handles)) {
            $tag = str_replace(' src', ' defer src', $tag); // Добавляем атрибут defer для улучшения производительности
        }
        return $tag;
    }
    add_filter('script_loader_tag', 'move_scripts_to_footer', 10, 2);
}
add_action('wp_enqueue_scripts', 'gomel_diesel_service_enqueue_scripts');

// 2. Настройка темы
function gomel_diesel_service_setup() {
    // Добавляем поддержку title-tag для автоматического управления <title>
    add_theme_support('title-tag');
    
    // Добавляем поддержку миниатюр (featured images)
    add_theme_support('post-thumbnails');
    
    // Добавляем поддержку логотипа
    add_theme_support('custom-logo', array(
        'height'      => 70,
        'width'       => 70,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Добавляем поддержку HTML5 для различных элементов
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Добавляем поддержку языковых переводов
    load_theme_textdomain('gomel-diesel-service', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'gomel_diesel_service_setup');

// 3. Регистрация навигационных меню
function gomel_diesel_service_register_menus() {
    register_nav_menus(array(
        'primary'   => __('Главное меню', 'gomel-diesel-service'),
        'footer'    => __('Футер меню', 'gomel-diesel-service'),
    ));
}
add_action('init', 'gomel_diesel_service_register_menus');

// 4. Разрешение загрузки SVG-файлов
function gomel_diesel_service_allow_svg_uploads($mimes = array()) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'gomel_diesel_service_allow_svg_uploads');

// 5. Включение админ-бара только для администраторов
function gomel_diesel_service_enable_admin_bar_for_admins() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'gomel_diesel_service_enable_admin_bar_for_admins');

// 6. Удаление эмодзи и их скриптов
function gomel_diesel_service_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'gomel_diesel_service_disable_emojis_tinymce');
}
add_action('init', 'gomel_diesel_service_disable_emojis');

function gomel_diesel_service_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// 7. Оптимизация медиафайлов: увеличение максимального размера изображений
function gomel_diesel_service_increase_image_sizes() {
    update_option('large_size_w', 1920); // Ширина больших изображений
    update_option('large_size_h', 1080); // Высота больших изображений
    update_option('medium_size_w', 768); // Ширина средних изображений
    update_option('medium_size_h', 576); // Высота средних изображений
}
add_action('after_setup_theme', 'gomel_diesel_service_increase_image_sizes');

// 8. Добавление поддержки виджетов и сайдбаров
function gomel_diesel_service_widgets_init() {
    register_sidebar(array(
        'name'          => __('Основной сайдбар', 'gomel-diesel-service'),
        'id'            => 'sidebar-1',
        'description'   => __('Добавьте виджеты в этот сайдбар.', 'gomel-diesel-service'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'gomel_diesel_service_widgets_init');

// 9. Добавление поддержки breadcrumbs (хлебные крошки)
function gomel_diesel_service_breadcrumbs() {
    if (!is_home() && !is_front_page()) {
        echo '<div class="breadcrumbs">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . __('Главная', 'gomel-diesel-service') . '</a>';
        if (is_category() || is_single()) {
            echo ' / ' . single_cat_title('', false);
        } elseif (is_page()) {
            echo ' / ' . get_the_title();
        }
        echo '</div>';
    }
}
add_action('gomel_diesel_service_breadcrumbs', 'gomel_diesel_service_breadcrumbs');

// 10. Добавление поддержки постформатов (если нужно)
function gomel_diesel_service_add_post_formats() {
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
}
add_action('after_setup_theme', 'gomel_diesel_service_add_post_formats');

function enqueue_custom_scripts() {
    // Регистрируем и подключаем JavaScript
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', ['jquery'], null, true);

    // Передаем параметры AJAX в JavaScript
    wp_localize_script('custom-script', 'ajax_params', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('send_email')
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');