<?php

namespace App;

class Layout
{
    public static function header($title, $active_page = 'home', $num_chamados = 0)
    {
        $user_name = $_SESSION['user_name'] ?? 'Usuário';
        $role = $_SESSION['user_role'] ?? '';
        $base_path = ($role === 'admin') ? '' : '../'; // Simple logic for nested dirs
        
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo htmlspecialchars($title); ?> | SafeTickets</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
            <link rel="icon" type="image/png" href="../img/favicon.png"/>
            <style>
                body { background-color: #f8f9fa; }
                .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.08); }
                .navbar-brand { font-weight: 700; color: #0d6efd !important; }
            </style>
        </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container">
                <a class="navbar-brand" href="adminHome.php">SafeTickets</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_page === 'home' ? 'active' : ''; ?>" href="adminHome.php">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ticket-alt"></i> Chamados
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="abrirchamadoAdmin.php">Abrir Chamado</a></li>
                                <li><a class="dropdown-item" href="chamadosAbertos.php">Em Aberto <span class="badge bg-danger"><?php echo $num_chamados; ?></span></a></li>
                                <li><a class="dropdown-item" href="chamadosConcluidos.php">Concluídos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="verchamadosAdmin.php">Listar Todos</a></li>
                            </ul>
                        </li>
                        <?php if ($role === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-cog"></i> Administração
                            </a>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">Técnicos</h6></li>
                                <li><a class="dropdown-item" href="inseretecnicoRes.php">Inserir Técnico</a></li>
                                <li><a class="dropdown-item" href="verTecnicos.php">Ver Técnicos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Usuários</h6></li>
                                <li><a class="dropdown-item" href="insereUsuario.php">Inserir Usuário</a></li>
                                <li><a class="dropdown-item" href="verUsuarios.php">Ver Usuários</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div class="navbar-nav align-items-center">
                        <span class="nav-item me-3 text-muted">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($user_name); ?>
                        </span>
                        <a href="../logout.php" class="btn btn-outline-danger btn-sm">Sair</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
        <?php
    }

    public static function footer()
    {
        ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}
