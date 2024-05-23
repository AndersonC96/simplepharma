<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Cadastro Técnico</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$nomecompletousr = mysqli_real_escape_string($link, $_POST['nomecompusr']);
				$nomesisusr = mysqli_real_escape_string($link, $_POST['nomesisusr']);
				$senhausr = mysqli_real_escape_string($link, $_POST['senhausr']);
				$tipousr = mysqli_real_escape_string($link, $_POST['tipousr']);
				$sql2 = "INSERT INTO usuarios(nome, username, password, role) VALUES ('$nomecompletousr', '$nomesisusr', '$senhausr', '$tipousr')";
				if(mysqli_query($link, $sql2)){
					if(mysqli_affected_rows($link)){
						echo '<script type="text/javascript">$(document).ready(function() { $("#myModal2").modal("show"); });</script>';
					}else{
						echo '<script type="text/javascript">$(document).ready(function() { $("#myModal").modal("show"); });</script>';
					}
				}else{
					echo '<script type="text/javascript">$(document).ready(function() { $("#myModal").modal("show"); });</script>';
				}
			}
		?>
	</body>
</html>