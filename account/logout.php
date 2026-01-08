<?php
// 包含配置文件
require_once __DIR__ . '/../config.php';

// 清空 session 数据
$_SESSION = array();

// 如果使用 session cookie，清除 cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 销毁 session
session_destroy();

// 重定向回首页
redirect($base_url . 'index.php');
