<?php

namespace App;

class Csrf
{
    /**
     * Generate a CSRF token.
     */
    public static function generateToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate a CSRF token.
     */
    public static function validateToken($token)
    {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }

    /**
     * Output a CSRF input field.
     */
    public static function field()
    {
        $token = self::generateToken();
        echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}
