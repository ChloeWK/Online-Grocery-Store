<?php
// ===========================
// config.php - Global configuration file
// ===========================

// ---------- Basic Settings of the site ----------
$base_url       = 'http://localhost/32516-assignment1/';  // Local debugging path
$site_title     = 'FreshMart - Online Grocery Store';
$company_name   = 'FreshMart';
$company_email  = 'info@freshmart.example.com';
$company_phone  = '+1 (555) 123-4567';
$site_description = "Your one-stop shop for fresh groceries and household essentials.";

// ---------- Error Report (Available development environment) ----------
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ---------- Time zone setting ----------
date_default_timezone_set('Australia/Sydney');

// ---------- Session Configuration (Security) ----------
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);         // Prohibit JS from accessing cookies
    ini_set('session.use_only_cookies', 1);        // session ID is prohibited in the URL
    ini_set('session.cookie_lifetime', 0);         // The session ends automatically when the browser is closed
    ini_set('session.gc_maxlifetime', 1440);       // Server session saving time
    session_start();
}

// ---------- Database Connection ----------
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "freshmart_db";

// Create a connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($mysqli->connect_errno) {
    die("数据库连接失败: " . $mysqli->connect_error);
}

// Set the encoding to prevent garbled characters
$mysqli->set_charset("utf8mb4");

// ---------- global constant ----------
define('SITE_NAME', 'FreshMart');
define('ADMIN_EMAIL', 'admin@freshmart.com');

// ---------- auxiliary function ----------
function redirect($url) {
    header("Location: " . $url);
    exit;
}

function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
