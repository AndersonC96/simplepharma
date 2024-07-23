<?php
    error_reporting(0);
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "tecnico"){
    header('Location: ../index.php?err=2');
    exit();
}
?>
<?php
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = intval($_GET['pagina']);
    $tecnico = $_SESSION['sess_username'];
    $item = $pagina * $itens_por_pagina;
    $sql_code = "SELECT * FROM chamados WHERE tecnico='$tecnico' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("SELECT * FROM chamados WHERE tecnico='$tecnico'")->num_rows;
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
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Todos os Chamados</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="../img/favicon.png">
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <style>
            thead th{
                background-color: #008d93;
                color: white;
            }
            .table-striped tbody tr:nth-of-type(odd){
                background-color: rgba(0, 0, 0, .05);
            }
            .pagination{
                justify-content: center; /* Centraliza a paginação */
            }
            .pagination .page-link{
                color: #008d93;
            }
            .pagination .active .page-link{
                background-color: #008d93;
                border-color: #008d93;
            }
            .page-link:hover{
                background-color: #007a7a;
            }
            .badge-aberto{
                background-color: #dc3545;
                color: #fff;
            }
            .badge-feito{
                background-color: #28a745;
                color: #fff;
            }
            .badge-em-andamento{
                background-color: #ffc107;
                color: #fff;
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
        <br>
        <div class="container">
            <h2>Chamados Recentes</h2>
            <div class="table-responsive">
                <table class="table table-striped">
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
                                <span class="badge <?php echo ($produto['status'] == 'Aberto') ? 'badge-aberto' : ($produto['status'] == 'Feito' ? 'badge-feito' : 'badge-em-andamento'); ?>">
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
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="verchamadosTec.php?pagina=0" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                            for($i = 0; $i < $num_paginas; $i++){
                                $estilo = ($pagina == $i) ? 'class="active"' : '';
                        ?>
                        <li class="page-item" <?php echo $estilo; ?>><a class="page-link" href="verchamadosTec.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                        <?php } ?>
                        <li class="page-item">
                            <a class="page-link" href="verchamadosTec.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function (){
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl){
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>