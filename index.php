<!DOCTYPE html>
<html lang="en">
    <head>
        <title>E-Chamados</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="jumbotron text-center">
            <h1>Bem vindo ao E-chamados</h1>
            <p>Entre com o seu login e senha fornecidos</p>
        </div>
        <div class="container">
            <h2>Login</h2>
            <?php
                $errors = array(1=>"Usuário ou senha inválidos, tente mais uma vez",2=>"Você precisa estar logado para acessar esta área");
                $error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;
                if($error_id == 1){
                    echo '<p class="text-danger">'.$errors[$error_id].'</p>';
                }elseif($error_id == 2){
                    echo '<p class="text-danger">'.$errors[$error_id].'</p>';
                }
            ?>
            <br>
            <form action="autenticarUsuario.php" method="POST"  role="form">
                <div class="form-group">
                    <!--<label for="email">Nome</label>-->
                    <input type="text" name="username" class="form-control" placeholder="E-Mail" required autofocus>
                </div>
                <br>
                <div class="form-group">
                    <!--<label for="pwd">Senha</label>-->
                    <input type="password" name="password" class="form-control" placeholder="Senha" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>