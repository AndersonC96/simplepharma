<?php

namespace App;

use PDO;

class Auth
{
    /**
     * Authenticate user with password_verify.
     * 
     * @param string $email
     * @param string $password
     * @return array|bool User data on success, false otherwise.
     */
    public static function login($email, $password)
    {
        $db = get_db_connection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND active = 1 LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Secure session handling
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return $user;
        }

        return false;
    }

    /**
     * Check if user is logged in.
     */
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if user has a specific role.
     */
    public static function hasRole($role)
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
    }

    /**
     * Require a specific role or redirect.
     */
    public static function requireRole($role, $redirect = 'index.php')
    {
        if (!self::hasRole($role)) {
            header("Location: $redirect?err=unauthorized");
            exit();
        }
    }

    /**
     * Logout user.
     */
    public static function logout()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
