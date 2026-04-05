<?php

require_once __DIR__ . '/../config/bootstrap.php';

use App\Auth;
use App\Csrf;

// Security check
Auth::requireRole('admin', '../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: insereUsuario.php');
    exit();
}

// CSRF Validation
if (!isset($_POST['csrf_token']) || !Csrf::validateToken($_POST['csrf_token'])) {
    die("Sessão inválida ou expirada.");
}

$db = get_db_connection();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'subadmin';

// Simple validation
if (empty($name) || empty($email) || empty($password)) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Todos os campos são obrigatórios.'];
    header('Location: insereUsuario.php');
    exit();
}

try {
    $db->beginTransaction();

    // Check if email already exists
    $stmt_check = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt_check->execute([$email]);
    if ($stmt_count = $stmt_check->fetchColumn() > 0) {
        throw new Exception("E-mail já cadastrado no sistema.");
    }

    // Secure Hashing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert User
    $stmt = $db->prepare("INSERT INTO users (name, email, password, role, active) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$name, $email, $hashed_password, $role]);
    
    $user_id = $db->lastInsertId();

    // If role is tecnico, we should also insert into technicians table for consistency
    if ($role === 'tecnico') {
        $stmt_tech = $db->prepare("INSERT INTO technicians (user_id, full_name) VALUES (?, ?)");
        $stmt_tech->execute([$user_id, $name]);
    }

    $db->commit();
    $_SESSION['message'] = ['type' => 'success', 'text' => "Usuário '$name' cadastrado com sucesso!"];
    header('Location: insereUsuario.php');

} catch (Exception $e) {
    if ($db->inTransaction()) $db->rollBack();
    error_log("Error creating user: " . $e->getMessage());
    $_SESSION['message'] = ['type' => 'danger', 'text' => $e->getMessage() ?: 'Erro ao cadastrar usuário.'];
    header('Location: insereUsuario.php');
}
exit();