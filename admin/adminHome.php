<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "admin"){
        header('Location: ../index.php?err=2');
        exit();
    }
    include("conexaodbAdmin.php");
    $sql_code = "SELECT * FROM chamados WHERE Status='Aberto'";
    $execute = $mysqli->query($sql_code) or die($mysqli->error);
    $num = $execute->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Área Administrativa | Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
        <link href="../CSS/nav.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <style>
            body{
                background-color: #f8f9fa;
            }
            .navbar{
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .container h1{
                color: #343a40;
            }
            .container p{
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary px-0 py-3">
            <div class="container-xl">
                <a class="navbar-brand" href="adminHome.php">
                    <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" class="h-12" alt="...">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-lg-auto">
                        <a class="nav-item nav-link active" href="adminHome.php" aria-current="page">
                            <i class="fas fa-home"></i> Home
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ticket-alt"></i> Chamados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoAdmin.php"><i class="fas fa-plus-circle"></i> Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoAdmin.php"><i class="fas fa-trash-alt"></i> Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="fas fa-folder-open"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="fas fa-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php"><i class="fas fa-list"></i> Listar Chamados</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-cog"></i> Técnico
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="tecnicoDropdown">
                                <li><a class="dropdown-item" href="inseretecnicoRes.php"><i class="fas fa-user-plus"></i> Inserir Técnico</a></li>
                                <li><a class="dropdown-item" href="removetecnicoRes.php"><i class="fas fa-user-minus"></i> Remover Técnico</a></li>
                                <li><a class="dropdown-item" href="verTecnicos.php"><i class="fas fa-users"></i> Ver Técnicos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-users"></i> Usuários
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="usuarioDropdown">
                                <li><a class="dropdown-item" href="insereUsuario.php"><i class="fas fa-user-plus"></i> Inserir Usuário</a></li>
                                <li><a class="dropdown-item" href="removeUsuario.php"><i class="fas fa-user-minus"></i> Remover Usuário</a></li>
                                <li><a class="dropdown-item" href="verUsuarios.php"><i class="fas fa-users"></i> Ver Usuários</a></li>
                            </ul>
                        </li>
                    </div>
                    <div class="navbar-nav ms-lg-4">
                        <a class="nav-item nav-link" href="#"><i class="fas fa-user"></i> <?php echo $_SESSION['sess_usersisname']; ?></a>
                    </div>
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-sm btn-secondary w-full w-lg-auto"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h1>Bem-vindo</b></h1>
            <p>Algumas funcionalidades podem não estar ativas ainda.</p>
        </div>
    </body>
</html>