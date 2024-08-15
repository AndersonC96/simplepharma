<?php
    session_start();
    include('session_check.php');
    include("conexaodbAdmin.php");
    $status = 'Aberto';
    $stmt = $mysqli->prepare("SELECT * FROM chamados WHERE status = ?");
    $stmt->bind_param('s', $status);
    $stmt->execute();
    $execute = $stmt->get_result();
    $num = $execute->num_rows;
    $stmt_tecnicos = $mysqli->prepare("SELECT id, nome FROM tecnicos");
    $stmt_tecnicos->execute();
    $result_tecnicos = $stmt_tecnicos->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Abrir Chamado</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <style>
            .note-editor.note-frame{
                border-radius: 0.375rem;
                border-color: #ced4da;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }
            .note-toolbar{
                background-color: #f8f9fa;
                border-bottom: 1px solid #ced4da;
                border-radius: 0.375rem 0.375rem 0 0;
            }
            .note-editing-area{
                background-color: #fff;
                border-bottom: 1px solid #ced4da;
            }
            .note-editable{
                min-height: 200px;
                padding: 1rem;
                border-radius: 0 0 0.375rem 0.375rem;
            }
            .note-editor.note-frame .note-statusbar{
                background-color: #f8f9fa;
                border-top: 1px solid #ced4da;
            }
        </style>
    </head>
    <body>
        <?php include('navbarAdmin.php'); ?>
        <div class="container">
            <h2>Preencha os campos</h2>
            <form method="POST" action="processainsereChamado.php" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="username"><b>Nome do Usuário</b></label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="local"><b>Selecione um setor</b></label>
                    <select class="form-select" id="local" name="local">
                        <option>Almoxarifado</option>
                        <option>Conferência final</option>
                        <option>Conferência inicial</option>
                        <option>Desvincular</option>
                        <option>Expedição</option>
                        <option>Financeiro</option>
                        <option>Inclusão</option>
                        <option>Laboratório</option>
                        <option>Orçamento</option>
                        <option>RH</option>
                        <option>Recepção</option>
                        <option>SAC</option>
                        <option>TI</option>
                        <option>Uso contínuo</option>
                        <option>Vendas</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="phone"><b>Telefone</b></label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="(xx) xxxxx-xxxx" required>
                </div>
                <div class="form-group mb-3">
                    <label for="anydesk"><b>Anydesk</b></label>
                    <input type="text" class="form-control" id="anydesk" name="anydesk" placeholder="Digite o ID do Anydesk (se necessário)">
                </div>
                <div class="form-group mb-3">
                    <label for="titulo"><b>Título</b></label>
                    <textarea name="titulo" class="form-control" rows="3" id="titulo" placeholder="Insira o título do chamado" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="comment"><b>Ocorrência</b></label>
                    <textarea name="servico" class="form-control" rows="5" id="comment" placeholder="Descreva a ocorrência detalhadamente" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="anexos"><b>Anexos</b></label>
                    <input type="file" class="form-control" id="anexos" name="anexos[]" multiple>
                </div>
                <div class="form-group mb-3">
                    <label for="id"><b>Técnico</b></label>
                    <select name="id" class="form-select">
                        <?php while ($row = $result_tecnicos->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['nome']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="datetime"><b>Data</b></label>
                    <input type="text" class="form-control" id="datetime" name="dateFrom" required readonly>
                </div>
                <button type="submit" class="btn btn-success">Inserir Chamado</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote/lang/summernote-pt-BR.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#phone').mask('(00) 00000-0000');
                $('#comment').summernote({
                    height: 200,
                    lang: 'pt-BR',
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
                var datetimeField = document.getElementById("datetime");
                if(datetimeField){
                    datetimeField.value = moment().format("DD/MM/YYYY HH:mm");
                }
            });
        </script>
    </body>
</html>