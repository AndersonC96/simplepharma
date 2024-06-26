<?php
    error_reporting(0);
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "tecnico"){
        header('Location: ../index.php?err=2');
    }
?>
<?php
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = intval($_GET['pagina']);
    $tecnico = $_SESSION['sess_username'];
    $item = $pagina * $itens_por_pagina;
    $sql_code = "select * from chamados WHERE  tecnico='$tecnico' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("select * from chamados WHERE tecnico='$tecnico'")->num_rows;
    $num_paginas = ceil($num_total / $itens_por_pagina);
?>
<?php
    include("conexaodbAdmin.php");
    $sql_code2 = "select * from chamados WHERE status='Aberto' AND tecnico='$tecnico'";
    $execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
    $produto2 = $execute2->fetch_assoc();
    $num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Todos meus chamados</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><b style="color: rgb(83 168 177)">Simple Pharma</b></a>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item active"><a class="nav-link" href="tecnicoHome.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="chamadosabertosTec.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num2; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosconcluidosTec.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosTec.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h3>Todos os Chamados para <b style="color: rgb(83 168 177)"><?php echo $_SESSION['sess_usersisname']; ?></b></h3>
            <table class="table table-striped table-bordered">
                <?php if($num > 0){ ?>
                <thead>
                    <tr>
                        <th class="text-center">OS</th>
                        <th class="text-center">Local</th>
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
                        <td class="text-center"><?php echo $produto['datahora']; ?></td>
                        <?php if($produto['status'] == "Aberto"){ ?>
                        <td style="background-color:#F00;" class="text-center"><?php echo $produto['status']; ?></td>
                        <?php }elseif($produto['status'] == "Feito"){ ?>
                        <td style="background-color:#0F0;" class="text-center"> <?php echo $produto['status']; ?></td>
                        <?php } ?>
                        <td class="text-center"><a class="btn btn-info btn-sm" href="ver1chamadoTecnico.php?chamado=<?php echo $produto['contador']; ?>" data-bs-toggle="tooltip" title="Detalhes"><span class="glyphicon glyphicon-share"></span>Ver</a></td>
                    </tr>
                    <?php }while($produto = $execute->fetch_assoc()); ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li>
                        <a href="verchamadosTec.php?pagina=0" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                        for($i = 0; $i < $num_paginas; $i++){
                            $estilo = "";
                            if($pagina == $i)
                                $estilo = "class=\"active\"";
                    ?>
                    <li <?php echo $estilo; ?>><a href="verchamadosTec.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                    <?php } ?>
                    <li>
                        <a href="verchamadosTec.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </body>
</html>