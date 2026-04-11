<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    exit;
}

$codigo = $_GET['codigo'];

require_once 'clsControle.php';
require_once 'conexao_ftp.php';
require_once 'ftp.php';

$p = new User;
$p->conectar();

/* =========================================================
   ALTERAR CAPA VIA AJAX
========================================================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax_action']) &&
    $_POST['ajax_action'] === 'alterar_capa'
) {
    header('Content-Type: application/json; charset=utf-8');

    $img_capa = isset($_POST['img_capa']) ? trim($_POST['img_capa']) : '';

    if ($img_capa === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Imagem não informada.'
        ]);
        exit;
    }

    try {
        $p->updateCapa($codigo, $img_capa);

        echo json_encode([
            'success' => true,
            'message' => 'Capa atualizada com sucesso.',
            'img_capa' => $img_capa
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível alterar a capa.'
        ]);
    }

    exit;
}

/* =========================================================
   UPLOAD DE IMAGENS - MODO LOCAL
   ---------------------------------------------------------
   Se ainda não existir capa, a primeira imagem enviada
   vira capa automaticamente.
========================================================= */
if (
    isset($_FILES['imagem']) &&
    is_array($_FILES['imagem']['name']) &&
    !empty(array_filter($_FILES['imagem']['name']))
) {
    $uploadDirectory = __DIR__ . '/upload/';
    $uploadSucesso = false;

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $imagensAtuais = $p->getImagens($codigo);
    $jaTemCapa = false;

    if (!empty($imagensAtuais)) {
        foreach ($imagensAtuais as $imgAtual) {
            if (isset($imgAtual['capa']) && $imgAtual['capa'] == 1) {
                $jaTemCapa = true;
                break;
            }
        }
    }

    $primeiraImagemEnviada = null;

    foreach ($_FILES['imagem']['name'] as $i => $fileName) {
        if (empty($fileName)) {
            continue;
        }

        $fileTmpName = $_FILES['imagem']['tmp_name'][$i];

        if (!file_exists($fileTmpName)) {
            continue;
        }

        $pathInfo = pathinfo($fileName);
        $fileExtension = strtolower($pathInfo['extension']);
        $novoNome = $codigo . "-" . $i . "." . $fileExtension;
        $destinoFinal = $uploadDirectory . $novoNome;

        if (move_uploaded_file($fileTmpName, $destinoFinal)) {
            $caminho = 'upload/';
            $img = $novoNome;
            $p->updateImagem($codigo, $caminho, $img);
            $uploadSucesso = true;

            if ($primeiraImagemEnviada === null) {
                $primeiraImagemEnviada = $img;
            }
        }
    }

    if ($uploadSucesso && !$jaTemCapa && $primeiraImagemEnviada !== null) {
        $p->updateCapa($codigo, $primeiraImagemEnviada);
    }

    if ($uploadSucesso) {
        $_SESSION['flash_sucesso'] = 'Salvo com sucesso';
        header("Location: imagem.php?codigo=$codigo");
        exit;
    }
}

/* =========================================================
   CÓDIGO FTP ANTIGO - MANTIDO COMENTADO
========================================================= */

/*
if (
    isset($_FILES['imagem']) &&
    is_array($_FILES['imagem']['name']) &&
    !empty(array_filter($_FILES['imagem']['name']))
) {
    $ftp_connection = ftp_connect($ftp_host) or die("Couldn't connect to $ftp_host");
    ftp_login($ftp_connection, $ftp_user, $ftp_pass) or die("Couldn't login to ftp server");
    ftp_pasv($ftp_connection, true);

    $uploadDirectory = '/admin/upload/';
    $uploadSucesso = false;

    $imagensAtuais = $p->getImagens($codigo);
    $jaTemCapa = false;

    if (!empty($imagensAtuais)) {
        foreach ($imagensAtuais as $imgAtual) {
            if (isset($imgAtual['capa']) && $imgAtual['capa'] == 1) {
                $jaTemCapa = true;
                break;
            }
        }
    }

    $primeiraImagemEnviada = null;

    foreach ($_FILES['imagem']['name'] as $i => $fileName) {
        if (empty($fileName)) {
            continue;
        }

        $fileTmpName = $_FILES['imagem']['tmp_name'][$i];

        if (!file_exists($fileTmpName)) {
            continue;
        }

        $pathInfo = pathinfo($fileName);
        $fileExtension = strtolower($pathInfo['extension']);
        $remoteFilePath = $uploadDirectory . $codigo . "-" . $i . "." . $fileExtension;

        if (ftp_put($ftp_connection, $remoteFilePath, $fileTmpName, FTP_BINARY)) {
            $img = $codigo . "-" . $i . "." . $fileExtension;
            $caminho = $uploadDirectory;
            $p->updateImagem($codigo, $caminho, $img);
            $uploadSucesso = true;

            if ($primeiraImagemEnviada === null) {
                $primeiraImagemEnviada = $img;
            }
        }
    }

    ftp_close($ftp_connection);

    if ($uploadSucesso && !$jaTemCapa && $primeiraImagemEnviada !== null) {
        $p->updateCapa($codigo, $primeiraImagemEnviada);
    }

    if ($uploadSucesso) {
        $_SESSION['flash_sucesso'] = 'Salvo com sucesso';
        header("Location: imagem.php?codigo=$codigo");
        exit;
    }
}
*/

/* =========================================================
   LISTA DE IMAGENS
========================================================= */
$imagens = $p->getImagens($codigo);

/* =========================================================
   ALERTA FLASH
========================================================= */
if (isset($_SESSION['flash_sucesso'])) {
    echo "<script language='javascript'>alert('" . $_SESSION['flash_sucesso'] . "');</script>";
    unset($_SESSION['flash_sucesso']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagens do Imóvel</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="admin-layout">
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

        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <span class="admin-page-badge">Imagens</span>
                    <h1>Gerenciar imagens do imóvel</h1>
                    <p>Envie novas imagens, defina a capa principal e remova arquivos que não deseja manter.</p>
                </div>

                <button class="admin-menu-toggle" id="adminMenuToggle" aria-label="Abrir menu">
                    <i class="fas fa-bars"></i>
                </button>
            </header>

            <section class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <span class="admin-page-badge">Upload</span>
                        <h3>Anexar imagens</h3>
                    </div>
                </div>

                <form action="imagem.php?codigo=<?php echo $codigo; ?>" method="post" enctype="multipart/form-data" class="admin-upload-form">
                    <div class="admin-upload-box">
                        <label for="imagem" class="admin-upload-label">Selecionar imagens</label>
                        <input type="file" id="imagem" name="imagem[]" accept="image/*" multiple class="admin-upload-input">
                    </div>

                    <div class="admin-form-actions">
                        <a href="editarCasa.php?codigo=<?php echo $codigo; ?>" class="admin-search-btn admin-search-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span>Voltar</span>
                        </a>

                        <button type="submit" class="admin-search-btn">
                            <i class="fas fa-upload"></i>
                            <span>Anexar imagens</span>
                        </button>
                    </div>
                </form>
            </section>

            <section class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <span class="admin-page-badge">Galeria</span>
                        <h3>Imagens cadastradas</h3>
                    </div>
                </div>

                <?php if (!empty($imagens)) { ?>
                    <div class="admin-image-grid" id="adminImageGrid">
                        <?php foreach ($imagens as $imagem) { ?>
                            <div class="admin-image-card" data-img="<?php echo htmlspecialchars($imagem['img']); ?>">
                                <div class="admin-image-preview">
                                    <img src="upload/<?php echo $imagem['img']; ?>" alt="Pré-visualização da imagem">
                                </div>

                                <div class="admin-image-info">
                                    <p class="admin-image-name"><?php echo $imagem['img']; ?></p>

                                    <span class="admin-status-badge <?php echo (isset($imagem['capa']) && $imagem['capa'] == 1) ? 'is-highlight' : 'is-normal'; ?>">
                                        <?php echo (isset($imagem['capa']) && $imagem['capa'] == 1) ? 'Capa atual' : 'Imagem comum'; ?>
                                    </span>
                                </div>

                                <div class="admin-image-actions">
                                    <button
                                        type="button"
                                        class="admin-table-btn delete js-open-delete-modal"
                                        data-img="<?php echo htmlspecialchars($imagem['img']); ?>">
                                        Excluir
                                    </button>

                                    <form class="admin-capa-form js-capa-form">
                                        <input type="hidden" name="img_capa" value="<?php echo htmlspecialchars($imagem['img']); ?>">

                                        <label class="admin-capa-radio-label">
                                            <input
                                                type="radio"
                                                name="capa_radio_global"
                                                class="admin-capa-radio"
                                                <?php echo (isset($imagem['capa']) && $imagem['capa'] == 1) ? 'checked' : ''; ?>>
                                            <span>Definir como capa</span>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="admin-table-empty">Nenhuma imagem cadastrada para este imóvel.</div>
                <?php } ?>
            </section>
        </main>
    </div>

    <!-- Modal de exclusão -->
    <div class="admin-modal-overlay" id="deleteImageModal">
        <div class="admin-modal">
            <div class="admin-modal-header">
                <h3>Excluir imagem</h3>
                <button type="button" class="admin-modal-close" id="closeDeleteModal">&times;</button>
            </div>

            <div class="admin-modal-body">
                <p>Tem certeza que deseja excluir esta imagem?</p>
                <p class="admin-modal-subtext">Se ela for a capa atual, outra imagem será definida automaticamente.</p>
            </div>

            <div class="admin-modal-actions">
                <button type="button" class="admin-search-btn admin-search-btn-secondary" id="cancelDeleteModal">
                    Cancelar
                </button>
                <button type="button" class="admin-search-btn delete" id="confirmDeleteModal">
                    Excluir imagem
                </button>
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById('adminMenuToggle');
        const sidebar = document.getElementById('adminSidebar');

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }

        const codigo = <?php echo json_encode($codigo); ?>;
        const capaForms = document.querySelectorAll('.js-capa-form');

        capaForms.forEach((form) => {
            const radio = form.querySelector('.admin-capa-radio');

            radio.addEventListener('change', async function() {
                const formData = new FormData();
                formData.append('ajax_action', 'alterar_capa');
                formData.append('img_capa', form.querySelector('input[name="img_capa"]').value);

                radio.disabled = true;

                try {
                    const response = await fetch(`imagem.php?codigo=${encodeURIComponent(codigo)}`, {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (!data.success) {
                        alert(data.message || 'Não foi possível alterar a capa.');
                        radio.disabled = false;
                        return;
                    }

                    document.querySelectorAll('.admin-image-card').forEach((card) => {
                        const badge = card.querySelector('.admin-status-badge');
                        const currentRadio = card.querySelector('.admin-capa-radio');

                        if (card.dataset.img === data.img_capa) {
                            badge.classList.remove('is-normal');
                            badge.classList.add('is-highlight');
                            badge.textContent = 'Capa atual';
                            currentRadio.checked = true;
                        } else {
                            badge.classList.remove('is-highlight');
                            badge.classList.add('is-normal');
                            badge.textContent = 'Imagem comum';
                            currentRadio.checked = false;
                        }

                        currentRadio.disabled = false;
                    });
                } catch (error) {
                    radio.disabled = false;
                    alert('Erro ao atualizar a capa.');
                }
            });
        });

        /* =========================================================
           MODAL DE EXCLUSÃO + AJAX
        ========================================================= */
        const deleteModal = document.getElementById('deleteImageModal');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteModal = document.getElementById('cancelDeleteModal');
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const deleteButtons = document.querySelectorAll('.js-open-delete-modal');

        let selectedImgToDelete = null;

        function openDeleteModal(img) {
            selectedImgToDelete = img;
            deleteModal.classList.add('active');
        }

        function hideDeleteModal() {
            deleteModal.classList.remove('active');
            selectedImgToDelete = null;
        }

        deleteButtons.forEach((button) => {
            button.addEventListener('click', function() {
                openDeleteModal(this.dataset.img);
            });
        });

        closeDeleteModal.addEventListener('click', hideDeleteModal);
        cancelDeleteModal.addEventListener('click', hideDeleteModal);

        deleteModal.addEventListener('click', function(event) {
            if (event.target === deleteModal) {
                hideDeleteModal();
            }
        });

        confirmDeleteModal.addEventListener('click', async function() {
            if (!selectedImgToDelete) return;

            confirmDeleteModal.disabled = true;

            const formData = new FormData();
            formData.append('ajax_action', 'excluir_imagem');
            formData.append('codigo', codigo);
            formData.append('img', selectedImgToDelete);

            try {
                const response = await fetch(`excluir_imagem.php?codigo=${encodeURIComponent(codigo)}&img=${encodeURIComponent(selectedImgToDelete)}`, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message || 'Não foi possível excluir a imagem.');
                    confirmDeleteModal.disabled = false;
                    return;
                }

                const card = document.querySelector(`.admin-image-card[data-img="${CSS.escape(selectedImgToDelete)}"]`);
                if (card) {
                    card.remove();
                }

                if (data.nova_capa) {
                    document.querySelectorAll('.admin-image-card').forEach((currentCard) => {
                        const badge = currentCard.querySelector('.admin-status-badge');
                        const currentRadio = currentCard.querySelector('.admin-capa-radio');

                        if (currentCard.dataset.img === data.nova_capa) {
                            badge.classList.remove('is-normal');
                            badge.classList.add('is-highlight');
                            badge.textContent = 'Capa atual';
                            currentRadio.checked = true;
                        } else {
                            badge.classList.remove('is-highlight');
                            badge.classList.add('is-normal');
                            badge.textContent = 'Imagem comum';
                            currentRadio.checked = false;
                        }
                    });
                }

                const remainingCards = document.querySelectorAll('.admin-image-card');
                const imageGrid = document.getElementById('adminImageGrid');

                if (remainingCards.length === 0 && imageGrid) {
                    imageGrid.innerHTML = '';
                    imageGrid.insertAdjacentHTML(
                        'afterend',
                        '<div class="admin-table-empty" id="adminNoImagesMessage">Nenhuma imagem cadastrada para este imóvel.</div>'
                    );
                }

                hideDeleteModal();
                confirmDeleteModal.disabled = false;
            } catch (error) {
                alert('Erro ao excluir a imagem.');
                confirmDeleteModal.disabled = false;
            }
        });
    </script>
</body>

</html>