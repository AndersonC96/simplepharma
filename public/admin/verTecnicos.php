<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('admin', '../index.php');

$db = get_db_connection();

// Pagination logic
$items_per_page = 12;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$offset = $current_page * $items_per_page;

// Count totals
$stmt_count = $db->query("SELECT COUNT(*) FROM technicians");
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Fetch technicians
$stmt = $db->prepare("SELECT * FROM technicians ORDER BY full_name ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$technicians = $stmt->fetchAll();

// Count open tickets for navbar
$num_open = $db->query("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'")->fetchColumn();

Layout::header('Gerenciar Técnicos', 'admin', $num_open);
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="card-title h5 mb-0">Corpo Técnico (<?php echo $total_items; ?>)</h3>
            <a href="insereUsuario.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Novo Técnico</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome Completo</th>
                        <th>Especialidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($technicians) > 0): ?>
                        <?php foreach ($technicians as $tech): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($tech['full_name']); ?></strong></td>
                                <td>
                                    <?php echo $tech['specialty'] ? htmlspecialchars($tech['specialty']) : '<span class="text-muted">Geral</span>'; ?>
                                </td>
                                <td>
                                    <button class="btn btn-outline-secondary btn-sm" disabled>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Nenhum técnico cadastrado.</td>
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
                            <a class="page-link" href="verTecnicos.php?page=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php Layout::footer(); ?>
