<?php
/*
Plugin Name: Default Password Protection
Description: This plugin sets a default password protection for new posts and provides a backend settings page.
Version: 1.0
Author: Kun JIN
Author URI: http://www.flykun.com
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: default-password-protection
Domain Path: /languages
*/


// 防止直接访问
if (!defined('ABSPATH')) exit;

// 加载插件的语言文件
function dpp_load_textdomain() {
    load_plugin_textdomain('default-password-protection', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'dpp_load_textdomain');

// 引入其他文件
require_once plugin_dir_path(__FILE__) . 'includes/admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/post.php';

// 初始化插件
function dpp_init() {
    // 其他初始化操作
}
add_action('plugins_loaded', 'dpp_init');


// 添加设置链接
function dpp_add_settings_link($links) {
    // 在插件列表的操作按钮后面添加设置按钮
    $settings_link = '<a href="admin.php?page=default-password-protection">'.__('设置', 'default-password-protection').'</a>';
    array_unshift($links, $settings_link); // 插入到开头
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'dpp_add_settings_link');
