<?php
	include("conexaodbAdmin.php");
	$sql_code2 = "select * from chamados WHERE Status='Aberto'";
	$execute2 = $mysqli->query($sql_code2) or die($mysqli->error);
	$produto2 = $execute2->fetch_assoc();
	$num2 = $execute2->num_rows;
?>
<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role!="admin"){
		header('Location: ../index.php?err=2');
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Cadastrar Técnico</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<link rel="icon" type="image/png" href="../img/favicon.png"/>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><b style="color: rgb(83 168 177)">Simple Pharma</b> Chamados</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="Admin-Home.php">Home</a></li>
						<li>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Chamados<span class="caret"></span></a>
							<ul class="dropdown-menu multi-level">
								<li><a href="abrirchamadoAdmin.php">Abrir Chamado</a></li>
								<li><a href="deletarchamadoAdmin.php">Deletar Chamado</a></li>
								<li><a href="chamadosAbertos.php">Chamados em Aberto <span class="badge badge-danger"><?php echo $num2;?></span></a></li>
								<li><a href="chamadosConcluidos.php">Chamados Concluídos</a></li>
								<li><a href="verchamadosAdmin.php">Listar Chamado</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Técnico<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="inseretecnicoRes.php">Inserir Técnico</a></li>
								<li><a href="removetecnicoRes.php">Remover Técnico</a></li>
								<li><a href="verTecnicos.php">Ver Técnicos</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<h2>Preencha os campos</h2>
			<form method="POST" action="processacadTecnic.php">
				<div class="form-group">
					<label for="nomecomptec">Nome Completo</label>
					<input type="text" class="form-control" id="nomecomptec" placeholder="Nome do técnico" name="nomecomptec" required />
				</div>
				<div class="form-group">
					<label for="nomesistec">Nome Sistema</label>
					<input type="text" class="form-control" id="nomesistec" placeholder="Nome no sistema do técnico" name="nomesistec" required />
				</div>
				<div class="form-group">
					<label for="nomesistec">Senha</label>
					<input type="text" class="form-control" id="senhatec" placeholder="Senha para o técnico" name="senhatec" required />
				</div>
				<button type="submit" class="btn btn-default">Inserir Técnico</button>
			</form>
		</div>
	</body>
</html>