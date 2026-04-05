<?php

require_once __DIR__ . '/../config/bootstrap.php';

use App\Auth;
use App\Layout;
use App\Csrf;

Auth::requireRole('admin', '../index.php');

$db = get_db_connection();

// Count open tickets
$stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE status = 'Aberto'");
$stmt->execute();
$num_tickets = $stmt->fetchColumn();

// Fetch technicians
$stmt_techs = $db->prepare("SELECT id, full_name FROM technicians");
$stmt_techs->execute();
$technicians = $stmt_techs->fetchAll();

Layout::header('Abrir Chamado', 'chamados', $num_tickets);
?>

<div class="row items-center justify-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 mb-4">Novo Chamado</h2>
                <form action="processainsereChamado.php" method="POST" enctype="multipart/form-data">
                    <?php Csrf::field(); ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Setor / Local</label>
                            <select class="form-select" name="location" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option>Almoxarifado</option>
                                <option>Expedição</option>
                                <option>Financeiro</option>
                                <option>RH</option>
                                <option>Recepção</option>
                                <option>TI</option>
                                <option>Vendas</option>
                                <option>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Telefone de Contato</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="(00) 00000-0000" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ID Acesso Remoto (opcional)</label>
                            <input type="text" class="form-control" name="remote_tool_id" placeholder="Ex: Anydesk ID">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Atribuir ao Técnico</label>
                            <select class="form-select" name="technician_id">
                                <option value="">Automático / Nenhum</option>
                                <?php foreach ($technicians as $tech): ?>
                                    <option value="<?php echo $tech['id']; ?>"><?php echo htmlspecialchars($tech['full_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Título do Problema</label>
                            <input type="text" class="form-control" name="title" placeholder="Resumo curto" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Descrição Detalhada</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Anexos (Imagens, PDF, Doc)</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                            <small class="text-muted">Máx: 5MB por arquivo.</small>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100">Abrir Chamado Agora</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function(){
        $('#phone').mask('(00) 00000-0000');
        $('#description').summernote({
            height: 150,
            placeholder: 'Descreva a ocorrência detalhadamente...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>

<?php Layout::footer(); ?>