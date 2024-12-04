<?php

// 添加设置页面
function dpp_add_settings_page() {
    add_menu_page(
        __('默认密码保护设置', 'default-password-protection'), // 页面标题
        __('密码保护', 'default-password-protection'),        // 菜单标题
        'manage_options',  // 权限要求
        'default-password-protection', // 菜单 slug
        'dpp_render_settings_page',    // 页面回调函数
        'dashicons-lock',  // 图标
        80                 // 菜单位置
    );
}
add_action('admin_menu', 'dpp_add_settings_page');

// 渲染设置页面
function dpp_render_settings_page() {
    // 检查用户权限
    if (!current_user_can('manage_options')) {
        return;
    }

    // 保存设置
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dpp_settings_nonce']) && wp_verify_nonce($_POST['dpp_settings_nonce'], 'dpp_save_settings')) {
        update_option('dpp_enable_protection', isset($_POST['enable_protection']) ? 1 : 0);
        update_option('dpp_default_password', sanitize_text_field($_POST['default_password']));
        echo '<div class="updated"><p>' . __('设置已保存。', 'default-password-protection') . '</p></div>';
    }

    // 获取当前设置
    $enable_protection = get_option('dpp_enable_protection', 1);
    $default_password = get_option('dpp_default_password', 'thisismypassword');

    // 设置表单
    ?>
    <div class="wrap">
        <h1><?php _e('默认密码保护设置', 'default-password-protection'); ?></h1>
        <form method="post">
            <?php wp_nonce_field('dpp_save_settings', 'dpp_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="enable_protection"><?php _e('启用默认密码保护', 'default-password-protection'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="enable_protection" id="enable_protection" value="1" <?php checked($enable_protection, 1); ?>>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="default_password"><?php _e('默认密码', 'default-password-protection'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="default_password" id="default_password" value="<?php echo esc_attr($default_password); ?>" class="regular-text">
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" class="button button-primary"><?php _e('保存设置', 'default-password-protection'); ?></button>
            </p>
        </form>
    </div>
    <?php
}
