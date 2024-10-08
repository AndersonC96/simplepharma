<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Remover Chamado</title>
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
                <div class="modal-body">Ordem de serviço inválida</div>
                <div class="modal-footer">
                    <a class="btn btn-danger btn-lg" href="deletarchamadoAdmin.php">Entendido</a>
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
                <div class="modal-body">Ordem de serviço removida com sucesso!</div>
                <div class="modal-footer">
                    <a class="btn btn-success btn-lg" href="deletarchamadoAdmin.php">Entendido</a>
                </div>
            </div>
        </div>
    </div>
    <?php
      include("conexaodbAdmin.php");
      $numero_os = filter_input(INPUT_POST, 'oser', FILTER_VALIDATE_INT);
      if(!$numero_os){
          echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
          exit();
      }
      $stmt = $mysqli->prepare("DELETE FROM chamados WHERE contador = ?");
      $stmt->bind_param("i", $numero_os);
      if($stmt->execute()){
        if($stmt->affected_rows > 0){
          echo '<script type="text/javascript"> $("#myModal2").modal("show")</script>';
        }else{
          echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
        }
      }else{
        error_log("Error: " . $stmt->error);
        echo "Erro ao executar a consulta.";
      }
      $stmt->close();
      $mysqli->close();
    ?>
  </body>
</html>