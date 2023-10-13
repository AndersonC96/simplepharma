<?php
	include("conexaodbAdmin.php");
	$sql_code2 = "select * from chamados WHERE status='Aberto'";
	$execute2 = $mysqli->query($sql_code2) or die ($mysqli->error);
	$produto2 = $execute2->fetch_assoc();
	$num2 = $execute2->num_rows;
?>
<?php
	session_start();
	$role = $_SESSION['sess_userrole'];
	if(!isset($_SESSION['sess_username']) || $role != "subadmin"){
		header('Location: ../index.php?err=2');
	}
	$chamado = $_GET["chamado"];
?>
<?php
	include("conexao.php");
	$sql_code = "select usuario,contador,local,tecnico,datahora,status,servico,serviexecu,datahoraaber,datahorafim from chamados WHERE contador='$chamado'";
	$execute = $conn->query($sql_code) or die($conn->error);
	$produto = $execute->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $_SESSION['sess_usersisname']; ?> | Chamado: <?php echo $chamado; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link" href="subadminHome.php">Home</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
							<ul class="dropdown-menu multi-level">
								<li><a class="dropdown-item" href="abrirchamadoSadmin.php">Abrir Chamado</a></li>
								<li><a class="dropdown-item" href="deletarchamadoSadmin.php">Deletar Chamado</a></li>
								<li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num2; ?></span></a></li>
								<li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
								<li><a class="dropdown-item" href="verchamadosSadmin.php">Listar Chamado</a></li>
							</ul>
						</li>
					</ul>
					<ul class="navbar-nav ms-auto">
						<li class="nav-item">
							<a class="nav-link" href="logout.php"><span class="bi bi-box-arrow-right"></span> Sair</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<br>
		<div class="container">
			<h2 class="text-center"><strong>Dados do Chamado <?php echo $chamado;?></strong></h2>
			<div class="card">
				<div class="card-header"><strong>Usuário</strong></div>
				<div class="card-body"><?php echo $produto['usuario'];?></div>
				<div class="card-header"><strong>Local do chamado</strong></div>
				<div class="card-body"><?php echo $produto['local'];?></div>
				<div class="card-header"><strong>Serviço Solicitado</strong></div>
				<div class="card-body"><?php echo $produto['servico'];?></div>
				<div class="card-header"><strong>Data da abertura do Chamado</strong></div>
				<div class="card-body"><?php echo $produto['datahora'];?></div>
				<div class="card-header"><strong>Serviço Executado</strong></div>
				<div class="card-body"><?php echo $produto['serviexecu'];?></div>
				<div class="card-header"><strong>Data de Início do Atendimento</strong></div>
				<div class="card-body"><?php echo $produto['datahoraaber'];?></div>
				<div class="card-header"><strong>Data Final do Atendimento</strong></div>
				<div class="card-body"><?php echo $produto['datahorafim'];?></div>
				<div class="card-header"><strong>Status do Chamado</strong></div>
				<?php if($produto['status'] == "Aberto"){ ?>
				<div class="card-body" style="background-color:#F00;"><?php echo $produto['status']; ?></div>
				<?php }elseif($produto['status'] == "Feito"){ ?>
				<div class="card-body" style="background-color:#0F0;"><?php echo $produto['status']; ?></div>
				<?php } ?>
			</div>
		</div>
	</body>
</html>