<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "tecnico"){
        header('Location: ../index.php?err=2');
    }
?>
<?php
    include("conexaodbAdmin.php");
    $tecnico = $_SESSION['sess_username'];
    $sql_code = "select * from chamados WHERE status='Aberto' AND tecnico='$tecnico'";
    $execute = $mysqli->query($sql_code) or die($mysqli->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Área Técnico | Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
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
                                <li><a class="dropdown-item" href="chamadosabertosTec.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
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
            <h1>Bem-vindo, <b style="color: rgb(83 168 177)"><?php echo $_SESSION['sess_usersisname']; ?></b></h1>
            <p>Algumas funcionalidades podem não estar ativas ainda.</p>
        </div>
    </body>
</html>