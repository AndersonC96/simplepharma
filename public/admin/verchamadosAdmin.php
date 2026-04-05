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

// Count totals
$stmt_count = $db->query("SELECT COUNT(*) FROM tickets");
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Fetch all tickets
$query = "
    SELECT t.*, tech.full_name as technician_name 
    FROM tickets t 
    LEFT JOIN technicians tech ON t.technician_id = tech.id 
    ORDER BY t.created_at DESC 
    LIMIT :limit OFFSET :offset
";
$stmt = $db->prepare($query);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$tickets = $stmt->fetchAll();

// Count open tickets for navbar
$num_open = $db->query("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'")->fetchColumn();

// View
Layout::header('Listar Todos os Chamados', 'chamados', $num_open);
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h3 class="card-title h5 mb-4">Histórico Geral de Chamados</h3>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>OS</th>
                        <th>Título</th>
                        <th>Local</th>
                        <th>Técnico</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($tickets) > 0): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td>#<?php echo $ticket['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($ticket['title']); ?></strong></td>
                                <td><?php echo htmlspecialchars($ticket['location']); ?></td>
                                <td><?php echo $ticket['technician_name'] ? htmlspecialchars($ticket['technician_name']) : '---'; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])); ?></td>
                                <td>
                                    <?php 
                                        $status_colors = [
                                            'Aberto' => 'bg-danger',
                                            'Em Atendimento' => 'bg-warning text-dark',
                                            'Concluido' => 'bg-success',
                                            'Cancelado' => 'bg-secondary'
                                        ];
                                        $badge_class = $status_colors[$ticket['status']] ?? 'bg-primary';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo htmlspecialchars($ticket['status']); ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="ver1chamadoAdmin.php?id=<?php echo $ticket['id']; ?>" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Nenhum chamado registrado.</td>
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
                            <a class="page-link" href="verchamadosAdmin.php?page=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php Layout::footer(); ?>
