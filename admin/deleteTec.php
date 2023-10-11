<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Remover Técnico</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="../img/favicon.png"/>
  </head>
  <body>
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Atenção</h4>
          </div>
          <div class="modal-body">Técnico Inválido</div>
          <div class="modal-footer">
            <a class="btn btn-danger btn-lg" href="removetecnicoRes.php">Entendido</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModal2">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Atenção</h4>
          </div>
          <div class="modal-body">Técnico removido com sucesso !</div>
          <div class="modal-footer">
            <a class="btn btn-sucess btn-lg" href="removetecnicoRes.php">Entendido</a>
          </div>
        </div>
      </div>
    </div>
    <?php
      $link = mysqli_connect("localhost", "root", "", "simplepharma");
      //$link = mysqli_connect($hostname_conexao, $username_conexao, $password_conexao, $database_conexao);
      $nome_tec = $_POST['tecex'];
      if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      $sql2 = "DELETE FROM usuarios WHERE nome='$nome_tec'";
      if(mysqli_query($link, $sql2)){
        if($total = mysqli_affected_rows($link)){
          echo '<script type="text/javascript"> $("#myModal2").modal("show")</script>';
        }else{
          echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
        }
      }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
      $sql = "DELETE FROM tecnicos WHERE nome='$nome_tec'";
      if(mysqli_query($link, $sql)){
        if($total = mysqli_affected_rows($link)){
          echo '<script type="text/javascript"> $("#myModal2").modal("show")</script>';
        }else{
          echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
        }
      }else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
      mysqli_close($link);
    ?>
  </body>
</html>