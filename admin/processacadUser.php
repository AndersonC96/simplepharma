<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Cadastro Técnico</title>
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
					<div class="modal-body">Este nome de usuário já existe</div>
					<div class="modal-footer">
						<a class="btn btn-danger btn-lg" href="insereUsuario.php">Entendido</a>
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
					<div class="modal-body">Cadastro de usuário realizado com sucesso!</div>
					<div class="modal-footer">
						<a class="btn btn-success" href="insereUsuario.php">Entendido</a>
					</div>
				</div>
			</div>
		</div>
		<?php
			$link = mysqli_connect("localhost", "root", "", "simplepharma");
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			$nomecompletousr = $_POST['nomecompusr'];
			$nomesisusr = $_POST['nomesisusr'];
			$senhausr = $_POST['senhausr'];
			$tipousr = $_POST['tipousr'];
			$sql2 = "INSERT INTO usuarios(nome,username,password,role) VALUES ('$nomecompletousr','$nomesisusr','$senhausr','$tipousr')";
			if(mysqli_query($link, $sql2)){
				if($total = mysqli_affected_rows($link)){
					echo '<script type="text/javascript"> $("#myModal2").modal("show")</script>';
				}else{
					echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
				}
			}else{
				echo '<script type="text/javascript"> $("#myModal").modal("show")</script>';
			}
		?>
	</body>
</html>