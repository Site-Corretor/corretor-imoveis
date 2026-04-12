<?php
require_once 'clsPrincipal.php';
$u = new Principal;
$u->conectar();

$visualizar = $u->visualizar();

function parsePreco($valor)
{
    if ($valor === null) return 0;

    $valor = trim((string)$valor);
    $valor = str_replace(['R$', 'r$', ' '], '', $valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    $valor = preg_replace('/[^\d.]/', '', $valor);

    return is_numeric($valor) ? (float)$valor : 0;
}

function valorSelecionado($valorAtual, $valorEsperado)
{
    return $valorAtual === $valorEsperado ? 'selected' : '';
}

$tipo = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$cidade = isset($_GET['cidade']) ? trim($_GET['cidade']) : '';
$preco_min = isset($_GET['preco_min']) ? trim($_GET['preco_min']) : '';
$preco_max = isset($_GET['preco_max']) ? trim($_GET['preco_max']) : '';
$dormitorios = isset($_GET['dormitorios']) ? trim($_GET['dormitorios']) : '';
$banheiros = isset($_GET['banheiros']) ? trim($_GET['banheiros']) : '';
$vagas = isset($_GET['vagas']) ? trim($_GET['vagas']) : '';
$ordenar = isset($_GET['ordenar']) ? trim($_GET['ordenar']) : 'relevantes';

$cidadesDisponiveis = [];

if ($visualizar && count($visualizar) > 0) {
    foreach ($visualizar as $item) {
        if (!empty($item['cidade'])) {
            $cidadesDisponiveis[] = trim($item['cidade']);
        }
    }
}

$cidadesDisponiveis = array_unique($cidadesDisponiveis);
sort($cidadesDisponiveis);

$imoveisFiltrados = [];

if ($visualizar && count($visualizar) > 0) {
    foreach ($visualizar as $imovel) {
        if ((int)$imovel['ativo'] !== 1) {
            continue;
        }

        if ($tipo !== '' && isset($imovel['tipo_imovel']) && $imovel['tipo_imovel'] !== $tipo) {
            continue;
        }

        if ($cidade !== '' && isset($imovel['cidade']) && trim($imovel['cidade']) !== $cidade) {
            continue;
        }

        $precoNumerico = parsePreco($imovel['preco']);

        if ($preco_min !== '' && is_numeric($preco_min) && $precoNumerico < (float)$preco_min) {
            continue;
        }

        if ($preco_max !== '' && is_numeric($preco_max) && $precoNumerico > (float)$preco_max) {
            continue;
        }

        if ($dormitorios !== '' && isset($imovel['dormitorios']) && (int)$imovel['dormitorios'] < (int)$dormitorios) {
            continue;
        }

        if ($banheiros !== '' && isset($imovel['banheiros']) && (int)$imovel['banheiros'] < (int)$banheiros) {
            continue;
        }

        if ($vagas !== '' && isset($imovel['vagas']) && (int)$imovel['vagas'] < (int)$vagas) {
            continue;
        }

        $imovel['preco_numerico'] = $precoNumerico;
        $imoveisFiltrados[] = $imovel;
    }
}

if ($ordenar === 'menor_preco') {
    usort($imoveisFiltrados, function ($a, $b) {
        return $a['preco_numerico'] <=> $b['preco_numerico'];
    });
} elseif ($ordenar === 'maior_preco') {
    usort($imoveisFiltrados, function ($a, $b) {
        return $b['preco_numerico'] <=> $a['preco_numerico'];
    });
}

$tituloPagina = 'Todos os imóveis';
$descricaoPagina = 'Explore opções residenciais, comerciais, industriais e terrenos.';

if ($tipo === 'residencia') {
    $tituloPagina = 'Residências disponíveis';
    $descricaoPagina = 'Confira as opções residenciais atualmente disponíveis.';
} elseif ($tipo === 'comercio') {
    $tituloPagina = 'Comércios disponíveis';
    $descricaoPagina = 'Explore os imóveis comerciais disponíveis no momento.';
} elseif ($tipo === 'industria') {
    $tituloPagina = 'Indústrias disponíveis';
    $descricaoPagina = 'Veja as opções industriais disponíveis atualmente.';
} elseif ($tipo === 'terreno') {
    $tituloPagina = 'Terrenos disponíveis';
    $descricaoPagina = 'Veja os terrenos disponíveis no momento.';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="style.css?v=2" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"> -->
    <link rel="stylesheet" href="/css/all.min.css">
    <link rel="short cut icon" type="image/x-icon" href="imagens/logo-ricardo.ico">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricardo Souza - Corretor de Imóveis</title>
</head>

<body>
    <header>
        <div class="center">
            <div class="logo">
                <a href="index.php">
                    <img src="imagens/logo-ricardo.png" width="145" height="70" alt="Ricardo Souza Imóveis">
                </a>
            </div>

            <div class="menu">
                <a href="geral.php">Imóveis</a>
                <a href="sobre.php">Sobre Nós</a>
                <a href="contato.php">Contato</a>
                <a href="https://api.whatsapp.com/send?phone=5511970355935" target="_blank" class="menu-cta">WhatsApp</a>
            </div>
        </div>
    </header>

    <main class="catalogo-page">
        <div class="catalogo-layout">
            <aside class="filtros-sidebar">
                <form method="GET" class="filtros-card">
                    <div class="filtros-header">
                        <h2>Filtrar</h2>
                        <a class="limpar-filtros" href="geral.php">Limpar</a>
                    </div>

                    <div class="filtros-body">
                        <div class="campo-filtro">
                            <label for="tipo">Tipo de imóvel</label>
                            <select name="tipo" id="tipo">
                                <option value="">Todos</option>
                                <option value="residencia" <?php echo valorSelecionado($tipo, 'residencia'); ?>>Residencial</option>
                                <option value="comercio" <?php echo valorSelecionado($tipo, 'comercio'); ?>>Comercial</option>
                                <option value="industria" <?php echo valorSelecionado($tipo, 'industria'); ?>>Industrial</option>
                                <option value="terreno" <?php echo valorSelecionado($tipo, 'terreno'); ?>>Terreno</option>
                            </select>
                        </div>

                        <div class="campo-filtro">
                            <label for="cidade">Cidade</label>
                            <select name="cidade" id="cidade">
                                <option value="">Todas</option>
                                <?php foreach ($cidadesDisponiveis as $cidadeOpcao) { ?>
                                    <option value="<?php echo htmlspecialchars($cidadeOpcao); ?>" <?php echo valorSelecionado($cidade, $cidadeOpcao); ?>>
                                        <?php echo htmlspecialchars($cidadeOpcao); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="campo-filtro">
                            <label>Faixa de preço</label>
                            <div class="filtro-grid-2">
                                <input type="number" name="preco_min" placeholder="Mínimo" value="<?php echo htmlspecialchars($preco_min); ?>">
                                <input type="number" name="preco_max" placeholder="Máximo" value="<?php echo htmlspecialchars($preco_max); ?>">
                            </div>
                        </div>

                        <div class="campo-filtro">
                            <label>Dormitórios, banheiros e vagas</label>
                            <div class="filtro-grid-2">
                                <input type="number" name="dormitorios" placeholder="Dorm." value="<?php echo htmlspecialchars($dormitorios); ?>">
                                <input type="number" name="banheiros" placeholder="Banheiros" value="<?php echo htmlspecialchars($banheiros); ?>">
                            </div>
                            <input type="number" name="vagas" placeholder="Vagas" value="<?php echo htmlspecialchars($vagas); ?>">
                        </div>

                        <input type="hidden" name="ordenar" value="<?php echo htmlspecialchars($ordenar); ?>">

                        <div class="filtro-acoes">
                            <button type="submit" class="btn-filtro btn-filtro-primario">Aplicar</button>
                            <a href="geral.php" class="btn-filtro btn-filtro-secundario">Limpar</a>
                        </div>
                    </div>
                </form>
            </aside>

            <section class="catalogo-conteudo">
                <div class="catalogo-topbar">
                    <div>
                        <h1 class="catalogo-page-title"><?php echo $tituloPagina; ?></h1>
                        <p class="catalogo-page-subtitle"><?php echo $descricaoPagina; ?></p>
                    </div>

                    <div class="catalogo-topbar-direita">
                        <button type="button" class="mobile-filter-btn" onclick="abrirFiltros()">Filtrar</button>

                        <form method="GET">
                            <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
                            <input type="hidden" name="cidade" value="<?php echo htmlspecialchars($cidade); ?>">
                            <input type="hidden" name="preco_min" value="<?php echo htmlspecialchars($preco_min); ?>">
                            <input type="hidden" name="preco_max" value="<?php echo htmlspecialchars($preco_max); ?>">
                            <input type="hidden" name="dormitorios" value="<?php echo htmlspecialchars($dormitorios); ?>">
                            <input type="hidden" name="banheiros" value="<?php echo htmlspecialchars($banheiros); ?>">
                            <input type="hidden" name="vagas" value="<?php echo htmlspecialchars($vagas); ?>">

                            <select name="ordenar" class="ordenacao-select" onchange="this.form.submit()">
                                <option value="relevantes" <?php echo valorSelecionado($ordenar, 'relevantes'); ?>>Mais relevantes</option>
                                <option value="menor_preco" <?php echo valorSelecionado($ordenar, 'menor_preco'); ?>>Menor preço</option>
                                <option value="maior_preco" <?php echo valorSelecionado($ordenar, 'maior_preco'); ?>>Maior preço</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="catalogo-total">
                    <?php echo count($imoveisFiltrados); ?> imóveis encontrados
                </div>

                <div class="house-list portal-grid">
                    <?php if (count($imoveisFiltrados) > 0) { ?>
                        <?php foreach ($imoveisFiltrados as $imovel) { ?>
                            <?php $imagem = $u->imagem($imovel['codigo']); ?>
                            <div class="house portal-card" onclick="window.location='<?php echo 'imovel.php?codigo=' . $imovel['codigo']; ?>'" style="cursor: pointer;">
                                <?php
                                if ($imagem && !empty($imagem['img'])) {
                                    echo '<img src="https://ricardosouzaimoveis.com.br/admin/upload/' . $imagem['img'] . '" alt="Pré-visualização do imóvel">';
                                    //echo '<img src="admin/upload/' . $imagem['img'] . '" alt="Pré-visualização do imóvel">';
                                } else {
                                    echo '<img src="imagens/fotocapa.jpg" alt="Imagem padrão do imóvel">';
                                }
                                ?>

                                <div class="house-details">
                                    <div class="house-info-topo">
                                        <span class="house-tag"><?php echo !empty($imovel['tipo_imovel']) ? ucfirst($imovel['tipo_imovel']) : 'Disponível'; ?></span>
                                    </div>

                                    <h3 class="casa-descricao"><?php echo $imovel['titulo']; ?></h3>

                                    <p class="texto-descricao">
                                        <i class="fas fa-map-marker-alt favicon"></i>
                                        <?php echo $imovel['cidade']; ?>
                                    </p>

                                    <p class="portal-preco"><?php echo 'R$ ' . number_format((float)$imovel['preco'], 2, ',', '.'); ?></p>

                                    <div class="portal-meta">
                                        <?php if (!empty($imovel['dormitorios'])) { ?>
                                            <span><i class="fas fa-bed"></i> <?php echo $imovel['dormitorios']; ?></span>
                                        <?php } ?>
                                        <?php if (!empty($imovel['banheiros'])) { ?>
                                            <span><i class="fas fa-bath"></i> <?php echo $imovel['banheiros']; ?></span>
                                        <?php } ?>
                                        <?php if (!empty($imovel['vagas'])) { ?>
                                            <span><i class="fas fa-car"></i> <?php echo $imovel['vagas']; ?></span>
                                        <?php } ?>
                                        <?php if (!empty($imovel['total_area'])) { ?>
                                            <span><i class="fas fa-ruler-combined"></i> <?php echo $imovel['total_area']; ?> m²</span>
                                        <?php } ?>
                                    </div>

                                    <p class="portal-resumo">
                                        <?php
                                        $resumo = '';
                                        if (!empty($imovel['descricao1'])) {
                                            $resumo = $imovel['descricao1'];
                                        } elseif (!empty($imovel['descricao2'])) {
                                            $resumo = $imovel['descricao2'];
                                        } elseif (!empty($imovel['descricao3'])) {
                                            $resumo = $imovel['descricao3'];
                                        } else {
                                            $resumo = 'Clique para ver mais detalhes sobre este imóvel.';
                                        }
                                        echo $resumo;
                                        ?>
                                    </p>

                                    <a href="<?php echo 'imovel.php?codigo=' . $imovel['codigo']; ?>">
                                        <button class="house-button">+ Detalhes</button>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="error-image">
                            <!--
                            <img src="imagens/Icones/error.png" height="200" alt="Nenhum imóvel encontrado">
                            <h2 class="nome-lista">Nenhum imóvel encontrado com os filtros selecionados</h2>
                             -->
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>

    <div class="mobile-filtros-overlay" id="mobileFiltros">
        <div class="mobile-filtros-box">
            <form method="GET" class="filtros-card">
                <div class="filtros-header">
                    <h2>Filtrar</h2>
                    <a href="javascript:void(0)" class="limpar-filtros" onclick="fecharFiltros()">Fechar</a>
                </div>

                <div class="filtros-body">
                    <div class="campo-filtro">
                        <label for="tipo-mobile">Tipo de imóvel</label>
                        <select name="tipo" id="tipo-mobile">
                            <option value="">Todos</option>
                            <option value="residencia" <?php echo valorSelecionado($tipo, 'residencia'); ?>>Residencial</option>
                            <option value="comercio" <?php echo valorSelecionado($tipo, 'comercio'); ?>>Comercial</option>
                            <option value="industria" <?php echo valorSelecionado($tipo, 'industria'); ?>>Industrial</option>
                            <option value="terreno" <?php echo valorSelecionado($tipo, 'terreno'); ?>>Terreno</option>
                        </select>
                    </div>

                    <div class="campo-filtro">
                        <label for="cidade-mobile">Cidade</label>
                        <select name="cidade" id="cidade-mobile">
                            <option value="">Todas</option>
                            <?php foreach ($cidadesDisponiveis as $cidadeOpcao) { ?>
                                <option value="<?php echo htmlspecialchars($cidadeOpcao); ?>" <?php echo valorSelecionado($cidade, $cidadeOpcao); ?>>
                                    <?php echo htmlspecialchars($cidadeOpcao); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="campo-filtro">
                        <label>Faixa de preço</label>
                        <div class="filtro-grid-2">
                            <input type="number" name="preco_min" placeholder="Mínimo" value="<?php echo htmlspecialchars($preco_min); ?>">
                            <input type="number" name="preco_max" placeholder="Máximo" value="<?php echo htmlspecialchars($preco_max); ?>">
                        </div>
                    </div>

                    <div class="campo-filtro">
                        <label>Dormitórios, banheiros e vagas</label>
                        <div class="filtro-grid-2">
                            <input type="number" name="dormitorios" placeholder="Dorm." value="<?php echo htmlspecialchars($dormitorios); ?>">
                            <input type="number" name="banheiros" placeholder="Banheiros" value="<?php echo htmlspecialchars($banheiros); ?>">
                        </div>
                        <input type="number" name="vagas" placeholder="Vagas" value="<?php echo htmlspecialchars($vagas); ?>">
                    </div>

                    <input type="hidden" name="ordenar" value="<?php echo htmlspecialchars($ordenar); ?>">

                    <div class="filtro-acoes">
                        <button type="submit" class="btn-filtro btn-filtro-primario">Aplicar</button>
                        <a href="geral.php" class="btn-filtro btn-filtro-secundario">Limpar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer-site">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="imagens/logo-ricardo.png" width="180" alt="Ricardo Souza Imóveis">
                    <p>Av. Gov. Mário Covas Júnior, 2665
                        - Portão</p>
                    <p>Arujá - SP</p>
                </div>

                <div class="footer-col">
                    <h4>Empresa</h4>
                    <div class="footer-links">
                        <a href="sobre.php">Sobre Nós</a>
                        <a href="contato.php">Fale Conosco</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Imóveis</h4>
                    <div class="footer-links">
                        <a href="geral.php?tipo=residencia">Residencial</p>
                            <a href="geral.php?tipo=comercio">Comercial</p>
                                <a href="geral.php?tipo=industria">Industrial</p>
                                    <a href="geral.php?tipo=terreno">Terrenos</p>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Serviços</h4>
                    <div class="footer-links">
                        <p>Venda</p>
                        <p>Locação</p>
                        <p>Administração</p>
                        <p>Suporte</p>
                    </div>
                </div>


            </div>

            <div class="footer-bottom">
                <p>&copy; 2023. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        function abrirFiltros() {
            document.getElementById('mobileFiltros').classList.add('active');
        }

        function fecharFiltros() {
            document.getElementById('mobileFiltros').classList.remove('active');
        }
    </script>
</body>

</html>