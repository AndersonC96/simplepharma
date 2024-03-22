<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Pharma Chamados - Login</title>
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="./CSS/style.css"> <!-- Referência ao arquivo CSS externo -->
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" alt="Simple Pharma">
        </div>
        <form action="autenticarUsuario.php" method="POST" class="login-form">
            <input type="text" name="username" class="form-control" placeholder="Usuário" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
