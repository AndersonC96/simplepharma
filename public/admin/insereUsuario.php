<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;
use App\Csrf;

Auth::requireRole('admin', '../index.php');

$db = get_db_connection();
$num_open = $db->query("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'")->fetchColumn();

Layout::header('Cadastrar Usuário', 'admin', $num_open);
$default_role = $_GET['role'] ?? 'subadmin';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 mb-4">Novo Usuário do Sistema</h2>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['message']['text']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <form method="POST" action="processacadUser.php">
                    <?php Csrf::field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome Completo</label>
                        <input type="text" class="form-control" name="name" placeholder="Ex: João Silva" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">E-mail (Login)</label>
                        <input type="email" class="form-control" name="email" placeholder="email@empresa.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Senha Inicial</label>
                        <input type="password" class="form-control" name="password" required minlength="6">
                        <small class="text-muted">Mínimo de 6 caracteres.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nível de Acesso</label>
                        <select class="form-select" name="role" required>
                            <option value="subadmin" <?php echo $default_role === 'subadmin' ? 'selected' : ''; ?>>SubAdmin (Acesso limitado)</option>
                            <option value="admin" <?php echo $default_role === 'admin' ? 'selected' : ''; ?>>Admin (Acesso total)</option>
                            <option value="tecnico" <?php echo $default_role === 'tecnico' ? 'selected' : ''; ?>>Técnico (Acesso ao painel técnico)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3">
                        <i class="fas fa-user-plus"></i> Inserir Usuário
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php Layout::footer(); ?>
