<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'pressing3_db');
define('DB_USER', 'root');
define('DB_PASS', 'YAH_K01');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'pressing & buanderie');
define('APP_URL', 'http://localhost/pressing3/public');
define('BASE_PATH', dirname(__DIR__));

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}