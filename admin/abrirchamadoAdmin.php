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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#"><b style="color: rgb(83 168 177)">Simple Pharma</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="adminHome.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="#">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoAdmin.php">Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto<span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php">Listar Chamado</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Técnico</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="inseretecnicoRes.php">Inserir Técnico</a></li>
                                <li><a class="dropdown-item" href="removetecnicoRes.php">Remover Técnico</a></li>
                                <li><a class="dropdown-item" href="verTecnicos.php">Ver Técnicos</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Sair</a>
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
                    <label for="local"><b>Selecione um setor</b></label>
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
                </div>
                <br>
                <div class="form-group">
                    <label for="servico"><b>Ocorrência</b></label>
                    <textarea name="servico" class="form-control" rows="5" id="servico" placeholder="Descreva seu problema" required></textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="id"><b>Técnico</b></label>
                    <?php
                        ini_set('default_charset', 'UTF-8');
                        $conn = new mysqli($hostname_conexao, $username_conexao, $password_conexao, $database_conexao) or die ('Cannot connect to db');
                        $result = $conn->query("select id, nome from tecnicos");
                        echo "<select name='id'>";
                        while($row = $result->fetch_assoc()){
                            unset($id, $name);
                            $id = $row['id'];
                            $name = $row['nome'];
                            echo '<option value="' . $name . '">' . $name . '</option>';
                        }
                        echo $return .= ' </select>';
                    ?>
                </div>
                <br>
                <div class="form-group">
                    <label for="datetime"><b>Data</b></label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control datepicker" name="dateFrom" id="datetime" readonly>
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Abrir Chamado</button>
            </form>
        </div>
        <script>
            $(document).ready(function(){
                var datetimeInput = $('#datetime');
                function formatTwoDigits(number){
                    return (number < 10 ? '0' : '') + number;
                }
                var now = new Date();
                var year = now.getFullYear();
                var month = formatTwoDigits(now.getMonth() + 1);
                var day = formatTwoDigits(now.getDate());
                var hours = formatTwoDigits(now.getHours());
                var minutes = formatTwoDigits(now.getMinutes());
                var currentDatetime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes;
                datetimeInput.val(currentDatetime);
                datetimeInput.datepicker({
                    format: 'dd/mm/yyyy hh:ii',
                    todayBtn: "linked",
                    clearBtn: true,
                    autoclose: true,
                    todayHighlight: true,
                    language: 'pt-BR'
                });
            });
        </script>
    </body>
</html>