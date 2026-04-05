<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;
use App\Csrf;

// Security check
Auth::requireRole('admin', '../index.php');

$db = get_db_connection();
$ticket_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch ticket details
$query = "
    SELECT t.*, u.name as user_name, u.email as user_email, tech.full_name as technician_name 
    FROM tickets t 
    JOIN users u ON t.user_id = u.id 
    LEFT JOIN technicians tech ON t.technician_id = tech.id 
    WHERE t.id = ?
";
$stmt = $db->prepare($query);
$stmt->execute([$ticket_id]);
$ticket = $stmt->fetch();

if (!$ticket) {
    header('Location: chamadosAbertos.php?err=notfound');
    exit();
}

// Fetch attachments
$stmt_files = $db->prepare("SELECT * FROM ticket_attachments WHERE ticket_id = ?");
$stmt_files->execute([$ticket_id]);
$attachments = $stmt_files->fetchAll();

// Count open tickets for navbar
$num_open = $db->query("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'")->fetchColumn();

// View
Layout::header("Chamado #$ticket_id", 'chamados', $num_open);
?>

<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="adminHome.php">Home</a></li>
                <li class="breadcrumb-item"><a href="chamadosAbertos.php">Chamados</a></li>
                <li class="breadcrumb-item active">#<?php echo $ticket_id; ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Ticket Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detalhes do Chamado</h5>
                <?php 
                    $status_colors = [
                        'Aberto' => 'bg-danger',
                        'Em Atendimento' => 'bg-warning text-dark',
                        'Concluido' => 'bg-success',
                        'Cancelado' => 'bg-secondary'
                    ];
                    $badge_class = $status_colors[$ticket['status']] ?? 'bg-primary';
                ?>
                <span class="badge <?php echo $badge_class; ?> px-3 py-2">
                    <?php echo htmlspecialchars($ticket['status']); ?>
                </span>
            </div>
            <div class="card-body">
                <h2 class="h4 mb-3"><?php echo htmlspecialchars($ticket['title']); ?></h2>
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold">Descrição</label>
                    <div class="p-3 bg-light rounded">
                        <?php echo $ticket['description']; // Summernote content ?>
                    </div>
                </div>

                <?php if ($attachments): ?>
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Anexos</label>
                        <div class="list-group list-group-flush border rounded mt-2">
                            <?php foreach ($attachments as $file): ?>
                                <a href="../<?php echo $file['file_path']; ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="far fa-file-alt me-2"></i> <?php echo htmlspecialchars($file['filename']); ?></span>
                                    <i class="fas fa-download text-primary"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Sidebar Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase fw-bold mb-3">Informações de Contato</h6>
                <p class="mb-1"><strong>Solicitante:</strong> <?php echo htmlspecialchars($ticket['user_name']); ?></p>
                <p class="mb-1"><strong>E-mail:</strong> <?php echo htmlspecialchars($ticket['user_email']); ?></p>
                <p class="mb-1"><strong>Setor:</strong> <?php echo htmlspecialchars($ticket['location']); ?></p>
                <p class="mb-1"><strong>Telefone:</strong> <?php echo htmlspecialchars($ticket['phone']); ?></p>
                <?php if ($ticket['remote_tool_id']): ?>
                    <p class="mb-1"><strong>Anydesk:</strong> <code><?php echo htmlspecialchars($ticket['remote_tool_id']); ?></code></p>
                <?php endif; ?>
                <hr>
                <p class="mb-1"><strong>Aberto em:</strong> <?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])); ?></p>
                <p class="mb-0"><strong>Técnico:</strong> <?php echo $ticket['technician_name'] ? htmlspecialchars($ticket['technician_name']) : '<em>Aguardando atribuição</em>'; ?></p>
            </div>
        </div>

        <!-- Quick Actions (Example form) -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase fw-bold mb-3">Ações Rápidas</h6>
                <form action="atualizaStatusAdmin.php" method="POST">
                    <?php Csrf::field(); ?>
                    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">
                    <div class="mb-3">
                        <label class="form-label">Alterar Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="Aberto" <?php echo $ticket['status'] == 'Aberto' ? 'selected' : ''; ?>>Aberto</option>
                            <option value="Em Atendimento" <?php echo $ticket['status'] == 'Em Atendimento' ? 'selected' : ''; ?>>Em Atendimento</option>
                            <option value="Concluido" <?php echo $ticket['status'] == 'Concluido' ? 'selected' : ''; ?>>Concluído</option>
                            <option value="Cancelado" <?php echo $ticket['status'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php Layout::footer(); ?>
