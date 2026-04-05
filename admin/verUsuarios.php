<?php

require_once __DIR__ . '/../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('admin', '../index.php');

$db = get_db_connection();

// Pagination & Search logic
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$offset = $current_page * $items_per_page;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order']) ? $_GET['order'] : 'id DESC';

// Validate order_by to prevent SQL injection (even with limit/offset, it's good practice)
$allowed_orders = ['id DESC', 'id ASC', 'name ASC', 'name DESC', 'email ASC', 'email DESC'];
if (!in_array($order_by, $allowed_orders)) $order_by = 'id DESC';

// Count totals
$stmt_count = $db->prepare("SELECT COUNT(*) FROM users WHERE name LIKE ? OR email LIKE ?");
$stmt_count->execute(["%$search%", "%$search%"]);
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// Fetch users
$query = "SELECT id, name, email, role, active, created_at FROM users WHERE name LIKE :search OR email LIKE :search ORDER BY $order_by LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

// Count open tickets for navbar
$num_open = $db->query("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'")->fetchColumn();

Layout::header('Gerenciar Usuários', 'admin', $num_open);
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="card-title h5 mb-0">Usuários do Sistema (<?php echo $total_items; ?>)</h3>
            <a href="insereUsuario.php" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Novo Usuário</a>
        </div>

        <!-- Search Form -->
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar por nome ou e-mail..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="col-md-3">
                <select name="order" class="form-select form-select-sm">
                    <option value="id DESC" <?php echo $order_by == 'id DESC' ? 'selected' : ''; ?>>Mais recentes</option>
                    <option value="name ASC" <?php echo $order_by == 'name ASC' ? 'selected' : ''; ?>>Nome (A-Z)</option>
                    <option value="email ASC" <?php echo $order_by == 'email ASC' ? 'selected' : ''; ?>>E-mail (A-Z)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">Filtrar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Papel</th>
                        <th>Status</th>
                        <th>Criado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($user['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo strtoupper($user['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user['active']): ?>
                                        <span class="text-success small"><i class="fas fa-check-circle"></i> Ativo</span>
                                    <?php else: ?>
                                        <span class="text-danger small"><i class="fas fa-times-circle"></i> Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
                                    <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum usuário encontrado.</td>
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
                            <a class="page-link" href="verUsuarios.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&order=<?php echo urlencode($order_by); ?>">
                                <?php echo $i + 1; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php Layout::footer(); ?>