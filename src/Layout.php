<?php

namespace App;

class Layout
{
    public static function header($title, $active_page = 'home', $num_chamados = 0)
    {
        $user_name = $_SESSION['user_name'] ?? 'Usuário';
        $role = $_SESSION['user_role'] ?? '';
        $base_path = '../'; 
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo htmlspecialchars($title); ?> | SafeTickets Pro</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
            <link rel="stylesheet" href="<?php echo $base_path; ?>CSS/global.css?v=2.1">
            <link rel="icon" type="image/png" href="<?php echo $base_path; ?>img/favicon.png"/>
        </head>
        <body class="bg-light">
            <!-- Professional Sidebar V2 -->
            <aside class="sidebar">
                <a href="adminHome.php" class="brand">
                    <i class="fas fa-ticket-alt brand-icon"></i>
                    <span>SafeTickets</span>
                </a>

                <nav class="nav-group">
                    <span class="nav-label">Monitoramento</span>
                    <a href="adminHome.php" class="nav-link-item <?php echo $active_page === 'home' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="chamadosAbertos.php" class="nav-link-item <?php echo $active_page === 'chamados' ? 'active' : ''; ?>">
                        <i class="fas fa-inbox"></i> Chamados Abertos
                    </a>
                    <a href="chamadosConcluidos.php" class="nav-link-item">
                        <i class="fas fa-check-double"></i> Concluídos
                    </a>
                </nav>

                <?php if ($role === 'admin'): ?>
                <nav class="nav-group">
                    <span class="nav-label">Administração</span>
                    <a href="verUsuarios.php" class="nav-link-item">
                        <i class="fas fa-users-cog"></i> Usuários
                    </a>
                    <a href="verTecnicos.php" class="nav-link-item">
                        <i class="fas fa-user-shield"></i> Técnicos
                    </a>
                    <a href="verchamadosAdmin.php" class="nav-link-item">
                        <i class="fas fa-database"></i> Logs do Sistema
                    </a>
                </nav>
                <?php endif; ?>

                <div class="mt-auto px-2">
                    <a href="../logout.php" class="nav-link-item text-danger border border-danger-subtle mt-4">
                        <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                    </a>
                </div>
            </aside>

            <!-- Main Application Shell -->
            <main class="main-shell">
                <header class="top-header">
                    <div class="d-flex align-items-center">
                        <h1 class="h5 fw-bold mb-0 text-slate-800">
                             <?php echo htmlspecialchars($title); ?>
                        </h1>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end d-none d-sm-block">
                            <p class="mb-0 small fw-bold"><?php echo htmlspecialchars($user_name); ?></p>
                            <p class="mb-0 x-small text-muted text-uppercase" style="font-size: 0.65rem;"><?php echo strtoupper($role); ?></p>
                        </div>
                        <div class="avatar bg-indigo-100 p-2 rounded-circle border">
                            <i class="fas fa-user-circle fa-xl text-primary"></i>
                        </div>
                    </div>
                </header>

                <div class="content-area">
        <?php
    }

    public static function footer()
    {
        ?>
                </div>
                <footer class="py-4 px-5 text-muted small border-top bg-white mt-auto">
                    <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                        <span>&copy; <?php echo date('Y'); ?> SafeTickets - Advanced IT Support Case Study</span>
                        <div class="d-flex gap-3">
                           <span class="badge bg-light text-dark border">v2.0.4 - Premium</span>
                        </div>
                    </div>
                </footer>
            </main>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}
