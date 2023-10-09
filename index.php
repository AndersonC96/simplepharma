<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Simple Pharma Chamados</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="./img/favicon.png"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	</head>
	<body>
		<div class="jumbotron text-center">
			<h1>Bem vindo ao <b style="Color: rgb(62 166 173)">Simple Pharma</b> chamados</h1>
			<p>Entre com o seu login e senha fornecidos</p>
		</div>
		<div class="container">
			<h2>Login</h2>
			<br>
			<?php
				$errors = array(1=>"Usuário ou senha inválidos, tente mais uma vez",2=>"Você precisa estar logado para acessar esta área");
				$error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;
				if($error_id == 1){
					echo '<p class="text-danger">'.$errors[$error_id].'</p>';
				}elseif($error_id == 2){
					echo '<p class="text-danger">'.$errors[$error_id].'</p>';
				}
			?>
			<form action="autenticacao-usuario.php" method="POST"  role="form">
				<div class="form-group">
					<!--<label for="email">Nome</label>-->
					<input type="text" name="username" class="form-control" placeholder="Usuário" required autofocus>
				</div>
				<br>
				<div class="form-group">
					<!--<label for="pwd">Senha</label>-->
					<input type="password" name="password" class="form-control" placeholder="Senha" required>
				</div>
				<br>
				<button type="submit" class="btn btn-success">Entrar</button>
			</form>
		</div>
	</body>
</html>