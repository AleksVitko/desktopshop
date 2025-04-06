<?php
/**
 * send_email.php - ��������� �������� ������ ����� wp_mail()
 */

function send_email_handler() {
    // ��������� nonce ��� ������������
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'send_email')) {
        wp_send_json_error(['message' => '������������ ������!']);
    }

    // �������� ������ �� POST-�������
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // ��������� ������������ ����
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => '��� ���� ����������� ��� ����������!']);
    }

    // ��������� ��� �������� ������
    $to = 'sasavitko552@gmail.com'; // �������� �� ���� email
    $subject = '����� ��������� � �����';
    $body = "���: $name\nEmail: $email\n���������: $message";
    $headers = [
        'From: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8'
    ];

    // ���������� ������ ����� wp_mail()
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(['message' => '��������� ������� ����������!']);
    } else {
        wp_send_json_error(['message' => '������ ��� �������� ���������!']);
    }
}

// ��������� �������� ��� ��������� AJAX-�������
add_action('wp_ajax_send_email', 'send_email_handler');
add_action('wp_ajax_nopriv_send_email', 'send_email_handler');