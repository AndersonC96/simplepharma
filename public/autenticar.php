<?php

require_once __DIR__ . '/../config/bootstrap.php';

use App\Auth;
use App\Csrf;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// CSRF Validation
if (!isset($_POST['csrf_token']) || !Csrf::validateToken($_POST['csrf_token'])) {
    header('Location: index.php?err=csrf');
    exit();
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (Auth::login($email, $password)) {
    $role = $_SESSION['user_role'];
    
    // Redirect based on role
    switch ($role) {
        case 'admin':
            header('Location: admin/adminHome.php');
            break;
        case 'tecnico':
            header('Location: tecnico/tecnicoHome.php');
            break;
        case 'subadmin':
            header('Location: subadmin/subadminHome.php');
            break;
        default:
            Auth::logout();
            header('Location: index.php?err=1');
    }
} else {
    header('Location: index.php?err=1');
}
exit();
