<?php
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = intval($_GET['pagina']);
    $item = $pagina * $itens_por_pagina;
    $sql_code = "select contador,local,tecnico,datahora,status,servico from chamados WHERE Status='Aberto' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("select contador,local,tecnico,datahora,status,servico from chamados WHERE Status='Aberto'")->num_rows;
    $num_paginas = ceil($num_total/$itens_por_pagina);
?>
<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role!="admin"){
        header('Location: ../index.php?err=2');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Chamados em Aberto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">E-Chamados</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="adminHome.php">Home</a></li>
                        <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Chamados<span class="caret"></span></a>
                            <ul class="dropdown-menu multi-level">
                                <li><a href="abrirchamadoAdmin.php">Abrir Chamado</a></li>
                                <li><a href="Deletar-chamado-admin.php">Deletar Chamado</a></li>
                                <li><a href="chamadosAbertos.php">Chamados em Aberto <span class="badge badge-danger"><?php echo $num;?></span></a></li>
                                <li><a href="ChamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a href="Ver-chamados-admin.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Técnico<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="insere_tecnico_res.php">Inserir Técnico</a></li>
                                <li><a href="remove_tecnico_res.php">Remover Técnico</a></li>
                                <li><a href="Ver-tecnicos.php">Ver Técnicos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h3>Chamados em aberto no Sistema</h3>
            <table class="table table-striped table table-bordered">
                <?php if($num > 0){ ?>
                <thead>
                    <tr>
                        <th>OS</th>
                        <th>Local</th>
                        <th>Técnico</th>
                        <th>Abertura</th>
                        <th>Status</th>
                        <th>Det.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php do{ ?>
                    <tr>
                        <td><?php echo $produto['contador'];?></td>
                        <td><?php echo $produto['local'];?></td>
                        <td><?php echo $produto['tecnico']; ?></td>
                        <td><?php echo $produto['datahora']; ?></td>
                        <?php if ($produto['status']=="Aberto"){?>
                        <td style="background-color:#F00;"> <?php echo $produto['status']; ?></td>
                        <?php }elseif ($produto['status']=="Feito") {?>
                        <td style="background-color:#0F0;"> <?php echo $produto['status']; ?></td>
                        <?php } ?>
                        <td>  <a class="btn btn-info btn-sm" href="ver-1chamado-admin.php?chamado=<?php echo $produto['contador'];?>"data-toggle="tooltip" title="Detalhes"><span class="glyphicon glyphicon-share"></span>Ver</button></td>
                    </tr>
                    <?php } while($produto = $execute->fetch_assoc()); ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li>
                        <a href="Chamados_abertos.php?pagina=0" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                        for($i=0;$i<$num_paginas;$i++){
                            $estilo = "";
                            if($pagina == $i)
                            $estilo = "class=\"active\"";
                    ?>
                    <li <?php echo $estilo; ?> ><a href="Chamados_abertos.php?pagina=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
                    <?php } ?>
                    <li>
                        <a href="chamadosAbertos.php?pagina=<?php echo $num_paginas-1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php } ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>