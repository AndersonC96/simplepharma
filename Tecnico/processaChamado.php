<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Chamado feito</title>
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
          <div class="modal-body">Chamado realizado com sucesso!</div>
          <div class="modal-footer">
            <a class="btn btn-success" href="tecnicoHome.php">Entendido</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      session_start();
      $role = $_SESSION['sess_userrole'];
      if (!isset($_SESSION['sess_username']) || $role != "tecnico") {
        header('Location: ../index.php?err=2');
      }
    ?>
    <?php
      include_once("conexao.php");
      $servicoexecutado = $_POST['servicoexe'];
      $datainiciofez = $_POST['datahoraaber'];
      $numeroos = $_POST['var'];
      $datafimfez = $_POST['datahorafim'];
      $status = $_POST['status'];
      $comentarios = $_POST['comentarios'];
      $query = "UPDATE chamados SET serviexecu = '$servicoexecutado', datahoraaber = '$datainiciofez', datahorafim = '$datafimfez', status = '$status', comentarios = '$comentarios' WHERE contador = '$numeroos'";
      $resultado_usuario = mysqli_query($conn, $query);
      if($conn->query($query) === TRUE){
        echo '<script type="text/javascript"> $("#myModal2").modal("show");</script>';
      }else{
        echo "Error updating record: " . $conn->error;
      }
      $conn->close();
    ?>
  </body>
</html>