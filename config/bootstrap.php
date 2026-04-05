<?php

/**
 * Project bootstrap: autoloader, environment and session.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Security: Disable direct access to errors if in production
if (($_ENV['APP_ENV'] ?? 'production') === 'production') {
    ini_set('display_errors', 0);
    error_reporting(0);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Session Security Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_name($_ENV['SESSION_NAME'] ?? 'safetickets_session');
    session_start();
}

/**
 * Database Connection Wrapper
 */
function get_db_connection() {
    static $dbh = null;
    if ($dbh === null) {
        $config = require __DIR__ . '/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']};charset={$config['charset']}";
        try {
            $dbh = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Desculpe, ocorreu um problema com a conexão ao banco de dados.");
        }
    }
    return $dbh;
}
