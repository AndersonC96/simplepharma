<?php
    session_start();
    require('./includes/db.php');
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $senha = $_POST["senha"];
        /*$db_host = "seu_host_mysql";
        $db_usuario = "seu_usuario_mysql";
        $db_senha = "sua_senha_mysql";
        $db_nome = "seu_banco_de_dados";*/
        $conn = new mysqli($host, $username, $password, $database);
        if($conn->connect_error){
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }
        $username = $conn->real_escape_string($username);
        $senha = $conn->real_escape_string($senha);
        $query = "SELECT id, username, senha FROM usuarios WHERE username = '$username'";
        $result = $conn->query($query);
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            if(password_verify($senha, $row["senha"])){
                $_SESSION["username"] = $row["username"];
                header("Location: dashboard.php");
                exit();
            }else{
                $error_message = "Credenciais inválidas.";
            }
        }else{
            $error_message = "Credenciais inválidas.";
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Relatório Médicos - Login</title>
        <link rel="icon" type="image/png" href="./img/favicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoI6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            .gradient-custom{
                background: #3ea5af;
                background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
                background: linear-gradient(to right, rgba(83, 168, 177, 1), rgba(37, 117, 252, 1))
            }
        </style>
    </head>
    <body>
        <!DOCTYPE html>
        <html>
            <head>
            <title>Relatório Médicos - Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>
        <body>
            <section class="vh-100 gradient-custom">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">
                                    <div class="mb-md-5 mt-md-4 pb-5">
                                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                        <p class="text-white-50 mb-5">Entre com o seu login e senha fornecidos</p>
                                        <form method="POST" action="login.php">
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Usuário" required>
                                            </div>
                                            <div class="form-outline form-white mb-4">
                                                <input type="password" name="senha" class="form-control form-control-lg" placeholder="Senha" required>
                                            </div>
                                            <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </body>
    </html>