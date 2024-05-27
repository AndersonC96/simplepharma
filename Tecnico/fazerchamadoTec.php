<?php
  error_reporting(0);
  session_start();
  $role = $_SESSION['sess_userrole'];
  if(!isset($_SESSION['sess_username']) || $role!="tecnico"){
    header('Location: ../index.php?err=2');
  }
  $chamado = $_GET["chamado"];
?>
<?php
  include("conexao.php");
  $itens_por_pagina = 10;
  $pagina = intval($_GET['pagina']);
  $tecnico = $_SESSION['sess_username'];
  $sql_code = "select contador,local,tecnico,datahora,status,servico,usuario,telefone,titulo from chamados WHERE contador='$chamado'";
  $execute = $conn->query($sql_code) or die($conn->error);
  $produto = $execute->fetch_assoc();
  $num = $execute->num_rows;
  $num_total = $conn->query("select contador,local,tecnico,datahora,status,servico,telefone,titulo from chamados WHERE tecnico='$tecnico'")->num_rows;
  $num_paginas = ceil($num_total/$itens_por_pagina);
?>
<?php
  include("conexaodbAdmin.php");
  $sql_code2 = "select * from chamados WHERE status='Aberto' AND tecnico='$tecnico'";
  $execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
  $produto2 = $execute2->fetch_assoc();
  $num2 = $execute2->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $_SESSION['sess_usersisname']; ?> | Chamado: <?php echo $chamado; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <link href="../CSS/nav.css" rel="stylesheet">
    <link href="../CSS/body_chamado.css" rel="stylesheet">
    <style>
        .card-header{
            background-color: #008d93;
            color: #fff;
        }
        .badge-estado{
            font-size: 1em;
        }
        .bg-aberto{
            background-color: #dc3545;
            color: #fff;
        }
        .bg-feito{
            background-color: #28a745;
            color: #fff;
        }
        .input-group-text{
            cursor: pointer;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function(){
        document.getElementById('datahoraaber').value = moment().format('DD/MM/YYYY H:mm:ss');
        window.setEndTime = function(){
          document.getElementById('datahorafim').value = moment().format('DD/MM/YYYY H:mm:ss');
        };
      });
    </script>
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
            <a class="nav-item nav-link active" href="tecnicoHome.php" aria-current="page">Home</a>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
              <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                <li><a class="dropdown-item" href="chamadosabertosTec.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                <li><a class="dropdown-item" href="chamadosconcluidosTec.php">Chamados Concluídos</a></li>
                <li><a class="dropdown-item" href="verchamadosTec.php">Listar Chamado</a></li>
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
    <div class="container my-5">
      <h2 class="text-center mb-4"><strong>Dados do Chamado <?php echo $chamado; ?></strong></h2>
      <div class="card">
        <div class="card-header"><strong>Informações do Chamado</strong></div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Usuário:</strong> <?php echo $produto['usuario']; ?></li>
          <li class="list-group-item"><strong>Telefone:</strong>
            <?php 
              if($produto['telefone'] == NULL){
                echo "";
              }else{
                echo $produto['telefone'];
              }
            ?>
          </li>
          <li class="list-group-item"><strong>Local do chamado:</strong> <?php echo $produto['local']; ?></li>
          <li class="list-group-item"><strong>Título:</strong>
            <?php 
              if($produto['titulo'] == NULL){
                echo "";
              }else{
                echo $produto['titulo'];
              }
            ?>
          </li>
          <li class="list-group-item"><strong>Serviço Solicitado:</strong> <?php echo $produto['servico']; ?></li>
          <li class="list-group-item"><strong>Data e Hora da abertura:</strong> <?php echo $produto['datahora']; ?></li>
        </ul>
      </div>
    </div>
    <!--<div class="container my-5">
      <form method="POST" action="processaChamado.php" class="card">
        <div class="card-header"><strong>Registro de Atendimento</strong></div>
        <div class="card-body">
          <div class="form-group">
            <label for="servicoexe"><b>Serviço Executado</b></label>
            <textarea name="servicoexe" class="form-control" rows="5" id="servicoexe"></textarea>
          </div>
          <div class="row">
            <div class='col-sm-6'>
              <div class="form-group">
                <input type="hidden" name="var" id="var" value="<?php print $chamado ?>" />
                <label for="datahoraaber"><b>Data e Hora de Início do Atendimento</b></label>
                <div class='input-group'>
                  <input type='text' class="form-control" id="datahoraaber" name="datahoraaber" required />
                  <span class="input-group-text">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class='col-sm-6'>
              <div class="form-group">
                <label for="datahorafim"><b>Data e Hora de Término do Atendimento</b></label>
                <div class='input-group'>
                  <input type='text' class="form-control" id="datahorafim" name="datahorafim" required />
                  <button type="button" class="btn btn-info" onclick="setEndTime()">Definir horário</button>
                  <span class="input-group-text">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-success">Salvar Chamado</button>
        </div>
      </form>
    </div>-->
    <div class="container my-5">
      <form method="POST" action="processaChamado.php" class="card">
        <div class="card-header"><strong>Registro de Atendimento</strong></div>
        <div class="card-body">
          <div class="form-group">
            <label for="servicoexe"><b>Serviço Executado</b></label>
            <textarea name="servicoexe" class="form-control" rows="5" id="servicoexe"></textarea>
          </div>
          <div class="form-group">
            <label for="status"><b>Status do Chamado</b></label>
            <select name="status" class="form-control" id="status">
              <option value="Aberto">Aberto</option>
              <option value="Em Andamento">Em Andamento</option>
              <option value="Feito">Finalizado</option>
            </select>
          </div>
          <div class="form-group">
            <label for="comentarios"><b>Comentários</b></label>
            <textarea name="comentarios" class="form-control" rows="3" id="comentarios"></textarea>
          </div>
          <div class="row">
            <div class='col-sm-6'>
              <div class="form-group">
                <input type="hidden" name="var" id="var" value="<?php print $chamado ?>" />
                <label for="datahoraaber"><b>Data e Hora de Início do Atendimento</b></label>
                <div class='input-group'>
                  <input type='text' class="form-control" id="datahoraaber" name="datahoraaber" required />
                  <span class="input-group-text">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class='col-sm-6'>
              <div class="form-group">
                <label for="datahorafim"><b>Data e Hora de Término do Atendimento</b></label>
                <div class='input-group'>
                  <input type='text' class="form-control" id="datahorafim" name="datahorafim" required />
                  <button type="button" class="btn btn-info" onclick="setEndTime()">Definir horário</button>
                  <span class="input-group-text">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-success">Salvar Chamado</button>
        </div>
      </form>
    </div>
  </body>
</html>