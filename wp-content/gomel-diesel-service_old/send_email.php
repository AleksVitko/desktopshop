<?php
/**
 * send_email.php - Обработка отправки письма через wp_mail()
 */

function send_email_handler() {
    // Проверяем nonce для безопасности
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'send_email')) {
        wp_send_json_error(['message' => 'Недопустимый запрос!']);
    }

    // Получаем данные из POST-запроса
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Проверяем обязательные поля
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Все поля обязательны для заполнения!']);
    }

    // Настройки для отправки письма
    $to = 'sasavitko552@gmail.com'; // Замените на свой email
    $subject = 'Новое сообщение с сайта';
    $body = "Имя: $name\nEmail: $email\nСообщение: $message";
    $headers = [
        'From: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8'
    ];

    // Отправляем письмо через wp_mail()
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(['message' => 'Сообщение успешно отправлено!']);
    } else {
        wp_send_json_error(['message' => 'Ошибка при отправке сообщения!']);
    }
}

// Добавляем действие для обработки AJAX-запроса
add_action('wp_ajax_send_email', 'send_email_handler');
add_action('wp_ajax_nopriv_send_email', 'send_email_handler');