<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;

// Security check
Auth::requireRole('tecnico', '../index.php');

$db = get_db_connection();
$user_id = $_SESSION['user_id'];

// Get technician ID for this user
$stmt_tech = $db->prepare("SELECT id FROM technicians WHERE user_id = ?");
$stmt_tech->execute([$user_id]);
$tech_id = $stmt_tech->fetchColumn();

// Count assigned open tickets
$num_tickets = 0;
if ($tech_id) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status IN ('Aberto', 'Em Atendimento') AND technician_id = ?");
    $stmt->execute([$tech_id]);
    $num_tickets = $stmt->fetchColumn();
}

// View
Layout::header('Área do Técnico', 'home', $num_tickets);
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h2">Painel do Técnico: <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <p class="text-muted">Gerencie seus chamados atribuídos.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-warning"><i class="fas fa-tools"></i> Seus Chamados Ativos</h5>
                <h2 class="display-4 fw-bold"><?php echo $num_tickets; ?></h2>
                <p class="text-muted">Chamados aguardando sua ação.</p>
                <a href="chamadosabertosTec.php" class="btn btn-warning btn-sm mt-auto">Ver Meus Chamados</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-success"><i class="fas fa-history"></i> Histórico</h5>
                <p class="card-text">Visualize chamados que você já concluiu.</p>
                <a href="chamadosconcluidosTec.php" class="btn btn-outline-success btn-sm mt-auto">Ver Concluídos</a>
            </div>
        </div>
    </div>
</div>

<?php Layout::footer(); ?>
