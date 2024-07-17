<?php
    session_start();
    error_reporting(0);
    include("conexao.php");
    $itens_por_pagina = 10;
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $item = $pagina * $itens_por_pagina;
    $sql_code = "SELECT contador, local, tecnico, datahora, status, servico FROM chamados WHERE status='Aberto' AND usuario='{$_SESSION['sess_usersisname']}' ORDER BY contador DESC LIMIT $item, $itens_por_pagina";
    $execute = $conn->query($sql_code) or die($conn->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
    $num_total = $conn->query("SELECT contador, local, tecnico, datahora, status, servico FROM chamados WHERE status='Aberto' AND usuario='{$_SESSION['sess_usersisname']}'")->num_rows;
    $num_paginas = ceil($num_total / $itens_por_pagina);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Chamados em Aberto</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                        <a class="nav-item nav-link active" href="subadminHome.php" aria-current="page">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-envelope"></i> Chamados
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoSadmin.php"><i class="bi bi-plus-circle"></i> Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoSadmin.php"><i class="bi bi-trash"></i> Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="bi bi-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="bi bi-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosSadmin.php"><i class="bi bi-list"></i> Listar Chamados</a></li>
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
            <h3>Chamados em aberto no Sistema</h3>
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
                        <td class="text-center"><?php echo $produto['contador']; ?></td>
                        <td class="text-center"><?php echo $produto['local']; ?></td>
                        <td class="text-center"><?php echo $produto['tecnico']; ?></td>
                        <td class="text-center"><?php echo $produto['datahora']; ?></td>
                        <td class="text-center" style="background-color: <?php echo $produto['status'] == 'Aberto' ? '#F00' : '#0F0'; ?>;">
                            <?php echo $produto['status']; ?>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm" href="ver1chamadoAdmin.php?chamado=<?php echo $produto['contador']; ?>" data-toggle="tooltip" title="Detalhes">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    <?php } while ($produto = $execute->fetch_assoc()); ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item <?php echo $pagina == 0 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="chamadosAbertos.php?pagina=0" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $num_paginas; $i++): ?>
                    <li class="page-item <?php echo $pagina == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="chamadosAbertos.php?pagina=<?php echo $i; ?>"><?php echo $i + 1; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $pagina == $num_paginas - 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="chamadosAbertos.php?pagina=<?php echo $num_paginas - 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php } ?>
        </div>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </body>
</html>