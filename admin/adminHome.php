<?php

require_once __DIR__ . '/../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('admin', '../index.php');

$db = get_db_connection();

// Count open tickets - using NEW schema names
$stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'");
$stmt->execute();
$num_tickets = $stmt->fetchColumn();

// View
Layout::header('Área Administrativa', 'home', $num_tickets);
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h2">Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <p class="text-muted">Painel de gerenciamento do sistema de chamados.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-danger"><i class="fas fa-exclamation-circle"></i> Chamados em Aberto</h5>
                <h2 class="display-4 fw-bold"><?php echo $num_tickets; ?></h2>
                <a href="chamadosAbertos.php" class="btn btn-danger btn-sm">Ver Detalhes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-success"><i class="fas fa-check-circle"></i> Concluídos</h5>
                <p class="card-text">Gerenciar chamados finalizados.</p>
                <a href="chamadosConcluidos.php" class="btn btn-outline-success btn-sm">Acessar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-user-plus"></i> Novos Usuários</h5>
                <p class="card-text">Cadastrar técnicos ou clientes.</p>
                <a href="insereUsuario.php" class="btn btn-outline-primary btn-sm">Cadastrar</a>
            </div>
        </div>
    </div>
</div>

<?php Layout::footer(); ?>