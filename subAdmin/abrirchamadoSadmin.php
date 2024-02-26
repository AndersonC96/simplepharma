<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role != "subadmin"){
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><b style="color: #53A8B1">Simple Pharma</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item active"><a class="nav-link" href="subadminHome.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoSadmin.php">Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosSadmin.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container">
            <h2>Preencha os campos</h2>
            <form method="POST" action="processainsereChamado.php">
                <div class="form-group">
                    <label for="username"><b>Nome do Usuário</b></label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['sess_usersisname'];?>" readonly>
                </div>
                <br>
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
                        <option>Uso contínuo</option>
                        <option>Vendas</option>
                    </select>
                    <br>
                </div>
                <div class="form-group">
                    <label for="comment"><b>Ocorrência</b></label>
                    <textarea name="servico" class="form-control" rows="5" id="comment" placeholder="Descreva sua ocorrência"required></textarea>
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
                    <input type="text" class="form-control" id="datetime" name="dateFrom" required>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Inserir Chamado</button>
            </form>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function(){
                var datetimeField = document.getElementById("datetime");
                if(datetimeField){
                    datetimeField.value = moment().format("DD/MM/YYYY HH:mm");
                }
            });
        </script>
    </body>
</html>