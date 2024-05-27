<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "admin"){
        header('Location: ../index.php?err=2');
    }
?>
<?php
    include("conexaodbAdmin.php");
    $sql_code = "select * from chamados WHERE status='Aberto'";
    $execute = $mysqli->query($sql_code) or die($mysqli->error);
    $produto = $execute->fetch_assoc();
    $num = $execute->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $_SESSION['sess_usersisname']; ?> | Abrir Chamado</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
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
                        <a class="nav-item nav-link active" href="adminHome.php" aria-current="page"><i class="bi bi-house-door"></i> Home</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-card-list"></i> Chamados</a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoAdmin.php"><i class="bi bi-plus-circle"></i> Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoAdmin.php"><i class="bi bi-trash"></i> Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="bi bi-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="bi bi-check-circle"></i> Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php"><i class="bi bi-list"></i> Listar Chamado</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person"></i> Técnico</a>
                            <ul class="dropdown-menu" aria-labelledby="tecnicoDropdown">
                                <li><a class="dropdown-item" href="inseretecnicoRes.php"><i class="bi bi-person-plus"></i> Inserir Técnico</a></li>
                                <li><a class="dropdown-item" href="removetecnicoRes.php"><i class="bi bi-person-x"></i> Remover Técnico</a></li>
                                <li><a class="dropdown-item" href="verTecnicos.php"><i class="bi bi-person-lines-fill"></i> Ver Técnicos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-people"></i> Usuários</a>
                            <ul class="dropdown-menu" aria-labelledby="usuarioDropdown">
                                <li><a class="dropdown-item" href="insereUsuario.php"><i class="bi bi-person-plus"></i> Inserir Usuário</a></li>
                                <li><a class="dropdown-item" href="removeUsuario.php"><i class="bi bi-person-x"></i> Remover Usuário</a></li>
                                <li><a class="dropdown-item" href="verUsuarios.php"><i class="bi bi-people"></i> Ver Usuários</a></li>
                            </ul>
                        </li>
                    </div>
                    <div class="navbar-nav ms-lg-4">
                        <a class="nav-item nav-link" href="#"><i class="bi bi-person-circle"></i> <?php echo $_SESSION['sess_usersisname']; ?></a>
                    </div>
                    <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                        <a href="logout.php" class="btn btn-sm btn-secondary w-full w-lg-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container">
            <h2>Preencha os campos</h2>
            <form method="POST" action="processainsereChamado.php">
                <div class="form-group">
                    <label for="username"><b>Nome do Usuário</b></label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['sess_usersisname'];?>" readonly>
                </div>
                <div class="form-group">
                    <label for="local"><b>Selecione um local</b></label>
                    <select class="form-select" id="local" name="local">
                        <option>Almoxarifado</option>
                        <option>Conferência final</option>
                        <option>Conferência inicial</option>
                        <option>Desvincular</option>
                        <option>Expedição</option>
                        <option>Financeiro</option>
                        <option>Inclusão</option>
                        <option>Laboratório</option>
                        <option>Orçamento</option>
                        <option>RH</option>
                        <option>Recepção</option>
                        <option>SAC</option>
                        <option>TI</option>
                        <option>Uso contínuo</option>
                        <option>Vendas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone"><b>Telefone</b></label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="(xx) xxxxx-xxxx" required>
                </div>
                <div class="form-group">
                    <label for="titulo"><b>Título</b></label>
                    <textarea name="titulo" class="form-control" rows="5" id="titulo" required></textarea>
                </div>
                <div class="form-group">
                    <label for="comment"><b>Ocorrência</b></label>
                    <textarea name="servico" class="form-control" rows="5" id="comment" required></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="id"><b>Técnico</b></label>
                    <?php
                        ini_set('default_charset','UTF-8');
                        $conn = new mysqli($hostname_conexao, $username_conexao, $password_conexao, $database_conexao) or die ('Cannot connect to db');
                        $result = $conn->query("select id, nome from tecnicos");
                        echo "<select name='id' class='form-select'>";
                        while($row = $result->fetch_assoc()){
                            unset($id, $name);
                            $id = $row['id'];
                            $name = $row['nome'];
                            echo '<option value="'.$name.'">'.$name.'</option>';
                        }
                        echo $return .= ' </select>';
                    ?>
                </div>
                <br>
                <div class="form-group">
                    <label for="datetime"><b>Data</b></label>
                    <input type="text" class="form-control" id="datetime" name="dateFrom" required readonly>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Inserir Chamado</button>
            </form>
        </div>
        <script>
            $(document).ready(function(){
                $('#phone').mask('(00) 00000-0000');
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function(){
                var datetimeField = document.getElementById("datetime");
                if(datetimeField){
                    datetimeField.value = moment().format("DD/MM/YYYY HH:mm");
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>