<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location: index.php");
    exit;
}

require_once 'clsControle.php';
require_once 'conexao_ftp.php';
require_once 'ftp.php';

$u = new user;
$u->conectar();

if (!isset($_SESSION['cadastro_temp_imagens'])) {
    $_SESSION['cadastro_temp_imagens'] = [];
}

/* =========================================================
   ANEXAR IMAGENS TEMPORARIAMENTE VIA AJAX
   - ainda não grava no banco
   - só salva em pasta temporária + sessão
========================================================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax_action']) &&
    $_POST['ajax_action'] === 'anexar_imagens_temp'
) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        if (
            !isset($_FILES['imagem']) ||
            !is_array($_FILES['imagem']['name']) ||
            empty(array_filter($_FILES['imagem']['name']))
        ) {
            echo json_encode([
                'success' => false,
                'message' => 'Nenhuma imagem foi selecionada.'
            ]);
            exit;
        }

        $tempDir = __DIR__ . '/upload/temp/';

        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $imagensTemp = [];
        $jaTemCapa = false;

        if (!empty($_SESSION['cadastro_temp_imagens'])) {
            foreach ($_SESSION['cadastro_temp_imagens'] as $imgAtual) {
                if (isset($imgAtual['capa']) && $imgAtual['capa'] == 1) {
                    $jaTemCapa = true;
                    break;
                }
            }
        }

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
            $tempName = uniqid('temp_', true) . '.' . $fileExtension;
            $destinoFinal = $tempDir . $tempName;

            if (move_uploaded_file($fileTmpName, $destinoFinal)) {
                $novaImagem = [
                    'img' => $tempName,
                    'temp' => 1,
                    'capa' => 0
                ];

                if (!$jaTemCapa && empty($_SESSION['cadastro_temp_imagens']) && empty($imagensTemp)) {
                    $novaImagem['capa'] = 1;
                    $jaTemCapa = true;
                }

                $_SESSION['cadastro_temp_imagens'][] = $novaImagem;
                $imagensTemp[] = $novaImagem;
            }
        }

        if (empty($imagensTemp)) {
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível anexar as imagens.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'imagens' => $imagensTemp
        ]);
    } catch (Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao anexar imagens.'
        ]);
    }

    exit;
}

/* =========================================================
   ALTERAR CAPA TEMP VIA AJAX
========================================================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax_action']) &&
    $_POST['ajax_action'] === 'alterar_capa_temp'
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

    if (!empty($_SESSION['cadastro_temp_imagens'])) {
        foreach ($_SESSION['cadastro_temp_imagens'] as &$imagem) {
            $imagem['capa'] = ($imagem['img'] === $img_capa) ? 1 : 0;
        }
        unset($imagem);
    }

    echo json_encode([
        'success' => true,
        'img_capa' => $img_capa
    ]);
    exit;
}

/* =========================================================
   EXCLUIR IMAGEM TEMP VIA AJAX
========================================================= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax_action']) &&
    $_POST['ajax_action'] === 'excluir_imagem_temp'
) {
    header('Content-Type: application/json; charset=utf-8');

    $img = isset($_POST['img']) ? trim($_POST['img']) : '';
    $novaCapa = null;

    if ($img === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Imagem não informada.'
        ]);
        exit;
    }

    $tempDir = __DIR__ . '/upload/temp/';
    $eraCapa = false;
    $novasImagens = [];

    if (!empty($_SESSION['cadastro_temp_imagens'])) {
        foreach ($_SESSION['cadastro_temp_imagens'] as $imagem) {
            if ($imagem['img'] === $img) {
                if (!empty($imagem['capa'])) {
                    $eraCapa = true;
                }

                $arquivo = $tempDir . $imagem['img'];
                if (file_exists($arquivo)) {
                    unlink($arquivo);
                }
            } else {
                $novasImagens[] = $imagem;
            }
        }
    }

    if ($eraCapa && !empty($novasImagens)) {
        $novasImagens[0]['capa'] = 1;
        $novaCapa = $novasImagens[0]['img'];

        for ($i = 1; $i < count($novasImagens); $i++) {
            $novasImagens[$i]['capa'] = 0;
        }
    }

    $_SESSION['cadastro_temp_imagens'] = $novasImagens;

    echo json_encode([
        'success' => true,
        'nova_capa' => $novaCapa
    ]);
    exit;
}

/* =========================================================
   SALVAR IMÓVEL + IMAGENS
========================================================= */
if (isset($_POST['salvar_tudo'])) {
    $titulo = $_POST['titulo'];
    $tipoImovel = $_POST['tipoImovel'];
    $total_area = $_POST['total_area'];
    $dormitorios = $_POST['dormitorios'];
    $banheiros = $_POST['banheiros'];
    $vagas = $_POST['vagas'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $cidade = $_POST['cidade'];
    $destaque = $_POST['destaque'];

    if ($u->msgErro == "") {
        try {
            $codigo = $u->cadastrarImovel(
                $titulo,
                $tipoImovel,
                $descricao,
                $total_area,
                $dormitorios,
                $banheiros,
                $vagas,
                $preco,
                $cidade,
                $destaque,
            );

            if (!$codigo) {
                $_SESSION['flash_erro'] = 'Não foi possível cadastrar o imóvel.';
                header("Location: cadastrarCasa.php");
                exit;
            }

            $tempDir = __DIR__ . '/upload/temp/';
            $uploadDir = __DIR__ . '/upload/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (!empty($_SESSION['cadastro_temp_imagens'])) {
                $indice = 0;
                $imgCapaFinal = null;

                foreach ($_SESSION['cadastro_temp_imagens'] as $imagemTemp) {
                    $origem = $tempDir . $imagemTemp['img'];

                    if (!file_exists($origem)) {
                        continue;
                    }

                    $ext = pathinfo($imagemTemp['img'], PATHINFO_EXTENSION);
                    $novoNome = $codigo . '-' . $indice . '.' . $ext;
                    $destino = $uploadDir . $novoNome;

                    if (rename($origem, $destino)) {
                        $u->updateImagem($codigo, 'upload/', $novoNome);

                        if (!empty($imagemTemp['capa'])) {
                            $imgCapaFinal = $novoNome;
                        }

                        $indice++;
                    }
                }

                if ($imgCapaFinal !== null) {
                    $u->updateCapa($codigo, $imgCapaFinal);
                }

                $_SESSION['cadastro_temp_imagens'] = [];
            }

            $_SESSION['flash_sucesso'] = 'Imóvel cadastrado com sucesso.';
            header("Location: cadastrarCasa.php?sucesso=1");
            exit;
            } catch (Throwable $e) {
            $_SESSION['flash_erro'] = 'Erro ao cadastrar o imóvel.';

            header("Location: cadastrarCasa.php");
            exit;
        }
    } else {
        $_SESSION['flash_erro'] = 'Erro: ' . $u->msgErro;
        header("Location: cadastrarCasa.php");
        exit;
    }
}

$imagensTemp = $_SESSION['cadastro_temp_imagens'] ?? [];

$flashSucesso = null;
$flashErro = null;

if (isset($_SESSION['flash_sucesso'])) {
    $flashSucesso = $_SESSION['flash_sucesso'];
    unset($_SESSION['flash_sucesso']);
}

if (isset($_SESSION['flash_erro'])) {
    $flashErro = $_SESSION['flash_erro'];
    unset($_SESSION['flash_erro']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Imóvel</title>

    <link rel="short cut icon" type="image/x-icon" href="../imagens/logo-ricardo.ico?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/admin/admin.css?v=2">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="/css/all.min.css">

    <style>
        .admin-form-unico .admin-image-grid-compact {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)) !important;
            gap: 14px !important;
        }

        .admin-form-unico .admin-image-card-compact {
            border-radius: 16px !important;
            overflow: hidden !important;
        }

        .admin-form-unico .admin-image-preview-compact {
            height: 120px !important;
        }

        .admin-form-unico .admin-image-preview-compact img {
            width: 100% !important;
            height: 120px !important;
            object-fit: cover !important;
        }

        .admin-form-unico .admin-image-info {
            padding: 10px 10px 8px !important;
            gap: 8px !important;
        }

        .admin-form-unico .admin-image-name {
            font-size: 13px !important;
            line-height: 1.35 !important;
        }

        .admin-form-unico .admin-status-badge {
            font-size: 10px !important;
            padding: 6px 10px !important;
        }

        .admin-form-unico .admin-image-actions {
            padding: 0 10px 10px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }

        .admin-form-unico .admin-image-actions .admin-table-btn {
            width: 100% !important;
            min-width: unset !important;
            padding: 9px 12px !important;
            font-size: 13px !important;
        }

        .admin-form-unico .admin-capa-wrap {
            width: 100% !important;
            margin: 0 !important;
        }

        .admin-form-unico .admin-capa-radio-label {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 8px !important;
            width: 100% !important;
            min-height: 34px !important;
            padding: 8px 10px !important;
            border: 1px solid #e6ddd2 !important;
            border-radius: 10px !important;
            background: #fff !important;
            cursor: pointer !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
        }

        .admin-form-unico .admin-capa-radio-label span {
            font-size: 12px !important;
            font-weight: 700 !important;
        }

        .admin-form-unico .admin-capa-radio {
            appearance: radio !important;
            -webkit-appearance: radio !important;
            display: inline-block !important;
            width: 14px !important;
            height: 14px !important;
            min-width: 14px !important;
            min-height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            flex: 0 0 14px !important;
            accent-color: #b39a7a !important;
            cursor: pointer !important;
        }

        .admin-form-unico .admin-form-actions-final {
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
            gap: 14px !important;
            margin-top: 12px !important;
            padding-top: 12px !important;
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-top">
                <img src="../imagens/logo-ricardo.png?v=2" alt="Ricardo Souza Imóveis" class="admin-sidebar-logo">
                <span class="admin-sidebar-badge">Painel administrativo</span>
            </div>

            <nav class="admin-sidebar-nav">
                <a href="menu.php"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
                <a href="cadastrarCasa.php" class="active"><i class="fas fa-plus-circle"></i><span>Cadastrar Imóvel</span></a>
                <a href="casasCadastradas.php"><i class="fas fa-home"></i><span>Imóveis Cadastrados</span></a>
                <a href="https://ricardosouzaimoveis.com.br/" target="_blank"><i class="fas fa-globe"></i><span>Abrir Site</span></a>
                <a href="logoff.php" class="admin-sidebar-exit"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar">
                <div>
                    <span class="admin-page-badge">Cadastro</span>
                    <h1>Cadastrar imóvel</h1>
                    <p>Preencha os dados, anexe as imagens e salve tudo no final.</p>
                </div>
            </header>

            <?php if ($flashErro) { ?>
                <div class="admin-toast admin-toast-error" id="adminToast">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $flashErro; ?></span>
                </div>
            <?php } ?>

            <form method="post" enctype="multipart/form-data" class="admin-panel admin-form-grid admin-form-unico">
                <div class="admin-inline-section admin-col-12">
                    <div class="admin-inline-section-title">
                        <span class="admin-page-badge">Formulário</span>
                        <h3>Dados do imóvel</h3>
                    </div>
                </div>

                <div class="admin-form-group admin-col-8">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div class="admin-form-group admin-col-4">
                    <label for="tipoImovel">Tipo de imóvel</label>
                    <select id="tipoImovel" name="tipoImovel" required>
                        <option value="">Selecione</option>
                        <option value="residencia">Residência</option>
                        <option value="comercio">Comércio</option>
                        <option value="industria">Indústria</option>
                        <option value="terreno">Terreno</option>
                    </select>
                </div>

                <div class="admin-form-group admin-col-3">
                    <label for="total_area">Área total</label>
                    <input type="text" id="total_area" name="total_area">
                </div>

                <div class="admin-form-group admin-col-3">
                    <label for="dormitorios">Dormitórios</label>
                    <input type="text" id="dormitorios" name="dormitorios">
                </div>

                <div class="admin-form-group admin-col-3">
                    <label for="banheiros">Banheiros</label>
                    <input type="text" id="banheiros" name="banheiros">
                </div>

                <div class="admin-form-group admin-col-3">
                    <label for="vagas">Vagas</label>
                    <input type="text" id="vagas" name="vagas">
                </div>

                <div class="admin-form-group admin-col-12">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="5"></textarea>
                </div>

                <div class="admin-form-group admin-col-4">
                    <label for="preco">Preço</label>
                    <input type="text" id="preco" name="preco">
                </div>

                <div class="admin-form-group admin-col-4">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade">
                </div>

                <div class="admin-form-group admin-col-4">
                    <label for="destaque">Imóvel destaque</label>
                    <select id="destaque" name="destaque">
                        <option value="nao">Não</option>
                        <option value="sim">Sim</option>
                    </select>
                </div>

                <div class="admin-inline-section admin-col-12">
                    <div class="admin-inline-section-title">
                        <span class="admin-page-badge">Galeria</span>
                        <h3>Imagens</h3>
                    </div>
                </div>

                <div class="admin-form-group admin-col-12">
                    <label for="imagem">Novas imagens</label>
                    <div class="admin-upload-inline">
                        <input type="file" id="imagem" name="imagem[]" accept="image/*" multiple class="admin-upload-input">
                        <button type="button" class="admin-search-btn admin-search-btn-secondary" id="btnAnexarImagens">
                            <i class="fas fa-upload"></i>
                            <span>Anexar imagens</span>
                        </button>
                    </div>
                </div>

                <div class="admin-form-group admin-col-12">
                    <?php if (!empty($imagensTemp)) { ?>
                        <div class="admin-image-grid admin-image-grid-compact" id="adminImageGrid">
                            <?php foreach ($imagensTemp as $imagem) { ?>
                                <div class="admin-image-card admin-image-card-compact" data-img="<?php echo htmlspecialchars($imagem['img']); ?>">
                                    <div class="admin-image-preview admin-image-preview-compact">
                                        <img src="upload/temp/<?php echo $imagem['img']; ?>" alt="Pré-visualização da imagem">
                                    </div>

                                    <div class="admin-image-info">
                                        <p class="admin-image-name"><?php echo $imagem['img']; ?></p>
                                        <span class="admin-status-badge <?php echo !empty($imagem['capa']) ? 'is-highlight' : 'is-normal'; ?>">
                                            <?php echo !empty($imagem['capa']) ? 'Capa atual' : 'Imagem comum'; ?>
                                        </span>
                                    </div>

                                    <div class="admin-image-actions">
                                        <button type="button" class="admin-table-btn delete js-open-delete-modal" data-img="<?php echo htmlspecialchars($imagem['img']); ?>">
                                            Excluir
                                        </button>

                                        <div class="admin-capa-wrap js-capa-form" data-img="<?php echo htmlspecialchars($imagem['img']); ?>">
                                            <label class="admin-capa-radio-label" for="capa_<?php echo md5($imagem['img']); ?>">
                                                <input type="radio" id="capa_<?php echo md5($imagem['img']); ?>" name="capa_radio_visual" class="admin-capa-radio" <?php echo !empty($imagem['capa']) ? 'checked' : ''; ?>>
                                                <span>Definir como capa</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="admin-table-empty" id="adminNoImagesMessage">Nenhuma imagem cadastrada para este imóvel.</div>
                        <div class="admin-image-grid admin-image-grid-compact" id="adminImageGrid" style="display:none;"></div>
                    <?php } ?>
                </div>

                <div class="admin-form-actions admin-form-actions-final admin-col-12">
                    <a href="casasCadastradas.php" class="admin-search-btn admin-search-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Voltar</span>
                    </a>

                    <button type="submit" class="admin-search-btn" name="salvar_tudo">
                        <i class="fas fa-save"></i>
                        <span>Salvar imóvel</span>
                    </button>
                </div>
            </form>
        </main>
    </div>

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
                <button type="button" class="admin-search-btn admin-search-btn-secondary" id="cancelDeleteModal">Cancelar</button>
                <button type="button" class="admin-search-btn delete" id="confirmDeleteModal">Excluir imagem</button>
            </div>
        </div>
    </div>

    <?php if ($flashSucesso) { ?>
        <div class="admin-modal-overlay active" id="successModal">
            <div class="admin-modal admin-modal-success">
                <div class="admin-modal-header">
                    <h3>Imóvel cadastrado</h3>
                </div>
                <div class="admin-modal-body">
                    <p><?php echo $flashSucesso; ?></p>
                </div>
                <div class="admin-modal-actions">
                    <a href="casasCadastradas.php" class="admin-search-btn">OK</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        function bindCapaEvents() {
            document.querySelectorAll('.js-capa-form').forEach((wrap) => {
                const radio = wrap.querySelector('.admin-capa-radio');
                if (!radio || radio.dataset.bound === '1') return;

                radio.dataset.bound = '1';

                radio.addEventListener('change', async function() {
                    const formData = new FormData();
                    formData.append('ajax_action', 'alterar_capa_temp');
                    formData.append('img_capa', wrap.dataset.img);

                    try {
                        const response = await fetch('cadastrarCasa.php', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();
                        if (!data.success) return;

                        document.querySelectorAll('.admin-capa-radio').forEach(r => r.checked = false);

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
                        });
                    } catch (e) {}
                });
            });
        }

        function bindDeleteEvents() {
            document.querySelectorAll('.js-open-delete-modal').forEach((button) => {
                if (button.dataset.bound === '1') return;
                button.dataset.bound = '1';

                button.addEventListener('click', function() {
                    openDeleteModal(this.dataset.img);
                });
            });
        }

        function createImageCard(imagem) {
            const isCapa = Number(imagem.capa) === 1;
            const safeId = `capa_${imagem.img.replace(/[^a-zA-Z0-9]/g, '_')}`;

            return `
                <div class="admin-image-card admin-image-card-compact" data-img="${imagem.img}">
                    <div class="admin-image-preview admin-image-preview-compact">
                        <img src="upload/temp/${imagem.img}" alt="Pré-visualização da imagem">
                    </div>

                    <div class="admin-image-info">
                        <p class="admin-image-name">${imagem.img}</p>
                        <span class="admin-status-badge ${isCapa ? 'is-highlight' : 'is-normal'}">
                            ${isCapa ? 'Capa atual' : 'Imagem comum'}
                        </span>
                    </div>

                    <div class="admin-image-actions">
                        <button type="button" class="admin-table-btn delete js-open-delete-modal" data-img="${imagem.img}">
                            Excluir
                        </button>

                        <div class="admin-capa-wrap js-capa-form" data-img="${imagem.img}">
                            <label class="admin-capa-radio-label" for="${safeId}">
                                <input type="radio" id="${safeId}" name="capa_radio_visual" class="admin-capa-radio" ${isCapa ? 'checked' : ''}>
                                <span>Definir como capa</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
        }

        const btnAnexarImagens = document.getElementById('btnAnexarImagens');
        const inputImagem = document.getElementById('imagem');

        btnAnexarImagens.addEventListener('click', async function() {
            if (!inputImagem.files || inputImagem.files.length === 0) return;

            btnAnexarImagens.disabled = true;

            const formData = new FormData();
            formData.append('ajax_action', 'anexar_imagens_temp');
            Array.from(inputImagem.files).forEach(file => formData.append('imagem[]', file));

            try {
                const response = await fetch('cadastrarCasa.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (!data.success) {
                    btnAnexarImagens.disabled = false;
                    return;
                }

                const noImagesMessage = document.getElementById('adminNoImagesMessage');
                const imageGrid = document.getElementById('adminImageGrid');

                if (noImagesMessage) noImagesMessage.remove();
                imageGrid.style.display = 'grid';

                data.imagens.forEach((imagem) => {
                    imageGrid.insertAdjacentHTML('beforeend', createImageCard(imagem));
                });

                inputImagem.value = '';

                if (data.imagens.some(img => Number(img.capa) === 1)) {
                    document.querySelectorAll('.admin-capa-radio').forEach(r => r.checked = false);

                    document.querySelectorAll('.admin-image-card').forEach((card) => {
                        const badge = card.querySelector('.admin-status-badge');
                        const currentRadio = card.querySelector('.admin-capa-radio');
                        const uploadedCapa = data.imagens.find(img => Number(img.capa) === 1);

                        if (uploadedCapa && card.dataset.img === uploadedCapa.img) {
                            badge.classList.remove('is-normal');
                            badge.classList.add('is-highlight');
                            badge.textContent = 'Capa atual';
                            currentRadio.checked = true;
                        }
                    });
                }

                bindCapaEvents();
                bindDeleteEvents();
            } catch (e) {} finally {
                btnAnexarImagens.disabled = false;
            }
        });

        const deleteModal = document.getElementById('deleteImageModal');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteModal = document.getElementById('cancelDeleteModal');
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');

        let selectedImgToDelete = null;

        function openDeleteModal(img) {
            selectedImgToDelete = img;
            deleteModal.classList.add('active');
        }

        function hideDeleteModal() {
            deleteModal.classList.remove('active');
            selectedImgToDelete = null;
        }

        closeDeleteModal.addEventListener('click', hideDeleteModal);
        cancelDeleteModal.addEventListener('click', hideDeleteModal);

        deleteModal.addEventListener('click', function(event) {
            if (event.target === deleteModal) hideDeleteModal();
        });

        confirmDeleteModal.addEventListener('click', async function() {
            if (!selectedImgToDelete) return;

            confirmDeleteModal.disabled = true;

            const formData = new FormData();
            formData.append('ajax_action', 'excluir_imagem_temp');
            formData.append('img', selectedImgToDelete);

            try {
                const response = await fetch('cadastrarCasa.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (!data.success) {
                    confirmDeleteModal.disabled = false;
                    return;
                }

                const card = document.querySelector(`.admin-image-card[data-img="${CSS.escape(selectedImgToDelete)}"]`);
                if (card) card.remove();

                if (data.nova_capa) {
                    document.querySelectorAll('.admin-capa-radio').forEach(r => r.checked = false);

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
                const noImagesMessage = document.getElementById('adminNoImagesMessage');
                const imageGrid = document.getElementById('adminImageGrid');

                if (remainingCards.length === 0 && !noImagesMessage) {
                    imageGrid.style.display = 'none';
                    imageGrid.insertAdjacentHTML('afterend', '<div class="admin-table-empty" id="adminNoImagesMessage">Nenhuma imagem cadastrada para este imóvel.</div>');
                }

                hideDeleteModal();
            } catch (e) {} finally {
                confirmDeleteModal.disabled = false;
            }
        });

        bindCapaEvents();
        bindDeleteEvents();
    </script>
</body>

</html>