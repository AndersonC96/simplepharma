<nav class="navbar navbar-expand-lg navbar-secondary bg-secondary px-0 py-3">
    <div class="container-xl">
        <a class="navbar-brand" href="#">
            <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" class="h-12" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-lg-auto">
                <a class="nav-item nav-link active" href="adminHome.php" aria-current="page"><i class="bi bi-house-door"></i> Home</a>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="chamadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-card-list"></i> Chamados</a>
                    <ul class="dropdown-menu" aria-labelledby="chamadosDropdown">
                        <li><a class="dropdown-item" href="abrirchamadoAdmin.php"><i class="bi bi-plus-circle"></i> Abrir Chamado</a></li>
                        <li><a class="dropdown-item" href="deletarchamadoAdmin.php"><i class="bi bi-trash"></i> Deletar Chamado</a></li>
                        <li><a class="dropdown-item" href="chamadosAbertos.php"><i class="bi bi-exclamation-circle"></i> Chamados em Aberto <span class="badge bg-danger"><?php echo $num; ?></span></a></li>
                        <li><a class="dropdown-item" href="chamadosConcluidos.php"><i class="bi bi-check-circle"></i> Chamados Concluídos</a></li>
                        <li><a class="dropdown-item" href="verchamadosAdmin.php"><i class="bi bi-list"></i> Listar Chamados</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tecnicoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person"></i> Técnico</a>
                    <ul class="dropdown-menu" aria-labelledby="tecnicoDropdown">
                        <li><a class="dropdown-item" href="inseretecnicoRes.php"><i class="bi bi-person-plus"></i> Inserir Técnico</a></li>
                        <li><a class="dropdown-item" href="removetecnicoRes.php"><i class="bi bi-person-x"></i> Remover Técnico</a></li>
                        <li><a class="dropdown-item" href="verTecnicos.php"><i class="bi bi-person-lines-fill"></i> Ver Técnicos</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-people"></i> Usuários</a>
                    <ul class="dropdown-menu" aria-labelledby="usuarioDropdown">
                        <li><a class="dropdown-item" href="insereUsuario.php"><i class="bi bi-person-plus"></i> Inserir Usuário</a></li>
                        <li><a class="dropdown-item" href="removeUsuario.php"><i class="bi bi-person-x"></i> Remover Usuário</a></li>
                        <li><a class="dropdown-item" href="verUsuarios.php"><i class="bi bi-people"></i> Ver Usuários</a></li>
                    </ul>
                </li>
            </div>
            <div class="navbar-nav ms-lg-4">
                <a class="nav-item nav-link" href="#"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['sess_usersisname']); ?></a>
            </div>
            <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
                <a href="logout.php" class="btn btn-sm btn-secondary w-full w-lg-auto"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
    </div>
</nav>