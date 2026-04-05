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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SafeTickets - Sistema de Chamados</title>
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="CSS/global.css?v=2.0">
        <style>
            .login-mesh {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #0f172a;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                    radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(253,16%,7%,1) 0, transparent 50%);
                position: relative;
                overflow: hidden;
            }
            .login-glass-card {
                max-width: 420px;
                width: 100%;
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 24px;
                padding: 3rem;
                z-index: 10;
            }
            .form-control-v2 {
                background: rgba(255, 255, 255, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                color: white !important;
                padding: 0.75rem 1rem !important;
                border-radius: 12px !important;
            }
            .form-control-v2::placeholder { color: rgba(255, 255, 255, 0.3); }
            .btn-v2 {
                background: #6366f1 !important;
                border: none !important;
                padding: 0.8rem !important;
                border-radius: 12px !important;
                font-weight: 600 !important;
                box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.5);
            }
        </style>
    </head>
    <body class="login-mesh">
        <main class="login-glass-card shadow-2xl">
            <header class="text-center mb-5">
                <div class="mb-3">
                    <i class="fas fa-ticket-alt fa-3x text-indigo-400" style="color: #818cf8;"></i>
                </div>
                <h1 class="h2 fw-bold text-white mb-1">SafeTickets</h1>
                <p class="text-indigo-200 small opacity-75">Plataforma de Suporte Técnico Profissional</p>
            </header>
            
            <?php if ($error_msg): ?>
                <div class="alert alert-danger bg-danger bg-opacity-25 border-0 text-white py-2 small text-center mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <form action="autenticar.php" method="POST">
                <?php Csrf::field(); ?>
                
                <div class="mb-3">
                    <label class="form-label text-indigo-100 x-small fw-bold text-uppercase opacity-75" style="font-size: 0.65rem;">Identificação / E-mail</label>
                    <input type="email" class="form-control form-control-v2" name="email" placeholder="nome@exemplo.com" required autofocus>
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-indigo-100 x-small fw-bold text-uppercase opacity-75" style="font-size: 0.65rem;">Chave de Acesso</label>
                    <input type="password" class="form-control form-control-v2" name="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn btn-v2 btn-primary w-100 text-white">
                    Acessar Dashboard <i class="fas fa-chevron-right ms-2 small"></i>
                </button>
            </form>
            
            <footer class="mt-5 text-center">
                <p class="text-indigo-300 x-small opacity-50 mb-0">&copy; <?php echo date('Y'); ?> SafeTickets Pro — Case Técnico Sanitizado</p>
            </footer>
        </main>
    </body>
</html>