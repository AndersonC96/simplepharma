<?php
    include("conexaodbAdmin.php");
    $sql_code = "SELECT * FROM chamados WHERE status='Aberto'";
    $execute = $mysqli->query($sql_code) or die($mysqli->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
?>
<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "subadmin"){
        header('Location: ../index.php?err=2');
    }
    $chamado = $_GET["chamado"];
?>
<?php
    include("conexao.php");
    $sql_code = "SELECT usuario, contador, local, tecnico, datahora, status, servico, serviexecu, datahoraaber, datahorafim FROM chamados WHERE contador='$chamado'";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Chamado: <?php echo $chamado; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <style>
            .table-custom{
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 1rem;
                background-color: #fff;
                border-radius: 0.5rem;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            }
            .table-custom th, .table-custom td{
                padding: 0.75rem;
                vertical-align: middle;
                border-top: 1px solid #dee2e6;
            }
            .table-custom thead th{
                background-color: #008d93;
                color: white;
                text-align: center;
                font-weight: 600;
            }
            .table-custom tbody tr:hover{
                background-color: #f1f1f1;
            }
            .badge-status{
                padding: 0.35em 0.65em;
                font-size: 0.75em;
                font-weight: 600;
                border-radius: 0.2rem;
                text-transform: uppercase;
            }
            .status-aberto{
                background-color: #ff0707;
                color: #fcfcfc;
            }
            .status-feito{
                background-color: #28a745;
                color: #fff;
            }
            .page-link{
                color: #008d93;
            }
            .page-link:hover{
                color: #fff;
                background-color: #008d93;
                border-color: #008d93;
            }
            .page-item.active .page-link{
                color: #fff;
                background-color: #008d93;
                border-color: #008d93;
            }
            .card{
                margin-top: 2rem;
                margin-bottom: 2rem;
                padding: 2rem;
                border-radius: 1rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }
            .card-header{
                background-color: #008d93;
                color: #fff;
            }
            .badge-estado{
                font-size: 1em;
            }
            .bg-aberto{
                background-color: #dc3545;
                color: #fff;
            }
            .bg-feito{
                background-color: #28a745;
                color: #fff;
            }
            body {
                margin: 0; /* Remove qualquer margem padrão do body */
            }
            nav.navbar {
                margin-bottom: 0; /* Remove margem inferior da navbar */
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary px-0 py-3">
            <div class="container-xl">
                <a class="navbar-brand" href="#">
                    <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" class="h-12" alt="...">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-lg-auto">
                        <a class="nav-item nav-link active" href="subadminHome.php" aria-current="page">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-envelope"></i> Chamados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoSadmin.php"><i class="bi bi-plus-circle"></i> Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoSadmin.php"><i class="bi bi-trash"></i> Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="bi bi-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="bi bi-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosSadmin.php"><i class="bi bi-list"></i> Listar Chamados</a></li>
                            </ul>
                        </li>
                    </div>
                    <div class="navbar-nav ms-lg-4">
                        <a class="nav-item nav-link" href="#"><i class="bi bi-person"></i> <?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?></a>
                    </div>
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-sm btn-secondary w-full w-lg-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container my-5">
            <h2 class="text-center mb-4"><strong>Dados do Chamado <?php echo $chamado; ?></strong></h2>
            <div class="card">
                <div class="card-header"><strong>Informações do Chamado</strong></div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Usuário:</strong> <?php echo $produto['usuario']; ?></li>
                    <li class="list-group-item"><strong>Local do chamado:</strong> <?php echo $produto['local']; ?></li>
                    <li class="list-group-item"><strong>Serviço Solicitado:</strong> <?php echo $produto['servico']; ?></li>
                    <li class="list-group-item"><strong>Data e Hora da abertura:</strong> <?php echo $produto['datahora']; ?></li>
                    <li class="list-group-item"><strong>Técnico Responsável:</strong> <?php echo $produto['tecnico']; ?></li>
                    <li class="list-group-item"><strong>Serviço Executado:</strong> <?php echo $produto['serviexecu']; ?></li>
                    <li class="list-group-item"><strong>Data e Hora Início do Atendimento:</strong> <?php echo $produto['datahoraaber']; ?></li>
                    <li class="list-group-item"><strong>Data e Hora Final do Atendimento:</strong> <?php echo $produto['datahorafim']; ?></li>
                    <li class="list-group-item">
                        <strong>Status do Chamado:</strong>
                        <span class="badge <?php echo ($produto['status'] == 'Aberto') ? 'bg-aberto' : 'bg-feito'; ?>">
                            <?php echo $produto['status']; ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>