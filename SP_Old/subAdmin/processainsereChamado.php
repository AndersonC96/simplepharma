<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Insere Chamado</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="../img/favicon.png"/>
  </head>
  <body>
    <div class="modal fade" id="myModal2">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Atenção</h4>
          </div>
          <div class="modal-body">Chamado Aberto com sucesso!</div>
          <div class="modal-body">Tempo médio para atendimento: 30 Minutos</div>
          <div class="modal-footer">
            <a class="btn btn-success" href="subadminHome.php">Entendido</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      session_start();
      $role = $_SESSION['sess_userrole'];
      if(!isset($_SESSION['sess_username']) || $role!="subadmin"){
        header('Location: ../index.php?err=2');
      }
    ?>
    <?php
      include_once("conexao.php");
      $id_usuario = $_POST['id_usuario'];
      $usuario = $_POST['username'];
      $local = $_POST['local'];
      $servico = $_POST['servico'];
      $tecnico = $_POST['id'];
      $data_atendimento = $_POST['dateFrom'];
      $status = "Aberto";
      $result_usuario = "INSERT INTO chamados (usuario,local,datahora,tecnico,status,servico,id_usuario) VALUES ('$usuario','$local','$data_atendimento','$tecnico','$status','$servico','$id_usuario')";
      $resultado_usuario = mysqli_query($conn, $result_usuario);
      if(mysqli_affected_rows($conn) != 0){
        echo '<script type="text/javascript"> $("#myModal2").modal("show")</script>';
      }else{
        echo "ERRO";
      }
    ?>