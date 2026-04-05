<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Auth;
use App\Layout;
use App\Csrf;

// Security check
Auth::requireRole('subadmin', '../index.php');

$db = get_db_connection();
$user_id = $_SESSION['user_id'];

// Count open tickets for navbar
$stmt_count = $db->prepare("SELECT COUNT(*) FROM tickets WHERE user_id = ? AND status IN ('Aberto', 'Em Atendimento')");
$stmt_count->execute([$user_id]);
$num_open = $stmt_count->fetchColumn();

Layout::header('Abrir Chamado', 'chamados', $num_open);
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 mb-4">Novo Chamado</h2>
                <form action="processainsereChamado.php" method="POST" enctype="multipart/form-data">
                    <?php Csrf::field(); ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Seu Setor / Local</label>
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
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">ID Anydesk (se necessário)</label>
                            <input type="text" class="form-control" name="remote_tool_id" placeholder="Digite o ID para acesso remoto">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Título Resumido</label>
                            <input type="text" class="form-control" name="title" placeholder="Ex: Problema com impressora" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Descrição da Ocorrência</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Anexos</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                            <small class="text-muted">Formatos permitidos: JPG, PNG, PDF, DOCX.</small>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success w-100 py-2">Enviar Chamado</button>
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
            placeholder: 'Descreva detalhadamente o problema ou solicitação...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']]
            ]
        });
    });
</script>

<?php Layout::footer(); ?>
