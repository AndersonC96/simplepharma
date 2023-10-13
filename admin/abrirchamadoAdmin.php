<?php
    session_start();
    $role = $_SESSION['sess_userrole'];
    if(!isset($_SESSION['sess_username']) || $role!="admin"){
		header('Location: ../index.php?err=2');
    }
?>
<?php
	include("conexaodbAdmin.php");
	$sql_code = "select * from chamados WHERE Status='Aberto'";
	$execute = $mysqli->query($sql_code) or die($mysqli->error);
	$produto = $execute->fetch_assoc();
	$num = $execute->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Abrir Chamado</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="/bootstrap/pt-br.js"></script>
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
						<li class="active"><a href="adminHome.php">Home</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Chamados<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">Abrir Chamado</a></li>
								<li><a href="deletarchamadoAdmin.php">Deletar Chamado</a></li>
								<li><a href="chamadosAbertos.php">Chamados em Aberto<span class="badge badge-danger"><?php echo $num;?></span></a></li>
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
			<form method="POST" action="processainsereChamado.php">
				<div class="form-group">
					<label for="username">Nome do Usuário</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['sess_usersisname'];?>" readonly>
				</div>
				<div class="form-group">
					<label for="sel1">Selecione um local</label>
					<select class="form-control" id="local" name="local">
						<option>Simple Pharma (São Paulo)</option>
						<option>2</option>
					</select>
					<br>
				</div>
				<div class="form-group">
					<label for="comment">Serviço</label>
					<textarea name="servico" class="form-control" rows="5" id="comment" required /></textarea>
				</div>
				<div class="form-group">
					<label for="servi">Técnico</label>
					<?php
						ini_set('default_charset','UTF-8');
						$conn = new mysqli($hostname_conexao, $username_conexao, $password_conexao, $database_conexao) or die ('Cannot connect to db');
						$result = $conn->query("select id, nome from tecnicos");
						echo "<select name='id'>";
						while($row = $result->fetch_assoc()){
							unset($id, $name);
							$id = $row['id'];
							$name = $row['nome'];
							echo '<option value="'.$name.'">'.$name.'</option>';
						}
						echo $return .= ' </select>';
					?>
				</div>
				<div class="form-group">
					<label for="datetimepicker1">Data</label>
					<div class="row">
						<div class='col-sm-6'>
							<div class="form-group">
								<div class='input-group date' id='datetimepicker1'>
									<input type='text' class="form-control" name="dateFrom" required />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(function(){
								$('#datetimepicker1').datetimepicker({
									locale: 'pt-br'
								});
							});
						</script>
					</div>
				</div>
				<button type="submit" class="btn btn-default">Inserir Chamado</button>
			</form>
		</div>
	</body>
</html>