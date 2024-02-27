<?php
    error_reporting(0);
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = intval($_GET['pagina']);
    $item = $pagina * $itens_por_pagina;
    //$sql_code = "select contador, local, tecnico, datahora, status, servico from chamados ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $sql_code = "select contador, local, tecnico, datahora, status, servico from chamados WHERE usuario='{$_SESSION['sess_usersisname']}' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    //$num_total = $conn->query("select contador, local, tecnico, datahora, status, servico from chamados")->num_rows;
    $num_total = $conn->query("select contador, local, tecnico, datahora, status, servico from chamados WHERE usuario='{$_SESSION['sess_usersisname']}'")->num_rows;
    $num_paginas = ceil($num_total / $itens_por_pagina);
?>
<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "subadmin"){
        header('Location: ../index.php?err=2');
    }
?>
<?php
    include("conexaodbAdmin.php");
    $sql_code2 = "select * from chamados WHERE status='Aberto'";
    $execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
    $produto2 = $execute2->fetch_assoc();
    $num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Todos os Chamados</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><b style="color: rgb(83 168 177)">Simple Pharma</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="subadminHome.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown"  aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu multi-level">
                                <li><a class="dropdown-item" href="abrirchamadoSadmin.php">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoSadmin.php">Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num2; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosSadmin.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h2>Chamados Recentes</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <?php if($num > 0){ ?>
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
                            <td class="text-center"><?php echo $produto['contador'];?></td>
                            <td class="text-center"><?php echo $produto['local'];?></td>
                            <td class="text-center"><?php echo $produto['tecnico']; ?></td>
                            <td class="text-center"><?php echo $produto['datahora']; ?></td>
                            <?php if($produto['status'] == "Aberto"){?>
                            <td style="background-color:#F00;" class="text-center"><?php echo $produto['status']; ?></td>
                            <?php }elseif($produto['status'] == "Feito"){?>
                            <td style="background-color:#0F0;" class="text-center"><?php echo $produto['status']; ?></td>
                            <?php } ?>
                            <td class="text-center"><a class="btn btn-info btn-sm" href="ver1chamadoAdmin.php?chamado=<?php echo $produto['contador'];?>" data-toggle="tooltip" title="Detalhes"><span class="bi bi-share"></span> Ver</a></td>
                            </tr>
                        <?php }while($produto = $execute->fetch_assoc()); ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="verchamadosAdmin.php?pagina=0" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                            for($i = 0; $i < $num_paginas; $i++){
                                $estilo = "";
                                if($pagina == $i)
                                    $estilo = "class=\"active\"";
                        ?>
                        <li class="page-item" <?php echo $estilo; ?> ><a class="page-link" href="verchamadosSadmin.php?pagina=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
                        <?php } ?>
                        <li class="page-item">
                            <a class="page-link" href="verchamadosSadmin.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-Vt1hF/c5tDb2ja7mV9vnjrS4OFkxhghKp8ZURok2HnUv3KT0jZjR/RcRUqc5fZp" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>