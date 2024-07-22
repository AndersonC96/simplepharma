<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "tecnico"){
        header('Location: ../index.php?err=2');
        exit();
    }
?>
<?php
    error_reporting(0);
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $tecnico = $_SESSION['sess_username'];
    $item = $pagina * $itens_por_pagina;
    $sql_code = "SELECT contador, local, tecnico, datahora, status, servico FROM chamados WHERE status='Feito' AND tecnico='$tecnico' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("SELECT contador, local, tecnico, datahora, status, servico FROM chamados WHERE status='Feito' AND tecnico='$tecnico'")->num_rows;
    $num_paginas = ceil($num_total / $itens_por_pagina);
?>
<?php
    include("conexaodbAdmin.php");
    $sql_code2 = "SELECT * FROM chamados WHERE status='Aberto' AND tecnico='$tecnico'";
    $execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
    $num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Chamados Concluídos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="../img/favicon.png">
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
                color: #fafbfc;
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
                        <a class="nav-item nav-link active" href="tecnicoHome.php" aria-current="page">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-envelope"></i> Chamados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="chamadosabertosTec.php"><i class="bi bi-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num2; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosconcluidosTec.php"><i class="bi bi-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosTec.php"><i class="bi bi-list"></i> Listar Chamados</a></li>
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
        <div class="container mt-4">
            <h3 class="text-center">Chamados Concluídos</h3>
            <div class="table-responsive">
                <table class="table table-custom">
                    <?php if ($num > 0){ ?>
                    <thead>
                        <tr>
                            <th class="text-center">OS</th>
                            <th class="text-center">Local</th>
                            <th class="text-center">Técnico</th>
                            <th class="text-center">Abertura</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php do{ ?>
                        <tr>
                            <td class="text-center"><?php echo $produto['contador']; ?></td>
                            <td class="text-center"><?php echo $produto['local']; ?></td>
                            <td class="text-center"><?php echo $produto['tecnico']; ?></td>
                            <td class="text-center"><?php echo $produto['datahora']; ?></td>
                            <td class="text-center">
                                <span class="badge badge-status <?php echo 'status-' . strtolower(str_replace(' ', '-', $produto['status'])); ?>">
                                    <?php echo $produto['status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="ver1chamadoTecnico.php?chamado=<?php echo $produto['contador']; ?>" data-bs-toggle="tooltip" title="Detalhes"><i class="bi bi-eye"></i> Ver</a>
                            </td>
                        </tr>
                        <?php } while ($produto = $execute->fetch_assoc()); ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="chamadosconcluidosTec.php?pagina=0" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                            for($i = 0; $i < $num_paginas; $i++){
                                $estilo = ($pagina == $i) ? 'class="active"' : '';
                        ?>
                        <li class="page-item" <?php echo $estilo; ?>><a class="page-link" href="chamadosconcluidosTec.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                        <?php } ?>
                        <li class="page-item">
                            <a class="page-link" href="chamadosconcluidosTec.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl){
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    </body>
</html>