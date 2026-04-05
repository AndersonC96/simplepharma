<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('subadmin', '../index.php');

$db = get_db_connection();
$user_id = $_SESSION['user_id'];

// SubAdmin sees only their own tickets? 
// Original code was inconsistent, but generally subadmins are 'clients' in this context.
$stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE user_id = ? AND status IN ('Aberto', 'Em Atendimento')");
$stmt->execute([$user_id]);
$num_tickets = $stmt->fetchColumn();

// View
Layout::header('Painel do Usuário', 'home', $num_tickets);
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h2">Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <p class="text-muted">Acompanhe seus chamados e solicitações.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title text-primary"><i class="fas fa-ticket-alt"></i> Meus Chamados Abertos</h5>
                <h2 class="display-4 fw-bold"><?php echo $num_tickets; ?></h2>
                <a href="chamadosAbertos.php" class="btn btn-primary btn-sm">Ver Meus Chamados</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                <h5>Precisa de ajuda?</h5>
                <p class="text-muted">Abra um novo chamado para suporte técnico.</p>
                <a href="abrirchamadoSadmin.php" class="btn btn-success">Abrir Novo Chamado</a>
            </div>
        </div>
    </div>
</div>

<?php Layout::footer(); ?>
