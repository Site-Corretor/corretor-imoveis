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
$casaPesquisada = null;

/* =========================================================
   EXCLUIR IMÓVEL NA MESMA PÁGINA
========================================================= */
if (isset($_POST['confirmar_exclusao'])) {
    $codigoExcluir = trim($_POST['codigo_excluir']);

    if (!empty($codigoExcluir)) {
        $u->ExcluiCasa($codigoExcluir);
        header("Location: casasCadastradas.php");
        exit;
    }
}

/* =========================================================
   PESQUISA
========================================================= */
if (isset($_POST['pesquisar'])) {
    $codigo = trim($_POST['pesquisar']);
    $casaPesquisada = $u->VisualizarImoveisUnico($codigo);

    if (empty($casaPesquisada)) {
        echo "<script language='javascript'>alert('Casa não encontrada');</script>";
        echo "<script language='javascript'>window.location.href='casasCadastradas.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis Cadastrados</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="admin.css">

    <style>
        .admin-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 9999;
        }

        .admin-modal-overlay.active {
            display: flex;
        }

        .admin-modal-box {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
            padding: 24px;
        }

        .admin-modal-box h3 {
            font-size: 24px;
            font-weight: 800;
            color: #161616;
            margin-bottom: 12px;
        }

        .admin-modal-box p {
            font-size: 15px;
            line-height: 1.7;
            color: #6e6a65;
            margin-bottom: 16px;
        }

        .admin-modal-info {
            background: #faf7f3;
            border: 1px solid #eee4d9;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .admin-modal-info p {
            margin: 0 0 8px 0;
            color: #4b4742;
            font-size: 14px;
            line-height: 1.5;
        }

        .admin-modal-info p:last-child {
            margin-bottom: 0;
        }

        .admin-modal-info strong {
            color: #161616;
        }

        .admin-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .admin-modal-cancel {
            border: none;
        }

        .admin-delete-trigger {
            border: none;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .admin-modal-actions {
                flex-direction: column;
            }

            .admin-modal-actions .admin-search-btn,
            .admin-modal-actions .admin-table-btn {
                width: 100%;
            }
        }
    </style>
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
                <a href="menu.php">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <a href="cadastrarCasa.php">
                    <i class="fas fa-plus-circle"></i>
                    <span>Cadastrar Imóvel</span>
                </a>

                <a href="casasCadastradas.php" class="active">
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
                    <span class="admin-page-badge">Gestão de imóveis</span>
                    <h1>Imóveis cadastrados</h1>
                    <p>Pesquise, visualize e gerencie os imóveis cadastrados no sistema.</p>
                </div>

                <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Abrir menu">
                    <i class="fas fa-bars"></i>
                </button>
            </header>

            <section class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <span class="admin-page-badge">Pesquisa</span>
                        <h3>Buscar por código</h3>
                    </div>
                </div>

                <form method="post" action="casasCadastradas.php" class="admin-search-form">
                    <input type="text" name="pesquisar" class="admin-search-input" placeholder="Pesquise pelo código do imóvel">

                    <button type="submit" class="admin-search-btn">
                        <i class="fas fa-search"></i>
                        <span>Pesquisar</span>
                    </button>

                    <?php if (empty($casaPesquisada)) { ?>
                        <a href="menu.php" class="admin-search-btn admin-search-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span>Voltar</span>
                        </a>
                    <?php } else { ?>
                        <a href="casasCadastradas.php" class="admin-search-btn admin-search-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span>Limpar busca</span>
                        </a>
                    <?php } ?>
                </form>
            </section>

            <section class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <span class="admin-page-badge">Listagem</span>
                        <h3>Imóveis registrados</h3>
                    </div>
                </div>

                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Título</th>
                                <th>Destaque</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($casaPesquisada)) { ?>
                                <?php if (!empty($casasCadastradas)) { ?>
                                    <?php for ($i = 0; $i < count($casasCadastradas); $i++) { ?>
                                        <?php if ($casasCadastradas[$i]['ativo'] == '1') { ?>
                                            <tr>
                                                <td><?php echo $casasCadastradas[$i]['codigo']; ?></td>
                                                <td><?php echo $casasCadastradas[$i]['titulo']; ?></td>
                                                <td>
                                                    <span class="admin-status-badge <?php echo ($casasCadastradas[$i]['destaque'] == 'sim') ? 'is-highlight' : 'is-normal'; ?>">
                                                        <?php echo $casasCadastradas[$i]['destaque']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="admin-table-btn edit" href="editarCasa.php?codigo=<?php echo $casasCadastradas[$i]['codigo']; ?>">
                                                        Editar
                                                    </a>
                                                </td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="admin-table-btn delete admin-delete-trigger"
                                                        data-codigo="<?php echo htmlspecialchars($casasCadastradas[$i]['codigo']); ?>"
                                                        data-titulo="<?php echo htmlspecialchars($casasCadastradas[$i]['titulo']); ?>"
                                                        data-destaque="<?php echo htmlspecialchars($casasCadastradas[$i]['destaque']); ?>"
                                                    >
                                                        Excluir
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="5" class="admin-table-empty">Nenhum imóvel cadastrado no momento.</td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td><?php echo $casaPesquisada['codigo']; ?></td>
                                    <td><?php echo $casaPesquisada['titulo']; ?></td>
                                    <td>
                                        <span class="admin-status-badge <?php echo ($casaPesquisada['destaque'] == 'sim') ? 'is-highlight' : 'is-normal'; ?>">
                                            <?php echo $casaPesquisada['destaque']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a class="admin-table-btn edit" href="editarCasa.php?codigo=<?php echo $casaPesquisada['codigo']; ?>">
                                            Editar
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="admin-table-btn delete admin-delete-trigger"
                                            data-codigo="<?php echo htmlspecialchars($casaPesquisada['codigo']); ?>"
                                            data-titulo="<?php echo htmlspecialchars($casaPesquisada['titulo']); ?>"
                                            data-destaque="<?php echo htmlspecialchars($casaPesquisada['destaque']); ?>"
                                        >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal de exclusão -->
    <div class="admin-modal-overlay" id="deleteModal">
        <div class="admin-modal-box">
            <h3>Confirmar exclusão</h3>
            <p>Confira as informações abaixo antes de excluir este imóvel.</p>

            <div class="admin-modal-info">
                <p><strong>Código:</strong> <span id="modalCodigo">-</span></p>
                <p><strong>Título:</strong> <span id="modalTitulo">-</span></p>
                <p><strong>Destaque:</strong> <span id="modalDestaque">-</span></p>
            </div>

            <form method="post" action="casasCadastradas.php">
                <input type="hidden" name="codigo_excluir" id="codigoExcluirInput">

                <div class="admin-modal-actions">
                    <button type="button" class="admin-search-btn admin-search-btn-secondary admin-modal-cancel" id="cancelDelete">
                        Cancelar
                    </button>

                    <button type="submit" name="confirmar_exclusao" class="admin-table-btn delete">
                        Excluir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById('adminMenuToggle');
        const sidebar = document.getElementById('adminSidebar');

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });

        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteTriggers = document.querySelectorAll('.admin-delete-trigger');

        const modalCodigo = document.getElementById('modalCodigo');
        const modalTitulo = document.getElementById('modalTitulo');
        const modalDestaque = document.getElementById('modalDestaque');
        const codigoExcluirInput = document.getElementById('codigoExcluirInput');

        deleteTriggers.forEach((button) => {
            button.addEventListener('click', function () {
                modalCodigo.textContent = this.dataset.codigo || '-';
                modalTitulo.textContent = this.dataset.titulo || '-';
                modalDestaque.textContent = this.dataset.destaque || '-';
                codigoExcluirInput.value = this.dataset.codigo || '';
                deleteModal.classList.add('active');
            });
        });

        cancelDelete.addEventListener('click', function () {
            deleteModal.classList.remove('active');
        });

        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                deleteModal.classList.remove('active');
            }
        });
    </script>
</body>

</html>