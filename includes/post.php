<?php

// 为新文章设置默认密码
function dpp_set_default_password($post_id, $post, $update) {
    // 获取启用状态
    $enable_protection = get_option('dpp_enable_protection', 1);
    if (!$enable_protection) {
        return;
    }

    // 仅对新文章生效
    if ($update || $post->post_type !== 'post') {
        return;
    }

    // 设置文章密码
    $default_password = get_option('dpp_default_password', '');
    wp_update_post([
        'ID'            => $post_id,
        'post_status'   => $post->post_status,
        'post_password' => $default_password
    ]);
}
add_action('wp_insert_post', 'dpp_set_default_password', 10, 3);