<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Csrf;
use App\Uploader;

// Security check
Auth::requireRole('admin', '../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: abrirchamadoAdmin.php');
    exit();
}

// CSRF Validation
if (!isset($_POST['csrf_token']) || !Csrf::validateToken($_POST['csrf_token'])) {
    die("Sessão inválida ou expirada.");
}

$db = get_db_connection();

// Inputs
$user_id = $_SESSION['user_id'];
$location = $_POST['location'] ?? 'Outro';
$phone = $_POST['phone'] ?? '';
$remote_tool_id = $_POST['remote_tool_id'] ?? '';
$title = $_POST['title'] ?? 'Sem Título';
$description = $_POST['description'] ?? '';
$technician_id = !empty($_POST['technician_id']) ? (int)$_POST['technician_id'] : null;
$status = 'Aberto';

try {
    $db->beginTransaction();

    // Insert Ticket
    $stmt = $db->prepare("INSERT INTO tickets (user_id, title, location, phone, remote_tool_id, description, technician_id, status, opened_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $user_id, $title, $location, $phone, $remote_tool_id, $description, $technician_id, $status
    ]);
    
    $ticket_id = $db->lastInsertId();

    // Handle Uploads
    if (!empty($_FILES['attachments']['name'][0])) {
        $uploads = Uploader::upload($_FILES['attachments'], $user_id);
        
        foreach ($uploads as $file) {
            $stmt_file = $db->prepare("INSERT INTO ticket_attachments (ticket_id, user_id, filename, file_path, file_type) VALUES (?, ?, ?, ?, ?)");
            $stmt_file->execute([
                $ticket_id, $user_id, $file['original_name'], $file['stored_path'], $file['mime_type']
            ]);
        }
    }

    $db->commit();
    $_SESSION['message'] = ['type' => 'success', 'text' => 'Chamado aberto com sucesso! ID: #' . $ticket_id];
    header('Location: chamadosAbertos.php');

} catch (Exception $e) {
    if ($db->inTransaction()) $db->rollBack();
    error_log("Error opening ticket: " . $e->getMessage());
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Erro ao abrir o chamado. Por favor, tente novamente.'];
    header('Location: abrirchamadoAdmin.php');
}
exit();
