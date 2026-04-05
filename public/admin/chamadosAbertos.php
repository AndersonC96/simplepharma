<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('admin', '../index.php');

$db = get_db_connection();

// Pagination logic
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$offset = $current_page * $items_per_page;

// Count totals for pagination
$stmt_count = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status IN ('Aberto', 'Em Atendimento')");
$stmt_count->execute();
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Fetch open tickets with technician names
$query = "
    SELECT t.*, tech.full_name as technician_name 
    FROM tickets t 
    LEFT JOIN technicians tech ON t.technician_id = tech.id 
    WHERE t.status IN ('Aberto', 'Em Atendimento') 
    ORDER BY t.created_at DESC 
    LIMIT :limit OFFSET :offset
";
$stmt = $db->prepare($query);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$tickets = $stmt->fetchAll();

// View
Layout::header('Chamados em Aberto', 'chamados', $total_items);
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="card-title h5 mb-0">Chamados em Aberto (<?php echo $total_items; ?>)</h3>
            <a href="abrirchamadoAdmin.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Novo Chamado</a>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']['text']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Setor</th>
                        <th>Técnico</th>
                        <th>Abertura</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($tickets) > 0): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td>#<?php echo $ticket['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($ticket['title']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($ticket['location']); ?></td>
                                <td>
                                    <?php echo $ticket['technician_name'] ? htmlspecialchars($ticket['technician_name']) : '<span class="text-muted">Não atribuído</span>'; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])); ?></td>
                                <td>
                                    <?php 
                                        $badge_class = ($ticket['status'] === 'Aberto') ? 'bg-danger' : 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo htmlspecialchars($ticket['status']); ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="ver1chamadoAdmin.php?id=<?php echo $ticket['id']; ?>" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i> Detalhes
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Nenhum chamado em aberto no momento.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 0; $i < $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($current_page === $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="chamadosAbertos.php?page=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php Layout::footer(); ?>
