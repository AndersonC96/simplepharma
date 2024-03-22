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
		</style>
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
                        <a class="nav-item nav-link active" href="subadminHome.php" aria-current="page">Home</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chamados</a>
                            <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                                <li><a class="dropdown-item" href="abrirchamadoSadmin.php">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="deletarchamadoSadmin.php">Deletar Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Chamados Concluídos</a></li>
                                <li><a class="dropdown-item" href="verchamadosSadmin.php">Listar Chamado</a></li>
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
		<br>
		<div class="container my-5">
			<h2 class="text-center mb-4"><strong>Dados do Chamado <?php echo $chamado; ?></strong></h2>
			<div class="card">
				<div class="card-header"><strong>Informações do Chamado</strong></div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item"><strong>Usuário:</strong> <?php echo $produto['usuario']; ?></li>
						<li class="list-group-item"><strong>Local do chamado:</strong> <?php echo $produto['local']; ?></li>
						<li class="list-group-item"><strong>Serviço Solicitado:</strong> <?php echo $produto['servico']; ?></li>
						<li class="list-group-item"><strong>Data e Hora da abertura:</strong> <?php echo $produto['datahora']; ?></li>
						<li class="list-group-item"><strong>Técnico Responsável:</strong> <?php echo $produto['tecnico']; ?></li>
						<li class="list-group-item"><strong>Serviço Executado:</strong> <?php echo $produto['serviexecu']; ?></li>
						<li class="list-group-item"><strong>Data e Hora Início do Atendimento:</strong> <?php echo $produto['datahoraaber']; ?></li>
						<li class="list-group-item"><strong>Data e Hora Final do Atendimento:</strong> <?php echo $produto['datahorafim']; ?></li>
						<li class="list-group-item">
							<strong>Status do Chamado:</strong>
							<span class="badge <?php echo ($produto['status'] == 'Aberto') ? 'bg-aberto' : 'bg-feito'; ?>">
								<?php echo $produto['status']; ?>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>