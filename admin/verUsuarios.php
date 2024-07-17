<?php
    error_reporting(0);
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = intval($_GET['pagina']);
    $item = $pagina * $itens_por_pagina;
    $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
    $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id DESC';
    $sql_code = "SELECT * FROM usuarios WHERE username LIKE '%$busca%' ORDER BY $ordem LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("SELECT * FROM usuarios WHERE username LIKE '%$busca%'")->num_rows;
    $num_paginas = ceil($num_total / $itens_por_pagina);
    session_start();
    $role = $_SESSION['sess_userrole'];
    if (!isset($_SESSION['sess_username']) || $role != "admin"){
        header('Location: Home.php?err=2');
    }
    include("conexaodbAdmin.php");
    $sql_code2 = "SELECT * FROM chamados WHERE status='Aberto'";
    $execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
    $produto2 = $execute2->fetch_assoc();
    $num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Todos os Usuários</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png">
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <style>
            .table{
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 15px;
                overflow: hidden;
            }
            .table thead th{
                background-color: #008d93;
                color: #ffffff;
            }
            .table-bordered{
                border: 1px solid #dee2e6;
                border-radius: 15px;
            }
            .table-bordered th,
            .table-bordered td{
                border: 1px solid #dee2e6;
            }
            .pagination li a{
                color: #008d93;
            }
            .pagination li.active a, .pagination li a:hover{
                color: #ffffff;
                background-color: #008d93;
                border-color: #008d93;
            }
            .pagination{
                justify-content: center;
            }
            .pagination .page-link{
                color: #008d93;
                background-color: #ffffff;
                border-color: #008d93;
            }
            .pagination .page-item.active .page-link{
                color: #ffffff;
                background-color: #008d93;
                border-color: #008d93;
            }
            .pagination .page-link:hover{
                color: #ffffff;
                background-color: #007a7a;
                border-color: #007a7a;
            }
            .search-form{
                margin-bottom: 20px;
            }
            .search-form .btn-primary, .search-form .form-control, .search-form .form-select{
                background-color: #008d93;
                border-color: #008d93;
                color: #ffffff;
            }
            .search-form .form-control::placeholder{
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-secondary bg-secondary py-3">
            <div class="container-xl">
                <a class="navbar-brand" href="#">
                    <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" class="h-12" alt="...">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="adminHome.php" aria-current="page">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tasks"></i> Chamados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoAdmin.php"><i class="fas fa-plus-circle"></i> Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoAdmin.php"><i class="fas fa-trash-alt"></i> Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="fas fa-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num2; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="fas fa-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php"><i class="fas fa-list"></i> Listar Chamado</a></li>
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
                                <i class="fas fa-users-cog"></i> Usuários
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="usuarioDropdown">
                                <li><a class="dropdown-item" href="insereUsuario.php"><i class="fas fa-user-plus"></i> Inserir Usuário</a></li>
                                <li><a class="dropdown-item" href="removeUsuario.php"><i class="fas fa-user-minus"></i> Remover Usuário</a></li>
                                <li><a class="dropdown-item" href="verUsuarios.php"><i class="fas fa-users"></i> Ver Usuários</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="navbar-nav ms-lg-4">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user"></i> <?php echo $_SESSION['sess_usersisname']; ?>
                        </a>
                    </div>
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-sm btn-secondary"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h2>Lista de usuários</h2>
            <form method="GET" action="verUsuarios.php" class="search-form d-flex">
                <div class="input-group me-2">
                    <select name="ordem" class="form-select">
                        <option value="id DESC" <?php if(isset($_GET['ordem']) && $_GET['ordem'] == 'id DESC') echo 'selected'; ?>>Mais recente</option>
                        <option value="id ASC" <?php if(isset($_GET['ordem']) && $_GET['ordem'] == 'id ASC') echo 'selected'; ?>>Mais antigo</option>
                        <option value="username ASC" <?php if(isset($_GET['ordem']) && $_GET['ordem'] == 'username ASC') echo 'selected'; ?>>Nome de usuário (A-Z)</option>
                        <option value="username DESC" <?php if(isset($_GET['ordem']) && $_GET['ordem'] == 'username DESC') echo 'selected'; ?>>Nome de usuário (Z-A)</option>
                    </select>
                </div>
                <div class="input-group flex-grow-1 me-2">
                    <input type="text" name="busca" class="form-control" placeholder="Enter address e.g. street, city" value="<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>">
                </div>
                <div class="input-group">
                    <button type="submit" class="btn btn-primary">Search Results</button>
                </div>
            </form>
            <table class="table table-striped table-bordered">
                <?php if ($num > 0){ ?>
                <thead>
                    <tr>
                        <th class="text-center">Nome de usuário</th>
                        <th class="text-center">Nome Completo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php do{ ?>
                    <tr>
                        <td class="text-center"><?php echo $produto['username']; ?></td>
                        <td class="text-center"><?php echo $produto['nome']; ?></td>
                    </tr>
                    <?php } while ($produto = $execute->fetch_assoc()); ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="verUsuarios.php?pagina=0&busca=<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>&ordem=<?php echo isset($_GET['ordem']) ? $_GET['ordem'] : 'id DESC'; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 0; $i < $num_paginas; $i++){
                        $estilo = ($pagina == $i) ? "class=\"page-item active\"" : "";
                    ?>
                    <li <?php echo $estilo; ?>><a class="page-link" href="verUsuarios.php?pagina=<?php echo $i; ?>&busca=<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>&ordem=<?php echo isset($_GET['ordem']) ? $_GET['ordem'] : 'id DESC'; ?>"><?php echo $i + 1; ?></a></li>
                    <?php } ?>
                    <li class="page-item">
                        <a class="page-link" href="verUsuarios.php?pagina=<?php echo $num_paginas - 1; ?>&busca=<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>&ordem=<?php echo isset($_GET['ordem']) ? $_GET['ordem'] : 'id DESC'; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php } else{ ?>
            <p class="text-center">Nenhum usuário encontrado.</p>
            <?php } ?>
        </div>
    </body>
</html>