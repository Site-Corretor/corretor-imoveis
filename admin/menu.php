<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location: index.php");
    exit;
}

require_once 'clsControle.php';
$u = new user;
$u->conectar();

$casasCadastradas = $u->VisualizarImoveis();
$cadaDestaque = $u->casaDestaque();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="/admin/admin.css?v=2">
=======
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
>>>>>>> origin/main
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-top">
                <img src="../imagens/logo-ricardo.png" alt="Ricardo Souza Imóveis" class="admin-sidebar-logo">
                <span class="admin-sidebar-badge">Painel administrativo</span>
            </div>

            <nav class="admin-sidebar-nav">
                <a href="menu.php" class="active">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <a href="cadastrarCasa.php">
                    <i class="fas fa-plus-circle"></i>
                    <span>Cadastrar Imóvel</span>
                </a>

                <a href="casasCadastradas.php">
                    <i class="fas fa-home"></i>
                    <span>Imóveis Cadastrados</span>
                </a>

                <a href="https://ricardosouzaimoveis.com.br/" target="_blank">
                    <i class="fas fa-globe"></i>
                    <span>Abrir Site</span>
                </a>

                <a href="logoff.php" class="admin-sidebar-exit">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </nav>
        </aside>

        <!-- Conteúdo -->
        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <span class="admin-page-badge">Visão geral</span>
                    <h1>Painel principal</h1>
                    <p>Acompanhe rapidamente os principais números e acesse as áreas de gestão do site.</p>
                </div>

                <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Abrir menu">
                    <i class="fas fa-bars"></i>
                </button>
            </header>

            <section class="admin-cards-grid">
                <article class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fas fa-home"></i>
                    </div>

                    <div class="admin-card-content">
                        <span class="admin-card-label">Imóveis cadastrados</span>
                        <h2><?php echo is_array($casasCadastradas) ? count($casasCadastradas) : 0; ?></h2>
                        <p>Total de imóveis atualmente registrados no sistema.</p>
                    </div>

                    <div class="admin-card-footer">
                        <a href="casasCadastradas.php" class="admin-card-link">
                            Abrir listagem
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>

                <article class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fas fa-star"></i>
                    </div>

                    <div class="admin-card-content">
                        <span class="admin-card-label">Imóveis em destaque</span>
                        <h2><?php echo is_array($cadaDestaque) ? count($cadaDestaque) : 0; ?></h2>
                        <p>Quantidade de imóveis marcados como destaque no site.</p>
                    </div>

                    <div class="admin-card-footer">
                        <a href="casasCadastradas.php" class="admin-card-link">
                            Gerenciar destaques
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </section>

            <section class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <span class="admin-page-badge">Acesso rápido</span>
                        <h3>Atalhos do painel</h3>
                    </div>
                </div>

                <div class="admin-shortcuts">
                    <a href="cadastrarCasa.php" class="admin-shortcut-box">
                        <i class="fas fa-plus-circle"></i>
                        <strong>Novo imóvel</strong>
                        <span>Cadastrar um novo imóvel no sistema.</span>
                    </a>

                    <a href="casasCadastradas.php" class="admin-shortcut-box">
                        <i class="fas fa-list-ul"></i>
                        <strong>Listagem</strong>
                        <span>Visualizar e gerenciar os imóveis cadastrados.</span>
                    </a>

                    <a href="https://ricardosouzaimoveis.com.br/" target="_blank" class="admin-shortcut-box">
                        <i class="fas fa-external-link-alt"></i>
                        <strong>Ver site</strong>
                        <span>Abrir o site público em uma nova aba.</span>
                    </a>
                </div>
            </section>
        </main>
    </div>

    <script>
        const toggleButton = document.getElementById('adminMenuToggle');
        const sidebar = document.getElementById('adminSidebar');

        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    </script>
</body>

</html>