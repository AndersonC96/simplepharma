<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Csrf;

// Security check
Auth::requireRole('admin', '../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: chamadosAbertos.php');
    exit();
}

// CSRF Validation
if (!isset($_POST['csrf_token']) || !Csrf::validateToken($_POST['csrf_token'])) {
    die("Sessão inválida ou expirada.");
}

$db = get_db_connection();

$ticket_id = (int)($_POST['ticket_id'] ?? 0);
$status = $_POST['status'] ?? '';
$allowed_status = ['Aberto', 'Em Atendimento', 'Concluido', 'Cancelado'];

if (!in_array($status, $allowed_status)) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Status inválido.'];
    header("Location: ver1chamadoAdmin.php?id=$ticket_id");
    exit();
}

try {
    $stmt = $db->prepare("UPDATE tickets SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$status, $ticket_id]);

    $_SESSION['message'] = ['type' => 'success', 'text' => "Status do chamado #$ticket_id atualizado para '$status'."];
    header("Location: ver1chamadoAdmin.php?id=$ticket_id");

} catch (Exception $e) {
    error_log("Error updating ticket status: " . $e->getMessage());
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Erro ao atualizar o status.'];
    header("Location: ver1chamadoAdmin.php?id=$ticket_id");
}
exit();
