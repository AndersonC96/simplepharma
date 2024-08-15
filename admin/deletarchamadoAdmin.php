<?php
    error_reporting(0);
    session_start();
    if(!isset($_SESSION['sess_username']) || $_SESSION['sess_userrole'] != "admin"){
        header('Location: ../index.php?err=2');
        exit();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("conexaodbAdmin.php");
    $stmt = $mysqli->prepare("SELECT contador, titulo, servico, datahora FROM chamados WHERE status='Aberto'");
    if(!$stmt){
        echo "Erro na preparação da consulta: " . $mysqli->error;
        exit();
    }
    $stmt->execute();
    $execute = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?> | Deletar Chamado</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <link href="../CSS/nav.css" rel="stylesheet">
        <link href="../CSS/body_chamado.css" rel="stylesheet">
        <style>
            body{
                font-family: 'Roboto', sans-serif;
                background-color: #f8f9fa;
            }
            h2{
                font-weight: 500;
                color: #343a40;
            }
            .form-group input{
                border-radius: 0.375rem;
                padding-left: 1rem;
                border: 2px solid #50acb2;
                font-size: 1rem;
                height: calc(2.25rem + 2px);
            }
            .btn-danger{
                background-color: #dc3545;
                border-color: #dc3545;
                transition: background-color 0.3s ease;
            }
            .btn-danger:hover{
                background-color: #c82333;
                border-color: #bd2130;
            }
            .container{
                margin-top: 50px;
            }
            .card{
                margin-bottom: 20px;
                border: none;
                border-radius: 0.75rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .card-header{
                background-color: #50acb2;
                color: #fff;
                font-weight: 700;
                text-align: center;
                border-top-left-radius: 0.75rem;
                border-top-right-radius: 0.75rem;
                padding: 1rem;
            }
            .card-body{
                padding: 1.5rem;
                text-align: center;
            }
            .card-title{
                margin-bottom: 0.75rem;
            }
            .card-subtitle{
                margin-bottom: 1rem;
            }
            .card-text{
                font-size: 0.9rem;
                line-height: 1.4;
            }
            .card-footer{
                background-color: #f1f1f1;
                border-bottom-left-radius: 0.75rem;
                border-bottom-right-radius: 0.75rem;
                padding: 0.75rem;
                text-align: center;
                font-size: 0.8rem;
                color: #6c757d;
            }
        </style>
    </head>
    <body>
        <?php include('navbarAdmin.php'); ?>
        <br>
        <div class="container">
            <h2>Por favor, insira o número do chamado que você deseja remover</h2>
            <br>
            <form method="POST" action="deleteOS.php">
                <div class="form-group position-relative">
                    <input type="number" class="form-control" id="oser" placeholder="Número do Chamado" name="oser" required />
                </div>
                <br>
                <button type="submit" class="btn btn-danger btn-block">Remover Chamado</button>
            </form>
            <br>
            <h2>Chamados em Aberto</h2>
            <div class="row">
                <?php while ($produto = $execute->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Chamado #<?php echo htmlspecialchars($produto['contador']); ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($produto['titulo']); ?></h5>
                                <p class="card-text"><b>Descrição</b>: <?php echo htmlspecialchars($produto['servico']); ?></p>
                            </div>
                            <div class="card-footer">
                                <?php
                                    $datahora = $produto['datahora'];
                                    $date = DateTime::createFromFormat('d/m/Y H:i', $datahora);
                                    if($date){
                                        echo "Criado em: " . htmlspecialchars($date->format('d/m/Y H:i'));
                                    }else{
                                        echo "Data inválida";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </body>
</html>