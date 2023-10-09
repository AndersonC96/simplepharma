<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role!="admin"){
        header('Location: ../index.php?err=2');
    }
?>
<?php
    include("conecta-puxa-dados-admin.php");
    $sql_code = "select * from chamados1 WHERE Status='Aberto'";
    $execute = $mysqli->query($sql_code) or die($mysqli->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Área Administrativa | Home</title>
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
                                <li><a href="Chamados_abertos.php">Chamados em Aberto <span class="badge badge-danger"><?php echo $num;?></span></a></li>
                                <li><a href="Chamados_concluidos.php">Chamados Concluídos</a></li>
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
            <h2>Modelo Beta de testes</h2>
            <h4>Bem vindo <?php echo $_SESSION['sess_usersisname'];?></h4>
            <p>Algumas funcionalidades podem não estar ativas ainda</p>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>