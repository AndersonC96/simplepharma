<?php
	error_reporting(0);
	include("conexao.php");
	$itens_por_pagina = 10;
	$pagina = intval($_GET['pagina']);
	$item = $pagina * $itens_por_pagina;
	$sql_code = "select contador,local,tecnico,datahora,status,servico from chamados WHERE status='Feito' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
	$execute = $conn->query($sql_code) or die($conn->error);
	$produto = $execute->fetch_assoc();
	$num = $execute->num_rows;
	$num_total = $conn->query("select contador,local,tecnico,datahora,status,servico from chamados WHERE status='Feito'")->num_rows;
	$num_paginas = ceil($num_total/$itens_por_pagina);
?>
<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role!="admin"){
		header('Location: ../index.php?err=2');
    }
?>
<?php
	include("conexaodbAdmin.php");
	$sql_code2 = "select * from chamados WHERE status='Aberto'";
	$execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
	$produto2 = $execute->fetch_assoc();
	$num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Chamados Concluídos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png">
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <style>
            thead th{
            background-color: #008d93;
            color: white;
            }
            .page-link{
            color: #008d93;
            }
            .page-link:hover{
            color: white;
            background-color: #008d93;
            border-color: #008d93;
            }
            .page-item.active .page-link{
                color: white;
                background-color: #008d93;
                border-color: #008d93;
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
                        <a class="nav-item nav-link active" href="adminHome.php" aria-current="page">Home</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoAdmin.php">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoAdmin.php">Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Técnico</a>
                            <ul class="dropdown-menu" aria-labelledby="tecnicoDropdown">
                                <li><a class="dropdown-item" href="inseretecnicoRes.php">Inserir Técnico</a></li>
                                <li><a class="dropdown-item" href="removetecnicoRes.php">Remover Técnico</a></li>
                                <li><a class="dropdown-item" href="verTecnicos.php">Ver Técnicos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuários</a>
                            <ul class="dropdown-menu" aria-labelledby="tecnicoDropdown">
                                <li><a class="dropdown-item" href="insereUsuario.php">Inserir Usuário</a></li>
                                <li><a class="dropdown-item" href="removeUsuario.php">Remover Usuário</a></li>
                                <li><a class="dropdown-item" href="verUsuarios.php">Ver Usuários</a></li>
                            </ul>
                        </li>
                    </div>
                    <div class="navbar-nav ms-lg-4">
                        <a class="nav-item nav-link" href="#"><?php echo $_SESSION['sess_usersisname']; ?></a>
                    </div>
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-sm btn-secondary w-full w-lg-auto">Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h3>Chamados Concluídos</h3>
            <div class="table-responsive">
                <table class="table table-striped">
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
                            <?php if ($produto['status']=="Aberto"){?>
                            <td style="background-color:#F00;" class="text-center"> <?php echo $produto['status']; ?></td>
                            <?php }elseif ($produto['status']=="Feito") {?>
                            <td style="background-color:#0F0;" class="text-center"> <?php echo $produto['status']; ?></td>
                            <?php } ?>
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="ver1chamadoAdmin.php?chamado=<?php echo $produto['contador'];?>" data-toggle="tooltip" title="Detalhes"><span class="glyphicon glyphicon-share"></span>Ver</a>
                            </td>
                        </tr>
                        <?php }while($produto = $execute->fetch_assoc()); ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="chamadosConcluidos.php?pagina=0" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                            for($i = 0; $i < $num_paginas; $i++){
                                $estilo = "";
                                if($pagina == $i)
                                    $estilo = "class=\"active\"";
                        ?>
                        <li class="page-item" <?php echo $estilo; ?>><a class="page-link" href="chamadosConcluidos.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                        <?php } ?>
                        <li class="page-item">
                            <a class="page-link" href="chamadosConcluidos.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>