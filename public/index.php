<?php
require_once __DIR__ . '/../config/bootstrap.php';
use App\Csrf;

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['user_role'];
    if ($role === 'admin') header('Location: admin/adminHome.php');
    elseif ($role === 'tecnico') header('Location: tecnico/tecnicoHome.php');
    elseif ($role === 'subadmin') header('Location: subadmin/subadminHome.php');
    exit();
}

$error_msg = '';
if (isset($_GET['err'])) {
    if ($_GET['err'] == 1) $error_msg = 'Usuário ou senha inválidos.';
    elseif ($_GET['err'] == 2) $error_msg = 'Por favor, faça login para acessar esta área.';
    elseif ($_GET['err'] == 'csrf') $error_msg = 'Sessão expirada. Tente novamente.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SafeTickets - Sistema de Chamados</title>
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
        <link rel="stylesheet" href="CSS/style.css">
        <style>
            body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f4f7f6; }
            .login-container{ max-width: 400px; width: 100%; padding: 2rem; background-color: #ffffff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); }
            .login-header h1 { text-align: center; color: #333; margin-bottom: 2rem; font-size: 1.5rem; }
            .alert { padding: 0.75rem; margin-bottom: 1rem; border-radius: 6px; text-align: center; font-size: 0.9rem; }
            .alert-error { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        </style>
    </head>
    <body>
        <main class="login-container">
            <header class="login-header">
                <h1>SafeTickets</h1>
            </header>
            
            <?php if ($error_msg): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error_msg); ?></div>
            <?php endif; ?>

            <form action="autenticar.php" method="POST" class="login-form">
                <?php Csrf::field(); ?>
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" required autofocus>
                
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" placeholder="Sua senha" required>
                
                <button type="submit" class="contrast">Entrar</button>
            </form>
        </main>
    </body>
</html>